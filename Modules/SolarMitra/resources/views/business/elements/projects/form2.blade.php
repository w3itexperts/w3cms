 <!-- Start - Project Info -->
<div class="card showProjectInfo">
    <div class="card-header">
        <div class="d-flex align-items-center gap-2">
        <i class="icon-info text-primary fs-20"></i>
        <h3 class="fs-15 fw-medium align-items-center m-0">{{ __('solarmitra::solarmitra.project_info') }}</h3>
        </div>
        <div class="d-flex gap-2 align-items-center">
        <a href="javascript:void(0)" title="Edit Project" class="btn btn-sm btn-primary editProjectInfoBtn">{{ __('solarmitra::solarmitra.edit') }}</a>
 
        </div>
    </div>
    <div class="card-body">
        <div class="row">
        <div class="col-xl-6">
            <div class="row gy-3 mb-xl-0 mb-3">
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Select Client</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->client->name ?? 'N/A' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Project Type *</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->project_type ?? 'N/A' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Location *</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->location ?? 'N/A' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">End Date</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->end_date ? $project->end_date : '' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">{{ __('solarmitra::solarmitra.solar_kit_project') }}</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->is_solar_kit_project ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="row gy-3">
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Project Capacity *</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->capacity ?? 'N/A' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">{{ __('solarmitra::solarmitra.status') }}</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ config('solarmitra.projects_status.' . $project->status) ?? 'N/A' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Start Date</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ $project->start_date ? $project->start_date : '' }}</p>
                </div>
                <div class="col-sm-4 col-5">
                    <p class="m-0 fs-13 text-black">Project Value ({{SolarMitraHelper::getBusinessConfig('currency_code', 'INR')}})</p>
                </div>
                <div class="col-sm-8 col-7">
                    <p class="m-0 fs-14">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($project->project_value ?? 0) }}</p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- End - Project Info -->

