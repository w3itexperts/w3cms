<form method="post" action="{{@$quotation->id ? route('business.solarmitra.quotations.update',@$quotation->id) : route('business.solarmitra.quotations.store')}}" class="AjaxModalForm">
    @csrf
    <input type="hidden" name="business_id" value="{{@$quotation->business_id ?? app('currentBusinessId')}}">
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$quotation->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.quotation') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.quotation') }} {{ __('solarmitra::solarmitra.title') }}</label>
            <input type="text" class="form-control" name="title" value="{{@$quotation->title}}">
                <p class="text-danger error-text title_error"></p>
        </div>

        <div class="mb-3">
            {!! SolarMitraHelper::getContactDropdown('clients','',@$quotation->client_id) !!}
            <p class="text-danger error-text client_id_error"></p>
        </div>

        @if (empty(@$quotation->id))

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Capacity <span class="text-danger">*</span></label>
            <select class="form-select " name="capacity">
                <option value="" >{{ __('Select Capacity') }}</option>
                @foreach (config('solarmitra.projects_capacity') as $capacity)
                    <option value="{{$capacity}}" @selected(old('capacity') == $capacity)>{{$capacity}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text capacity_error"></p>
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Type <span class="text-danger">*</span></label>
            <select class="form-select " name="project_type">
                <option value="" >{{ __('Select Project Type') }}</option>
                @foreach (config('solarmitra.project_types') as $project_type)
                    <option value="{{$project_type}}" @selected(old('project_type') == $project_type)>{{$project_type}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text project_type_error"></p>
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Kit  <span class="text-danger">*</span></label>
            <select class="form-select " name="kit">
                <option value="" >{{ __('Select Project Kit') }}</option>
                @foreach (config('solarmitra.project_kits') as $kit)
                    <option value="{{$kit}}"  @selected(old('kit') == $kit)>{{$kit}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text kit_error"></p>
        </div>
        @endif
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$quotation->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.quotation') }}</button>
        </div>
    </div>
</form>