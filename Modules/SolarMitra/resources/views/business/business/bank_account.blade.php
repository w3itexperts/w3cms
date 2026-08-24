<form action="{{route('business.solarmitra.bank_account',@$bank_account->id)}}" method="post" class="AjaxModalForm">
    @csrf
    <input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
    @if (request()->contact_id || @$contact_id)
        <input type="hidden" name="contact_id" value="{{request()->contact_id ?? @$contact_id}}">
    @endif
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>

    <div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div class="flex-column">
                <h5 class="fs-14 fw-bold m-0">{{ @$bank_account->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.bank_account') }}</h5>
            </div>
        </div>
        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-xl-6 mb-3">
                <label for="account_holder" class="form-label">{{ __('solarmitra::solarmitra.account_holder_name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_holder" id="account_holder" value="{{@$bank_account->account_holder}}">
                <p class="text-danger error-text account_holder_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="account_number" class="form-label" >{{ __('solarmitra::solarmitra.account_number') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_number" id="account_number" value="{{@$bank_account->account_number}}">
                <p class="text-danger error-text account_number_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="ifsc_code" class="form-label">{{ __('solarmitra::solarmitra.ifsc_code') }} </label>
                <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="{{@$bank_account->ifsc_code}}">
                <p class="text-danger error-text ifsc_code_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="bank_name" class="form-label">{{ __('solarmitra::solarmitra.bank_name') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{@$bank_account->bank_name}}">
                <p class="text-danger error-text bank_name_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="bank_address" class="form-label">{{ __('solarmitra::solarmitra.bank_address') }} </label>
                <input type="text" class="form-control" name="bank_address" id="bank_address" value="{{@$bank_account->bank_address}}">
                <p class="text-danger error-text bank_address_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="upi_number" class="form-label">{{ __('solarmitra::solarmitra.upi_number') }} </label>
                <input type="text" class="form-control" name="upi_number" id="upi_number" value="{{@$bank_account->upi_number}}">
                <p class="text-danger error-text upi_number_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="iban_number" class="form-label">{{ __('solarmitra::solarmitra.iban_number') }} </label>
                <input type="text" class="form-control" name="iban_number" id="iban_number" value="{{@$bank_account->iban_number}}">
                <p class="text-danger error-text iban_number_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label for="is_primary" class="form-label">{{ __('solarmitra::solarmitra.is_primary') }} </label>
                <div class=" form-switch">
                    <input class="form-check-input inpu-lg" type="checkbox" name="is_primary" role="switch" id="is_primary" value="1" @checked(@$bank_account->is_primary == 1)>
                </div>
                <p class="text-danger error-text is_primary_error"></p>
            </div>
            <div class="col-6">
                <label for="payment_barcode" class="form-label">{{ __('solarmitra::solarmitra.payment_barcode') }} </label>
                <div class="upload-image-box img-parent-box">
                    <div class="img-wrapper">
                        
                        <img src="{{ SolarMitraHelper::getAttachmentImage(@$bank_account->payment_barcode) }}" class="img-for-onchange zoomable"  alt="Image" height="150px" title="Image" @if (@$bank_account->payment_barcode) style="display: inline-block;" @endif>
                        <button type="button" href="{{ @$bank_account->payment_barcode ? route('business.solarmitra.remove-attachment',['attachment_id'=>@$bank_account->payment_barcode]) : 'javascript:void(0);' }}" class="cancel-img-btn position-absolute" aria-label="Close" @if(@$bank_account->payment_barcode) style="display: inline-block;" @endif><i class="icon icon-x"></i></button>
                    </div>
                    <input type="file" class="form-control ps-2 img-business-input-onchange" name="payment_barcode" id="payment_barcode"  hidden accept=".png, .jpg, .jpeg, .webp">
                    <label class="upload-label dropzone-btn" for="payment_barcode" @if(@$bank_account->payment_barcode) style="display: none;" @endif>
                        Payment Barcode
                        <i class="ms-2 icon-upload text-primary fs-18"></i>
                    </label>
                </div>
                @error('payment_barcode')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</form>