<!-- Top Header -->
<div class="top-bar">
    <div class="container">
        <div class="dz-topbar-inner d-flex justify-content-between align-items-center">
            <div class="dz-topbar-left">
                @if (config('ThemeOptions.email_address'))
                <ul>
                    <li>
                        <i class="fa-regular fa-envelope"></i>
                        {{config('ThemeOptions.email_address')}}
                    </li>
                </ul>
                @endif
            </div>
            
            <div class="dz-topbar-right">
                <ul>
                    @if (!\Auth::check() && $show_login_registration)
                        @if ( $header_login_on )
                            <li class="dz-login-btn"><a href="{{ route('admin.login') }}" class="me-1">{{ __('Sign In') }}</a>
                                @if ($header_register_on)/ @endif </li>
                        @endif
                        @if ($header_register_on)
                            <li class="dz-register-btn ps-0"><a href="{{ route('admin.register') }}">{{ __('Sign Up') }}</a></li>
                        @endif
                    @endif
                    @if(!empty(config('ThemeOptions.opening_time')))
                        <li><i class="fa-regular fa-clock"></i> {!! config('ThemeOptions.opening_time') !!}</li>
                    @endif
                    @if(!empty(config('ThemeOptions.phone_number')))
                        <li><i class="fa fa-phone"></i>{{ config('ThemeOptions.phone_number') }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
