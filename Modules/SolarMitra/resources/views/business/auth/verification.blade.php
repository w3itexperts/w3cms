{{-- Extends layout --}}
@extends('admin.layout.fullwidth')

{{-- Content --}}
@section('content')

<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center align-items-center">

        	<div class="card verification-card m-auto mt-5" id="VerificationRequiredContainer">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <div class="verification-icon mb-3">
                            🔒
                        </div>

                        <h2 class="fw-bold">{{ __('solarmitra::solarmitra.account_verification_required') }}</h2>

                        <p class="text-muted">
                            {{ __('solarmitra::solarmitra.verify_to_continue') }}
                            {{ __('solarmitra::solarmitra.verify_one_method') }}
                        </p>
                        @include('admin.elements.alert_message')
                    </div>

                    <div class="row g-4">

                        <!-- Email Verification -->
                        <div class="col-md-6">
                            <div class="verify-box text-center">
                                <div class="fs-1 mb-3">📧</div>
                                <h5>{{ __('solarmitra::solarmitra.email_verification') }}</h5>
                                <p class="text-muted small">
                                    {{ __('solarmitra::solarmitra.verify_email_description') }}
                                </p>
                                @if ($user->is_email_verified)
                                    <a href="#" class="btn btn-primary w-100 disabled" disabled>
                                        {{ __('solarmitra::solarmitra.email_verified_badge') }} <i class="icon-search-check"></i>
                                    </a>
                                @else
                                    <a href="{{ route('business.solarmitra.auth.verify_email')}}" class="btn btn-primary w-100 mb-2">
                                        {{ __('solarmitra::solarmitra.verify_email') }}
                                    </a>
                                    <a href="{{ route('business.solarmitra.auth.update_contact_form', ['type' => 'email']) }}" class="btn btn-link btn-sm text-muted">
                                        <i class="icon-square-pen me-1"></i> {{ __('solarmitra::solarmitra.change_email') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Mobile Verification -->
                        <div class="col-md-6">
                            <div class="verify-box text-center">
                                <div class="fs-1 mb-3">📱</div>
                                <h5>{{ __('solarmitra::solarmitra.mobile_verification') }}</h5>
                                <p class="text-muted small">
                                    {{ __('solarmitra::solarmitra.verify_mobile_description') }}
                                </p>
                                @if ($user->is_mobile_verified)
                                    <a href="#" class="btn btn-success w-100 disabled" disabled>
                                        {{ __('solarmitra::solarmitra.mobile_verified') }} <i class="icon-search-check"></i>
                                    </a>
                                @else
                                    <a href="{{ route('business.solarmitra.auth.verify_mobile') }}" class="btn btn-success w-100 mb-2">
                                        {{ __('solarmitra::solarmitra.verify_mobile') }}
                                    </a>
                                    <a href="{{ route('business.solarmitra.auth.update_contact_form', ['type' => 'mobile']) }}" class="btn btn-link btn-sm text-muted">
                                        <i class="icon-square-pen me-1"></i> {{ __('solarmitra::solarmitra.change_number') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            {{ __('solarmitra::solarmitra.dashboard_access_after_verification') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('inline-css')
     <style>
        

        .verification-card {
            max-width: 650px;
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .verification-icon {
            width: 80px;
            height: 80px;
            background: #eef5ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 35px;
        }

        .verify-box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            transition: .3s;
            height: 100%;
        }

        .verify-box:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('scripts')
    {{-- <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script> --}}
@endsection