@extends('admin.layout.fullwidth')

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="auth-wrapper">
                <div class="row m-0">

                    {{-- ============================================================ --}}
                    {{-- LEFT PANEL: Register Form --}}
                    {{-- ============================================================ --}}
                    <div class="col-xl-4 col-lg-4 p-0">
                        <div class="login-form-panel">
                            <div class="login-form-inner">

                                {{-- Logo --}}
                                <div class="brand-logo mb-4 text-center">
                                    <img class="brand-title" width="180px" src="{{ asset('modules/solarmitra/images/logo.png') }}">
                                </div>

                                {{-- Heading --}}
                                <h3 class="login-heading text-center">{{ __('solarmitra::solarmitra.sign_up_your_account') }}</h3>
                                <p class="login-subtitle text-center">{{ __('solarmitra::solarmitra.create_account_subtitle') }}</p>

                                {{-- Form --}}
                                <form action="{{ route('business.solarmitra.auth.register') }}" method="post" class="mt-4">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.company_name') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-building input-icon-left"></i>
                                                <input type="text" class="form-control form-control input-has-icon-left @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" placeholder="{{ __('solarmitra::solarmitra.company_name_placeholder') }}">
                                                @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.full_name') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-user input-icon-left"></i>
                                                <input type="text" class="form-control form-control input-has-icon-left @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" placeholder="{{ __('solarmitra::solarmitra.full_name_placeholder') }}">
                                                @error('full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.email') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-envelope input-icon-left"></i>
                                                <input type="email" class="form-control form-control input-has-icon-left @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('solarmitra::solarmitra.email_placeholder') }}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.phone') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-phone input-icon-left"></i>
                                                <input type="number" class="form-control form-control input-has-icon-left @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="{{ __('solarmitra::solarmitra.phone_placeholder') }}">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.password') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-lock input-icon-left"></i>
                                                <input type="password" autocomplete="new-password" name="password" class="form-control form-control input-has-icon-left dz-password @error('password') is-invalid bg-img-none @enderror" placeholder="{{ __('solarmitra::solarmitra.enter_your_password_placeholder') }}">
                                                <span class="show-pass position-absolute  ">
                                                    <span class="show"><i class="fa fa-eye-slash"></i></span>
                                                    <span class="hide"><i class="fa fa-eye"></i></span>
                                                </span>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.confirm_password') }}</label>
                                            <div class="position-relative">
                                                <i class="fas fa-lock input-icon-left"></i>
                                                <input type="password" autocomplete="new-password" name="password_confirmation" class="form-control form-control input-has-icon-left dz-password @error('password_confirmation') bg-img-none is-invalid @enderror" placeholder="{{ __('solarmitra::solarmitra.enter_your_password_placeholder') }}">
                                                <span class="show-pass position-absolute   ">
                                                    <span class="show"><i class="fa fa-eye-slash"></i></span>
                                                    <span class="hide"><i class="fa fa-eye"></i></span>
                                                </span>
                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sign Up Button --}}
                                    <div class="text-center mb-4">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 login-btn fw-light">
                                            <i class="fas fa-user-plus me-2"></i>{{ __('solarmitra::solarmitra.sign_up_btn') }}
                                        </button>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="text-center border-bottom border-grey position-relative my-3">
                                        <span class="small bg-white position-absolute top-50 start-50 translate-middle px-2">{{ __('solarmitra::solarmitra.or_continue_with') }}</span>
                                    </div>

                                    {{-- Login Link --}}
                                    <p class="text-center pt-3 mb-0">{{ __('solarmitra::solarmitra.already_registered') }}
                                        <a class="btn-link text-primary fw-semibold" href="{{ route('business.solarmitra.auth.login') }}">{{ __('solarmitra::solarmitra.sign_in') }}</a>
                                    </p>
                                </form>

                            </div>
                            <div class="login-footer">
                                <span class="text-muted">{{ __('solarmitra::solarmitra.powered_by') }} W3ITEXPERTS</span>
                            </div>
                        </div>
                    </div>

                    {{-- ============================================================ --}}
                    {{-- RIGHT PANEL: Showcase --}}
                    {{-- ============================================================ --}}
                    <div class="col-xl-8 col-lg-8 d-none d-lg-flex p-0">
                        <div class="login-showcase-panel" style="background-image: url('{{ asset('modules/solarmitra/images/dark-background.png') }}');">
                            <h1 class="showcase-heading">{{ __('solarmitra::solarmitra.powering_smarter_solar_businesses') }}</h1>
                            <p class="showcase-subtitle">{{ __('solarmitra::solarmitra.powering_solar_subtitle') }}</p>

                            <div class="dashboard-mockup">
                                <img class="dashboard-main" src="{{ asset('modules/solarmitra/images/login-dashboard-main.png') }}" alt="Dashboard Preview">
                                <img class="floating-card-1" src="{{ asset('modules/solarmitra/images/login-floating-card-1.png') }}" alt="Project Card">
                                <img class="floating-card-2" src="{{ asset('modules/solarmitra/images/login-floating-card-2.png') }}" alt="Financial Snapshot">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
