<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Quotation;
use Modules\SolarMitra\App\Models\InvoiceItem;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\Business;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Modules\SolarMitra\App\Models\Transaction;
use Carbon\Carbon;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.invoices');
        $projects = Project::where('business_id',app('currentBusinessId'))->pluck('title','id')->toArray();
        $baseQuery = Invoice::query()
                        ->where('business_id', app('currentBusinessId'))
                        ->when(!empty($request->title), function ($q) use ($request) {
                            $q->where('title', 'LIKE', '%' . $request->title . '%');
                        })
                        ->when(!empty($request->client_id), function ($q) use ($request) {
                            $q->where('client_id', $request->client_id);
                        })
                        ->when(!empty($request->project_id), function ($q) use ($request) {
                            $q->where('project_id', $request->project_id);
                        })
                        ->when(!empty($request->status), function ($q) use ($request) {
                            $q->where('status', $request->status);
                        })->orderBy('updated_at', 'desc');

                        
        $invoices = $baseQuery->paginate(config('Reading.nodes_per_page'));
        return view('solarmitra::business.invoices.index',compact('page_title','invoices','projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_title = __('solarmitra::solarmitra.create').' '.__('solarmitra::solarmitra.invoice');
        $quotations = Quotation::where('business_id', app('currentBusinessId'))->whereNot('invoice_generated', 1)->whereHas('status', function($q){
                            $q->where('can_convert', 1);
                        })->pluck('title','id')->toArray();

        if ($request->ajax()) {
            return view('solarmitra::business.invoices.invoice_modal',compact('page_title','quotations'));
        }

        return view('solarmitra::business.invoices.create',compact('page_title','quotations'));
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
            'date.before' => __('solarmitra::solarmitra.date_before_due_date'),
            'due_date.after' => __('solarmitra::solarmitra.due_date_after_date'),
        ];

        $validator = \Validator::make($request->all(), $validation,$validationMsg);
        
        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$validationMsg);
        }

        $quotationObj = Quotation::findOrFail($request->quotation_id);

        if (!optional($quotationObj->status)->can_convert) {
            return redirect()->back()->with('warning', __("solarmitra::solarmitra.quotation_not_confirmed_for_invoice"));
        }
        
        if (Invoice::where('quotation_id', $quotationObj->id)->exists()) {
            $msg = __("solarmitra::solarmitra.quotation_invoice_already_exists");
            if ($request->ajax()) {
                return response()->json(['status' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->with('warning', $msg);
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

        $InvoiceObj = New Invoice();
        $InvoiceObj->client_id          = $quotationObj->client_id; 
        $InvoiceObj->quotation_id       = $quotationObj->id; 
        $InvoiceObj->project_id         = $quotationObj->project_id;
        $InvoiceObj->business_id        = $quotationObj->business_id; 
        $InvoiceObj->invoice_number     = $newInvoiceNumber; 
        $InvoiceObj->date               = $request->date ?? Carbon::now()->format(config('solarmitra.date_time_format')); 
        $InvoiceObj->sub_total          = $quotationObj->sub_total; 
        $InvoiceObj->title              = $invoiceTitle; 
        $InvoiceObj->paid_amount        = 0; 
        $InvoiceObj->due_amount         = $quotationObj->total_amount; 
        $InvoiceObj->tax                = $quotationObj->tax; 
        $InvoiceObj->aditional_charges  = $quotationObj->aditional_charges; 
        $InvoiceObj->discount           = $quotationObj->discount; 
        $InvoiceObj->total_amount       = $quotationObj->total_amount; 
        $InvoiceObj->due_date           = $request->due_date ?? Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format'));
        $InvoiceObj->status             = $request->status ?? 1;
        $InvoiceObj->description             = $request->description;
        $res = $InvoiceObj->save();

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('INVOICE-ANI', $InvoiceObj->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

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
        if ($request->ajax()) {
            return response()->json(['status' => true,'reload' => true,'message' => __('solarmitra::solarmitra.invoice_created_successfully')]);
        }
        return redirect()->route('business.solarmitra.invoices.index')->with('success', __('solarmitra::solarmitra.invoice_created_successfully'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $invoice = Invoice::with('client', 'quotation', 'project', 'items')->findOrFail($id);
        return view('solarmitra::business.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        $page_title = __('solarmitra::solarmitra.edit').' '.__('solarmitra::solarmitra.invoice');
        $invoice = Invoice::findOrFail($id);
        
        if ($request->ajax()) {
            return view('solarmitra::business.invoices.invoice_modal',compact('invoice'));
        }

        return view('solarmitra::business.invoices.edit',compact('page_title','invoice'));
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
            'business_id.exists' => __('solarmitra::solarmitra.selected_business_not_exist'),
            'date.before' => __('solarmitra::solarmitra.date_before_due_date'),
            'due_date.after' => __('solarmitra::solarmitra.due_date_after_date'),
        ];

        $validator = \Validator::make($request->all(), $validation,$validationMsg);
            

        if ($request->ajax() && $validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
            $this->validate($request, $validation,$validationMsg);
        }

        
        $invoiceObj                 = Invoice::findOrFail($id); 
        $invoiceObj->status         = $request->status; 
        $invoiceObj->date           = $request->date; 
        $invoiceObj->due_date       = $request->due_date; 
        $invoiceObj->description       = $request->description; 
        $res = $invoiceObj->save();

        if ($res) {

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('INVOICE-UI', $invoiceObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */

            if ($request->ajax()) 
            {
                return response()->json([
                    'status' => true,
                    'close_modal' => true,
                    'message' => __('solarmitra::solarmitra.invoice_updated_text'),
                ]);
            }

            return redirect()->route('business.solarmitra.invoices.index')->with('success', __('solarmitra::solarmitra.invoice_updated_text'));
        }

        return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_org($id)
    {
        $invoice = Invoice::findOrFail($id);

        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('INVOICE-DI', $invoice->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */

        $invoice->items()->delete();
        if ($invoice->quotation_id) {
            Quotation::where('id', $invoice->quotation_id)->update(['invoice_generated' => 0]);
        }
        $invoice->delete();
        return redirect()->back()->with('success', __('solarmitra::solarmitra.invoice_deleted_text'));
    }
    
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        // 1. Delete transactions linked to this invoice
        Transaction::where('reference_type', 'invoice')
            ->where('reference_id', $invoice->id)
            ->delete();

        // 2. Delete items
        $invoice->items()->delete();

        // 3. Reset quotation flag
        if ($invoice->quotation_id) {
            Quotation::where('id', $invoice->quotation_id)->update(['invoice_generated' => 0]);
        }

        // 4. Notification
        $notificationObj = new Notification();
        $notificationObj->notification_entry('INVOICE-DI', $invoice->id, auth('business')->id(), config('constants.superadmin'));

        // 5. Delete invoice
        $invoice->delete();

        return redirect()->back()->with('success', __('solarmitra::solarmitra.invoice_deleted_text'));
    }

    public function view_invoice($invoice_id)
    {
        if (!is_numeric($invoice_id)) {
            $invoice_id = \Crypt::decrypt($invoice_id);
        }
        $invoice = Invoice::findOrFail($invoice_id);
        $business = Business::findOrFail($invoice->business_id);
        $transactions = Transaction::where('reference_type', 'invoice')
            ->where('reference_id', $invoice->id)
            ->with('transaction_type')
            ->get();

        $totalPaid = $transactions->sum('amount');
        $dueAmount = $invoice->total_amount - $totalPaid;

        $pdf = Pdf::loadview('solarmitra::business.invoices.pdf', compact('invoice','business','transactions','totalPaid','dueAmount'));
        
        return $pdf->stream($invoice->invoice_number.'.pdf');
    }

    public function download_invoice($invoice_id)
    {
        if (!is_numeric($invoice_id)) {
            $invoice_id = \Crypt::decrypt($invoice_id);
        }
        $invoice = Invoice::findOrFail($invoice_id);
        $business = Business::findOrFail($invoice->business_id);
        $transactions = Transaction::where('reference_type', 'invoice')
            ->where('reference_id', $invoice->id)
            ->with('transaction_type')
            ->get();

        $totalPaid = $transactions->sum('amount');
        $dueAmount = $invoice->total_amount - $totalPaid;

        $pdf = Pdf::loadview('solarmitra::business.invoices.pdf', compact('invoice','business','transactions','totalPaid','dueAmount'));
        
        /* Send Event Notification */
        $notificationObj        = new Notification();
        $notificationObj->notification_entry('INVOICE-DLI', $invoice->id, auth('business')->id(), config('constants.superadmin'));
        /* End Send Event Notification */
        
        return $pdf->download($invoice->invoice_number.'.pdf');
        
    }
    public function share_invoice($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        $business = Business::findOrFail($invoice->business_id);

        return view('solarmitra::business.invoices.share_modal',compact('invoice','business'));
    }

    public function get_contact_invoices($contact_id=null)
    {
        $invoices = Invoice::where('business_id', app('currentBusinessId'))->when(!empty(request('contact_id')), function ($q) {
                            $q->where('client_id', request('contact_id'));
                        })->get();
        $transaction = Transaction::find(request('transaction_id'));
        $html = '<option value="" >'.__('solarmitra::solarmitra.select_invoice').'</option>';
        
        foreach($invoices as $invoice){
            
            $due_amount = (@$transaction->reference_type === 'invoice' && (int)$transaction->reference_id === (int)$invoice->id) ? $transaction->amount + $invoice->due_amount : $invoice->due_amount;

            $html .= '<option value="'.$invoice->id.'" data-due_amount="'.$due_amount.'" '.(@$transaction->reference_id === $invoice->id ? 'selected' : '').'>' . $invoice->title . ' - Total: ' . $invoice->total_amount . ' - Due : '.@$invoice->due_amount.'</option>';
        }
        return $html;
    }

    public function change_to_paid(Request $request,$id)
    {
        $invoice = Invoice::with('client', 'quotation', 'project')->findOrFail($id);
        $transactions = Transaction::where('reference_type', 'invoice')
            ->where('reference_id', $id)
            ->with('transaction_type')
            ->get();

        $totalPaid = $transactions->sum('amount');
        $dueAmount = max(0, $invoice->total_amount - $totalPaid);
        $isFullyPaid = $invoice->total_amount > 0 && $totalPaid >= $invoice->total_amount;

        if ($request->isMethod('POST')) {

            $invoice->status = 2;
                
            if ($isFullyPaid) 
            {
                $res = $invoice->save();
                if ($request->ajax()) {
                    return response()->json(['status' => true, 'reload' => true, 'close_modal' => true,'message' => __('solarmitra::solarmitra.invoice_confirmed_to_paid_successfully')]);
                }
                return redirect()->back()->with('success', __('solarmitra::solarmitra.invoice_confirmed_to_paid_successfully'));    
            }

            if ($request->ajax()) {
                return response()->json(['status' => false]);
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong')); 
        }
            


        return view('solarmitra::business.invoices.change_to_paid_modal', compact('invoice', 'transactions', 'totalPaid', 'dueAmount', 'isFullyPaid'));

    }
}
