<form method="post" action="{{@$business_role->id ? route('business.solarmitra.business_roles.update',@$business_role->id) : route('business.solarmitra.business_roles.store')}}" class="AjaxModalForm">
    @csrf
    <input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
    <input type="hidden" name="role_type" value="Business">
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$business_role->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.business_role') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.role') }} {{ __('solarmitra::solarmitra.name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="{{@$business_role->name}}">
                <p class="text-danger error-text name_error"></p>
                
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('Select Parent Role') }} </label>
                <select name="parent_id" class="form-select  text-primary">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.parent') }}</option>
                    @forelse ($business_roles as $role_id => $name)
                        <option value="{{$role_id}}" @selected(@$business_role->parent_id == $role_id)>{{$name}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text parent_id_error"></p>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('Select Status') }} </label>
                <select name="status" class="form-select  text-primary">
                    <option value="1" @selected(old('status',@$business_role->status) === 1)>{{ __('solarmitra::solarmitra.active') }}</option>
                    <option value="0" @selected(old('status',@$business_role->status) === 0)>{{ __('solarmitra::solarmitra.inactive') }}</option>
                </select>
                <p class="text-danger error-text status_error"></p>
            </div>
            <div class="col-12 mb-3 ">
                <label class="form-label">{{ __('Description') }} </label>
                <textarea name="description" class="form-control h-auto" rows="3"> {{@$business_role->description}}</textarea>
            </div>
            
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$business_role->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.business_role') }}</button>
        </div>
    </div>
</form>