@endsection

@push('inline-css')
<style>
/* ===== Login Page Layout ===== */
.auth-wrapper { min-height: 100vh; }

/* ===== Left Panel: Form ===== */
.login-form-panel {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 30px;
    flex-direction: column;
    background: #ffffff;
}
.login-form-inner {
    width: 100%;
    max-width: 420px;
    margin-top: auto;
}
.login-heading {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 6px;
}
.login-subtitle {
    color: #888;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

/* Input icon */
.input-icon-left {
    position: absolute;
    left: 14px;
    top: 14px;
    color: #aaa;
    z-index: 4;
    font-size: 0.9rem;
}
.input-has-icon-left {
    padding-left: 40px;
    min-height: 2.75rem;
    color: #000 !important;
}

/* Login button */
.login-btn {
    font-weight: 600;
    letter-spacing: 0.5px;
    padding: 12px;
    font-size: 1rem;
    border-radius: 8px;
}

/* Footer */
.login-footer {
    text-align: center;
    color: #999;
    font-size: 0.82rem;
    margin-top: auto;
}

/* ===== Right Panel: Showcase ===== */
.login-showcase-panel {
    background: linear-gradient(160deg, #0b1a30 0%, #0e2242 40%, #112a52 100%);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 3rem 15rem;
    position: relative;
    overflow: hidden;
    width: 100%;
    background-size: cover;
}
.login-showcase-panel::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -20%;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.025);
    pointer-events: none;
}
.login-showcase-panel::after {
    content: '';
    position: absolute;
    bottom: -25%;
    left: -15%;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.02);
    pointer-events: none;
}

/* Showcase text */
.showcase-heading {
    color: #ffffff;
    font-size: 3.1rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}
.showcase-subtitle {
    color: rgb(255 255 255 / 90%);
    font-size: 1.2rem;
    letter-spacing: 0.1px;
    margin-bottom: 40px;
    position: relative;
    z-index: 1;
}

/* Dashboard mockup */
.dashboard-mockup {
    position: relative;
    width: 100%;
    z-index: 1;
}
.dashboard-mockup .dashboard-main {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.45);
    display: block;
}
.dashboard-mockup .floating-card-1 {
    position: absolute;
    top: 60px;
    right: -150px;
    border-radius: 10px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
}
.dashboard-mockup .floating-card-2 {
    position: absolute;
    bottom: -60px;
    left: -125px;
    border-radius: 10px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
}

/* ===== Responsive ===== */
@media (max-width: 991.98px) {
    .login-form-panel {
        min-height: 100vh;
        padding: 30px 20px;
    }
    .showcase-heading { font-size: 1.8rem; }
}
.show-pass {
    top: 14px;
    right: 14px;
}
.bg-img-none {
  background-image: none !important;
}
</style>
@endpush
