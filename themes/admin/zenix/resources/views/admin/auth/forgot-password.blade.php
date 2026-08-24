@extends('admin.layout.fullwidth')
@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="auth-card">
                <div class="row g-0">
                    <!-- Left: illustration -->
                    <div class="col-md-6 auth-illustration">
                        @if (!empty(config('Admin.logo_dark')) && \Storage::exists('public/configuration-images/'.config('Admin.logo_dark')))
                            <img width="150px" src="{{ asset('storage/configuration-images/'.config('Admin.logo_dark')) }}">
                        @else
                            <img width="150px" src="{{ asset('images/logo-full-black.png') }}">
                        @endif
                        <!-- Forgot password illustration -->
                        <svg class="overflow-visible" width="400" height="340" viewBox="0 0 400 340" xmlns="http://www.w3.org/2000/svg">
                            <!-- soft background blobs -->
                            <ellipse cx="200" cy="295" rx="160" ry="16" fill="#E3EAF8"/>
                            <circle class="float-1" cx="335" cy="55" r="6" fill="#CBD8F2"/>
                            <circle class="float-2" cx="45" cy="80" r="9" fill="#CBD8F2"/>
                            <circle class="float-3" cx="355" cy="200" r="5" fill="#FFD8A1"/>
                            <circle class="float-1" cx="35" cy="230" r="7" fill="#BDEEDD"/>
                            <!-- big rounded screen -->
                            <rect x="70" y="40" width="260" height="190" rx="16" fill="#FFFFFF" stroke="#E5E9F2" stroke-width="2"/>
                            <rect x="70" y="40" width="260" height="34" rx="16" fill="#1B7AE0"/>
                            <rect x="70" y="58" width="260" height="16" fill="#1B7AE0"/>
                            <circle cx="90" cy="57" r="4" fill="#FFD8A1"/>
                            <circle cx="104" cy="57" r="4" fill="#BDEEDD"/>
                            <circle cx="118" cy="57" r="4" fill="#FFFFFF" fill-opacity="0.6"/>
                            <!-- lock illustration inside screen -->
                            <g transform="translate(150,95)">
                                <rect x="0" y="35" width="100" height="70" rx="10" fill="#EAF3FE"/>
                                <path d="M20 35 V22 a30 30 0 0 1 60 0 V35" fill="none" stroke="#1B7AE0" stroke-width="8" stroke-linecap="round"/>
                                <circle cx="50" cy="68" r="9" fill="#1B7AE0"/>
                                <rect x="46" y="74" width="8" height="16" rx="3" fill="#1B7AE0"/>
                            </g>
                            <!-- person -->
                            <g transform="translate(245,150)">
                                <ellipse cx="35" cy="135" rx="46" ry="9" fill="#E3EAF8"/>
                                <rect x="8" y="62" width="54" height="68" rx="12" fill="#222B3C"/>
                                <rect x="8" y="62" width="54" height="14" rx="7" fill="#1B7AE0"/>
                                <circle cx="35" cy="34" r="24" fill="#F4B183"/>
                                <path d="M11 32 a24 24 0 0 1 48 0 v-3 a24 24 0 0 0 -48 0 Z" fill="#3A2E27"/>
                                <rect x="-8" y="68" width="20" height="50" rx="9" fill="#F4B183"/>
                                <rect x="50" y="68" width="20" height="50" rx="9" fill="#F4B183"/>
                                <rect x="-12" y="112" width="32" height="15" rx="7" fill="#FFB648"/>
                                <rect x="46" y="112" width="32" height="15" rx="7" fill="#2ECC8F"/>
                            </g>
                            <!-- key floating -->
                            <g transform="translate(45,150) rotate(-18)">
                                <g class="float-2" >
                                    <circle cx="14" cy="14" r="14" fill="none" stroke="#FFB648" stroke-width="6"/>
                                    <rect x="24" y="10" width="36" height="8" fill="#FFB648"/>
                                    <rect x="52" y="18" width="8" height="11" fill="#FFB648"/>
                                    <rect x="40" y="18" width="8" height="11" fill="#FFB648"/>
                                </g>
                            </g>
                            <!-- magnifier checking shield -->
                            <g  transform="translate(75,205)">
                                <g class="float-3" >
                                    <path d="M20 0 L40 7 V27 C40 41 30 51 20 56 C10 51 0 41 0 27 V7 Z" fill="#2ECC8F"/>
                                    <path d="M12 26 L18 32 L30 18" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </g>
                        </svg>
                        <p class="auth-caption">
                            <strong>{{ __('common.account_security_made_simple') }}</strong><br>
                            {{ __('common.forgot_password_description_3') }}
                        </p>
                    </div>
                    <!-- Right: form -->
                    <div class="col-md-6 auth-form-side">

                        @if (empty(env('MAIL_FROM_ADDRESS'))) 
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                              <strong>Warning!</strong> You have to Configure SMTP first.
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <h1 class="auth-title">{{ __('common.forgot_your_password') }}</h1>
                        <p class="auth-sub">
                            {{ __('common.forgot_password_description_1') }}
                            {{ __('common.forgot_password_description_2') }}
                        </p>
                        <!-- Example success status (toggle as needed) -->
                        
                        @if (session('status'))
                        <div class="status-msg">
                            <i class="bi bi-check-circle-fill"></i>
                            <span> {{ session('status') }}</span>
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.password.email') }}">
                            @csrf
                            <div class="mb-1">
                                <label for="email" class="form-label">{{ __('common.email') }} {{ __('common.address') }}</label>
                                <div class="input-group-custom">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('passwords.enter_email') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                        </svg></span>
                                </div>
                                <!-- Example validation error (toggle as needed) -->

                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-4" {{ empty(env('MAIL_FROM_ADDRESS')) ? 'disabled' : '' }}>
                            {{ __('common.send_reset_link') }}
                            <span aria-hidden="true">→</span>
                            </button>
                        </form>
                        <div class="divider-note">{{ __('common.or') }}</div>
                        <p class="text-center">{{ __('common.already_have_account') }}? <a class="text-primary" href="{{ url('/admin/login') }}">{{ __('common.sign_in') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('inline-css')
    
<style>
    :root {
        --bg:        #EEF1F8;
        --text:      #2B3445;
        --muted:     #8A93A6;
        --border:    #E5E9F2;
        --primary:   #1B7AE0;
        --primary-d: #1768C4;
        --primary-soft: #EAF3FE;
        --accent-orange: #FFB648;
        --accent-green:  #2ECC8F;
    }

    .auth-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 20px 60px rgba(43, 52, 69, 0.08);
        overflow: hidden;
        max-width: 1020px;
        width: 100%;
        opacity: 0;
        transform: translateY(14px);
        animation: rise 0.55s ease forwards;
    }

    @keyframes rise {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Left illustration panel */
    .auth-illustration {
        background: linear-gradient(180deg, #FAFCFF 0%, #F2F6FE 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 2.5rem;
        text-align: center;
        position: relative;
    }

    .auth-logo {
        position: absolute;
        top: 2rem;
        left: 2.5rem;
        font-weight: 700;
        font-size: 1.35rem;
        letter-spacing: 0.01em;
    }
    .auth-logo .w3 { color: var(--text); }
    .auth-logo .cms { color: var(--primary); }

    .auth-illustration svg {
        max-width: 100%;
        height: auto;
        margin-top: 1.5rem;
    }

    .auth-caption {
        margin-top: 1.5rem;
        font-size: 0.92rem;
        color: var(--muted);
        max-width: 22rem;
        line-height: 1.6;
    }
    .auth-caption strong { color: var(--text); }

    /* floating shapes animation */
    @media (prefers-reduced-motion: no-preference) {
        .float-1 { animation: float 4.5s ease-in-out infinite; }
        .float-2 { animation: float 5.5s ease-in-out infinite 0.6s; }
        .float-3 { animation: float 4s ease-in-out infinite 0.3s; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    /* Right form panel */
    .auth-form-side {
        padding: 3.5rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-icon-badge {
        width: 3rem;
        height: 3rem;
        border-radius: 0.85rem;
        background: var(--primary-soft);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        font-size: 1.3rem;
    }

    .auth-title {
        font-weight: 600;
        font-size: 1.65rem;
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .auth-sub {
        color: var(--muted);
        font-size: 0.93rem;
        line-height: 1.65;
        margin-bottom: 1.85rem;
    }

    .form-label {
        font-weight: 500;
        font-size: 0.88rem;
        color: var(--text);
        margin-bottom: 0.45rem;
    }

    .input-group-custom {
        position: relative;
    }
    .input-group-custom .input-icon {
        position: absolute;
        left: 0.95rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.95rem;
        pointer-events: none;
        transition: color 0.15s ease;
    }
    .input-group-custom input:focus + .input-icon,
    .input-group-custom input:not(:placeholder-shown) + .input-icon {
        color: var(--primary);
    }

    .form-control {
        border: 1.5px solid var(--border);
        border-radius: 0.65rem;
        padding: 0.78rem 1rem 0.78rem 2.7rem;
        font-size: 0.93rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(27, 122, 224, 0.1);
    }
    .form-control.is-invalid {
        border-color: #E0563B;
    }
    .form-control.is-invalid + .input-icon {
        color: #E0563B;
    }
    .invalid-feedback {
        font-size: 0.82rem;
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.8rem 1rem;
        border-radius: 0.65rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.15s ease, transform 0.1s ease, box-shadow 0.15s ease;
        box-shadow: 0 8px 20px rgba(27, 122, 224, 0.25);
    }
    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--primary-d);
        border-color: var(--primary-d);
        box-shadow: 0 10px 24px rgba(27, 122, 224, 0.32);
    }
    .btn-primary:active { transform: translateY(1px); }
    .btn-primary i { transition: transform 0.2s ease; }
    .btn-primary:hover i { transform: translateX(3px); }

    .back-link {
        text-align: center;
        font-size: 0.88rem;
        color: var(--muted);
        {{-- margin-top: 1.5rem; --}}
    }
    .back-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .back-link a:hover { text-decoration: underline; }

    .status-msg {
        background: #EAFBF3;
        border: 1px solid #BFEAD8;
        color: #1F9D72;
        font-size: 0.88rem;
        border-radius: 0.65rem;
        padding: 0.8rem 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
    }
    .status-msg i { margin-top: 0.15rem; }

    .divider-note {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin: 1.6rem 0;
        font-size: 0.78rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .divider-note::before,
    .divider-note::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .helper-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--primary-soft);
        color: var(--primary-d);
        font-size: 0.78rem;
        font-weight: 500;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        margin-bottom: 1.25rem;
    }

    @media (max-width: 767.98px) {
        .auth-illustration { display: none; }
        .auth-form-side { padding: 2.75rem 1.75rem; }
    }
</style>
@endpush