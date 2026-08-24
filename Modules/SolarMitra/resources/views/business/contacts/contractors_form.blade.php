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
					<label class="form-label">{{ __('solarmitra::solarmitra.company_name') }}</label>
					<input type="text" class="form-control" name="company_name" value="{{@$contact->company_name}}">
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

				<!----  Contractor Table Fields Start  ----->
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.contractor_type') }} </label>
					<select name="contractor_type" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
						<option value="installation" @selected(@$contact->contractor->contractor_type == 'installation')>{{ __('solarmitra::solarmitra.installation') }}</option>
						<option value="maintenance" @selected(@$contact->contractor->contractor_type == 'maintenance')>{{ __('solarmitra::solarmitra.maintenance') }}</option>
					</select>
	                <p class="text-danger error-text m-0 contractor_type_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.team_size') }} </label>
					<input type="number" class="form-control" name="team_size" min="0" value="{{@$contact->contractor->team_size}}">
	                <p class="text-danger error-text m-0 team_size_error"></p>
				</div>
				
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.skill_category') }} </label>
					<select name="skill_category" class="form-control selectpicker text-primary">
						<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.category') }}</option>
						<option value="rooftop" @selected(@$contact->contractor->skill_category == 'rooftop')>{{ __('solarmitra::solarmitra.rooftop') }}</option>
						<option value="ground_mount" @selected(@$contact->contractor->skill_category == 'ground_mount')>{{ __('solarmitra::solarmitra.ground_mount') }}</option>
					</select>
	                <p class="text-danger error-text m-0 skill_category_error"></p>
				</div>
				
				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.labor_rate_per_kw') }} </label>
					<input type="number" class="form-control" name="labor_rate_per_kw" min="0" value="{{@$contact->contractor->labor_rate_per_kw}}">
					<p class="text-danger error-text m-0 labor_rate_per_kw_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.service_area') }} </label>
					<input type="text" class="form-control" name="service_area" value="{{@$contact->contractor->service_area}}">
	                <p class="text-danger error-text m-0 service_area_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.experience_years') }} </label>
					<input type="number" class="form-control" name="experience_years" min="0" value="{{@$contact->contractor->experience_years}}">
					<p class="text-danger error-text m-0 experience_years_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.license_no') }} </label>
					<input type="text" class="form-control" name="license_no" value="{{@$contact->contractor->license_no}}">
	                <p class="text-danger error-text m-0 license_no_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.availability_status') }} </label>
					<select name="availability_status" class="form-control selectpicker text-primary">
						<option value="1" @selected(@$contact->contractor->availability_status == '1')>{{ __('solarmitra::solarmitra.available') }}</option>
						<option value="2" @selected(@$contact->contractor->availability_status == '2')>{{ __('solarmitra::solarmitra.busy') }}</option>
					</select>
	                <p class="text-danger error-text m-0 availability_status_error"></p>
				</div>

				<div class="col-xl-6 mb-3">
					<label class="form-label">{{ __('solarmitra::solarmitra.rating') }} </label>
					<input type="number" class="form-control" name="rating" min="0" max="5" step="any" value="{{@$contact->contractor->rating}}">
					<p class="text-danger error-text m-0 rating_error"></p>
				</div>
				<!----  Contractor Table Fields End  ----->

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
