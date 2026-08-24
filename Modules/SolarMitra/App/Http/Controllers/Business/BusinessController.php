<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\BankAccount;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Lead;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Notification;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.dashboard');

        $projects = Project::where('business_id',app('currentBusinessId'));
        $this->checkDateFilter('start_date' ,$projects);

        $quotations = Quotation::where('business_id', app('currentBusinessId'));
        $this->checkDateFilter('date' ,$quotations);

        $invoices = Invoice::where('business_id', app('currentBusinessId'));
        $this->checkDateFilter('date' ,$invoices);

        $leads = Lead::where('business_id', app('currentBusinessId'))
                    ->when(optional(auth('business')->user())->id && !auth('business')->user()->hasRole('Business'), function ($query) use ($request) {
                        $query->where('lead_added_by_id', optional(auth('business')->user())->id);
                    });

        $this->checkDateFilter('created_at' ,$leads);

        /* 1. KPI Summary Cards Start Here */

        /* New Leads */
        $new_leads = (clone $leads)->whereHas('lead_stage',function($q){
                                $q->where('slug','new');
                            })->count();

        /* Active Projects */
        $active_projects = (clone $projects)->where('status', '2')->count();

        /* Pending Quotation */
        $pending_quotations = (clone $quotations)->whereIn('quotation_status_id', [2,3,4])->count();

        /* Outstanding Payments */
        $outstanding_payments = (clone $invoices)->sum('due_amount');

        /* Installed Capacities */
        $installed_capacities = (clone $projects)->where('status', '3')->sum('capacity_int');

        /* Material Alerts */
        $material_alerts = 0;

        /* Material Alerts */
        $draft_quotations = (clone $quotations)->where('quotation_status_id',1)->count();
        $sent_quotations = (clone $quotations)->where('quotation_status_id',2)->count();
        $in_discussion_quotations = (clone $quotations)->where('quotation_status_id',3)->count();
        $on_hold_quotations = (clone $quotations)->where('quotation_status_id',4)->count();
        $client_confirmed_quotations = (clone $quotations)->where('quotation_status_id',5)->count();
        $rejected_quotations = (clone $quotations)->where('quotation_status_id',6)->count();

        /* KPI Summary Cards End Here */


        /* 2. Sales Funnel Start Here */

        /* Total Leads */
        $total_leads = (clone $leads)->count();

        /* Total Qualified */
        $total_qualified = (clone $leads)->where('lead_stage_id',3)->count();

        /* Total Quotation Send */
        $total_quotation_send = (clone $quotations)->where('quotation_status_id',2)->count();

        /* Apporoved Quotation Won */
        $apporoved_quotations = (clone $quotations)->where('quotation_status_id',5)->count();

        /* Installed Panels */
        $installed_panels = (clone $projects)->whereHas('project_documents', function($q){
                                            $q->where('panel_work_status',1);
                                    })->count();
        /* Sales Funnel End Here */



        /* 3. Project Status Overview Start Here - Not in Worked Yet*/

        /* Project Planning */ // used drafted and hold projects
        $draft_projects = (clone $projects)->where('status', 1)->latest()->limit(10)->get();
        
        /* Solar Installation */
        $running_projects = (clone $projects)->where('status', 2)->latest()->limit(10)->get();
        
        /* Site Inspection */
        $completed_projects = (clone $projects)->where('status', 3)->latest()->limit(10)->get();
        
        /* Project Completed */
        $hold_projects = (clone $projects)->where('status', 4)->latest()->limit(10)->get();

        /* Project Status Overview End Here */



        /* 4. Financial Snapshot Start Here */


        /* Total Revenue */
        $total_revenue = (clone $invoices)->sum('total_amount');
        $total_paid_invoices = (clone $invoices)->selectRaw('COUNT(*) as count, SUM(paid_amount) as total')->first();
        $total_unpaid_invoices = (clone $invoices)->selectRaw('COUNT(*) as count, SUM(due_amount) as total')->first();

        /* Pending Invoices */
        
        /* Paid vs Unpaid chart */

        /* GST / Tax summary (India-ready) */
        /* Financial Snapshot End Here */

        if ($request->ajax()) {
            return view('solarmitra::business.business.dashboard_widgets',compact('page_title','new_leads','active_projects','pending_quotations','outstanding_payments','installed_capacities','material_alerts','total_leads','total_qualified','total_quotation_send','apporoved_quotations','installed_panels','draft_quotations','sent_quotations','in_discussion_quotations','on_hold_quotations','client_confirmed_quotations','rejected_quotations','draft_projects','running_projects','completed_projects','hold_projects'))->render();
        }

        return view('solarmitra::business.business.dashboard',compact('page_title','new_leads','active_projects','pending_quotations','outstanding_payments','installed_capacities','material_alerts','total_leads','total_qualified','total_quotation_send','apporoved_quotations','installed_panels','total_revenue','total_paid_invoices','total_unpaid_invoices','draft_quotations','sent_quotations','in_discussion_quotations','on_hold_quotations','client_confirmed_quotations','rejected_quotations','draft_projects','running_projects','completed_projects','hold_projects'));
    }

    private function checkDateFilter($fieldName ,$query) {
        if (request()->sort_by == 'this_month') {
            $query->whereYear($fieldName, \Carbon\Carbon::now()->year);
            $query->whereMonth($fieldName, \Carbon\Carbon::now()->month);
        }
        elseif (request()->sort_by == 'last_24_hours') {
            $query->where($fieldName, '>=', \Carbon\Carbon::now()->subDay());
        }
        elseif (request()->sort_by == 'last_7_days') {
            $query->where($fieldName, '>=', \Carbon\Carbon::now()->subDays(7));
        }
        elseif (request()->sort_by == 'this_week') {
            $query->whereBetween($fieldName, [
                \Carbon\Carbon::now()->startOfWeek(), 
                \Carbon\Carbon::now()->endOfWeek()
            ]);
        }
        elseif (request()->sort_by == 'this_year') {
            $query->whereYear($fieldName, \Carbon\Carbon::now()->year);
        }
        elseif (request()->sort_by == 'range') {
            if (!empty(request()->daterange)) {
                $dates = explode(' - ', request()->daterange);
                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[0])->format('Y-m-d');
                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[1])->format('Y-m-d');
                $query->whereBetween($fieldName, [$startDate, $endDate]);
            }
        }
        elseif (request()->sort_by == 'all_time') {
            
        }
    }

    public function get_invoice_series(Request $request)
    {
        $seriesType = $request->seriesType; // Week, Month, Year, All
        $categories = [];
        $paidData = [];
        $pendingData = [];
        $invoices = Invoice::where('business_id', app('currentBusinessId'));

        switch($seriesType) {
            case 'Week':
                // Get days of the current week from invoices
                $days = (clone $invoices)->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])->orderBy('date')->pluck('date')->map(function($date){
                                   return \Carbon\Carbon::parse($date)->format('l'); // Monday, Tuesday...
                               })->unique()->values();

                $categories = $days->toArray();

                // Sum by day
                $paid = (clone $invoices)->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                               ->select(DB::raw('DAYNAME(date) as day'), DB::raw('SUM(paid_amount) as total'))
                               ->groupBy('day')->pluck('total','day');

                $pending = (clone $invoices)->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                                  ->select(DB::raw('DAYNAME(date) as day'), DB::raw('SUM(due_amount) as total'))->groupBy('day')->pluck('total','day');

                // Map data to categories
                foreach($categories as $day){
                    $paidData[] = $paid[$day] ?? 0;
                    $pendingData[] = $pending[$day] ?? 0;
                }

                break;

            case 'Month':
                // Get months with invoices this year
                $rawDates = (clone $invoices)->whereMonth('date', now()->month)->whereYear('date', now()->year)->orderBy('date')->pluck('date')->map(function ($date) {
                        return \Carbon\Carbon::parse($date)->format('Y-m-d');
                    })->unique()->values();

                $categories = $rawDates->map(function ($date) {
                    return \Carbon\Carbon::parse($date)->format('j M');
                })->toArray();

                $paid = (clone $invoices)->whereMonth('date', now()->month)->whereYear('date', now()->year)->select(DB::raw('DATE(date) as day'), DB::raw('SUM(paid_amount) as total'))->groupBy('day')->pluck('total', 'day');

                $pending = (clone $invoices)->whereMonth('date', now()->month)->whereYear('date', now()->year)->select(DB::raw('DATE(date) as day'), DB::raw('SUM(due_amount) as total'))->groupBy('day')->pluck('total', 'day');

                $paidData = [];
                $pendingData = [];

                foreach ($rawDates as $date) {
                    $paidData[] = $paid[$date] ?? 0;
                    $pendingData[] = $pending[$date] ?? 0;
                }

                break;

            case 'Year':
                $months = (clone $invoices)->whereYear('date', now()->year)->orderBy('date')->pluck('date')->map(function($date){
                        return \Carbon\Carbon::parse($date)->format('M'); // ? Jan, Feb, Mar
                    })->unique()->values();

                $categories = $months->toArray();

                $paid = (clone $invoices)->whereYear('date', now()->year)
                    ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(paid_amount) as total'))
                    ->groupBy('month')->pluck('total','month');

                $pending = (clone $invoices)->whereYear('date', now()->year)
                    ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(due_amount) as total'))
                    ->groupBy('month')->pluck('total','month');

                foreach($months as $month){
                    $monthNumber = \Carbon\Carbon::createFromFormat('M', $month)->month;

                    $paidData[] = $paid[$monthNumber] ?? 0;
                    $pendingData[] = $pending[$monthNumber] ?? 0;
                }

                break;
            case 'All':
            default:
                $years = (clone $invoices)->select(DB::raw('YEAR(date) as year'))->groupBy('year')->orderBy('year')->pluck('year');
                $categories = $years->toArray();
                $paid = (clone $invoices)->select(DB::raw('YEAR(date) as year'), DB::raw('SUM(paid_amount) as total'))->groupBy('year')->pluck('total','year');
                $pending = (clone $invoices)->select(DB::raw('YEAR(date) as year'), DB::raw('SUM(due_amount) as total'))->groupBy('year')->pluck('total','year');

                foreach($years as $year){
                    $paidData[] = $paid[$year] ?? 0;
                    $pendingData[] = $pending[$year] ?? 0;
                }

            break;
        }

        return response()->json([
            'categories' => $categories,
            'paid' => $paidData,
            'pending' => $pendingData
        ]);
    }

    /**
     * Display Settings.
     */
    public function settings()
    {
        $page_title = __('solarmitra::solarmitra.settings');
        $business = Business::FindOrFail(app('currentBusinessId'));
        return view('solarmitra::business.business.settings',compact('page_title','business'));
    }

    public function save_business(Request $request,$id)
    {
        $business = Business::findorFail($id);

            $validation = [
                'first_name'        => 'required',
                'email'             => 'required|email|unique:users,email,'.$business->user_id,
                'password'          => 'nullable|confirmed',
                'password_confirmation'  => 'nullable',
                'company_name'      => 'required',
                'phone'             => 'required|string|digits:10|unique:users,mobile,'.$business->user_id,
            ];

            $validationMsg = [
                'phone.required'    => __('solarmitra::solarmitra.phone_field_required'),
                'first_name.required' => __('solarmitra::solarmitra.first_name_required'),

                'email.required' => __('solarmitra::solarmitra.email_required'),
                'email.email' => __('solarmitra::solarmitra.email_invalid'),
                'email.unique' => __('solarmitra::solarmitra.email_unique'),

                'password.confirmed' => __('solarmitra::solarmitra.password_confirmation_mismatch'),

                'company_name.required' => __('solarmitra::solarmitra.company_name_required'),

                'phone.digits' => __('solarmitra::solarmitra.phone_digits'),
                'phone.unique' => __('solarmitra::solarmitra.phone_unique'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $full_name = $request->input('first_name').' '.$request->input('last_name');
            
            $userObj = User::firstOrNew(['id' =>  $business->user_id]);
            $userObj->name          = $full_name;
            $userObj->first_name    = $request->input('first_name');
            $userObj->last_name     = $request->input('last_name');
            $userObj->email         = $request->input('email');
            $userObj->mobile        = $request->input('phone');

            if ($request->input('password')) {
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
             
            $contactObj = Contact::firstOrNew(['id' =>  optional($business->contact)->id]);
            $contactObj->user_id            = $userObj->id;
            $contactObj->business_id        = $business->id;
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


            $AttachmentObj = New Attachment();

            $BusinessObj = Business::findorFail($id);
            $BusinessObj->user_id           = $userObj->id;
            $BusinessObj->company_name      = $request->company_name;
            $BusinessObj->contact_person    = $request->contact_person;
            $BusinessObj->phone             = $request->phone;
            $BusinessObj->gst_no            = $request->gst_no;
            $BusinessObj->pan_no            = $request->pan_no;
            $BusinessObj->about             = $request->about;
            
            if ($request->hasFile('logo')) {
                $BusinessObj->logo              = $AttachmentObj->InsertAttachments($request,'logo');
            }
            $business                       = $BusinessObj->save();

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('BUSINESS-UB', $BusinessObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
            

            return redirect()->back()->with('success', __('solarmitra::solarmitra.business_saved_text'));
    }

    public function bank_account(Request $request,$id=null)
    {

        if($request->isMethod('post'))
        {
            $validation = [
                'account_holder'        => 'required',
                'bank_name'             => 'required',
                'account_number'        => 'required',
                'ifsc_code'             => 'nullable|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',

            ];

            $messages = [
                'account_holder.required' => __('solarmitra::solarmitra.account_holder_required'),
                'bank_name.required' => __('solarmitra::solarmitra.bank_name_required'),
                'account_number.required' => __('solarmitra::solarmitra.account_number_required'),
                'ifsc_code.regex' => __('solarmitra::solarmitra.ifsc_code_invalid'),
            ];

            $validator = \Validator::make($request->all(), $validation,$messages);
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$messages);
            }

            $businessId = $request->business_id;
            $contactId  = $request->contact_id ?? 0;
            $isPrimary  = $request->boolean('is_primary');

            // Existing account (edit case)
            $existingAccount = BankAccount::find($id);

            /**
             * ==================================================
             * VALIDATION: At least one primary must exist
             * ==================================================
             */
            if ($existingAccount && $existingAccount->is_primary && ! $isPrimary) {

                $hasAnotherPrimary = BankAccount::where('business_id', $businessId)
                    ->where('contact_id', $contactId)
                    ->where('id', '!=', $existingAccount->id)
                    ->where('is_primary', 1)
                    ->exists();

                if (! $hasAnotherPrimary) {
                    throw ValidationException::withMessages([
                        'is_primary' => __('solarmitra::solarmitra.at_least_one_primary_bank_account'),
                    ]);
                }
            }

            /**
             * ==================================================
             * AUTO PRIMARY FOR FIRST RECORD
             * ==================================================
             */
            $hasAnyAccount = BankAccount::where('business_id', $businessId)
                ->where('contact_id', $contactId)
                ->exists();

            if (! $hasAnyAccount) {
                $isPrimary = true;
            }

            /**
             * ==================================================
             * UNSET OTHER PRIMARY ACCOUNTS
             * ==================================================
             */
            if ($isPrimary) {
                BankAccount::where('business_id', $businessId)
                    ->where('contact_id', $contactId)
                    ->where('id', '!=', $id)
                    ->update(['is_primary' => 0]);
            }

            $AttachmentObj = New Attachment();

            $bankAccount = BankAccount::firstOrNew(['id' => $id]);
            $newAccount = !$bankAccount->exists;
            $bankAccount->business_id       = $request->business_id;
            $bankAccount->contact_id        = $request->contact_id ?? 0;
            $bankAccount->account_holder    = $request->account_holder;
            $bankAccount->account_number    = $request->account_number;
            $bankAccount->ifsc_code         = $request->ifsc_code;
            $bankAccount->bank_name         = $request->bank_name;
            $bankAccount->bank_address      = $request->bank_address;
            $bankAccount->iban_number       = $request->iban_number;
            $bankAccount->upi_number        = $request->upi_number;
            $bankAccount->is_primary        = $isPrimary ? 1 : 0;
            if ($request->hasFile('payment_barcode')) {
                $bankAccount->payment_barcode              = $AttachmentObj->InsertAttachments($request,'payment_barcode');
            }
            $bankAccount->save();

            /* Send Event Notification */
            $notificationObj        = new Notification();
            if ($newAccount) {
                $notificationObj->notification_entry('BANKACCOUNT-ANBA', $bankAccount->id, auth('business')->id(), config('constants.superadmin'));
            }else{
                $notificationObj->notification_entry('BANKACCOUNT-UBA', $bankAccount->id, auth('business')->id(), config('constants.superadmin'));
            }
            /* End Send Event Notification */


            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'message' => __('solarmitra::solarmitra.bank_account_saved_text'),
                    'reload' => true
                ]);
            }

        }

        $page_title = __('solarmitra::solarmitra.bank_account');
        $bank_account = BankAccount::find($id);
        return view('solarmitra::business.business.bank_account',compact('page_title','bank_account'));
    }

    public function bank_account_destroy($id)
    {
        $bank_account = BankAccount::find($id);

        if($bank_account->is_primary) 
        {
            return redirect()->back()->with('warning', __('solarmitra::solarmitra.primary_bank_account_cannot_be_deleted'));
        }

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('BANKACCOUNT-DBA', $bank_account->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        if($bank_account->delete()) 
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.bank_account_delete_success'));
        }
        return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
    }

    public function address(Request $request,$id=null)
    {

        if($request->isMethod('post'))
        {
            $validation = [
                'address_title'     => 'required',
                'address'           => 'required',
            ];

            $messages = [
                'address_title.required' => __('solarmitra::solarmitra.address_title_required'),
                'address.required' => __('solarmitra::solarmitra.address_required'),
            ];

            $validator = \Validator::make($request->all(), $validation);
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation);
            }

            $AddressObj = Address::firstOrNew(['id' => $id]);

            $newAddress = !$AddressObj->exists;
            $AddressObj->business_id        = $request->business_id ?? 0;
            $AddressObj->contact_id         = $request->contact_id ?? 0;
            $AddressObj->project_id         = $request->project_id ?? 0;
            $AddressObj->address_title      = $request->address_title;
            $AddressObj->address            = $request->address;
            $AddressObj->city_id            = $request->city_id;
            $AddressObj->state_id           = $request->state_id;
            $AddressObj->country_id         = $request->country_id;
            $AddressObj->address_type       = $request->address_type ?? 1;
            $address                        = $AddressObj->save();

            /* Send Event Notification */
            $notificationObj        = new Notification();
            if ($newAddress) {
                $notificationObj->notification_entry('ADDRESS-ANA', $AddressObj->id, auth('business')->id(), config('constants.superadmin'));
            }else{
                $notificationObj->notification_entry('ADDRESS-UA', $AddressObj->id, auth('business')->id(), config('constants.superadmin'));
            }
            /* End Send Event Notification */

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'message' => __('solarmitra::solarmitra.address_saved_text'),
                    'reload' => true
                ]);
            }

        }

        $page_title = __('solarmitra::solarmitra.address');
        $address = Address::find($id);

        return view('solarmitra::business.business.address',compact('page_title','address'));
    }

    public function address_destroy($id)
    {
        $address = Address::find($id);

        if($address->is_primary) 
        {
            return redirect()->back()->with('warning', __('solarmitra::solarmitra.primary_address_cannot_be_deleted'));
        }

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('ADDRESS-DA', $address->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        if($address->delete()) 
        {
            return redirect()->back()->with('success', __('solarmitra::solarmitra.address_delete_success'));
        }
        return redirect()->back()->with('error', __('solarmitra::solarmitra.problem_in_form_submition'));
    }

    /**
     * Set an address as primary for this business.
     */
    public function address_make_primary($id)
    {
        $address = Address::findOrFail($id);

        // Unset all other primary addresses for this business
        Address::where('business_id', app('currentBusinessId'))
            ->where('id', '!=', $id)
            ->update(['is_primary' => 0]);

        // Set this one as primary
        $address->is_primary = 1;
        $address->save();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.address_set_as_primary_success'));
    }
}
