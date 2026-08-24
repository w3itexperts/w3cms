<form method="post" action="{{@$invoice->id ? route('business.solarmitra.invoices.update',@$invoice->id) : route('business.solarmitra.invoices.store')}}" class="AjaxModalForm">
    @csrf    
    <input type="hidden" name="business_id" value="{{@$invoice->business_id ?? app('currentBusinessId')}}">
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$invoice->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.invoice') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        
        @if (empty($invoice))
        <div class="mb-3">
            <label class="form-label text-uppercase">Select Quotation <span class="text-danger">*</span></label>
            <select class="form-select selectpicker" name="quotation_id" data-live-search="true">
                <option value="" >{{ __('Select Quotation') }}</option>
                @foreach ($quotations as $key => $title)
                    <option value="{{$key}}" @selected(old('quotation_id') == $key)>{{$title}}</option>
                @endforeach
            </select>
            <p class="text-danger error-text quotation_id_error"></p>
        </div>
        @else
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.invoice') }} {{ __('solarmitra::solarmitra.title') }}</label>
            <input type="text" class="form-control" name="title" readonly value="{{@$invoice->title}}">
            <p class="text-danger error-text title_error"></p>
        </div>
        @endif

        <div class="row">
            <div class="mb-3 col-6">
                @php
                    $date = @$invoice ? @$invoice->date : \Carbon\Carbon::now()->format(config('solarmitra.date_time_format')) ;
                @endphp
                <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="date" value="{{ old('date', $date) }}">
                <p class="text-danger error-text date_error"></p>
            </div>

            <div class="mb-3 col-6">
                @php
                    $default_validity_days = SolarMitraHelper::getBusinessConfig('default_validity_days',7);
                    $due_date = @$invoice ? @$invoice->due_date : \Carbon\Carbon::now()->addDays($default_validity_days)->format(config('solarmitra.date_time_format')) ;
                @endphp
                <label class="form-label text-uppercase">{{ __('Due Date') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control DateTimePicker" name="due_date" value="{{ old('due_date', $due_date) }}">
                <p class="text-danger error-text due_date_error"></p>
            </div>

        </div>
        <div class="mb-3">
            <label class="form-label text-uppercase">Select Status <span class="text-danger">*</span></label>
            <select class="form-select " name="status" data-live-search="true">
                <option value="1" @selected(@$invoice->status == 1)>{{ __('Unpaid') }}</option>
                <option value="2" @selected(@$invoice->status == 2)>{{ __('Paid') }}</option>
            </select>
            <p class="text-danger error-text status_error"></p>
        </div>
        <div class="mb-3">
            <label class="form-label text-uppercase">{{ __('solarmitra::solarmitra.description') }}</label>
            <textarea class="form-control" name="description">{{@$invoice->description}}</textarea>
            <p class="text-danger error-text description_error"></p>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$invoice->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.invoice') }}</button>
        </div>
    </div>
</form>