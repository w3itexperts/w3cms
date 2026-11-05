<!-- Header -->
<header class="site-header mo-left header">

	<!-- Main Header -->
	<div class="{{ $header_sticky_class }} main-bar-wraper navbar-expand-lg">
		<div class="main-bar clearfix">
			<div class="container clearfix">
				<div class="box-header clearfix d-lg-flex d-block">

					<!-- Website Logo -->
					<div class="logo-header mostion logo-dark">
                        @if ($logo_type == 'text_logo')
						<div class="text-logo">
							@if (!empty($logo_text))
							<h1 class="site-title">
								<a href="{{url( '/' )}}" title="{{$logo_title}}">
									{{$logo_text}}
								</a>
							</h1>
							@endif
                            @if(!empty($logo_tag))
                                <p class="site-description">{{$logo_tag}}</p>
                            @endif
						</div>
						@else
						<a href="{{url( '/' )}}" title="{{$logo_title}}">
							<img src="{{$logo}}" alt="{{$logo_alt}}"/>
						</a>
						@endif
					</div>

					<!-- Nav Toggle Button -->
					<button class="navbar-toggler navbar-toggler-skew navbar-toggler navbar-toggler-skew-skew collapsed navicon justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>


					<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
						<div class="logo-header">
                            @if ($logo_type == 'text_logo')
                            <div class="text-logo">
                                @if (!empty($logo_text))
                                <h1 class="site-title">
                                    <a href="{{url( '/' )}}" title="{{$logo_title}}">
                                        {{$logo_text}}
                                    </a>
                                </h1>
                                @endif
                            </div>
                            @else
                            <a href="{{url( '/' )}}" title="{{$logo_title}}">
                                <img src="{{DzHelper::siteLogo()}}" alt="{{$logo_alt}}"/>
                            </a>
                            @endif
						</div>
                        {{ DzHelper::nav_menu(
                            array(
                            'theme_location'  => 'primary',
                            'menu_class'      => 'nav navbar-nav navbar navbar-left',
                            )
                        ) }}
						<div class="sidebar-footer text-center">
							<div class="dz-login-register d-lg-none">
                                @if(!empty($mobile_header_login_on))
                                <a href="{{ route('admin.login') }}" class="dz-login-btn btn btn-primary shadow-primary btn-skew d-lg-none">
                                    <span>{{ __('Sign In') }}</span>
                                </a>
                                @endif
                                @if(!empty($mobile_header_register_on))
                                    <a href="{{ route('register') }}" class="dz-register-btn btn btn-primary shadow-primary btn-skew d-lg-none">
                                    <span>{{ __('Sign Up') }}</span>
                                </a>
                                @endif
							</div>
							@if($mobile_header_social_link_on && $show_social_icon)
                            <div class="dz-social-icon">
                                @if ($header_social_link_on && $show_social_icon && $mobile_header_social_link_on)
                                    <ul>
                                        {!! get_social_icons(null,'') !!}
                                    </ul>
                                @endif
                            </div>
                            @endif
						</div>
					</div>

					<!-- Extra Nav -->
                    @if( !empty($header_search_on) || !empty($header_button_1_text))
                    <div class="extra-nav">
                        <div class="extra-cell">
                            @if( $header_search_on)
                                <button id="quik-search-btn" type="button" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <div class="dz-quik-search">
                                    <form method="get" action="{{ route('permalink.search') }}">
                                        <input name="s" value="" type="text" class="form-control" placeholder="{{ __('Enter Your Keyword ...') }}">
                                        <span type="submit" id="quik-search-remove"><i class="fa-solid fa-xmark"></i></span>
                                    </form>
                                </div>
                            @endif
                            @if(!empty($header_button_1_text))
                                <a href="{{ $header_button_1_url }}" class="btn btn-primary btn-skew appointment-btn" target="{{ $header_button_1_target }}"><span>{{ $header_button_1_text }}</span></a>
                            @endif
                        </div>
                    </div>
                    @endif
					<!-- Extra Nav -->
				</div>
			</div>
		</div>
	</div>
	<!-- Main Header End -->
</header>
<!-- Header -->
