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
                            
                        <div class="col-xl-10 col-md-8">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('admin.solarmitra.business_roles.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            <a href="{{ route('admin.solarmitra.business_roles.create') }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.business_role') }}</a>
                            
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
                                    <th class="">Name</th>
                                    <th class="">Type</th>
                                    <th class=" ">Role Type</th>
                                    <th class=" ">Status</th>
                                    <th class=" width100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($business_roles as $business_role)
                                    <tr>
                                        <td>{{$business_roles->firstItem() + $loop->index}}</td>
                                        <td>{{$business_role->name}} </td>
                                        <td><span class="badge border border-primary text-primary"> {{!$business_role['business_id'] ? 'Predefined' : 'User Defined'}}</span> </td>
                                        <td>{{$business_role->role_type}}</td>
                                        <td>{{$business_role->status}}</td>
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ route('admin.solarmitra.business_roles.edit',$business_role->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('admin.solarmitra.business_roles.destroy',$business_role->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">{{ __('solarmitra::solarmitra.no_business_roles') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($business_roles && $business_roles->hasPages())
                    <div class="card-footer">
                        {{ $business_roles->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
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