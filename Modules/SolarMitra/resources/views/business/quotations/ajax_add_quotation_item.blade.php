<div class="row mb-2 quotationItem quotationItem{{ $category_id }}">
    
    <div class="col-4">
        <select class="form-select brand-select default-select" name="item[{{ $next_item_count }}][material_company_id]" data-target="#Project{{$category_slug}}Item{{ $next_item_count }}" data-category="{{$category_id}}" data-live-search="true">
            <option value="">Select Brand/Services</option>
            @php
                $category_companies = SolarMitraHelper::getCompaniesByCategoryArr($category_id);
            @endphp
            @foreach($category_companies as $id => $title)
                <option value="{{ $id }}" >{{ $title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-6">
        <select class="form-select quotationItemSelect default-select" name="item[{{ $next_item_count }}][item_id]" id="Project{{$category_slug}}Item{{ $next_item_count }}" data-live-search="true">
        <option value="">Select {{$category_title}}</option>
        </select>
        <p class="item-description m-0 text-wrap"></p>
    </div>
    <div class="col-2 ">
        <input name="item[{{ $next_item_count }}][item_quantity]" type="number" class="form-control-sm form-control quantity width80 d-inline-block" min="1" value="1"  placeholder="Qty" >
        <span class="item-unit">{{@$item['item_unit']}}</span> 
        <input type="hidden" name="item[{{ $next_item_count }}][material_category_id]" value="{{ $category_id }}">
        <input type="hidden" class="item-total" name="item[{{ $next_item_count }}][amount]" value="" >
        <input type="hidden" class="price" name="item[{{ $next_item_count }}][rates_per_units]" value="" >
        <input type="hidden" class="tax" name="item[{{ $next_item_count }}][gst]" value="" >
        @if (SolarMitraHelper::getBusinessConfig('enable_item_level_pricing',false))
        {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}<span class="total-text"> 00.0 </span>
        @endif
        <button class="btn btn-outline-danger px-2 py-1 RemoveQuotationItem">x</button>
    </div>
</div>