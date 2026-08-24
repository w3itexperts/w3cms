<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\ProjectPayment;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\QuotationItem;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\InvoiceItem;
use Modules\SolarMitra\App\Models\Business;
use Modules\SolarMitra\App\Models\MaterialLibrary;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SolarMitra\App\Models\Lead;
use Carbon\Carbon;

class QuotationsController extends Controller
{

    // Display Quotation Listing
    public function list(Request $request)
    {

        $request->validate([
            'search'      => 'nullable|string|max:255',
            'per_page'    => 'nullable|integer|min:1|max:100',
        ]);

        $businessId = app('currentBusinessId');
        $search = $request->query('search');  
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));

        $quotations = Quotation::where('business_id', $businessId)->with('project','items','client','creator')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when(!empty($request->client_id), function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->when(!empty($request->quotation_status_id), function ($query) use ($request) {
                $query->where('quotation_status_id', $request->quotation_status_id);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);


        return response()->json([
            'status' => true,
            'data' => $quotations
        ]);

    }


    // Dropdown List
    public function get_dropdown_list(Request $request)
    {
        $request->validate([
            'quotation_status_id' => 'nullable|integer',
        ]);

        $businessId = app('currentBusinessId');
        $quotations = Quotation::where('business_id', $businessId)
            ->when($request->has('quotation_status_id'), function ($query) use ($request) {
                $query->where('quotation_status_id', $request->quotation_status_id);
            })
            ->when($request->has('invoice_generated'), function ($query) use ($request) {
                $query->where('invoice_generated', $request->invoice_generated);
            })
            ->select('id', 'title') // Only required fields
            ->latest()
            ->get(); // Get all records

        return response()->json([
            'status' => true,
            'data' => $quotations
        ]);
    }


    //Add Quotation
    public function save_quotation(Request $request,$quotation_id=null)
    {

        $quotation = Quotation::firstOrNew(['id' => $quotation_id]);
        $projectExist = Project::where('id',$quotation->project_id)->exists(); 

        $validations = [
            'client_id'   => 'required|integer',

            // Quotation
            'title'            => 'required|string',
            'start_date'  => 'required|date|before:end_date',
            'end_date'  => 'required|date|after:start_date',
            'location'  => 'required|string',
            'date'             => 'nullable|date|before:valid_till_date',
            'valid_till_date'  => 'nullable|date|after:date',
            'sub_total'        => 'nullable|numeric',
            'tax'              => 'nullable|numeric',
            'aditional_charges'=> 'nullable|numeric',
            'discount'         => 'nullable|numeric',

            // Items
            'items'                         => 'nullable|array',
            'items.*.item_id'               => 'required|numeric',
            'items.*.material_company_id'   => 'required|numeric',
            'items.*.material_category_id'  => 'required|numeric',
            'items.*.item_quantity'         => 'required|numeric',
        ];

        $messages = [
            'business_id.required' => __('solarmitra::solarmitra.business_is_required'),
            'business_id.integer' => __('solarmitra::solarmitra.invalid_business_selected'),

            'client_id.required' => __('solarmitra::solarmitra.client_is_required'),
            'client_id.integer' => __('solarmitra::solarmitra.invalid_client_selected'),

            'title.required' => __('solarmitra::solarmitra.quotation_title_is_required'),
            'title.string' => __('solarmitra::solarmitra.title_must_be_string'),

            'date.date' => __('solarmitra::solarmitra.please_provide_valid_date'),
            'valid_till_date.date' => __('solarmitra::solarmitra.please_provide_valid_till_date'),

            'sub_total.numeric' => __('solarmitra::solarmitra.sub_total_must_be_number'),
            'tax.numeric' => __('solarmitra::solarmitra.tax_must_be_number'),
            'aditional_charges.numeric' => __('solarmitra::solarmitra.additional_charges_must_be_number'),
            'discount.numeric' => __('solarmitra::solarmitra.discount_must_be_number'),

            // Items
            'items.array' => __('solarmitra::solarmitra.items_must_be_array'),
            'items.*.item_id.required' => __('solarmitra::solarmitra.item_is_required'),
            'items.*.material_company_id.required' => __('solarmitra::solarmitra.material_company_is_required'),
            'items.*.material_category_id.required' => __('solarmitra::solarmitra.material_category_is_required'),
            'items.*.item_title.required' => __('solarmitra::solarmitra.item_title_is_required'),
            'items.*.item_unit.required' => __('solarmitra::solarmitra.item_unit_is_required'),
            'items.*.item_quantity.required' => __('solarmitra::solarmitra.item_quantity_is_required'),
            'items.*.rates_per_units.required' => __('solarmitra::solarmitra.rate_per_unit_is_required'),
            'items.*.gst.numeric' => __('solarmitra::solarmitra.gst_must_be_number'),
            'items.*.discount.numeric' => __('solarmitra::solarmitra.item_discount_must_be_number'),
            'items.*.description.string' => __('solarmitra::solarmitra.item_description_must_be_string'),
        ];

        if (!$projectExist) {
            $validations = array_merge($validations, [
                // Project
                'capacity'  => 'required|string',
                'project_type'  => 'required|string',
                'is_solar_kit_project'  => 'nullable',
                'booking_amount'  => 'nullable|numeric',
            ]);
        }
        $validated = $request->validate($validations,$messages);
        $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days',7);
        $businessId = app('currentBusinessId');


        DB::beginTransaction();

        try {
            
            $newQuotationNumber = SolarMitraHelper::generateDocumentNumber('quotation');
            $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('quotation');
            
            // Create Project if project_id not provided
            $project = Project::firstOrCreate([
                'id' => @$quotation->project_id,
            ], [
                'business_id'  => $businessId,
                'title'        => $request->title,
                'client_id'    => $request->client_id,
                'start_date'   => $request->filled('start_date') ? Carbon::parse($request->start_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')),
                'end_date'     => $request->filled('end_date') ? Carbon::parse($request->end_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')),
                'project_type' => $request->project_type,
                'is_solar_kit_project' => $request->is_solar_kit_project,
                'project_value' => $request->total_amount ?? 0,
                'change_note'  => '[' . now() . '] Project Created with Quotation By '.auth()->user()->full_name,
                'location'       => $request->location,
                'status'       => 1,
            ]); 

            if ($request->filled('project_type')) {
                $project->project_type = $request->project_type;
            }
            if (isset($request->is_solar_kit_project)) {
                $project->is_solar_kit_project = $request->is_solar_kit_project ?? 0;
            }
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
                $project->start_date = Carbon::parse($request->start_date)->format(config('solarmitra.date_time_format'));
            }
            if ($request->filled('end_date')) {
                $project->end_date = Carbon::parse($request->end_date)->format(config('solarmitra.date_time_format'));
            }
            if ($request->filled('location')) {
                $project->location = $request->location;
            }

            if ($project) {
                $project->save();
            }

            if (!empty($request->booking_amount) && is_numeric($request->booking_amount) && $request->booking_amount > 0){
                $projectPayment = ProjectPayment::firstOrNew([
                    'project_id' => $project->id,
                    'remark'=>1
                ]); 
                $projectPayment->amount = $request->booking_amount;
                $projectPayment->status = $request->payment_status ?? 1;
                $projectPayment->save();
            }
            
            // Create Quotation
            if (!$quotation->exists) {
                $quotation->business_id         = $businessId; 
                $quotation->project_id          = $project->id; 
                $quotation->quotation_number    = $newQuotationNumber; 
            }

            if (!$quotation->created_by) {
                $quotation->created_by           = auth('api')->id();
            }

            if ($request->filled('sub_total')) {
                $quotation->sub_total           = $request->sub_total; 
            }
            if ($request->description) {
                $quotation->description           = $request->description; 
            }
            if ($request->filled('aditional_charges')) {
                $quotation->aditional_charges           = $request->aditional_charges; 
            }
            if ($request->filled('tax')) {
                $quotation->tax           = $request->tax; 
            }
            if ($request->filled('discount')) {
                $quotation->discount           = $request->discount; 
            }
            if ($request->filled('total_amount')) {
                $quotation->total_amount           = $request->total_amount; 
            }
            if ($request->filled('margin_amount')) {
                $quotation->margin_amount           = $quotation->margin_amount ?: $request->margin_amount; 
            }
            if (!$quotation->exists || $request->date) {
                $quotation->date             = $request->filled('date') ? Carbon::parse($request->date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));
            }
            if (!$quotation->exists || $request->valid_till_date) {
                $quotation->valid_till_date  = $request->filled('valid_till_date') ? Carbon::parse($request->valid_till_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format'));
            }
            $quotation->quotation_status_id = $request->quotation_status_id ?? 1;

            if (! $quotation->exists) {
                $quotation->title = str_starts_with($request->title, $titlePrefix)
                    ? $request->title
                    : $titlePrefix . $request->title;
            } else {
                $quotation->title = $request->title;
            }
            $quotation->client_id           = $request->client_id; 
            $quotation->save();

            // Create items separately
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
                    $quotationItem->item_title              = $material->title;
                    $quotationItem->item_unit               = $material->material_unit->title;
                    $quotationItem->item_quantity           = $row['item_quantity'] ?? 1;
                    $quotationItem->rates_per_units         = $material->selling_price ?? 0;
                    $quotationItem->gst                     = $material->gst ?? 0;
                    $quotationItem->discount                = $row['discount'] ?? null;
                    $quotationItem->amount                  = $row['amount'] ?? null;
                    $quotationItem->description             = $row['description'] ?? null;

                    $quotationItem->save();
                }
            }

            // Sync linked invoice items if quotation is already invoiced
            $linkedInvoice = Invoice::where('quotation_id', $quotation->id)->first();
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
                $linkedInvoice->sub_total         = $quotation->sub_total;
                $linkedInvoice->tax               = $quotation->tax;
                $linkedInvoice->aditional_charges = $quotation->aditional_charges;
                $linkedInvoice->discount          = $quotation->discount;
                $linkedInvoice->total_amount      = $quotation->total_amount;
                $linkedInvoice->due_amount        = max(0, $quotation->total_amount - $linkedInvoice->paid_amount);
                $linkedInvoice->save();
            }

            if ($linkedInvoice && $request->has('items')) {
                $quotation->quotation_status_id = 1; // Draft
                $quotation->save();
            }

            if ($request->has('lead_id')) {
                $lead = Lead::where('id', $request->lead_id)->update(['lead_stage_id' => 5]); /* lead status set to Proposal Sent */
            }
            
            DB::commit();

            // Return quotation with items
            return response()->json([
                'status'  => true,
                'message' => $quotation_id ? __('solarmitra::solarmitra.quotation_updated_successfully') :  __('solarmitra::solarmitra.quotation_created_successfully'),
                'data'    => $quotation->load('project','items','client','creator')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'error'  => $e->getMessage(),
                'file'   => $e->getFile(),
                'line'   => $e->getLine(),
            ], 500);
        }

    }

    //Destroy Quotation
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete related items first
            $quotation->items()->delete();

            // Delete quotation
            $quotation->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.quotation_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    //remove Quotation Item by Item id
    public function item_destroy($id)
    {
        $quotationItem = QuotationItem::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete quotation Item
            $quotationItem->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.quotation_item_deleted_text')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    public function status_change(Request $request,$id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->quotation_status_id = $request->quotation_status_id;
        $quotation->save();

        return response()->json([
            'status' => true,
            'data' => $request->quotation_status_id,
            'message' => __('solarmitra::solarmitra.quotation_status_changed_successfully')
        ]);
        
    }

    public function convert_to_invoice(Request $request,$id=null)
    {
        try {
            DB::beginTransaction();
            $id = $id ?? request('quotation_id') ?? 0;
            $quotation = Quotation::with('items')->findOrFail($id);
            
            if (!$quotation->status->can_convert) {
                return response()->json([
                    'status'  => false,
                    'message' => __("solarmitra::solarmitra.quotation_not_confirmed_for_invoice")
                ], 400);
            }

            if (Invoice::where('quotation_id', $quotation->id)->exists()) {
                $quotation->invoice_generated = 1;
                $quotation->save();
                DB::commit();
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.quotation_already_has_invoice'),
                ], 422);
            }
            
            $newInvoiceNumber = SolarMitraHelper::generateDocumentNumber('invoice');
            $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('invoice');
            $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days', 7);


            $clientName  = optional($quotation->client)->name ?? 'Unknown Client';
            $capacity    = optional($quotation->project)->capacity ?? '';
            $projectType = optional($quotation->project)->project_type ?? '';
            $invoiceTitle = $titlePrefix . $clientName;
            if ($capacity) $invoiceTitle .= ' - ' . $capacity;
            if ($projectType) $invoiceTitle .= ' - ' . $projectType;

            // Create Invoice
            $invoice = Invoice::create([
                'client_id'         => $quotation->client_id,
                'title'      =>         $invoiceTitle,
                'quotation_id'      => $quotation->id,
                'project_id'        => $quotation->project_id,
                'business_id'       => $quotation->business_id,
                'due_amount'        => $quotation->total_amount,
                'paid_amount'        => 0,
                'invoice_number'    => $newInvoiceNumber,
                'date'              => $quotation->date ?? Carbon::now()->format(config('solarmitra.date_time_format')),
                'sub_total'         => $quotation->sub_total,
                'tax'               => $quotation->tax,
                'aditional_charges' => $quotation->aditional_charges,
                'discount'          => $quotation->discount,
                'total_amount'      => $quotation->total_amount,
                'due_date'          => $quotation->valid_till_date ?? Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')),
                'status'            => 1,
                'description'       => $quotation->description,
            ]);

            $quotation->invoice_generated = 1;
            $quotation->save();

            // Copy quotation items to invoice items
            if ($quotation->items && $quotation->items->count()) {
                foreach ($quotation->items as $item) {

                    $invoiceItem = InvoiceItem::firstOrNew([
                        'invoice_id' => $invoice->id,
                        'item_id'    => $item->item_id,
                    ]);

                    $invoiceItem->material_company_id  = $item->material_company_id;
                    $invoiceItem->material_category_id = $item->material_category_id;
                    $invoiceItem->item_title           = $item->item_title;
                    $invoiceItem->item_unit            = $item->item_unit;
                    $invoiceItem->item_quantity        = $item->item_quantity;
                    $invoiceItem->rates_per_units      = $item->rates_per_units;
                    $invoiceItem->gst                  = $item->gst;
                    $invoiceItem->discount             = $item->discount;
                    $invoiceItem->amount               = $item->amount;
                    $invoiceItem->description          = $item->description;

                    $invoiceItem->save();
                }
            }
            
            DB::commit();

            $invoice->load('quotation'); 

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.invoice_created_successfully'),
                'data'    => $invoice
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.something_went_wrong'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

   
    public function view_quotation($quotation_id)
    {
        try {
            $quotation = Quotation::findOrFail($quotation_id);
            
            $business = Business::findOrFail($quotation->business_id);

            $pdf = Pdf::loadview('solarmitra::business.quotations.pdf', compact('quotation', 'business'));
            
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="quotation_'.$quotation->id.'.pdf"',
            ]);

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => __('solarmitra::solarmitra.failed_to_generate_pdf'),
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

    public function download_quotation($quotation_id)
    {
        $quotation = Quotation::findOrFail($quotation_id);
        $business = Business::findOrFail($quotation->business_id);

        $business_id = $quotation->business_id;

        // Generate PDF
        $pdf = Pdf::loadview('solarmitra::business.quotations.pdf', compact('quotation','business'));

        $fileName = 'quotation_'.$quotation->id.'.pdf';

        $folderPath = 'public/solarmitra-attachments/business_'.$business_id.'/quotations';

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        $filePath = $folderPath.'/'.$fileName;

        // Save PDF
        Storage::put($filePath, $pdf->output());

        // Public URL
        $pdfUrl = asset(str_replace('public/', 'storage/', $filePath));

        return response()->json([
            'status' => true,
            'message' => __('solarmitra::solarmitra.quotation_generated_successfully'),
            'pdf_url' => $pdfUrl
        ]);
    }

}