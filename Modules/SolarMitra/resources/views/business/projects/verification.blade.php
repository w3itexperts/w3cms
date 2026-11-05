{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')

<div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.verification',$project_id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{@$project_id}}">
        @if (@$project_documents->government_subsidy)
            <input type="hidden" name="government_subsidy" value="1">
        @endif
        <div class="row">

            <div class="col-xxl-5 col-xl-6 col-lg-7 col-lg-6 mx-auto align-self-center">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">

                        <!-- Start - Document Verification -->
                        <div class="col-12">

                            <div class="text-start border-bottom border-grey position-relative mt-2 mb-4">
                                <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.document_verification') }}</h4>
                            </div>

                            <div class="d-flex flex-wrap flex-column gap-2">

                                <!-- Start - Eletricity Bill -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->electricity_bill) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">

                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Electricity Bill is Correct." name="electricity_bill_verification_status" type="checkbox" value="1" @checked(old('electricity_bill_verification_status', @$project_documents->electricity_bill_verification_status) == 1) id="electricity_bill_verification_status" {{ $isDisabled }}>

                                            <label class="form-check-label" for="electricity_bill_verification_status">
                                                Eletricity Bill
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('electricity_bill_verification_status', @$project_documents->electricity_bill_verification_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->electricity_bill) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'electricity_bill']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                @error('electricity_bill_verification_status')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <!-- End - Eletricity Bill -->

                                <!-- Start - Aadhar Card -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->adhar_card) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">
                                            
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Aadhar Card is Correct." name="adhar_card_verification_status" type="checkbox" value="1" @checked(old('adhar_card_verification_status', @$project_documents->adhar_card_verification_status) == 1) id="adhar_card_verification_status" {{$isDisabled}}>

                                            <label class="form-check-label" for="adhar_card_verification_status">
                                                Aadhar Card
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('adhar_card_verification_status', @$project_documents->adhar_card_verification_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->adhar_card) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'adhar_card']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                @error('adhar_card_verification_status')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <!-- End - Aadhar Card -->

                                @if (@$project_documents->government_subsidy)
                                <!-- Start - Pancard -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->pancard) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">
                                            
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Pancard is Correct." name="pancard_verification_status" type="checkbox" value="1" @checked(old('pancard_verification_status', @$project_documents->pancard_verification_status) == 1) id="pancard_verification_status" {{$isDisabled}}>

                                            <label class="form-check-label" for="pancard_verification_status">
                                                Pancard
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('pancard_verification_status', @$project_documents->pancard_verification_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->pancard) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'pancard']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                @error('pancard_verification_status')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <!-- End - Name Correction -->

                                <!-- Start - Bank Passbook -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->bank_passbook) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">
                                            
                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Bank Passbok is Correct." name="bank_passbook_verification_status" type="checkbox" value="1" @checked(old('bank_passbook_verification_status', @$project_documents->bank_passbook_verification_status) == 1) id="bank_passbook_verification_status" {{$isDisabled}}>

                                            <label class="form-check-label" for="bank_passbook_verification_status">
                                                Bank Passbook
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('bank_passbook_verification_status', @$project_documents->bank_passbook_verification_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->bank_passbook) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'bank_passbook']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                @error('bank_passbook_verification_status')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                                <!-- Start - Bank Passbook -->
                                @endif

                            </div>
                                
                        </div>
                        <!-- End - Document Verification -->

                        <!-- Start - Name Correction -->
                        <div class="col-12">

                            <div class="text-start border-bottom border-grey position-relative mb-4 mt-5">
                                <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.name_correction') }}</h4>
                            </div>

                            <p class="text-black">Your Name Correction Application Is in Under Process. It may take 1 to 30 working days according to Govt. rules</p>

                            <!-- Start - Name Correction -->
                            <div class="d-flex justify-content-between align-items-center verification-item">
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
                            <!-- End - Name Correction -->

                        </div>
                        <!-- End - Name Correction -->

                        <!-- Start - Name Transfer -->
                        <div class="col-12">

                            <div class="text-start border-bottom border-grey position-relative mb-4 mt-5">
                                <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.name_transfer') }}</h4>
                            </div>
                            <p class="text-black">Your Name Transfer Application Is in Under Process. It may take 1 to 30 working days according to Govt. rules</p>
                            <div class="d-flex flex-wrap flex-column gap-2">
                                <!-- Start - Name Transfer -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->noc_name_transfer) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">

                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure the Name Tranfer Certificate is Correct." name="noc_name_transfer_status" type="checkbox" value="1" @checked(old('noc_name_transfer_status', @$project_documents->noc_name_transfer_status) == 1) id="noc_name_transfer_status" {{$isDisabled}}>

                                            <label class="form-check-label" for="noc_name_transfer_status">
                                                Name Transfer
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('noc_name_transfer_status', @$project_documents->noc_name_transfer_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->noc_name_transfer) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'noc_name_transfer']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                <!-- End - Name Transfer -->
                                
                                <!-- Start - Property / Patta / Affidavit -->
                                <div class="d-flex justify-content-between align-items-center verification-item">
                                    @php
                                        $isDisabled = empty(@$project_documents->property_patta_evidence) ? 'disabled' : '';
                                    @endphp
                                    <div class="min-w300">
                                        <div class="form-check verification-checkbox">

                                            <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure Property Patta Evidence is Correct." name="property_patta_evidence_verification_status" type="checkbox" value="1" @checked(old('property_patta_evidence_verification_status', @$project_documents->property_patta_evidence_verification_status) == 1) id="property_patta_evidence_verification_status" {{$isDisabled}}>

                                            <label class="form-check-label" for="property_patta_evidence_verification_status">
                                                Property / Patta / Affidavit
                                            </label>
                                        </div>
                                    </div>
                                    <div class="verification-status {{old('property_patta_evidence_verification_status', @$project_documents->property_patta_evidence_verification_status) == 1 ? "complete" : 'pending'}}">
                                        <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                        <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}" class="btn btn-primary light py-2 btn-xs sharp me-1 document-view-btn {{$isDisabled}}" target="_blank" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ SolarMitraHelper::getAttachmentImage(@$project_documents->property_patta_evidence) }}" class="btn btn-info light py-2 btn-xs sharp me-1 document-download-btn {{$isDisabled}}" title="Download" Download Image ><i class="fas fa-download"></i></a>
                                        @can('SolarMitra > Business > ProjectsController > remove_document')
                                        <a href="{{ route('business.solarmitra.projects.remove_document',['project_id'=>$project_id,'doc_type'=>'property_patta_evidence']) }}" class="btn btn-danger light py-2 btn-xs sharp me-1 document-delete-btn {{$isDisabled}} deleteRecord" title="Delete"><i class="fas fa-trash"></i></a>
                                        @endcan
                                    </div>
                                </div>
                                <!-- End - Property / Patta / Affidavit -->
                            </div>
                        </div>
                        <!-- End - Name Transfer -->

                    </div>
                </div>
                <h5 class="text-center text-black mb-4">Now Your Project is in Verification Process.</h5>
                <div class="d-flex gap-2 justify-content-between">
                    <a href="{{ route('business.solarmitra.projects.documents',$project_id) }}" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.previous') }}</a>
                    <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.next') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection