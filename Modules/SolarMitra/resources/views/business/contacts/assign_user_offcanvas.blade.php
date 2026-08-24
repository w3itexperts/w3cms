<div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="flex-column">
            <h5 class="fs-14 fw-bold m-0">{{ $contact->user ? __('Update Assigned User') : __('Assign Login to User') }}</h5>
        </div>
    </div>
    <div class="d-flex gap-3">
        <button type="button" id="SubmitContactAssignLoginForm" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
    </div>
</div>
<div class="offcanvas-body">
    @include('solarmitra::business.contacts.assign_user_form')
</div>