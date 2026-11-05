@php
    $blogs = HelpDesk::elementPostsByArgs($args);
@endphp
<!-- Our Blog -->
<section class="{{ $args['section_class'] ?? 'content-inner-1' }} overflow-hidden" style="background-image: url({{ theme_asset('images/background/bg1.png') }});">
    <div class="container">
        <div class="row justify-content-between align-items-center m-b10">
            <div class="col-xl-7">
                <div class="section-head text-center text-md-start">
                    <span class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</span>
                    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
                    <p class="wow fadeInUp m-0" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                </div>
            </div>

            <div class="col-xl-5 text-md-end d-flex align-items-center justify-content-xl-end justify-content-sm-between justify-content-center m-sm-b30 m-b40 wow fadeInUp" data-wow-delay="0.2s">
                @if (isset($args['pagination']) && $args['pagination'] == 'true' && $blogs->isNotEmpty())
                <div class="num-pagination">
                    <div class="{{ $args['base'] }}-prev btn-prev"><i class="fa-solid fa-arrow-left"></i></div>
                    <div class="{{ $args['base'] }}-pagination swiper-pagination style-1"></div>
                    <div class="{{ $args['base'] }}-next btn-next"><i class="fa-solid fa-arrow-right"></i></div>
                </div>
                @endif
                @if (isset($args['view_all']) && $args['view_all'] == 'true')
                <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn btn-primary btn-skew d-none d-sm-block"><span>{{ __('Show All') }}</span></a>
                @endif
            </div>
        </div>
        <div class="swiper swiper-container {{ $args['base'] }} blog-slider-wrapper">
            <div class="swiper-wrapper">
                @forelse($blogs as $blog)
                    <div class="swiper-slide wow fadeInUp" data-wow-delay="0.2s">
                        <div class="dz-card style-1 overlay-shine">
                            <div class="dz-media">
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                    <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                </a>
                            </div>
                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-author">
                                            <a href="{{ DzHelper::author($blog->user_id) }}">
                                                <img src="{{ HelpDesk::user_img(optional($blog->user)->profile) }}" alt=""> 
                                                <span>{{ __('By') }} {{ optional($blog->user)->name }}</span>
                                            </a>
                                        </li>
                                        <li class="post-date"> {{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</li>
                                    </ul>
                                </div>
                                <h4 class="dz-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h4>
                                <p>{{ Str::limit($blog->excerpt, 100, ' ...') }}</p>
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="btn btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </div>
</section>
<!-- Our Blog -->

@push('inline-swiper')
    <script>
        'use strict';
        var swiper_class = '{{ $args['base'] }}';
        var space_between = {{ isset($args['space_between']) ? $args['space_between'] : 0 }};
        var loop = {{ isset($args['loop']) ? $args['loop'] : 'false' }};
        var keyboard_control = {{ isset($args['keyboard_control']) ? $args['keyboard_control'] : 'false' }};
        var auto_play = {{ isset($args['auto_play']) ? $args['auto_play'] : 'false' }};
        var autoplay_delay = {{ isset($args['autoplay_delay']) ? $args['autoplay_delay'] : 1500 }};
        var slides_per_view = {{ isset($args['slides_per_view']) ? $args['slides_per_view'] : 1 }};
        var centered_slides = {{ isset($args['centered_slides']) ? $args['centered_slides'] : 'false' }};
        var free_mode = {{ isset($args['free_mode']) ? $args['free_mode'] : 'false' }};
        var slider_speed = {{ isset($args['speed']) ? $args['speed'] : 1000 }};
        var effect = '{{ isset($args['effect']) ? $args['effect'] : '' }}';
        
        var autoplay_enable = ((typeof auto_play != "undefined") ? { delay: autoplay_delay } : false);
        var breakpoint1 = {{ isset($args['breakpoint1']) ? $args['breakpoint1'] : 1 }};
        var breakpoint2 = {{ isset($args['breakpoint2']) ? $args['breakpoint2'] : 2 }};
        var breakpoint3 = {{ isset($args['breakpoint3']) ? $args['breakpoint3'] : 2 }};
        var breakpoint4 = {{ isset($args['breakpoint4']) ? $args['breakpoint4'] : 3 }};
        var break_points = {};

        break_points[575] = {
            slidesPerView: breakpoint1,
        };
        break_points[768] = {
            slidesPerView: breakpoint2,
        };
        break_points[992] = {
            slidesPerView: breakpoint3,
        };
        break_points[1200] = {
            slidesPerView: breakpoint4,
        };

        var swiperMain = new Swiper('.'+swiper_class, {
            speed: slider_speed,
            effect: effect,
            centeredSlides: centered_slides,
            spaceBetween: space_between,
            slidesPerView: slides_per_view,
            loop:loop,
            keyboard: keyboard_control,
            autoplay: autoplay_enable,
            freeMode: free_mode,
            breakpoints:break_points,
            navigation: {
                nextEl: "."+swiper_class+"-next",
                prevEl: "."+swiper_class+"-prev",
            },
            pagination: {
            el: "." + swiper_class + "-pagination",
            clickable: true,
            renderBullet: function (index, className) {
                if (index < 3) {
                    return '<span class="' + className + '">' + "0" + (index + 1) + "</span>";
                }
                return '';
            },
        },
        });
    </script>
@endpush