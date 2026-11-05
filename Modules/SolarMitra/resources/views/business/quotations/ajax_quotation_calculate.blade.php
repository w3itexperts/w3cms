<div>
    @php
        $currency_symbol = SolarMitraHelper::getBusinessConfig('currency_symbol', '₹');
        $B2AmountExceptTotalAmount = !empty($B2AmountExceptTotalAmount) ? $B2AmountExceptTotalAmount : 0;
        $total_amount = !empty($total_amount) ? $total_amount : (!empty(@$quotation->total_amount) ? $quotation->total_amount : 0);

    @endphp
    @if (SolarMitraHelper::getBusinessConfig('show_tax_breakup', true))
    <p class="d-flex justify-content-between mb-2 border-top pt-2">Net Subtotal: <span>{{$currency_symbol}}<span class="text-black fw-semibold" id="net_subtotal">{{@$net_subtotal ?? 0}}</span></span></p>
    @endif

    <input type="hidden" id="margin_value" name="margin_value" value="{{@$margin_value}}">
    <input type="hidden" id="margin_unit" name="margin_unit" value="{{@$margin_unit}}">
    <input type="hidden" id="subtotal_val" name="sub_total" value="{{@$subtotal_val ?? @$quotation->sub_total}}">
</div>
@if (SolarMitraHelper::getBusinessConfig('allow_discount', true))
<div class="d-flex justify-content-between my-2">
    <span class="text-gray">Additional Discount ({{SolarMitraHelper::getBusinessConfig('discount_type', '%')}})</span>
    <input type="number" step="any" max="{{SolarMitraHelper::getBusinessConfig('max_discount_limit', '100')}}" value="{{ request('additional_discount_percent', @$quotation->discount) }}" name="discount" class="form-control form-control-sm width100 checkMaxNumber" id="additional_discount" placeholder="0">
</div>
@endif
<div class="d-flex justify-content-between my-2">
    <span class="text-gray">Additional Charges ({{SolarMitraHelper::getBusinessConfig('currency_code', 'INR')}})</span>
    <input type="number" step="any" value="{{ request('additional_charges', @$quotation->aditional_charges) }}" name="aditional_charges" class="form-control form-control-sm width100" id="additional_charges" placeholder="0">
</div>
<hr class="my-4">
<input type="hidden" id="total_val" name="total_amount" value="{{@$total_val}}">
<table class="table table-bordered text-end">
    <thead>
        <tr>
            <th>Tax</th>
            <th>Amount</th>
            <th id="total_amount">Total Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$currency_symbol}} {{ SolarMitraHelper::format_number(($total_val??0) - $B2AmountExceptTotalAmount) }}</td>
            <td>{{$currency_symbol}} {{ SolarMitraHelper::format_number($B2AmountExceptTotalAmount) }}</td>
            <td id="total_amount">{{$currency_symbol}} {{ $total_amount }}</td>
        </tr>
    </tbody>
</table> 