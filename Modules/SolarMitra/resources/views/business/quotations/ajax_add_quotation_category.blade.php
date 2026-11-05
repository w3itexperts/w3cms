<tr data-item="{{ $category->id }}">
    <td>
        <span class="s-no-box">{{ $length + 1 }}</span>
    </td>
    <td>
        {{$category->title}}
    </td>
    <td>
        <div class="quotationItemContainer{{ $category->id }}">

            <!--- Items Related Inputs if Current Category exist in quotation items --->
            <div class="row mb-2 quotationItem quotationItem{{ $category->id }}">
                <div class="col-4">
                    <select class="form-select brand-select" name="item[{{ $itemCount }}][material_company_id]" data-category="{{ $category->id }}" data-target="#Project{{$category->slug}}Item{{ $itemCount }}" data-selected-items='@json([$item['item_id'] ?? null])'
                    >
                        <option value="">Select Brand/Services</option>
                        @foreach(SolarMitraHelper::getCompaniesByCategoryArr($category->id) as $id => $title)
                            <option value="{{ $id }}" @selected($material->material_company_id == $id)>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <select class="form-select quotationItemSelect" name="item[{{ $itemCount }}][item_id]" id="Project{{$category->slug}}Item{{ $itemCount }}">
                        <option value="">Select {{$category->title}}</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" @selected($material->id == $item->id)>{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <p class="item-description m-0 text-wrap">{{$material->description}}</p>
                </div>

                <div class="col-2 ">
                    <input name="item[{{ $itemCount }}][item_quantity]" type="number" min="1" class="form-control-sm form-control quantity width100 d-inline-block" value="1" placeholder="Qty">
                    <span class="item-unit">{{@$material->material_unit->title}}</span> 
                    <input type="hidden" name="item[{{ $itemCount }}][material_category_id]" value="{{ $category->id }}">
                    <input type="hidden" class="item-total" name="item[{{ $itemCount }}][amount]" value="{{$material->selling_price}}">
                    <input type="hidden" class="price" name="item[{{ $itemCount }}][rates_per_units]" value="{{$material->selling_price}}">
                    <input type="hidden" class="tax" name="item[{{ $itemCount }}][gst]" value="{{$material->gst}}">
                    @if (SolarMitraHelper::getBusinessConfig('enable_item_level_pricing',false))
                    {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}<span class="total-text"> {{$item->selling_price}} </span>
                    @endif
                </div>
            </div>
        </div>
        <button 
            name="add_more" 
            class="addMoreItem btn btn-link float-start" 
            data-item-class="quotationItem{{ $category->id }}"
            data-item-container="quotationItemContainer{{ $category->id }}"
            data-item-limit="5"
            data-limit-message="you can't add any more."
            data-model="{{ $category->title }}"
            data-slug="{{ $category->slug }}"
            data-category-id="{{ $category->id }}"
            data-url="{{ route('business.solarmitra.quotations.ajax_quotation_addmore_item') }}"
        >+ Add More</button>  
        
        
    </td>
</tr>