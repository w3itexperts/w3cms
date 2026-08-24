@php
    $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days',7);
    $quotation_limit_per_client = SolarMitraHelper::getBusinessConfig('quotation_limit_per_client',3);
    $disabled = '';
    if (@$business && $business->bank_accounts->isEmpty()) {
        $disabled = 'disabled';
    }
    if (@$existingQuotations && $existingQuotations->count() >= $quotation_limit_per_client) {
        $disabled = 'disabled';
    }
@endphp
<form method="post" action="{{@$quotation->id ? route('business.solarmitra.quotations.update',@$quotation->id) : route('business.solarmitra.quotations.store')}}" class="AjaxModalForm" id="QuotationModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    <fieldset {{ $disabled }}>
    @if (@$lead)
        <input type="hidden" name="lead_id" value="{{$lead->id}}">
    @endif
    <input type="hidden" name="business_id" value="{{@$quotation->business_id ?? app('currentBusinessId')}}">
    <input type="hidden" name="project_title" id="ProjectTitle" value="">
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$quotation->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.quotation') }} </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        @if (@$business && $business->bank_accounts->isEmpty())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Warning!</strong> Please Add Bank Account First in Current Business.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
         @if (@$existingQuotations && $existingQuotations->count())
        <div class="alert alert-warning  fade show" role="alert">
          <strong><i class="icon icon-info"></i> Existing Quotation{{ $existingQuotations->count() > 1 ? 's' : '' }} ({{ $existingQuotations->count() }})</strong> 
          <a href="{{ route('business.solarmitra.quotations.index', ['client_id' => $contact->id]) }}" 
             class="alert-link" target="_blank">
             View Quotations <i class="icon icon-external-link"></i>
          </a>
          <br>
          @forelse ($existingQuotations as $existingQuotation)
            <p> {{$loop->iteration}}. {{$existingQuotation->title}} By <strong>{{optional($existingQuotation->creator)->name}}</strong> At <strong>{{$existingQuotation->created_at}}</strong> <a href="{{ route('business.solarmitra.quotations.edit',$existingQuotation->id) }}" 
             class="alert-link" target="_blank">Edit <i class="icon icon-external-link"></i></a>.</p>
          @empty
          @endforelse

          @if ($existingQuotations->count() >= $quotation_limit_per_client)
              <p class="text-danger text-end m-0">Quotation Per Client Limit is Reached.</p>
          @endif
        </div>
        @endif

        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.quotation') }} {{ __('solarmitra::solarmitra.title') }}</label>
            <input type="hidden" id="QuotationTitlePrefix" value="{{ SolarMitraHelper::getDocumentTitlePrefix('quotation') }}">
            <input type="text" class="form-control"  name="title" value="{{@$quotation->title}}" id="SetQuotationTitle" >
            <p class="text-danger error-text title_error m-0"></p>
    
        </div>

        <div class="mb-3">
            {!! SolarMitraHelper::getContactDropdown('clients','',@$quotation->client_id ?? @$contact->id) !!}
            <p class="text-danger error-text client_id_error m-0"></p>
        </div>

        @if (empty(@$quotation->id))

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Capacity <span class="text-danger">*</span></label>
            <select class="form-select" name="capacity" id="SolorCapacitySelect">
                <option value="" >{{ __('Select Capacity') }}</option>
                @foreach (config('solarmitra.projects_capacity') as $capacity)
                    <option value="{{$capacity}}" @selected(old('capacity') == $capacity)>{{$capacity}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text capacity_error m-0"></p>
        </div>

        <div class="mb-3">
            <label class="form-label text-uppercase">Project Type <span class="text-danger">*</span></label>
            <select class="form-select " name="project_type" id="ProjectTypeSelect">
                <option value="" >{{ __('Select Project Type') }}</option>
                @foreach (config('solarmitra.project_types') as $project_type)
                    <option value="{{$project_type}}" @selected(old('project_type') == $project_type)>{{$project_type}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text project_type_error m-0"></p>
        </div>


        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.expexted_start_date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="start_date" value="{{old('start_date',@$project->start_date ?? \Carbon\Carbon::now()->format(config('solarmitra.date_time_format')) )}}">
                @error('start_date')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-danger error-text start_date_error m-0"></p>
            </div>
            <div class="col-md-6 mb-2">
                
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.expexted_end_date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="end_date" value="{{old('end_date',@$project->end_date ?? \Carbon\Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')) )}}">
                @error('end_date')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-danger error-text end_date_error m-0"></p>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.location') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="location" placeholder="Area - City" value="{{old('location', @$project->location)}}">
            @error('location')
                <p class="text-danger">
                    {{ $message }}
                </p>
            @enderror
                <p class="text-danger error-text location_error m-0"></p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="is_solar_kit_project" class="form-label text-uppercase">{{ __('solarmitra::solarmitra.solar_kit_project') }}</label>
                <div class="form-check custom-checkbox">
                    <input type="checkbox" class="form-check-input check-input" name="is_solar_kit_project" value="1" @checked(old('is_solar_kit_project') == 1) id="is_solar_kit_project">
                </div>
                <p class="text-danger error-text is_solar_kit_project_error m-0"></p>
            </div>
        </div>
        @endif
        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$quotation->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.quotation') }}</button>
        </div>
    </div>
    </fieldset>
</form>