@if (@$contact->id && (@$type == 'staff' || in_array('staff', SolarMitraHelper::getContactTypes(@$contact->id))) && auth('business')->user()->can('SolarMitra > Business > ContactsController > assign_login'))

	<form action="{{route('business.solarmitra.contacts.assign_login')}}" method="post" id="ContactAssignLoginForm">
		<div class="formLoading d-none">
		    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
		    <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
		</div>
        <p class="text-danger error-text m-0 email_error"></p>
		@if (@$contact->email)
		<input type="hidden" name="email" value="{{@$contact->email}}">
		@endif
		<input type="hidden" name="name" value="{{@$contact->name}}">
		<input type="hidden" name="mobile" value="{{@$contact->phone_number}}">
		<input type="hidden" name="contact_id" value="{{@$contact->id}}">
		<input type="hidden" name="type" value="{{@$type}}">
		<div class="row">

			<div class="col-xl-12 mb-3">
				<div class="text-start border-bottom border-grey position-relative my-4">
                    <h4 class="bg-body position-absolute top-50 translate-middle-y pe-2 text-uppercase text-primary m-0">{{ $contact->user ? 'Update Assigned User' : __('solarmitra::solarmitra.assign_login_to_user') }}</h4>
                </div>
				@if (!$contact->user)
				<label for="assign_login" class="form-label">{{ __('solarmitra::solarmitra.assign_login_to_user') }} </label>
	            <div class=" form-switch">
	                <input class="form-check-input inpu-lg" type="checkbox" name="assign_login" role="switch" id="assign_login" value="1" @checked(!empty(@$contact->user))>
	            </div>
				@endif
                <p class="text-danger error-text m-0 assign_login_error"></p>
                <p class="text-danger error-text m-0 name_error"></p>
                <p class="text-danger error-text m-0 mobile_error"></p>
			</div>
			@if (!@$contact->email)
			<div class="col-xl-6 mb-3">
                <label for="email" class="form-label">{{ __('solarmitra::solarmitra.email') }} @if (!$contact->user)<span class="text-danger">*</span>@endif</label>
				<input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <p class="text-danger error-text m-0 email_error"></p>
            </div>
			@endif
			<div class="col-xl-6 mb-3" id="assign_login_password" style="{{$contact->user ? '' : 'display:none;'}}">
                <label for="password" class="form-label">{{ __('solarmitra::solarmitra.password') }} @if (!$contact->user)<span class="text-danger">*</span>@endif</label>
                <div class="position-relative">
					<input type="password" class="form-control dz-password" name="password" value="{{ old('password') }}">
					<span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                        <span class="show"><i class="fa fa-eye-slash"></i></span>
                        <span class="hide"><i class="fa fa-eye"></i></span>
                    </span>
            	</div>
                <p class="text-danger error-text m-0 password_error"></p>
            </div>

            <div class="col-xl-6 mb-3" id="assign_login_confirm_password"  style="{{$contact->user ? '' : 'display:none;'}}">
                <label for="password_confirmation" class="form-label">{{ __('solarmitra::solarmitra.confirm_password') }} @if (!$contact->user)<span class="text-danger">*</span>@endif</label>
                <div class="position-relative">
                    <input type="password" class="form-control dz-password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                        <span class="show"><i class="fa fa-eye-slash"></i></span>
                        <span class="hide"><i class="fa fa-eye"></i></span>
                    </span>
                </div>
                <p class="text-danger error-text m-0 password_confirmation_error"></p>
            </div>
            @php
            	$user_roles = optional(optional(optional($contact->user)->roles)->pluck('id'))->toArray() ?? [config('solarmitra.business_user_roles.'.@$type)];

            @endphp
            <div class="col-xl-6 mb-3" id="assign_login_role"  style="{{$contact->user ? '' : 'display:none;'}}">
                <label class="form-label" for="role">{{ __('solarmitra::solarmitra.role') }} <span class="text-danger">*</span></label>
				<select name="role[]" id="role" class="form-control selectpicker text-primary" data-live-search="true" multiple>
					<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.role') }}</option>
					@foreach ($business_roles as $roleId => $name)
						<option value="{{$roleId}}" @selected(in_array($roleId, $user_roles))>{{$name}}</option>
					@endforeach
				</select>
                <p class="text-danger error-text m-0 role_error"></p>
            </div>
            <div class="col-xl-12 mb-3" >
    			<button type="submit" id="SubmitContactAssignLoginForm" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>

            </div>
			
		</div>
	</form>
@endif