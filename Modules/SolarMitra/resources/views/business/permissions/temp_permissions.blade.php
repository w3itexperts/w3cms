{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">
			<div class="card">
                <div class="card-header d-block">
                    <h4 class="card-title mb-3">{{ __('solarmitra::solarmitra.permission_managment_tool') }}</h4>
                    <div>
	                    <a href="{{ route('business.solarmitra.permissions.add_to_permissions') }}" class="btn btn-primary">{{ __('solarmitra::solarmitra.add_to_permissions') }}</a>
	                    <a href="{{ route('business.solarmitra.permissions.generate_permissions') }}" class="btn btn-primary">{{ __('solarmitra::solarmitra.sync_temp_permissions') }}</a>
                    </div>
                </div>
                @if(($tempPermissionsCount > 0) && ($permissionsCount == $tempPermissionsCount))
	                <div class="alert alert-info mt-3 me-3 ms-3 mb-0">
	                	{{ __('solarmitra::solarmitra.all_permission_generated') }}
	                </div>
	            @endif
				<div id="dz_tree" class="tree-demo card-body">
					<ul>
						@foreach($moduleTempPermissions as $modulePermissionKey => $modulePermissionValue)
							<li data-jstree='{ "selected" : false }'> {{ $modulePermissionKey }} 
								@foreach($modulePermissionValue as $controllerPermissionKey => $controllerPermissionValue)
									<ul>
										<li data-jstree='{"selected" : false}'>{{ $controllerPermissionKey }}
											@foreach($controllerPermissionValue as $actionPermissionKey => $actionPermissionValue)
												<ul>
													@php
														$addPermissionBtn = __('solarmitra::solarmitra.add');
													@endphp
													@foreach ($actionPermissionValue as $actionPermission)
														@if(in_array($actionPermission->id, $permissionsArr))
															@php
																$permissionClass = 'added-permission';
																$addPermissionBtn = '<span class="bg-info">'.__("solarmitra::solarmitra.added").'</span>';
															@endphp
														@else
															@php
																$permissionClass = 'not-added-permission';
																$addPermissionBtn = '<a href="'.route('business.solarmitra.permissions.add_to_permissions').'">'.__("solarmitra::solarmitra.add").'</a>';
															@endphp
														@endif
														
														<li data-jstree='{"icon":{{ asset('images/jstree_setting_icon.svg') }}}' class="{{ $actionPermission->id }} {{ $permissionClass }}">
															{{ $actionPermission->name }}
														</li>
													@endforeach
												</ul>
											@endforeach
										</li>
									</ul>
								@endforeach
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Row ends -->
</div>


@endsection