{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('solarmitra::solarmitra.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('solarmitra::solarmitra.welcome_back_desc') }}</p>
		    </div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.solarmitra.businesses.index') }}">{{ __('solarmitra::solarmitra.businesses') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.business') }}</a></li>
			</ol>
		</div>
	</div>

	<form action="{{ route('admin.solarmitra.businesses.update', $business->id) }}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h4 class="head-sefrator">{{ __('solarmitra::solarmitra.user') }} {{ __('Details') }}</h4>
						<div class="row">
							<div class="form-group col-md-4">
								<label>{{ __('solarmitra::solarmitra.first_name') }} <span class="text-danger">*</span></label>
								<input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name',$business->user->first_name) }}">
								@error('first_name')
		                            <p class="text-danger">
		                                {{ $message }}
		                            </p>
		                        @enderror
							</div>
							<div class="form-group col-md-4">
								<label>{{ __('solarmitra::solarmitra.last_name') }} </label>
								<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name',$business->user->last_name) }}">
								@error('last_name')
		                            <p class="text-danger">
		                                {{ $message }}
		                            </p>
		                        @enderror
							</div>
							<div class="form-group col-md-4">
								<label>{{ __('solarmitra::solarmitra.email') }}<span class="text-danger">*</span></label>
								<input type="email" name="email" id="email" class="form-control" value="{{ old('email',$business->user->email) }}">
								@error('email')
		                            <p class="text-danger">
		                                {{ $message }}
		                            </p>
		                        @enderror
							</div>
							<div class="form-group col-sm-6">
								<label for="dz-password">{{ __('solarmitra::solarmitra.password') }}</label>
								<div class="input-group">
									<input type="password" name="password" id="dz-password" class="form-control" autocomplete="new-password" value="{{ old('password') }}">
									<span class="input-group-text show-pass"> 
	                                    <i class="icon-eye-off"></i>
	                                    <i class="icon-eye"></i>
	                                </span>
								</div>
								@error('password')
		                            <p class="text-danger">
		                                {{ $message }}
		                            </p>
		                        @enderror
							</div>
							<div class="form-group col-sm-6">
								<label for="dz-con-password">{{ __('solarmitra::solarmitra.confirm_password') }}</label>
								<div class="input-group">
									<input type="password" name="password_confirmation" id="dz-con-password" class="form-control" autocomplete="new-password" value="{{ old('password_confirmation') }}">
									<span class="input-group-text show-con-pass"> 
	                                    <i class="icon-eye-off"></i>
	                                    <i class="icon-eye"></i>
	                                </span>
								</div>
								@error('password_confirmation')
		                            <p class="text-danger">
		                                {{ $message }}
		                            </p>
		                        @enderror
							</div>
						</div>
						<h4 class="head-sefrator">{{ __('solarmitra::solarmitra.business_owner') }}</h4>
						<div class="row">
							<div class="form-group col-md-3">
								<label for="company_name">{{ __('solarmitra::solarmitra.company_name') }}<span class="text-danger">*</span></label>
								<input type="text" name="company_name" class="form-control" id="company_name" placeholder="{{ __('solarmitra::solarmitra.company_name') }}" value="{{ old('company_name',$business->company_name) }}" required>
								@error('company_name')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-3">
								<label for="Phone">{{ __('solarmitra::solarmitra.phone') }}<span class="text-danger">*</span></label>
								<input type="number" name="phone" class="form-control" id="Phone" value="{{ old('phone',$business->phone) }}" placeholder="{{ __('solarmitra::solarmitra.phone') }}">
								@error('phone')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-3">
								<label for="gst_no">{{ __('solarmitra::solarmitra.gst_no') }}</label>
								<input type="text" name="gst_no" class="form-control" id="gst_no" value="{{ old('gst_no',$business->gst_no) }}" placeholder="{{ __('solarmitra::solarmitra.gst_no') }}" >
								@error('gst_no')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-3">
								<label for="pan_no">{{ __('solarmitra::solarmitra.pan_no') }}</label>
								<input type="text" name="pan_no" class="form-control" id="pan_no" value="{{ old('pan_no',$business->pan_no) }}" placeholder="{{ __('solarmitra::solarmitra.pan_no') }}" >
								@error('pan_no')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<label for="About">{{ __('solarmitra::solarmitra.about') }}</label>
								<textarea name="about" class="form-control h-auto" id="About" rows="5">{{ old('about',$business->about) }}</textarea>
								@error('about')
									<p class="text-danger">
										{{ $message }}
									</p>
								@enderror
							</div>
							<div class="form-group col-md-6">
								<div class=" img-parent-box"> 
		                            <img src="{{ SolarMitraHelper::getAttachmentImage(@$business->logo) }}" class="img-for-onchange zoomable rounded mb-2" alt="" width="200px">
									<input type="file" class="ps-2 form-control img-business-input-onchange" name="logo" accept=".png, .jpg, .jpeg">
							   </div>
                                @error('logo')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
							</div>
						</div>

					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary" title="{{ __('solarmitra::solarmitra.click_to_save') }} {{ __('solarmitra::solarmitra.business') }}">{{ __('solarmitra::solarmitra.save') }}</button>
						<a href="{{ route('admin.solarmitra.businesses.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
					</div>
				</div>
			</div>	
		</div>
	</form>
</div>
@endsection

