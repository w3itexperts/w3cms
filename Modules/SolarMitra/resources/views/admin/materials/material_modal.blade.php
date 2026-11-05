<form method="post" action="{{@$material->id ? route('admin.solarmitra.materials.update',@$material->id) : route('admin.solarmitra.materials.store')}}" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;Loading... </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$material->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.material') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.material') }} {{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{@$material->title}}">
                <p class="text-danger error-text m-0 title_error"></p>
                
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('Select Material Category') }} <span class="text-danger">*</span></label>
                <select name="material_category_id" id="MaterialCategorySelect" data-url="{{ route('admin.solarmitra.materials.get_unit_by_category') }}" class="form-select  text-primary">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.category') }}</option>
                    @forelse ($material_categories as $material_category)
                        <option value="{{$material_category->id}}" data-gst="{{$material_category->gst}}" data-unit="{{$material_category->unit_id}}" @selected(@$material->material_category_id == $material_category->id)>{{$material_category->title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text m-0 material_category_id_error"></p>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('Select Material Company') }} <span class="text-danger">*</span></label>
                <select name="material_company_id" class="form-select  text-primary">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('Company') }}</option>
                    @forelse ($material_companies as $company_id => $company_title)
                        <option value="{{$company_id}}" @selected(@$material->material_company_id == $company_id)>{{$company_title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text m-0 material_company_id_error"></p>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('Select Material Unit') }} <span class="text-danger">*</span></label>
                <select name="unit_id" id="MaterialUnitSelect" class="form-select  text-primary">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.material') }}</option>
                    @forelse ($material_units as $unit_id => $unit_title)
                        <option value="{{$unit_id}}" @selected(@$material->unit_id == $unit_id)>{{$unit_title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text m-0 unit_id_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.purchase_price') }} <span class="text-danger">*</span></label>
                <input type="number" min="0" step="any" class="form-control" name="purchase_price" id="MaterialPurchasePrice" value="{{@$material->purchase_price}}">
                <p class="text-danger error-text m-0 purchase_price_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.selling_price') }} <span class="text-danger">*</span></label>
                <input type="number" min="0" step="any" class="form-control" name="selling_price" id="MaterialSellingPrice" value="{{@$material->selling_price}}">
                <p class="text-danger error-text m-0 selling_price_error"></p>
            </div>
            <div class="col-12 mb-3 " id="WeightPerPieceBox" style="display: none;">
                <label class="form-label">{{ __('Weight Per Piece (Kg)') }} </label>
                <input type="number" min="0" step="any" class="form-control" id="WeightPerPiece" name="weight_per_piece" value="{{@$material->weight_per_piece}}">
                <input type="hidden" name="gi_price_per_kg" id="GiPricePerKg" value="{{SolarMitraHelper::getBusinessConfig('gi_price_per_kg',1)}}">
                <p class="text-danger error-text m-0 weight_per_piece_error"></p>
            </div>
            <div class="col-12 mb-3" id="PanelWattageBox" style="display: none;">
                <label class="form-label">{{ __('Panel Wattage') }} </label>
                <input type="number" min="0" step="any" class="form-control" id="PanelWattage" name="panel_wattage" value="{{@$material->panel_wattage}}">
                <p class="text-danger error-text m-0 panel_wattage_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.gst') }} (in percentage %)</label>
                <input type="number" step="any" min="0" max="100" id="MaterialGST" class="form-control" name="gst" value="{{@$material->gst}}">
                <p class="text-danger error-text m-0 gst_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('Hsn Sac') }} </label>
                <input type="text" class="form-control" name="hsn_sac" value="{{@$material->hsn_sac}}">
                <p class="text-danger error-text m-0 hsn_sac_error"></p>
            </div>
            <div class="col-12 mb-3 ">
                <label class="form-label">{{ __('Search Tags') }} </label>
                <input class="form-control basic-tagify" name='search_tags' id="search_tags" value="{{@$material->search_tags}}" autofocus>
            </div>
            <div class="col-12 mb-3 ">
                <label class="form-label">{{ __('Description') }} </label>
                <textarea name="description" class="form-control h-auto" rows="3"> {{@$material->description}}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$material->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.material') }}</button>
        </div>
    </div>
</form>