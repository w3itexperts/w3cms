@extends('admin.layout.fullwidth')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="auth-card col-12">
                <div class="row g-0">

                    <!-- Left: illustration -->
                    <div class="col-md-6 auth-illustration">
                        <div class="text-center mb-5">
                            
                            @if (!empty(config('Admin.logo_dark')) && \Storage::exists('public/configuration-images/'.config('Admin.logo_dark')))
                                <img width="150px" src="{{ asset('storage/configuration-images/'.config('Admin.logo_dark')) }}">
                            @else
                                <img width="150px" src="{{ asset('images/logo-full-black.png') }}">
                            @endif
                            <!-- Login illustration -->
                        </div>
                        
                        <img src="{{ theme_asset('images/log.svg') }}" class="education-img w-100">


                        <p class="auth-caption">
                            <strong>{{ __('common.welcome_back_to_your_dashboard') }}</strong><br>
                            {{ __('common.sign_in_to_continue_managing_your_content_team_and_live_sessions') }}
                        </p>
                    </div>

                    <!-- Right: form -->
                    <div class="col-md-6 auth-form-side">

                        <h1 class="auth-title">{{ __('common.sign_in_text') }}</h1>
                        <p class="auth-sub">
                            {{ __('common.login_welcome_text_1') }}
                        </p>

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label"><strong>{{ __('common.email') }}</strong></label>
                                <div class="input-group-custom">
                                    <input
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="you@example.com"
                                        required
                                        autofocus
                                    >
                                    <span class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                        </svg>
                                    </span>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-1">
                                <label for="password" class="form-label">{{ __('common.password') }}</label>
                                <div class="input-group-custom">
                                    <input
                                        type="password"
                                        class="form-control has-trailing-icon @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="{{ __('common.enter_password') }}"
                                        required
                                    >
                                    <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                    </svg></span>
                                    <button type="button" class="toggle-visibility" data-target="password" aria-label="Show password">{{ __('common.show') }}</button>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember + Forgot -->
                            <div class="form-row-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" >
                                        {{ __('common.remember_preference') }}
                                    </label>
                                </div>
                                @if (Route::has('admin.password.request'))
                                <a href="{{ route('admin.password.request') }}" class="link-forgot">{{__('common.forgot_password')}}?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">
                                {{ __('common.sign_in') }}
                                <span aria-hidden="true">→</span>
                            </button>
                        </form>

                        <div class="divider-note">{{ __('common.or_continue_with') }}</div>

                        <div class="social-row">
                            <a href="#" class="btn-social">
                                <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#FFC107" d="M43.6 20.5h-1.9V20.4H24v7.2h11.3c-1.6 4.6-6 7.9-11.3 7.9-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.8 1.1 7.9 3l5.1-5.1C33.6 6.1 29 4.4 24 4.4 12.9 4.4 4 13.3 4 24.4s8.9 20 20 20c11.5 0 19.1-8.1 19.1-19.5 0-1.3-.1-2.3-.5-3.4z"/>
                                    <path fill="#FF3D00" d="M6.3 14.7l5.9 4.3C13.7 15.5 18.5 12.4 24 12.4c3 0 5.8 1.1 7.9 3l5.1-5.1C33.6 6.1 29 4.4 24 4.4c-7.5 0-14 4.2-17.7 10.3z"/>
                                    <path fill="#4CAF50" d="M24 44.4c4.9 0 9.4-1.9 12.8-4.9l-5.9-5c-2 1.5-4.6 2.4-6.9 2.4-5.3 0-9.7-3.3-11.3-7.9l-6 4.6C9.9 39.9 16.4 44.4 24 44.4z"/>
                                    <path fill="#1976D2" d="M43.6 20.5h-1.9V20.4H24v7.2h11.3c-.8 2.2-2.2 4.1-4.1 5.4l5.9 5c-.4.4 6.4-4.7 6.4-13.6 0-1.3-.1-2.3-.5-3.4z"/>
                                </svg>
                                Google
                            </a>
                            <a href="#" class="btn-social">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="#1B7AE0" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 12.07C22 6.5 17.52 2 12 2S2 6.5 2 12.07c0 5 3.66 9.13 8.44 9.93v-7.03H7.9v-2.9h2.54V9.85c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33V22c4.78-.8 8.44-4.93 8.44-9.93z"/>
                                </svg>
                                Facebook
                            </a>
                        </div>

                        @if (Route::has('register'))
                        <p class="signup-link mb-0">
                            {{ __("common.do_not_have_account") }} <a href="{{ url('/admin/register') }}">{{ __('common.sign_up') }}</a>
                        </p>
                        @endif
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
        --accent-red:    #E0563B;
    }

    

    .auth-card {
        background: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 20px 60px rgba(43, 52, 69, 0.08);
        overflow: hidden;
        {{-- max-width: 1020px; --}}
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
        .pulse-dot { animation: pulse 1.8s ease-in-out infinite; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    /* Right form panel */
    .auth-form-side {
        padding: 3.5rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
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
    .input-group-custom .toggle-visibility {
        position: absolute;
        right: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 0.85rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem 0.35rem;
        line-height: 1;
        transition: color 0.15s ease;
    }
    .input-group-custom .toggle-visibility:hover { color: var(--primary); }
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
    .form-control.has-trailing-icon {
        padding-right: 2.6rem;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(27, 122, 224, 0.1);
    }
    .form-control.is-invalid {
        border-color: var(--accent-red);
    }
    .form-control.is-invalid + .input-icon {
        color: var(--accent-red);
    }
    .invalid-feedback {
        font-size: 0.82rem;
    }

    .form-row-between {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.85rem;
    }

    .form-check-input {
        border: 1.5px solid var(--border);
        width: 1.05rem;
        height: 1.05rem;
        margin-top: 0.15rem;
    }
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(27, 122, 224, 0.12);
        border-color: var(--primary);
    }
    .form-check-label {
        font-size: 0.85rem;
        color: var(--muted);
    }

    .link-forgot {
        font-size: 0.85rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    .link-forgot:hover { text-decoration: underline; }

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
    .btn-primary span { transition: transform 0.2s ease; }
    .btn-primary:hover span { transform: translateX(3px); }

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

    .social-row {
        display: flex;
        gap: 0.75rem;
    }
    .btn-social {
        flex: 1;
        border: 1.5px solid var(--border);
        background: #fff;
        border-radius: 0.65rem;
        padding: 0.65rem 1rem;
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: border-color 0.15s ease, background 0.15s ease, transform 0.1s ease;
        text-decoration: none;
    }
    .btn-social:hover {
        border-color: var(--primary);
        background: var(--primary-soft);
        color: var(--text);
    }
    .btn-social:active { transform: translateY(1px); }

    .signup-link {
        text-align: center;
        font-size: 0.88rem;
        color: var(--muted);
        margin-top: 1.5rem;
    }
    .signup-link a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }
    .signup-link a:hover { text-decoration: underline; }

    @media (max-width: 767.98px) {
        .auth-illustration { display: none; }
        .auth-form-side { padding: 2.75rem 1.75rem; }
    }
</style>
@endpush

@push('inline-scripts')
    <script>
    document.querySelectorAll('.toggle-visibility').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-target'));
            if (target.type === 'password') {
                target.type = 'text';
                btn.textContent = '{{ __('common.hide') }}';
            } else {
                target.type = 'password';
                btn.textContent = '{{ __('common.show') }}';
            }
        });
    });
</script>
@endpush