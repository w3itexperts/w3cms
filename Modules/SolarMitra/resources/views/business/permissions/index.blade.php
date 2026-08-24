{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    
    <!-- row -->
    <div class="row">
        @php 
            $permissions_list = config('permission.acl.action_list'); 
            $i = 1;
        @endphp

        @foreach($modulePermissions as $modulePermissionKey => $modulePermissionValue)

            <div class="col-xl-12">
                <div class="card accordion accordion-bordered mb-2" id="accordion-{{ $modulePermissionKey }}">

                    <div class="card-header d-block accordion-header  rounded-lg collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $modulePermissionKey }}">
                        <h4 class="card-title">{{ ucfirst($modulePermissionKey) }}</h4>
                        
                    </div>

                    <div class="card-body accordion__body collapse show" id="collapse-{{ $modulePermissionKey }}" data-bs-parent="#accordion-{{ $modulePermissionKey }}">
                        
                        @forelse($modulePermissionValue as $controllerKey => $controller)

                            <div id="accordion-{{ $modulePermissionKey }}-{{ $i }}" class="accordion accordion-bordered mb-2 accordion-primary custom-accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed card-header" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $modulePermissionKey }}-{{ $i }}">
                                        @php
                                            $title = collect(explode('\\', $controllerKey))->take(-2)->map(fn ($v) => str_replace('Controller', '', $v))->implode(' -> ');
                                        @endphp
                                        <span class="accordion-header-text fw-bold">{{ __('solarmitra::solarmitra.controller') }}: {{ $title }}</span>
                                        
                                    </div>
                                    <div id="collapse-{{ $modulePermissionKey }}-{{ $i }}" class="accordion__body collapse" data-bs-parent="#accordion-{{ $modulePermissionKey }}-{{ $i }}">
                                        <div class="accordion-body-text table-responsive">
                                            <table class="table table-responsive-lg">
                                                <thead>
                                                    <tr>
                                                        <th><strong>{{ __('solarmitra::solarmitra.permissions') }}</strong></th>
                                                        <th><strong>{{ __('solarmitra::solarmitra.actions') }}</strong></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse($controller[0] as $methodKey => $method)
                                                        @php
                                                            $permissionId = Acl::get_permission_id($method->id);
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <span class="label">
                                                                    {{ $method->name }} <i class="fa fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $method->name }}"></i>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('business.solarmitra.permissions.permission_by_action') }}" class="AssignRevokePermissions btn btn-xs btn-info
                                                                  me-2" data-permission-id="{{ $permissionId }}" data-type="role">{{ __('solarmitra::solarmitra.role_based') }}</a>

                                                                <a href="{{ route('business.solarmitra.permissions.permission_by_action') }}" class="AssignRevokePermissions btn btn-xs btn-primary " data-permission-id="{{ $permissionId }}" data-type="user">{{ __('solarmitra::solarmitra.user_based') }}</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>
                                                                <p class="text-center">{{ __('solarmitra::solarmitra.records_not_found') }}</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @empty

                            <h5 class="text-center">{{ __('solarmitra::solarmitra.records_not_found') }}</h5>

                        @endforelse
                    </div>

                </div>
            </div>

        @endforeach

        
    </div>
    <!-- Row ends -->
</div>

@endsection