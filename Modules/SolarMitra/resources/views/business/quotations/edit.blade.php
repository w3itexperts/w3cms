{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <!-- Start - Filtering -->
        <form method="post" action="{{ route('business.solarmitra.quotations.update',@$quotation->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="todo" value="QuotationEditForm">
            <input type="hidden" name="business_id" value="{{@$quotation->business_id}}">
            <input type="hidden" name="client_id" value="{{@$quotation->client_id}}">
            <input type="hidden" name="project_id" value="{{@$quotation->project_id}}">
            <input type="hidden" name="title" value="{{@$quotation->title}}">
            <h4>{{optional(@$quotation->project)->title}}</h4>
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="clearfix row">
                        
                            <!-- Start - Edit Quatation Subject -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3 d-flex gap-4 align-items-center">
                                    <div>
                                        <h6 class="m-0">{{optional($quotation->client)->name}}</h6>
                                        <p class="m-0 fs-10">{{$quotation->title}}</p>
                                    </div>
                                    <a href="{{route('business.solarmitra.quotations.edit',@$quotation->id)}}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">
                                        <i class="icon icon-pencil fs-18"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- End - Edit Quatation Subject -->

                            <!-- Start - Edit Quatation Number -->
                            <div class="col-1 mb-3">
                                <div class="bg-white border rounded p-3 pointer">
                                    <p class="mb-1 fs-10">QT. NO.</p>
                                    <input class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm " name="quotation_number" value="{{@$quotation->quotation_number}}" placeholder="Quo. No." type="text" readonly>
                                </div>
                            </div>
                            <!-- End - Edit Quatation Number -->

                            <!-- Start - Edit Date -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3  pointer" >
                                    <p class="mb-1 fs-10">QT. Date</p>
                                    <input class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm w-100 bs-datepicke DateTimePicker"  name="date" value="{{$quotation->date}}" type="text" />
                                    @error('date')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text date_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Date -->

                            <!-- Start - Edit Valid Till Date -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3 pointer" >
                                        <p class="mb-1 fs-10">QT. Valid Till</p>
                                        <input class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm w-100 bs-datepicker DateTimePicker"  name="valid_till_date" value="{{$quotation->valid_till_date}}" type="text" />
                                        @error('valid_till_date')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                        <p class="text-danger error-text valid_till_date_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Valid Till Date -->
                            
                            <!-- Start - Edit Quatation Status -->
                            <div class="col-1 mb-3">
                                <div class="bg-white border rounded p-3 pointer">
                                    <p class="mb-0 fs-10">{{ __('solarmitra::solarmitra.status') }}</p>
                                    <select name="status" class="qt-select form-control selectpicker text-primary">
                                        <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
                                        @foreach (config('solarmitra.quotations_status') as $key => $title)
                                            <option value="{{$key}}" @selected($key == $quotation->quotation_status_id)>{{$title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- End - Edit Quatation Status -->
                            
                            <!-- Start - Edit Project Type -->
                            <div class="col-1 mb-3">
                                <div class="bg-white border rounded p-3 pointer">
                                    <p class="mb-0 fs-10">Project Type</p>
                                    <select class="qt-select form-control selectpicker text-primary " name="project_type" id="ProjectTypeSelect">
                                        @foreach (config('solarmitra.project_types') as $projectType)
                                            <option value="{{$projectType}}" @selected(old('project_type', optional($quotation->project)->project_type) == $projectType)>{{$projectType}}</option>
                                        @endforeach
                                    </select>
                                    @error('project_type')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text project_type_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Project Type -->
                            
                            <!-- Start - Edit Project Capacity -->
                            <div class="col-1 mb-3">
                                <div class="bg-white border rounded p-3  pointer">
                                    <p class="mb-0 fs-10">Project Capacity</p>
                                    <select class="qt-select form-control selectpicker text-primary" name="capacity" id="SolorCapacitySelect">
                                        @foreach (config('solarmitra.projects_capacity') as $capacity)
                                            <option value="{{$capacity}}" @selected(old('capacity', optional($quotation->project)->capacity) == $capacity)>{{$capacity}}</option>
                                        @endforeach
                                    </select>
                                    @error('capacity')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text capacity_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Project Capacity -->
                            
                            <!-- Start - Edit Start Date -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3 pointer">
                                    <p class="mb-1 fs-10">{{ __('solarmitra::solarmitra.expexted_start_date') }}</p>
                                    <input class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm w-100 bs-datepicker DateTimePicker"  name="start_date" value="{{optional($quotation->project)->start_date}}" type="text" />
                                    @error('start_date')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text start_date_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Start Date -->
                            
                            <!-- Start - Edit End Date -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3  pointer">
                                    <p class="mb-1 fs-10">{{ __('solarmitra::solarmitra.expexted_end_date') }}</p>
                                    <input class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm w-100 bs-datepicker DateTimePicker"  name="end_date" value="{{optional($quotation->project)->end_date}}" type="text" />
                                    @error('end_date')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text end_date_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit End Date -->
                            
                            <!-- Start - Edit Location -->
                            <div class="col-2 mb-3">
                                <div class="bg-white border rounded p-3 pointer">
                                    <p class="mb-1 fs-10">{{ __('solarmitra::solarmitra.location') }}</p>
                                    <input type="text" class="form-control text-black shadow-none form-control-xs border-0 p-0 fs-14 lh-sm w-100" name="location" placeholder="Area - City" value="{{old('location', optional($quotation->project)->location)}}">
                                    @error('location')<p class="text-danger m-0">{{ $message }}</p>@enderror
                                    <p class="text-danger error-text location_error m-0"></p>
                                </div>
                            </div>
                            <!-- End - Edit Location -->


                            <div class="col align-items-center justify-content-end d-flex gap-3">
                                @if (optional(optional($quotation)->status)->can_convert)
                                <a href="{{ route('business.solarmitra.quotations.convert_to_invoice',@$quotation->id) }}" class="btn btn-xl btn-outline-primary">Convert to Invoice</a>
                                @endif
                                
                                <button type="submit" class="btn btn-primary btn-xl">{{ __('solarmitra::solarmitra.save') }} {{ __('solarmitra::solarmitra.quotation') }}</button>
                                <a href="{{ route('business.solarmitra.quotations.index') }}" class="btn btn-outline-primary btn-square"><i class="icon icon-x"></i></a>
                            </div>
                        </div>
                            

                    </div>

                    <div class="card h-auto">
                        <div class="row card-body align-items-end">
                            <div class="col-3 ">
                                <div class="">
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.category') }}</label>
                                    <select name="material_category_id" id="QuotationMaterialCategory" data-url="{{ route('business.solarmitra.quotations.get_brands_by_category') }}" data-ajax-container="#QuotationMaterialBrands" data-live-search="true" class="form-control selectpicker">
                                        <option value="" >{{ __('solarmitra::solarmitra.select_category') }}</option>
                                        @forelse ($excluded_categories as $excluded_category)
                                            <option value="{{$excluded_category->id}}" >{{$excluded_category->title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 ">
                                <div class="">
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.brands') }}</label>
                                    <select name="material_company_id" id="QuotationMaterialBrands" data-target="#QuotationMaterialItem" data-live-search="true" class="form-control selectpicker brand-select">
                                        <option value="" >Select Brand/Services</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 ">
                                <div class="">
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.item') }}</label>
                                    <select name="material_item_id" id="QuotationMaterialItem" data-live-search="true" class="form-control selectpicker" data-url="{{ route('business.solarmitra.quotations.add_quotation_category') }}">
                                        <option value="" >{{ __('Select Item') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 d-flex align-items-end justify-content-between">
                                <button class="btn btn-primary" id="AddQuotationMaterialItem"> Add Item</button>
                                <div>
                                    <label for="is_solar_kit_project" class="form-label text-uppercase">Solar Kit Project </label>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input check-input" data-url="{{ route('business.solarmitra.quotations.ajax_quotation_items',$quotation->id) }}" name="is_solar_kit_project" value="1" @checked(optional($quotation->project)->is_solar_kit_project == 1) id="EnableSolarKitCheck">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Filtering -->

                <!-- Start - Table -->
                <div class="col-xl-12">
                    <div class="card table-hover text-nowrap quotation-tbl" id="SolarItemsContainer">
                        @include('solarmitra::business.quotations.ajax_quotation_items')
                    </div>
                </div>
                <!-- End - Table -->
            

            <!-- Start - Bank Details -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-body">
                                <div>
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.note') }}</label>
                                    <textarea class="form-control h-auto" name="description" rows="6">{{$quotation->description}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-6 ps-0">
                            <div class="card-body d-flex flex-column h-100" id="QuotationCalculationContainer">
                                @include('solarmitra::business.quotations.ajax_quotation_calculate')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End - Bank Details -->

        </div>
        </form>
    </div>
    
@endsection

@push('inline-scripts')
    <script>
        var quotation_calculate_url = '{{ route('business.solarmitra.quotations.ajax_quotation_calculate',@$quotation->id) }}';
    </script>
@endpush