<!-- Start - Edit Project Info -->
<div class="card editProjectInfo" style="display:none;">
    <div class="card-header">
        <div class="d-flex align-items-center gap-2">
        <i class="icon-info text-primary fs-20"></i>
        <h3 class="fs-15 fw-medium align-items-center m-0">{{ __('solarmitra::solarmitra.project_info') }}</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('business.solarmitra.projects.update',@$project->id)}}" data-ajax-container="#ProjectInfoBox" method="post" class="row g-3 AjaxModalForm">
        @csrf
        <div class="formLoading d-none">
            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
        </div>
        
        <input type="hidden" id="QuotationTitlePrefix" value="{{ SolarMitraHelper::getDocumentTitlePrefix('quotation') }}">
        <input id="SetQuotationTitle" hidden />
        <!-- Project Title -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.project') }} {{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" style="background-color: #f1f1f1" value="{{old('title', @$project->title)}}" readonly id="ProjectTitle">
            <span class="title_error text-danger fs-12"></span>
        </div>
        <!-- Select Client -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            {!! SolarMitraHelper::getContactDropdown('clients','',old('client_id', @$project->client_id)) !!}
            <span class="client_id_error text-danger fs-12"></span>
        </div>
        <!-- Project Capacity -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">Project Capacity <span class="text-danger">*</span></label>
            <select class="form-select " name="capacity" id="SolorCapacitySelect">
                <option value="" >{{ __('Select Capacity') }}</option>
                @foreach (config('solarmitra.projects_capacity') as $capacity)
                <option value="{{$capacity}}" @selected(old('capacity', @$project->capacity) == $capacity)>{{$capacity}}</option>
                @endforeach
            </select>
            <span class="capacity_error text-danger fs-12"></span>
        </div>
        <!-- Project Type -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">Project Type <span class="text-danger">*</span></label>
            <select class="form-select " name="project_type" id="ProjectTypeSelect">
                <option value="" >{{ __('Select Project Type') }}</option>
                @foreach (config('solarmitra.project_types') as $projectType)
                <option value="{{$projectType}}" @selected(old('project_type', @$project->project_type) == $projectType)>{{$projectType}}</option>
                @endforeach
            </select>
            <span class="project_type_error text-danger fs-12"></span>
        </div>
        <!-- Status -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.status') }}</label>
            <select class="form-select " name="status">
                @foreach (config('solarmitra.projects_status') as $key => $val)
                <option value="{{$key}}" @selected(old('status', @$project->status) == $key)>{{$val}}</option>
                @endforeach
            </select>
            <span class="status_error text-danger fs-12"></span>
        </div>
        <!-- Location -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.location') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="location" placeholder="Area - City" value="{{old('location', @$project->location)}}">
            <span class="location_error text-danger fs-12"></span>
        </div>
        <!-- Start Date -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.start_date') }} <span class="text-danger">*</span></label>
            <input type="text"
            class="form-control DateTimePicker"
            name="start_date"
            value="{{ old('start_date', @$project->start_date) }}">
            <span class="start_date_error text-danger fs-12"></span>
        </div>
        <!-- End Date -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.end_date') }} <span class="text-danger">*</span></label>
            <input type="text"
            class="form-control DateTimePicker"
            name="end_date"
            value="{{ old('end_date', @$project->end_date) }}">
            <span class="end_date_error text-danger fs-12"></span>
        </div>
        <!-- Project Value -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label class="form-label text-uppercase">{{ __('Project Value ('.SolarMitraHelper::getBusinessConfig('currency_code', 'INR').')') }} </label>
            <input type="text" class="form-control" name="project_value" value="{{old('project_value', @$project->project_value)}}">
            <span class="project_value_error text-danger fs-12"></span>
        </div>

        <!-- Project Solar Kit -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <label for="is_solar_kit_project" class="form-label text-uppercase">Solar Kit Project </label>
            <div class="form-check custom-checkbox">
                <input type="checkbox" class="form-check-input check-input" data-url="{{ route('business.solarmitra.quotations.ajax_quotation_items',@$quotation->id) }}" name="is_solar_kit_project" value="1" @checked(old('is_solar_kit_project',@$project->is_solar_kit_project) == 1) id="is_solar_kit_project">
            </div>
            <span class="is_solar_kit_project_error text-danger fs-12"></span>
        </div>
        <!-- Project Special Note -->
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div>
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.special_note') }}</label>
                <textarea class="form-control " name="description" rows="5">{{ old('description', @$project->description) }}</textarea>
            </div>
            <span class="description_error text-danger fs-12"></span>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
            <label class="form-label">{{ __('solarmitra::solarmitra.site_photo') }}</label>
            <div class="d-flex flex-wrap gap-3"> 
                @php
                    $project_attachments = @$project->project_attachments ? @$project->project_attachments->where('type',1) : [];
                @endphp
                @forelse ($project_attachments ?? [] as $project_attachment)
                <div class="custom-img-upload custom-img-upload-xl upload-image-box uploadNext img-parent-box border-0">
                    <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_attachment->attachment_id) }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: block;">

                    <button type="button" href="{{ route('business.solarmitra.projects.remove_project_attachment',$project_attachment->id) }}" class=" cancel-img-btn position-absolute" style="display: block; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>
                </div>
                @empty
                @endforelse
                <div class="custom-img-upload custom-img-upload-xl uploadNext img-parent-box border-0">
                    <img src="{{ asset('images/noimage.jpg') }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: none;">

                    <button type="button" class="cancel-img-btn position-absolute" style="display: none; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>

                    <div class="upload-btn">
                        <input type="file" class="form-control ps-2 img-business-input-onchange" name="site_photo[]" id="site_photo" accept=".png, .jpg, .jpeg, .webp" hidden="">
                        <label class="upload-label border-dashed flex-column justify-content-center text-center rounded dropzone-btn-xl m-0" style="display: flex;" for="site_photo"><i class=" fas fa-plus fs-26"></i></label>
                    </div>
                </div>
                @error('site_photo')
                    <p class="text-danger m-0">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <!-- Save Button -->
        <div class="col-12">
            <div class="d-lg-flex justify-content-lg-end mt-lg-3 gap-2">
                <button type="button" class="btn btn-danger light projectInfoCancel">{{ __('solarmitra::solarmitra.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- End - Edit Project Info -->