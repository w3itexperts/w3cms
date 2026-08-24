{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    @if (session('status') == "two-factor-authentication-disabled")
        <div class="alert alert-danger" role="alert">
            {{ __('solarmitra::solarmitra.2fa_disabled_text') }}
        </div>
    @endif
    
    @if (session('status') == "two-factor-authentication-enabled")
        <div class="alert alert-success" role="alert">
            {{ __('solarmitra::solarmitra.2fa_enabled_text') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit_profile') }}</h4>
        </div>
        <form action="{{ route('business.solarmitra.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="basic-form">
                    <div class="row align-items-center ">
                        <div class="col-sm-4 text-center">

                            <div class="custom-img-upload img-parent-box mb-2">
                                    
                                <img src="{{ HelpDesk::user_img($user->profile) }}" class="img-for-onchange zoomable rounded mb-3" width="200" id="RemoveProfile_{{ $user->id }}" alt="{{ __('solarmitra::solarmitra.user_profile') }}">
                                
                                <div class="upload-btn">

                                    @if ($user->profile)
                                        <a href="javascript:void(0);" rdx-link="{{ route('admin.user.remove_user_image', $user->id) }}" class="rdxUpdateAjax btn btn-primary btn-xs me-1" rdx-delete-box="RemoveProfile_{{ $user->id }}">{{ __('solarmitra::solarmitra.remove') }}</a>
                                    @endif

                                    <input type="file" class="-input form-control ps-2 img-business-input-onchange" name="user_img" id="user_img" accept=".png, .jpg, .jpeg" hidden>
                                    <label class="upload-label btn btn-xs btn-primary m-0" for="user_img">{{ __('solarmitra::solarmitra.upload') }}</label>
                                </div>
                                @error('user_img')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.first_name') }} <span class="text-danger"> *</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-12">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.last_name') }} </label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.email') }} <span class="text-danger"> *</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">{{ __('solarmitra::solarmitra.phone') }} <span class="text-danger"> *</span></label>
                                    <input type="number" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                                    @error('mobile')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.update') }}</button>
                <a href="#" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('solarmitra::solarmitra.update_password') }}</h4>
                            </div>
                            <form action="{{ route('business.solarmitra.users.update-password', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="basic-form">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">{{ __('solarmitra::solarmitra.password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control dz-password" name="password" value="{{ old('password') }}">
                                                    <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                                                        <span class="show"><i class="fa fa-eye-slash"></i></span>
                                                        <span class="hide"><i class="fa fa-eye"></i></span>
                                                    </span>
                                                </div>
                                                @error('password')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="mb-3  col-md-6">
                                                <label class="form-label">{{ __('solarmitra::solarmitra.confirm_password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control dz-password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                                    <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                                                        <span class="show"><i class="fa fa-eye-slash"></i></span>
                                                        <span class="hide"><i class="fa fa-eye"></i></span>
                                                    </span>
                                                </div>
                                                @error('confirm_password')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection