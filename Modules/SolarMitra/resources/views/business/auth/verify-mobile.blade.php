{{-- Extends layout --}}
@extends('admin.layout.fullwidth')

{{-- Content --}}
@section('content')
<div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                @include('admin.elements.alert_message')

                <div class="d-flex justify-content-center align-items-center py-5 vh-100" style="min-height:480px; border-radius:16px;">
                    <div class="card verify-card shadow-sm p-4 h-auto" style="width:380px;">
                        <div class="text-center mb-3">
                            <div class="icon-wrap-m mx-auto mb-3">
                                <i class="icon-phone fs-3 text-success"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Verify your mobile number</h5>
                            <p class="text-muted small mb-2">We sent a 6-digit SMS code to</p>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge bg-success-subtle text-success badge-mobile rounded-pill px-3 py-2">
                                    <i class="icon-phone-call me-1"></i>{{ auth()->user()->mobile ?? $mobile ?? '' }}
                                </span>
                                <a href="{{ route('business.solarmitra.auth.update_contact_form', ['type' => 'mobile']) }}" class="btn btn-link btn-sm p-0 text-muted small" id="change-number-btn">Change</a>
                            </div>
                        </div>
                        <div id="email-success" class="alert alert-success d-flex align-items-center gap-2 py-2 small d-none" role="alert">
                            <i class="icon-circle-check"></i> Email verified successfully!
                        </div>
                        <form action="{{ route('business.solarmitra.auth.verify_user') }}" method="POST" id="VerifyUserForm">
                            @csrf
                            {{-- Set to 'email' or 'mobile' depending on which screen --}}
                            {{-- Pass email or mobile so resend knows who to send to --}}
                            <input type="hidden" name="email"    value="{{ auth()->user()->email ?? $email ?? '' }}">
                            <input type="hidden" name="mobile"   value="{{ auth()->user()->mobile ?? $mobile ?? '' }}">
                            <input type="hidden" name="otp_type" value="mobile"> {{-- or 'mobile' --}}
                            {{-- Hidden field that collects combined OTP from the 6 boxes --}}
                            <input type="hidden" name="otp" id="otp-value">
                            <div class="d-flex justify-content-center gap-2 my-4" id="otp-row">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 1">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 2">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 3">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 4">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 5">
                                <input class="otp-input form-control" maxlength="1" inputmode="numeric" pattern="[0-9]*" aria-label="Digit 6">
                            </div>
                            
                            <button class="btn btn-success btn-verify-m w-100 mb-3" id="verify-btn" disabled>
                              Verify Mobile Number
                            </button>

                            <div class="text-center small text-muted mb-2">
                              Didn't receive it?
                              <button type="button" class="btn btn-link btn-sm p-0 text-success fw-medium" id="resend-btn" disabled>
                                Resend OTP
                                </button>
                                <span id="timer-display" class="ms-1 text-muted"></span>
                            </div>

                            <p class="m-0" id="resend-alert"></p>
                            <div class="text-center mt-3">
                                <a href="{{ route('business.solarmitra.auth.verification') }}" class="btn btn-link text-muted">
                                    <i class="icon-arrow-left me-1"></i> Back to Verification
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>


@endsection

@push('inline-css')
     <style>
