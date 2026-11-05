<section class="content-inner-1 z-index-none">  
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-xl-5 m-sm-b30 m-xl-b0">    
                <div class="contact-box">
                    <h3 class="contact-title">Contact Information</h3>
                    <p class="contact-text">Fill up the form and our Team will get back to you within 24 hours.</p>
                    <div class="widget widget_getintuch ">
                        <ul>
                            @if (isset($args['address']) && !empty($args['address']))
                            <li>
                                <i class="fa-solid fa-location-dot"></i>
                                <p>{{ $args['address'] }}</p>
                            </li>
                            @endif
                            @if (isset($args['phone']) && !empty($args['phone']))
                            <li>
                                <i class="fa-solid fa-phone"></i>
                                <p>{{ $args['phone'] }}</p>
                            </li>
                            @endif
                            @if (isset($args['email']) && !empty($args['email']))
                            <li>
                                <i class="fa-solid fa-envelope"></i>
                                <p>{{ $args['email'] }}</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                     @if(isset($args['social_icon']) && !empty($args['social_icon']))
                    <h6 class="m-b15 text-white">Our Socials</h6>
                    <div class="dz-social-icon style-1 dark">
                        <ul>
                           {!! get_social_icons('','') !!}
                        </ul>
                    </div>
                    @endif
                    <svg width="250" height="70" viewBox="0 0 250 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 38L250 0L210 70L0 38Z" fill="url(#paint0_linear_306_1296)"/>
                        <defs>
                            <linearGradient id="paint0_linear_306_1296" x1="118.877" y1="35.552" x2="250.365" y2="35.552" gradientUnits="userSpaceOnUse">
                            <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="col-md-6 col-xl-7">
                <form class="dz-form  style-1" method="POST" action="{{ route('front.contact') }}">
                    @csrf
                    <div class="dzFormMsg">{{ Session::get('success') }}</div>
                    <div class="row">
                        @if($errors->any())
                            <div class="col-12 m-b30">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>{{ __('Something') }} </strong>{{ __(' Went wrong.') }}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                        @if( Session::get('success') )
                            <div class="col-12 m-b30">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  {{ Session::get('success') }}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="input-area">
                                <label>{{ __('First Name') }} <span class="text-danger">*</span></label>
                                <div class="input-group input-line">
                                    <input name="first_name" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-area">
                                <label>{{ __('Last Name') }}</label>
                                <div class="input-group input-line">
                                    <input name="last_name" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="input-area">
                                <label>{{ __('Your Email Address') }} <span class="text-danger">*</span></label>
                                <div class="input-group input-line">
                                    <input name="email" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="input-area">
                                <label>{{ __('Phone') }} <span class="text-danger">*</span></label>
                                <div class="input-group input-line">
                                    <input name="phone_number" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="input-area">
                                <label>{{ __('Message... ') }}<span class="text-danger">*</span></label>
                                <div class="input-group input-line m-b30">
                                    <textarea name="message" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button name="submit" type="submit" value="Submit" class="btn btn-primary btn-lg btn-skew"><span>{{ __('Send Message') }}</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
