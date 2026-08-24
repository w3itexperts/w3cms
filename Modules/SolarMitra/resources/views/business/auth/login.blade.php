@extends('admin.layout.fullwidth')

@section('content')
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="auth-wrapper">
                <div class="row m-0">

                    {{-- ============================================================ --}}
                    {{-- LEFT PANEL: Login Form --}}
                    {{-- ============================================================ --}}
                    <div class="col-xl-4 col-lg-4 p-0">
                        <div class="login-form-panel">
                            <div class="login-form-inner">

                                {{-- Logo --}}
                                <div class="brand-logo mb-4 text-center">
                                    <img class="brand-title" width="180px" src="{{ asset('modules/solarmitra/images/logo.png') }}">
                                </div>

                                {{-- Heading --}}
                                <h3 class="login-heading text-center">{{ __('solarmitra::solarmitra.welcome_back_title') }}!</h3>
                                <p class="login-subtitle text-center">{{ __('solarmitra::solarmitra.login_trial_subtitle') }}</p>

                                {{-- Form --}}
                                <form action="{{ route('business.solarmitra.auth.login') }}" method="post" id="LoginForm" class="mt-4">
                                    @csrf

                                    {{-- Email / Mobile --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-medium" for="login">{{ __('solarmitra::solarmitra.email_address') }}</label>
                                        <div class="position-relative">
                                            <i class="fas fa-envelope input-icon-left"></i>
                                            <input type="text" name="login" id="login" class="form-control form-control input-has-icon-left @error('login') is-invalid @enderror" value="{{ old('login') }}" placeholder="{{ __('solarmitra::solarmitra.email') }} / {{ __('solarmitra::solarmitra.phone') }}">
                                            @error('login')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- OTP Section (hidden by default) --}}
                                    <div id="OtpSection" style="display:none;">
                                        <div class="mb-3">
                                            <span id="OtpLinkGroup">
                                                <a href="#" class="text-primary btn-link" id="SendOtpBtn">{{ __('solarmitra::solarmitra.get_otp_to_log_in') }}</a>
                                                <small class="text-muted"> (or) {{ __('solarmitra::solarmitra.or_enter_password_below') }}</small>
                                            </span>
                                        </div>

                                        {{-- OTP Input (hidden until OTP sent) --}}
                                        <div id="OtpInputGroup" style="display:none;">
                                            <div class="mb-3">
                                                <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.enter_otp') }}</label>
                                                <input type="text" name="otp" id="otp_input" class="form-control form-control" placeholder="{{ __('solarmitra::solarmitra.six_digit_otp_placeholder') }}" maxlength="6" inputmode="numeric">
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <small class="text-muted" id="OtpTimer"></small>
                                                    <button type="button" class="btn btn-sm btn-link p-0" id="ResendOtpBtn" style="display:none;">{{ __('solarmitra::solarmitra.resend_otp') }}</button>
                                                </div>
                                                <p class="text-danger m-0" id="otp_error"></p>
                                            </div>
                                            <div class="text-center mb-3">
                                                <button type="button" class="btn btn-success btn-lg w-100" id="LoginWithOtpBtn">
                                                    <i class="fas fa-sign-in-alt me-1"></i> {{ __('solarmitra::solarmitra.login_with_otp') }}
                                                </button>
                                            </div>
                                            <hr/>
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="mb-3" id="PasswordField">
                                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.password') }}</label>
                                        <div class="position-relative">
                                            <i class="fas fa-lock input-icon-left"></i>
                                            <input type="password" name="password" id="login_password" class="form-control form-control input-has-icon-left dz-password @error('password') is-invalid @enderror" placeholder="{{ __('solarmitra::solarmitra.enter_password') }}">
                                            <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle @error('password') d-none @enderror">
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

                                    {{-- Remember + Forgot --}}
                                    <div class="d-flex gap-2 flex-wrap justify-content-between align-items-center mb-4">
                                        <div class="form-check custom-checkbox mb-0">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">{{ __('solarmitra::solarmitra.keep_me_signed_in') }}</label>
                                        </div>
                                        <a href="#" class="text-primary fw-medium text-decoration-none small">{{ __('solarmitra::solarmitra.forgot_password') }}</a>
                                    </div>

                                    {{-- Login Button --}}
                                    <div class="text-center mb-4" id="PasswordLoginBtn">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 login-btn fw-light">
                                            <i class="fas fa-lock me-2"></i>{{ __('solarmitra::solarmitra.login_btn') }}
                                        </button>
                                    </div>

                                    {{-- Sign Up Link --}}
                                    <p class="text-center mb-0">{{ __('solarmitra::solarmitra.dont_have_business_account_yet') }}
                                        <a class="btn-link text-primary fw-semibold" href="{{ route('business.solarmitra.auth.register') }}">{{ __('solarmitra::solarmitra.try_for_free') }}</a>
                                    </p>

                                    <div class="text-center border-bottom border-grey position-relative my-4">
                                        <span class="small bg-white position-absolute top-50 start-50 fs-16 translate-middle px-2">Or</span>
                                    </div>

                                    <button type="button" class="demoUserBtn btn btn-outline-primary w-100 fw-light" data-email="chandan.w3itexperts@gmail.com" data-password="12345678">Demo User <i class="icon-user"></i></button>
                                    <small class="text-grey d-block text-center mt-2">See how SolarMitra works with a demo account</small>
                                </form>

                                {{-- Footer --}}

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
<script>
$(document).ready(function() {
    var otpTimer = null;

    $(document).on('keyup','#login', function() {
        var val = $(this).val().trim();
        if (val.length >= 5) {
            $.ajax({
                url: '{{ route("business.solarmitra.auth.check_user_exists") }}',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', login: val },
                success: function(response) {
                    if (response.success) {
                        $('#MaskedValue').text(response.masked_value);
                        $('#OtpSection').show();
                        $('#OtpLinkGroup').show();
                        $('#SendOtpBtn').show().prop('disabled', false).text('Get OTP to log in');
                        $('#OtpInputGroup').hide();
                    } else {
                        $('#OtpSection').hide();
                        $('#OtpInputGroup').hide();
                    }
                },
                error: function() {
                    $('#OtpSection').hide();
                    $('#OtpInputGroup').hide();
                }
            });
        } else {
            $('#OtpSection').hide();
            $('#OtpInputGroup').hide();
        }
    });

    $('#SendOtpBtn').on('click', function() {
        var btn = $(this);
        var login = $('#login').val().trim();
        btn.prop('disabled', true).text('Sending...');
        $.ajax({
            url: '{{ route("business.solarmitra.auth.send_login_otp") }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', login: login },
            success: function(response) {
                if (response.success) {
                    $('#OtpInputGroup').show();
                    $('#otp_error').text('');
                    $('#OtpLinkGroup').hide();
                    startOtpTimer(response.expires_in);
                    $('#otp_input').focus();
                } else {
                    alert(response.message);
                    $('#OtpLinkGroup').show();
                    btn.prop('disabled', false).text('Get OTP to log in');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.message || 'Failed to send OTP.';
                alert(msg);
                $('#OtpLinkGroup').show();
                btn.prop('disabled', false).text('Get OTP to log in');
            }
        });
    });

    $('#LoginWithOtpBtn').on('click', function() {
        var btn = $(this);
        var login = $('#login').val().trim();
        var otp = $('#otp_input').val().trim();
        $('#otp_error').text('');
        if (otp.length !== 6) {
            $('#otp_error').text('Please enter a valid 6-digit OTP.');
            return;
        }
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Verifying...');
        $.ajax({
            url: '{{ route("business.solarmitra.auth.login_with_otp") }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', login: login, otp: otp },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    $('#otp_error').text(response.message);
                    btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-1"></i> Login with OTP');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON?.message || 'Something went wrong.';
                $('#otp_error').text(msg);
                btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-1"></i> Login with OTP');
            }
        });
    });

    $('#ResendOtpBtn').on('click', function() {
        $('#OtpLinkGroup').show();
        $('#SendOtpBtn').show().prop('disabled', false).text('Get OTP to log in');
        $('#OtpInputGroup').hide();
        clearInterval(otpTimer);
    });

    function startOtpTimer(seconds) {
        clearInterval(otpTimer);
        var remaining = seconds;
        $('#ResendOtpBtn').hide();
        $('#OtpTimer').show();
        otpTimer = setInterval(function() {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            $('#OtpTimer').text('Resend OTP in ' + m + ':' + (s < 10 ? '0' : '') + s);
            remaining--;
            if (remaining < 0) {
                clearInterval(otpTimer);
                $('#OtpTimer').hide();
                $('#ResendOtpBtn').show();
            }
        }, 1000);
    }

    document.querySelectorAll('.demoUserBtn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('login').value = btn.dataset.email;
            document.getElementById('login_password').value = btn.dataset.password;
        });
    });
});
</script>
@endsection

@push('inline-css')
<style>
    /* ===== Login Page Layout ===== */
    .auth-wrapper { min-height: 100vh; }
    .auth-wrapper .row { min-height: 100vh; }

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
        /* height: 100%; */
        /* display: flex; */
        /* flex-direction: column; */
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
        top: 15px;
        {{-- transform: translateY(-50%); --}}
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
        /* padding-top: 20px;*/
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
        {{-- max-width: 500px; --}}
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
        {{-- max-width: 520px; --}}
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
        {{-- width: 180px; --}}
        right: -150px;
        border-radius: 10px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
    }
    .dashboard-mockup .floating-card-2 {
        position: absolute;
        bottom: -60px;
        left: -125px;
        /* width: 190px; */
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
</style>
@endpush
