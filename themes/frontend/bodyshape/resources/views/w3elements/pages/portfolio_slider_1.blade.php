<!-- Our Portfolio -->
@if (isset($args['post_categories']) && !empty($args['post_categories']))
@php
    $box = 1;
    $args['post_type'] = 'portfolios';
    $blogs = HelpDesk::elementPostsByArgs($args);

@endphp
<section class="{{ $args['section_class'] ?? 'content-inner' }} portfolio-wrapper">
    <div class="portfolio-wrapper-inner">
        <div class="container-fluid portfolio-slider p-0">
            <div class="swiper swiper-container {{ $args['base'] }}">
                <div class="swiper-wrapper">
                    @forelse($blogs as $blog)
                        <div class="swiper-slide">
                            <div class="dz-box box-{{ $box = ($box > 3) ? 1 : $box }} style-1">
                                <div class="dz-media">
                                    <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="">
                                    </a>
                                </div>
                                <div class="dz-info">
                                    <h3 class="title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ $blog->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                        @php
                            $box++;
                        @endphp
                    @empty
                    @endforelse
                </div>
                @if (isset($args['show_pagination']) && $args['show_pagination'] == 'true' && $blogs->isNotEmpty())
                <div class="container">
                    <div class="num-pagination">
                        <div class="{{ $args['base'] }}-prev btn-prev dark"><i class="fa-solid fa-arrow-left"></i></div>
                        <div class="swiper-pagination {{ $args['base'] }}-pagination dark style-1 m-lr-lg"></div>
                        <div class="{{ $args['base'] }}-next btn-next dark"><i class="fa-solid fa-arrow-right"></i></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <svg class="shape-up" width="635" height="107" viewBox="0 0 635 107" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M577 0L-16 107L635 45L577 0Z" fill="var(--primary-dark)"/>
    </svg>
    <svg class="shape-down" width="673" height="109" viewBox="0 0 673 109" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M682 0L0 56L682 109V0Z" fill="var(--primary)"/>
    </svg>
</section>
@endif
<!-- Our portfolio -->

@push('inline-swiper')
    <script>
        'use strict';
        var swiper_class = '{{ $args['base'] }}';
        var space_between = {{ isset($args['space_between']) ? $args['space_between'] : 0 }};
        var loop = {{ isset($args['loop']) ? $args['loop'] : 'false' }};
        var keyboard_control = {{ isset($args['keyboard_control']) ? $args['keyboard_control'] : 'false' }};
        var auto_play = {{ isset($args['auto_play']) ? $args['auto_play'] : 'false' }};
        var autoplay_delay = {{ isset($args['autoplay_delay']) ? $args['autoplay_delay'] : 1500 }};
        var slides_per_view = '{{ isset($args['slides_per_view']) ? $args['slides_per_view'] : 3 }}';
        var centered_slides = {{ isset($args['centered_slides']) ? $args['centered_slides'] : 'false' }};
        var free_mode = {{ isset($args['free_mode']) ? $args['free_mode'] : 'false' }};
        var slider_speed = {{ isset($args['speed']) ? $args['speed'] : 1000 }};
        var effect = '{{ isset($args['effect']) ? $args['effect'] : '' }}';
        
        var autoplay_enable = ((typeof auto_play != "undefined") ? { delay: autoplay_delay } : false);

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
            navigation: {
                nextEl: "."+swiper_class+"-next",
                prevEl: "."+swiper_class+"-prev",
            },
            pagination: {
                 el: "."+swiper_class+"-pagination",
                 clickable: true,
                 renderBullet: function (index, className) {
                 return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
                },
            },
        });
    </script>
@endpush
