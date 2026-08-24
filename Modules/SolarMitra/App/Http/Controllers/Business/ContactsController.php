<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\Client;
use Modules\SolarMitra\App\Models\Staff;
use Modules\SolarMitra\App\Models\Supplier;
use Modules\SolarMitra\App\Models\Investor;
use Modules\SolarMitra\App\Models\Contractor;
use Modules\SolarMitra\App\Models\Partner;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use App\Models\User;
use App\Models\Role;
use Modules\SolarMitra\App\Models\Address;
use Illuminate\Validation\Rule;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\BusinessRole;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Str;

class ContactsController extends Controller
{
    
    private function getContacts($request,$type=null)
    {
        $type = Str::singular($type ?? '');
        $resQuery = Contact::query()->with('client','supplier','investor','contractor','partner','staff')->where('business_id',app('currentBusinessId'))
                    ->when(!empty($type), function ($query) use ($type) {
                        $query->whereHas($type);
                    })
                    ->when($request->filled('name'), function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->name . '%');
                    })
                    ->when($request->filled('email'), function ($query) use ($request) {
                        $query->where('email', 'like', '%' . $request->email . '%');
                    })
                    ->when($request->filled('phone_number'), function ($query) use ($request) {
                        $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
                    })
                    ->when(!empty($request->type) && is_array($request->type), function ($query) use ($request) {
                        $query->where(function ($q) use ($request) {
                            foreach ($request->type as $type) {
                                if ($type) {
                                    $q->orWhereHas(Str::singular($type ?? ''));
                                }
                            }
                        });
                    });

        $sortMap = [
            'name_asc'      => ['name', 'asc'],
            'name_desc'     => ['name', 'desc'],
            'created_asc'   => ['created_at', 'asc'],
            'created_desc'  => ['created_at', 'desc'],
            'modified_asc'  => ['updated_at', 'asc'],
            'modified_desc' => ['updated_at', 'desc'],
        ];

        if ($request->filled('sort_by') && isset($sortMap[$request->sort_by])) {
            [$column, $direction] = $sortMap[$request->sort_by];
            $resQuery->orderBy($column, $direction);
        }

        return $resQuery->paginate(config('Reading.nodes_per_page'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.contacts');
        
        $contacts = $this->getContacts($request);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts'))->render(),
            ]);
        }
        return view('solarmitra::business.contacts.index',compact('page_title','contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.contact');
        $business_roles = SolarMitraHelper::getBusinessRolesListArr();
        
        if ($request->ajax()) {
            $type = $request->type ?? '';

            if (view()->exists('solarmitra::business.contacts.'.$type.'_form')) {
                return view('solarmitra::business.contacts.'.$type.'_form',compact('type','page_title','business_roles'));
            }
            return view('solarmitra::business.contacts.contact_form',compact('page_title','business_roles'));
        }
        return view('solarmitra::business.contacts.create',compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $responce = $this->save_contact($request);
            return $responce;
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('solarmitra::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $type = $request->type ?? '';
        $business_roles = SolarMitraHelper::getBusinessRolesListArr();


        if ($request->ajax()) {

            if (view()->exists('solarmitra::business.contacts.'.$type.'_form')) {
                return view('solarmitra::business.contacts.'.$type.'_form',compact('type','contact','business_roles'));
            }
            return view('solarmitra::business.contacts.contact_form',compact('type','contact','business_roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $responce = $this->save_contact($request,$id);
            return $responce;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contactObj = Contact::findOrFail($id);
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('CONTACT-DC', $contactObj->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        if(request('type') == 'clients') optional($contactObj->client)->delete(); 
        if(request('type') == 'staff') optional($contactObj->staff)->delete(); 
        if(request('type') == 'suppliers') optional($contactObj->supplier)->delete(); 
        if(request('type') == 'investors') optional($contactObj->investor)->delete(); 
        if(request('type') == 'contractors') optional($contactObj->contractor)->delete(); 
        if(request('type') == 'partners') optional($contactObj->partner)->delete(); 

        if (empty(request('type'))) {
            optional($contactObj->client)->delete();
            optional($contactObj->staff)->delete();
            optional($contactObj->supplier)->delete();
            optional($contactObj->investor)->delete();
            optional($contactObj->contractor)->delete();
            optional($contactObj->partner)->delete();
            $contactObj->delete(); 
        }

        return redirect()->back()->with('success', __('solarmitra::solarmitra.contact_deleted_text'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function multi_destroy(Request $request)
    {
        $contacts = Contact::WhereIn('id',$request->selected_leads)->get();
        
        foreach ($contacts as $contactObj) {
            optional($contactObj->client)->delete();
            optional($contactObj->staff)->delete();
            optional($contactObj->supplier)->delete();
            optional($contactObj->investor)->delete();
            optional($contactObj->contractor)->delete();
            optional($contactObj->partner)->delete();
            
            $contactObj->delete();
        }

        return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.contact_deleted_text')]);
    }

    
    public function clients(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.clients');
        $type = 'clients';
        $contacts = $this->getContacts($request,$type);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type'));
    }
    
    public function staff(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.staff');
        $type = 'staff';
        $contacts = $this->getContacts($request,$type);
        $business_roles = SolarMitraHelper::getBusinessRolesListArr();


        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type','business_roles'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type','business_roles'));
    }
    
    public function contractors(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.contractors');
        $type = 'contractors';
        $contacts = $this->getContacts($request,$type);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type'));
    }
    
    public function suppliers(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.suppliers');
        $type = 'suppliers';
        $contacts = $this->getContacts($request,$type);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type'));
    }
    
    public function investors(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.investors');
        $type = 'investors';
        $contacts = $this->getContacts($request,$type);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type'));
    }
    
    public function partners(Request $request)
    {
        
        $page_title = __('solarmitra::solarmitra.partners');
        $type = 'partners';
        $contacts = $this->getContacts($request,$type);

        if ($request->ajax()) {
            return response()->json([
                'responce_for' => 'contacts',
                'ContactsTableContent' => view('solarmitra::business.contacts.list_view',compact('contacts','type'))->render(),
            ]);
        }

        return view('solarmitra::business.contacts.index',compact('page_title','contacts','type'));
    }
    
    public function assign_type(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            
            $contact = Contact::where('business_id',app('currentBusinessId'))->where('id',$id)->firstOrFail();

            $contact->type        = 2;
            $contact->save();

            if (request('type') == 'clients') {
                $clientsObj = $contact->client()->firstOrNew(['contact_id' => $contact->id]);
                $clientsObj->business_id = $request->business_id;
                $clientsObj->save();
            }

            if (request('type') == 'staff') {

                $staffObj = $contact->staff()->firstOrNew(['contact_id' => $contact->id]);
                $staffObj->business_id = $request->business_id;
                $staffObj->save();
            }

            if (request('type') == 'suppliers') {
                $suppliersObj = $contact->supplier()->firstOrNew(['contact_id' => $contact->id]);
                $suppliersObj->business_id = $request->business_id;
                $suppliersObj->save();
            }

            if (request('type') == 'investors') {
                $investorsObj = $contact->investor()->firstOrNew(['contact_id' => $contact->id]);
                $investorsObj->business_id = $request->business_id;
                $investorsObj->save();
            }

            if (request('type') == 'contractors') {
                $contractorsObj = $contact->contractor()->firstOrNew(['contact_id' => $contact->id]);
                $contractorsObj->business_id = $request->business_id;
                $contractorsObj->save();
            }

            if (request('type') == 'partners') {
                $partnersObj = $contact->partner()->firstOrNew(['contact_id' => $contact->id]);
                $partnersObj->business_id = $request->business_id;
                $partnersObj->save();
            }

            if ($contact->user) {
                $business_roles = config('solarmitra.business_user_roles', []);
                $user = $contact->user;
                $role = Role::firstOrCreate(
                    ['name' => $business_roles[request('type')], 'guard_name' => 'business'],
                    ['role_type' => 'Business', 'level' => 0]
                );

                $user->assignRole($role->name);
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('CONTACT-ACT', $contact->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
            if ($request->ajax()) {
                return response()->json(['status' => true,'reload' => true]);
            }
            return redirect()->back()->with('success', __('solarmitra::solarmitra.type_assigned'));
        }
        $contact = Contact::findOrFail($id);
        return view('solarmitra::business.contacts.assign_type',compact('contact'));
    }
    
    public function save_contact($request,$id=Null)
    {
        $business_roles = config('solarmitra.business_user_roles', []);

        if ($request->isMethod('post')) {

            $contact = Contact::findOrNew($id);
            $user = $contact->user ?? new User();

            $validation = [
                'name'  => 'required|string|max:255',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('contacts')->where(fn($q) => $q->where('business_id', $request->business_id))->ignore($contact->id, 'id'),
                ],
                'phone_number' => [
                    'required','numeric','digits:10',
                    Rule::unique('contacts')->where(fn($q) => $q->where('business_id', $request->business_id))->ignore($contact->id, 'id'),
                ],
                'aadhar_no' => [
                    'nullable',
                    'digits:12',
                    'regex:/^[0-9]{12}$/',
                    Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $request->business_id))->ignore($contact->id, 'id'),
                ],

                'pan_no' => [
                    'nullable',
                    'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                    Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $request->business_id))->ignore($contact->id, 'id'),
                ],

                'gst_no' => [
                    'nullable',
                    'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[A-Z0-9]{1}[A-Z0-9]{1}$/',
                    Rule::unique('contacts')->where(fn($query) => $query->where('business_id', $request->business_id))->ignore($contact->id, 'id'),
                ],
            ];

            if (!$id) {
                $validation['type']  = 'required|in:' . implode(',', array_keys($business_roles));
            }

            if (request('type') == 'clients' && !$contact->exists) {
                $validation['address_title'] = 'required';
                $validation['address'] = 'required';

            }

            if ($contact->user) {
                $validation['email'] = 'required|email|unique:users,email,' . $contact->user->id;
                $validation['phone_number'] = 'required|string|digits:10|unique:users,mobile,'. $contact->user->id;
            }

            $messages = [
                            'email.required' => __('solarmitra::solarmitra.email_required'),
                            'email.email' => __('solarmitra::solarmitra.email_invalid'),
                            'email.unique' => __('solarmitra::solarmitra.email_unique'),

                            'phone_number.required' => __('solarmitra::solarmitra.phone_number_required'),
                            'phone_number.digits' => __('solarmitra::solarmitra.phone_number_digits'),
                            'phone_number.unique' => __('solarmitra::solarmitra.phone_number_unique'),

                            'aadhar_no.digits' => __('solarmitra::solarmitra.aadhar_no_digits'),
                            'aadhar_no.regex' => __('solarmitra::solarmitra.aadhar_no_regex'),
                            'pan_no.regex' => __('solarmitra::solarmitra.pan_no_regex'),
                            'gst_no.regex' => __('solarmitra::solarmitra.gst_no_regex'),
                            'type.required' => __('solarmitra::solarmitra.type_required'),
                            'type.in' => __('solarmitra::solarmitra.type_invalid'),
                        ];

            $validator = \Validator::make($request->all(), $validation, $messages);
        
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$messages);
            }

            try {
                
            
                [$firstName, $lastName] = explode(' ', $request->name . ' ', 2);

                if ($contact->user) {
                    $user->name = $request->name;
                    $user->first_name = trim($firstName);
                    $user->last_name = trim($lastName);
                    $user->email = $request->email;
                    $user->mobile = $request->phone_number;
                    $user->save();

                    if (request('type') && in_array(request('type'), $business_roles)) {
                        $role = Role::firstOrCreate(
                            ['name' => $business_roles[request('type')], 'guard_name' => 'business'],
                            ['role_type' => 'Business', 'level' => 0]
                        );
                        $user->assignRole($role->name);
                    }

                }

                $contact->business_id = $request->business_id;
                $contact->user_id     = optional(@$contact->user)->id ?? 0;
                $contact->type        = 2;
                $contact->first_name    = trim(@$firstName);
                $contact->last_name     = trim(@$lastName);
                $contact->name        = $request->name;
                $contact->phone_number  = $request->phone_number;
                $contact->email       = $request->email;
                if ($request->filled('company_name')) {
                    $contact->company_name= $request->company_name;
                }
                $contact->aadhar_no   = $request->aadhar_no;
                $contact->pan_no      = $request->pan_no;
                $contact->gst_no      = $request->gst_no;
                
                $contact->save();


                if (request('type') == 'clients') {
                    $clientsObj = $contact->client()->firstOrNew(['contact_id' => $contact->id]);
                    $clientsObj->business_id = $request->business_id;
                    $clientsObj->client_code = $request->client_code;
                    $clientsObj->client_type = $request->client_type;
                    $clientsObj->customer_since = $request->customer_since ?? Carbon::now()->format(config('solarmitra.date_time_format')); 
                    $clientsObj->credit_limit = $request->credit_limit;
                    $clientsObj->payment_terms = $request->payment_terms ?? null;
                    $clientsObj->preferred_contact_method = $request->preferred_contact_method ?? 'phone';
                    $clientsObj->priority_level = $request->priority_level;
                    $clientsObj->status = $request->status;
                    $clientsObj->notes = $request->notes;
                    $clientsObj->save();
                }

                if (request('type') == 'staff') {

                    $staffObj = $contact->staff()->firstOrNew(['contact_id' => $contact->id]);
                    $staffObj->business_id = $request->business_id;
                    $staffObj->employee_code = $request->employee_code;
                    $staffObj->department = $request->department;
                    $staffObj->designation = $request->designation;
                    $staffObj->joining_date = $request->joining_date ?? Carbon::now()->format(config('solarmitra.date_time_format'));
                    $staffObj->employment_type = $request->employment_type;
                    $staffObj->salary_type = $request->salary_type;
                    $staffObj->salary_amount = $request->salary_amount;
                    $staffObj->work_location = $request->work_location;
                    $staffObj->status = $request->status;
                    $staffObj->work_responsibilities = $request->work_responsibilities;
                    $staffObj->special_note = $request->special_note;
                    $staffObj->save();

                    $contact->fill(['company_name' => optional($contact->business)->company_name])->save();
                }

                if (request('type') == 'suppliers') {
                    $suppliersObj = $contact->supplier()->firstOrNew(['contact_id' => $contact->id]);
                    $suppliersObj->business_id = $request->business_id;
                    $suppliersObj->supplier_category = $request->supplier_category;
                    $suppliersObj->brand_name = $request->brand_name;
                    $suppliersObj->gst_no = $request->gst_no;
                    $suppliersObj->pan_no = $request->pan_no;
                    $suppliersObj->payment_terms = $request->payment_terms;
                    $suppliersObj->delivery_time_days = $request->delivery_time_days;
                    $suppliersObj->service_area = $request->service_area;
                    $suppliersObj->rating = $request->rating;
                    $suppliersObj->status = $request->status;
                    $suppliersObj->save();
                }

                if (request('type') == 'investors') {
                    $AttachmentObj = New Attachment();
                    
                    $investorsObj = $contact->investor()->firstOrNew(['contact_id' => $contact->id]);
                    $investorsObj->business_id = $request->business_id;
                    $investorsObj->investment_type = $request->investment_type;
                    $investorsObj->investment_amount = $request->investment_amount;
                    $investorsObj->equity_percent = $request->equity_percent;
                    $investorsObj->investment_date = $request->investment_date ?? Carbon::now()->format(config('solarmitra.date_time_format'));
                    $investorsObj->expected_roi = $request->expected_roi;
                    $investorsObj->payout_frequency = $request->payout_frequency;
                    if ($request->hasFile('contract_document')) {
                        $investorsObj->contract_document = $AttachmentObj->InsertAttachments($request,'contract_document');
                    }
                    $investorsObj->status = $request->status;

                    $investorsObj->save();
                }

                if (request('type') == 'contractors') {
                    $contractorsObj = $contact->contractor()->firstOrNew(['contact_id' => $contact->id]);
                    $contractorsObj->business_id = $request->business_id;
                    $contractorsObj->contractor_type = $request->contractor_type;
                    $contractorsObj->team_size = $request->team_size;
                    $contractorsObj->skill_category = $request->skill_category;
                    $contractorsObj->labor_rate_per_kw = $request->labor_rate_per_kw;
                    $contractorsObj->service_area = $request->service_area;
                    $contractorsObj->experience_years = $request->experience_years;
                    $contractorsObj->license_no = $request->license_no;
                    $contractorsObj->availability_status = $request->availability_status;
                    $contractorsObj->rating = $request->rating;
                    $contractorsObj->save();
                }

                if (request('type') == 'partners') {
                    $partnersObj = $contact->partner()->firstOrNew(['contact_id' => $contact->id]);
                    $partnersObj->business_id = $request->business_id;
                    $partnersObj->partner_type = $request->partner_type;
                    $partnersObj->commission_percent = $request->commission_percent;
                    $partnersObj->partnership_start_date = $request->partnership_start_date ?? Carbon::now()->format(config('solarmitra.date_time_format'));
                    $partnersObj->partnership_end_date = $request->partnership_end_date ?? Carbon::now()->format(config('solarmitra.date_time_format'));
                    $partnersObj->region = $request->region;
                    $partnersObj->sales_target = $request->sales_target;
                    $partnersObj->status = $request->status;
                    $partnersObj->save();
                }

                if ($request->address) {
                    $AddressObj = $contact->address()->firstOrNew(['contact_id' => $contact->id]);
                    $AddressObj->business_id        = $request->business_id ?? 0;
                    $AddressObj->contact_id         = $contact->id ?? 0;
                    $AddressObj->project_id         = $request->project_id ?? 0;
                    $AddressObj->address_title      = $request->address_title;
                    $AddressObj->address            = $request->address;
                    $AddressObj->city_id            = $request->city_id ?? 0;
                    $AddressObj->state_id           = $request->state_id ?? 0;
                    $AddressObj->country_id         = $request->country_id ?? 0;
                    $AddressObj->address_type       = $request->address_type ?? 1;
                    $AddressObj->is_primary         = 1;
                    $address                        = $AddressObj->save();
                }

                /* Send Event Notification */
                $notificationObj        = new Notification();
                if ($contact->wasRecentlyCreated) {
                    $notificationObj->notification_entry('CONTACT-ANC', $contact->id, auth('business')->id(), config('constants.superadmin'));
                }else{
                    $notificationObj->notification_entry('CONTACT-UC', $contact->id, auth('business')->id(), config('constants.superadmin'));
                }
                /* End Send Event Notification */

                $dropdown_html = SolarMitraHelper::getContactDropdown(request('type'),$request->project_id,$contact->id);
                $message = $id ? __('solarmitra::solarmitra.contact_update_success') : __('solarmitra::solarmitra.contact_add_success');
                return response()->json(['success' => true,'message' => $message,'dropdown' => $dropdown_html]);
            } catch (Exception $e) {
                
                return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
            }
            
        }
    }

    public function assign_login(Request $request)
    {
        $business_roles = SolarMitraHelper::getBusinessRolesListArr();

        if ($request->isMethod('post')) {

            $contact = Contact::find($request->contact_id);
            $user = $contact->user ?? new User();

            $validation = [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'mobile' => 'required|string|digits:10|unique:users,mobile,' . $user->id,
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
                'role' => 'required|array',
            ];
            if ($contact->user) {
                $validation = array_merge($validation,[
                    'password' => 'nullable',
                    'password_confirmation' => 'nullable',
                ]);
            }

            $validationMsg = [
                'name.required' => __('solarmitra::solarmitra.name_required'),
                'name.string' => __('solarmitra::solarmitra.name_string'),
                'name.max' => __('solarmitra::solarmitra.name_max'),

                'email.required' => __('solarmitra::solarmitra.email_address_required'),
                'email.email' => __('solarmitra::solarmitra.email_address_invalid'),
                'email.unique' => __('solarmitra::solarmitra.email_unique'),

                'mobile.required' => __('solarmitra::solarmitra.mobile_required'),
                'mobile.digits' => __('solarmitra::solarmitra.mobile_digits'),
                'mobile.unique' => __('solarmitra::solarmitra.mobile_unique'),

                'password.required' => __('solarmitra::solarmitra.password_required'),
                'password.confirmed' => __('solarmitra::solarmitra.password_confirmed'),

                'password_confirmation.required' => __('solarmitra::solarmitra.password_confirmation_required'),
            ];


            $validator = \Validator::make($request->all(), $validation,$validationMsg);
        
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }
            DB::beginTransaction();

            try {
                

                [$firstName, $lastName] = explode(' ', $request->name . ' ', 2);

                $user->name = $request->name;
                $user->first_name = trim($firstName);
                $user->last_name = trim($lastName);
                $user->email = $request->email;
                $user->mobile = $request->mobile;

                if (!$user->exists || $request->password) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();

                 // Old method to assign role 
                if (request('type') && in_array(request('type'), $business_roles)) {
                    $role = Role::firstOrCreate(
                        ['name' => $business_roles[request('type')], 'guard_name' => 'business'],
                        ['role_type' => 'Business', 'level' => 0]
                    );
                }
                
                $user->syncRoles(BusinessRole::findMany($request->role));

                $contact->user_id     = $user->id;
                $contact->save();

                /* Send Event Notification */
                $notificationObj        = new Notification();
                $notificationObj->notification_entry('CONTACT-ALC', $contact->id, auth('business')->id(), config('constants.superadmin'));
                /* End Send Event Notification */
                
                DB::commit();

                return response()->json(['success' => true,'message' => $user->wasRecentlyCreated ? __('solarmitra::solarmitra.login_assigned_successfully') : __('solarmitra::solarmitra.assigned_user_updated_successfully') ]);
            } catch (\Throwable $e) {

                DB::rollBack();

                return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
            }
            
        }
    
        $contact = Contact::with('user.roles')->find($request->contact_id);
        $type = $request->type;
        return view('solarmitra::business.contacts.assign_user_offcanvas', compact('contact', 'type', 'business_roles'));    
    }

    public function verify_user_direct($contact_id)
    {
        $contact = Contact::with('user')->find($contact_id);

        if (!$contact || !$contact->user) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.no_user_account_found'));
        }

        $user = $contact->user;
        $user->is_email_verified = 1;
        $user->is_mobile_verified = 1;
        $user->save();

        return redirect()->back()->with('success', $contact->name . ' ' . __('solarmitra::solarmitra.verified_login_message'));
    }

    /**
     * Show the verify user popup with separate email/mobile buttons
     */
    public function verify_user_modal($contact_id)
    {
        $contact = Contact::with('user')->find($contact_id);

        if (!$contact || !$contact->user) {
            return response()->json(['status' => false, 'message' => __('solarmitra::solarmitra.no_user_account_found')], 404);
        }

        return view('solarmitra::business.contacts.ajax.verify_user_modal', compact('contact'));
    }

    /**
     * Verify a single field (email or mobile) for a contact's user via AJAX
     */
    public function verify_user_field(Request $request, $contact_id)
    {
        $request->validate([
            'field' => 'required|in:email,mobile',
        ]);

        $contact = Contact::with('user')->find($contact_id);

        if (!$contact || !$contact->user) {
            return response()->json(['status' => false, 'message' => __('solarmitra::solarmitra.no_user_account_found')], 404);
        }

        $user = $contact->user;
        $field = $request->field;

        if ($field === 'email') {
            $user->is_email_verified = 1;
        } else {
            $user->is_mobile_verified = 1;
        }

        $user->save();

        return response()->json([
            'status'  => true,
            'field'   => $field,
            'message' => ucfirst($field) . ' ' . __('solarmitra::solarmitra.field_verified_for', ['name' => $contact->name]),
        ]);
    }


}
