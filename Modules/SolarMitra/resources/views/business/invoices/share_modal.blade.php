<!-- Header -->
<div class="modal-header">
    <h5 class="modal-title" id="date-filter">{{ __('solarmitra::solarmitra.share') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<!-- Body -->
<div class="modal-body ">
    <!-- Social Icons Grid -->
    <div class="row row-cols-4 g-4 text-center mb-4">
        <!-- WhatsApp -->
        <div class="col">
            <a href="https://wa.me/91{{optional($invoice->client)->phone_number}}?text={{ urlencode('Download your invoice: '.route('solarmitra.invoices.view_invoice',Crypt::encrypt($invoice->id))) }}" target="_blank" class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2 border"
                style="width:60px;height:60px;">
                <i class="fab fa-whatsapp text-success fs-4"></i>
            </a>
            <small>Whatsapp</small>
        </div>
        <!-- Facebook -->
       
        <!-- Download -->
        <div class="col">
            <a href="{{ route('solarmitra.invoices.download_invoice',Crypt::encrypt($invoice->id)) }}" class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-2 border"
                style="width:60px;height:60px;">
                <i class="fa-solid fa-download text-primary fs-4"></i>
            </a>
            <small>{{ __('solarmitra::solarmitra.download') }}</small>
        </div>
    </div>
    <hr>
    <!-- Page Link Section -->
    <div>
        <label class="form-label fw-semibold">
            Page Link <small class="text-danger d-none" id="CopyToClipBoardMsg">Link Copied</small>
        </label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="CopyToClipBoardInput" value="{{ route('solarmitra.invoices.view_invoice',Crypt::encrypt($invoice->id)) }}" readonly>
          <a href="{{ route('solarmitra.invoices.view_invoice',Crypt::encrypt($invoice->id)) }}" class="input-group-text" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
          <button class="input-group-text" id="CopyToClipBoardBtn"><i class="fa-regular fa-copy"></i></button>
        </div>
    </div>
</div>