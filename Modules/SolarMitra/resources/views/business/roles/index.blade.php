{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    @php
        
        $is_action =
		(
			auth()->user()->can('SolarMitra > Business > BusinessRolesController > edit') &&
			auth()->user()->can('SolarMitra > Business > BusinessRolesController > update')
		) ||
		auth()->user()->can('SolarMitra > Business > BusinessRolesController > destroy');

    @endphp

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                <form method="get">
                    <div class="row gy-2">
                        
                         <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control " name="name" value="{{ request('name') }}" placeholder="{{ __('solarmitra::solarmitra.name') }}">
                        </div>
                        <div class="col-xl-10 col-md-8">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.business_roles.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can([
                                'SolarMitra > Business > BusinessRolesController > create', 
                                'SolarMitra > Business > BusinessRolesController > store'
                            ])
                            <a href="{{ route('business.solarmitra.business_roles.create') }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.business_role') }}</a>
                            @endcan
                        </div>
                    </div>


                </form>
            </div>
            <!-- End - Filtering -->

            <div class="col-xl-12">
                 <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless  rounded m-0 quotation-tbl" id="quatationTbl">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.name') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.type') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.role_type') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.status') }}</th>
                                    @if($is_action)
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($business_roles as $business_role)
                                    <tr>
                                        <td>{{$business_roles->firstItem() + $loop->index}}</td>
                                        <td>{{$business_role->name}} </td>
                                        <td><span class="badge border border-primary text-primary"> {{!empty($business_role->business_id) ? 'User Defined' : 'Predefined'}}</span> </td>
                                        <td>{{$business_role->role_type}}</td>
                                        <td>
                                            @if (!empty($business_role->status))
                                            <span class="badge bg-success">{{ __('solarmitra::solarmitra.active') }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ __('solarmitra::solarmitra.inactive') }}</span>
                                            @endif
                                        </td>
                                        @if($is_action)
                                        <td>
                                            @if (!empty($business_role->business_id))
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can(['SolarMitra > Business > BusinessRolesController > edit','SolarMitra > Business > BusinessRolesController > update'])
                                                        <a class="dropdown-item" href="{{ route('business.solarmitra.business_roles.edit',$business_role->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                        @endcan
                                                        @can('SolarMitra > Business > BusinessRolesController > destroy')
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.business_roles.destroy',$business_role->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        @endif
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
        </div>
    </div>

@endsection