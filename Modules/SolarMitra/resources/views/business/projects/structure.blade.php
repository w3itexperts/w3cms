{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@include('solarmitra::business.components.project_process_nav')
<div class="container-fluid">
    <form action="{{ route('business.solarmitra.projects.structure',$project_id) }}" method="Post">
        @csrf
        <div class="row">

            <div class="col-xxl-5 col-xl-6 col-lg-7 col-lg-6 mx-auto align-self-center">
                <div class="card shadow-sm d-flex flex-column">
                    <div class="card-body">
                        <div class="row">

                            <!-- Start - Subsidy Registration -->
                            <div class="col-12">

                                <div class="text-start border-bottom border-grey position-relative mt-2 mb-4">
                                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ __('solarmitra::solarmitra.work_done') }}</h4>
                                </div>

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
                                        @error('structure_work_status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
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
                                            <span class="m-0 fs-12">{{-- Work By: Vikas Malav --}}</span>
                                            <span>{{@$project_dates->panel_work_date}}</span>
                                        </div>
                                        @error('panel_work_status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center verification-item">
                                            <div class="form-check verification-checkbox">
                                                <input class="form-check-input confirmCheckbox" data-alert_text="Are you sure For Cabling Work." type="checkbox" value="1" name="cabling_work_status" id="cabling_work_status" @checked(old('cabling_work_status', @$project_documents->cabling_work_status) == 1)>
                                                <label class="form-check-label" for="cabling_work_status">
                                                    Cabling Work
                                                </label>
                                            </div>
                                            
                                            <div class="verification-status {{old('cabling_work_status', @$project_documents->cabling_work_status) == 1 ? "complete" : 'pending'}}">
                                                <p class="m-0 text-success fw-semibold complete">{{ __('solarmitra::solarmitra.success') }}</p>
                                                <p class="m-0 text-warning fw-semibold pending">{{ __('solarmitra::solarmitra.pending') }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="m-0 fs-12">{{-- Work By: Vikas Malav --}}</span>
                                            <span>{{@$project_dates->cabling_work_date}}</span>
                                        </div>
                                        @error('cabling_work_status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
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
                                            <span class="m-0 fs-12">{{-- Work By: Vikas Malav --}}</span>
                                            <span>{{@$project_dates->civil_work_date}}</span>
                                        </div>
                                        @error('civil_work_status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
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