<div class="main-bnr-one">
    <div class="banner-inner" style="background-image: url({{ theme_asset('images/main-slider/slider1/bg1.jpg') }})">
        @if(isset($args['bg_text']))
            <h2 class="data-text">
                @php
                    $characters = str_split(strtoupper($args['bg_text']));
                @endphp
                @foreach($characters as $char)
                    <span>{{ $char }}</span>
                @endforeach
            </h2>
        @endif
        <div class="container">
            <div class="row banner-row">
                <div class="col-lg-6 col-md-7 col-sm-8">
                    <div class="banner-content">
                        <div class="top-content">
                            <h1 class="title wow fadeInUp" data-wow-delay="0.2s">{!! isset($args['title']) ? $args['title'] : '' !!}</h1>
                            <p class="wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                            <div class="d-flex align-items-center wow fadeInUp" data-wow-delay="0.6s">
                                @if (isset($args['learn_more_button']) && $args['learn_more_button'] == 'true' )
                                    <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn btn-skew btn-lg btn-primary shadow-primary"><span>{{ isset($args['btn_text']) ? $args['btn_text'] : 'Get Started' }}</span></a>
                                @endif
                                @if (isset($args['video_btn']) && $args['video_btn'] == 'true')
                                    <div class="video-bx4">
                                        @php
                                            $class = '';
                                            if (isset($args['video_btn_link']) && filter_var($args['video_btn_link'], FILTER_VALIDATE_URL) !== FALSE) {
                                                $class = 'popup-youtube';
                                            }
                                        @endphp    
                                        @if (isset($args['video_btn_link']) && filter_var($args['video_btn_link'], FILTER_VALIDATE_URL) !== FALSE)
                                            <a class="video-btn style-1 {{ $class }}" href="{{ isset($args['video_btn_link']) ? $args['video_btn_link'] : '' }}">
                                                <i class="fa fa-play"></i>
                                                <span class="text">{{ __('Play Video') }}</span>
                                            </a>
                                        @else
                                            <a class="video-btn style-1 {{ $class }}">
                                                <i class="fa fa-play"></i>
                                                <span class="text">{{ __('Play Video') }}</span>
                                            </a>
                                        @endif                     
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (isset($args['clients_logo']) && $args['clients_logo'] == 'true')
                            <div class="bottom-content">
                                <h4 class="partner-title wow fadeInUp" data-wow-delay="0.8s">{{ isset($args['clients_logo_title']) ? $args['clients_logo_title'] : '' }}</h4>
                                <div class="row">
                                    @if(isset($args['clients_logo_images']))
                                        @foreach($args['clients_logo_images'] as $key => $value)
                                            <div class="col-4">
                                                <div class="clients-logo wow fadeInUp" data-wow-delay="1.0s">
                                                    <img class="logo-main" src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$value['logo_image']) }}" alt="{{ __('logo_') }}{{ $key+1 }}">
                                                </div>
                                            </div>  
                                        @endforeach 
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 col-sm-4">
                    <div class="banner-media media1 anm wow fadeInRight" data-wow-delay="1s" data-speed-x="-2" data-speed-scale="-1">
                        <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" class="main-img" alt="{{ __('image') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>