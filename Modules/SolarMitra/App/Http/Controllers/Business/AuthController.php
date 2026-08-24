<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Modules\SolarMitra\Lib\SmsService;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Notification;
use Illuminate\Validation\Rules\Password;
use Storage;

class AuthController extends Controller
{

    protected int $otpValidity    = 2;   // minutes OTP is valid
    protected int $resendCooldown = 60;  // seconds before resend allowed

    public function store(Request $request)
    {
        $user = auth('business')->user();
        app(EnableTwoFactorAuthentication::class)($user);
        return back()->with('status', __('solarmitra::solarmitra.2fa_enabled'));
    }

    public function destroy(Request $request)
    {
        $user = auth('business')->user();
        app(DisableTwoFactorAuthentication::class)($user);
        return back()->with('status', __('solarmitra::solarmitra.2fa_disabled'));
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $user = auth('business')->user();
        app(GenerateNewRecoveryCodes::class)($user);
        return back()->with('status', __('solarmitra::solarmitra.recovery_codes_regenerated'));
    }

    /**
     * Register a business User.
     */
    public function register(Request $request)
    {
        
        if($request->isMethod('post'))
        {

            $validation = [
                'full_name'         => 'required|string|max:255',
                'email'             => 'required|email|unique:users',
                'phone'             => 'required|string|digits:10|unique:users,mobile',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'company_name'      => 'required',
            ];

            $validationMsg = [
                'full_name.required' => __('solarmitra::solarmitra.full_name_required'),
                'full_name.string' => __('solarmitra::solarmitra.full_name_string'),
                'full_name.max' => __('solarmitra::solarmitra.full_name_max'),

                'email.required' => __('solarmitra::solarmitra.email_required'),
                'email.email' => __('solarmitra::solarmitra.email_invalid'),
                'email.unique' => __('solarmitra::solarmitra.email_unique'),

                'password.required' => __('solarmitra::solarmitra.password_required'),
                'password.confirmed' => __('solarmitra::solarmitra.password_confirmed'),

                'password_confirmation.required' => __('solarmitra::solarmitra.password_confirmation_required'),

                'company_name.required' => __('solarmitra::solarmitra.company_name_required'),

                'phone.required' => __('solarmitra::solarmitra.phone_required'),
                'phone.digits' => __('solarmitra::solarmitra.phone_digits'),
                'phone.unique' => __('solarmitra::solarmitra.phone_unique'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $full_name = explode(' ', $request->input('full_name'),2);
            $first_name = $full_name[0];
            $last_name = $full_name[1] ?? '';
            

            $user = new User;
            $user->name          = $request->input('full_name');
            $user->first_name    = $first_name;
            $user->last_name     = $last_name;
            $user->email         = $request->input('email');
            $user->mobile        = $request->input('phone');
            $user->password      = Hash::make($request->input('password'));
            $user->save();

            if ($user) {
                $role = Role::firstOrCreate(
                    ['name' => 'Business', 'guard_name' => 'business'],
                    ['role_type' => 'Business', 'level' => 0]
                );

                $user->roles()->sync([$role->id]);
            }
            
            $request->merge(['login' => $request->input('email')]);
                
            $BusinessObj = New Business;
            $BusinessObj->user_id           = $user->id;
            $BusinessObj->company_name      = $request->company_name;
            $BusinessObj->phone             = $request->phone;
            $business                       = $BusinessObj->save();

            $contactObj = New Contact;
            $contactObj->user_id            = $user->id;
            $contactObj->business_id        = $BusinessObj->id;
            $contactObj->name               = $request->input('full_name');
            $contactObj->first_name         = $first_name;
            $contactObj->last_name          = $last_name;
            $contactObj->company_name       = $request->company_name;
            $contactObj->phone_number       = $request->input('phone');
            $contactObj->email              = $request->input('email');
            $contactObj->type               = 1;
            $contactObj->aadhar_no          = $request->input('aadhar_no') ?? null;
            $contactObj->pan_no             = $request->input('pan_no') ?? null;
            $contactObj->gst_no             = $request->input('gst_no') ?? null;
            $contactObj->zip                = $request->input('zip') ?? null;
            $contactRes            = $contactObj->save(); 
            
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BUSINESS-RB', $BusinessObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return $this->login($request);
        }
        return view('solarmitra::business.auth.register');
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {

            $validation = [
                'login' => 'required' . (is_numeric($request->login) ? '|digits_between:10,15|exists:users,mobile' : '|email|exists:users,email'),
                'password'             => 'required',
            ];
            $messages = [
                'login.required' => __('solarmitra::solarmitra.login_required'),
                'login.email' => __('solarmitra::solarmitra.login_email_invalid'),
                'login.digits' => __('solarmitra::solarmitra.login_mobile_invalid'),
                'login.digits_between' => __('solarmitra::solarmitra.login_mobile_invalid'),
                'login.numeric' => __('solarmitra::solarmitra.login_mobile_invalid'),

                'password.required' => __('solarmitra::solarmitra.password_required'),
            ];

            $this->validate($request, $validation,$messages);
            $remember = $request->has('remember');
            $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';


            if (\Auth::guard('business')->attempt([$field => $request->login,'password' => $request->password], $remember)) {
                
                $user = \Auth::guard('business')->user()->load('contact','businesses');

                /* check if user has role type Business */
                if ($user->roles->where('role_type', 'Business')->isNotEmpty()) 
                {    
                    return redirect()->intended('/business/dashboard');
                } 
                else 
                {    
                    \Auth::guard('business')->logout(); // optional: logout
                    return back()->withErrors([
                        'login' => 'You are not authorized as a business user.',
                    ]);
                }
            }

            return back()->withErrors(['login' => __('solarmitra::solarmitra.login_credentials_not_match')]);
        }

        return view('solarmitra::business.auth.login');

    }

    public function logout(Request $request)
    {
        \Auth::guard('business')->logout(); 

        return redirect()->route('business.solarmitra.auth.login');


    }

    public function profile(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.profile');
        $user_id    = Auth::guard('business')->id();
        $sessionArr = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                        ->where('user_id', $user_id)
                        ->orderBy('last_activity', 'desc')
                        ->get();

        $sessions = collect( $sessionArr )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        $user = User::findorFail(Auth::guard('business')->id());
        $roles = Role::get();
        $userRoles = User::get_roles(Auth::guard('business')->id());
        return view('solarmitra::business.auth.profile', compact('user', 'roles', 'userRoles', 'sessions', 'page_title'));
    }

    /**
     * Update Password the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $user_id='')
    {
        $this->validate($request, [
                'password'          => ['required', 
                                    Password::min(8),
                                    'same:confirm_password'],
                'confirm_password'  => 'required',
            ],
        );

        $user = User::findorFail($user_id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if($user->save()) 
        {
            /* Send Event Notification */
            // $notificationObj        = new Notification();
            // $notificationObj->notification_entry('ADMIN-UUPASS', $user_id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('business.solarmitra.users.profile')->with('success', __('solarmitra::solarmitra.password_update_success'));
        } else {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
        }

    }
    public function update_user(Request $request, $id)
    {

        $this->validate($request, [
                'first_name'    => 'required',
                'last_name'     => 'nullable',
                'email'         => 'required|email|unique:users,email,'.$id,
                'mobile'         => 'required|unique:users,mobile,'.$id,
                'user_img'      => 'mimes:jpg,png,jpeg,gif,webp',
            ],
        );

        $user = User::findorFail($id);

        $fileName = $this->__imageSave($request, 'user_img', 'user-images', $user->profile);
        $full_name = $request->input('first_name').' '.$request->input('last_name');

        $user->name       = $full_name;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');

        if(!empty($fileName)) 
        {
            $user->profile = $fileName;
        }

        if($user->save()) 
        {

            /* Send Event Notification */
            // $notificationObj        = new Notification();
            // $notificationObj->notification_entry('ADMIN-UP', $user->id, Auth::id(), config('constants.superadmin'));
            /* End Send Event Notification */

            return redirect()->route('business.solarmitra.users.profile')->with('success', __('solarmitra::solarmitra.user_update_success'));
        } else {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
        }

    }

