<div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h5 class="offcanvas-title fw-semibold">{{ __('solarmitra::solarmitra.quotation') }}</h5>
    </div>
    <div class="d-flex gap-2">
        @can('SolarMitra > Business > QuotationsController > view_quotation')
        <a href="{{ route('solarmitra.quotations.view_quotation',Crypt::encrypt($quotation->id)) }}" class="btn btn-sm btn-light btn-square border" target="_blank"><i class="icon icon-eye"></i></a>
        @endcan
        @can('SolarMitra > Business > QuotationsController > download_quotation')
        <a href="{{ route('solarmitra.quotations.download_quotation',Crypt::encrypt($quotation->id)) }}" class="btn btn-sm btn-light btn-square border"><i class="icon icon-download"></i></a>
        @endcan
        @can(['SolarMitra > Business > QuotationsController > edit','SolarMitra > Business > QuotationsController > update'])
        <a href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}" class="btn btn-sm btn-light btn-square border"><i class="icon icon-pencil"></i></a>
        @endcan
    </div>
</div>

<!-- Start - Offcanvas Body -->
<div class="offcanvas-body">
    
    <div class="row mb-3">
        <div class="col-6 d-flex flex-column gap-1">
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Client :</p>
                <span class="fs-12">{{optional(@$quotation->client)->name}}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">GST :</p>
                <span class="fs-12">{{optional(@$quotation->client)->gst_no}}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Mobile :</p>
                <span class="fs-12">{{optional(@$quotation->client)->phone_number}}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">Address :</p>
                <span class="fs-12">13 B, Keshavpura, Kota</span>
            </div>
        </div>
        <div class="col-6 d-flex flex-column gap-1">
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">QT NO :</p>
                <span class="fs-12">{{$quotation->quotation_number}}</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <p class="m-0 fs-12">QT Date :</p>
                <span class="fs-12">{{$quotation->date}}</span>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th class="bg-primary text-white fs-12 ">{{ __('solarmitra::solarmitra.item_name') }}</th>
                    <th class="bg-primary text-white fs-12 text-center width180">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotation->items as $item)
                    <tr>
                        <td>{{$item->item_title}}</td>
                        <td class="text-center">{{$item->item_quantity}} {{$item->item_unit}}</td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <td  class="text-end">Item Subtotal</td>
                    <td class="text-end">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->sub_total)}}</td>
                </tr>
                <tr>
                    <td  class="text-end">{{ __('solarmitra::solarmitra.discount') }}</td>
                    <td class="text-end">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->sub_total * ($quotation->discount / 100))}}</td>
                </tr>
                <tr>
                    <td  class="text-end">{{ __('solarmitra::solarmitra.additional_charges') }}</td>
                    <td class="text-end">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->aditional_charges)}}</td>
                </tr>
                <tr>
                    <td  class="text-end">Additional Tax</td>
                    <td class="text-end">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{ SolarMitraHelper::format_number(round($quotation->total_amount * ($quotation->tax / (100 + $quotation->tax)),2)) }}</td>
                </tr>
                <tr>
                    <td  class="text-end"><strong>Total</strong></td>
                    <td class="text-end"><strong>{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="mb-3">
        <h6 class="fs-14 fw-semibold">{{ __('solarmitra::solarmitra.note') }}</h6>
        <p class="mb-0">{{$quotation->description}}</p>
        @if (!in_array(optional(optional($quotation)->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
            <a href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}" class="btn btn-primary d-block" >{{ __('Quotation Approve') }}</a>
        @endif
        @if (optional(optional($quotation)->status)->can_convert && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
            <a href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}" class="btn btn-primary d-block" >{{ __('Create Invoice for this Quotation') }}</a>
        @endif
    </div>

</div>
<!-- End - Offcanvas Body -->