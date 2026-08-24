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
				<!----  Staff Table Fields Start  ----->
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.staff_code') }} </label>
					<input type="text" class="form-control" name="employee_code"  value="{{@$contact->staff->employee_code}}">
	                <p class="text-danger error-text m-0 employee_code_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.department') }} </label>
					<select name="department" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.department') }}</option>
						@foreach (config('solarmitra.staff_departments', []) as $element => $title)
							<option value="{{$element}}" @selected(@$contact->staff->department == $element)>{{$title}}</option>
						@endforeach
					</select>
	                <p class="text-danger error-text m-0 department_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.designation') }} </label>
					<input type="text" class="form-control" name="designation"  value="{{@$contact->staff->designation}}">
	                <p class="text-danger error-text m-0 designation_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.joining_date') }} </label>
					<input type="text" class="form-control DateTimePicker" name="joining_date" value="{{old('joining_date',@$contact->staff->joining_date ?? \Carbon\Carbon::now()->format(config('solarmitra.date_time_format')) )}}">
	                <p class="text-danger error-text m-0 joining_date_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.employment_type') }} </label>
					<select name="employment_type" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
						<option value="full_time" @selected(@$contact->staff->employment_type == 'full_time')>{{ __('solarmitra::solarmitra.full_time') }}</option>
						<option value="contract" @selected(@$contact->staff->employment_type == 'contract')>{{ __('solarmitra::solarmitra.contract') }}</option>
					</select>
	                <p class="text-danger error-text m-0 employment_type_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.salary_type') }} </label>
					<select name="salary_type" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
						@foreach (config('solarmitra.salary_type', []) as $element => $title)
							<option value="{{$element}}" @selected(@$contact->staff->salary_type == $element)>{{$title}}</option>
						@endforeach
					</select>
	                <p class="text-danger error-text m-0 salary_type_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.salary_amount') }} </label>
					<input type="number" class="form-control" name="salary_amount"  value="{{@$contact->staff->salary_amount}}">
	                <p class="text-danger error-text m-0 salary_amount_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.work_location') }} </label>
					<select name="work_location" class="form-control selectpicker text-primary">
						@foreach (config('solarmitra.work_location', []) as $element => $title)
							<option value="{{$element}}" @selected(@$contact->staff->work_location == $element)>{{$title}}</option>
						@endforeach
					</select>
	                <p class="text-danger error-text m-0 work_location_error"></p>
				</div>
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.status') }} </label>
					<select name="status" class="form-control selectpicker text-primary">
						<option value="1" @selected(@$contact->staff->status == '1')>{{ __('solarmitra::solarmitra.active') }}</option>
						<option value="0" @selected(@$contact->staff->status == '0')>{{ __('solarmitra::solarmitra.inactive') }}</option>
					</select>
	                <p class="text-danger error-text m-0 status_error"></p>
				</div>
				<div class="col-xl-12 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.work_responsibilities') }} </label>
					<textarea name="work_responsibilities" class="form-control">{{@$contact->staff->work_responsibilities}}</textarea>
	                <p class="text-danger error-text m-0 work_responsibilities_error"></p>
				</div>
				<div class="col-xl-12 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.special_note') }} </label>
					<textarea name="special_note" class="form-control">{{@$contact->staff->special_note}}</textarea>
	                <p class="text-danger error-text m-0 special_note_error"></p>
				</div>
				<!----  Staff Table Fields End  ----->

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

	</div>
</div>
