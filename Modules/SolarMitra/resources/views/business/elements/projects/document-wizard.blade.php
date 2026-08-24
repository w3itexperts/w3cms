@php
    $isDraft = $project->status == config('solarmitra.projects_status_keys.Draft');
    $currentStep = SolarMitraHelper::getProjectStep($project->id);

    $steps = [
        'documents',
        'verification',
        'subsidy',
        'structure',
        'netmeter',
        'handover',
    ];

    if (
        !$currentStep ||
        !auth('business')->user()->can('SolarMitra > Business > ProjectsController > ' . $currentStep)
    ) {
        foreach ($steps as $step) {
            if (auth('business')->user()->can('SolarMitra > Business > ProjectsController > ' . $step)) {
                $currentStep = $step;
                break;
            }
        }
    }


@endphp

<div class="card">
    <div class="card-body wizard-box">
        <span id="projectStep" hidden data-step="{{ $currentStep }}"></span>

        <div class="wizard-steps">
            <!-- Start - Wizard Steps -->
            <ul class="wizard-step d-flex">
                @can('SolarMitra > Business > ProjectsController > documents')
                <li class="step-container step-1 d-inline-block {{ $currentStep == 'documents' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-info fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Documents</p>
                </div>
                </li>
                @endcan
                @can('SolarMitra > Business > ProjectsController > verification')
                <li class="step-container step-2 {{ ($currentStep == 'verification' && !$isDraft) ? '' : '' }} d-inline-block {{ $currentStep == 'verification' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-shield-check fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Verification @if($isDraft) <i class="icon d-inline-block align-middle icon-lock fs-14 text-primary ms-1"></i> @endif</p>
                </div>
                </li>
                @endcan
                @if((@$project_documents->government_subsidy) == 1 && auth('business')->user()->can('SolarMitra > Business > ProjectsController > subsidy'))
                <li class="step-container step-3 {{ ($currentStep == 'verification' && !$isDraft) ? '' : '' }} d-inline-block {{ $currentStep == 'subsidy' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-hand-coins fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Subsidy @if($isDraft) <i class="icon d-inline-block align-middle icon-lock fs-14 text-primary ms-1"></i> @endif</p>
                </div>
                </li>
                @endif
                @can('SolarMitra > Business > ProjectsController > structure')
                <li class="step-container step-4 {{ ($currentStep == 'verification' && !$isDraft) ? '' : '' }} d-inline-block {{ $currentStep == 'structure' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-zap fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Installation @if($isDraft) <i class="icon d-inline-block align-middle icon-lock fs-14 text-primary ms-1"></i> @endif</p>
                </div>
                </li>
                @endcan
                @can('SolarMitra > Business > ProjectsController > netmeter')
                <li class="step-container step-5 {{ ($currentStep == 'verification' && !$isDraft) ? '' : '' }} d-inline-block {{ $currentStep == 'netmeter' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-circle-gauge fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Net Metering @if($isDraft) <i class="icon d-inline-block align-middle icon-lock fs-14 text-primary ms-1"></i> @endif</p>
                </div>
                </li>
                @endcan
                @can('SolarMitra > Business > ProjectsController > handover')
                <li class="step-container step-6 {{ ($currentStep == 'verification' && !$isDraft) ? '' : '' }} d-inline-block {{ $currentStep == 'handover' ? 'active' : '' }}">
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <div class="step-icon">
                        <i class="icon-handshake fs-24"></i>
                    </div>
                    <p class="m-0 fs-15">Hand Over @if($isDraft) <i class="icon d-inline-block align-middle icon-lock fs-14 text-primary ms-1"></i> @endif</p>
                </div>
                </li>
                @endcan
            </ul>
            <!-- End - Wizard Steps -->
            @can('SolarMitra > Business > ProjectsController > documents')
            <!-- Start - Wizard Step 1 -->
            <div class="wizard-step-1 {{ $currentStep == 'documents' ? 'd-block' : 'd-none disabled ' }}">
                <form action="{{route('business.solarmitra.projects.documents',@$project->id)}}" data-ajax-container="#DocumentWizard" method="post" class="row AjaxModalForm">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            <!-- Subsidy Confirmation -->
                            <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.subsidy_confirmation') }}</h4>
                                <div class="form-check">
                                    <input class="form-check-input" name="government_subsidy" value="1"
                                    @checked(old('government_subsidy', @$project_documents->government_subsidy) == 1) type="checkbox" id="govtSubsidy">
                                    
                                    <label class="form-check-label" for="govtSubsidy">
                                        I Want Govt Subsidy
                                    </label>
                                </div>
                                <span class="government_subsidy_error text-danger fs-12"></span>

                                <div class="mt-3" id="SubsidyTypeInput" style="{{old('government_subsidy', @$project_documents->government_subsidy) == 1 ? '' : 'display:none'}}">
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
                            </div>
                            <!-- Document Upload -->
                            <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.document_upload') }}</h4>
                                <div class="row gy-3">
                                    <!-- Electricity Bill -->
                                    <div class="col-xxl-4 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            Electricity Bill
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your any Electricity Bill here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->electricity_bill) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->electricity_bill) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'electricity_bill']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->electricity_bill) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="electricity_bill_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Aadhar Card -->
                                    <div class="col-xxl-4 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            Aadhar Card
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Aadhar Card here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'adhar_card']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->adhar_card) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="adhar_card_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Aadhar Card Back Side -->
                                    <div class="col-xxl-4 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            Aadhar Card Back Side Image
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Aadhar Card Back Side Image here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card_backside), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card_backside) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card_backside) }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->adhar_card_backside) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'adhar_card_backside']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->adhar_card_backside) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="adhar_card_backside_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Bank Passbook / Cancel Check -->
                                    <div class="col-xxl-4 col-md-6 subsidy-inputs" style="display:none">
                                        <label class="form-label d-flex gap-2">
                                            Bank Passbook / Cancel Check
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Bank Passbook or a Cancel Check here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->bank_passbook) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->bank_passbook) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'bank_passbook']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->bank_passbook) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="bank_passbook_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Pancard -->
                                    <div class="col-xxl-4 col-md-6 subsidy-inputs" style="display:none">
                                        <label class="form-label d-flex gap-2">
                                            Pancard
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Pancard here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->pancard), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->pancard) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->pancard) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'pancard']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->pancard) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="pancard_error text-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- Name Transfer & Correction -->
                            <div class="row g-4">
                            <div class="col-lg-8">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.name_transfer') }}</h4>
                                <div class="row gy-3">
                                    <!-- No Objection Certificate -->
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            No Objection Certificate
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload No Objection Certificate here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper"> 
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->noc_name_transfer) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" alt="Image" height="150px" title="Image" @if (@$project_documents->noc_name_transfer) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'noc_name_transfer']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->noc_name_transfer) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="noc_name_transfer" id="noc_name_transfer" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="noc_name_transfer" @if(@$project_documents->noc_name_transfer) style="display: none;" @endif>
                                                Attach Media
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        <span class="noc_name_transfer_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Property / Patta / Affidavit -->
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            Property / Patta / Affidavit 
                                            <svg class="pointer" data-bs-toggle="tooltip" data-bs-title="Upload Your Property here." width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="var(--bs-primary)"/>
                                            </svg>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->property_patta_evidence) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}"  alt="Image" height="150px" title="Image" @if (@$project_documents->property_patta_evidence) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'property_patta_evidence']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->property_patta_evidence) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                @endcan
                                            </div>
                                            <input type="file" class="form-control ps-2 img-business-input-onchange" name="property_patta_evidence" id="property_patta_evidence" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden="">
                                            <label class="upload-label dropzone-btn" for="property_patta_evidence" @if(@$project_documents->property_patta_evidence) style="display: none;" @endif>
                                                Attach Media
                                                <i class="ms-2 icon-upload text-primary fs-18"></i>
                                            </label>
                                        </div>
                                        <span class="property_patta_evidence_error text-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.name_correction') }}</h4>
                                <label class="form-label mb-1" for="correctName">{{ __('solarmitra::solarmitra.correct_name') }}</label>
                                <input type="text" name="name_correction_new_name" class="form-control"  id="correctName" value="{{old('name_correction_new_name',@$project_documents->name_correction_new_name)}}">
                                <span class="name_correction_new_name_error text-danger fs-12"></span>
                            </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 1 -->
            @endcan
            @can('SolarMitra > Business > ProjectsController > verification')
            <!-- Start - Wizard Step 2 -->
            <div class="wizard-step-2 {{ $currentStep == 'verification' ? 'd-block' : 'd-none disabled' }}">
                <form action="{{route('business.solarmitra.projects.verification',@$project->id)}}" method="post" data-ajax-container="#DocumentWizard" class="row AjaxModalForm">
                @csrf
                <div class="col-lg-7 mx-auto">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            <!-- Document Verification -->
                            <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.document_verification') }}</h4>
                                
                                <div class="d-flex flex-column gap-2">
                                    
                                    <!-- Start - Electricity Bill -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->electricity_bill) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Electricity Bill is Correct." name="electricity_bill_verification_status" type="checkbox" value="1" @checked(old('electricity_bill_verification_status', @$project_documents->electricity_bill_verification_status) == 1) id="electricity_bill_verification_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="electricity_bill_verification_status">
                                                Electricity Bill
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('electricity_bill_verification_status', @$project_documents->electricity_bill_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'electricity_bill']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                            @endcan
                                            </div>
                                        </div>
                                        <span class="electricity_bill_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Electricity Bill -->
                                    
                                    <!-- Start - Aadhaar Card -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->adhar_card) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Aadhar Card is Correct." name="adhar_card_verification_status" type="checkbox" value="1" @checked(old('adhar_card_verification_status', @$project_documents->adhar_card_verification_status) == 1) id="adhar_card_verification_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="adhar_card_verification_status">
                                                Aadhar Card
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('adhar_card_verification_status', @$project_documents->adhar_card_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'adhar_card']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                            @endcan
                                            </div>
                                        </div>
                                        <span class="adhar_card_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Aadhar Card -->
                                    
                                    <!-- Start - Pancard -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->pancard) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Pan Card is Correct." name="pancard_verification_status" type="checkbox" value="1" @checked(old('pancard_verification_status', @$project_documents->pancard_verification_status) == 1) id="pancard_verification_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="pancard_verification_status">
                                                Pan Card
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('pancard_verification_status', @$project_documents->pancard_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'pancard']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                           @endcan
                                            </div>
                                        </div>
                                        <span class="pancard_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Pancard -->
                                    <!-- Start - Bank Passbook -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->bank_passbook) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Bank Passbook is Correct." name="bank_passbook_verification_status" type="checkbox" value="1" @checked(old('bank_passbook_verification_status', @$project_documents->bank_passbook_verification_status) == 1) id="bank_passbook_verification_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="bank_passbook_verification_status">
                                                Bank Passbook
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('bank_passbook_verification_status', @$project_documents->bank_passbook_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'bank_passbook']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                            @endcan
                                            </div>
                                        </div>
                                        <span class="bank_passbook_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Bank Passbook -->
                                </div>
                            </div>
                            </div>
                            <!-- Name Correction -->
                            <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.name_correction') }}</h4>
                                <span class="fs-13">Your Name Correction Application Is in Under Process. It may take 1 to 30 working days according to Govt. rules</span>
                                
                                <!-- Start - Name Correction -->
                                <div class="d-flex justify-content-between mt-3 align-items-center verification-item">
                                    @php
                                    $isDisabled = empty(@$project_documents->name_correction_new_name) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">
                                        <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure the Name is Correct." name="name_correction_new_name_status" type="checkbox" value="1" @checked(old('name_correction_new_name_status', @$project_documents->name_correction_new_name_status) == 1) id="name_correction_new_name_status" {{$isDisabled}}>
                                        <label class="form-check-label" for="name_correction_new_name_status">
                                            Name Correction
                                        </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('name_correction_new_name_status', @$project_documents->name_correction_new_name_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.complete') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                </div>
                                <span class="name_correction_new_name_status_error text-danger fs-12"></span>
                                <!-- End - Name Correction -->
                            </div>
                            </div>
                            <!-- Name Transfer -->
                            <div class="row">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.name_transfer') }}</h4>
                                <span class="fs-13">Your Name Transfer Application Is in Under Process. It may take 1 to 30 working days according to Govt. rules</span>
                                <div class="d-flex gap-2 flex-column mt-3">
                                    
                                    <!-- Start - Name Transfer -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->noc_name_transfer) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Name Transfer is Correct." name="noc_name_transfer_status" type="checkbox" value="1" @checked(old('noc_name_transfer_status', @$project_documents->noc_name_transfer_status) == 1) id="noc_name_transfer_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="noc_name_transfer_status">
                                                Name Transfer
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('noc_name_transfer_status', @$project_documents->noc_name_transfer_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'noc_name_transfer']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                            @endcan    
                                        </div>
                                        </div>
                                        <span class="noc_name_transfer_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Name Transfer -->
                                    <!-- Start - Property / Patta / Affidavit -->
                                    <div>
                                        <div class="row align-items-center verification-item">
                                            @php
                                            $isDisabled = empty(@$project_documents->property_patta_evidence) ? 'disabled' : '';
                                            @endphp
                                            <div class="form-check verification-checkbox col-5">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Property / Patta / Affidavit is Correct." name="property_patta_evidence_verification_status" type="checkbox" value="1" @checked(old('property_patta_evidence_verification_status', @$project_documents->property_patta_evidence_verification_status) == 1) id="property_patta_evidence_verification_status" {{ $isDisabled }}>
                                            <label class="form-check-label" for="property_patta_evidence_verification_status">
                                                Property / Patta / Affidavit
                                            </label>
                                            </div>
                                            <div class="verification-status text-center col-3 {{old('property_patta_evidence_verification_status', @$project_documents->property_patta_evidence_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                            <div class="d-flex gap-2 col-4 justify-content-end">
                                            <button 
                                                data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}"
                                                aria-label="View document" 
                                                class="btn btn-square btn-sm border zoomable {{$isDisabled}}" 
                                            >
                                                <i class="icon-eye"></i>
                                            </button>
                                            <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}" class="btn btn-square btn-sm border {{$isDisabled}}" title="Download" Download Image ><i class="icon-download"></i></a>
                                            @can('SolarMitra > Business > ProjectsController > remove_document')
                                            <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'property_patta_evidence']) }}" class="btn btn-square btn-sm border {{$isDisabled}} deleteRecord"><i class="icon-trash text-danger"></i></a>
                                            @endcan
                                            </div>
                                        </div>
                                        <span class="property_patta_evidence_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <!-- End - Property / Patta / Affidavit -->
                                </div>
                            </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 2 -->
            @endcan
            @can('SolarMitra > Business > ProjectsController > subsidy')
            <!-- Start - Wizard Step 3 -->
            <div class="wizard-step-3 {{ $currentStep == 'subsidy' ? 'd-block' : 'd-none disabled' }}">
                <form action="{{route('business.solarmitra.projects.subsidy',@$project->id)}}" method="post" data-ajax-container="#DocumentWizard" class="row AjaxModalForm">
                @csrf
                <div class="col-lg-7 mx-auto">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            <!-- Subsidy Registration -->
                            <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.subsidy_registration') }}</h4>
                                
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    <div class="form-check verification-checkbox">
                                        <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Subsidy Registration." name="subsidi_registration_status" type="checkbox" value="1" @checked(old('subsidi_registration_status', @$project_documents->subsidi_registration_status) == 1) id="subsidi_registration_status">
                                        <label class="form-check-label" for="subsidi_registration_status">
                                        Subsidi Registration
                                        </label>
                                    </div>
                                    <div class="verification-status {{old('subsidi_registration_status', @$project_documents->subsidi_registration_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- <p class="m-0 fs-13">Assign: <span class="fw-semibold">Vikas Malav</span></p> --}}
                                    <span>{{optional($project->project_dates)->subsidi_registration_date}}</span>
                                </div>
                                <span class="subsidi_registration_status_error text-danger fs-12"></span>
                            </div>
                            </div>
                            <!-- Loan Application -->
                            <div class="row">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.loan_application') }}</h4>
                                <div class="d-flex flex-column gap-3">
                                    
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Loan Document Submition." type="checkbox" value="1" name="loan_doc_submit_status" @checked(old('loan_doc_submit_status', @$project_documents->loan_doc_submit_status) == 1) id="loan_doc_submit_status">
                                            <label class="form-check-label" for="loan_doc_submit_status">
                                                Loan Document Submition
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('loan_doc_submit_status', @$project_documents->loan_doc_submit_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <span>{{optional($project->project_dates)->loan_doc_submit_date}}</span>
                                        </div>
                                        <span class="loan_doc_submit_status_error text-danger fs-12"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Bank Verification." type="checkbox" value="1" name="bank_verification_status" @checked(old('bank_verification_status', @$project_documents->bank_verification_status) == 1) id="bank_verification_status">
                                            <label class="form-check-label" for="bank_verification_status">
                                                Bank Verification
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('bank_verification_status', @$project_documents->bank_verification_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 fs-13">By: <span class="fw-semibold">Bank</span></p>
                                        <span>{{optional($project->project_dates)->bank_verification_date}}</span>
                                        </div>
                                        <span class="bank_verification_status_error text-danger fs-12"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Loan Disbarsment." type="checkbox" value="1" name="loan_disberment_status" @checked(old('loan_disberment_status', @$project_documents->loan_disberment_status) == 1) id="loan_disberment_status">
                                            <label class="form-check-label" for="loan_disberment_status">
                                                Loan Disbarsment
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('loan_disberment_status', @$project_documents->loan_disberment_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 fs-13">By: <span class="fw-semibold">Bank</span></p>
                                        <span>{{optional($project->project_dates)->loan_disberment_date}}</span>
                                        </div>
                                        <span class="loan_disberment_status_error text-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 3 -->
            @endcan
            @can('SolarMitra > Business > ProjectsController > structure')
            <!-- Start - Wizard Step 4 -->
            <div class="wizard-step-4 {{ $currentStep == 'structure' ? 'd-block' : 'd-none disabled' }}">
                <form action="{{route('business.solarmitra.projects.structure',@$project->id)}}" method="post" data-ajax-container="#DocumentWizard" class="row AjaxModalForm">
                @csrf
                <div class="col-lg-7 mx-auto">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            <!-- Work Done -->
                            <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.work_done') }}</h4>
                                <div class="d-flex flex-column gap-3">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Structure Work." type="checkbox" value="1" name="structure_work_status" id="structure_work_status" @checked(old('structure_work_status', @$project_documents->structure_work_status) == 1)>
                                            <label class="form-check-label" for="structure_work_status">
                                                Structure Work
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('structure_work_status', @$project_documents->structure_work_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <span class="structure_work_status_error text-danger fs-12"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Panel Work." type="checkbox" value="1" name="panel_work_status" id="panel_work_status" @checked(old('panel_work_status', @$project_documents->panel_work_status) == 1)>
                                            <label class="form-check-label" for="panel_work_status">
                                                Panel Work
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('panel_work_status', @$project_documents->panel_work_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 fs-13">{{-- Assign By: <span class="fw-semibold">Vikas Malav</span> --}}</p>
                                        <p class="m-0 fs-13">{{optional($project->project_dates)->panel_work_date}}</p>
                                        </div>
                                        <span class="panel_work_status_error text-danger fs-12"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Cabiling Work." type="checkbox" value="1" name="cabling_work_status" id="cabling_work_status" @checked(old('cabling_work_status', @$project_documents->cabling_work_status) == 1)>
                                            <label class="form-check-label" for="cabling_work_status">
                                                Cabiling Work
                                            </label>
                                        </div>
                                        
                                        <div class="verification-status {{old('cabling_work_status', @$project_documents->cabling_work_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 fs-13">{{-- Assign By: <span class="fw-semibold">Vikas Malav</span> --}}</p>
                                        <p class="m-0 fs-13">{{optional($project->project_dates)->cabling_work_date}}</p>
                                        </div>
                                        <span class="cabling_work_status_error text-danger fs-12"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                        <div class="form-check verification-checkbox">
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Civil Work." type="checkbox" value="1" name="civil_work_status" id="civil_work_status" @checked(old('civil_work_status', @$project_documents->civil_work_status) == 1)>
                                            <label class="form-check-label" for="civil_work_status">
                                                Civil Work
                                            </label>
                                        </div>
                                        <div class="verification-status {{old('civil_work_status', @$project_documents->civil_work_status) == 1 ? "complete" : 'pending'}}">
                                            <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                            <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                        </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                        <p class="m-0 fs-13">{{-- Assign By: <span class="fw-semibold">Vikas Malav</span> --}}</p>
                                        <p class="m-0 fs-13">{{optional($project->project_dates)->civil_work_date}}</p>
                                        </div>
                                        <span class="civil_work_status_error text-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 4 -->
            @endcan
            @can('SolarMitra > Business > ProjectsController > netmeter')
            <!-- Start - Wizard Step 5 -->
            <div class="wizard-step-5 {{ $currentStep == 'netmeter' ? 'd-block' : 'd-none disabled' }}">
                <form action="{{route('business.solarmitra.projects.netmeter',@$project->id)}}" method="post" data-ajax-container="#DocumentWizard" class="row AjaxModalForm">
                @csrf
                <div class="col-lg-7 mx-auto">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            
                            <!-- Net Metering -->
                            <div class="row mb-3">
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.net_metering') }}</h4>
                                <div class="d-flex flex-column gap-3 mb-3">
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
                                        <span class="netmeter_file_submission_error text-danger fs-12"></span>
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
                                        <span class="netmeter_site_visited_error text-danger fs-12"></span>
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
                                        <span class="netmeter_demand_note_generated_error text-danger fs-12"></span>
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
                                        <span class="netmeter_demand_note_paid_error text-danger fs-12"></span>
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
                                        <span class="netmeter_installed_error text-danger fs-12"></span>
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
                                        <span class="netmeter_plant_on_error text-danger fs-12"></span>
                                    </div>
                                </div>
                                <div class="row gy-3">
                                    <!-- Netmeter Photo -->
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <label class="form-label d-flex gap-2">
                                            Netmeter Photo
                                            <i class="icon-info text-primary" data-bs-toggle="tooltip" data-bs-title="Upload Your any Netmeter Photo here."></i>
                                        </label>
                                        <div class="upload-image-box img-parent-box">
                                            <div class="img-wrapper">
                                                @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_photo), PATHINFO_EXTENSION) == 'pdf')
                                                <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_photo) style="display: inline-block;" @endif>
                                                @else
                                                <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_photo) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_photo) style="display: inline-block;" @endif>
                                                @endif
                                                @can('SolarMitra > Business > ProjectsController > remove_document')
                                                <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'netmeter_photo']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->netmeter_photo) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
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
                                        <span class="netmeter_photo_error text-danger fs-12"></span>
                                    </div>
                                    <!-- Netmeter Plant Photo -->
                                    <div class="col-xl-6 col-lg-12 col-md-6">
                                        <label class="form-label mb-1 align-items-center" for="netmeter_plant_photo">Netmeter Plant Photo <i class="icon-info text-primary" data-bs-toggle="tooltip" data-bs-title="Upload Netmeter Plant Photo."></i> </label>
                                        <div class="upload-image-box img-parent-box">
                                                <div class="img-wrapper">
                                                    @if (pathinfo(SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_plant_photo), PATHINFO_EXTENSION) == 'pdf')
                                                    <img src="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" data-src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="img-for-onchange zoomable" data-pdf-icon="{{ asset('modules/solarmitra/images/pdf-icon.png') }}" alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif>
                                                    @else
                                                    <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->netmeter_plant_photo) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif>
                                                    @endif
                                                    @can('SolarMitra > Business > ProjectsController > remove_document')
                                                    <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'netmeter_plant_photo']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->netmeter_plant_photo) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                                    @endcan
                                                </div>
                                                <input type="file" class="form-control ps-2 img-business-input-onchange" name="netmeter_plant_photo" id="netmeter_plant_photo" accept=".png, .jpg, .jpeg, .webp, .pdf" hidden >
                                                <label class="upload-label dropzone-btn" for="netmeter_plant_photo" @if(@$project_documents->netmeter_plant_photo) style="display: none;" @endif>
                                                    Upload Netmeter Plant Photo
                                                    <i class="ms-2 icon-upload text-primary fs-18"></i>
                                                </label>
                                            </div>
                                        <span class="netmeter_plant_photo_error text-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 5 -->
            @endcan
            @can('SolarMitra > Business > ProjectsController > handover')
            <!-- Start - Wizard Step 6 -->
            <div class="wizard-step-6 {{ $currentStep == 'handover' ? 'd-block' : 'd-none disabled' }}">
                <form action="{{route('business.solarmitra.projects.handover',@$project->id)}}" method="post" data-ajax-container="#DocumentWizard" class="row AjaxModalForm">
                @csrf
                <div class="col-lg-7 mx-auto">
                    <div class="card">
                        <div class="formLoading d-none">
                            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
                            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
                        </div>
                        <div class="card-body">
                            
                            <!-- Client Feedback -->
                            <div class="row gy-3">
                            
                            <div class="col-xl-6">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.client_feedback') }}</h4>
                                <div class="mb-3">
                                    <label for="review" class="form-label mb-1">{{ __('solarmitra::solarmitra.write_review') }}</label>
                                    <textarea class="form-control" id="review" name="review" rows="4">{{old('review',optional(@$project->client_feedback)->review)}}</textarea>
                                    <span class="review_error text-danger fs-12"></span>
                                </div>
                                <!-- Upload Video -->
                                <div>
                                    <label class="form-label mb-1 align-items-center">Upload Video <i class="icon-info text-primary" data-bs-toggle="tooltip" data-bs-title="Upload Customer Review Video Upto 10MB"></i> </label>
                                    
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
                                    <span class="video_review_error text-danger fs-12"></span>
                                </div>
                            </div>
                            <!-- Site Completion Photo -->
                            <div class="col-xl-6">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.site_completion_photo') }}</h4>
                                @php
                                $project_attachments = @$project->project_attachments ? @$project->project_attachments->where('type',2) : [];
                                $site_images = [];
                                if(!empty($project_attachments)){
                                foreach($project_attachments as $attachment){
                                $data = SolarMitraHelper::getAttachment(@$attachment->attachment_id);
                                $data->attachment_id = $attachment->id;
                                $site_images[] = $data;
                                }
                                }
                                @endphp
                                
                                <div class="d-flex flex-wrap gap-2"> 
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
                                <span class="site_completion_photo_error text-danger fs-12"></span>
                            </div>
                            <!-- Handover Later Signing -->
                            <div class="col-12">
                                <h4 class="fs-15 fw-semibold text-primary pb-2 mb-3 border-bottom">{{ __('solarmitra::solarmitra.handover_later_signing') }}</h4>

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
                                
                                <div>
                                    <label class="form-label mb-1 align-items-center">Handover Later <i class="icon-info text-primary" data-bs-toggle="tooltip" data-bs-title="Upload Handover Later with Signature"></i> </label>
                                    
                                    <div class="upload-image-box img-parent-box ">
                                    <div class="img-wrapper">
                                        
                                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->handover_confirmation_signature) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$project_documents->handover_confirmation_signature) style="display: inline-block;" @endif>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <button type="button" href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project->id,'doc_type'=>'handover_confirmation_signature']) }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$project_documents->handover_confirmation_signature) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                                        @endcan
                                    </div>
                                    <input type="file" class="form-control ps-2 img-business-input-onchange" name="handover_confirmation_signature" id="handover_confirmation_signature"  hidden accept=".png, .jpg, .jpeg, .webp">
                                    <label class="upload-label dropzone-btn" for="handover_confirmation_signature" @if(@$project_documents->handover_confirmation_signature) style="display: none;" @endif>
                                        Handover Later Signing
                                        <i class="ms-2 icon-upload text-primary fs-18"></i>
                                    </label>
                                </div>
                                    <span class="handover_confirmation_signature_error text-danger fs-12"></span>
                                </div>
                            </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <!-- End - Wizard Step 6 -->
            @endcan
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <button type="button" title="Previous" data-subsidy="{{ (@$project_documents->government_subsidy) == 1 }}" class="btn project-previous btn-primary" style=" {{$currentStep == 'documents' ? 'display:none' : ''}}"><i class="icon-arrow-left"></i>{{ __('solarmitra::solarmitra.previous') }}</button>
            </div>
            @if (!$isDraft)
            <div class="col-6 text-end">
                <button type="button" title="Next" data-subsidy="{{ (@$project_documents->government_subsidy) == 1 }}" class="btn project-next btn-primary" style=" {{$currentStep == 'handover' ? 'display:none' : ''}}">Next <i class="icon-arrow-right"></i></button>
            </div>
            @endif
        </div>
    </div>
    </div>