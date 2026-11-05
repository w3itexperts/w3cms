@php
    $style = '';
    if (isset($args['bg_image']) && !empty($args['bg_image']) ) {
        $style = 'style=background-image:url('.DzHelper::getStorageImage('storage/magic-editor/'.@$args['bg_image']).');background-position:center;background-size:cover';
    }
@endphp

<section class="{{ $args['section_class'] ?? 'content-inner' }}  {{ ($args['extra_top_padding'] ?? false ) ? 'about-wrapper2' : ''  }}"  {{ $style }}>
    <div class="container">
        <div class="row about-bx2 align-items-center">
            <div class="col-lg-6 about-content m-b30">
                <div class="section-head m-0">
                    <span class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : ''  }}</span>
                    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
                    <p class="m-0 wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                </div>
                @if (isset($args['show_tabs']) && $args['show_tabs'] == 'true')
                <div class="wow fadeInUp" data-wow-delay="0.8s">
                    <ul class="nav nav-tabs style-1 m-b20 m-t30">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabMission">
                                <span>{{ isset($args['tab_title_1']) ? $args['tab_title_1'] : ''  }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabVision">
                                <span>{{ isset($args['tab_title_2']) ? $args['tab_title_2'] : ''  }}</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content m-sm-b30 m-b40 p-r30" id="myTabContent">
                        <div class="tab-pane fade show active" id="tabMission" role="tabpanel">
                            <div class="content">
                                <p>{{ isset($args['tab_content_1']) ? $args['tab_content_1'] : ''  }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabVision" role="tabpanel">
                            <div class="content">
                                <p>{{ isset($args['tab_content_2']) ? $args['tab_content_2'] : ''  }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if (isset($args['show_tabs']) && $args['show_tabs'] == 'true')
                <div class="contact-us wow fadeInUp" data-wow-delay="1.2s">
                    <span class="icon"><i class="fa-solid fa-phone"></i></span>
                    <div class="content">
                        <span>{{ __('Call us for help') }}</span>
                        <h4 class="number">{{ isset($args['call_us_number']) ? $args['call_us_number'] : ''  }}</h4>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-6 m-b30">
                <div class="dz-media wow fadeInUp" data-wow-delay="0.6s">
                    <div class="image-box">
                        <div class="video-bx1 h-auto w-auto overflow-visible">
                            <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image1']) }}" alt="{{ __('image') }}">
                            @if (isset($args['video_btn']) && $args['video_btn'] == 'true')
                            <div class="video-btn sm">
                                @if (isset($args['video_btn_link']) && filter_var($args['video_btn_link'], FILTER_VALIDATE_URL) !== FALSE)
                                    <a href="{{ isset($args['video_btn_link']) ? $args['video_btn_link'] : '#'  }}" class="popup-youtube"><i class="fa fa-play"></i></a>
                                @else
                                    <a class="popup-youtube"><i class="fa fa-play"></i></a>
                                @endif 
                            </div>
                            @endif
                        </div>
                        <div class="info-box">
                            <span><i class="flaticon-play text-primary"></i> {{ isset($args['image_title_1']) ? $args['image_title_1'] : ''  }}</span>                          
                        </div>
                    </div>
                    <div class="image-box">
                        <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image2']) }}" alt="">
                        <div class="info-box">
                            <span><i class="flaticon-athletics text-primary"></i> {{ isset($args['image_title_2']) ? $args['image_title_2'] : ''  }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>