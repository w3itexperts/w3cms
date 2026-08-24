<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Modules\SolarMitra\App\Models\Contact;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\QuotationItem;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\ProjectPayment;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\App\Models\ProjectDocument;
use Modules\SolarMitra\App\Models\ProjectDate;
use Modules\SolarMitra\App\Models\ProjectAssign;
use Modules\SolarMitra\App\Models\ProjectAttachment;
use Modules\SolarMitra\App\Models\ClientFeedback;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class ProjectsController extends Controller
{

    // Display Project Listing
    public function list(Request $request)
    {
        $request->validate([
            'search'      => 'nullable|string|max:255',
            'per_page'    => 'nullable|integer|min:1|max:100',
        ]);

        $businessId = app('currentBusinessId');
        $search  = $request->query('search');
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));

        /** 1?? Get projects */
        $projects = Project::whereNot('status',config('solarmitra.projects_status_keys.Archived'))->with('project_member','project_documents','project_payments','project_attachments','client_feedback','quotation.items','project_dates','client')
            ->where('business_id', $businessId)
            ->when($search, fn ($q) =>
                $q->where('title', 'like', "%{$search}%")
            )
            ->when(!empty($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        /** 2?? Preload related data in ONE query */
        $projectIds = $projects->pluck('id')->toArray();

        $documents = ProjectDocument::whereIn('project_id', $projectIds)
            ->get()
            ->keyBy('project_id');

        $projects->getCollection()->transform(function ($project) use (
            $documents,
        ) {

            // Documents with full URLs
            $doc = $documents[$project->id] ?? null;


            if ($doc) {

                

                $project->documents = [
                    'government_subsidy'        => $doc->government_subsidy,
                    'selected_subsidy_type'        => $doc->selected_subsidy_type,
                    'name_correction_new_name'  => $doc->name_correction_new_name,
                    'name_correction_new_name_status' => $doc->name_correction_new_name_status,
                    'electricity_bill' => $doc->electricity_bill,
                    'electricity_bill_url' => $doc->electricity_bill ? SolarMitraHelper::getAttachmentImage(@$doc->electricity_bill) : null,
                    'electricity_bill_verification_status' => $doc->electricity_bill_verification_status,
                    'adhar_card' => $doc->adhar_card,
                    'adhar_card_url' => $doc->adhar_card ? SolarMitraHelper::getAttachmentImage(@$doc->adhar_card) : null,
                    'adhar_card_backside' => $doc->adhar_card_backside,
                    'adhar_card_backside_url' => $doc->adhar_card_backside ? SolarMitraHelper::getAttachmentImage(@$doc->adhar_card_backside) : null,
                    'adhar_card_verification_status' => $doc->adhar_card_verification_status,
                    'pancard' => $doc->pancard,
                    'pancard_url' => $doc->pancard ? SolarMitraHelper::getAttachmentImage(@$doc->pancard) : null,
                    'pancard_verification_status' => $doc->pancard_verification_status,
                    'bank_passbook' => $doc->bank_passbook,
                    'bank_passbook_url' => $doc->bank_passbook ? SolarMitraHelper::getAttachmentImage(@$doc->bank_passbook) : null,
                    'bank_passbook_verification_status' => $doc->bank_passbook_verification_status,
                    'noc_name_transfer' => $doc->noc_name_transfer,
                    'noc_name_transfer_url' => $doc->noc_name_transfer ? SolarMitraHelper::getAttachmentImage(@$doc->noc_name_transfer) : null,
                    'noc_name_transfer_status' => $doc->noc_name_transfer_status,
                    'property_patta_evidence' => $doc->property_patta_evidence,
                    'property_patta_evidence_url' => $doc->property_patta_evidence ? SolarMitraHelper::getAttachmentImage(@$doc->property_patta_evidence) : null,
                    'property_patta_evidence_verification_status' => $doc->property_patta_evidence_verification_status,
                    'subsidi_registration_status' => $doc->subsidi_registration_status,
                    'loan_doc_submit_status' => $doc->loan_doc_submit_status,
                    'bank_verification_status' => $doc->bank_verification_status,
                    'loan_disberment_status' => $doc->loan_disberment_status,
                    'structure_work_status' => $doc->structure_work_status,
                    'panel_work_status' => $doc->panel_work_status,
                    'cabling_work_status' => $doc->cabling_work_status,
                    'civil_work_status' => $doc->civil_work_status,
                    'netmeter_file_submission' => $doc->netmeter_file_submission,
                    'netmeter_site_visited' => $doc->netmeter_site_visited,
                    'netmeter_demand_note_generated' => $doc->netmeter_demand_note_generated,
                    'netmeter_demand_note_paid' => $doc->netmeter_demand_note_paid,
                    'netmeter_installed' => $doc->netmeter_installed,
                    'netmeter_plant_on' => $doc->netmeter_plant_on,
                    'netmeter_photo' => $doc->netmeter_photo,
                    'netmeter_photo_url' => $doc->netmeter_photo ? SolarMitraHelper::getAttachmentImage(@$doc->netmeter_photo) : null,
                    'netmeter_plant_photo' => $doc->netmeter_plant_photo,
                    'netmeter_plant_photo_url' => $doc->netmeter_plant_photo ? SolarMitraHelper::getAttachmentImage(@$doc->netmeter_plant_photo) : null,
                    'handover_confirmation_signature' => $doc->handover_confirmation_signature,
                    'handover_confirmation_signature_url' => $doc->handover_confirmation_signature ? SolarMitraHelper::getAttachmentImage(@$doc->handover_confirmation_signature) : null,
                    'handover_status' => $doc->handover_status,

                ];
            } else {
                $project->documents = null;
            }

            $project->current_step = $this->checkCurrentStep($project->project_documents);

            return $project;
        });

        return response()->json([
            'status' => true,
            'data'   => $projects
        ]);
    }


    //Add Project
    public function save_project(Request $request,$project_id=null)
    {

      
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'client_id'     => 'required|integer',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'capacity'      => 'required|string',
            'project_type'  => 'required|string',
            'is_solar_kit_project' => 'nullable',
            'booking_amount'=> 'nullable|numeric',
            'location'      => 'nullable|string',
            'project_value' => 'nullable|numeric',
        ]);

        $businessId = app('currentBusinessId');

        DB::beginTransaction();

        try {

            /** CREATE PROJECT */

            $project = Project::firstOrNew(['id' => $project_id]);

            $project_change_note = @$project->change_note ? $project->change_note . PHP_EOL . '[' . now() . '] Project Updated By '.auth()->user()->full_name : '[' . now() . '] Project Created with Quotation By '.auth()->user()->full_name;
            
            [$capacity_int, $capacity_unit] = explode(' ', $request->capacity);

            $project->title = $request->title;
            if (!$project->business_id) {
                $project->business_id = $businessId;
            }
            $project->client_id = $request->client_id;
            $project->start_date = $request->filled('start_date') ? Carbon::parse($request->start_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));
            $project->end_date = $request->filled('end_date') ? Carbon::parse($request->end_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));
            $project->capacity_int           = @$capacity_int; 
            $project->capacity_unit          = @$capacity_unit; 
            $project->capacity = $request->capacity;
            $project->project_type = $request->project_type;
            $project->is_solar_kit_project = $request->is_solar_kit_project;
            $project->location = $request->location;
            $project->project_value = $request->project_value ?? 0;

            $project->description = $request->description;
            $project->change_note = $project_change_note;
            $project->status      = $request->status ?? 1;

            $project->save();


            $project['current_step'] = SolarMitraHelper::getProjectStep(@$project->id);

            /** UPLOAD SITE PHOTOS */ 
            $AttachmentObj = New Attachment();
            
            if ($request->hasFile('site_photo')) {
                $attachment_ids = $AttachmentObj->InsertAttachments($request,'site_photo',$project->id,$request->business_id);

                foreach ($attachment_ids as $attachment_id) {
                    ProjectAttachment::create(['project_id'=>$project->id,'attachment_id'=>$attachment_id,'user_id'=>auth('api')->id(),'type'=>1]);
                }
            }
            $project->project_attachments->where('type',1);

            /** RECORD BOOKING AMOUNT PAYMENT */
            if (!empty($request->booking_amount) && is_numeric($request->booking_amount) && $request->booking_amount > 0){

                $projectPayment = ProjectPayment::firstOrNew([
                    'project_id' => $project->id,
                    'remark'=>1
                ]); 
                $projectPayment->amount = $request->booking_amount;
                $projectPayment->status = $request->payment_status ?? 1;
                $projectPayment->save();
            }
            $project->project_payments;

            /** GENERATE NEXT QUOTATION NUMBER (BUSINESS WISE) */
            $lastQuotation = Quotation::where('business_id', $businessId)->when(!empty(request('project_id')), function ($q) {
                // return $q->where('project_id', request('project_id'));
            })->count();

            $nextNumber = $lastQuotation ? $lastQuotation+1 : 1;
            $quotationNumber = 'QT-' . $nextNumber;

            /** CREATE QUOTATION */
            if (!Quotation::where('project_id',$project->id)->exists()) {
                
                $quotation = Quotation::firstOrCreate([
                    'project_id' => $project->id,
                ], [
                    'business_id'      => $businessId,
                    'client_id'        => $validated['client_id'],
                    'project_id'       => $project->id,
                    'quotation_number' => $quotationNumber,
                    'total_amount'     => $request->project_value ?? 0,
                    'title'            => $validated['title'],
                    'date'             => Carbon::today(),
                    'valid_till_date'  => Carbon::today(),
                    'quotation_status_id' => 1,
                ]);

            }else{
                $quotation = Quotation::firstWhere('project_id' , $project->id);
                if ($quotation && $request->project_value) {
                    $quotation->total_amount = $request->project_value;
                    $quotation->save();
                }
            }

            /** ADD QUOTATION ITEMS FROM MATERIAL LIBRARY */
            if ($request->items) {

                if ($quotation->id) {
                    QuotationItem::where('quotation_id' , $quotation->id)->delete();
                }

                $items = collect($request->items)->filter(function ($row) {
                                return !empty($row['item_id']);
                            });
                
                foreach ($items as $row) {
                    $material = MaterialLibrary::find($row['item_id']);

                    
                    $quotationItem = QuotationItem::firstOrNew([
                        'quotation_id' => $quotation->id,
                        'item_id'      => $row['item_id'],
                    ]);

                    $quotationItem->material_company_id     = $row['material_company_id'];
                    $quotationItem->material_category_id    = $row['material_category_id'];
                    $quotationItem->item_title              = $quotationItem->item_title ?? $material->title;
                    $quotationItem->item_unit               = $quotationItem->item_unit ?? optional($material->material_unit)->title;
                    $quotationItem->item_quantity           = $row['item_quantity'] ?? 1;
                    $quotationItem->rates_per_units         = $material->selling_price ?? 0;
                    $quotationItem->gst                     = $material->gst ?? 0;
                    $quotationItem->discount                = $row['discount'] ?? null;
                    $quotationItem->amount                  = $row['amount'] ?? null;
                    $quotationItem->description             = $row['description'] ?? null;

                    $quotationItem->save();
                }
            }
            $project->quotation->items;

            $resMsg = $project_id ? __('solarmitra::solarmitra.project_and_quotation_updated_successfully') : __('solarmitra::solarmitra.project_and_quotation_created_successfully');

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => $resMsg,
                'data'    => $project
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        \File::deleteDirectory(storage_path('app/public/solarmitra-attachments/business_' . app('currentBusinessId') . '/project_' . $id));

        $project->project_payments()->delete();
        $project->project_documents()->delete();
        $project->project_dates()->delete();
        $project->client_feedback()->delete();
        $project->project_assign()->delete();
        $project->attachments()->delete();
        $project->delete();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_deleted_text'),
        ]);

    }

    //Upload Project Documents
    public function documents(Request $request, $project_id)
    {
       
        $projectDocumentObj = ProjectDocument::firstOrNew([
            'project_id' => $project_id
        ]);

        $validated = $request->validate([
            'government_subsidy'      => 'nullable|integer',
            'electricity_bill'        => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'adhar_card'              => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'adhar_card_backside'     => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'pancard'                 => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'bank_passbook'           => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'name_correction_new_name'=> 'nullable|string|max:255',
            'noc_name_transfer'       => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'property_patta_evidence' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        
        $projectObj = Project::find($project_id);

        $AttachmentObj = New Attachment();

        /* Set electricity_bill status to 0 if image uploaded again */
        if ($request->hasFile('electricity_bill')) {
            $projectDocumentObj->electricity_bill                   = $AttachmentObj->InsertAttachments($request,'electricity_bill',$project_id,$projectObj->business_id);
            $projectDocumentObj->electricity_bill_verification_status   = 0;
        }

        /* Set adhar_card status to 0 if image uploaded again */
        if ($request->hasFile('adhar_card')) {
            $projectDocumentObj->adhar_card                         = $AttachmentObj->InsertAttachments($request,'adhar_card',$project_id,$projectObj->business_id);
            $projectDocumentObj->adhar_card_verification_status         = 0;
        }

        if ($request->hasFile('adhar_card_backside')) {
            $projectDocumentObj->adhar_card_backside                         = $AttachmentObj->InsertAttachments($request,'adhar_card_backside',$project_id,$projectObj->business_id);
            $projectDocumentObj->adhar_card_verification_status         = 0;
        }

        $projectDocumentObj->government_subsidy                     = $request->government_subsidy ?? 0;
        $projectDocumentObj->selected_subsidy_type                     = $request->selected_subsidy_type ?? 3;

        /* Set Passbook status to 0 if image uploaded again */
        if ($request->hasFile('bank_passbook')) {
            $projectDocumentObj->bank_passbook                      = $AttachmentObj->InsertAttachments($request,'bank_passbook',$project_id,$projectObj->business_id);
            $projectDocumentObj->bank_passbook_verification_status      = 0;
        }

        /* Set Passbook status to 0 if image uploaded again */
        if ($request->hasFile('pancard')) {
            $projectDocumentObj->pancard                            = $AttachmentObj->InsertAttachments($request,'pancard',$project_id,$projectObj->business_id);
            $projectDocumentObj->pancard_verification_status            = 0;
        }

        /* Set name_correction status to 0 if New name is filled (check with matching to old) */
        $projectDocumentObj->name_correction_new_name               = $request->name_correction_new_name;
        if ($projectDocumentObj->name_correction_new_name == $request->name_correction_new_name) {
            $projectDocumentObj->name_correction_new_name_status    = 0;
        }

        if ($request->hasFile('noc_name_transfer')) {
            $projectDocumentObj->noc_name_transfer                  = $AttachmentObj->InsertAttachments($request,'noc_name_transfer',$project_id,$projectObj->business_id);
            $projectDocumentObj->noc_name_transfer_status               = 0;
        }

        if ($request->hasFile('property_patta_evidence')) {
            $projectDocumentObj->property_patta_evidence            = $AttachmentObj->InsertAttachments($request,'property_patta_evidence',$project_id,$projectObj->business_id);
            $projectDocumentObj->property_patta_evidence_verification_status = 0;
        }

        $projectDocumentObj->save();

        $projectDocumentObj->electricity_bill_url = $projectDocumentObj->electricity_bill ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->electricity_bill) : null;
        $projectDocumentObj->adhar_card_url = $projectDocumentObj->adhar_card ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->adhar_card) : null;
        $projectDocumentObj->adhar_card_backside_url = $projectDocumentObj->adhar_card_backside ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->adhar_card_backside) : null;
        $projectDocumentObj->pancard_url = $projectDocumentObj->pancard ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->pancard) : null;
        $projectDocumentObj->bank_passbook_url = $projectDocumentObj->bank_passbook ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->bank_passbook) : null;
        $projectDocumentObj->noc_name_transfer_url = $projectDocumentObj->noc_name_transfer ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->noc_name_transfer) : null;
        $projectDocumentObj->property_patta_evidence_url = $projectDocumentObj->property_patta_evidence ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->property_patta_evidence) : null;
        
        $projectDocumentObj->current_step = $this->checkCurrentStep($projectDocumentObj);
        
        $projectObj = Project::find($project_id);
        $projectDocumentObj->status = $projectObj->status;
        

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_documents_saved_successfully'),
            'data'    => $projectDocumentObj
        ], 201);

    }

    //Verify Project Documents
    public function verification(Request $request, $project_id)
    {
        $validated = $request->validate([
            'electricity_bill_verification_status'       => 'nullable',
            'adhar_card_verification_status'             => 'nullable',
            'pancard_verification_status'                => 'nullable',
            'bank_passbook_verification_status'          => 'nullable',
            'name_correction_new_name_status'            => 'nullable',
            'noc_name_transfer_status'                   => 'nullable',
            'property_patta_evidence_verification_status'=> 'nullable',
        ]);

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

        $projectDocumentObj->current_step = $this->checkCurrentStep($projectDocumentObj);

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_documents_verification_status_updated_successfully'),
            'data'    => $projectDocumentObj
        ], 201);

    }
    
    //Subsidy
    public function subsidy(Request $request, $project_id)
    {
        $validated = $request->validate([
            'subsidi_registration_status'  => 'nullable|integer',
            'loan_doc_submit_status'       => 'nullable|integer',
            'bank_verification_status'     => 'nullable|integer',
            'loan_disberment_status'       => 'nullable|integer',
        ]);

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

        //dates
        $projectDocumentObj->subsidi_registration_date = $projectDateObj->subsidi_registration_date;
        $projectDocumentObj->loan_doc_submit_date = $projectDateObj->loan_doc_submit_date;
        $projectDocumentObj->bank_verification_date = $projectDateObj->bank_verification_date;
        $projectDocumentObj->loan_disberment_date = $projectDateObj->loan_disberment_date;

        // current step
        $projectDocumentObj->current_step = $this->checkCurrentStep($projectDocumentObj);

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_subsidy_status_updated_successfully'),
            'data'    => $projectDocumentObj
        ], 201);

    }
    
    //Structure
    public function structure(Request $request, $project_id)
    {

        $validated = $request->validate([
            'structure_work_status' => 'nullable|integer',
            'panel_work_status'   => 'nullable|integer',
            'cabling_work_status' => 'nullable|integer',
            'civil_work_status'   => 'nullable|integer',
            'handover_status'     => 'nullable|integer',
        ]);

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
        $projectDateObj->save();


        $projectDocumentObj->structure_work_status    = $request->structure_work_status;
        $projectDocumentObj->panel_work_status    = $request->panel_work_status;
        $projectDocumentObj->cabling_work_status    = $request->cabling_work_status;
        $projectDocumentObj->civil_work_status    = $request->civil_work_status;
        $projectDocumentObj->save();

        //dates
        $projectDocumentObj->panel_work_date = $projectDateObj->panel_work_date;
        $projectDocumentObj->cabling_work_date = $projectDateObj->cabling_work_date;
        $projectDocumentObj->civil_work_date = $projectDateObj->civil_work_date;

        // current step
        $projectDocumentObj->current_step = $this->checkCurrentStep($projectDocumentObj);

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_structure_status_updated_successfully'),
            'data'    => $projectDocumentObj
        ], 201);

    }

    //Netmeter
    public function netmeter(Request $request,$project_id)
    {
        $validated = $request->validate([
            'netmeter_file_submission' => 'nullable',
            'netmeter_site_visited' => 'nullable',
            'netmeter_demand_note_generated' => 'nullable',
            'netmeter_demand_note_paid' => 'nullable',
            'netmeter_installed' => 'nullable',
            'netmeter_plant_on' => 'nullable',
                'netmeter_photo' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
                'netmeter_plant_photo' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $projectDocumentObj = ProjectDocument::firstOrNew([
            'project_id' => $project_id,
        ]);

        $projectObj = Project::find($project_id);

        $projectDocumentObj->netmeter_file_submission       = $request->netmeter_file_submission;
        $projectDocumentObj->netmeter_site_visited          = $request->netmeter_site_visited;
        $projectDocumentObj->netmeter_demand_note_generated = $request->netmeter_demand_note_generated;
        $projectDocumentObj->netmeter_demand_note_paid      = $request->netmeter_demand_note_paid;
        $projectDocumentObj->netmeter_installed         = $request->netmeter_installed;
        $projectDocumentObj->netmeter_plant_on          = $request->netmeter_plant_on;

        $AttachmentObj = New Attachment();

        if ($request->hasFile('netmeter_photo')) {
            $projectDocumentObj->netmeter_photo            = $AttachmentObj->InsertAttachments($request,'netmeter_photo',$project_id, $projectObj->business_id);
        }

        if ($request->hasFile('netmeter_plant_photo')) {
            $projectDocumentObj->netmeter_plant_photo            = $AttachmentObj->InsertAttachments($request,'netmeter_plant_photo',$project_id, $projectObj->business_id);
        }
        $projectDocumentObj->save();

        $projectDocumentObj->netmeter_photo_url = $projectDocumentObj->netmeter_photo ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->netmeter_photo) : null;
        $projectDocumentObj->netmeter_plant_photo_url = $projectDocumentObj->netmeter_plant_photo ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->netmeter_plant_photo) : null;

         $projectDocumentObj->current_step = $this->checkCurrentStep($projectDocumentObj);

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_netmeter_status_updated_successfully'),
            'data'    => $projectDocumentObj
        ], 201);    

    }
    
    //Handover
    public function handover(Request $request, $project_id)
    {
        $request->validate([
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
        ],[
                'review.required' => __('solarmitra::solarmitra.please_provide_a_review'),

                'video_review.file' => __('solarmitra::solarmitra.video_review_must_be_a_valid_file'),
                'video_review.mimetypes' => __('solarmitra::solarmitra.video_review_must_be_in_mp4_avi_mpeg_or_mov_format'),
                'video_review.max' => __('solarmitra::solarmitra.video_review_cannot_exceed_10mb'),

                'site_completion_photo.array' => __('solarmitra::solarmitra.site_completion_photos_must_be_an_array'),
                'site_completion_photo.max' => __('solarmitra::solarmitra.you_can_upload_a_maximum_of_6_photos'),
                'site_completion_photo.*.image' => __('solarmitra::solarmitra.each_site_completion_photo_must_be_an_image'),
                'site_completion_photo.*.max' => __('solarmitra::solarmitra.each_site_completion_photo_cannot_exceed_5mb'),

                'handover_confirmation_signature.image' => __('solarmitra::solarmitra.handover_confirmation_signature_must_be_an_image'),
                'handover_confirmation_signature.max' => __('solarmitra::solarmitra.handover_confirmation_signature_cannot_exceed_10mb'),
            ]);

        $AttachmentObj = New Attachment();

        $projectObj = Project::find($project_id);

        $clientFeedbackObj = ClientFeedback::firstOrNew([
            'project_id' => $project_id,
        ]);
        $projectDocumentObj = ProjectDocument::firstOrNew([
            'project_id' => $project_id,
        ]);
        $projectDateObj = ProjectDate::firstOrNew([
                'project_id' => $project_id,
            ]);

        if ($request->hasFile('handover_confirmation_signature')) {
            $projectDocumentObj->handover_confirmation_signature    = $AttachmentObj->InsertAttachments($request,'handover_confirmation_signature',$project_id,$projectObj->business_id);
        }
        if ($request->hasFile('site_completion_photo')) {
            $attachment_ids = $AttachmentObj->InsertAttachments($request,'site_completion_photo',$project_id,$projectObj->business_id);

            foreach ($attachment_ids as $attachment_id) {
                ProjectAttachment::create(['project_id'=>$project_id,'attachment_id'=>$attachment_id,'user_id'=>auth('api')->id(),'type'=>2]);
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
            $clientFeedbackObj->video_review    =  $AttachmentObj->InsertAttachments($request,'video_review',$project_id,$projectObj->business_id);
        }
        $clientFeedbackObj->review    = $request->review;
        $clientFeedbackObj->save();

        if (SolarMitraHelper::getProjectStep($project_id) === 'done') {
            $projectObj->status = 3;
            $projectObj->save();
        }


        $projectDocumentObj->review = $clientFeedbackObj->review;
        $projectDocumentObj->video_review = $clientFeedbackObj->video_review;
        $projectDocumentObj->video_review_url = $clientFeedbackObj->video_review ? SolarMitraHelper::getAttachmentImage(@$clientFeedbackObj->video_review) : null;
        $projectDocumentObj->handover_confirmation_signature_url = $projectDocumentObj->handover_confirmation_signature ? SolarMitraHelper::getAttachmentImage(@$projectDocumentObj->handover_confirmation_signature) : null;
        
        $project_attachments = $projectObj->project_attachments->where('type',2);
        
        $site_completion_photos = [];
        if ($project_attachments) {
            foreach ($project_attachments as $project_attachment) {
                $site_completion_photos[] = SolarMitraHelper::getAttachmentImage(@$project_attachment->attachment_id);
            }
        }

        $projectDocumentObj->site_completion_photo = $site_completion_photos;

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_handover_status_updated_successfully'),
            'data'    => $projectDocumentObj
        ], 201);
    }

    private function checkCurrentStep($projectDocumentObj)
    {
        $step = SolarMitraHelper::getProjectStep(@$projectDocumentObj->project_id);   
        return $step;
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

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.document_removed_text'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove_project_attachment($project_attachment_id)
    {
        $projectAttachmentObj = ProjectAttachment::findOrFail($project_attachment_id);

        $attachment = New Attachment;
        $attachment->DeleteAttachment($projectAttachmentObj->attachment_id,$projectAttachmentObj->project_id);

        $projectAttachmentObj->delete();

        if (request()->ajax()) {
            return response()->json(['res' => true]);
        }
        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.document_removed_text'),
        ]);
    }

    // Helper function to save images
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


    //Assign Projects
    public function assign_staff(Request $request, $project_id)
    {
        $projectAssignObj = ProjectAssign::firstOrNew([
            'project_id' => $project_id,
        ]);
        $projectAssignObj->staff_id = $request->staff_id;
        $projectAssignObj->save();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.project_assign_successfully'),
            'data'    => $projectAssignObj->staff
        ], 201);

    }


    //Assign Projects
    public function remove_review_video($feedback_id)
    {
        $feedback = ClientFeedback::find($feedback_id);

        $attachment = New Attachment;
        $attachment->DeleteAttachment($feedback->video_review,$feedback->project_id);

        $feedback->video_review = null;
        $feedback->save();

        
        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.video_removed_successfully'),
        ]);

    }

}
