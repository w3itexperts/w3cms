@php
	if (@$contact->id) {
		$action = route('business.solarmitra.contacts.update',$contact->id);
	}else{
		$action = route('business.solarmitra.contacts.store');
	}
@endphp


	<div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
		<div class="d-flex align-items-center gap-3">
			<button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			<div class="flex-column">
				@if (@$contact->id)
				<h5 class="fs-14 fw-bold m-0">{{ __('solarmitra::solarmitra.edit') }} {{ @$type ? __('solarmitra::solarmitra.'.$type) : __('solarmitra::solarmitra.contact') }}</h5>
				@else
				<h5 class="fs-14 fw-bold m-0">{{ __('solarmitra::solarmitra.add') }} {{ @$type ? __('solarmitra::solarmitra.'.$type) : __('solarmitra::solarmitra.contact') }}</h5>
				@endif
			</div>
		</div>
		<div class="d-flex gap-3">
			<button type="submit" id="SubmitContactForm" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
		</div>
	</div>
	<div class="offcanvas-body">
		
		<form action="{{@$action}}" method="post" id="ContactForm">
			<div class="formLoading d-none">
			    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
			    <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
			</div>
			@csrf
			<input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
			<input type="hidden" name="id" value="{{@$contact->id}}">
			@if (@$type)
				<input type="hidden" name="type" value="{{@$type}}">
			@endif
			<div class="row">
				@if (!@$type)
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.select_user_type') }} <span class="text-danger">*</span></label>
					<select name="type" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
						@foreach (config('solarmitra.business_user_types', []) as $element => $title)
							<option value="{{$element}}" @selected(in_array($element, SolarMitraHelper::getContactTypes(@$contact->id)))>{{$title}}</option>
						@endforeach
					</select>
	                <p class="text-danger error-text m-0 type_error"></p>
				</div>
				@endif

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.name') }} <span class="text-danger">*</span></label>
					<input type="text" class="form-control" name="name" value="{{@$contact->name}}">
	                <p class="text-danger error-text m-0 name_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.phone') }} <span class="text-danger">*</span></label>
					<input type="number" class="form-control" name="phone_number" value="{{@$contact->phone_number}}">
	                <p class="text-danger error-text m-0 phone_number_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.email') }} </label>
					<input type="email" class="form-control" name="email" value="{{@$contact->email}}">
	                <p class="text-danger error-text m-0 email_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.aadhar_no') }} </label>
					<input type="text" class="form-control" name="aadhar_no"  value="{{@$contact->aadhar_no}}">
	                <p class="text-danger error-text m-0 aadhar_no_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.pan_no') }} </label>
					<input type="text" class="form-control" name="pan_no" value="{{@$contact->pan_no}}">
	                <p class="text-danger error-text m-0 pan_no_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.gst_no') }} </label>
					<input type="text" class="form-control" name="gst_no" value="{{@$contact->gst_no}}">
	                <p class="text-danger error-text m-0 gst_no_error"></p>
				</div>
				@if (!@$contact->id)
				<div class="col-xl-6 mb-3">
	                <label class="form-label">{{ __('solarmitra::solarmitra.address_title') }} {!!@$type === 'clients' ? '<span class="text-danger">*</span>' : '('.__('solarmitra::solarmitra.optional').')'!!}</label>
	                <input type="text" class="form-control" name="address_title" value="">
	                <p class="text-danger error-text address_title_error"></p>
	            </div>
	            <div class="col-xl-6 mb-3">
	                <label class="form-label">{{ __('solarmitra::solarmitra.address') }} {!!@$type === 'clients' ? '<span class="text-danger">*</span>' : '('.__('solarmitra::solarmitra.optional').')'!!}</label>
	                <input type="text" class="form-control" name="address" value="">
	                <p class="text-danger error-text address_error"></p>
	            </div>
				@endif
				
				<!----  Clients Table Fields Start  ----->
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.client_code') }} </label>
					<input type="text" class="form-control" name="client_code"  value="{{@$contact->client->client_code}}">
	                <p class="text-danger error-text m-0 client_code_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.client_type') }} </label>
					<select name="client_type" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
						@foreach (config('solarmitra.client_types', []) as $element => $title)
							<option value="{{$element}}" @selected(@$contact->client->client_type == $element)>{{$title}}</option>
						@endforeach
					</select>
	                <p class="text-danger error-text m-0 client_type_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.customer_since') }} </label>
					<input type="text" class="form-control DateTimePicker" name="customer_since" value="{{old('customer_since',@$contact->client->customer_since ?? \Carbon\Carbon::now()->format(config('solarmitra.date_time_format')) )}}">
	                <p class="text-danger error-text m-0 customer_since_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.credit_limit') }} </label>
					<input type="number" class="form-control" name="credit_limit"  value="{{@$contact->client->credit_limit}}">
	                <p class="text-danger error-text m-0 credit_limit_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.payment_terms') }} </label>
					<select name="payment_terms" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.payment_terms') }}</option>
						<option value="advance" @selected(@$contact->client->payment_terms == 'advance')>{{ __('solarmitra::solarmitra.advance') }}</option>
						<option value="due_on_receipt" @selected(@$contact->client->payment_terms == 'due_on_receipt')>{{ __('solarmitra::solarmitra.due_on_receipt') }}</option>
						<option value="7_days" @selected(@$contact->client->payment_terms == '7_days')>{{ __('solarmitra::solarmitra.7_days') }}</option>
						<option value="15_days" @selected(@$contact->client->payment_terms == '15_days')>{{ __('solarmitra::solarmitra.15_days') }}</option>
						<option value="30_days" @selected(@$contact->client->payment_terms == '30_days')>{{ __('solarmitra::solarmitra.30_days') }}</option>
					</select>
	                <p class="text-danger error-text m-0 payment_terms_error"></p>
				</div>
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.preferred_contact_method') }} </label>
					<select name="preferred_contact_method" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.method') }}</option>
						<option value="phone" @selected(@$contact->client->preferred_contact_method == 'phone')>{{ __('solarmitra::solarmitra.phone') }}</option>
						<option value="email" @selected(@$contact->client->preferred_contact_method == 'email')>{{ __('solarmitra::solarmitra.email') }}</option>
						<option value="whatapp" @selected(@$contact->client->preferred_contact_method == 'whatapp')>{{ __('solarmitra::solarmitra.whatsapp') }}</option>
					</select>
	                <p class="text-danger error-text m-0 preferred_contact_method_error"></p>
				</div>
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.priority_level') }} </label>
					<select name="priority_level" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.level') }}</option>
						<option value="1" @selected(@$contact->client->priority_level == 1)>{{ __('solarmitra::solarmitra.normal') }}</option>
						<option value="2" @selected(@$contact->client->priority_level == 2)>{{ __('solarmitra::solarmitra.high') }}</option>
						<option value="3" @selected(@$contact->client->priority_level == 3)>{{ __('solarmitra::solarmitra.vip') }}</option>
					</select>
	                <p class="text-danger error-text m-0 priority_level_error"></p>
				</div>
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.status') }} </label>
					<select name="status" class="form-control selectpicker text-primary">
						<option value="1" @selected(@$contact->client->status == 1)>{{ __('solarmitra::solarmitra.active') }}</option>
						<option value="0" @selected(@$contact->client->status == 0)>{{ __('solarmitra::solarmitra.inactive') }}</option>
						<option value="2" @selected(@$contact->client->status == 2)>{{ __('solarmitra::solarmitra.blocked') }}</option>
					</select>
	                <p class="text-danger error-text m-0 priority_level_error"></p>
				</div>
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.note') }} </label>
					<textarea class="form-control" name="notes">{{@$contact->client->notes}}</textarea>
				</div>
				<!----  Clients Table Fields End  ----->

				@if (@$contact->id)
				<div class="col-xl-6 mb-3">
					<div class="">
						<label class="form-label d-flex align-items-center justify-content-between">
							{{ __('solarmitra::solarmitra.bank_account') }} 
							<a class="btn-link AjaxOffCanvasShow" href="{{route('business.solarmitra.bank_account',[@$contact->bank_account->id,'contact_id'=>@$contact->id])}}" id="ContactAddBankLink" data-link-type="Bank" > {{ @$contact->bank_account ? __('solarmitra::solarmitra.edit_bank') : __('solarmitra::solarmitra.add_bank').' +'}}</a>
						</label>
					</div>
					@if (@$contact->bank_account)
					<input type="text" class="form-control" name="bank_account" value="{{@$contact->bank_account->bank_name}}" readonly>
					@endif
				</div>

				<div class="col-xl-6 mb-3">
					<div class="">
						<label class="form-label d-flex align-items-center justify-content-between">
							{{ __('solarmitra::solarmitra.address') }} 

							<a class="btn-link AjaxOffCanvasShow" href="{{route('business.solarmitra.address',[@$contact->address->id,'contact_id'=>@$contact->id])}}" id="ContactAddAddressLink" data-link-type="Address"> {{ @$contact->address ? __('solarmitra::solarmitra.edit_address') : __('solarmitra::solarmitra.add_address').' +'}}</a>
						</label>
					</div>
					@if (@$contact->address)
					<input type="text" class="form-control" name="address" value="{{@$contact->address->address}}" readonly>
					@endif
				</div>
				@endif
			</div>
		</form>

		@include('solarmitra::business.contacts.assign_user_form')
	</div>
</div>
