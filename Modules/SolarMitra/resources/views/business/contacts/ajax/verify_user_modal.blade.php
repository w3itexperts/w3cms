<div class="modal-header">
    <h5 class="modal-title"><i class="fas fa-badge-check me-2"></i>{{ __('solarmitra::solarmitra.verify_user') }} — {{ $contact->name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body text-center py-4">
    <p class="text-muted mb-4">{{ __('solarmitra::solarmitra.select_method_to_verify', ['name' => $contact->name]) }}</p>

    <div class="d-flex justify-content-center gap-3">
        <button type="button"
                class="btn btn-outline-primary btn-md px-4 verifyFieldBtn {{ $contact->user->is_email_verified ? 'bg-success-subtle border-success text-success' : '' }}"
                data-field="email"
                data-url="{{ route('business.solarmitra.contacts.verify_user_field', $contact->id) }}"
                {{ $contact->user->is_email_verified ? 'disabled' : '' }}>
            <i class="fas fa-envelope me-2"></i>
            @if($contact->user->is_email_verified)
                <span class="verified-text">{{ __('solarmitra::solarmitra.email_verified') }} <i class="fas fa-check-circle ms-1"></i></span>
            @else
                <span class="verify-text">{{ __('solarmitra::solarmitra.verify_email') }}</span>
            @endif
        </button>

        <button type="button"
                class="btn btn-outline-primary btn-md px-4 verifyFieldBtn {{ $contact->user->is_mobile_verified ? 'bg-success-subtle border-success text-success' : '' }}"
                data-field="mobile"
                data-url="{{ route('business.solarmitra.contacts.verify_user_field', $contact->id) }}"
                {{ $contact->user->is_mobile_verified ? 'disabled' : '' }}>
            <i class="fas fa-mobile-alt me-2"></i>
            @if($contact->user->is_mobile_verified)
                <span class="verified-text">{{ __('solarmitra::solarmitra.mobile_verified') }} <i class="fas fa-check-circle ms-1"></i></span>
            @else
                <span class="verify-text">{{ __('solarmitra::solarmitra.verify_mobile') }}</span>
            @endif
        </button>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
</div>