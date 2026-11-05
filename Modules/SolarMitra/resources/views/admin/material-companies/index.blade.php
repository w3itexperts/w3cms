{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

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
                            <a href="{{ route('admin.solarmitra.material_companies.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            <a href="{{route('admin.solarmitra.material_companies.ajax_modal')}}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.companies') }}</a>
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
                                    <th class="width100">S.No.</th>
                                    <th class="width200">Title</th>
                                    <th class="width100">Categories Count</th>
                                    <th class="width100 ">Materials Count</th>
                                    <th class=" width200">Description</th>
                                    <th class=" width100">Actions</th>
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
                                        <td>
                                            <a href="{{ route('admin.solarmitra.material_companies.ajax_modal', $company['id']) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="icon-pencil"></i></a>
                                            <a href="{{ route('admin.solarmitra.material_companies.destroy', $company['id']) }}" class="btn delete btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('solarmitra::solarmitra.no_companies') }}</td>
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

@push('inline-css')
     <link href="{{ theme_asset('vendor/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('modules/solarmitra/css/business-custom.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
    <script src="{{ theme_asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
@endpush