{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

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
                            <select class="selectpicker form-control me-2" name="material_category_id" data-live-search="true" id="QuotationMaterialCategory" data-url="{{ route('admin.solarmitra.quotations.get_brands_by_category') }}" data-ajax-container="#QuotationMaterialBrands">
                                <option value="">Select Category</option>
                                @foreach (SolarMitraHelper::getItemCategoryArr() as $key => $title)
                                    <option value="{{$key}}" @selected(request('material_category_id') == $key)>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2 brand-select" name="material_company_id"  id="QuotationMaterialBrands" data-live-search="true">
                                <option value="">Select Brand</option>
                                @foreach (SolarMitraHelper::getItemCompanyArr() as $key => $title)
                                    <option value="{{$key}}" @selected(request('material_company_id') == $key)>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-xl-6">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('admin.solarmitra.materials.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            <a href="{{ route('admin.solarmitra.materials.create') }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.materials') }}</a>
                            
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
                                    <th class="width100">S.No.</th>
                                    <th class="width200">Title</th>
                                    <th class=" width150">Category</th>
                                    <th class=" width150">Unit</th>
                                    <th class=" width150">Brand</th>
                                    <th class=" width150">Purchase Price</th>
                                    <th class=" width150">Selling Price</th>
                                    <th class=" width150">GST</th>
                                    <th class=" ">Description</th>
                                    <th class=" width100">Actions</th>
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
                                        <td>{{@$material->purchase_price}}</td>
                                        <td>{{@$material->selling_price}}</td>
                                        <td>{{round(@$material->gst)}}%</td>
                                        <td title="{{@$material->description}}">{{Str::limit(@$material->description, 70)}}</td>
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ route('admin.solarmitra.materials.edit',$material->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('admin.solarmitra.materials.destroy',$material->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">{{ __('solarmitra::solarmitra.no_materials') }}</td>
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

@push('inline-css')
     <link href="{{ theme_asset('vendor/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/tagify/tagify.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('modules/solarmitra/css/business-custom.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
    <script src="{{ theme_asset('vendor/tagify/tagify.js') }}"></script>
    <script src="{{ theme_asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
    <script>
        jQuery(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation(); 
        });
    </script>
@endpush