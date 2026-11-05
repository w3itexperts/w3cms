<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\ProjectPayment;
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\QuotationItem;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\InvoiceItem;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\Lead;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.quotations');
        $baseQuery = Quotation::query()
            ->where('business_id', app('currentBusinessId'))
            ->when(!empty($request->title), function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->title . '%');
            })
            ->when(!empty($request->client_id), function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->when(!empty($request->project_id), function ($q) use ($request) {
                $q->where('project_id', $request->project_id);
            });
            

        $sortMap = [
            'title_asc'      => ['title', 'asc'],
            'title_desc'     => ['title', 'desc'],
            'created_asc'   => ['created_at', 'asc'],
            'created_desc'  => ['created_at', 'desc'],
            'modified_asc'  => ['updated_at', 'asc'],
            'modified_desc' => ['updated_at', 'desc'],
        ];

        $sort_by = $request->sort_by ?: 'modified_desc';
        [$column, $direction] = $sortMap[$sort_by];
        $baseQuery->orderBy($column, $direction);

        // TAB 1: Draft
        $draft_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 1)
            ->paginate(config('Reading.nodes_per_page'));

        // TAB 2: Sent
        $sent_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 2)
            ->paginate(config('Reading.nodes_per_page'));

        // TAB 3: In Discussion
        $inDiscussion_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 3)
            ->paginate(config('Reading.nodes_per_page'));

        // TAB 4: On Hold
        $onHold_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 4)
            ->paginate(config('Reading.nodes_per_page'));

        // TAB 5: Client Confirmed
        $clientConfirmed_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 5)
            ->paginate(config('Reading.nodes_per_page'));

        // TAB 6: Rejected
        $rejected_quotations = (clone $baseQuery)
            ->where('quotation_status_id', 6)
            ->paginate(config('Reading.nodes_per_page'));

        $quotations = (clone $baseQuery)
                    ->when(!empty($request->quotation_status_id) && is_array($request->quotation_status_id),function($q)use($request){
                        $q->whereIn('quotation_status_id',$request->quotation_status_id);
                    })->paginate(config('Reading.nodes_per_page'));

        $projects = Project::where('business_id',app('currentBusinessId'))->pluck('title','id')->toArray();
        return view('solarmitra::business.quotations.index',compact('page_title','quotations','projects','draft_quotations','sent_quotations','inDiscussion_quotations','onHold_quotations','clientConfirmed_quotations','rejected_quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.quotation');
        $contact = '';
        $business = Business::find(app('currentBusinessId'));
        $lead       = '';
        if ($request->ajax()) {
            if ($request->lead_id) {
                $lead       = Lead::firstOrNew(['id' =>  $request->lead_id]);

                $contact = Contact::firstOrNew([
                    'phone_number' => @$lead->phone,
                ]);

                $contact->user_id         = 0;
                $contact->business_id     = app('currentBusinessId');
                $contact->first_name            = @$lead->first_name;
                $contact->last_name            = @$lead->last_name;
                $contact->name            = @$lead->first_name.' '.@$lead->last_name;
                $contact->email           = @$lead->email;
                $contact->save();


                $clientsObj = $contact->client()->firstOrNew(['contact_id' => $contact->id]);
                $clientsObj->business_id = app('currentBusinessId');
                $clientsObj->save();

                if ($contact->wasRecentlyCreated) {
                    if ($lead->address) {
                        
                        $AddressObj = new Address();
                        $AddressObj->business_id        = app('currentBusinessId') ?? 0;
                        $AddressObj->contact_id         = $contact->id ?? 0;
                        $AddressObj->project_id         = $request->project_id ?? 0;
                        $AddressObj->address_title      = optional($lead->address)->address_title;
                        $AddressObj->address            = optional($lead->address)->address;
                        $AddressObj->city_id            = optional($lead->address)->city_id ?? 0;
                        $AddressObj->state_id           = optional($lead->address)->state_id ?? 0;
                        $AddressObj->country_id         = optional($lead->address)->country_id ?? 0;
                        $AddressObj->address_type       = optional($lead->address)->address_type ?? 1;
                        $AddressObj->is_primary         = 1;
                        $address                        = $AddressObj->save();
                    }

                    /* Send Event Notification */
                    $notificationObj        = new Notification();
                    $notificationObj->notification_entry('CONTACT-ANC', $contact->id, auth('business')->id(), config('constants.superadmin'));
                    /* End Send Event Notification */
                }

            }

            // Check for existing quotations for this contact
            $existingQuotations = 0;
            if (!empty($contact->id)) {
                $existingQuotations = Quotation::with('creator')->where('business_id', app('currentBusinessId'))
                    ->where('client_id', $contact->id)
                    ->get();
            }

            return view('solarmitra::business.quotations.quotation_modal',compact('page_title','contact','business','existingQuotations','lead'));
        }

        return view('solarmitra::business.quotations.create',compact('page_title','contact','business','lead'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $newQuotationNumber = SolarMitraHelper::generateDocumentNumber('quotation');
        $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('quotation');
        $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days', 7);

        $validation = [
            'title'  => 'required',
            'location'  => 'required',
            'project_title'  => 'required',
            'client_id'  => 'required',
            'business_id'  => 'required',
            'capacity'  => 'required',
            'project_type'  => 'required',
            'date'   => "nullable|before:valid_till_date",
            "valid_till_date"     => "nullable|after:date",
            "start_date"   => "nullable|before:end_date",
            "end_date"     => "nullable|after:start_date",
        ];

        
        $validationMsg = [
            'title.required' => __('solarmitra::solarmitra.title_required'),
            'project_title.required' => __('solarmitra::solarmitra.project_title_is_required'),
            'client_id.required' => __('solarmitra::solarmitra.please_select_a_client'),
            'client_id.exists' => __('solarmitra::solarmitra.selected_client_does_not_exist'),
            'business_id.required' => __('solarmitra::solarmitra.please_select_a_business'),
            'business_id.exists' => __('solarmitra::solarmitra.selected_business_does_not_exist'),
            'capacity.required' => __('solarmitra::solarmitra.project_capacity_required'),
            'capacity.numeric' => __('solarmitra::solarmitra.capacity_must_be_a_number'),
            'capacity.min' => __('solarmitra::solarmitra.capacity_must_be_at_least_1'),
            'project_type.required' => __('solarmitra::solarmitra.project_type_required'),
            'date.before' => __('solarmitra::solarmitra.start_date_before_valid_till'),
            'valid_till_date.after' => __('solarmitra::solarmitra.valid_till_after_start'),
        ];

        $validator = \Validator::make($request->all(), $validation,$validationMsg);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$validationMsg);
        }

        $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days',7);
        [$capacity_int, $capacity_unit] = explode(' ', $request->capacity);

        $projectObj               = new Project(); 
        $projectObj->business_id  = app('currentBusinessId'); 
        $projectObj->title        = $request->project_title; 
        $projectObj->client_id    = $request->client_id;
        $projectObj->start_date   = $request->start_date ?? Carbon::now()->format(config('solarmitra.date_time_format'));
        $projectObj->end_date     = $request->end_date ?? Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')); 
        $projectObj->capacity     = $request->capacity; 
        $projectObj->capacity_int      = $capacity_int; 
        $projectObj->capacity_unit     = $capacity_unit; 
        $projectObj->project_type = $request->project_type;
        $projectObj->is_solar_kit_project     = $request->is_solar_kit_project ?? 0; 
        $projectObj->change_note  = '[' . now() . '] Project Created with Quotation By '.auth()->user()->full_name; 
        $projectObj->status       = 1; // Draft 
        $projectObj->location     = $request->location ?? null; 
        $projectRes = $projectObj->save();

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('PROJECT-ANP', $projectObj->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        

        $quotationObj = new Quotation(); 
        $quotationObj->business_id      = app('currentBusinessId'); 
        $quotationObj->project_id       = @$projectObj->id ?? 0; 
        $quotationObj->title            = str_contains($request->title, $titlePrefix) ? $request->title : $titlePrefix . $request->title; 
        $quotationObj->quotation_number = $newQuotationNumber; 
        $quotationObj->client_id        = $request->client_id ?? 0; 
        $quotationObj->date             = $request->date ?? Carbon::now()->format(config('solarmitra.date_time_format')); 
        $quotationObj->sub_total        = $request->sub_total ?? 0; 
        $quotationObj->tax              = $request->tax ?? 0; 
        $quotationObj->aditional_charges = $request->aditional_charges ?? 0; 
        $quotationObj->discount         = $request->discount ?? 0; 
        $quotationObj->total_amount     = $request->total_amount ?? 0; 
        $quotationObj->created_by           = auth('business')->id(); 
        $quotationObj->valid_till_date  = $request->valid_till_date ?? Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format'));
        $quotationObj->quotation_status_id           = $request->status ?? 1; 
        $quotationObj->description           = $request->description; 
        if ($request->filled('margin_amount')) {
            $quotationObj->margin_amount           = $request->margin_amount; 
        }
        $res = $quotationObj->save();

        if ($res) {

            if ($request->has('lead_id')) {
                $lead = Lead::where('id', $request->lead_id)->update(['lead_stage_id' => 5]); /* lead status set to Proposal Sent */
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('QUOTATION-ANQ', $quotationObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'message' => __('solarmitra::solarmitra.quotation_added_text'),
                    'redirect' => route('business.solarmitra.quotations.edit', $quotationObj->id)
                ]);
            }

            return redirect()->route('business.solarmitra.quotations.edit',$quotationObj->id);
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        return view('solarmitra::business.quotations.show',compact('quotation'));
    }

    public function edit(Request $request,$id)
    {
        $page_title = __('solarmitra::solarmitra.edit').' '.__('solarmitra::solarmitra.quotation');
        $quotation = Quotation::findOrFail($id);
        $is_solar_kit_project = optional($quotation->project)->is_solar_kit_project;
        $project_type = optional($quotation->project)->project_type;

        $excluded_categories = MaterialCategory::where('display_on_invoice', '!=', 1);
        $categories = MaterialCategory::where('display_on_invoice', 1);

        if ($is_solar_kit_project) {
            $excluded_categories->where('include_in_solar_kit', '!=', 1);
            $categories->where('include_in_solar_kit', '!=', 1);
        } else {
            $excluded_categories->where('slug', '!=', 'solar-kit');
            $categories->where('slug', '!=', 'solar-kit');
        }

        $orderBy = "
            CASE WHEN slug = 'workmanship-installation' THEN 1 ELSE 0 END,
            `order` ASC
        ";

        $excluded_categories = $excluded_categories
            ->orderByRaw($orderBy)
            ->get();

        $categories = $categories
            ->orderByRaw($orderBy)
            ->get();
        /*Get and Set Margin Value*/
        $margin_value = 0;
        $margin_unit = SolarMitraHelper::getBusinessConfig('solar_installation_margin_unit');
        $project = $quotation->project;
        
        if (optional($project)->capacity_int < 4) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_1kw_3kw');
        }
        else if (optional($project)->capacity_int >= 4 && optional($project)->capacity_int <= 7) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_4kw_7kw');
        }
        else if (optional($project)->capacity_int >= 8 && optional($project)->capacity_int <= 15) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_8kw_15kw');
        }
        else if (optional($project)->capacity_int > 15) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_16kw_plus');
        }else {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0);
        }


        if ($request->ajax()) {
            return view('solarmitra::business.quotations.quotation_modal',compact('quotation','margin_value','margin_unit'));
        }

        return view('solarmitra::business.quotations.edit',compact('page_title','quotation','margin_value','margin_unit','categories','excluded_categories','project_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'title'  => 'required',
            'client_id'  => 'required',
            'business_id'  => 'required',
            'date'   => "nullable|before:valid_till_date",
            "valid_till_date"     => "nullable|after:date",
            "start_date"   => "nullable|before:end_date",
            "end_date"     => "nullable|after:start_date",
        ];

        
        $validationMsg = [
            'title.required' => __('solarmitra::solarmitra.title_required'),
            'client_id.required' => __('solarmitra::solarmitra.please_select_a_client'),
            'client_id.exists' => __('solarmitra::solarmitra.selected_client_does_not_exist'),
            'business_id.required' => __('solarmitra::solarmitra.please_select_a_business'),
            'business_id.exists' => __('solarmitra::solarmitra.selected_business_does_not_exist'),
            'date.before' => __('solarmitra::solarmitra.start_date_before_valid_till'),
            'valid_till_date.after' => __('solarmitra::solarmitra.valid_till_after_start'),
        ];

        $validator = \Validator::make($request->all(), $validation,$validationMsg);
            

        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
    
            $this->validate($request, $validation,$validationMsg);
        }
        
        $quotationObj = Quotation::findOrFail($id); 
        $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('quotation');

        if ($request->filled('project_id')) {
            $quotationObj->project_id       = $request->project_id; 
        }
        if ($request->filled('sub_total')) {
            $quotationObj->sub_total           = $request->sub_total; 
        }
        if ($request->filled('aditional_charges')) {
            $quotationObj->aditional_charges           = $request->aditional_charges; 
        }
        if ($request->filled('tax')) {
            $quotationObj->tax           = $request->tax; 
        }
        if ($request->filled('discount')) {
            $quotationObj->discount           = $request->discount; 
        }
        if ($request->filled('total_amount')) {
            $quotationObj->total_amount           = str_replace([',', ' '], '', $request->total_amount); 
        }
        if ($request->filled('date')) {
            $quotationObj->date             = $request->date; 
        }
        if ($request->filled('valid_till_date')) {
            $quotationObj->valid_till_date  = $request->valid_till_date;
        }
        if ($request->filled('status')) {
            $quotationObj->quotation_status_id           = $request->status;
        }
        if (!$quotationObj->created_by) {
            $quotationObj->created_by           = auth('business')->id();
        }

        if ($request->filled('margin_amount')) {
            $quotation->margin_amount           = $quotation->margin_amount ?: $request->margin_amount; 
        }
        $quotationObj->description          = $request->description; 
        $quotationObj->title                = $request->title ;
        $quotationObj->client_id            = $request->client_id; 
        $res = $quotationObj->save();

        $project = Project::find($request->project_id);

        if ($project) {

            if ($request->filled('project_type')) {
                $project->project_type = $request->project_type;
            }

            $project->is_solar_kit_project = $request->is_solar_kit_project ?? 0;

            if ($request->filled('total_amount')) {
                $project->project_value = str_replace([',', ' '], '', $request->total_amount);
            }
            if ($request->filled('capacity')) {
                [$capacity_int, $capacity_unit] = explode(' ', $request->capacity);
                $project->capacity          = $request->capacity; 
                $project->capacity_int      = $capacity_int; 
                $project->capacity_unit     = $capacity_unit; 
            }
            if ($request->filled('start_date')) {
                $project->start_date = $request->start_date;
            }
            if ($request->filled('end_date')) {
                $project->end_date = $request->end_date;
            }
            if ($request->filled('location')) {
                $project->location = $request->location;
            }

            $project->save();
        }
        
        if ($request->has('item')) {

            if ($quotationObj->id) {
                QuotationItem::where('quotation_id' , $quotationObj->id)->delete();
            }

             $items = collect($request->item)->filter(function ($row) {
                            return !empty($row['item_id']) && !empty($row['item_quantity']);
                        });

            foreach ($items as $row) {
                $material = MaterialLibrary::find($row['item_id']);
                
                $quotationItem = QuotationItem::firstOrNew([
                    'quotation_id' => $quotationObj->id,
                    'item_id'      => $row['item_id'],
                ]);

                $quotationItem->material_company_id     = $row['material_company_id'];
                $quotationItem->material_category_id    = @$material->material_category_id;
                $quotationItem->item_title              = @$material->title;
                $quotationItem->item_unit               = @$material->material_unit->title;
                $quotationItem->item_quantity           = $row['item_quantity'] ?? 1;
                $quotationItem->rates_per_units         = @$material->selling_price ?? 0;
                $quotationItem->gst                     = @$material->gst ?? 0;
                $quotationItem->discount                = $row['discount'] ?? null;
                $quotationItem->amount                  = $row['amount'] ?? null;
                $quotationItem->description             = @$material->description;

                $quotationItem->save();
            }
        }

        // Sync linked invoice items if quotation is already invoiced
        $linkedInvoice = Invoice::where('quotation_id', $quotationObj->id)->first();
        if ($linkedInvoice) {
            // Delete old invoice items
            InvoiceItem::where('invoice_id', $linkedInvoice->id)->delete();

            // Re-create from updated quotation items
            foreach ($items as $row) {
                $material = MaterialLibrary::find($row['item_id']);

                InvoiceItem::create([
                    'invoice_id'           => $linkedInvoice->id,
                    'item_id'              => $row['item_id'],
                    'material_company_id'  => $row['material_company_id'],
                    'material_category_id' => @$material->material_category_id,
                    'item_title'           => @$material->title,
                    'item_unit'            => @$material->material_unit->title,
                    'item_quantity'        => $row['item_quantity'] ?? 1,
                    'rates_per_units'      => @$material->selling_price ?? 0,
                    'gst'                  => @$material->gst ?? 0,
                    'discount'             => $row['discount'] ?? null,
                    'amount'               => $row['amount'] ?? null,
                    'description'          => @$material->description,
                ]);
            }

            // Sync invoice financials with quotation
            $linkedInvoice->sub_total         = $quotationObj->sub_total;
            $linkedInvoice->tax               = $quotationObj->tax;
            $linkedInvoice->aditional_charges = $quotationObj->aditional_charges;
            $linkedInvoice->discount          = $quotationObj->discount;
            $linkedInvoice->total_amount      = $quotationObj->total_amount;
            $linkedInvoice->due_amount        = max(0, $quotationObj->total_amount - $linkedInvoice->paid_amount);
            $linkedInvoice->save();
        }

        if ($linkedInvoice && $request->has('item')) {
            $quotationObj->quotation_status_id = 1; // Draft
            $quotationObj->save();
        }

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('QUOTATION-UQ', $quotationObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'close_modal' => true,
                    'message' => __('solarmitra::solarmitra.quotation_updated_text'),
                ]);
            }

            return redirect()->route('business.solarmitra.quotations.index')->with('success', __('solarmitra::solarmitra.quotation_updated_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $quotation = Quotation::with([
                'items',
                'status',
                'project.transactions.attachments',
                'project.addresses',
                'project.project_payments',
                'project.project_documents',
                'project.project_dates',
                'project.client_feedback',
                'project.project_assign',
                'project.project_attachments',
                'project.attachments',
            ])->findOrFail($id);

            if ($quotation->status->is_final) {
                return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_not_eligible_for_deletion'));
            }

            $project = $quotation->project;

            $quotation->items()->delete();

            // 2. Delete quotation
            $quotation->delete();

            // 3. Delete project and its related data
            if ($project) {
                // Direct children
                $project->addresses()->delete();
                $project->project_payments()->delete();
                $project->project_documents()->delete();
                $project->project_dates()->delete();
                $project->client_feedback()->delete();
                $project->project_assign()->delete();
                $project->project_attachments()->delete();

                // Pivot: solar_project_phases
                DB::table('solar_project_phases')->where('project_id', $project->id)->delete();

                // Project-level transactions and their attachments
                foreach ($project->transactions as $transaction) {
                    $transaction->attachments()->detach();
                }
                $project->transactions()->delete();

                // Project files from storage
                $folderPath = storage_path('app/public/solarmitra-attachments/business_' . app('currentBusinessId') . '/project_' . $project->id);
                if (\File::isDirectory($folderPath)) {
                    \File::deleteDirectory($folderPath);
                }

                // Project attachments from DB
                $project->attachments()->delete();

                // Delete project
                $project->delete();
            }

            // 4. Notification
            $notificationObj = new Notification();
            $notificationObj->notification_entry('QUOTATION-DQ', $id, auth('business')->id(), config('constants.superadmin'));

            DB::commit();

            return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_deleted_text'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('solarmitra::solarmitra.failed_to_delete') . $e->getMessage());
        }
    }

    public function confirm_quotation($id)
    {
        $quotation = Quotation::findOrFail($id);

        if ($quotation->status && !$quotation->status->is_final) {
            $quotation->update(['quotation_status_id'=> 5]);
            return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_confirmed'));
        }
        return redirect()->back()->with('success', __('solarmitra::solarmitra.quotation_confirmation_problem'));
        
    }

    public function convert_to_invoice(Request $request,$id)
    {
        try {

            DB::beginTransaction();

            $quotationObj = Quotation::where('business_id', app('currentBusinessId'))->findOrFail($id);

            if (!optional($quotationObj->status)->can_convert) {
                return redirect()->back()->with('warning', __('solarmitra::solarmitra.quotation_not_confirmed_for_invoice'));
            }

            if (Invoice::where('quotation_id', $quotationObj->id)->exists()) {
                $quotationObj->invoice_generated = 1;
                $quotationObj->save();
                DB::commit();
                return redirect()->back()->with('warning', __('solarmitra::solarmitra.quotation_invoice_already_exists'));
            }
            
            $newInvoiceNumber = SolarMitraHelper::generateDocumentNumber('invoice');
            $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('invoice');
            $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days', 7);

            $clientName = optional($quotationObj->client)->name ?? 'Unknown Client';
            $capacity   = optional($quotationObj->project)->capacity ?? '';
            $projectType = optional($quotationObj->project)->project_type ?? '';
            $invoiceTitle = $titlePrefix . $clientName;
            if ($capacity) $invoiceTitle .= ' - ' . $capacity;
            if ($projectType) $invoiceTitle .= ' - ' . $projectType;

            $InvoiceObj = New Invoice();
            $InvoiceObj->client_id          = $quotationObj->client_id; 
            $InvoiceObj->title              = $invoiceTitle;
            $InvoiceObj->quotation_id       = $quotationObj->id; 
            $InvoiceObj->project_id         = $quotationObj->project_id; 
            $InvoiceObj->business_id        = $quotationObj->business_id; 
            $InvoiceObj->due_amount         = $quotationObj->total_amount; 
            $InvoiceObj->paid_amount        = 0; 
            $InvoiceObj->invoice_number     = $newInvoiceNumber; 
            $InvoiceObj->date               = $quotationObj->date ?? Carbon::now()->format(config('solarmitra.date_time_format')); 
            $InvoiceObj->sub_total          = $quotationObj->sub_total; 
            $InvoiceObj->tax                = $quotationObj->tax; 
            $InvoiceObj->aditional_charges  = $quotationObj->aditional_charges; 
            $InvoiceObj->discount           = $quotationObj->discount; 
            $InvoiceObj->total_amount       = $quotationObj->total_amount; 
            $InvoiceObj->due_date           = $quotationObj->valid_till_date ?? Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format'));
            $InvoiceObj->status             = 1;
            $InvoiceObj->description        = $quotationObj->description;
            $res = $InvoiceObj->save();

            $quotationObj->invoice_generated = 1;
            $quotationObj->save();

            if ($quotationObj->items) {
                foreach ($quotationObj->items as $item) {

                    $invoiceItem = InvoiceItem::firstOrNew([
                        'invoice_id' => $InvoiceObj->id,
                        'item_id'      => $item->item_id,
                    ]);

                    $invoiceItem->material_company_id   = $item->material_company_id;
                    $invoiceItem->material_category_id  = $item->material_category_id;
                    $invoiceItem->item_title            = $item->item_title;
                    $invoiceItem->item_unit             = $item->item_unit;
                    $invoiceItem->item_quantity         = $item->item_quantity;
                    $invoiceItem->rates_per_units       = $item->rates_per_units;
                    $invoiceItem->gst                   = $item->gst;
                    $invoiceItem->discount              = $item->discount;
                    $invoiceItem->amount                = $item->amount;
                    $invoiceItem->description           = $item->description;

                    $invoiceItem->save();
                }
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('QUOTATION-CQTI', $quotationObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
            DB::commit();

            return redirect()->route('business.solarmitra.invoices.index')->with('success', __('solarmitra::solarmitra.invoice_created_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get_item_by_category(Request $request)
    {
        $materials = MaterialLibrary::where('material_category_id',$request->category_id)->get()->pluck('title','id')->toArray();
        
        $html = '<option value="">Select Item</option>';
        
        foreach ($materials as $key => $value) {
            $html .= '<option value="'.$key.'">'.$value.'</option>';
        }
        return $html;
    }

    public function get_brands_by_category(Request $request)
    {
        $companies = SolarMitraHelper::getCompaniesByCategoryArr($request->category_id);
        
        $html = '<option value="">Select Item</option>';
        
        foreach ($companies as $key => $value) {
            $html .= '<option value="'.$key.'">'.$value.'</option>';
        }
        return $html;
    }

    public function view_quotation($quotation_id)
    {
        if (!is_numeric($quotation_id)) {
            $quotation_id = \Crypt::decrypt($quotation_id);
        }
        $quotation = Quotation::findOrFail($quotation_id);
        $business = Business::findOrFail($quotation->business_id);

        $pdf = Pdf::loadview('solarmitra::business.quotations.pdf', compact('quotation','business'));
        
        return $pdf->stream('quotation_'.$quotation->id.'.pdf');
    }

    public function download_quotation($quotation_id)
    {
        if (!is_numeric($quotation_id)) {
            $quotation_id = \Crypt::decrypt($quotation_id);
        }
        $quotation = Quotation::findOrFail($quotation_id);
        $business = Business::findOrFail($quotation->business_id);

        $pdf = Pdf::loadview('solarmitra::business.quotations.pdf', compact('quotation','business'));
        
        /* comment this code to run */
        return $pdf->download('quotation_'.$quotation->id.'.pdf');
        
        $fileName = 'quotation_'.$quotation->id.'.pdf';
        $folderPath = 'public/solarmitra-attachments/business_'.$business->id.'/quotations';


        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        $filePath = $folderPath.'/'.$fileName;

        // Save PDF
        Storage::put($filePath, $pdf->output());
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('QUOTATION-DLQ', $quotation->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        // Download after saving
        return response()->download(storage_path('app/'.$filePath), $fileName);
    }
    public function share_quotation($quotation_id)
    {
        $quotation = Quotation::findOrFail($quotation_id);
        $business = Business::findOrFail(app('currentBusinessId'));

        return view('solarmitra::business.quotations.share_modal',compact('quotation','business'));
    }

    public function add_quotation_item(Request $request)
    {
        $material = MaterialLibrary::findOrFail($request->id);
        $length = $request->length;
        return $html = '
                <tr data-item="'.$material->id.'">
                    <td>
                        <span class="s-no-box">'.($length + 1).'</span>
                        <input type="hidden" name="item['.$length.'][item_id]" value="'.$material->id.'">
                        <input type="hidden" name="item['.$length.'][item_title]" value="'.$material->title.'">
                        <input type="hidden" name="item['.$length.'][item_unit]" value="'.$material->material_unit->title.'">
                        <input type="hidden" name="item['.$length.'][material_company_id]" value="'.$material->material_company_id.'">
                        <input type="hidden" name="item['.$length.'][material_category_id]" value="'.$material->material_category_id.'">
                        <input type="hidden" name="item['.$length.'][description]" value="'.$material->description.'">
                    </td>
                    <td>
                        '.$material->title.'
                    </td>
                    <td class="d-flex align-items-center gap-3">
                        <input name="item['.$length.'][item_quantity]" type="number" class="form-control-sm form-control quantity" min="1" value="1" >'.$material->material_unit->title.'
                    </td>
                    <td class="d-none">
                        <input name="item['.$length.'][rates_per_units]" type="number" class="form-control-sm form-control price" min="0" value="'.$material->selling_price.'" >
                    </td>
                    <td class="d-none">
                        <input name="item['.$length.'][gst]" type="number" class="form-control-sm form-control tax" min="0" max="100" value="'.$material->gst.'" >
                    </td>
                    <td class="d-none">
                        <input name="item['.$length.'][discount]" type="number" class="form-control-sm form-control discount" min="0" max="100" value="'.$material->discount.'" >
                    </td>
                    <td class="text-end">
                        <input type="hidden" class="item-total" name="item['.$length.'][amount]" value="'.$material->selling_price.'" >
                        <span class="total-text">'.$material->selling_price.'</span>
                    </td>
                    <td>
                        <button class="btn btn-outline-danger btn-sm rounded-circle RemoveQuotationItem">X</button>
                    </td>
                </tr>';
    }

    public function add_quotation_category(Request $request)
    {
        $material = MaterialLibrary::find($request->id);
        $category = MaterialCategory::find($material->material_category_id);
        $items = MaterialLibrary::where('material_company_id', $material->material_company_id)
            ->where('material_category_id', $material->material_category_id)
            ->get();

        $length = $request->row_length;
        $itemCount = $request->item_length;
        return view('solarmitra::business.quotations.ajax_add_quotation_category',compact('material','itemCount','length','category','items'));
    }


    public function ajax_quotation_addmore_item(Request $request)
    {
    
        $category_title = $request->title;
        $next_item_count = $request->nextItemCount;
        $category_id = $request->catId;
        $category_slug = $request->slug;

        return view('solarmitra::business.quotations.ajax_add_quotation_item',compact('category_title','next_item_count','category_id','category_slug'));

    }

    public function ajax_quotation_items(Request $request,$id=null)
    {
    
        $quotation = Quotation::find($id);
        $is_solar_kit_project = $request->boolean('is_solar_kit_project');
        $project_type = $request->project_type;
        
        if ($is_solar_kit_project) {
            $categories = MaterialCategory::where('display_on_invoice',1)->where('include_in_solar_kit','!=', 1)->orderBy('order', 'asc')->get();
        }else{
            $categories = MaterialCategory::where('display_on_invoice',1)->where('slug','!=','solar-kit')->orderBy('order', 'asc')->get();
        }

        return view('solarmitra::business.quotations.ajax_quotation_items',compact('quotation','categories','project_type'));

    }


    public function ajax_quotation_calculate(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);
        $itemsSubTotal = $request->items_subtotal;
        $itemsDiscount = $request->items_discount;
        $itemsTax = $request->items_tax;
        $orderTaxPercent = (float)($request->order_tax_percent ?? 0);
        $additionalDiscountPercent = (float)($request->additional_discount_percent ?? 0);
        $additionalCharges = (float)($request->additional_charges ?? 0);

        /*Get and Set Margin Value*/
        $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0);
        $capacity = !empty($request->solor_capacity) ? explode(' ', $request->solor_capacity)[0] : optional($quotation->project)->capacity_int;
        $margin_unit = SolarMitraHelper::getBusinessConfig('solar_installation_margin_unit','Fix');
        
        if ($capacity < 4) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_1kw_3kw',$margin_value);
        }
        else if ($capacity >= 4 && $capacity <= 7) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_4kw_7kw',$margin_value);
        }
        else if ($capacity >= 8 && $capacity <= 15) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_8kw_15kw',$margin_value);
        }
        else if ($capacity > 15) {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_for_16kw_plus',$margin_value);
        }else {
            $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0);
        }

        if ($margin_unit && $margin_unit == '%' && !empty($margin_value)) {
            $margin_value = ($itemsSubTotal * ($margin_value / 100));
            $itemsSubTotal = $itemsSubTotal + ($quotation->margin_amount ?? $margin_value);
        }
        else if($margin_unit && $margin_unit == 'Fix' && $margin_value){
            $itemsSubTotal = $itemsSubTotal + ($quotation->margin_amount ?? $margin_value);
        }
        
        //  B = itemIncludedTax 
        $itemIncludedTax = $itemsSubTotal + $itemsTax;
        $netSubtotal = $itemIncludedTax;


        // Additional Discount on Net Subtotal
        if (SolarMitraHelper::getBusinessConfig('discount_type', '%') === '%') {
            $additionalDiscountAmount = $netSubtotal * ($additionalDiscountPercent / 100);
        }elseif (SolarMitraHelper::getBusinessConfig('discount_type', 'fixed') === 'fixed') {
            $additionalDiscountAmount = $additionalDiscountPercent;
        }
        
        $afterDiscountAmount = $netSubtotal - $additionalDiscountAmount;
         // B = $totalAmount After Aditional Charges ()
        
        $totalAmount = $afterDiscountAmount + $additionalCharges;

        // B = B1 (8.9%) + B2 (Remaining) 
        $B2AmountExceptTotalAmount = 0 ;
        $B1fetch89Percent = $totalAmount * (8.9/ 100);
        $B2AmountExceptTotalAmount = $totalAmount - $B1fetch89Percent;

        // Order Tax (AFTER discount & charges)
        $orderTaxAmount = $totalAmount * ($orderTaxPercent / 100);

        if ($totalAmount < 0) $totalAmount = 0;

        $items_sub_total = SolarMitraHelper::format_number($itemsSubTotal);
        $items_discount = SolarMitraHelper::format_number($itemsDiscount);
        $items_tax = SolarMitraHelper::format_number($itemsTax);
        $net_subtotal = SolarMitraHelper::format_number($netSubtotal);
        $order_tax_amount = SolarMitraHelper::format_number($orderTaxAmount);
        $total_amount = SolarMitraHelper::format_number($totalAmount);

        $subtotal_val = round($netSubtotal, 2);
        $total_val = round($totalAmount, 2);

        return response()->json([
            'status' => true,
            'html' => view('solarmitra::business.quotations.ajax_quotation_calculate',compact('items_sub_total','subtotal_val','items_discount','items_tax','net_subtotal','order_tax_amount','total_val','total_amount','margin_value','B2AmountExceptTotalAmount'))->render()
        ]);
    }

}
