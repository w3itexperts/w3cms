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

                        <!-- Reset password illustration -->
                        <svg class="overflow-visible" width="400" height="340" viewBox="0 0 400 340" xmlns="http://www.w3.org/2000/svg">
                            <!-- soft background blobs -->
                            <ellipse cx="200" cy="295" rx="160" ry="16" fill="#E3EAF8"/>
                            <circle class="float-1" cx="335" cy="55" r="6" fill="#CBD8F2"/>
                            <circle class="float-2" cx="45" cy="80" r="9" fill="#CBD8F2"/>
                            <circle class="float-3" cx="355" cy="200" r="5" fill="#FFD8A1"/>
                            <circle class="float-1" cx="35" cy="230" r="7" fill="#BDEEDD"/>

                            <!-- big rounded screen -->
                            <rect x="70" y="40" width="260" height="200" rx="16" fill="#FFFFFF" stroke="#E5E9F2" stroke-width="2"/>
                            <rect x="70" y="40" width="260" height="34" rx="16" fill="#1B7AE0"/>
                            <rect x="70" y="58" width="260" height="16" fill="#1B7AE0"/>
                            <circle cx="90" cy="57" r="4" fill="#FFD8A1"/>
                            <circle cx="104" cy="57" r="4" fill="#BDEEDD"/>
                            <circle cx="118" cy="57" r="4" fill="#FFFFFF" fill-opacity="0.6"/>

                            <!-- form fields inside screen -->
                            <g transform="translate(100,95)">
                                <rect x="0" y="0" width="200" height="14" rx="4" fill="#E3EAF8"/>
                                <rect x="0" y="34" width="200" height="34" rx="8" fill="#F5F8FE" stroke="#E5E9F2" stroke-width="1.5"/>
                                <circle cx="20" cy="51" r="5" fill="#1B7AE0" fill-opacity="0.5"/>
                                <rect x="34" y="46" width="100" height="10" rx="3" fill="#D7E3FA"/>
                                <rect x="170" y="44" width="14" height="14" rx="3" fill="#CBD8F2"/>

                                <rect x="0" y="84" width="200" height="34" rx="8" fill="#F5F8FE" stroke="#E5E9F2" stroke-width="1.5"/>
                                <circle cx="20" cy="101" r="5" fill="#2ECC8F" fill-opacity="0.5"/>
                                <rect x="34" y="96" width="100" height="10" rx="3" fill="#D7E3FA"/>
                                <rect x="170" y="94" width="14" height="14" rx="3" fill="#CBD8F2"/>

                                <rect x="0" y="134" width="200" height="36" rx="8" fill="#1B7AE0"/>
                                <rect x="80" y="148" width="40" height="8" rx="4" fill="#FFFFFF" fill-opacity="0.85"/>
                            </g>

                            <!-- shield with check -->
                            <g transform="translate(280,150)">
                                <path d="M30 0 L60 11 V40 C60 62 46 76 30 84 C14 76 0 62 0 40 V11 Z" fill="#2ECC8F"/>
                                <path d="M16 38 L26 48 L46 26" fill="none" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>

                            <!-- key floating -->
                            <g transform="translate(45,160) rotate(-18)">
                                <g class="float-2">
                                    <circle cx="14" cy="14" r="14" fill="none" stroke="#FFB648" stroke-width="6"/>
                                    <rect x="24" y="10" width="36" height="8" fill="#FFB648"/>
                                    <rect x="52" y="18" width="8" height="11" fill="#FFB648"/>
                                    <rect x="40" y="18" width="8" height="11" fill="#FFB648"/>
                                </g>
                            </g>

                            <!-- person -->
                            <g transform="translate(50,160)">
                                <ellipse cx="35" cy="125" rx="46" ry="9" fill="#E3EAF8"/>
                                <rect x="8" y="52" width="54" height="68" rx="12" fill="#222B3C"/>
                                <rect x="8" y="52" width="54" height="14" rx="7" fill="#FFB648"/>
                                <circle cx="35" cy="24" r="24" fill="#F4B183"/>
                                <path d="M11 22 a24 24 0 0 1 48 0 v-3 a24 24 0 0 0 -48 0 Z" fill="#3A2E27"/>
                                <rect x="-8" y="58" width="20" height="50" rx="9" fill="#F4B183"/>
                                <rect x="50" y="58" width="20" height="50" rx="9" fill="#F4B183"/>
                                <rect x="-12" y="102" width="32" height="15" rx="7" fill="#1B7AE0"/>
                                <rect x="46" y="102" width="32" height="15" rx="7" fill="#2ECC8F"/>
                            </g>
                        </svg>

                        <p class="auth-caption">
                            <strong>Choose a strong new password.</strong><br>
                            A good password keeps your account safe — use a mix of letters, numbers and symbols.
                        </p>
                    </div>

                    <!-- Right: form -->
                    <div class="col-md-6 auth-form-side">


                        <h1 class="auth-title">Set a new password</h1>
                        <p class="auth-sub">
                            Your new password must be different from previously used passwords.
                        </p>

                        <form method="POST" action="{{ route('admin.password.update') }}">
                            @csrf   
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email (read-only, carried from reset link) -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-Mail Address</label>
                                <div class="input-group-custom">
                                    <input
                                        id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $request->input('email') ?? old('email') }}" required autocomplete="email" autofocus
                                        readonly
                                        
                                    >
                                    <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                        </svg></span>
                                </div>
                                @error('email')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New password -->
                            <div class="mb-1">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group-custom">
                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Enter new password"
                                        required
                                        autofocus
                                    >
                                    <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                    </svg></span>
                                    <button type="button" class="toggle-visibility" data-target="password" aria-label="Show password">Show</button>
                                </div>
                                <!-- Example validation error (toggle as needed) -->
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <!-- Strength meter -->
                                <div class="strength-meter" id="strengthMeter">
                                    <span></span><span></span><span></span><span></span>
                                </div>
                                <p class="strength-label" id="strengthLabel">Password strength</p>
                            </div>

                            <!-- Requirements checklist -->
                            <ul class="req-list mb-3" id="reqList">
                                <li data-req="length"><span class="dot"></span> At least 8 characters</li>
                                <li data-req="uppercase"><span class="dot"></span> One uppercase letter</li>
                                <li data-req="number"><span class="dot"></span> One number</li>
                                <li data-req="special"><span class="dot"></span> One special character</li>
                            </ul>

                            <!-- Confirm password -->
                            <div class="mb-1">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group-custom">
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Re-enter new password"
                                        required
                                    >
                                    <span class="input-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4M4.5 7A1.5 1.5 0 0 0 3 8.5v5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 11.5 7zM8 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3"/>
                                    </svg></span>
                                    <button type="button" class="toggle-visibility" data-target="password_confirmation" aria-label="Show password">Show</button>
                                </div>
                                <!-- Example mismatch error (toggle as needed) -->
                                @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <p class="match-feedback" id="matchFeedback"></p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">
                                Reset Password
                                <span aria-hidden="true">→</span>
                            </button>
                        </form>

                        <p class="back-link mb-0">
                            <a href="{{ url('/admin/login') }}"><span aria-hidden="true">←</span> Back to Sign In</a>
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
    .input-group-custom .toggle-visibility {
        position: absolute;
        right: 1.6rem;
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
        padding: 0.78rem 2.6rem 0.78rem 2.7rem;
        font-size: 0.93rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
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

    /* Password strength meter */
    .strength-meter {
        display: flex;
        gap: 0.35rem;
        margin-top: 0.6rem;
    }
    .strength-meter span {
        height: 4px;
        flex: 1;
        border-radius: 2px;
        background: var(--border);
    }
    .strength-meter.weak span:nth-child(1) { background: var(--accent-red); }
    .strength-meter.fair span:nth-child(1),
    .strength-meter.fair span:nth-child(2) { background: var(--accent-orange); }
    .strength-meter.good span:nth-child(1),
    .strength-meter.good span:nth-child(2),
    .strength-meter.good span:nth-child(3) { background: #6FCF97; }
    .strength-meter.strong span { background: var(--accent-green); }

    .strength-label {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.4rem;
        font-weight: 500;
    }
    .strength-label.weak { color: var(--accent-red); }
    .strength-label.fair { color: var(--accent-orange); }
    .strength-label.good,
    .strength-label.strong { color: var(--accent-green); }

    /* Confirm password match feedback */
    .match-feedback {
        font-size: 0.8rem;
        margin-top: 0.4rem;
        display: none;
    }
    .match-feedback.show { display: flex; align-items: center; gap: 0.35rem; }
    .match-feedback.match { color: var(--accent-green); }
    .match-feedback.no-match { color: var(--accent-red); }

    .req-list {
        list-style: none;
        padding: 0;
        margin: 0.85rem 0 0;
        font-size: 0.8rem;
        color: var(--muted);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.4rem 0.5rem;
    }
    .req-list li {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .req-list .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--border);
        flex: none;
    }
    .req-list li.met { color: var(--accent-green); }
    .req-list li.met .dot { background: var(--accent-green); }

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

    .back-link {
        text-align: center;
        font-size: 0.88rem;
        color: var(--muted);
        margin-top: 1.5rem;
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

    @media (max-width: 767.98px) {
        .auth-illustration { display: none; }
        .auth-form-side { padding: 2.75rem 1.75rem; }
        .req-list { grid-template-columns: 1fr; }
    }
</style>
@endpush

@push('inline-scripts')
<script>
    var passwordInput  = document.getElementById('password');
    var confirmInput   = document.getElementById('password_confirmation');
    var reqList        = document.getElementById('reqList');
    var strengthMeter  = document.getElementById('strengthMeter');
    var strengthLabel  = document.getElementById('strengthLabel');
    var matchFeedback  = document.getElementById('matchFeedback');
    var submitBtn      = document.querySelector('.btn-primary[type="submit"]');

    var requirements = {
        length:    function (v) { return v.length >= 8; },
        uppercase: function (v) { return /[A-Z]/.test(v); },
        number:    function (v) { return /[0-9]/.test(v); },
        special:   function (v) { return /[^A-Za-z0-9]/.test(v); }
    };

    var strengthLevels = [
        { className: '',        label: 'Password strength' },
        { className: 'weak',    label: 'Weak password' },
        { className: 'fair',    label: 'Fair password' },
        { className: 'good',    label: 'Good password' },
        { className: 'strong',  label: 'Strong password' }
    ];

    function updateRequirements(value) {
        var metCount = 0;

        Object.keys(requirements).forEach(function (key) {
            var li  = reqList.querySelector('[data-req="' + key + '"]');
            var met = requirements[key](value);

            li.classList.toggle('met', met);
            if (met) metCount++;
        });

        return metCount;
    }

    function updateStrengthMeter(value, metCount) {
        // Empty field -> reset to neutral state
        var level = value.length === 0 ? 0 : metCount;

        strengthMeter.className = 'strength-meter ' + strengthLevels[level].className;
        strengthLabel.className = 'strength-label ' + strengthLevels[level].className;
        strengthLabel.textContent = strengthLevels[level].label;
    }

    function updateMatchFeedback() {
        var pwd     = passwordInput.value;
        var confirm = confirmInput.value;

        if (confirm.length === 0) {
            matchFeedback.className = 'match-feedback';
            matchFeedback.textContent = '';
            confirmInput.classList.remove('is-invalid');
            return;
        }

        if (pwd === confirm) {
            matchFeedback.className = 'match-feedback show match';
            matchFeedback.textContent = '✓ Passwords match';
            confirmInput.classList.remove('is-invalid');
        } else {
            matchFeedback.className = 'match-feedback show no-match';
            matchFeedback.textContent = '✕ Passwords do not match';
            confirmInput.classList.add('is-invalid');
        }
    }

    function isFormValid() {
        var metCount = updateRequirements(passwordInput.value);
        var allMet   = metCount === Object.keys(requirements).length;
        var matches  = passwordInput.value.length > 0 && passwordInput.value === confirmInput.value;

        {{-- return allMet && matches; --}}
        return matches;
    }

    passwordInput.addEventListener('input', function () {
        var metCount = updateRequirements(this.value);
        updateStrengthMeter(this.value, metCount);

        this.classList.toggle('is-invalid', this.value.length > 0 && metCount < Object.keys(requirements).length);

        if (confirmInput.value.length > 0) updateMatchFeedback();
    });

    confirmInput.addEventListener('input', updateMatchFeedback);

    // Toggle password visibility
    document.querySelectorAll('.toggle-visibility').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-target'));
            if (target.type === 'password') {
                target.type = 'text';
                btn.textContent = 'Hide';
            } else {
                target.type = 'password';
                btn.textContent = 'Show';
            }
        });
    });

    // Prevent submit (in this preview only) until requirements are met
    document.querySelector('form').addEventListener('submit', function (e) {
        if (!isFormValid()) {
            e.preventDefault();

            if (passwordInput.value.length === 0) {
                passwordInput.classList.add('is-invalid');
            }
            updateMatchFeedback();
        }
    });
</script>
@endpush