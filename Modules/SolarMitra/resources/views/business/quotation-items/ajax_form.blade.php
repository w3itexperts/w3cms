<form action="{{@$quotationItem->id ? route('business.solarmitra.quotations_items.update',@$quotationItem->id) : route('business.solarmitra.quotations_items.store')}}" method="Post">
    @csrf
    @if (@$quotationItem->quotation_id || request('quotation_id'))
        <input type="hidden" name="quotation_id" value="{{request('quotation_id') ?? @$quotationItem->quotation_id}}">
    @endif
    <div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div>
                <h5 class="offcanvas-title fw-semibold text-uppercase">{{@$quotationItem->id ? 'Edit Item' : 'New Item'}}</h5>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
    </div>

    <!-- Start - Offcanvas Body -->
    <div class="offcanvas-body">
        
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.name') }}</label>
            <input type="text" class="form-control" name="item_title" value="{{@$quotationItem->item_title}}" placeholder="{{ __('solarmitra::solarmitra.enter') }} {{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.code') }}</label>
            <input type="text" class="form-control" name="item_id" value="{{@$quotationItem->item_id}}" placeholder="{{ __('solarmitra::solarmitra.enter') }} {{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.code') }}">
        </div>

        <div class="d-flex gap-2 mb-4">
            <div class="w-50">
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.unit') }}</label>
                <select name="item_unit" class="form-control selectpicker">
                    @forelse (SolarMitraHelper::getItemUnitsArr() as $id => $title)
                        <option value="{{$id}}" @selected(@$quotationItem->item_unit == $id)>{{$title}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="w-50">
                <label for="est-quality" class="form-label">GST %</label>
                <select name="gst" class="form-control selectpicker">
                    @forelse (config('solarmitra.gst_rates') as $rate)
                        <option value="{{$rate}}"  @selected(@$quotationItem->gst == $rate)>{{$rate}}%</option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">Estimated Qty.</label>
            <input type="number" name="item_quantity" value="{{@$quotationItem->item_quantity}}" class="form-control" placeholder="0">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="m-0">{{ __('solarmitra::solarmitra.per_unit_amount') }}</h5>
            <div class="position-relative">
                <label class="float-form-label text-uppercase">{{ __('solarmitra::solarmitra.amount') }}</label>
                <input type="number" name="rates_per_units" value="{{@$quotationItem->rates_per_units}}" class="form-control" placeholder="0">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="m-0">{{ __('solarmitra::solarmitra.discount') }}</h5>
            <div class="position-relative">
                <label class="float-form-label text-uppercase">Discount (%)</label>
                <input type="number" name="discount" class="form-control" value="{{@$quotationItem->discount}}" placeholder="0">
            </div>
        </div>

        

        <div class="mb-3 add-input-box">
            <div class="d-flex justify-content-end">
                <a class="add-input-btn" href="javascript:void(0);">+ HSN/SAC</a>
            </div>
            <div class="input-content">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2 remove-input-btn">
                        <i class="icon icon-x-circle fs-18 pointer fw-medium"></i>
                        <label class="pointer">HSN/SAC</label>
                    </div>
                    <input type="text" class="form-control w-50">
                </div>
            </div>
        </div>

        <div class="mb-3 add-input-box">
            <div class="d-flex justify-content-end">
                <a class="add-input-btn" href="javascript:void(0);">+ Description</a>
            </div>
            <div class="input-content" style="display: none;">
                <div>
                    <div class="d-flex align-items-center gap-2 remove-input-btn">
                        <i class="icon icon-x-circle fs-18 pointer fw-medium"></i>
                        <label class="pointer">{{ __('solarmitra::solarmitra.note') }}</label>
                    </div>
                    <textarea name="description" class="form-control mt-3">{{@$quotationItem->description}}</textarea>
                </div>
            </div>
        </div>

        <div>
            <form action="javascript:void(0);" class="custom-dropzone dropzone pointer dz-clickable">
                <div class="dz-default dz-message pointer">
                    <button class="dz-button" type="button">{{ __('solarmitra::solarmitra.upload_bills') }}<i class="ms-2 icon-upload text-primary fs-18"></i></button>
                </div>
            </form>
        </div>
        <div class="mt-5">
            <form action="javascript:void(0);" class="dropzone dz-clickable">
                <div class="dz-default dz-message">
                    <button class="dz-button" type="button">{{ __('solarmitra::solarmitra.upload_bills') }}</button>
                </div>
            </form>
        </div>
        <div class="mt-5">
            <form action="javascript:void(0);" class="dropzone dz-clickable">
                <div class="dz-default dz-message">
                    <button class="dz-button" type="button">{{ __('solarmitra::solarmitra.upload_bills') }}</button>
                </div>
            </form>
        </div>

    </div>
    <!-- End - Offcanvas Body -->
</form>