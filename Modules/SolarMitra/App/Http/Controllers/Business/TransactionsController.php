<?php

namespace Modules\SolarMitra\App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SolarMitra\App\Models\Project;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Address;
use Modules\SolarMitra\App\Models\Attachment;
use Modules\SolarMitra\App\Models\Transaction;
use Modules\SolarMitra\App\Models\TransactionType;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Carbon\Carbon;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = __('solarmitra::solarmitra.transactions');
        $project = Project::find(request('project_id'));
        $transactions = Transaction::where('business_id', app('currentBusinessId'))->with('sender','receiver','transaction_type')
                            ->when(!empty(request('project_id')), function($q){
                                $q->where('project_id', request('project_id'));
                            })
                            ->when(request()->filled('search'), function($q) {
                                $search = request('search');
                                $q->where(function($query) use ($search) {
                                    $query->where('description', 'like', "%{$search}%")
                                          ->orWhere('amount', 'like', "%{$search}%")
                                          ->orWhere('transaction_number', 'like', "%{$search}%")
                                          ->orWhereHas('sender', function($q2) use ($search) {
                                              $q2->where('name', 'like', "%{$search}%");
                                          })
                                          ->orWhereHas('receiver', function($q2) use ($search) {
                                              $q2->where('name', 'like', "%{$search}%");
                                          });
                                });
                            })
                            ->when(request()->filled('transfer_type'), function($q) {
                                $q->where('transfer_type', request('transfer_type'));
                            })
                            ->when(request()->filled('transfer_mode'), function($q) {
                                $q->where('transfer_mode', request('transfer_mode'));
                            })
                            ->when(request()->filled('transaction_type_id'), function($q) {
                                $q->where('transaction_type_id', request('transaction_type_id'));
                            })
                            ->when(request()->filled('date_from'), function($q) {
                                $q->whereDate('date', '>=', request('date_from'));
                            })
                            ->when(request()->filled('date_to'), function($q) {
                                $q->whereDate('date', '<=', request('date_to'));
                            })
                            ->when(request()->filled('reference_type'), function($q) {
                                $q->where('reference_type', request('reference_type'));
                            })
                            ->latest()
                            ->paginate(config('Reading.nodes_per_page'))
                            ->appends(request()->all());

        $transaction_types = TransactionType::with('childs')->whereNull('parent_id')->get();

        $invoice_payment_in = Transaction::where('business_id', app('currentBusinessId'))->where('reference_type', 'invoice')->sum('amount');
        $payment_expence_total = Transaction::where('business_id', app('currentBusinessId'))->where('transfer_type', 'dr')->sum('amount');
        $payment_income_total = Transaction::where('business_id', app('currentBusinessId'))->where('transfer_type', 'cr')->sum('amount');

        return view('solarmitra::business.transactions.index', compact('page_title','project','transactions','transaction_types','invoice_payment_in','payment_expence_total','payment_income_total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $projectId = request('project_id');
        [$type, $transaction_type] = array_pad(explode('-', request('type'), 2), 2, null);

        $lastTransaction = Transaction::where('business_id', app('currentBusinessId'))->count();
        $nextNumber = $lastTransaction ? $lastTransaction+1 : 1;
        $newTransactionNumber = 'TRSN-' . $nextNumber;

        $invoices = Invoice::with('project')->where('business_id', app('currentBusinessId'))->get();
        $invoice = Invoice::find(request()->invoice_id);

        $project = Project::find($projectId);
        $projects = Project::where('business_id', app('currentBusinessId'))->get();

        return view('solarmitra::business.transactions.transaction-'.$type,compact('project','projects','newTransactionNumber','invoices','transaction_type','invoice') );
        
    }

    /**
     * Store a newly created resource in \storage.
     */
    public function store(Request $request)
    {

        if ($request->isMethod('post')) {
            $invoice = Invoice::find($request->invoice_id);
            $validation = [
                'reciever_party_id'     => 'required',
                'sender_party_id'       => 'required',
                'amount'                => 'required',
                'project_id'            => 'nullable',
                'transaction_type'      => 'required',
                'transfer_mode'      => 'required',
                'invoice_id'   => 'required_if:transaction_type,invoice-payment',
                'project_id'   => 'required_if:transaction_type,project-expenses',
            ];

            if (request('transaction_type') === 'invoice-payment'){
                $validation['amount'] = ['required', 'numeric', 'max:' . $invoice->due_amount];
            } 

            $validationMsg = [
                'reciever_party_id.required' => __('solarmitra::solarmitra.please_select_receiver_party'),
                'reciever_party_id.exists' => __('solarmitra::solarmitra.selected_receiver_party_does_not_exist'),
                
                'sender_party_id.required' => __('solarmitra::solarmitra.please_select_sender_party'),
                'sender_party_id.exists' => __('solarmitra::solarmitra.selected_sender_party_does_not_exist'),
                
                'amount.required' => __('solarmitra::solarmitra.amount_required'),
                'amount.numeric' => __('solarmitra::solarmitra.amount_must_be_a_valid_number'),
                'amount.min' => __('solarmitra::solarmitra.amount_must_be_at_least_0'),
                
                'transaction_type.required' => __('solarmitra::solarmitra.transaction_type_required'),
                'transaction_type.exists' => __('solarmitra::solarmitra.selected_transaction_type_does_not_exist'),
                
                'invoice_id.required_if' => __('solarmitra::solarmitra.invoice_is_required'),
                'invoice_id.exists' => __('solarmitra::solarmitra.selected_invoice_does_not_exist'),
                
                'project_id.required_if' => __('solarmitra::solarmitra.project_is_required'),
                'project_id.exists' => __('solarmitra::solarmitra.selected_project_does_not_exist'),
                
                'transaction_type.in' => __('solarmitra::solarmitra.transaction_type_must_be_a_valid_option'),
            ];

            $validator = \Validator::make($request->all(), $validation,$validationMsg);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],422);
            }
            $reference_id = 0;
            $project_id = $request->project_id ?? 0;
            $reference_type = '';
            $transaction_type_id = TransactionType::firstWhere('slug',request('transaction_type'))->id;

            if ($invoice && request('transaction_type') === 'invoice-payment') {

                $reference_id = request('invoice_id');
                $reference_type = 'invoice';

                $invoice->paid_amount = $invoice->paid_amount + request('amount');
                $invoice->due_amount = max(0, ($invoice->due_amount ?? $invoice->total_amount) - request('amount'));
                $invoice->save();

                $project_id = $invoice->project_id;
            }
            elseif (request('transaction_type') === 'project-expenses') 
            {
                $reference_id = $project_id;
                $reference_type = 'project';
            }

            $transactionObj                     = new Transaction; 
            $transactionObj->sender_party_id    = request('sender_party_id');
            $transactionObj->reciever_party_id  = request('reciever_party_id');
            $transactionObj->business_id        = app('currentBusinessId');
            $transactionObj->project_id         = $project_id;
            $transactionObj->transaction_type_id = request('transaction_type_id') ?? $transaction_type_id;
            $transactionObj->transaction_number = request('transaction_number');
            $transactionObj->amount             = request('amount') ?? 0;
            $transactionObj->reference_id       = $reference_id;
            $transactionObj->reference_type     = $reference_type;
            $transactionObj->date               = request('date') ?? Carbon::now()->format(config('solarmitra.date_time_format'));
            $transactionObj->description        = request('description');
            $transactionObj->transfer_mode      = request('transfer_mode');
            $transactionObj->transfer_type      = request('transfer_type');
            $transactionObj->payment_for        = request('payment_for');
            $transaction                        = $transactionObj->save();

            $AttachmentObj = New Attachment();
            if ($request->hasFile('transaction_attachments')) {
                $attachment_ids = $AttachmentObj->InsertAttachments($request,'transaction_attachments');
                $transactionObj->attachments()->syncWithoutDetaching($attachment_ids);
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('TRANSACTION-ANT', $transactionObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
            if($request->ajax())
            {
                $response = ['status' => true, 'message' => __('solarmitra::solarmitra.transaction_saved_successfully'), 'close_offcanvas' => true];

                if (!empty($request->invoice_id)) {
                    $response['reload_modal_url'] = route('business.solarmitra.invoices.change_to_paid', $request->invoice_id);
                }

                return response()->json($response);
            }

            if ($transaction) {
                return redirect()->route('business.solarmitra.transactions.index',request('project_id'))->with('success', __('solarmitra::solarmitra.transaction_added_text'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
            
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
    public function edit(Request $request,$id)
    {
        $transaction = Transaction::findOrFail($id);
        $projectId = request('project_id');;
        
        $type = $transaction->transfer_type == 'cr' ? 'income' : 'expense';
        $transaction_type = optional($transaction->transaction_type)->slug;
        
        
        $invoice = '';
        if ($transaction->reference_type === 'invoice' && $transaction->reference_id > 0) {
            $invoice = Invoice::find($transaction->reference_id);
        }
        $invoices = Invoice::with('project')->where('business_id', app('currentBusinessId'))->get();

        $project = Project::find($projectId);
        $projects = Project::where('business_id', app('currentBusinessId'))->get();


        return view('solarmitra::business.transactions.transaction-'.$type,compact('project','transaction','invoices','projects','transaction_type','invoice') );
    }

    /**
     * Update the specified resource in \storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $transactionObj                     = Transaction::findOrFail($id); 
            $invoice = Invoice::find($request->invoice_id);
            $validation = [
                'reciever_party_id'     => 'required',
                'sender_party_id'       => 'required',
                'amount'                => 'required',
                'project_id'            => 'required',
                'transaction_type'      => 'required',
                'transfer_mode'      => 'required',
                'invoice_id'   => 'required_if:transaction_type,invoice-payment',
                'project_id'   => 'required_if:transaction_type,project-expenses',
            ];

            if (request('transaction_type') === 'invoice-payment'){
                $validation['amount'] = ['required', 'numeric', 'max:' . ($transactionObj->reference_id === $invoice->id ? $invoice->due_amount + $transactionObj->amount : $invoice->due_amount)];
            } 

            $validationMsg = [
                'reciever_party_id.required' => __('solarmitra::solarmitra.please_select_receiver_party'),
                'reciever_party_id.exists' => __('solarmitra::solarmitra.selected_receiver_party_does_not_exist'),

                'sender_party_id.required' => __('solarmitra::solarmitra.please_select_sender_party'),
                'sender_party_id.exists' => __('solarmitra::solarmitra.selected_sender_party_does_not_exist'),

                'amount.required' => __('solarmitra::solarmitra.amount_required'),
                'amount.numeric' => __('solarmitra::solarmitra.amount_must_be_a_valid_number'),
                'amount.min' => __('solarmitra::solarmitra.amount_must_be_at_least_0'),

                'transaction_type.required' => __('solarmitra::solarmitra.transaction_type_required'),

                'invoice_id.required_if' => __('solarmitra::solarmitra.invoice_is_required_when_payment_is_for_invoice'),
                'invoice_id.exists' => __('solarmitra::solarmitra.selected_invoice_does_not_exist'),

                'project_id.required_if' => __('solarmitra::solarmitra.project_is_required_when_payment_is_for_project'),
                'project_id.exists' => __('solarmitra::solarmitra.selected_project_does_not_exist'),

            ];

            $validator = \Validator::make($request->all(), $validation,$validationMsg);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()],422);
            }

            $reference_id = 0;
            $reference_type = '';
            $transaction_type_id = TransactionType::firstWhere('slug',request('transaction_type'))->id;
            
            if ($invoice && request('transaction_type') === 'invoice-payment') {
                $reference_id = request('invoice_id');
                $reference_type = 'invoice';

                if (request('amount') != $transactionObj->amount) {
                    $amount = request('amount') - $transactionObj->amount;
                    
                    $invoice->paid_amount = $invoice->paid_amount + $amount;
                    $invoice->due_amount = max(0, ($invoice->due_amount ?? $invoice->total_amount) - $amount);
                    $invoice->save();
                }
            }
            elseif (request('transaction_type') === 'project-expenses') 
            {
                $reference_id = request('project_id');
                $reference_type = 'project';
            }
            
            $transactionObj->sender_party_id    = request('sender_party_id');
            $transactionObj->reciever_party_id  = request('reciever_party_id');
            $transactionObj->transaction_type_id = $transaction_type_id;
            $transactionObj->transaction_number = request('transaction_number');
            $transactionObj->amount             = request('amount');
            $transactionObj->date               = request('date') ?? Carbon::now()->format(config('solarmitra.date_time_format'));
            $transactionObj->description        = request('description');
            $transactionObj->transfer_mode      = request('transfer_mode');
            $transactionObj->transfer_type      = request('transfer_type');
            $transactionObj->payment_for        = request('payment_for');
            $transactionObj->reference_id       = $reference_id;
            $transactionObj->reference_type     = $reference_type;
            $transaction                        = $transactionObj->save();


            $AttachmentObj = New Attachment();
            if ($request->hasFile('transaction_attachments')) {
                $attachment_ids = $AttachmentObj->InsertAttachments($request,'transaction_attachments');
                $transactionObj->attachments()->syncWithoutDetaching($attachment_ids);
            }

            /* Send Event Notification */
            $notificationObj        = new Notification();
            $notificationObj->notification_entry('TRANSACTION-UT', $transactionObj->id, auth('business')->id(), config('constants.superadmin'));
            /* End Send Event Notification */
            
            if($request->ajax() && $transaction)
            {
                return response()->json(['status' => true,'message' => __('solarmitra::solarmitra.transaction_saved_successfully'),'close_offcanvas' => true]);
            }

            if ($transaction) {
                return redirect()->route('business.solarmitra.transactions.index',request('project_id'))->with('success', __('solarmitra::solarmitra.transaction_added_text'));
            }
            return redirect()->back()->with('error', __('solarmitra::solarmitra.something_went_wrong'));
            
        }
    }

    /**
     * Remove the specified resource from \storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $transaction = Transaction::findOrFail($id);

            // If transaction is linked to an invoice, sync invoice financials
            if ($transaction->reference_type === 'invoice' && $transaction->reference_id > 0) {
                $invoice = Invoice::find($transaction->reference_id);

                if ($invoice) {
                    // Recalculate paid amount from remaining transactions (excluding this one)
                    $totalPaid = Transaction::where('reference_type', 'invoice')
                        ->where('reference_id', $invoice->id)
                        ->where('id', '!=', $transaction->id)
                        ->sum('amount');

                    $invoice->paid_amount = $totalPaid;
                    $invoice->due_amount = max(0, $invoice->total_amount - $totalPaid);

                    // If invoice was fully paid but now has due, revert to unpaid
                    if ($invoice->due_amount > 0 && $invoice->status == 2) {
                        $invoice->status = 1;
                    }

                    $invoice->save();
                }
            }

            // Notification
            $notificationObj = new Notification();
            $notificationObj->notification_entry('TRANSACTION-DT', $transaction->id, auth('business')->id(), config('constants.superadmin'));

            // Detach attachments
            $transaction->attachments()->detach();

            $transaction->delete();

            DB::commit();

            return redirect()->back()->with('success', __('solarmitra::solarmitra.transaction_deleted_text'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('solarmitra::solarmitra.failed_to_delete') . $e->getMessage());
        }
    }
}
