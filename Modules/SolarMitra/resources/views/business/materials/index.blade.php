{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    @php
        $is_action =
            (
                auth()->user()->can('SolarMitra > Business > MaterialsController > edit') &&
                auth()->user()->can('SolarMitra > Business > MaterialsController > update')
            ) ||
            auth()->user()->can('SolarMitra > Business > MaterialsController > destroy');

    @endphp

	<div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                <form method="get">
                    <div class="row gy-2">
                        
                        <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control " name="title" value="{{ request('title') }}" placeholder="{{ __('solarmitra::solarmitra.title') }}">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2" name="material_category_id" data-live-search="true" id="QuotationMaterialCategory" data-url="{{ route('business.solarmitra.quotations.get_brands_by_category') }}" data-ajax-container="#QuotationMaterialBrands">
                                <option value="">{{ __('solarmitra::solarmitra.select_category') }}</option>
                                @foreach (SolarMitraHelper::getItemCategoryArr() as $key => $title)
                                    <option value="{{$key}}" @selected(request('material_category_id') == $key)>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2 brand-select" name="material_company_id"  id="QuotationMaterialBrands" data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_brand') }}</option>
                                @foreach (SolarMitraHelper::getItemCompanyArr() as $key => $title)
                                    <option value="{{$key}}" @selected(request('material_company_id') == $key)>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-xl-6">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.materials.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can(['SolarMitra > Business > MaterialsController > create','SolarMitra > Business > MaterialsController > store'])
                            <a href="{{ route('business.solarmitra.materials.create') }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.materials') }}</a>
                            @endcan
                            @can('SolarMitra > Business > MaterialsController > import')
                            <a href="{{ route('business.solarmitra.materials.import') }}" class="btn btn-primary ms-2 float-end"  >{{ __('solarmitra::solarmitra.import') }}</a>
                            @endcan
                            @can('SolarMitra > Business > MaterialsController > export')
                            <a href="{{ route('business.solarmitra.materials.export') }}" class="btn btn-primary ms-2 mt-sm-0 mt-2 float-end"  >{{ __('solarmitra::solarmitra.export') }}</a>
                            @endcan
                        </div>
                    </div>


                </form>
            </div>
            <!-- End - Filtering -->
            
            <!-- Start - Table -->
            <div class="col-xl-12">
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless  rounded m-0 quotation-tbl" id="quatationTbl">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="width200">{{ __('solarmitra::solarmitra.title') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.category') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.unit') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.brands') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.purchase_price') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.selling_price') }}</th>
                                    <th class=" width150">{{ __('solarmitra::solarmitra.gst') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.description') }}</th>
                                    @if($is_action)
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materials as $material)
                                    <tr>
                                        <td>{{$materials->firstItem() + $loop->index}}</td>
                                        <td>{{$material->title}}</td>
                                        <td>{{optional(@$material->material_category)->title}}</td>
                                        <td>{{optional(@$material->material_unit)->title}}</td>
                                        <td>{{optional(@$material->material_company)->title}}</td>
                                        <td>{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number(@$material->purchase_price)}}</td>
                                        <td>{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number(@$material->selling_price)}}</td>
                                        <td>{{round(@$material->gst)}}%</td>
                                        <td title="{{@$material->description}}">{{Str::limit(@$material->description, 70)}}</td>
                                        @if($is_action)
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can(['SolarMitra > Business > MaterialsController > edit','SolarMitra > Business > MaterialsController > update'])
                                                        <a class="dropdown-item" href="{{ route('business.solarmitra.materials.edit',$material->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                        @endcan
                                                        @can('SolarMitra > Business > MaterialsController > destroy')
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.materials.destroy',$material->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $is_action ? 10 : 9 }}" class="text-center">{{ __('solarmitra::solarmitra.no_materials') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($materials && $materials->hasPages())
                    <div class="card-footer">
                        {{ $materials->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                    </div>
                    @endif
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection

@push('inline-scripts')
    <script>
        jQuery(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation(); 
        });
    </script>
@endpush