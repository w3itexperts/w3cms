{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    @php
        $is_action =
            (
                auth()->user()->can('SolarMitra > Business > MaterialCompaniesController > ajax_modal') &&
                auth()->user()->can('SolarMitra > Business > MaterialCompaniesController > update')
            ) ||
            auth()->user()->can('SolarMitra > Business > MaterialCompaniesController > destroy');

    @endphp

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12">

                <form method="get" class="mb-3">
                    <div class="row gy-2">
                        <div class="col-sm-3">
                                <input type="text" class="form-control " name="title" value="{{ request('title') }}" placeholder="{{ __('solarmitra::solarmitra.title') }}">
                        </div>
                            
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.material_companies.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can(['SolarMitra > Business > MaterialCompaniesController > ajax_modal','SolarMitra > Business > MaterialCompaniesController > store'])
                            <a href="{{route('business.solarmitra.material_companies.ajax_modal')}}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.companies') }}</a>
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
                        <table class="table table-bottom-borderless  rounded m-0 quotation-tbl" >
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="width200">{{ __('solarmitra::solarmitra.title') }}</th>
                                    <th class="width100">{{ __('solarmitra::solarmitra.categories_count') }}</th>
                                    <th class="width100 ">{{ __('solarmitra::solarmitra.materials_count') }}</th>
                                    <th class=" width200">{{ __('solarmitra::solarmitra.description') }}</th>
                                    @if($is_action)
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($material_companies as $company)
                                    <tr>
                                        <td>{{$material_companies->firstItem() + $loop->index}}</td>
                                        <td>{{$company->title}}</td>
                                        <td>{{$company->categories_count}}</td>
                                        <td>{{$company->material_items_count}}</td>
                                        <td>{{$company->description}}</td>
                                        @if($is_action)
                                        <td>
                                            @can(['SolarMitra > Business > MaterialCompaniesController > ajax_modal','SolarMitra > Business > MaterialCompaniesController > update'])
                                            <a href="{{ route('business.solarmitra.material_companies.ajax_modal', $company['id']) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('SolarMitra > Business > MaterialCompaniesController > destroy')
                                            <a href="{{ route('business.solarmitra.material_companies.destroy', $company['id']) }}" class="btn delete btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{$is_action ? 6 : 5 }}" class="text-center">{{ __('solarmitra::solarmitra.no_companies') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($material_companies && $material_companies->hasPages())
                    <div class="card-footer">
                        {{ $material_companies->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                    </div>
                    @endif
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection