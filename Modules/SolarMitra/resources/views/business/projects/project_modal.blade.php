<form method="post" action="{{route('business.solarmitra.projects.store')}}" class="AjaxModalForm" id="QuotationModalForm">
    @csrf
    <input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
    <input type="hidden" id="QuotationTitlePrefix" value="{{ SolarMitraHelper::getDocumentTitlePrefix('quotation') }}">
    <input type="hidden" name="quotation_title" id="SetQuotationTitle" value="">
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.project') }} <span id="ProjectTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <div class="mb-3">
            {!! SolarMitraHelper::getContactDropdown('clients','',old('client_id')) !!}
            <p class="text-danger error-text client_id_error"></p>
        </div>


        <div class="mb-3">
            <label class="form-label text-uppercase">Project Capacity <span class="text-danger">*</span></label>
            <select class="form-select" name="capacity" id="SolorCapacitySelect">
                <option value="" >{{ __('Select Capacity') }}</option>
                @foreach (config('solarmitra.projects_capacity') as $capacity)
                    <option value="{{$capacity}}" @selected(old('capacity') == $capacity)>{{$capacity}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text capacity_error"></p>
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Type <span class="text-danger">*</span></label>
            <select class="form-select " name="project_type" id="ProjectTypeSelect">
                <option value="" >{{ __('Select Project Type') }}</option>
                @foreach (config('solarmitra.project_types') as $project_type)
                    <option value="{{$project_type}}" @selected(old('project_type') == $project_type)>{{$project_type}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text project_type_error"></p>
        </div>


        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.start_date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="start_date" value="{{old('start_date',)}}">
                @error('start_date')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.end_date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="end_date" value="{{old('end_date',)}}">
                @error('end_date')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.location') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="location" placeholder="Area - City" value="{{old('location')}}">
            @error('location')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="is_solar_kit_project" class="form-label text-uppercase">{{ __('solarmitra::solarmitra.solar_kit_project') }}</label>
                <div class="form-check custom-checkbox">
                    <input type="checkbox" class="form-check-input check-input" name="is_solar_kit_project" value="1" @checked(old('is_solar_kit_project') == 1) id="is_solar_kit_project">
                </div>
                <p class="text-danger error-text is_solar_kit_project_error"></p>
            </div>
        </div>
        @endif
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$quotation->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.project') }}</button>
        </div>
    </div>
</form>