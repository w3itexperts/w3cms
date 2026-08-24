<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\Business;
use App\Models\Role;
use Modules\SolarMitra\Lib\SmsService;
use App\Helper\HelpDesk;
use Carbon\Carbon;

class AuthController extends Controller
{

    private function generateOtp(User $user, string $channel)
    {
        $otp = rand(100000, 999999);

        $user->otp = Hash::make($otp);
        $user->otp_expires_at = now()->addMinutes(2);
        $user->otp_type = $channel;
        $user->save();

        return $otp;
    }


    // LOGIN WITH EMAIL
    public function login_with_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $business_uuid = (optional($user->businesses)->isNotEmpty()) ? $user->businesses->first()->business_uuid : (optional(optional($user->contact)->business)->business_uuid ? $user->contact->business->business_uuid : '');

        if ($request->business_uuid) {
            if (!empty($request->business_uuid) && $business_uuid === $request->business_uuid) {
            }else{
                return response()->json([
                    'message' => __('solarmitra::solarmitra.invalid_business_user')
                ], 422);
            }
        }

        // Resend cooldown
        if ($user->otp_expires_at && now()->lt($user->otp_expires_at->subSeconds(30))) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.please_wait_before_requesting_another_otp'),
                'resend_in' => now()->diffInSeconds($user->otp_expires_at->subSeconds(30)),
            ], 429);
        }

        // Generate new OTP
        $otp = $this->generateOtp($user, 'email');

        // Send OTP via email
        Mail::raw("Your login OTP is: {$otp}", function ($mail) use ($user) {
            $mail->to($user->email)->subject('Login OTP');
        });

        return response()->json([
            'message' => __('solarmitra::solarmitra.otp_sent_to_email'),
            'user_id' => $user->id,
        ]);
    }

    // LOGIN WITH PASSWORD
    public function login_with_password(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'login' => 'required' . (is_numeric($request->login) ? '|digits_between:10,15|exists:users,mobile' : '|email|exists:users,email'),
            'password' => 'required|string|min:6',
            'business_uuid' => 'nullable|string',
        ], [
            'login.required' => __('solarmitra::solarmitra.email_or_mobile_is_required'),
            'login.email' => __('solarmitra::solarmitra.please_enter_a_valid_email_address'),
            'login.digits' => __('solarmitra::solarmitra.please_enter_a_valid_mobile_number'),
            'login.digits_between' => __('solarmitra::solarmitra.please_enter_a_valid_mobile_number'),
            'login.numeric' => __('solarmitra::solarmitra.please_enter_a_valid_mobile_number'),
            'login.exists' => __('solarmitra::solarmitra.the_email_or_mobile_does_not_exist'),

            'password.required' => __('solarmitra::solarmitra.password_is_required'),
        ]);

        $login = trim($request->login);

        // 2. Detect login type (email or mobile)
        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'mobile';

        // 3. Get user with required relations (avoid N+1 issues)
        $user = User::with(['roles', 'businesses', 'contact.business'])
            ->where($field, $login)
            ->first();
        $user->load('contact');
        
        // 4. Generic invalid credentials response (security best practice)
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_credentials')
            ], 401);
        }

        // 5. Must be Business role
        if (!$user->roles->contains('role_type', 'Business')) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        }

        // 6. Resolve business_id & business_uuid
        $business = $user->businesses->first();

        if ($business) {
            $business_id   = $business->id;
            $business_uuid = $business->business_uuid;
        } elseif ($user->contact?->business_id) {
            $business_id = $user->contact->business_id;
            $business_uuid = optional($user->contact->business)->business_uuid;
        } else {
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        }

        // 7. Validate business_uuid if provided
        if ($request->filled('business_uuid') && $request->business_uuid !== $business_uuid) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        }

        // 8. Attach business_id to user object (not DB update)
        $user->business_id = $business_id;

        // 9. Generate token (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.login_successful'),
            'token'   => $token,
            'user'    => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    // LOGIN WITH MOBILE
    public function login_with_mobile(Request $request, SmsService $smsService)
    {
        $request->validate([
            'mobile' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                'exists:users,mobile',
            ],
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        $business_uuid = (optional($user->businesses)->isNotEmpty()) ? $user->businesses->first()->business_uuid : (optional(optional($user->contact)->business)->business_uuid ? $user->contact->business->business_uuid : '');

        if ($request->business_uuid) {
            if (!empty($request->business_uuid) && $business_uuid === $request->business_uuid) {
            }else{
                return response()->json([
                    'message' => __('solarmitra::solarmitra.invalid_business_user')
                ], 422);
            }
        }

        // Resend cooldown
        if ($user->otp_expires_at && now()->lt($user->otp_expires_at->subSeconds(30))) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.please_wait_before_requesting_another_otp'),
                'resend_in' => now()->diffInSeconds($user->otp_expires_at->subSeconds(30)),
            ], 429);
        }

        $otp = $this->generateOtp($user, 'mobile');

        $sent = $smsService->send(
                $user->mobile,
                "Your OTP is {$otp} regards BroSis Technlogies."
            );

        return response()->json([
            'message' => __('solarmitra::solarmitra.otp_sent_to_mobile'),
            'user_id' => $user->id,
        ]);
    }

    // VERIFY OTP (COMMON)
    public function verify_otp(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|digits:6',
        ]);

        $user = User::find($request->user_id);
        $user->load('contact');

        if (
            ! $user->otp ||
            ! Hash::check($request->otp, $user->otp) ||
            now()->gt($user->otp_expires_at)
        ) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_or_expired_otp')
            ], 422);
        }

        // Mark correct verification channel
        $updateData = [
            'otp' => null,
            'otp_expires_at' => null,
        ];

        if ($user->otp_type === 'email') {
            $updateData['email_verified_at'] = now();
            $updateData['is_email_verified'] = 1;
        }
        
        if ($user->otp_type === 'mobile') {
            $updateData['mobile_verified_at'] = now();
            $updateData['is_mobile_verified'] = 1;
        }

        $user->update($updateData);

        $token = $user->createToken('mobile')->plainTextToken;
        
        if ($user->roles->where('role_type', 'Business')->isEmpty()) 
        {    
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        } 

        if ($user->businesses && $user->businesses->isNotEmpty() && $user->businesses->first()->id) {
            $user->business_id = $user->businesses->first()->id;   /* for business owner */
        }elseif($user->contact && $user->contact->business_id){
            $user->business_id = $user->contact->business_id; /* for business staff */
        }else{
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        }

        return response()->json([
            'message' => __('solarmitra::solarmitra.authenticated_successfully'),
            'token' => $token,
            'user' => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    // Get Profile
    public function profile(Request $request)
    {
        $user = $request->user();
        $user->load('contact');

        if ($user->businesses && $user->businesses->isNotEmpty() && $user->businesses->first()->id) {
            $user->business_id = $user->businesses->first()->id;   /* for business owner */
        }elseif($user->contact && $user->contact->business_id){
            $user->business_id = $user->contact->business_id; /* for business staff */
        }else{
            return response()->json([
                'message' => __('solarmitra::solarmitra.invalid_business_user')
            ], 422);
        }

        if (!$user) {
            return response()->json([
                'message' => __('solarmitra::solarmitra.unauthenticated')
            ], 401);
        }
        if ($user->profile) {
            $user->profile_url = HelpDesk::user_img($user->profile);
        }
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => __('solarmitra::solarmitra.logged_out_successfully')
        ]);
    }

}
