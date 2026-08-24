<form action="{{ route('business.solarmitra.invoices.change_to_paid', $invoice->id) }}" method="post" class="AjaxModalForm" id="InvoicePaymentForm">
    @csrf
    <div class="modal-header justify-content-between">
        <h5 class="modal-title">{{ __('solarmitra::solarmitra.confirm_invoice_payment') }}</h5>
        @if(!$isFullyPaid)
        <a href="{{ route('business.solarmitra.transactions.create',['type'=>'income-invoice-payment','invoice_id'=>$invoice->id]) }}" class="btn btn-primary AjaxOffCanvasShow" >
            <i class="fas fa-plus-circle me-1"></i> Pay
        </a>
        @endif
        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body p-3">
        <div class="row mb-3">
            <div class="col-6">
                <label class="form-label text-muted mb-1">{{ __('solarmitra::solarmitra.invoice_no') }}</label>
                <p class="fw-bold mb-0">{{ $invoice->invoice_number }}</p>
            </div>
            <div class="col-6">
                <label class="form-label text-muted mb-1">{{ __('solarmitra::solarmitra.client') }}</label>
                <p class="fw-bold mb-0">{{ optional($invoice->client)->name ?? '-' }}</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label class="form-label text-muted mb-1">Project</label>
                <p class="fw-bold mb-0">{{ optional($invoice->project)->title ?? '-' }}</p>
            </div>
            <div class="col-6">
                <label class="form-label text-muted mb-1">{{ __('solarmitra::solarmitra.status') }}</label>
                <p class="fw-bold mb-0">
                    @if($invoice->status == 2)
                        <span class="badge bg-success">{{ __('solarmitra::solarmitra.paid') }}</span>
                    @else
                        <span class="badge bg-warning">{{ __('solarmitra::solarmitra.unpaid') }}</span>
                    @endif
                </p>
            </div>
        </div>

        <hr/>

        <div class="row mb-3">
            <div class="col-4">
                <label class="form-label text-muted mb-1">Total Amount</label>
                <p class="fw-bold fs-5 mb-0">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->total_amount) }}</p>
            </div>
            <div class="col-4">
                <label class="form-label text-muted mb-1">{{ __('solarmitra::solarmitra.total_paid') }}</label>
                <p class="fw-bold fs-5 mb-0 text-success">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($totalPaid) }}</p>
            </div>
            <div class="col-4">
                <label class="form-label text-muted mb-1">{{ __('solarmitra::solarmitra.due_amount') }}</label>
                <p class="fw-bold fs-5 mb-0 {{ $dueAmount > 0 ? 'text-danger' : 'text-success' }}">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($dueAmount) }}</p>
            </div>
        </div>

        @if($transactions->count())
        <div class="mt-3">
            <label class="form-label text-muted mb-2">{{ __('solarmitra::solarmitra.payment_history') }}</label>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('solarmitra::solarmitra.date') }}</th>
                            <th>{{ __('solarmitra::solarmitra.type') }}</th>
                            <th class="text-end">{{ __('solarmitra::solarmitra.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $txn)
                        <tr>
                            <td>{{ $txn->date }}</td>
                            <td>{{ optional($txn->transaction_type)->title ?? '-' }}</td>
                            <td class="text-end">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($txn->amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-info mb-0 mt-3">
            <i class="fas fa-info-circle me-1"></i> No payments recorded for this invoice yet.
        </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>

        

        @if($isFullyPaid && $invoice->status != 2)
        <button type="submit" class="btn btn-success" id="ConfirmToPaidBtn">
            <i class="fas fa-check-circle me-1"></i> Confirm To Paid
        </button>
        @elseif(!$isFullyPaid)
        <button type="button" class="btn btn-secondary" disabled title="Invoice is not fully paid. Due: {{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($dueAmount) }}">
            <i class="fas fa-lock me-1"></i> Confirm To Paid
        </button>
        @endif
    </div>
</form>