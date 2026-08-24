{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="page-title">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li><h1>{{$page_title}}</h1></li>
			<li class="breadcrumb-item">
				<a href="{{route('admin.solarmitra.config_master.manage',$module)}}">
					<svg width="16" height="16" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="var(--bs-body-color)" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="var(--bs-body-color)" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					{{ __('solarmitra::solarmitra.home') }}
				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">{{$page_title}}</li>
		</ol>
	</nav>
</div>

<div class="container-fluid">
	<form action="{{ route('admin.solarmitra.config_master.manage',$module) }}" method="post">
		@csrf
		<div class="row mb-3">

			<div class="col-md-6 mb-md-0 mb-2 d-flexgap-2 flex-wrap">
				<a href="{{ route('admin.solarmitra.config_master.create') }}" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.configuration') }}</a>
			</div>

			<div class="ms-auto col-md-6 d-flex justify-content-md-end gap-2 flex-wrap">
				<button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }} {{ __('solarmitra::solarmitra.configuration') }}</button>
				<a href="{{route('admin.solarmitra.config_master.manage',$module)}}" class="btn btn-danger">{{ __('solarmitra::solarmitra.cancel') }}</a>
			</div>

		</div>

		<div class="row">

			<!-- Start - {{$page_title}} List -->
			<div class="col-xl-12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">{{$page_title}} {{ __('solarmitra::solarmitra.listing') }}</div>
					</div>
					<div class="card-body">
	                    <div class="table-responsive check-wrapper">
	                        <table class="table mb-0 table-bottom-borderless">
	                            <thead>
	                                <tr>
	                                    <th>S.No.</th>
	                                    <th class="mw-100">Name</th>
	                                    <th>Default Value</th>
	                                </tr>
	                            </thead>
								<tbody>
									@forelse ($configurations as $key => $configuration)
										<tr>
											<td>
												{{$loop->iteration}}
												<input type="hidden" name="ConfigMaster[{{$key}}][id]" value="{{$configuration->id}}">
											</td>
											<td>
												<label for="{{$configuration->field_key}}">{{$configuration->display_title}}</label>
											</td>
											<td>
												<div class="d-inline-flex flex-column gap-2 align-items-start ">
													{!! ThemeOption::CreateField([
														'title'=>$configuration->display_title,
														'type'=>$configuration->field_type,
														'id'=>$configuration->field_key,
														'options'=>json_decode($configuration->options_json,true),
														'old_field_value'=>old('ConfigMaster.'.$configuration->field_key,$configuration->field_value),
														'field_name'=>$configuration->field_key
													],'ConfigMaster['.$key.']') !!}
													<small class="form-text">{{$configuration->description}}</small>
												</div>
											</td>
										</tr>
									@empty
									@endforelse
									
								</tbody>
	                        </table>
	                    </div>
	                </div>
				</div>
			</div>
			<!-- End - {{$page_title}} List -->

		</div>
	</form>
	
</div>


@endsection
@push('inline-css')

     <link href="{{ theme_asset('vendor/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/tempus-dominus/tempus-dominus.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('modules/solarmitra/css/business-custom.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
    <script src="{{ theme_asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/tempus-dominus/tempus-dominus.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
@endpush