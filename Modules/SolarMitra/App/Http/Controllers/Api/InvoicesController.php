<?php

namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Business;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SolarMitra\App\Models\InvoiceItem;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\Transaction;
use Carbon\Carbon;

class InvoicesController extends Controller
{

    // Display Invoice Listing
    public function list(Request $request)
    {

        $request->validate([
            'search'      => 'nullable|string|max:255',
            'per_page'    => 'nullable|integer|min:1|max:100',
        ]);

        $businessId = app('currentBusinessId');
        $search = $request->query('search');  
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));

        $invoices = Invoice::with('items','client','quotation.items')->where('business_id', $businessId)
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when(!empty($request->status), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(!empty($request->client_id), function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $invoices
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = [
            'quotation_id'  => 'required',
            'date'   => 'required|before:due_date',
            'due_date'     => 'required|after:date',
            'status'  => 'required',
        ];

        $validationMsg = [
            'quotation_id'  => __('solarmitra::solarmitra.please_select_quotation'),
            'date.before' => __('solarmitra::solarmitra.date_must_be_before_due_date'),
            'due_date.after' => __('solarmitra::solarmitra.due_date_must_be_after_date'),
        ];

        $this->validate($request, $validation,$validationMsg);
        
        try {
            DB::beginTransaction();
            
            $quotationObj = Quotation::findOrFail($request->quotation_id);

            if (!$quotationObj->status->can_convert) {
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.quotation_not_confirmed_for_invoice'),
                ], 500);
            }
            if (Invoice::where('quotation_id', $quotationObj->id)->exists()) {
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.quotation_already_has_invoice'),
                ], 422);
            }
            
            $newInvoiceNumber = SolarMitraHelper::generateDocumentNumber('invoice');
            $titlePrefix = SolarMitraHelper::getDocumentTitlePrefix('invoice');
            $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days', 7);

            $quotationObj->invoice_generated = 1;
            $quotationObj->save();
            
            $clientName = optional($quotationObj->client)->name ?? 'Unknown Client';
            $capacity   = optional($quotationObj->project)->capacity ?? '';
            $projectType = optional($quotationObj->project)->project_type ?? '';
            $invoiceTitle = $titlePrefix . $clientName;
            if ($capacity) $invoiceTitle .= ' - ' . $capacity;
            if ($projectType) $invoiceTitle .= ' - ' . $projectType;

            $InvoiceObj = new Invoice();
            $InvoiceObj->client_id          = $quotationObj->client_id; 
            $InvoiceObj->quotation_id       = $quotationObj->id; 
            $InvoiceObj->project_id         = $quotationObj->project_id;
            $InvoiceObj->business_id        = $quotationObj->business_id; 
            $InvoiceObj->invoice_number     = $newInvoiceNumber; 
            $InvoiceObj->date               = $request->filled('date') ? Carbon::parse($request->date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')); 
            $InvoiceObj->sub_total          = $quotationObj->sub_total; 
            $InvoiceObj->title              = $invoiceTitle; 
            $InvoiceObj->paid_amount        = 0; 
            $InvoiceObj->due_amount         = $quotationObj->total_amount; 
            $InvoiceObj->tax                = $quotationObj->tax; 
            $InvoiceObj->aditional_charges  = $quotationObj->aditional_charges; 
            $InvoiceObj->discount           = $quotationObj->discount; 
            $InvoiceObj->total_amount       = $quotationObj->total_amount; 
            $InvoiceObj->due_date           = $request->filled('due_date') ? Carbon::parse($request->due_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format'));
            $InvoiceObj->status             = $request->status ?? 1;
            $InvoiceObj->description             = $request->description;
            $res = $InvoiceObj->save();


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

            $InvoiceObj->load('quotation'); 

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.invoice_created_successfully'),
                'data'    => $InvoiceObj
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'date'   => 'required|before:due_date',
            'due_date'     => 'required|after:date',
            'status'  => 'required',
        ];

        
        $validationMsg = [
            'business_id.required' => __('solarmitra::solarmitra.please_select_business'),
            'business_id.exists' => __('solarmitra::solarmitra.selected_business_does_not_exist'),
            'date.before' => __('solarmitra::solarmitra.date_must_be_before_due_date'),
            'due_date.after' => __('solarmitra::solarmitra.due_date_must_be_after_date'),
        ];

        $this->validate($request, $validation,$validationMsg);

        $invoiceObj                 = Invoice::findOrFail($id); 
        $invoiceObj->status         = $request->status; 
        $invoiceObj->date           = $request->filled('date') ? Carbon::parse($request->date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')); 
        $invoiceObj->due_date       = $request->filled('due_date') ? Carbon::parse($request->due_date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')); 
        $invoiceObj->description       = $request->description; 
        $res = $invoiceObj->save();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.invoice_updated_successfully'),
        ], 200);

    }

    //Destroy Invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete related items first
            $invoice->items()->delete();

            if ($invoice->quotation_id) {
                Quotation::where('id', $invoice->quotation_id)->update(['invoice_generated' => 0]);
            }
            
            // Delete invoice
            $invoice->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => __('solarmitra::solarmitra.invoice_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ], 500);
        }
    }

    public function view_invoice($invoice_id)
    {
        try {
            $invoice = Invoice::findOrFail($invoice_id);
            
            $business = Business::findOrFail($invoice->business_id);
            $transactions = Transaction::where('reference_type', 'invoice')
                ->where('reference_id', $invoice->id)
                ->with('transaction_type')
                ->get();

            $totalPaid = $transactions->sum('amount');
            $dueAmount = $invoice->total_amount - $totalPaid;
            $pdf = Pdf::loadview('solarmitra::business.invoices.pdf', compact('invoice', 'business','transactions','totalPaid','dueAmount'));

            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$invoice->invoice_number.'.pdf"',
            ]);

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return response()->json([
                'error' => __('solarmitra::solarmitra.failed_to_generate_pdf'),
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function download_invoice($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $business = Business::findOrFail($invoice->business_id);
        $transactions = Transaction::where('reference_type', 'invoice')
                ->where('reference_id', $invoice->id)
                ->with('transaction_type')
                ->get();

        $totalPaid = $transactions->sum('amount');
        $dueAmount = $invoice->total_amount - $totalPaid;
        $business_id = $invoice->business_id;

        // Generate PDF
        $pdf = Pdf::loadview('solarmitra::business.invoices.pdf', compact('invoice','business','transactions','totalPaid','dueAmount'));

        $fileName = $invoice->invoice_number.'.pdf';

        $folderPath = 'public/solarmitra-attachments/business_'.$business_id.'/invoices';

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
            'message' => __('solarmitra::solarmitra.invoice_generated_successfully'),
            'pdf_url' => $pdfUrl
        ]);
    }

    public function change_to_paid(Request $request, $id)
    {
        $invoice = Invoice::with('client', 'quotation', 'project')->findOrFail($id);
        $transactions = Transaction::where('reference_type', 'invoice')
            ->where('reference_id', $id)
            ->with('transaction_type')
            ->get();

        $totalPaid = $transactions->sum('amount');
        $dueAmount = max(0, $invoice->total_amount - $totalPaid);
        $isFullyPaid = $invoice->total_amount > 0 && $totalPaid >= $invoice->total_amount;


        if (!$isFullyPaid) {
            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.invoice_not_fully_paid', ['due' => SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($dueAmount)]),
            ], 422);
        }

        // Mark as paid and sync financials
        $invoice->status = 2;
        $invoice->save();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.invoice_confirmed_to_paid_successfully'),
        ]);
        

    }

    /**
     * View a single transaction
     */
    public function show($id)
    {
        $businessId = app('currentBusinessId');

        $invoice = Invoice::where('business_id', $businessId)->with('items','client')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $invoice,
        ]);
    }
}