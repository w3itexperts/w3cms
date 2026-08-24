<div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h5 class="offcanvas-title fw-semibold">{{ __('solarmitra::solarmitra.invoice') }}</h5>
    </div>
    <div class="d-flex gap-2">
        @can('SolarMitra > Business > InvoicesController > view_invoice')
        <a href="{{ route('solarmitra.invoices.view_invoice', Crypt::encrypt($invoice->id)) }}" class="btn btn-sm btn-light btn-square border" target="_blank"><i class="icon icon-eye"></i></a>
        @endcan
        @can('SolarMitra > Business > InvoicesController > download_invoice')
        <a href="{{ route('solarmitra.invoices.download_invoice', Crypt::encrypt($invoice->id)) }}" class="btn btn-sm btn-light btn-square border"><i class="icon icon-download"></i></a>
        @endcan
        @can(['SolarMitra > Business > InvoicesController > edit', 'SolarMitra > Business > InvoicesController > update'])
        <a href="{{ route('business.solarmitra.invoices.edit', $invoice->id) }}" class="btn btn-sm btn-light btn-square border" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd"><i class="icon icon-pencil"></i></a>
        @endcan
    </div>
</div>

<!-- Start - Offcanvas Body -->
<div class="offcanvas-body">
    
    <div class="row mb-3">
        <div class="col-6 d-flex flex-column gap-1">
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Client :</p>
                <span class="fs-12">{{ optional($invoice->client)->name ?? '-' }}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">GST :</p>
                <span class="fs-12">{{ optional($invoice->client)->gst_no ?? '-' }}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Mobile :</p>
                <span class="fs-12">{{ optional($invoice->client)->phone_number ?? '-' }}</span>
            </div>
        </div>
        <div class="col-6 d-flex flex-column gap-1">
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">INV NO :</p>
                <span class="fs-12">{{ $invoice->invoice_number }}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">INV Date :</p>
                <span class="fs-12">{{ $invoice->date }}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Due Date :</p>
                <span class="fs-12">{{ $invoice->due_date }}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Status :</p>
                <span class="fs-12">
                    @if($invoice->status == 2)
                        <span class="badge bg-success">{{ __('solarmitra::solarmitra.paid') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('solarmitra::solarmitra.unpaid') }}</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="bg-primary text-white fs-12">{{ __('solarmitra::solarmitra.item_name') }}</th>
                    <th class="bg-primary text-white fs-12 text-center width180">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->items as $item)
                    <tr>
                        <td>{{ $item->item_title }}</td>
                        <td class="text-center">{{ $item->item_quantity }} {{ $item->item_unit }}</td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <td class="text-end">Item Subtotal</td>
                    <td class="text-end">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->sub_total) }}</td>
                </tr>
                <tr>
                    <td class="text-end">{{ __('solarmitra::solarmitra.discount') }}</td>
                    <td class="text-end">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->sub_total * ($invoice->discount / 100)) }}</td>
                </tr>
                <tr>
                    <td class="text-end">{{ __('solarmitra::solarmitra.additional_charges') }}</td>
                    <td class="text-end">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->aditional_charges) }}</td>
                </tr>
                <tr>
                    <td class="text-end">Additional Tax</td>
                    <td class="text-end">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number(round($invoice->total_amount * ($invoice->tax / (100 + $invoice->tax)), 2)) }}</td>
                </tr>
                <tr>
                    <td class="text-end"><strong>Total</strong></td>
                    <td class="text-end"><strong>{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->total_amount) }}</strong></td>
                </tr>
                <tr>
                    <td class="text-end text-success"><strong>{{ __('solarmitra::solarmitra.paid') }}</strong></td>
                    <td class="text-end text-success"><strong>{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->paid_amount) }}</strong></td>
                </tr>
                <tr>
                    <td class="text-end text-danger"><strong>Due</strong></td>
                    <td class="text-end text-danger"><strong>{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') }}{{ SolarMitraHelper::format_number($invoice->due_amount) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mb-3">
        <h6 class="fs-14 fw-semibold">{{ __('solarmitra::solarmitra.note') }}</h6>
        <p class="mb-0">{{ $invoice->description }}</p>
    </div>

</div>
<!-- End - Offcanvas Body -->