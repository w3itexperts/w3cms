<!-- Testimonials-->
<section class="{{ $args['section_class'] ?? 'content-inner-1' }} testimonial-wrapper1" data-text="{{ isset($args['background_text']) ? $args['background_text'] : 'FEEDBACK' }}" style="background-image: url({{ theme_asset('images/background/bg2.png') }}); background-position: center;">
    <div class="container">
        <div class="section-head text-center">
            <h5 class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</h5>
            <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
            <p class="wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
        </div>
        @if (isset($args['post_categories']) && !empty($args['post_categories']))
        <div class="swiper swiper-container {{ $args['base'] }} testimonial-swiper">
            <div class="swiper-wrapper">
                @php
                    $args['post_type'] = 'testimonials';
                    $blogs = HelpDesk::elementPostsByArgs($args);
                @endphp
                @forelse($blogs as $blog)
                    @php
                        $designation = CustomFieldHelper::get_custom_field_value('cpt_testimonials','designation',optional($blog)->id);
                        $rating = CustomFieldHelper::get_custom_field_value('cpt_testimonials','rating',optional($blog)->id);
                    @endphp
                <div class="swiper-slide">
                    <div class="testimonial-1">
                        <div class="testimonial-pic wow fadeInUp" data-wow-delay="0.2s">
                            <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="">
                        </div>
                        <ul class="testimonial-rating wow fadeInUp" data-wow-delay="0.4s">
                            @for ($i = 0; $i < $rating; $i++)
                                <li><i class="fa-solid fa-star"></i></li>
                            @endfor
                        </ul>
                        <div class="testimonial-info wow fadeInUp" data-wow-delay="0.6s">
                            <p class="testimonial-text">{!! $blog->content !!}</p>
                            <h4 class="testimonial-name">{{ $blog->title }}</h4> 
                            <span class="testimonial-position text-primary">{{ $designation }}</span> 
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
            @if (isset($args['pagination']) && $args['pagination'] == true  && $blogs->isNotEmpty())
            <div class="num-pagination wow fadeInUp" data-wow-delay="0.4s">
                <div class="{{ $args['base'] }}-prev btn-prev"><i class="fa-solid fa-arrow-left"></i></div>
                <div class="swiper-pagination {{ $args['base'] }}-pagination style-1"></div>
                <div class="{{ $args['base'] }}-next btn-next"><i class="fa-solid fa-arrow-right"></i></div>
            </div>
            @endif
        </div>
        @endif
    </div>
    @if ($args['avatars'])
        @php
            $avatars = explode(',', @$args['avatars']);
        @endphp
        @foreach ($avatars as $key => $image) 
            <div class="avatar{{++$key}}"><img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$image) }}" alt=""></div>
        @endforeach
    @endif
    <img class="svg-shape rotate-360" src="{{ theme_asset('images/pattern/circle-big.svg') }}" alt="">
    <img class="svg-shape-2 rotate-360" src="{{ theme_asset('images/pattern/circle-2.svg') }}" alt="">
</section>
<!-- Testimonials-->


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