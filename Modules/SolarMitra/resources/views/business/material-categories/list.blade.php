{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

	<div class="container-fluid">
        <div class="row">

            <div class="col-xl-4">

                <div class="card h-auto">
                    <div class="card-header d-block">
                        @if($materialCategory->id)
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.material_category') }}</h4>
                        @else
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.material_category') }}</h4>
                        @endif
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group mb-3">
                                    <label for="parent_id" class="form-label">{{ __('solarmitra::solarmitra.parent') }} {{ __('solarmitra::solarmitra.material_category') }}</label>
                                    <select name="parent_id" id="parent_id" class="default-select form-control selectpicker">
                                        <option value="">{{ __('solarmitra::solarmitra.no_parent') }}</option>
                                        @forelse($material_categories as $material_category)
                                            @if ($materialCategory->id != $material_category['id'])
                                                <option value="{{ $material_category['id'] }}" {{ old('parent_id', $materialCategory->parent_id) == $material_category['id'] ? 'selected="selected"' : '' }}>{{ $material_category['title'] }}</option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">{{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', $materialCategory->title) }}"  >
                                    @error('title')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="display_on_invoice" class="form-label">{{ __('Display on Invoice') }}</label>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input check-input" name="display_on_invoice" value="1" @checked($materialCategory->display_on_invoice == 1) id="display_on_invoice">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="include_in_solar_kit" class="form-label">{{ __('Include in Solar Kit') }}</label>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input check-input" name="include_in_solar_kit" value="1" @checked($materialCategory->include_in_solar_kit == 1) id="include_in_solar_kit">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="calculate_in_invoice" class="form-label">{{ __('Calculate in Invoice') }}</label>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input check-input" name="calculate_in_invoice" value="1" @checked($materialCategory->calculate_in_invoice == 1) id="calculate_in_invoice">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="unit_id" class="form-label">{{ __('Unit') }}</label>
                                    <select name="unit_id" id="unit_id" class="default-select form-control selectpicker">
                                        <option value="">{{ __('Select Unit') }}</option>
                                        @forelse($material_units as $unit_key => $unit_title)
                                                <option value="{{ $unit_key }}" {{ old('unit_id', $materialCategory->unit_id) == $unit_key ? 'selected="selected"' : '' }}>{{ $unit_title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.gst') }} (in percentage %)</label>
                                    <input type="number" step="any" min="0" max="100" class="form-control" name="gst" value="{{@$materialCategory->gst}}">
                                    @error('gst')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">{{ __('solarmitra::solarmitra.description') }}</label>
                                    <textarea name="description" id="description" class="form-control h-100" rows="5">{{ old('description', $materialCategory->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id" value="{{ $materialCategory->id }}">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            <a href="{{ route('business.solarmitra.material_categories.list') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                        </div>
                    </form>
                </div>

            </div>
           
            <div class="col-xl-8">

                <!-- Start - Table -->
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless rounded m-0 quotation-tbl">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="width320">{{ __('solarmitra::solarmitra.title') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.companies_count') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.material_items_count') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.display_on_invoice') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.calculate_in_invoice') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.include_in_solar_kit') }}</th>
                                    <th class="text-center width200">{{ __('solarmitra::solarmitra.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($material_categories as $category)    
                                    <tr id="Row_{{$category['id']}}">
                                        <td id="Column_Sno_{{$category['id']}}">{{$material_categories->firstItem() + $loop->index}}</td>
                                        <td id="Column_Title_{{$category['id']}}">{{$category['title']}} {{$category['gst'] ? '| GST Applied : '.$category['gst'] : '' }}</td>
                                        <td id="Column_CompaniesCount_{{$category['id']}}">{{$category['companies_count']}}</td>
                                        <td id="Column_MaterialItems_{{$category['id']}}">{{$category['material_items_count']}}</td>
                                        <td id="Column_DisplayOnInvoice_{{$category['id']}}">
                                            @if ($category['display_on_invoice'])
                                                <span class="badge bg-success">{{ __('solarmitra::solarmitra.yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('solarmitra::solarmitra.no') }}</span>
                                            @endif
                                        </td>
                                        <td id="Column_CalculateInInvoice_{{$category['id']}}">
                                            @if ($category['calculate_in_invoice'])
                                                <span class="badge bg-success">{{ __('solarmitra::solarmitra.yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('solarmitra::solarmitra.no') }}</span>
                                            @endif
                                        </td>
                                        <td id="Column_IncludeInSolarKit_{{$category['id']}}">
                                            @if ($category['include_in_solar_kit'])
                                                <span class="badge bg-success">{{ __('solarmitra::solarmitra.yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('solarmitra::solarmitra.no') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center" id="Column_Actions_{{$category['id']}}">
                                            <a href="{{ route('business.solarmitra.material_categories.list', $category['id']) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                            @can('SolarMitra > Business > MaterialCategoriesController > destroy')
                                            <a href="{{ route('business.solarmitra.material_categories.destroy', $category['id']) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('solarmitra::solarmitra.no_categories') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($material_categories && $material_categories->hasPages())
                    <div class="card-footer">
                        {{ $material_categories->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
                <!-- End - Table -->

            </div>

        </div>
    </div>

@endsection