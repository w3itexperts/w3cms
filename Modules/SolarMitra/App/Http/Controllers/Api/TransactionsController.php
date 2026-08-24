<?php
namespace Modules\SolarMitra\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SolarMitra\App\Models\Transaction;
use Modules\SolarMitra\App\Models\TransactionType;
use Modules\SolarMitra\App\Models\Invoice;
use Modules\SolarMitra\App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Modules\SolarMitra\Helper\SolarMitraHelper;
use Carbon\Carbon;

class TransactionsController extends Controller
{
    /**
     * List transactions with filters
     */
    public function list(Request $request)
    {
        $request->validate([
            'search'          => 'nullable|string|max:255',
            'per_page'        => 'nullable|integer|min:1|max:100',
            'transfer_type'   => 'nullable|in:cr,dr',
            'transaction_type'=> 'nullable|string',
            'project_id'      => 'nullable|integer',
            'date_from'       => 'nullable|date',
            'date_to'         => 'nullable|date|after_or_equal:date_from',
        ]);

        $businessId = app('currentBusinessId');
        $perPage = $request->query('per_page', config('Reading.nodes_per_page'));

        $transactions = Transaction::with(['sender', 'receiver', 'transaction_type'])
            ->where('business_id', $businessId)
            ->when(!empty($request->search), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('transaction_number', 'LIKE', "%{$request->search}%")
                       ->orWhere('description', 'LIKE', "%{$request->search}%");
                });
            })
            ->when(!empty($request->transfer_type), function ($q) use ($request) {
                $q->where('transfer_type', $request->transfer_type);
            })
            ->when(!empty($request->transaction_type), function ($q) use ($request) {
                $q->whereHas('transaction_type', function ($q2) use ($request) {
                    $q2->where('slug', $request->transaction_type);
                });
            })
            ->when(!empty($request->project_id), function ($q) use ($request) {
                $q->where('project_id', $request->project_id);
            })
            ->when(!empty($request->invoice_id), function ($q) use ($request) {
                $q->where('reference_id', $request->invoice_id)->where('reference_type', 'invoice');
            })
            ->when(!empty($request->date_from), function ($q) use ($request) {
                $q->where('date', '>=', $request->date_from);
            })
            ->when(!empty($request->date_to), function ($q) use ($request) {
                $q->where('date', '<=', $request->date_to);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        $invoice_payment_in = Transaction::where('business_id', app('currentBusinessId'))->where('reference_type', 'invoice')->sum('amount');
        $payment_expence_total = Transaction::where('business_id', app('currentBusinessId'))->where('transfer_type', 'dr')->sum('amount');
        $payment_income_total = Transaction::where('business_id', app('currentBusinessId'))->where('transfer_type', 'cr')->sum('amount');

        return response()->json([
            'status' => true,
            'data'   => $transactions,
            'dashboard'   => [
                'invoice_payment_in' => $invoice_payment_in,
                'payment_expence_total' => $payment_expence_total,
                'payment_income_total' => $payment_income_total,
            ],
        ]);
    }

    /**
     * View a single transaction
     */
    public function show($id)
    {
        $businessId = app('currentBusinessId');

        $transaction = Transaction::with(['sender', 'receiver', 'transaction_type', 'attachments'])
            ->where('business_id', $businessId)
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $transaction,
        ]);
    }

    /**
     * Create a new transaction
     */
    public function store(Request $request)
    {
        $validation = [
            'reciever_party_id'  => 'required|integer',
            'sender_party_id'    => 'required|integer',
            'amount'             => 'required|numeric|min:0.01',
            'transaction_type'   => 'required|string',
            'transfer_mode'      => 'required|string',
            'project_id'         => 'nullable|integer',
            'invoice_id'         => 'required_if:transaction_type,invoice-payment|nullable|integer',
            'date'               => 'nullable|date',
            'description'        => 'nullable|string|max:1000',
        ];

        $validationMsg = [
            'reciever_party_id.required' => __('solarmitra::solarmitra.please_select_receiver_party'),
            'sender_party_id.required'   => __('solarmitra::solarmitra.please_select_sender_party'),
            'amount.required'            => __('solarmitra::solarmitra.amount_is_required'),
            'amount.numeric'             => __('solarmitra::solarmitra.amount_must_be_valid_number'),
            'amount.min'                 => __('solarmitra::solarmitra.amount_must_be_at_least'),
            'transaction_type.required'  => __('solarmitra::solarmitra.transaction_type_is_required'),
            'transfer_mode.required'     => __('solarmitra::solarmitra.payment_method_is_required'),
            'invoice_id.required_if'     => __('solarmitra::solarmitra.invoice_is_required_for_payments'),
        ];

        $validator = \Validator::make($request->all(), $validation, $validationMsg);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.validation_failed'),
                'errors'  => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();

        try {

        $invoice = null;
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::where('business_id', app('currentBusinessId'))->find($request->invoice_id);
            if (!$invoice) {
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.invoice_not_found'),
                ], 404);
            }
        }

        // Validate max amount for invoice payments
        if ($request->transaction_type === 'invoice-payment' && $invoice) {
            if ($request->amount > $invoice->due_amount) {
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.payment_amount_exceeds_due_amount', ['amount' => $request->amount, 'due_amount' => $invoice->due_amount]),
                ], 422);
            }
        }


        $transactionType = TransactionType::firstWhere('slug', $request->transaction_type);
        if (!$transactionType) {
            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.invalid_transaction_type', ['type' => $request->transaction_type]),
            ], 422);
        }

        $reference_id = 0;
        $project_id = $request->project_id ?? 0;
        $reference_type = '';

        if ($request->transaction_type === 'invoice-payment' && $invoice) {
            $reference_id = $invoice->id;
            $reference_type = 'invoice';

            $invoice->paid_amount = $invoice->paid_amount + $request->amount;
            $invoice->due_amount = max(0, $invoice->due_amount - $request->amount);
            $invoice->save();
            $project_id = $invoice->project_id;
        } elseif ($request->transaction_type === 'project-expenses') {
            $reference_id = $project_id;
            $reference_type = 'project';
        }



        $lastTransaction = Transaction::where('business_id', app('currentBusinessId'))->count();
        $nextNumber = $lastTransaction + 1;
        $transactionNumber = 'TRSN-' . $nextNumber;

        $transaction = Transaction::create([
            'business_id'         => app('currentBusinessId'),
            'sender_party_id'     => $request->sender_party_id,
            'reciever_party_id'   => $request->reciever_party_id,
            'project_id'          => $project_id,
            'transaction_type_id' => $transactionType->id,
            'transaction_number'  => $transactionNumber,
            'amount'              => $request->amount,
            'reference_id'        => $reference_id,
            'reference_type'      => $reference_type,
            'date'                => $request->filled('date') ? Carbon::parse($request->date)->format(config('solarmitra.date_time_format')) : Carbon::now()->format(config('solarmitra.date_time_format')),
            'description'         => $request->description,
            'transfer_mode'       => $request->transfer_mode,
            'transfer_type'       => $request->transfer_type ?? 'cr',
            'payment_for'         => $request->payment_for,
        ]);


        if ($request->hasFile('transaction_attachments')) {
            $AttachmentObj = new Attachment();
            $attachment_ids = $AttachmentObj->InsertAttachments($request, 'transaction_attachments');
            $transaction->attachments()->syncWithoutDetaching($attachment_ids);
        }

        /* Send Event Notification */
        /*$notificationObj = new Notification();
        $notificationObj->notification_entry('TRANSACTION-ANT', $transaction->id, auth('business')->id(), config('constants.superadmin'));*/
        /* End Send Event Notification */

        $transaction->load(['sender', 'receiver', 'transaction_type']);
            DB::commit();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.transaction_saved_successfully'),
            'data'    => $transaction,
        ], 201);

         } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a transaction
     */
    public function update(Request $request, $id)
    {
        $businessId = app('currentBusinessId');

        $transaction = Transaction::where('business_id', $businessId)->findOrFail($id);

        $validation = [
            'reciever_party_id'  => 'required|integer',
            'sender_party_id'    => 'required|integer',
            'amount'             => 'required|numeric|min:0.01',
            'transaction_type'   => 'required|string',
            'transfer_mode'      => 'required|string',
            'project_id'         => 'nullable|integer',
            'invoice_id'         => 'required_if:transaction_type,invoice-payment|nullable|integer',
            'date'               => 'nullable|date',
            'description'        => 'nullable|string|max:1000',
        ];

        $validator = \Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.validation_failed'),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $invoice = null;
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::where('business_id', $businessId)->find($request->invoice_id);
            if (!$invoice) {
                return response()->json([
                    'status'  => false,
                    'message' => __('solarmitra::solarmitra.invoice_not_found'),
                ], 404);
            }
        }

        $transactionType = TransactionType::firstWhere('slug', $request->transaction_type);
        if (!$transactionType) {
            return response()->json([
                'status'  => false,
                'message' => __('solarmitra::solarmitra.invalid_transaction_type_default'),
            ], 422);
        }

        $reference_id = 0;
        $reference_type = '';

        if ($request->transaction_type === 'invoice-payment' && $invoice) {
            $reference_id = $invoice->id;
            $reference_type = 'invoice';

            // Reverse old amount, apply new amount
            if ($request->amount != $transaction->amount) {
                $diff = $request->amount - $transaction->amount;
                $invoice->paid_amount = $invoice->paid_amount + $diff;
                $invoice->due_amount = max(0, $invoice->due_amount - $diff);
                $invoice->save();
            }
        } elseif ($request->transaction_type === 'project-expenses') {
            $reference_id = $request->project_id ?? 0;
            $reference_type = 'project';
        }

        $transaction->update([
            'sender_party_id'     => $request->sender_party_id,
            'reciever_party_id'   => $request->reciever_party_id,
            'project_id'          => $request->project_id ?? 0,
            'transaction_type_id' => $transactionType->id,
            'amount'              => $request->amount,
            'reference_id'        => $reference_id,
            'reference_type'      => $reference_type,
            'date'                => $request->filled('date') ? Carbon::parse($request->date)->format(config('solarmitra.date_time_format')) : $transaction->date,
            'description'         => $request->description,
            'transfer_mode'       => $request->transfer_mode,
            'transfer_type'       => $request->transfer_type ?? $transaction->transfer_type,
            'payment_for'         => $request->payment_for,
        ]);

        if ($request->hasFile('transaction_attachments')) {
            $AttachmentObj = new Attachment();
            $attachment_ids = $AttachmentObj->InsertAttachments($request, 'transaction_attachments');
            $transaction->attachments()->syncWithoutDetaching($attachment_ids);
        }

        /* Send Event Notification */
        /*$notificationObj = new Notification();
        $notificationObj->notification_entry('TRANSACTION-UT', $transaction->id, auth('business')->id(), config('constants.superadmin'));*/
        /* End Send Event Notification */

        $transaction->load(['sender', 'receiver', 'transaction_type']);

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.transaction_updated_successfully'),
            'data'    => $transaction,
        ]);
    }

    /**
     * Delete a transaction
     */
    public function destroy($id)
    {
        $businessId = app('currentBusinessId');

        $transaction = Transaction::where('business_id', $businessId)->findOrFail($id);

        /* Send Event Notification */
        /*$notificationObj = new Notification();
        $notificationObj->notification_entry('TRANSACTION-DT', $transaction->id, auth('business')->id(), config('constants.superadmin'));*/
        /* End Send Event Notification */

        $transaction->delete();

        return response()->json([
            'status'  => true,
            'message' => __('solarmitra::solarmitra.transaction_deleted_successfully'),
        ]);
    }

    public function get_expense_head()
    {
        return response()->json([
            'status'  => true,
            'data' => SolarMitraHelper::getExpenseHead(),
        ]);
    }
    
    public function get_income_head()
    {
        return response()->json([
            'status'  => true,
            'data' => SolarMitraHelper::getIncomeHead(),
        ]);
    }
}