{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')
<div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.netmeter',$project_id) }}" method="Post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-xxl-5 col-xl-6 col-lg-7 col-lg-6 mx-auto align-self-center">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <div class="row">

                            <!-- Start - Subsidy Registration -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mt-2 mb-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.net_metering') }}</h4>
                                </div>

                                <div class="d-flex flex-column gap-3">

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter File Submission." type="checkbox" value="1" name="netmeter_file_submission" id="netmeter_file_submission" @checked(old('netmeter_file_submission', @$project_documents->netmeter_file_submission) == 1)>
                                                <label class="form-check-label" for="netmeter_file_submission">
                                                    Netmeter File Submission
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_file_submission', @$project_documents->netmeter_file_submission) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_file_submission')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter Site Visited." type="checkbox" value="1" name="netmeter_site_visited" id="netmeter_site_visited" @checked(old('netmeter_site_visited', @$project_documents->netmeter_site_visited) == 1)>
                                                <label class="form-check-label" for="netmeter_site_visited">
                                                    Netmeter Site Visited
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_site_visited', @$project_documents->netmeter_site_visited) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_site_visited')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter Demand Note Generated." type="checkbox" value="1" name="netmeter_demand_note_generated" id="netmeter_demand_note_generated" @checked(old('netmeter_demand_note_generated', @$project_documents->netmeter_demand_note_generated) == 1)>
                                                <label class="form-check-label" for="netmeter_demand_note_generated">
                                                    Netmeter Demand Note Generated
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_demand_note_generated', @$project_documents->netmeter_demand_note_generated) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_demand_note_generated')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter Demand Note Paid." type="checkbox" value="1" name="netmeter_demand_note_paid" id="netmeter_demand_note_paid" @checked(old('netmeter_demand_note_paid', @$project_documents->netmeter_demand_note_paid) == 1)>
                                                <label class="form-check-label" for="netmeter_demand_note_paid">
                                                    Netmeter Demand Note Paid
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_demand_note_paid', @$project_documents->netmeter_demand_note_paid) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_demand_note_paid')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter Installed." type="checkbox" value="1" name="netmeter_installed" id="netmeter_installed" @checked(old('netmeter_installed', @$project_documents->netmeter_installed) == 1)>
                                                <label class="form-check-label" for="netmeter_installed">
                                                    Netmeter Installed
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_installed', @$project_documents->netmeter_installed) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_installed')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Netmeter Plant On." type="checkbox" value="1" name="netmeter_plant_on" id="netmeter_plant_on" @checked(old('netmeter_plant_on', @$project_documents->netmeter_plant_on) == 1)>
                                                <label class="form-check-label" for="netmeter_plant_on">
                                                    Netmeter Plant On
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('netmeter_plant_on', @$project_documents->netmeter_plant_on) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        
                                        @error('netmeter_plant_on')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-6">
                                            <label class="form-label d-flex gap-2">
                                                Netmeter Photo
                                                <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your any Netmeter Photo here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                                </svg>
                                            </label>
                                            <div class="upload-image-box img-parent-box">
                                                <div class="img-wrapper">
                                                    @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_photo), PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_photo) style="display: inline-block;" @endif>
                                                    @else
                                                    <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_photo) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_photo) style="display: inline-block;" @endif>
                                                    @endif
                                                    @can('SolarMitra > Business > ProjectsController > remove_document')
                                                    <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'netmeter_photo']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->netmeter_photo) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                    @endcan
                                                </div>
                                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="netmeter_photo" id="netmeter_photo" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden >
                                                <label class="upload-label dropzone-btn" for="netmeter_photo" @if(@$project_documents->netmeter_photo) style="display: none;" @endif>
                                                    Upload Netmeter Photo
                                                    <i class="ms-2 icon-upload text-primary fs-18"></i>
                                                </label>
                                            </div>
                                            @error('netmeter_photo')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label d-flex gap-2">
                                                Netmeter Plant Photo
                                                <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your any Netmeter Plant Photo here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                                </svg>
                                            </label>
                                            <div class="upload-image-box img-parent-box">
                                                <div class="img-wrapper">
                                                    @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_plant_photo), PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif>
                                                    @else
                                                    <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_plant_photo) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif>
                                                    @endif
                                                    @can('SolarMitra > Business > ProjectsController > remove_document')
                                                    <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'netmeter_plant_photo']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                    @endcan
                                                </div>
                                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="netmeter_plant_photo" id="netmeter_plant_photo" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden >
                                                <label class="upload-label dropzone-btn" for="netmeter_plant_photo" @if(@$project_documents->netmeter_plant_photo) style="display: none;" @endif>
                                                    Upload Netmeter Plant Photo
                                                    <i class="ms-2 icon-upload text-primary fs-18"></i>
                                                </label>
                                            </div>
                                            @error('netmeter_plant_photo')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End - Subsidy Registration -->
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-between">
                    <a href="{{ route('business.solarmitra.projects.subsidy',$project_id) }}" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.previous') }}</a>
                    <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.next') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@push('inline-modals')
     <!-- Start - Remove Image Modal -->
    <div class="modal fade" id="imageRemoveConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content stylish-modal text-center p-3">
                <div class="text-danger mb-2">
                    <i class="icon icon-trash-2 fs-26"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Are you sure?</h5>
                <p class="text-muted mb-3">You want to remove this image.</p>
            
                <!-- Image preview -->
                <div class="preview-wrapper mb-3 rounded shadow-sm overflow-hidden">
                    <img id="previewImageInModal" src="" alt="Preview" class="img-fluid w-100" />
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-1" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.cancel') }}</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 py-1" id="confirmRemoveImageBtn">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End - Remove Image Modal -->   
@endpush