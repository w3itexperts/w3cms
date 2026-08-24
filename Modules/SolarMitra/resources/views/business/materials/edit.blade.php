{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    <form action="{{ route('business.solarmitra.materials.update',@$material->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.material') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.material') }} {{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" value="{{@$material->title}}">
                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">{{ __('Select Material Category') }} <span class="text-danger">*</span></label>
                                <select name="material_category_id" id="MaterialCategorySelect" data-url="{{ route('business.solarmitra.materials.get_unit_by_category') }}" class="form-select  text-primary">
                                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.category') }}</option>
                                    @forelse ($material_categories as $cat_id => $cat_title)
                                        <option value="{{$cat_id}}" @selected(@$material->material_category_id == $cat_id)>{{$cat_title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('material_category_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                @error('material_company_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                @error('unit_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('solarmitra::solarmitra.purchase_price') }} <span class="text-danger">*</span></label>
                                <input type="number" min="0" step="any" class="form-control" name="purchase_price" id="MaterialPurchasePrice" value="{{@$material->purchase_price}}" >
                                @error('purchase_price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3" id="WeightPerPieceBox" style="{{ (@$material_categories[@$material->material_category_id] == 'Structure') ? '' : 'display: none;'}}">
                                <label class="form-label">{{ __('Weight Per Piece (Kg)') }} <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" class="form-control" id="WeightPerPiece" name="weight_per_piece" value="{{@$material->weight_per_piece}}">
                                <input type="hidden" name="gi_price_per_kg" id="GiPricePerKg" value="{{SolarMitraHelper::getBusinessConfig('gi_price_per_kg',1)}}">
                                @error('weight_per_piece')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3" id="PanelWattageBox" style="{{ (@$material_categories[@$material->material_category_id] == 'Panel') ? '' : 'display: none;'}}">
                                <label class="form-label">{{ __('Panel Wattage') }} <span class="text-danger">*</span></label>
                                <input type="number" step="any" min="0" class="form-control" id="PanelWattage" name="panel_wattage" value="{{@$material->panel_wattage}}">
                                @error('panel_wattage')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('solarmitra::solarmitra.selling_price') }} (Excluded GST)</label>
                                <input type="number" step="any" min="0" class="form-control" name="selling_price"  id="MaterialSellingPrice" value="{{@$material->selling_price}}" {{  @$material_categories[@$material->material_category_id] == 'Structure' ? '' : ''}}>
                                @error('selling_price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('solarmitra::solarmitra.gst') }} (in percentage %)</label>
                                <input type="number" step="any" min="0" class="form-control" id="MaterialGST" name="gst" value="{{@$material->gst}}">
                                @error('gst')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('Price (Included GST)') }}</label>
                                <input type="number" step="any" min="0" id="MaterialCalculatedPrice" class="form-control" name="gst" value="" readonly>
                                @error('gst')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('Hsn Sac') }} </label>
                                <input type="text" class="form-control" name="hsn_sac" value="{{@$material->hsn_sac}}">
                                @error('hsn_sac')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('Search Tags') }} </label>
                                <input class="form-control basic-tagify" name='search_tags' id="search_tags" value="{{@$material->search_tags}}" autofocus>
                            </div>
                            <div class="col-6 mb-3 ">
                                <label class="form-label">{{ __('Description') }} </label>
                                <textarea name="description" class="form-control"> {{@$material->description}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                        <a href="{{ route('business.solarmitra.materials.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                    </div>
                </div>
            </div>  
        </div>
    </form>
</div>
@endsection

