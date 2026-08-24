{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')

 <div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.handover',$project_id) }}" method="Post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-7 col-lg-6 mx-auto align-self-center">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <div class="row">

                            <!-- Start - Client Feedback -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mt-2 mb-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.client_feedback') }}</h4>
                                </div>

                                <div class="d-flex flex-column gap-2">

                                    <div>
                                        <label for="review" class="form-label">{{ __('solarmitra::solarmitra.write_review') }}</label>
                                        <textarea class="form-control" id="review" name="review" rows="5">{{old('review',@$client_feedback->review)}}</textarea>
                                        @error('review')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex flex-column">
                                            <label class="form-label d-flex gap-2">
                                                Upload Video
                                                <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your any Electricity Bill here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                                </svg>
                                            </label>
                                            <div class="upload-image-box img-parent-box">
                                                <div class="img-wrapper">
                                                    <video width="100%" height="240" class="img-for-onchange" controls @if (@$client_feedback->video_review) style="display: inline-block;" @endif>
                                                      <source src="{{ SolarMitraHelper::getAttachmentImage(@$client_feedback->video_review) }}" type="video/mp4">
                                                      Your browser does not support the video tag.
                                                    </video>
                                                    <button type="button" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$client_feedback->video_review) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                </div>
                                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="video_review" id="video_review"  hidden accept=".mp4">
                                                <label class="upload-label dropzone-btn" for="video_review" @if(@$client_feedback->video_review) style="display: none;" @endif>
                                                    Upload Video
                                                    <i class="ms-2 icon-upload text-primary fs-18"></i>
                                                </label>
                                            </div>
                                            @error('video_review')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- End - Client Feedback -->

                            <!-- Start - Site Completion  -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mb-4 mt-5">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.site_completion_photo') }}</h4>
                                </div>

                                <div class="d-flex flex-wrap gap-3"> 
                                    @php
                                        $project_attachments = @$project->project_attachments ? @$project->project_attachments->where('type',2) : [];
                                    @endphp
                                    @forelse ($project_attachments as $project_attachment)
                                    <div class="custom-img-upload custom-img-upload-xl upload-image-box uploadNext img-parent-box border-0">
                                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_attachment->attachment_id) }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: block;">
                                        @can('SolarMitra > Business > ProjectsController > remove_project_attachment')
                                        <button type="button" href="{{ route('business.solarmitra.projects.remove_project_attachment',$project_attachment->id) }}" class=" cancel-img-btn position-absolute" style="display: block; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>
                                        @endcan
                                    </div>
                                    @empty
                                    @endforelse
                                    <div class="custom-img-upload custom-img-upload-xl uploadNext img-parent-box border-0">
                                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->site_completion_photo) }}" class="img-for-onchange zoomable" alt="Image" width="150px" height="150px" title="Image" style="display: none;">

                                        <button type="button" class="cancel-img-btn position-absolute" style="display: none; z-index: 2;" aria-label="Close"><i class="icon icon-x"></i></button>

                                        <div class="upload-btn">
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="site_completion_photo[]" id="site_completion_photo" accept=".png, .jpg, .jpeg, .webp" hidden="">
                                            <label class="upload-label border-dashed flex-column justify-content-center text-center rounded dropzone-btn-xl m-0" style="display: flex;" for="site_completion_photo"><i class="fas fa-plus fs-26"></i></label>
                                        </div>
                                    </div>
                                </div>
                                @error('site_completion_photo')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End - Site Completion  -->

                            <!-- Start - Handover Letter  -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mb-4 mt-5">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.project_handover') }}</h4>
                                </div>

                                <label for="handover_status" class="form-label">{{ __('solarmitra::solarmitra.handover_status') }}</label>
                                <div class="d-flex justify-content-between align-items-center verification-item mb-3">
                                    <div class="form-check verification-checkbox">
                                        <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure all the Processes is complete and Project is Done Now." type="checkbox" value="1" name="handover_status" id="handover_status" @checked(old('handover_status', @$project_documents->handover_status) == 1)>
                                    </div>
                                </div>
                                @error('handover_status')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <label for="handover_confirmation_signature" class="form-label">{{ __('solarmitra::solarmitra.handover_later_signing') }}</label>

                                <div class="upload-image-box img-parent-box ">
                                    <div class="img-wrapper">
                                        
                                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->handover_confirmation_signature) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->handover_confirmation_signature) style="display: inline-block;" @endif>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'handover_confirmation_signature']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->handover_confirmation_signature) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                        @endcan
                                    </div>
                                    <input type="file" class="form-control ps-2 img-business-input-onchange" name="handover_confirmation_signature" id="handover_confirmation_signature"  hidden accept=".png, .jpg, .jpeg, .webp">
                                    <label class="upload-label dropzone-btn" for="handover_confirmation_signature" @if(@$project_documents->handover_confirmation_signature) style="display: none;" @endif>
                                        Handover Later Signing
                                        <i class="ms-2 icon-upload text-primary fs-18"></i>
                                    </label>
                                </div>
                                @error('handover_confirmation_signature')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- End - Handover Letter  -->

                            <div class="col-12">
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-between">
                    <a href="{{ route('business.solarmitra.projects.structure',$project_id) }}" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.previous') }}</a>
                    <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.done') }}</button>
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