    private function __imageSave($request, $key='', $folder_name='', $old_img='')
    {
        $fileName = "";
        if($request->hasFile($key) && !empty($key) && !empty($folder_name)) { 
            $image = $request->file($key);
            $OriginalName = $image->getClientOriginalName();
            $fileName = time().'.'.$OriginalName;
            $request->file($key)->storeAs('public/'.$folder_name.'/', $fileName);
            if(!empty($old_img)) {
                if (Storage::exists('public/'.$folder_name.'/', $old_img)) {
                    Storage::delete('public/'.$folder_name.'/'.$old_img);
                }
            }
        }

        return $fileName;
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function verification(Request $request)
    {
        $user = User::findorFail(Auth::guard('business')->id());

        if ($user->is_email_verified && $user->is_mobile_verified) {
            return redirect()->back()->with('warning', __('solarmitra::solarmitra.you_are_already_verified'));
        }

        return view('solarmitra::business.auth.verification', compact('user'));
    }

    public function verify_mobile(Request $request,SmsService $smsService)
    {
        $user = User::findOrFail(Auth::guard('business')->id());

        if ($user->is_mobile_verified) {
            return redirect()->back()->with('warning', __('solarmitra::solarmitra.mobile_number_already_verified'));
        }
        if (!$user->mobile) {
            return redirect()->back()->with('warning', __('solarmitra::solarmitra.mobile_number_not_found'));
        }

        $otp = $this->generateOtp($user, 'mobile');

        $sent = $smsService->send(
                $user->mobile,
                // "Your OTP is: {$otp}. Valid for {$this->otpValidity} minutes. Do not share with anyone."
                "Your OTP is {$otp} regards BroSis Technlogies."
            );

        if (!$sent) {
            return back()->with('error', __('solarmitra::solarmitra.failed_to_send_otp'));
        }

        return view('solarmitra::business.auth.verify-mobile', compact('user'));
    }

    
    // -----------------------------------------------------------------------
    // Show verify email page & send OTP
    // -----------------------------------------------------------------------
    public function verify_email(Request $request)
    {
        $user = User::findOrFail(Auth::guard('business')->id());

        if ($user->is_email_verified) {
            return redirect()->route('business.solarmitra.dashboard')
                             ->with('info', __('solarmitra::solarmitra.email_already_verified'));
        }

        $otp = $this->generateOtp($user, 'email');

        try {
            Mail::raw(
                "Your email verification OTP is: {$otp}. It expires in {$this->otpValidity} minutes.",
                function ($mail) use ($user) {
                    $mail->to($user->email)
                         ->subject('Email OTP Verification')
                         ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );
        } catch (\Throwable $e) {
            \Log::error('Failed to send email verification OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                             ->with('error', __('solarmitra::solarmitra.failed_to_send_otp'));
        }

        return view('solarmitra::business.auth.verify-email', compact('user'));
    }

    public function update_contact_form(Request $request)
    {
        $user = User::findOrFail(Auth::guard('business')->id());
        $type = $request->get('type', 'email');

        return view('solarmitra::business.auth.update-contact', compact('user', 'type'));
    }

    public function update_contact(Request $request)
    {
        $request->validate([
            'type'  => 'required|in:email,mobile',
            'value' => 'required',
        ]);

        $user = User::findOrFail(Auth::guard('business')->id());

        if ($request->type === 'email') {
            $request->validate([
                'value' => 'required|email|max:255',
            ]);

            if (User::where('email', $request->value)->where('id', '!=', $user->id)->exists()) {
                return back()->with('error', __('solarmitra::solarmitra.email_already_in_use'));
            }

            $user->email = $request->value;
            $user->is_email_verified = 0;
            $user->save();

            return redirect()->route('business.solarmitra.auth.verify_email')
                             ->with('success', __('solarmitra::solarmitra.email_updated_verify'));

        } else {
            $request->validate([
                'value' => 'required|digits:10',
            ]);

            if (User::where('mobile', $request->value)->where('id', '!=', $user->id)->exists()) {
                return back()->with('error', __('solarmitra::solarmitra.mobile_already_in_use'));
            }

            $user->mobile = $request->value;
            $user->is_mobile_verified = 0;
            $user->save();

            return redirect()->route('business.solarmitra.auth.verify_mobile')
                             ->with('success', __('solarmitra::solarmitra.mobile_updated_verify'));
        }
    }

    // -----------------------------------------------------------------------
    // Verify OTP submitted by user
    // -----------------------------------------------------------------------
    public function verify_user(Request $request)
    {
        $request->validate([
            'otp'      => 'required|digits:6',
            'otp_type' => 'required|in:email,mobile',
        ]);

        $user = User::findOrFail(Auth::guard('business')->id());

        // --- Rate limit: max 5 attempts per minute per user ---
        $rateLimitKey = 'otp-verify:' . $user->id;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Too many attempts. Please try again in {$seconds} seconds.",
            ], 429);
        }

        // --- Check otp_type matches what was sent ---
        if ($user->otp_type !== $request->otp_type) {
            return response()->json([
                'success' => false,
                'message' => 'OTP type mismatch. Please request a new OTP.',
            ], 422);
        }

        // --- Check OTP expiry ---
        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 422);
        }

        // --- Verify hashed OTP ---
        if (!Hash::check($request->otp, $user->otp)) {
            RateLimiter::hit($rateLimitKey, 60); // increment attempt
            $attemptsLeft = 5 - RateLimiter::attempts($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Invalid OTP. {$attemptsLeft} attempt(s) remaining.",
            ], 422);
        }

        // --- OTP is valid, clear rate limiter ---
        RateLimiter::clear($rateLimitKey);

        // --- Mark verified based on type ---
        if ($request->otp_type === 'email') {
                $user->is_email_verified = 1;
                $user->email_verified_at = now();
                $user->otp               = null;
                $user->otp_expires_at    = null;
                $user->otp_type          = null;
                $user->save();
            

            return response()->json([
                'success'  => true,
                'message'  => 'Email verified successfully!',
                'type'     => 'email',
                'redirect' => route('business.solarmitra.dashboard'), // change to your route
            ]);
        }

        if ($request->otp_type === 'mobile') {
            
                $user->is_mobile_verified = 1;
                $user->mobile_verified_at = now();
                $user->otp                = null;
                $user->otp_expires_at     = null;
                $user->otp_type           = null;
                $user->save();

            return response()->json([
                'success'  => true,
                'message'  => 'Mobile number verified successfully!',
                'type'     => 'mobile',
                'redirect' => route('business.solarmitra.dashboard'), // change to your route
            ]);
        }
    }

    // -----------------------------------------------------------------------
    // Resend OTP
    // -----------------------------------------------------------------------
    public function resend_otp(Request $request,SmsService $smsService)
    {
        $request->validate([
            'otp_type' => 'required|in:email,mobile',
        ]);

        $user = User::findOrFail(Auth::guard('business')->id());

        // --- Rate limit: max 3 resends per 10 minutes per user ---
        $rateLimitKey = 'otp-resend:' . $user->id;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            $minutes = ceil($seconds / 60);
            return response()->json([
                'success' => false,
                'message' => "Too many resend attempts. Please try again in {$minutes} minute(s).",
            ], 429);
        }

        // --- Cooldown: prevent resend within 60 seconds ---
        if ($user->otp_expires_at) {
            $sentAt      = $user->otp_expires_at->subMinutes($this->otpValidity);
            $nextAllowed = $sentAt->addSeconds($this->resendCooldown);

            if (now()->lt($nextAllowed)) {
                $wait = now()->diffInSeconds($nextAllowed);
                return response()->json([
                    'success' => false,
                    'message' => "Please wait {$wait} second(s) before requesting a new OTP.",
                ], 429);
            }
        }

        // --- Generate and send new OTP ---
        $otp = $this->generateOtp($user, $request->otp_type);

        RateLimiter::hit($rateLimitKey, 600); // 10 minute decay

        if ($request->otp_type === 'email') {
            Mail::raw("Your email verification OTP is: {$otp}. It expires in {$this->otpValidity} minutes.", function ($mail) use ($user) {
                $mail->to($user->email)->subject('Email OTP Verification');
            });
        } else if ($request->otp_type === 'mobile') {
            $sent = $smsService->send(
                $user->mobile,
                // "Your OTP is: {$otp}. Valid for {$this->otpValidity} minutes. Do not share with anyone."
                "Your OTP is {$otp} regards BroSis Technlogies."
            );

            if (!$sent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.',
                ], 500);
            }
        }else {
            // SMS::send($user->mobile, "Your OTP is: {$otp}");
        }

        return response()->json([
            'success'    => true,
            'message'    => $request->otp_type === 'email'
                                ? 'OTP resent to your email address.'
                                : 'OTP resent to your mobile number.',
            'expires_in' => $this->otpValidity * 60, // in seconds for JS timer
        ]);
    }

    // -----------------------------------------------------------------------
    // Private: generate, hash and save OTP
    // -----------------------------------------------------------------------
    private function generateOtp(User $user, string $channel): int
    {
        $otp = random_int(100000, 999999);

        $user->otp            = Hash::make($otp);  // always hashed
        $user->otp_expires_at = now()->addMinutes($this->otpValidity);
        $user->otp_type       = $channel;
        $user->save();

        return $otp; // return plain OTP to send via mail/SMS
    }

    /**
     * Check if user exists by email or mobile (AJAX)
     */
    public function check_user_exists(Request $request)
    {
        $request->validate([
            'login' => 'required',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $user = User::where($field, $login)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this ' . ($field === 'email' ? 'email' : 'mobile number') . '.',
            ]);
        }

        // Check if user has business role
        if (!$user->roles->where('role_type', 'Business')->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized as a business user.',
            ]);
        }

        return response()->json([
            'success' => true,
            'otp_type' => $field === 'email' ? 'email' : 'mobile',
            'masked_value' => $field === 'email'
                ? substr($login, 0, 2) . str_repeat('*', strlen($login) - 5) . substr($login, -3)
                : substr($login, 0, 2) . str_repeat('*', 6) . substr($login, -2),
        ]);
    }

    /**
     * Send OTP for login
     */
    public function send_login_otp(Request $request, SmsService $smsService)
    {
        $request->validate(['login' => 'required']);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $user = User::where($field, $login)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $rateLimitKey = 'login-otp:' . $user->id;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json(['success' => false, 'message' => "Too many OTP requests. Try again in {$seconds} seconds."], 429);
        }

        // Generate OTP first, then send
        $otp = $this->generateOtp($user, $field);

        // Try to send, but don't fail if SMS service throws
        try {
            if ($field === 'mobile') {
                $smsService->send($user->mobile, "Your OTP is {$otp} regards BroSis Technlogies");
            } else {
                Mail::raw("Your login OTP is: {$otp}. Valid for {$this->otpValidity} minutes.", function ($mail) use ($user) {
                    $mail->to($user->email)->subject('Login OTP');
                });
            }
        } catch (\Exception $e) {
            // OTP is already saved in DB, just log the error
            \Log::error('Login OTP send failed: ' . $e->getMessage());
        }

        RateLimiter::hit($rateLimitKey, 600);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your ' . ($field === 'email' ? 'email' : 'mobile') . '.',
            'expires_in' => $this->otpValidity * 60,
        ]);
    }

    /**
     * Verify OTP and login directly
     */
    public function login_with_otp(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'otp'   => 'required|digits:6',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $user = User::where($field, $login)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $rateLimitKey = 'login-otp-verify:' . $user->id;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json(['success' => false, 'message' => "Too many attempts. Try again in {$seconds} seconds."], 429);
        }

        if (empty($user->otp)) {
            return response()->json(['success' => false, 'message' => 'Please request a new OTP.']);
        }

        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.']);
        }

        if (!Hash::check($request->otp, $user->otp)) {
            RateLimiter::hit($rateLimitKey, 60);
            $attemptsLeft = 5 - RateLimiter::attempts($rateLimitKey);
            return response()->json(['success' => false, 'message' => "Invalid OTP. {$attemptsLeft} attempt(s) remaining."]);
        }

        RateLimiter::clear($rateLimitKey);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->otp_type = null;
        $user->save();

        if (!$user->roles->where('role_type', 'Business')->isNotEmpty()) {
            return response()->json(['success' => false, 'message' => 'You are not authorized as a business user.']);
        }

        \Auth::guard('business')->login($user);

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful!',
            'redirect' => route('business.solarmitra.dashboard'),
        ]);
    }
}
