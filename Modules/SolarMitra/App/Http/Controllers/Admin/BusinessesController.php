<?php

namespace Modules\SolarMitra\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Role;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class BusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = __('solarmitra::solarmitra.businesses');
        $businesses = Business::with('addresses','user')->paginate(config('Reading.nodes_per_page'));
        return view('solarmitra::admin.businesses.index',compact('businesses','page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = __('solarmitra::solarmitra.add') . " " . __('solarmitra::solarmitra.business');
        return view('solarmitra::admin.businesses.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if($request->isMethod('post'))
        {
            $validation = [
                'first_name'        => 'required',
                'email'             => 'required|email|unique:users',
                'password'          => 'required|confirmed',
                'password_confirmation'  => 'required',
                'company_name'      => 'required',
                'phone'             => 'required',

            ];

            $validationMsg = [
                'phone.required'    => __('solarmitra::solarmitra.phone_field_required'),
                'first_name.required' => __('solarmitra::solarmitra.first_name_required'),
                'email.required' => __('solarmitra::solarmitra.email_required'),
                'email.email' => __('solarmitra::solarmitra.email_invalid'),
                'email.unique' => __('solarmitra::solarmitra.email_unique'),
                'password.required' => __('solarmitra::solarmitra.password_required'),
                'password.confirmed' => __('solarmitra::solarmitra.password_confirmed'),
                'password_confirmation.required' => __('solarmitra::solarmitra.password_confirmation_required'),
                'company_name.required' => __('solarmitra::solarmitra.company_name_required'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $full_name = $request->input('first_name').' '.$request->input('last_name');

            $user = User::create([
                'name'          => $full_name,
                'first_name'    => $request->input('first_name'),
                'last_name'     => $request->input('last_name'),
                'email'         => $request->input('email'),
                'mobile'         => $request->input('phone'),
                'password'      => Hash::make($request->input('password')),
            ]);

            if ($user) {

                $role = Role::firstOrCreate(
                    ['name' => 'Business', 'guard_name' => 'business'],
                    ['role_type' => 'Business', 'level' => 0]
                );

                $user->roles()->sync([$role->id]);
            }
            $AttachmentObj = New Attachment();

            $BusinessObj = Business::create([
                'user_id'        => $user->id,
                'company_name'   => $request->company_name,
                'contact_person' => $request->contact_person,
                'phone'          => $request->phone,
                'gst_no'         => $request->gst_no,
                'pan_no'         => $request->pan_no,
                'about'          => $request->about,
            ]);

            $contactObj = new Contact;
            $contactObj->user_id            = $user->id;
            $contactObj->business_id        = $BusinessObj->id;
            $contactObj->name               = $full_name;
            $contactObj->first_name         = $request->input('first_name');
            $contactObj->last_name          = $request->input('last_name');
            $contactObj->company_name       = $request->company_name;
            $contactObj->phone_number       = $request->input('phone');
            $contactObj->email              = $request->input('email');
            $contactObj->type               = 1;
            $contactObj->aadhar_no          = $request->input('aadhar_no') ?? null;
            $contactObj->pan_no             = $request->input('pan_no') ?? null;
            $contactObj->gst_no             = $request->input('gst_no') ?? null;
            $contactObj->zip                = $request->input('zip') ?? null;
            $contactRes            = $contactObj->save();

            $AttachmentId = $AttachmentObj->InsertAttachments(
                $request,
                'logo',
                0,
                $BusinessObj->id
            );

            if ($request->hasFile('logo')) {
                $BusinessObj->update([
                    'logo' => $AttachmentId
                ]);
            }

            
            if ($request->city_id || $request->state_id || $request->country_id || $request->address) {
                $AddressObj = New Address;
                $AddressObj->business_id        = $BusinessObj->id;
                $AddressObj->contact_id         = 0;
                $AddressObj->project_id         = 0;
                $AddressObj->address_title      = $request->address_title;
                $AddressObj->address            = $request->address;
                $AddressObj->city_id            = $request->city_id;
                $AddressObj->state_id           = $request->state_id;
                $AddressObj->country_id         = $request->country_id;
                $AddressObj->save();
            }

            return redirect()->route('admin.solarmitra.businesses.index')->with('success', __('solarmitra::solarmitra.business_added_text'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page_title = __('solarmitra::solarmitra.edit') . " " . __('solarmitra::solarmitra.business');
        $business = Business::findorFail($id);
        return view('solarmitra::admin.businesses.edit',compact('page_title','business'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        if($request->isMethod('post'))
        {
            $business = Business::findorFail($id);

            $validation = [
                'first_name'        => 'required',
                'email'             => 'required|email|unique:users,email,'.$business->user_id,
                'password'          => 'nullable|confirmed',
                'password_confirmation'  => 'nullable',
                'company_name'      => 'required',
                'phone'             => 'required|string|digits:10|unique:users,mobile,' . $business->user_id,

            ];

            $validationMsg = [
                'phone.required'    => __('solarmitra::solarmitra.phone_field_required'),
                'first_name.required' => __('solarmitra::solarmitra.first_name_required'),

                'email.required' => __('solarmitra::solarmitra.email_required'),
                'email.email' => __('solarmitra::solarmitra.email_invalid'),
                'email.unique' => __('solarmitra::solarmitra.email_unique'),

                'password.required' => __('solarmitra::solarmitra.password_required'),
                'password.confirmed' => __('solarmitra::solarmitra.password_confirmed'),

                'password_confirmation.required' => __('solarmitra::solarmitra.password_confirmation_required'),

                'company_name.required' => __('solarmitra::solarmitra.company_name_required'),

            ];

            $this->validate($request, $validation, $validationMsg);

            $full_name = $request->input('first_name').' '.$request->input('last_name');
            
            $userObj = User::firstOrNew(['id' =>  $business->user_id]);
             
            $userObj->name          = $full_name;
            $userObj->first_name    = $request->input('first_name');
            $userObj->last_name     = $request->input('last_name');
            $userObj->email         = $request->input('email');
            $userObj->mobile         = $request->input('phone');
            if ($request->filled('password')) {
                $userObj->password      = Hash::make($request->input('password'));
            }
            $res                    = $userObj->save();

            if ($res) {
                $role = Role::firstOrCreate(
                    ['name' => 'Business', 'guard_name' => 'business'],
                    ['role_type' => 'Business', 'level' => 0]
                );

                $userObj->roles()->sync([$role->id]);
            }

            $AttachmentObj = New Attachment();

            $BusinessObj = Business::findorFail($id);
            $BusinessObj->user_id           = $userObj->id;
            $BusinessObj->company_name      = $request->company_name;
            $BusinessObj->contact_person    = $request->contact_person;
            $BusinessObj->phone             = $request->phone;
            $BusinessObj->gst_no            = $request->gst_no;
            $BusinessObj->pan_no            = $request->pan_no;
            $BusinessObj->about             = $request->about;
            

            $AttachmentId = $AttachmentObj->InsertAttachments(
                $request,
                'logo',
                0,
                $BusinessObj->id
            );

            if ($request->hasFile('logo')) {
                $BusinessObj->logo              = $AttachmentId;
            }
            $business                       = $BusinessObj->save();
            return redirect()->route('admin.solarmitra.businesses.index')->with('success', __('solarmitra::solarmitra.business_added_text'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $business = Business::findorFail($id);
        if($business->delete()) 
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.business_delete_success'));
        } else {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
        }
    }
}
