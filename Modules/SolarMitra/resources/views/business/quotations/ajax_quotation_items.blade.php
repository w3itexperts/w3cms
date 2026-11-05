<table class="table table-bottom-borderless mb-0">
    <thead class="thead-transparent">
        <tr>
            <th class="width20">{{ __('solarmitra::solarmitra.s_no') }}</th>
            <th class="width120">{{ __('solarmitra::solarmitra.category') }}</th>
            <th class=" ">{{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.details') }}</th>
        </tr>
    </thead>
    <tbody id="QuotationBodyTable">
        @php
            $itemCount = 0;
            $length = 0;
            $oldItems = old('item', []);
        @endphp
        @forelse ($categories as $category)
            @php
                if (isset($project_type) && $category->slug == 'battery' && $project_type == 'On-Grid'  ){
                    continue;
                }
            @endphp
            <tr data-item="{{ $category->id }}">
                <td>
                    <span class="s-no-box">{{ $length + 1 }}</span>
                </td>
                <td>
                    {{$category->title}}
                </td>
                <td>
                    <div class="quotationItemContainer{{ $category->id }}">
                        @php
                            $categoryItems = collect($oldItems)->where('material_category_id', $category->id);
                            
                            if ($categoryItems->isEmpty() && isset($quotation)) {
                                $categoryItems = $quotation->items->where('material_category_id', $category->id)->map(function($item) use($category){
                                    $item->load('material_item');
                                    return [
                                        'material_company_id' => $item->material_company_id,
                                        'item_id' => $item->item_id,
                                        'item_unit' => $item->item_unit,
                                        'item_quantity' => $item->item_quantity,
                                        'amount' => $item->amount,
                                        'rates_per_units' => $item->rates_per_units,
                                        'gst' => $item->gst,
                                        'description' => $item->description,
                                        'material_category_id' => $item->material_category_id,
                                    ];
                                });
                            }

                            if ($categoryItems->isEmpty()) {
                                $categoryItems = collect([[
                                    'material_company_id' => '',
                                    'item_id' => '',
                                    'item_unit' => '',
                                    'item_quantity' => 1,
                                    'amount' => '',
                                    'rates_per_units' => '',
                                    'gst' => '',
                                    'description' => '',
                                    'material_category_id' => $category->id,
                                ]]);
                            }
                        @endphp

                        @foreach ($categoryItems as $key => $item)
                            <div class="row mb-2 quotationItem quotationItem{{ $category->id }}">
                                <div class="col-4">
                                    <select class="form-select brand-select default-select" name="item[{{ $itemCount }}][material_company_id]" data-category="{{ $category->id }}" data-target="#Project{{$category->slug}}Item{{ $itemCount }}" data-selected-items='@json([$item['item_id'] ?? null])' data-live-search="true">
                                        <option value="">Select Brand/Services</option>
                                        @foreach(SolarMitraHelper::getCompaniesByCategoryArr($category->id) as $id => $title)
                                            <option value="{{ $id }}" @selected(($item['material_company_id'] ?? '') == $id)>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6">
                                    <select class="form-select quotationItemSelect default-select" name="item[{{ $itemCount }}][item_id]" id="Project{{$category->slug}}Item{{ $itemCount }}" data-live-search="true">
                                        <option value="">Select {{$category->title}}</option>
                                    </select>
                                    @if (SolarMitraHelper::getBusinessConfig('show_item_description',true))
                                    <p class="item-description m-0 text-wrap">{{ $item['description'] ?? '' }}</p>
                                    @endif
                                </div>

                                <div class="col-2 ">
                                    <input name="item[{{ $itemCount }}][item_quantity]" type="number" min="1" class="form-control-sm form-control quantity width80 d-inline-block" value="{{ $item['item_quantity'] ?? 1 }}" placeholder="Qty">
                                    <span class="item-unit">{{@$item['item_unit']}}</span> 
                                    <input type="hidden" name="item[{{ $itemCount }}][material_category_id]" value="{{ $category->id }}">
                                    <input type="hidden" class="item-total" name="item[{{ $itemCount }}][amount]" value="{{ $item['amount'] ?? '' }}">
                                    <input type="hidden" class="price" name="item[{{ $itemCount }}][rates_per_units]" value="{{ $item['rates_per_units'] ?? '' }}">
                                    <input type="hidden" class="tax" name="item[{{ $itemCount }}][gst]" value="{{ $item['gst'] ?? '' }}">
                                    @if (SolarMitraHelper::getBusinessConfig('enable_item_level_pricing',false))
                                    {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}<span class="total-text"> {{ $item['amount'] ?? '' }} </span>
                                    @endif
                                    @if (!$loop->first)
                                    <button type="button" class="btn btn-outline-danger px-2 py-1 RemoveQuotationItem"> x </button>
                                    @endif
                                </div>
                            </div>

                            @php $itemCount++; @endphp
                        @endforeach
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
            @php
                $length++;
            @endphp
        @empty
        @endforelse
    </tbody>
</table>