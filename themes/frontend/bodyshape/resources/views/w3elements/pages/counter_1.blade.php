<!-- Counter Sec -->
<div class="section-head text-center">
    <span class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</span>
    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
    <p class="wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
</div>
<section class="counter-wrapper1">
    <div class="container">
        <div class="counter-inner bg-dark">
            <div class="row">
                <div class="col-sm-4 col-6 m-b30 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="counter-box">
                        <h3 class="title counter">{{ isset($args['counting1']) ? $args['counting1'] : '' }}</h3>
                        <p>{{ isset($args['counting_title_1']) ? $args['counting_title_1'] : '' }}</p>
                    </div>
                </div>
                <div class="col-sm-4 col-6 m-b30 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="counter-box">
                        <h3 class="title counter">{{ isset($args['counting2']) ? $args['counting2'] : '' }}</h3>
                        <p>{{ isset($args['counting_title_2']) ? $args['counting_title_2'] : '' }}</p>
                    </div>
                </div>
                <div class="col-sm-4 col-12 m-b30 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="counter-box">
                        <h3 class="title counter">{{ isset($args['counting3']) ? $args['counting3'] : '' }}</h3>
                        <p>{{ isset($args['counting_title_3']) ? $args['counting_title_3'] : '' }}</p>
                    </div>
                </div>
            </div>
            <svg class="triangle1" width="250" height="70" viewBox="0 0 250 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M250 32L0 70L40 0L250 32Z" fill="url(#paint0_linear_58_264)"/>
                <defs>
                    <linearGradient id="paint0_linear_58_264" x1="131.123" y1="34.448" x2="-0.36495" y2="34.448" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="var(--primary-dark)"/>
                        <stop offset="1" stop-color="var(--primary)"/>
                    </linearGradient>
                </defs>
            </svg>
            <svg class="triangle2" width="250" height="71" viewBox="0 0 250 71" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 38.3735L250 0.373535L210 70.3735L0 38.3735Z" fill="url(#paint0_linear_58_261)"/>
                <defs>
                    <linearGradient id="paint0_linear_58_261" x1="118.877" y1="35.9255" x2="250.365" y2="35.9255" gradientUnits="userSpaceOnUse">
                        <stop offset="1" stop-color="var(--primary-dark)"/>
                        <stop offset="1" stop-color="var(--primary)"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <img class="man wow fadeInUp" data-wow-delay="0.8s" src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ __('image') }}">
    </div>
</section>
<!-- Counter Sec -->