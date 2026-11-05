{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')

<div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.subsidy',$project_id) }}" method="Post">
        @csrf
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-lg-7 col-lg-6 mx-auto align-self-center">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <div class="row">

                            <!-- Start - Subsidy Registration -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mt-2 mb-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.subsidy_registration') }}</h4>
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <div>
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
                                            <span class="m-0 fs-12">{{-- Assign: Vikas Malav --}}</span>
                                            <span>{{@$project_dates->subsidi_registration_date}}</span>
                                        </div>
                                        @error('subsidi_registration_status')
                                            <p class="text-danger m-0">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- End - Subsidy Registration -->

                            <!-- Start - Loan Application  -->
                            <div class="col-xl-12">

                                <div class="text-start border-bottom border-grey position-relative mb-4 mt-5">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">Loan Application </h4>
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Loan Document Submission." type="checkbox" value="1" name="loan_doc_submit_status" @checked(old('loan_doc_submit_status', @$project_documents->loan_doc_submit_status) == 1) id="loan_doc_submit_status">
                                                <label class="form-check-label" for="loan_doc_submit_status">
                                                    Loan Document Submission
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('loan_doc_submit_status', @$project_documents->loan_doc_submit_status) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="m-0 fs-12">{{-- Assign: Vikas Malav --}}</span>
                                            <span>{{@$project_dates->loan_doc_submit_date}}</span>
                                        </div>
                                        @error('loan_doc_submit_status')
                                            <p class="text-danger m-0">
                                                {{ $message }}
                                            </p>
                                        @enderror
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
                                            <span class="m-0 fs-12">By: Bank</span>
                                            <span>{{@$project_dates->bank_verification_date}}</span>
                                        </div>
                                        @error('bank_verification_status')
                                            <p class="text-danger m-0">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Loan Disbursement." type="checkbox" value="1" name="loan_disberment_status" @checked(old('loan_disberment_status', @$project_documents->loan_disberment_status) == 1) id="loan_disberment_status">
                                                <label class="form-check-label" for="loan_disberment_status">
                                                    Loan Disbursement
                                                </label>
                                            </div>
                                            <div class="verification-status {{old('loan_disberment_status', @$project_documents->loan_disberment_status) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="m-0 fs-12">By: Bank</span>
                                            <span>{{@$project_dates->loan_disberment_date}}</span>
                                        </div>
                                        @error('loan_disberment_status')
                                            <p class="text-danger m-0">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                
                                </div>

                            </div>
                            <!-- End - Loan Application  -->

                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-between">
                    <a href="{{ route('business.solarmitra.projects.verification',$project_id) }}" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.previous') }}</a>
                    <button type="submit" class="btn btn-primary w-25 w-md-100 d-flex mb-3">{{ __('solarmitra::solarmitra.next') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection