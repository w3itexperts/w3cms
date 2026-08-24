{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('solarmitra::solarmitra.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('solarmitra::solarmitra.welcome_back_desc') }}</p>
		    </div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.solarmitra.config_master.index') }}">{{ __('solarmitra::solarmitra.config_master') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('solarmitra::solarmitra.config_master') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.search') }} {{ __('solarmitra::solarmitra.config_master') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.solarmitra.config_master.index') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4 m-sm-0 form-group">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="col-sm-4 m-sm-0 form-group">
                                <select name="module_code" data-live-search="true" class="form-control selectpicker">
                                    <option value="" >Select Modules</option>
                                    @forelse (config('solarmitra.business_config.modules') as $key => $value)
                                        <option value="{{$key}}" @selected(old('module_code', request()->input('module_code')) == $key)>{{$value}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-sm-4 text-sm-end">
                                <input type="submit" name="search" value="{{ __('solarmitra::solarmitra.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.solarmitra.config_master.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('solarmitra::solarmitra.config_master') }}</h4>
					<div>
						<a href="{{ route('admin.solarmitra.config_master.create') }}" class="btn btn-primary">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.configuration') }}</a>
						<a href="{{ route('admin.solarmitra.config_master.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">{{ __('Quick Add') }}</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0 min-width-40" >
							<thead>
								<tr>
									<th> <strong> {{ __('solarmitra::solarmitra.s_no') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.name') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.module_code') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.field_type') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.value_type') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.value') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.description') }} </strong> </th>
									<th class="text-center"> <strong> {{ __('solarmitra::solarmitra.actions') }} </strong> </th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = $configurations->firstItem();
								@endphp
								@forelse ($configurations as $config)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ $config->display_title }} </td>
										<td> {{ $config->module_code }} </td>
										<td> {{ $config->field_type }} </td>
										<td> {{ $config->value_type }} </td>
										<td> {{ $config->field_value }} </td>
										<td> {{ $config->description }} </td>
										<td class="text-center">
											<a href="{{ route('admin.solarmitra.config_master.edit', $config->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" class="btn btn-primary shadow btn-xs sharp me-1 " title="{{ __('solarmitra::solarmitra.edit') }}"><i class="icon-pencil"></i></a>	
											<a href="{{ route('admin.solarmitra.config_master.destroy', $config->id) }}" class="btn btn-danger shadow btn-xs sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="icon-trash-2"></i></a>
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="8"><p>{{ __('solarmitra::solarmitra.configurations_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				@if ($configurations && $configurations->hasPages())
				<div class="card-footer">
					{{ $configurations->onEachSide(1)->appends(request()->input())->links('admin.elements.pagination') }}
				</div>
				@endif
			</div>
		</div>
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