.otp-input { width: 48px; height: 56px; font-size: 22px; font-weight: 600; text-align: center; border: 1.5px solid #dee2e6; border-radius: 10px; transition: border-color .2s, box-shadow .2s; }
.otp-input:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25,135,84,.15); outline: none; }
.otp-input.filled { border-color: #198754; background: #f0faf5; }
.verify-card-m { border-radius: 20px; border: 1px solid #e9ecef; }
.icon-wrap-m { width: 64px; height: 64px; border-radius: 50%; background: #e8f5ee; display: flex; align-items: center; justify-content: center; }
.btn-verify-m { border-radius: 10px; padding: 12px; font-weight: 500; font-size: 15px; }
.badge-mobile { font-size: 13px; font-weight: 500; letter-spacing: .5px; }
</style>
@endpush

@section('scripts')
   <script>
    document.addEventListener('DOMContentLoaded', function () {

        // --- Elements ---
        const boxes        = document.querySelectorAll('#otp-row .otp-input');
        const verifyBtn    = document.getElementById('verify-btn');
        const otpInput     = document.getElementById('otp-value');
        const form         = document.getElementById('VerifyUserForm');
        const resendBtn    = document.getElementById('resend-btn');
        const timerDisplay = document.getElementById('timer-display');
        const resendAlert  = document.getElementById('resend-alert');

        const RESEND_LIMIT  = 3;
        const TIMER_SECONDS = 60;

        let timerInterval = null;
        let resendCount   = 0;

        // =========================================================
        // OTP INPUT BEHAVIOUR
        // =========================================================

        boxes.forEach((box, i) => {

            // Allow only numbers & auto-advance
            box.addEventListener('input', () => {
                box.value = box.value.replace(/[^0-9]/g, '');      // strip non-digits

                if (box.value) {
                    box.classList.add('filled');
                    if (boxes[i + 1]) boxes[i + 1].focus();        // move to next box
                } else {
                    box.classList.remove('filled');
                }

                // Enable verify button only when all 6 filled
                verifyBtn.disabled = ![...boxes].every(b => b.value !== '');
            });

            // Backspace: clear current & go back
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace') {
                    if (box.value) {
                        box.value = '';
                        box.classList.remove('filled');
                    } else if (boxes[i - 1]) {
                        boxes[i - 1].focus();
                        boxes[i - 1].value = '';
                        boxes[i - 1].classList.remove('filled');
                    }
                    verifyBtn.disabled = true;
                    e.preventDefault();
                }

                // Allow only digit keys and control keys
                if (
                    !/^[0-9]$/.test(e.key) &&
                    !['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'].includes(e.key)
                ) {
                    e.preventDefault();
                }
            });

            // Arrow key navigation
            box.addEventListener('keyup', e => {
                if (e.key === 'ArrowRight' && boxes[i + 1]) boxes[i + 1].focus();
                if (e.key === 'ArrowLeft'  && boxes[i - 1]) boxes[i - 1].focus();
            });

            // Paste full OTP at once
            box.addEventListener('paste', e => {
                const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
                if (pasted.length === 6) {
                    boxes.forEach((b, j) => {
                        b.value = pasted[j] || '';
                        pasted[j] ? b.classList.add('filled') : b.classList.remove('filled');
                    });
                    boxes[5].focus();
                    verifyBtn.disabled = false;
                }
                e.preventDefault();
            });

            // Prevent selecting existing value on click — clear & re-enter
            box.addEventListener('focus', () => box.select());
        });

        // Focus first box on load
        boxes[0].focus();

        // =========================================================
        // VERIFY BUTTON — FETCH
        // =========================================================

        verifyBtn.addEventListener('click', async function () {

            // Combine 6 digits into hidden input
            otpInput.value = [...boxes].map(b => b.value).join('');

            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying…';

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept'      : 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    verifyBtn.innerHTML = '<i class="icon-check me-1"></i> Verified';
                    verifyBtn.classList.replace('btn-primary', 'btn-success');
                    showAlert('success', result.message);

                    setTimeout(() => { window.location.href = result.redirect; }, 1500);

                } else {
                    showAlert('danger', result.message);
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = 'Verify';
                    clearBoxes();
                }

            } catch (error) {
                showAlert('danger', 'Something went wrong. Please try again.');
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = 'Verify';
            }
        });

        // =========================================================
        // TIMER
        // =========================================================

        function startTimer(seconds) {
            clearInterval(timerInterval);
            resendBtn.disabled = true;

            let remaining = seconds;
            updateTimerDisplay(remaining);

            timerInterval = setInterval(() => {
                remaining--;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.textContent = '';

                    if (resendCount < RESEND_LIMIT) {
                        resendBtn.disabled = false;
                    } else {
                        showResendAlert('warning', 'Maximum resend attempts reached. Please contact support.');
                    }
                } else {
                    updateTimerDisplay(remaining);
                }
            }, 1000);
        }

        function updateTimerDisplay(seconds) {
            const m = Math.floor(seconds / 60);
            const s = seconds % 60;
            timerDisplay.textContent = `Resend in ${m}:${String(s).padStart(2, '0')}`;
        }

        // =========================================================
        // RESEND BUTTON — FETCH
        // =========================================================

        resendBtn.addEventListener('click', async function () {

            if (resendCount >= RESEND_LIMIT) {
                showResendAlert('danger', 'Maximum resend attempts reached. Please contact support.');
                return;
            }

            resendBtn.disabled = true;
            resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>';

            const formData = new FormData();
            formData.append('otp_type', form.querySelector('[name="otp_type"]').value);

            try {
                const response = await fetch('{{ route("business.solarmitra.auth.resend_otp") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept'      : 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    resendCount++;

                    showResendAlert('success', result.message);
                    clearBoxes();

                    // Show remaining attempts
                    if (resendCount < RESEND_LIMIT) {
                        const left = RESEND_LIMIT - resendCount;
                        setTimeout(() => {
                            showResendAlert('info', `${left} resend attempt${left > 1 ? 's' : ''} remaining.`);
                        }, 4200);
                    }

                    // Restart timer with server expiry or default
                    startTimer(result.expires_in ?? TIMER_SECONDS);

                } else {
                    showResendAlert('danger', result.message);
                    resendBtn.disabled = false;
                }

            } catch (error) {
                showResendAlert('danger', 'Something went wrong. Please try again.');
                resendBtn.disabled = false;
            }

            resendBtn.innerHTML = 'Resend OTP';
        });

        // =========================================================
        // HELPERS
        // =========================================================

        function clearBoxes() {
            boxes.forEach(b => { b.value = ''; b.classList.remove('filled'); });
            verifyBtn.disabled = true;
            boxes[0].focus();
        }

        function showAlert(type, message) {
            document.querySelector('.otp-alert')?.remove();
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} d-flex align-items-center gap-2 py-2 small otp-alert`;
            alert.innerHTML = `<i class="${type === 'success' ? 'icon-circle-check' : 'icon-circle-alert'}"></i> ${message}`;
            form.prepend(alert);
        }

        function showResendAlert(type, message) {
            resendAlert.className = `alert alert-${type} small py-2 mt-2`;
            resendAlert.textContent = message;
            resendAlert.classList.remove('d-none');
            setTimeout(() => resendAlert.classList.add('d-none'), 4000);
        }

        // Auto-start timer on page load
        startTimer(TIMER_SECONDS);

    });
    </script>
@endsection