{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')

<div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.documents',$project_id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{@$project_id}}">

        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <div class="row">

                            <!-- Start - Subsidy Confirmation -->
                            <div class="col-sm-12">

                                <div class="mb-3">
                                    <div class="text-start border-bottom border-grey position-relative my-4">
                                        <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.subsidy_confirmation') }}</h4>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" name="government_subsidy" value="1" 
                                        @checked(old('government_subsidy', @$project_documents->government_subsidy) == 1) type="checkbox" id="govtSubsidy">
                                        <label class="form-check-label" for="govtSubsidy">{{ __('solarmitra::solarmitra.i_want_govt_subsidy') }}</label>
                                    </div>
                                </div>

                                <div class="mb-3" id="SubsidyTypeInput" style="{{old('government_subsidy', @$project_documents->government_subsidy) == 1 ? '' : 'display:none'}}">
                                    <div class="btn-group dz-btn-group" role="group" aria-label="Basic radio toggle button group">
                                        @forelse (config('solarmitra.subsidy_type', []) as $key => $value)
                                            <input type="radio" class="btn-check" name="selected_subsidy_type" id="selected_subsidy_type{{$key}}" value="{{$key}}"  @checked(old('selected_subsidy_type', (@$project_documents->selected_subsidy_type ?? 3)) == $key)>
                                            <label class="btn btn-outline-primary" for="selected_subsidy_type{{$key}}">{{$value}}</label>
                                        @empty
                                        @endforelse
                                    </div>
                                    @error('selected_subsidy_type')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <!-- End - Subsidy Confirmation -->

                            <!-- Start - Document Upload -->
                            <div class="col-sm-12">

                                <div class="mb-4">
                                    <div class="text-start border-bottom border-grey position-relative my-4">
                                        <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.document_upload') }}</h4>
                                    </div>
                                </div>
                                <div class="row mb-3">

                                    <!-- Start - Electricity Bill -->
                                    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                                        <label class="form-label d-flex gap-2">
                                            Electricity Bill
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your any Electricity Bill here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->electricity_bill) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->electricity_bill) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'electricity_bill']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->electricity_bill) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="electricity_bill" id="electricity_bill" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden >
                                            <label class="upload-label dropzone-btn" for="electricity_bill" @if(@$project_documents->electricity_bill) style="display: none;" @endif>
                                                Upload Electricity Bill
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        @error('electricity_bill')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- End - Electricity Bill -->

                                    <!-- Start - Aadhar Card -->
                                    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                                        <label class="form-label d-flex gap-2">
                                            Aadhar Card
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Aadhar Card here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'adhar_card']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->adhar_card) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="adhar_card" id="adhar_card" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden>
                                            <label class="upload-label dropzone-btn" for="adhar_card" @if(@$project_documents->adhar_card) style="display: none;" @endif>
                                                Upload Adhar Card
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        @error('adhar_card')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- End - Aadhar Card -->

                                    <!-- Start - Aadhar Card -->
                                    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                                        <label class="form-label d-flex gap-2">
                                            Aadhar Card Back Side Image
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Aadhar Card Back Side Image here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card_backside), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card_backside) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card_backside) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card_backside) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'adhar_card_backside']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->adhar_card_backside) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="adhar_card_backside" id="adhar_card_backside" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden>
                                            <label class="upload-label dropzone-btn" for="adhar_card_backside" @if(@$project_documents->adhar_card_backside) style="display: none;" @endif>
                                                Upload Aadhar Card Back Side
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        @error('adhar_card_backside')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- End - Aadhar Card -->

                                    <!-- Start - Bank Passbook / Cancel Check -->
                                    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0 subsidy-inputs" style="display:none">
                                        <label class="form-label d-flex gap-2">
                                            Bank Passbook / Cancel Check
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Bank Passbook or a Cancel Check here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->bank_passbook) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->bank_passbook) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'bank_passbook']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->bank_passbook) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="bank_passbook" id="bank_passbook" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="bank_passbook" @if(@$project_documents->bank_passbook) style="display: none;" @endif>
                                                Upload Bank Passbook
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        @error('bank_passbook')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- End - Bank Passbook / Cancel Check -->

                                    <!-- Start - Pancard -->
                                    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0 subsidy-inputs" style="display:none">
                                        <label class="form-label d-flex gap-2">
                                            Pancard
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Pancard here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->pancard), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->pancard) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->pancard) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'pancard']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->pancard) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="pancard" id="pancard" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="pancard" @if(@$project_documents->pancard) style="display: none;" @endif>
                                                Upload Pancard
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        @error('pancard')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <!-- Start - Pancard -->

                                </div>

                            </div>
                            <!-- End - Document Upload -->

                            <!-- Start - Name Correction   -->
                            <div class="col-xl-6 col-sm-12">

                                <div class="mb-4">
                                    <div class="text-start border-bottom border-grey position-relative my-4">
                                        <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">Name Correction  </h4>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div>
                                        <label class="form-label d-flex gap-2" for="name_correction_new_name">
                                            Correct Name
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Enter your Correct Name here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>    
                                        <input class="form-control" id="name_correction_new_name" name="name_correction_new_name" type="text" value="{{old('name_correction_new_name',@$project_documents->name_correction_new_name)}}">
                                    </div>
                                </div>

                            </div>
                            <!-- End - Name Correction   -->

                            <!-- Start - Name Transfer -->
                            <div class="col-xl-6 col-sm-12">

                                <div class="mb-4">
                                    <div class="text-start border-bottom border-grey position-relative my-4">
                                        <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.name_transfer') }}</h4>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <!-- Start - Pancard -->
                                    <div class="col-md-6 mb-3 mb-xl-0">
                                        <label class="form-label d-flex gap-2">
                                            No Objection Certificate
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload No Objection Certificate here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper"> 
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->noc_name_transfer) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->noc_name_transfer) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'noc_name_transfer']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->noc_name_transfer) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="noc_name_transfer" id="noc_name_transfer" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="noc_name_transfer" @if(@$project_documents->noc_name_transfer) style="display: none;" @endif>
                                                Attach Media
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3 mb-xl-0">
                                        <label class="form-label d-flex gap-2">
                                            Property / Patta / Affidavit 
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Property here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->property_patta_evidence) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->property_patta_evidence) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'property_patta_evidence']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->property_patta_evidence) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="property_patta_evidence" id="property_patta_evidence" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="property_patta_evidence" @if(@$project_documents->property_patta_evidence) style="display: none;" @endif>
                                                Attach Media
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Start - Name Transfer -->

                        </div>

                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 justify-content-between">
                <a href="{{ route('business.solarmitra.projects.create') }}" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.previous') }}</a>
                <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.next') }}</button>
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
