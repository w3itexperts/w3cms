<div class="row">
    <div class="form-group col-md-12 mb-3">
        <select name="role_id" id="RoleId" class="form-control" rdx-link="{{ route('business.solarmitra.permissions.get_users_by_role') }}">
            <option value="">{{ __('solarmitra::solarmitra.select_role') }}</option>
            @forelse($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @empty
            @endforelse
        </select>
    </div>
    <div class="form-group col-md-12 mb-3">
        <select name="user_id" id="PermissionUserId" class="form-control" rdx-link="{{ route('business.solarmitra.permissions.get_permission_by_user') }}">
            <option value="">{{ __('solarmitra::solarmitra.select_user') }}</option>
        </select>
    </div>
    <div class="form-group col-md-12 mb-3 d-flex align-items-center" id="PermissionActionBtn">
        
    </div>
    <input type="hidden" name="PermissionId" id="PermissionId" value="{{ $permission_id }}">
</div>