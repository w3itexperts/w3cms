
    @csrf
    <input type="hidden" name="quotation_title" id="SetQuotationTitle" value="">
    <input type="hidden" id="QuotationTitlePrefix" value="{{ SolarMitraHelper::getDocumentTitlePrefix('quotation') }}">
    <div class="row">
@php
    $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days',7);
@endphp
        <div class="col-xl-12">
            <div class="card d-flex flex-column">
                <div class="card-body">
                    <div class="row">

                        <!-- Start - Project -->
                        <div class="col-sm-12">

                            <div class="mb-4">
                                <div class="text-start border-bottom border-grey position-relative my-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.project_details') }}</h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xl-3 col-lg-6 mb-2">  
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.project') }} {{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title"  value="{{old('title', @$project->title)}}"  id="ProjectTitle">
                                    @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-3 col-lg-6 mb-2"> 
                                    {!! SolarMitraHelper::getContactDropdown('clients','',old('client_id', @$project->client_id)) !!}
                                    @error('client_id')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">    
                                    <label class="form-label text-uppercase">Project Capacity <span class="text-danger">*</span></label>
                                    <select class="form-select " name="capacity" id="SolorCapacitySelect">
                                        <option value="" >{{ __('Select Capacity') }}</option>
                                        @foreach (config('solarmitra.projects_capacity') as $capacity)
                                            <option value="{{$capacity}}" @selected(old('capacity', @$project->capacity) == $capacity)>{{$capacity}}</option>
                                        @endforeach
                                    </select>
                                    @error('capacity')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">
                                    <label class="form-label text-uppercase">Project Type <span class="text-danger">*</span></label>
                                    <select class="form-select " name="project_type" id="ProjectTypeSelect">
                                        <option value="" >{{ __('Select Project Type') }}</option>
                                        @foreach (config('solarmitra.project_types') as $projectType)
                                            <option value="{{$projectType}}" @selected(old('project_type', @$project->project_type) == $projectType)>{{$projectType}}</option>
                                        @endforeach
                                    </select>
                                    @error('project_type')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.status') }}</label>
                                    <select class="form-select " name="status">
                                        @foreach (config('solarmitra.projects_status') as $key => $val)
                                        <option value="{{$key}}" @selected(old('status', @$project->status) == $key)>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-4 col-lg-6 mb-2">
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.location') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="location" placeholder="Area - City" value="{{old('location', @$project->location)}}">
                                    @error('location')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">
                                    @php
                                        $start_date = @$project ? @$project->start_date : \Carbon\Carbon::now()->format(config('solarmitra.date_time_format')) ;
                                    @endphp
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.start_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                       class="form-control DateTimePicker" 
                                       name="start_date"
                                       value="{{ old('start_date', $start_date) }}">


                                    @error('start_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">
                                    @php
                                        $end_date = @$project ? @$project->end_date : \Carbon\Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')) ;
                                    @endphp
                                    <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.end_date') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                       class="form-control DateTimePicker" 
                                       name="end_date" 
                                       value="{{ old('end_date', $end_date) }}">
                                    @error('end_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-6 mb-2">
                                    <label class="form-label text-uppercase">{{ __('Project Value ('.SolarMitraHelper::getBusinessConfig('currency_code', 'INR').')') }} </label>
                                    <input type="number" step="any" class="form-control" name="project_value" value="{{old('project_value', @$project->project_value)}}">
                                    @error('project_value')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <label for="is_solar_kit_project" class="form-label text-uppercase">Solar Kit Project </label>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input check-input" data-url="{{ route('business.solarmitra.quotations.ajax_quotation_items',@$quotation->id) }}" name="is_solar_kit_project" value="1" @checked(old('is_solar_kit_project',@$project->is_solar_kit_project) == 1) id="EnableSolarKitCheck">
                                    </div>
                                    @error('is_solar_kit_project')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- End - Project -->
                        @php
                            $quotation_items_item_ids = isset($quotation) ? $quotation->items->pluck('item_id')->toArray() : [];
                            $quotation_items_category_ids = isset($quotation) ? $quotation->items->pluck('material_category_id')->toArray() : [];
                            $quotation_items_company_ids = isset($quotation) ? $quotation->items->pluck('material_company_id')->toArray() : [];
                        @endphp
                        <!-- Start - Project Items -->
                        <div class="col-sm-12">


                          <button class="btn w-100 px-0 border-0 outline-none shadow-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <div class="text-start border-bottom border-grey position-relative my-4">
                                <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0"><i class="icon-chevron-down align-middle"></i> Project Items</h4>
                            </div>
                          </button>
                            <div class="card h-auto border collapse " id="collapseExample">
                              <div class="card-body" id="SolarItemsContainer">
                                @include('solarmitra::business.quotations.ajax_quotation_items')
                              </div>
                            </div>
                            
                        </div>
                        <!-- End - Project Items -->

                        

                        <!-- Start - Project Other Details -->
                        <div class="col-12">
                            <div class="mb-4">
                                <div class="text-start border-bottom border-grey position-relative my-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.project_other_details') }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div>
                                        <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.special_note') }}</label>
                                        <textarea class="form-control " name="description" rows="1">{{ old('description', @$project->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.site_photo') }}</label>
                                    <div class="d-flex flex-wrap gap-3"> 
                                        @php
                                            $project_attachments = @$project->project_attachments ? @$project->project_attachments->where('type',1) : [];
                                        @endphp
                                        @forelse ($project_attachments ?? [] as $project_attachment)
                                        <div class="custom-img-upload custom-img-upload-xl upload-image-box uploadNext img-parent-box border-0">
                                            <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_attachment->attachment_id) }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: block;">
                                            @can('SolarMitra > Business > ProjectsController > remove_project_attachment')
                                            <button type="button" href="{{ route('business.solarmitra.projects.remove_project_attachment',$project_attachment->id) }}" class=" cancel-img-btn position-absolute" style="display: block; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>
                                            @endcan
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
                            </div>
                            

                        </div>
                        <!-- Start - Project Other Details -->

                    </div>

                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.next') }}</button>
        </div>

    </div>

