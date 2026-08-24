{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

	<div class="page-title">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li><h1>{{$page_title}}</h1></li>
				<li class="breadcrumb-item">
					<a href="{{route('business.solarmitra.business_config_master.manage')}}">
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
		<div class="row">
			<!-- Start - Filtering -->
			@foreach ($configurations as $module => $items)
            <div class="col">
				<div class="card">
					<div class="card-body d-flex">
						<div class="avatar avatar-info">
							<i class="icon-globe"></i>
						</div>
						<div class="clearfix ms-3">
							<h5 class="card-title mb-0 d-flex flex-wrap align-items-center gap-2">{{config('solarmitra.business_config.modules.'.$module)}}</h5>
							<p class="mb-3">{{$items->count()}} Settings</p>
							<a href="#{{$module}}" class="btn btn-light">Configure <i class="icon-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
            @endforeach
			
			<!-- End - Filtering -->
		</div>

		<form action="{{route('business.solarmitra.business_config_master.manage')}}" method="post">
			@csrf
			<div class="row">
				<div class="col-12 d-flex align-items-center justify-content-between">
					<ul class="nav nav-tabs-standard pt-4 mb-3 nav-scroll nav-scroll-auto-xl">
						@foreach ($configurations as $module => $items)
							<li class="nav-item" role="presentation">
								<button class="nav-link {{$loop->first ? 'active' : ''}}" id="{{$module}}-tab" data-bs-toggle="tab" data-bs-target="#{{$module}}" type="button" role="tab" aria-controls="{{$module}}" aria-selected="true">{{config('solarmitra.business_config.modules.'.$module)}}</button>
							</li>
	                    @endforeach
					</ul>
					<div>
						@can('SolarMitra > Business > BusinessConfigMasterController > reset_business_configs')
						<a href="{{ route('business.solarmitra.business_config_master.reset_business_configs') }}" class="btn btn-secondary">
							Factory Reset
						</a>
						@endcan
						<button type="reset" class="btn btn-secondary">
							Reset
						</button>
						<button type="submit" class="btn btn-primary">
							Save
						</button>
					</div>
				</div>
			</div>
			<div class="row">

				@php
					$itemCount = 0;
				@endphp
				<div class="tab-content" id="myTabContent">
	 				@forelse ($configurations as $module => $config_items)
					@php
						$tab_id = Str::slug(ucfirst($module));
						$config_groups = $config_items->groupBy('config_group');
					@endphp
					<!-- Start - Gloabl Tab -->
					<div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="{{$module}}" role="tabpanel" aria-labelledby="{{$module}}-tab" tabindex="0">
						<div class="accordion accordion-gap" id="Accordion{{$tab_id}}">

							@forelse ($config_groups as $group => $group_items)
							@php
								$accordian_id = Str::slug(ucfirst($module).ucfirst($group));
							@endphp
							<!-- Start - Business Identity -->
							<div class="accordion-item">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#{{$accordian_id}}Settings" aria-expanded="true" aria-controls="business-identity-settings-item">
									{{Str::title(str_replace(['-', '_'], ' ', $group))}}
								</button>
								<div id="{{$accordian_id}}Settings" class="accordion-collapse collapse show" data-bs-parent="#Accordion{{$tab_id}}">
									<div class="accordion-body">
										
										@forelse ($group_items as $item)
											<div class="row align-items-center mb-3">
												<div class="col-md-3 text-start text-md-end">
													<label class="form-label">{{$item->display_title}}</label>
												</div>
												<div class="col-md-9">
													<input type="hidden" name="ConfigMaster[{{$itemCount}}][id]" value="{{$item->id}}">

													@php
														$fieldValue = !empty($item->business_config_master) ? $item->business_config_master->field_value : $item->field_value;
													@endphp
													{!! ThemeOption::CreateField([
														'title'=>$item->display_title,
														'type'=>$item->field_type,
														'id'=>$item->field_key,
														'options'=>json_decode($item->options_json,true),
														'class'=>'form-control mx-w300',
														'old_field_value'=>old('ConfigMaster.'.$item->field_key,$fieldValue),
														'field_name'=>$item->field_key
													],'ConfigMaster['.$itemCount.']') !!}
													<small class="form-text d-block">{{$item->description}}</small>
												</div>
											</div>
											@php
												$itemCount++;
											@endphp
										@empty
										@endforelse
										
									</div>
								</div>
							</div>
							@empty
							@endforelse

						</div>
					</div>
					<!-- End - Gloabl Tab -->
	 				@empty
	 				@endforelse
				</div>

			</div>
		</form>
	</div>


@endsection