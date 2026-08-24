<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\Transaction;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\ProjectDocument;
use Modules\SolarMitra\App\Models\ProjectDate;
use Modules\SolarMitra\App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\ClientFeedback;
use Modules\SolarMitra\App\Models\ProjectAssign;
use Modules\SolarMitra\App\Models\ProjectPayment;
use Modules\SolarMitra\App\Models\QuotationItem;
use Modules\SolarMitra\App\Models\ProjectAttachment;
use Modules\SolarMitra\App\Models\MaterialCategory;
use Modules\SolarMitra\App\Models\ProjectPhase;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request,$id)
    {
        $page_title = __('solarmitra::solarmitra.projects') . ' ' . __('solarmitra::solarmitra.dashboard');


        /* Project Details Start */
        $project = Project::find($id); 
        $project_phases = ProjectPhase::get()->pluck('title','id')->toArray(); 
        
        /* Transactions */
        $project_transactions = Transaction::with('sender','receiver','transaction_type')
            ->where('project_id',$id)
            ->get();

        /* Invoices */
        $project_invoices = Invoice::where('project_id',$id)->get();

        /* Payment Overdue */
        $payment_overdue = max(
            $project->project_value - $project_transactions->where('transfer_type', 'cr')->sum('amount'),
            0
        );
        
        /* Project Timeline */
        $start = Carbon::createFromFormat(config('solarmitra.date_time_format'),$project->start_date)->startOfDay();
        $end = ($project->end_date ? Carbon::createFromFormat(config('solarmitra.date_time_format'),$project->end_date) : now())->startOfDay();
        $project_timeline = (int) $start->diffInDays($end);
        
        /* Project Documents */
        $project_documents = $project->project_documents;
        $project_documents_fields = [
            "electricity_bill",
            "adhar_card",
            "adhar_card_backside",
            "pancard",
            "bank_passbook",
            "property_patta_evidence",
            "noc_name_transfer",
            "netmeter_photo",
            "netmeter_plant_photo"
        ];

        /* Project Details End */

        return view('solarmitra::business.projects.dashboard',compact('page_title','project','project_transactions','project_invoices','payment_overdue','project_timeline','project_documents','project_documents_fields','project_phases') );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resultQuery = Project::with('project_documents')->where('business_id',app('currentBusinessId'))
            ->whereNot('status',config('solarmitra.projects_status_keys.Archived'))
            ->when(!empty($request->title),function($q)use($request){
                $q->where('title','Like','%'.$request->title.'%');
            })
            ->when(!empty($request->client_id),function($q)use($request){
                $q->where('client_id',$request->client_id);
            })
            ->when(!empty($request->status) && !empty(array_filter($request->status)) && is_array($request->status),function($q)use($request){
                $q->whereIn('status',$request->status);
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
            $resultQuery->orderBy($column, $direction);

        $projects = $resultQuery->paginate(config('Reading.nodes_per_page'));
        
        $page_title = __('solarmitra::solarmitra.projects');
        return view('solarmitra::business.projects.index',compact('page_title','projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $page_title = __('solarmitra::solarmitra.create').' '. __('solarmitra::solarmitra.project');
        $categories = MaterialCategory::where('display_on_invoice',1)->whereNot('slug','solar-kit')->orderBy('order', 'asc')->get();

        if ($request->ajax()) {
            return view('solarmitra::business.projects.project_modal',compact('page_title','categories') );
        }

        return view('solarmitra::business.projects.create',compact('page_title','categories') );
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validation = [
            'title'        => 'required',
            'client_id'  => 'required',
            'capacity'  => 'required',
            'project_type'  => 'required',
            'location'  => 'required',
            'start_date'   => "required|before:end_date",
            'end_date'     => "required|after:start_date",
            'site_photo' => 'nullable|array|max:6',
            'site_photo.*' => 'image|max:5120',
        ];

        $messages = [
            'title.required' => __('solarmitra::solarmitra.project_title_required'),
            'client_id.required' => __('solarmitra::solarmitra.please_select_client'),
            'capacity.required' => __('solarmitra::solarmitra.project_capacity_required'),
            'project_type.required' => __('solarmitra::solarmitra.project_type_required'),
            'location.required' => __('solarmitra::solarmitra.project_location_required'),
            'start_date.required' => __('solarmitra::solarmitra.start_date_required'),
            'start_date.before' => __('solarmitra::solarmitra.start_date_before_end_date'),
            'start_date.date' => __('solarmitra::solarmitra.start_date_valid'),
            'end_date.required' => __('solarmitra::solarmitra.end_date_required'),
            'end_date.after' => __('solarmitra::solarmitra.end_date_after_start_date'),
            'end_date.date' => __('solarmitra::solarmitra.end_date_valid'),
            'site_photo.array' => __('solarmitra::solarmitra.site_photos_must_be_array'),
            'site_photo.max' => __('solarmitra::solarmitra.site_photos_max_6'),
            'site_photo.*.image' => __('solarmitra::solarmitra.each_file_must_be_image'),
            'site_photo.*.max' => __('solarmitra::solarmitra.each_image_max_5mb'),
        ];

        $this->validate($request, $validation,$messages);

        $itemIds = array_filter(array_column(array_values($request->item), 'item_id'));
        $items = collect($request->item)->filter(function ($row) {
                    return !empty($row['item_id']) && !empty($row['item_quantity']);
                });
        
        [$capacity_int, $capacity_unit] = explode(' ', $request->capacity);

        $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0);
        $capacity = $capacity_int ?? 0;
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

        $project_value = 0;
        if ($margin_unit && $margin_unit == '%' && !empty($margin_value)) {
            $project_value = ($items->sum('amount') + ($items->sum('amount') * ($margin_value / 100)));
        }
        else if($margin_unit && $margin_unit == 'Fix' && $margin_value){
            $project_value = $items->sum('amount') + $margin_value;
        }
        else{
            if ($request->item) {
                $project_value = $items->sum('amount');
            }
        }
        
        /*----------Project---------*/
        $projectObj                         = new Project(); 
        $projectObj->business_id            = app('currentBusinessId'); 
        $projectObj->title                  = Project::getUniqueTitle($request->title); 
        $projectObj->client_id              = $request->client_id;
        $projectObj->start_date             = $request->input('start_date');
        $projectObj->end_date               = $request->input('end_date');
        $projectObj->capacity_int           = $capacity_int; 
        $projectObj->capacity_unit          = $capacity_unit; 
        $projectObj->capacity               = $request->capacity; 
        $projectObj->project_type           = $request->project_type;
        $projectObj->is_solar_kit_project   = $request->is_solar_kit_project ?? 0; 
        $projectObj->project_value          = $request->project_value ?? $project_value; 
        $projectObj->change_note            = '[' . now() . '] Project Created with Quotation By '.auth()->user()->full_name; 
        $projectObj->location               = $request->location; 
        $projectObj->status                 = $request->status ?? 1; // Draft 
        $projectObj->description            = $request->description;
        $projectObj->save();
        

        $AttachmentObj = New Attachment();
        if ($request->hasFile('site_photo')) {
            $attachment_ids = $AttachmentObj->InsertAttachments($request,'site_photo',$projectObj->id);

            foreach ($attachment_ids as $attachment_id) {
                ProjectAttachment::create(['project_id'=>$projectObj->id,'attachment_id'=>$attachment_id,'user_id'=>auth('business')->id(),'type'=>1]);
            }
        }

        /*----------ProjectPayment---------*/
        if ($request->amount) {
            ProjectPayment::create(['project_id'=>$projectObj->id,'amount'=>$request->amount,'remark'=>1,'status'=>$request->payment_status]);
        }

        /*----------Quotation---------*/
        $newQuotationNumber = SolarMitraHelper::generateDocumentNumber('quotation');
        $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('quotation');
        $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days', 7);

        $quotationObj = new Quotation(); 
        $quotationObj->business_id      = app('currentBusinessId'); 
        $quotationObj->project_id       = @$projectObj->id ?? 0; 
        $quotationObj->title            = str_contains($request->quotation_title, $titlePrefix) ? $request->quotation_title : $titlePrefix . $request->quotation_title;
        $quotationObj->quotation_number = $newQuotationNumber; 
        $quotationObj->client_id        = $request->client_id ?? 0; 
        $quotationObj->date             = $request->date ?? Carbon::now()->format(config('solarmitra.date_time_format')); 
        $quotationObj->valid_till_date  = $request->valid_till_date ?? Carbon::now()->addDays(7)->format(config('solarmitra.date_time_format'));
        $quotationObj->quotation_status_id           = $request->status ?? 1; 
        $quotationObj->created_by           = auth('business')->id(); 

        $quotationObj->sub_total        = @$items->sum('amount') ?? 0; 
        $quotationObj->total_amount     = $project_value ?? 0; 
        $quotationObj->save();


        if ($request->item) {

            if ($quotationObj->id) {
                QuotationItem::where('quotation_id' , $quotationObj->id)->delete();
            }

            foreach ($items as $row) {
                $material = MaterialLibrary::find($row['item_id']);
                
                $quotationItem = QuotationItem::firstOrNew([
                    'quotation_id' => $quotationObj->id,
                    'item_id'      => $row['item_id'],
                ]);

                $quotationItem->material_company_id     = $row['material_company_id'];
                $quotationItem->material_category_id    = $material->material_category_id;
                $quotationItem->item_title              = $material->title;
                $quotationItem->item_unit               = $material->material_unit->title;
                $quotationItem->item_quantity           = $row['item_quantity'] ?? 1;
                $quotationItem->rates_per_units         = $material->selling_price ?? 0;
                $quotationItem->gst                     = $material->gst ?? 0;
                $quotationItem->discount                = $row['discount'] ?? null;
                $quotationItem->amount                  = $row['amount'] ?? null;
                $quotationItem->description             = $material->description ?? null;

                $quotationItem->save();
            }
        }

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('PROJECT-ANP', $projectObj->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        if ($request->ajax()) 
        {
            return response()->json([
                'status' => true,
                'message' => __('solarmitra::solarmitra.project_added_text'),
                'redirect' => route('business.solarmitra.projects.edit', $projectObj->id)
            ]);
        }

        return redirect()->route('business.solarmitra.projects.index')->with('success', __('solarmitra::solarmitra.project_added_text'));

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
    public function edit(Request $request,$project_id)
    {
        $page_title = __('solarmitra::solarmitra.edit').' '.__('solarmitra::solarmitra.project');
        $project = Project::findOrFail($project_id);
        $quotation = Quotation::where('project_id',$project_id)->first();
        $project_type = $project->project_type;
        if ($project->is_solar_kit_project) {
            $categories = MaterialCategory::where('display_on_invoice',1)->where('include_in_solar_kit','!=', 1)->orderBy('order', 'asc')->get();
        }else{
            $categories = MaterialCategory::where('display_on_invoice',1)->whereNot('slug','solar-kit')->orderBy('order', 'asc')->get();
        }
        
        if ($request->ajax()) {

        }

        return view('solarmitra::business.projects.edit',compact('page_title','project','project_id','quotation','categories','project_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $project_id)
    {
        
        $validation = [
            'title'        => 'required',
            'client_id'  => 'required',
            'capacity'  => 'required',
            'project_type'  => 'required',
            'location'  => 'required',
            'start_date'   => "required|before:end_date",
            'end_date'     => "required|after:start_date",
            'site_photo' => 'nullable|array|max:6',
            'site_photo.*' => 'image|max:5120',
        ];

        $messages = [
            'title.required' => __('solarmitra::solarmitra.project_title_required'),
            'client_id.required' => __('solarmitra::solarmitra.please_select_client'),
            'capacity.required' => __('solarmitra::solarmitra.project_capacity_required'),
            'project_type.required' => __('solarmitra::solarmitra.project_type_required'),
            'location.required' => __('solarmitra::solarmitra.project_location_required'),
            'start_date.required' => __('solarmitra::solarmitra.start_date_required'),
            'start_date.date' => __('solarmitra::solarmitra.start_date_valid'),
            'start_date.before' => __('solarmitra::solarmitra.start_date_before_end_date'),
            'end_date.required' => __('solarmitra::solarmitra.end_date_required'),
            'end_date.date' => __('solarmitra::solarmitra.end_date_valid'),
            'end_date.after' => __('solarmitra::solarmitra.end_date_after_start_date'),
            'site_photo.array' => __('solarmitra::solarmitra.site_photos_must_be_array'),
            'site_photo.max' => __('solarmitra::solarmitra.site_photos_max_6'),
            'site_photo.*.image' => __('solarmitra::solarmitra.each_file_must_be_image'),
            'site_photo.*.max' => __('solarmitra::solarmitra.each_image_max_5mb'),
        ];
        
        $this->validate($request, $validation,$messages);

        if ($request->item) {
            $itemIds = array_filter(array_column(array_values($request->item), 'item_id'));
            $items = collect($request->item)->filter(function ($row) {
                        return !empty($row['item_id']) && !empty($row['item_quantity']);
                    });
        }

        [$capacity_int, $capacity_unit] = explode(' ', $request->capacity);

        $margin_value = SolarMitraHelper::getBusinessConfig('solar_installation_margin_value',0);
        $capacity = $capacity_int ?? 0;
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

        $project_value = 0;
        if ($request->item && $margin_unit && $margin_unit == '%' && !empty($margin_value)) {
            $project_value = ($items->sum('amount') + ($items->sum('amount') * ($margin_value / 100)));
        }
        else if($request->item && $margin_unit && $margin_unit == 'Fix' && $margin_value){
            $project_value = $items->sum('amount') + $margin_value;
        }
        else{
            if ($request->item) {
                $project_value = $items->sum('amount');
            }
        }

        /*----------Project---------*/
        $projectObj                 = Project::findOrFail($project_id); 
        $projectObj->title          = Project::getUniqueTitle($request->title,$project_id); 
        $projectObj->client_id      = $request->client_id;
        $projectObj->start_date     = $request->start_date;
        $projectObj->end_date       = $request->input('end_date');
        $projectObj->capacity       = $request->capacity; 
        $projectObj->capacity_int   = $capacity_int; 
        $projectObj->capacity_unit  = $capacity_unit; 
        $projectObj->project_type   = $request->project_type;
        $projectObj->is_solar_kit_project     = $request->is_solar_kit_project ?? 0; 
        $projectObj->change_note    .= PHP_EOL . '[' . now() . '] Project Updated By '.auth('business')->user()->full_name; 
        $projectObj->location       = $request->location; 
        $projectObj->status         = $request->status ?? 1; // Draft 
        $projectObj->description    = $request->description;
        $projectObj->project_value  = $request->project_value ?? $project_value; 
        $projectObj->save();

        $AttachmentObj = New Attachment();
        if ($request->hasFile('site_photo')) {
            $attachment_ids = $AttachmentObj->InsertAttachments($request,'site_photo',$project_id);

            foreach ($attachment_ids as $attachment_id) {
                ProjectAttachment::create(['project_id'=>$project_id,'attachment_id'=>$attachment_id,'user_id'=>auth('business')->id(),'type'=>1]);
            }
        }

        /*----------ProjectPayment---------*/
        $projectPayment = ProjectPayment::firstOrNew([
            'project_id' => $project_id,
            'remark'=>1
        ]); 
        $projectPayment->amount = $request->amount ?? 0;
        $projectPayment->status = $request->payment_status ?? 1;
        $projectPayment->save();

        $quotation = Quotation::where('project_id',$project_id)->firstOrFail();

        if ($request->item) {

            if ($quotation->id) {
                QuotationItem::where('quotation_id' , $quotation->id)->delete();
            }
            
            foreach ($items as $row) {
                $material = MaterialLibrary::find($row['item_id']);

                
                $quotationItem = QuotationItem::firstOrNew([
                    'quotation_id' => $quotation->id,
                    'item_id'      => $row['item_id'],
                ]);

                $quotationItem->material_company_id     = $row['material_company_id'];
                $quotationItem->material_category_id    = $material->material_category_id;
                $quotationItem->item_title              = $material->title;
                $quotationItem->item_unit               = $material->material_unit->title;
                $quotationItem->item_quantity           = $row['item_quantity'] ?? 1;
                $quotationItem->rates_per_units         = $material->selling_price ?? 0;
                $quotationItem->gst                     = $material->gst ?? 0;
                $quotationItem->discount                = $row['discount'] ?? null;
                $quotationItem->amount                  = $row['amount'] ?? null;
                $quotationItem->description             = $material->description ?? null;

                $quotationItem->save();
            }
        }

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('PROJECT-UP', $projectObj->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        if(request()->ajax()){
            return [
                'status' => true,
                'message' =>  __('solarmitra::solarmitra.project_updated_text'),
                'html'    => view('solarmitra::business.elements.projects.form2',["project" => $projectObj])->render()
            ];
        }

        return redirect()->route('business.solarmitra.projects.index')->with('success', __('solarmitra::solarmitra.project_updated_text'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $project = Project::findOrFail($id);

        /* Send Event Notification */
        /*$notificationObj        = new Notification();
        $notificationObj->notification_entry('PROJECT-DP', $project->id, auth('business')->id(), config('constants.superadmin'));*/
        /* End Send Event Notification */

        /* Currently commented to delete all data of project*/
        /*$project->change_note .= PHP_EOL . '[' . now() . '] Moved to Archived from Status:[' . config('solarmitra.projects_status.'.$project->status)."] By ".auth('business')->user()->full_name; 

        $project->status = config('solarmitra.projects_status_keys.Archived'); 
        $project->save();*/

        DB::beginTransaction();

        try {
            $project = Project::with([
                'quotation.items',
                'addresses',
                'project_payments',
                'project_documents',
                'project_dates',
                'client_feedback',
                'project_assign',
                'project_attachments',
                'transactions.attachments',
                'attachments',
            ])->findOrFail($id);

            // 1. Delete invoices + items
            $invoices = Invoice::where('project_id', $project->id)->get();
            foreach ($invoices as $invoice) {
                $invoice->items()->delete();
                $invoice->delete();
            }

            // 2. Delete quotation + items
            if ($project->quotation) {
                $project->quotation->items()->delete();
                $project->quotation->delete();
            }

            // 3. Delete project relationships
            $project->addresses()->delete();
            $project->project_payments()->delete();
            $project->project_documents()->delete();
            $project->project_dates()->delete();
            $project->client_feedback()->delete();
            $project->project_assign()->delete();
            $project->project_attachments()->delete();

            // 4. Delete pivot table
            DB::table('solar_project_phases')->where('project_id', $project->id)->delete();

            // 5. Delete transactions + detach pivot attachments
            foreach ($project->transactions as $transaction) {
                $transaction->attachments()->detach();
            }
            $project->transactions()->delete();

            // 6. Delete disk files
            $folderPath = storage_path('app/public/solarmitra-attachments/business_' . app('currentBusinessId') . '/project_' . $project->id);
            if (\File::isDirectory($folderPath)) {
                \File::deleteDirectory($folderPath);
            }

            // 7. Delete attachments
            $project->attachments()->delete();

            // 8. Delete project
            $project->delete();

            // 9. Notification
            $notificationObj = new Notification();
            $notificationObj->notification_entry('PROJECT-DP', $id, auth('business')->id(), config('constants.superadmin'));

            DB::commit();

            return redirect()->back()->with('success', __('solarmitra::solarmitra.project_deleted_text'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('solarmitra::solarmitra.failed_to_delete') . ' ' . $e->getMessage());
        }


        return redirect()->back()->with('success', __('solarmitra::solarmitra.project_deleted_text'));
    }

    /**
     * Remove the Document attachment id from project_documents table.
     */
    public function remove_document($doc_type,$project_id)
    {
        $projectDocumentObj = ProjectDocument::firstOrNew([
            'project_id' => $project_id,
        ]);

        $attachment = New Attachment;
        $attachment->DeleteAttachment($projectDocumentObj->$doc_type,$project_id);

        $projectDocumentObj->$doc_type = null;
        $projectDocumentObj->save();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.document_removed_text'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove_project_attachment($project_attachment_id=null)
    {
        if(!$project_attachment_id) {
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
        };
        $projectAttachmentObj = ProjectAttachment::findOrFail($project_attachment_id);

        $attachment = New Attachment;
        $attachment->DeleteAttachment($projectAttachmentObj->attachment_id,$projectAttachmentObj->project_id);

        $projectAttachmentObj->delete();

        if (request()->ajax()) {
            return response()->json(['res' => true]);
        }

        return redirect()->back()->with('success', __('solarmitra::solarmitra.document_removed_text'));
    }


    /**
     * Show the form for project documents.
     */
    public function documents(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {
            
            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);

            $validation = [
                'electricity_bill' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'selected_subsidy_type' => 'required_if:government_subsidy,1',
                'adhar_card'       => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'adhar_card_backside'       => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'bank_passbook'     => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'pancard'           => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'name_correction_new_name'=> 'nullable|string|max:255',
                'noc_name_transfer'       => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'property_patta_evidence' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            ];

            $messages = [
                'electricity_bill.image' => __('solarmitra::solarmitra.electricity_bill_image'),
                'electricity_bill.max' => __('solarmitra::solarmitra.electricity_bill_max'),
                
                'adhar_card.image' => __('solarmitra::solarmitra.adhar_card_image'),
                'adhar_card.max' => __('solarmitra::solarmitra.adhar_card_max'),
                
                'adhar_card_backside.image' => __('solarmitra::solarmitra.adhar_card_backside_image'),
                'adhar_card_backside.max' => __('solarmitra::solarmitra.adhar_card_backside_max'),
                
                'bank_passbook.image' => __('solarmitra::solarmitra.bank_passbook_image'),
                'bank_passbook.max' => __('solarmitra::solarmitra.bank_passbook_max'),
                
                'pancard.image' => __('solarmitra::solarmitra.pancard_image'),
                'pancard.max' => __('solarmitra::solarmitra.pancard_max'),
            ];

            $this->validate($request, $validation,$messages);
            $AttachmentObj = New Attachment();

            /* Set electricity_bill status to 0 if image uploaded again */
            if ($request->hasFile('electricity_bill')) {
                $projectDocumentObj->electricity_bill                   = $AttachmentObj->InsertAttachments($request,'electricity_bill',$project_id);
                $projectDocumentObj->electricity_bill_verification_status   = 0;
            }

            /* Set adhar_card status to 0 if image uploaded again */
            if ($request->hasFile('adhar_card')) {
                $projectDocumentObj->adhar_card                         = $AttachmentObj->InsertAttachments($request,'adhar_card',$project_id);
                $projectDocumentObj->adhar_card_verification_status         = 0;
            }

            /* Set adhar_card_backside status to 0 if image uploaded again */
            if ($request->hasFile('adhar_card_backside')) {
                $projectDocumentObj->adhar_card_backside                         = $AttachmentObj->InsertAttachments($request,'adhar_card_backside',$project_id);
                $projectDocumentObj->adhar_card_verification_status         = 0;
            }

            $projectDocumentObj->government_subsidy                     = $request->government_subsidy ?? 0;
            $projectDocumentObj->selected_subsidy_type                  = $request->selected_subsidy_type ?? 3;

            /* Set Passbook status to 0 if image uploaded again */
            if ($request->hasFile('bank_passbook')) {
                $projectDocumentObj->bank_passbook                      = $AttachmentObj->InsertAttachments($request,'bank_passbook',$project_id);
                $projectDocumentObj->bank_passbook_verification_status      = 0;
            }

            /* Set Passbook status to 0 if image uploaded again */
            if ($request->hasFile('pancard')) {
                $projectDocumentObj->pancard                            = $AttachmentObj->InsertAttachments($request,'pancard',$project_id);
                $projectDocumentObj->pancard_verification_status            = 0;
            }

            /* Set name_correction status to 0 if New name is filled (check with matching to old) */
            $projectDocumentObj->name_correction_new_name               = $request->name_correction_new_name;
            if ($projectDocumentObj->name_correction_new_name == $request->name_correction_new_name) {
                $projectDocumentObj->name_correction_new_name_status    = 0;
            }

            if ($request->hasFile('noc_name_transfer')) {
                $projectDocumentObj->noc_name_transfer                  = $AttachmentObj->InsertAttachments($request,'noc_name_transfer',$project_id);
                $projectDocumentObj->noc_name_transfer_status               = 0;
            }

            if ($request->hasFile('property_patta_evidence')) {
                $projectDocumentObj->property_patta_evidence            = $AttachmentObj->InsertAttachments($request,'property_patta_evidence',$project_id);
                $projectDocumentObj->property_patta_evidence_verification_status = 0;
            }

            $projectDocumentObj->save();
            SolarMitraHelper::getProjectStep($project_id);
            $projectObj  = Project::findOrFail($project_id); 

            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.documents_updated_successfully'),
                    'html' => view('solarmitra::business.elements.projects.document-wizard',["project" => $projectObj,"project_documents" => $projectDocumentObj])->render()
                ];
            }

            $nextStep = $this->getNextProjectStep('documents');

            return redirect()->route('business.solarmitra.projects.' . $nextStep, $project_id)->with('success', __('solarmitra::solarmitra.documents_updated_successfully'));

        }

        $project = Project::findOrFail($project_id);
        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.documents');

        return view('solarmitra::business.projects.documents',compact('page_title','project','project_id','project_documents') );
    }


    /**
     * Show the form for project verification.
     */
    public function verification(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {


            $validation = [

            ];

            $validationMsg = [
                'electricity_bill_verification_status.required' => __('solarmitra::solarmitra.electricity_bill_verification_required'),
                'adhar_card_verification_status.required' => __('solarmitra::solarmitra.adhar_card_verification_required'),
                'pancard_verification_status.required_if' => __('solarmitra::solarmitra.pancard_verification_required'),
                'bank_passbook_verification_status.required_if' => __('solarmitra::solarmitra.bank_passbook_verification_required'),
            ];


            $this->validate($request, $validation,$validationMsg);
            
            $projectObj = Project::findOrFail($project_id);

            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);

            $projectDateObj = ProjectDate::firstOrNew([
                'project_id' => $project_id,
            ]);
            $projectDateObj->document_varify_date = Carbon::now();

            if ($projectDocumentObj->noc_name_transfer_status != $request->noc_name_transfer_status) {
                $projectDateObj->name_transfer_date = Carbon::now();
            }
            if ($projectDocumentObj->name_correction_new_name_status != $request->name_correction_new_name_status) {
                $projectDateObj->name_correction_date = Carbon::now();
            }
            $projectDateObj->save();

            $projectDocumentObj->electricity_bill_verification_status           = $request->electricity_bill_verification_status;
            $projectDocumentObj->adhar_card_verification_status                 = $request->adhar_card_verification_status;
            $projectDocumentObj->bank_passbook_verification_status              = $request->bank_passbook_verification_status;
            $projectDocumentObj->pancard_verification_status                    = $request->pancard_verification_status;
            $projectDocumentObj->name_correction_new_name_status                = $request->name_correction_new_name_status;
            $projectDocumentObj->noc_name_transfer_status                       = $request->noc_name_transfer_status;
            $projectDocumentObj->property_patta_evidence_verification_status    = $request->property_patta_evidence_verification_status;
            $projectDocumentObj->save();
            
            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.verification_updated_successfully'),
                    'html' => view('solarmitra::business.elements.projects.document-wizard',["project" => $projectObj,"project_documents" => $projectDocumentObj])->render(),
                    'close_modal' => true,
                ];
            }
            
            if (!empty($projectDocumentObj->government_subsidy)) {
                return redirect()->route('business.solarmitra.projects.subsidy',$project_id)->with('success', __('solarmitra::solarmitra.verification_updated_successfully'));
            }

            $nextStep = $this->getNextProjectStep('verification');

            return redirect()->route('business.solarmitra.projects.' . $nextStep, $project_id)->with('success', __('solarmitra::solarmitra.verification_updated_successfully'));

        }
        $project = Project::findOrFail($project_id);
        if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
            return redirect()->route('business.solarmitra.projects.documents', $project_id)->with('warning', __('solarmitra::solarmitra.please_complete_documents_first'));
        }

        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.verification');
        return view('solarmitra::business.projects.verification',compact('page_title','project','project_id','project_documents') );
    }
    
    /**
     * Show the form for project subsidy.
     */
    public function subsidy(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {

            $validation = [

            ];

            $messages = [
                'subsidi_registration_status.required' => __('solarmitra::solarmitra.subsidy_registration_required'),
                'loan_doc_submit_status.required' => __('solarmitra::solarmitra.loan_doc_submission_required'),
                'bank_verification_status.required' => __('solarmitra::solarmitra.bank_verification_required'),
                'loan_disberment_status.required' => __('solarmitra::solarmitra.loan_disbursement_required'),
            ];

            $this->validate($request, $validation,$messages);

            $projectObj = Project::findOrFail($project_id);
            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);

            $projectDateObj = ProjectDate::firstOrNew([
                'project_id' => $project_id,
            ]);
            
            if ($projectDocumentObj->subsidi_registration_status != $request->subsidi_registration_status) {
                $projectDateObj->subsidi_registration_date = Carbon::now();
            }
            if ($projectDocumentObj->loan_doc_submit_status != $request->loan_doc_submit_status) {
                $projectDateObj->loan_doc_submit_date = Carbon::now();
            }
            if ($projectDocumentObj->bank_verification_status != $request->bank_verification_status) {
                $projectDateObj->bank_verification_date = Carbon::now();
            }
            if ($projectDocumentObj->loan_disberment_status != $request->loan_disberment_status) {
                $projectDateObj->loan_disberment_date = Carbon::now();
            }

            $projectDateObj->save();

            $projectDocumentObj->subsidi_registration_status    = $request->subsidi_registration_status;
            $projectDocumentObj->loan_doc_submit_status         = $request->loan_doc_submit_status;
            $projectDocumentObj->bank_verification_status       = $request->bank_verification_status;
            $projectDocumentObj->loan_disberment_status         = $request->loan_disberment_status;
            $projectDocumentObj->save();

            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.subsidy_updated_successfully'),
                    'html' => view('solarmitra::business.elements.projects.document-wizard',["project" => $projectObj,"project_documents" => $projectDocumentObj])->render(),
                    'close_modal' => true,
                ];
            }

            $nextStep = $this->getNextProjectStep('subsidy');

            return redirect()->route('business.solarmitra.projects.' . $nextStep, $project_id)->with('success', __('solarmitra::solarmitra.subsidy_updated_successfully'));

        }
        $project = Project::findOrFail($project_id);
        if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
            return redirect()->route('business.solarmitra.projects.documents', $project_id)->with('warning', __('solarmitra::solarmitra.please_complete_documents_first'));
        }
        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        $project_dates = ProjectDate::where('project_id',$project_id)->first();
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.subsidy');
        return view('solarmitra::business.projects.subsidy',compact('page_title','project','project_id','project_documents','project_dates') );
    }
    
    /**
     * Show the form for project structure.
     */
    public function structure(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {

            $validation = [

            ];

            $messages = [
                'panel_work_status.required' => __('solarmitra::solarmitra.panel_work_status_required'),
                'cabling_work_status.required' => __('solarmitra::solarmitra.cabling_work_status_required'),
                'civil_work_status.required' => __('solarmitra::solarmitra.civil_work_status_required'),
            ];

            $this->validate($request, $validation,$messages);

            $projectObj = Project::findOrFail($project_id);
            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);

            $projectDateObj = ProjectDate::firstOrNew([
                'project_id' => $project_id,
            ]);
            
            if ($projectDocumentObj->panel_work_status != $request->panel_work_status) {
                $projectDateObj->panel_work_date = Carbon::now();
            }
            if ($projectDocumentObj->cabling_work_status != $request->cabling_work_status) {
                $projectDateObj->cabling_work_date = Carbon::now();
            }
            if ($projectDocumentObj->civil_work_status != $request->civil_work_status) {
                $projectDateObj->civil_work_date = Carbon::now();
            }

            $projectDocumentObj->structure_work_status    = $request->structure_work_status;
            $projectDocumentObj->panel_work_status    = $request->panel_work_status;
            $projectDocumentObj->cabling_work_status    = $request->cabling_work_status;
            $projectDocumentObj->civil_work_status    = $request->civil_work_status;

            $projectDateObj->save();
            $projectDocumentObj->save();

            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.structure_updated_successfully'),
                    'html' => view('solarmitra::business.elements.projects.document-wizard',["project" => $projectObj,"project_documents" => $projectDocumentObj])->render(),
                    'close_modal' => true,
                ];
            }

            $nextStep = $this->getNextProjectStep('structure');

            return redirect()->route('business.solarmitra.projects.' . $nextStep, $project_id)->with('success', __('solarmitra::solarmitra.structure_updated_successfully'));

        }
        $project = Project::findOrFail($project_id);
        if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
            return redirect()->route('business.solarmitra.projects.documents', $project_id)->with('warning', __('solarmitra::solarmitra.please_complete_documents_first'));
        }
        $project_dates = ProjectDate::where('project_id',$project_id)->first();
        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.structure');
        return view('solarmitra::business.projects.structure',compact('page_title','project','project_documents','project_id','project_dates') );
    }
    
    /**
     * Show the form for project structure.
     */
    public function netmeter(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {

            $validation = [
                'netmeter_file_submission' => 'nullable',
                'netmeter_site_visited' => 'nullable',
                'netmeter_demand_note_generated' => 'nullable',
                'netmeter_demand_note_paid' => 'nullable',
                'netmeter_installed' => 'nullable',
                'netmeter_plant_on' => 'nullable',
                'netmeter_photo' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'netmeter_plant_photo' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            ];

            $messages = [
                'subsidi_registration_status.required' => __('solarmitra::solarmitra.subsidy_registration_required'),
                'loan_doc_submit_status.required' => __('solarmitra::solarmitra.loan_doc_submission_required'),
                'bank_verification_status.required' => __('solarmitra::solarmitra.bank_verification_required'),
                'loan_disberment_status.required' => __('solarmitra::solarmitra.loan_disbursement_required'),
            ];

            $this->validate($request, $validation,$messages);

            $projectObj = Project::findOrFail($project_id);
            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);


            $projectDocumentObj->netmeter_file_submission       = $request->netmeter_file_submission;
            $projectDocumentObj->netmeter_site_visited          = $request->netmeter_site_visited;
            $projectDocumentObj->netmeter_demand_note_generated = $request->netmeter_demand_note_generated;
            $projectDocumentObj->netmeter_demand_note_paid      = $request->netmeter_demand_note_paid;
            $projectDocumentObj->netmeter_installed         = $request->netmeter_installed;
            $projectDocumentObj->netmeter_plant_on          = $request->netmeter_plant_on;

            $AttachmentObj = New Attachment();

            if ($request->hasFile('netmeter_photo')) {
                $projectDocumentObj->netmeter_photo            = $AttachmentObj->InsertAttachments($request,'netmeter_photo',$project_id);
            }

            if ($request->hasFile('netmeter_plant_photo')) {
                $projectDocumentObj->netmeter_plant_photo            = $AttachmentObj->InsertAttachments($request,'netmeter_plant_photo',$project_id);
            }
            $projectDocumentObj->save();

            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.netmeter_updated_successfully'),
                    'html' => view('solarmitra::business.elements.projects.document-wizard',["project" => $projectObj,"project_documents" => $projectDocumentObj])->render(),
                    'close_modal' => true,
                ];
            }

            $nextStep = $this->getNextProjectStep('netmeter');

            return redirect()->route('business.solarmitra.projects.' . $nextStep, $project_id)->with('success', __('solarmitra::solarmitra.netmeter_updated_successfully'));

        }
        $project = Project::findOrFail($project_id);
        if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
            return redirect()->route('business.solarmitra.projects.documents', $project_id)->with('warning', __('solarmitra::solarmitra.please_complete_documents_first'));
        }
        $project_dates = ProjectDate::where('project_id',$project_id)->first();
        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.net_metering');
        return view('solarmitra::business.projects.netmeter',compact('page_title','project','project_documents','project_id','project_dates') );
    }
    /**
     * Show the form for project handover.
     */
    public function handover(Request $request,$project_id)
    {
        if ($request->isMethod('post')) {
            $validation = [
                'review'                  => 'required',
                'video_review'   => [
                                                'nullable',
                                                'file',
                                                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
                                                'max:10240', // 10MB (in KB)
                                            ],
                'site_completion_photo' => 'nullable|array|max:6',
                'site_completion_photo.*' => 'image|max:5120',
                'handover_confirmation_signature' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:10240',
            ];

            $messages = [
                'review.required' => __('solarmitra::solarmitra.review_required'),
                
                'video_review.file' => __('solarmitra::solarmitra.video_review_file'),
                'video_review.mimetypes' => __('solarmitra::solarmitra.video_review_mimetypes'),
                'video_review.max' => __('solarmitra::solarmitra.video_review_max'),
                
                'site_completion_photo.array' => __('solarmitra::solarmitra.site_completion_photos_must_be_array'),
                'site_completion_photo.max' => __('solarmitra::solarmitra.site_completion_photos_max_6'),
                'site_completion_photo.*.image' => __('solarmitra::solarmitra.site_completion_photo_image'),
                'site_completion_photo.*.max' => __('solarmitra::solarmitra.site_completion_photo_max'),
                
                'handover_confirmation_signature.image' => __('solarmitra::solarmitra.handover_signature_image'),
                'handover_confirmation_signature.max' => __('solarmitra::solarmitra.handover_signature_max'),
            ];
            $projectDocumentObj = ProjectDocument::firstOrNew([
                'project_id' => $project_id,
            ]);

            if (!$projectDocumentObj->handover_confirmation_signature) {
                $validation['handover_confirmation_signature'] = 'required|image|max:10240';
            }

            $projectObj = Project::findOrFail($project_id);
            $this->validate($request, $validation,$messages);
            $AttachmentObj = New Attachment();

            $clientFeedbackObj = ClientFeedback::firstOrNew([
                'project_id' => $project_id,
            ]);
            $projectDateObj = ProjectDate::firstOrNew([
                'project_id' => $project_id,
            ]);

            if ($request->hasFile('handover_confirmation_signature')) {
                $projectDocumentObj->handover_confirmation_signature    = $AttachmentObj->InsertAttachments($request,'handover_confirmation_signature',$project_id);
            }
            if ($request->hasFile('site_completion_photo')) {
                $attachment_ids = $AttachmentObj->InsertAttachments($request,'site_completion_photo',$project_id);

                foreach ($attachment_ids as $attachment_id) {
                    ProjectAttachment::create(['project_id'=>$project_id,'attachment_id'=>$attachment_id,'user_id'=>auth('business')->id(),'type'=>2]);
                }
            }

            /* Check Handover status only when all the things is corrected */
            if (SolarMitraHelper::getProjectStep($project_id) === 'handover') {

                $projectDocumentObj->handover_status    = $request->handover_status;
                $projectDateObj->handover_date = Carbon::now();
                $projectDateObj->save();
            }


            $projectDocumentObj->save();

            if ($request->hasFile('video_review')) {
                $clientFeedbackObj->video_review    =  $AttachmentObj->InsertAttachments($request,'video_review',$project_id);
            }
            $clientFeedbackObj->review    = $request->review;
            $clientFeedbackObj->save();

                if (SolarMitraHelper::getProjectStep($project_id) === 'done') {
                    $projectObj->status = 3;
                    $projectObj->save();
                }

            if(request()->ajax()){
                return [
                    'status' => true,
                    'message' =>  __('solarmitra::solarmitra.project_handover_successfully'),
                    'close_modal' => true,
                ];
            }

            return redirect()->route('business.solarmitra.projects.index')->with('success', __('solarmitra::solarmitra.project_handover_successfully'));
        }
        $page_title = __('solarmitra::solarmitra.project').' '. __('solarmitra::solarmitra.handover');
        $project = Project::with('project_attachments')->findOrFail($project_id);
        if ($project->status == config('solarmitra.projects_status_keys.Draft')) {
            return redirect()->route('business.solarmitra.projects.documents', $project_id)->with('warning', __('solarmitra::solarmitra.please_complete_documents_first'));
        }
        $project_dates = ProjectDate::where('project_id',$project_id)->first();
        $client_feedback = ClientFeedback::where('project_id',$project_id)->first();
        $project_documents = ProjectDocument::where('project_id',$project_id)->first();
        return view('solarmitra::business.projects.handover',compact('page_title','client_feedback','project_id','project_dates','project_documents','project'));
    }

    private function __imageSave($request, $key='', $folder_name='', $old_img='')
    {
        $fileName = $old_img ? $old_img : '';
        if($request->hasFile($key) && !empty($key) && !empty($folder_name)) { 
            $image = $request->file($key);
            $OriginalName = $image->getClientOriginalName();
            $fileName = time().'.'.$OriginalName;
            $request->file($key)->storeAs('public/'.$folder_name.'/', $fileName);
            if(!empty($old_img)) {
                if (\Storage::exists('public/'.$folder_name.'/', $old_img)) {
                    \Storage::delete('public/'.$folder_name.'/'.$old_img);
                }
            }
        }

        return $fileName;
    }
    
    public function assign_project(Request $request,$project_id){
        if ($request->isMethod('post')) {
            $validation = [
                'staff_id'  => 'required',
            ];

            $validationMsg = [
                'staff_id'  => __('solarmitra::solarmitra.please_select_staff_member'),
            ];

            $validator = \Validator::make($request->all(), $validation, $validationMsg);
            
            if ($request->ajax() && $validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }else{
                $this->validate($request, $validation,$validationMsg);
            }

            $projectAssignObj = ProjectAssign::firstOrNew([
                'project_id' => $project_id,
            ]);
            $projectAssignObj->staff_id = $request->staff_id;
            $projectAssignObj->save();
            
            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('PROJECT-APS', $project_id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.project_assigned'),'reload' => true]);
            }
            return redirect()->route('business.solarmitra.projects.index')->with('success', __('solarmitra::solarmitra.project_assigned'));
        }
        $projectStaff = ProjectAssign::where('project_id',$project_id)->first();

        $page_title = __('solarmitra::solarmitra.assign_project');
        return view('solarmitra::business.projects.assign_project_modal',compact('page_title','project_id','projectStaff'));
        
    }
    
    public function save_project_phase(Request $request,$projectId){
        if ($request->isMethod('post')) {
            $project = Project::findOrFail($projectId);


            $project->phases()->sync($request->project_phases);
            
            /* Send Event Notification */
            // $notificationObj        = new Notification();
            // $notificationObj->notification_entry('PROJECT-APS', $project_id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) {
                return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.project_phases_saved_successfully')]);
            }
            return redirect()->back()->with('success', __('solarmitra::solarmitra.project_phases_saved_successfully'));
        }
    }
    
    public function archived_projects(Request $request){
        
        $resultQuery = Project::with('project_documents')->where('business_id',app('currentBusinessId'))
            ->where('status',config('solarmitra.projects_status_keys.Archived'))
            ->when(!empty($request->title),function($q)use($request){
                $q->where('title','Like','%'.$request->title.'%');
            })
            ->when(!empty($request->client_id),function($q)use($request){
                $q->where('client_id',$request->client_id);
            })
            ->when(!empty($request->status) && !empty(array_filter($request->status)) && is_array($request->status),function($q)use($request){
                $q->whereIn('status',$request->status);
            });
        $projects = $resultQuery->paginate(config('Reading.nodes_per_page'));
        
        $page_title = __('solarmitra::solarmitra.archived_projects');
        return view('solarmitra::business.projects.archived_projects',compact('page_title','projects'));
    }
    
    public function move_to_projects(Request $request,$id){
        
        $project = Project::findOrFail($id);

        preg_match_all('/Status:\[([^\]]+)\]/', $project->change_note, $matches);
        $lastStatus = end($matches[1]);

        
        $project->change_note .= PHP_EOL . '[' . now() . '] Moved to Projects from Status: Archived By '.auth('business')->user()->full_name; 
        $project->status = $lastStatus ? config('solarmitra.projects_status_keys.'.$lastStatus) : config('solarmitra.projects_status_keys.Draft'); 
        $project->save();


        return redirect()->back()->with('success', __('solarmitra::solarmitra.project_moved_text'));
    }

    public function getNextProjectStep($currentStep)
    {
        $steps = [
            'documents',
            'verification',
            'subsidy',
            'structure',
            'netmeter',
            'handover',
        ];

        $currentIndex = array_search($currentStep, $steps);

        for ($i = $currentIndex + 1; $i < count($steps); $i++) {
            if (auth('business')->user()->can('SolarMitra > Business > ProjectsController > ' . $steps[$i])) {
                return $steps[$i];
            }
        }

        return null;
    }

    public function get_contact_projects($contact_id=null)
    {
        $projects = Project::where('business_id', app('currentBusinessId'))->when(!empty(request('contact_id')), function ($q) {
                            $q->where('client_id', request('contact_id'));
                        })->get();

        $transaction = Transaction::find(request('transaction_id'));
        $html = '<option value="" >Select Project</option>';
        
        foreach($projects as $project){

            $html .= '<option value="'.$project->id.'" '.(@$transaction->reference_type === 'project' && @$transaction->reference_id === $project->id ? 'selected' : '').'>' . $project->title . '</option>';
        }
        return $html;
    }

}
