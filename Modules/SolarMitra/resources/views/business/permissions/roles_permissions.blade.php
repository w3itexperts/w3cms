{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <!-- row -->
    <!-- Row starts -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-block">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.roles') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md mb-0">
                            <thead>
                                <tr>
                                    <th><strong>{{ __('solarmitra::solarmitra.role_name') }}</strong></th>
                                    <th class="text-center"><strong>{{ __('solarmitra::solarmitra.allow/deny') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)

                                    @php
                                        $rolePermissionCount = Acl::get_role_permissions_count($role->id);
                                    @endphp

                                    <tr>
                                        <td> {{ $role->name }} </td>
                                        <td class="justify-content-center d-flex align-items-center">

                                            @if(($allPermissionCount == $rolePermissionCount))
                                                <label class="permission-switch">
                                                    <input type="checkbox" class="bulkActionRoleCheckbox" rdx-link="{{ route('business.solarmitra.permissions.manage-role-all-permissions', ['id'=>$role->id] )}}" checked="checked" data-role-id="{{ $role->id }}">
                                                    <span class="permission-switch-slider"></span>
                                                </label> 
                                                <span class="ms-2">({{ __('solarmitra::solarmitra.allow/deny_all_permissions') }})</span>
                                            @else
                                                <label class="permission-switch">
                                                    <input type="checkbox" class="bulkActionRoleCheckbox" rdx-link="{{ route('business.solarmitra.permissions.manage-role-all-permissions', ['id'=>$role->id] )}}" data-role-id="{{ $role->id }}">
                                                    <span class="permission-switch-slider"></span>
                                                </label> 
                                                <span class="ms-2">({{ __('solarmitra::solarmitra.allow/deny_all_permissions') }})</span>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <p class="text-center">{{ __('solarmitra::solarmitra.roles_not_found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row ends -->

    <div class="row">

        @php 
            $permissions_list = config('permission.acl.action_list'); 
            $i = 1;
        @endphp

        @foreach($modulePermissions as $moduleKey => $modulePermission)

            <div class="col-xl-12">
                <div class="card accordion accordion-rounded-stylish accordion-bordered mb-2" id="accordion-{{ $moduleKey }}">

                    <div class="card-header d-block accordion-header collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $moduleKey }}">
                        <h4 class="card-title">{{ ucfirst($moduleKey) }}</h4>
                        
                    </div>

                    <div class="card-body accordion__body collapse show" id="collapse-{{ $moduleKey }}" data-bs-parent="#accordion-{{ $moduleKey }}">
                        
                        @forelse($modulePermission as $controllerKey => $controller)

                            <div id="accordion-{{ $moduleKey }}-{{ $i }}" class="accordion accordion-bordered mb-2 accordion-primary custom-accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header collapsed card-header" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $moduleKey }}-{{ $i }}">
                                        @php
                                            $title = collect(explode('\\', $controllerKey))->take(-2)->map(fn ($v) => str_replace('Controller', '', $v))->implode(' -> ');
                                        @endphp
                                        <span class="accordion-header-text"><strong>{{ __('solarmitra::solarmitra.controller') }}: {{ $title }}</strong></span>
                                        
                                    </div>
                                    <div id="collapse-{{ $moduleKey }}-{{ $i }}" class="accordion__body collapse" data-bs-parent="#accordion-{{ $moduleKey }}-{{ $i }}">
                                        <div class="accordion-body-text table-responsive">
                                            <table class="table table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th><strong>{{ __('solarmitra::solarmitra.permissions') }}</strong></th>

                                                        @forelse($roles as $role)
                                                            <th class="text-center">
                                                                <strong> {{ $role->name }} </strong>
                                                            </th>
                                                        @empty
                                                        @endforelse

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse($controller[0] as $methodKey => $method)

                                                    <tr>
                                                        <td>
                                                            {{ $method->name }} <i class="fa fa-question-circle" data-bs-toggle="tooltip" data-placement="right" title="{{ $method->name }}"></i>
                                                        </td>
                                                        @forelse($roles as $role)

                                                            @php
                                                                $permissionId = Acl::get_permission_id($method->id);
                                                                $checked = Acl::checked_role_permission($role->id, $permissionId);
                                                            @endphp

                                                            <td class="text-center">
                                                                <label class="permission-switch">
                                                                    <input type="checkbox" class="RoleCheckbox permissionCheckbox_{{ $role->id }}" id="RoleCheckbox_{{ $role->id }}_{{ $permissionId }}" data-role-id="{{ $role->id }}" data-permission-id="{{ $permissionId }}" rdx-link="{{ route('business.solarmitra.permissions.manage-role-permission', ['role_id'=> $role->id, 'permission_id' => $permissionId] )}}" {{ $checked }}>
                                                                    <span class="permission-switch-slider"></span>
                                                                </label>
                                                            </td>
                                                        @empty
                                                        @endforelse

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

</div>

@endsection