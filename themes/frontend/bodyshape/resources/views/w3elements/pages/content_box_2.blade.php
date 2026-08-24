<!-- About Services -->
<section class="content-inner about-wrapper1 about-bx1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 m-b30">
                <div class="dz-media ">
                    <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$args['image']) }}" alt="{{ __('image') }}" class="wow fadeInUp" data-wow-delay="0.6s">
                    <svg viewBox="0 0 596 803" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M300.08 326.885L5.89685 422.456V367.302L300.08 271.746V326.885Z" fill="url(#paint0_linear_53_55)"/>
                        <path d="M594.417 371.718L154.49 514.145V435.989L594.417 293.562V371.718Z" fill="var(--primary)"/>
                        <path d="M533.277 239.231L92.5232 382.16V376.355L533.277 233.426V239.231Z" fill="var(--primary)"/>
                        <path d="M592.417 134.076L151.663 277.02V271.215L592.417 128.271V134.076Z" fill="var(--primary)"/>
                        <path d="M593.356 109.22L107.549 266.762V260.365L593.356 102.823V109.22Z" fill="url(#paint1_linear_53_55)"/>
                        <path d="M587.358 216L3.2937 400.915L0.690552 388.073L584.755 203.158L587.358 216Z" fill="white"/>
                        <path d="M595 334.44L242.565 448.733L242.674 440.158L595 325.912V334.44Z" fill="white"/>
                        <path d="M585.356 284.285L45.7017 459.289V437.952L585.356 262.949V284.285Z" fill="var(--primary)"/>
                        <path d="M401.917 216.712L33.7017 336.125V321.574L401.917 202.161V216.712Z" fill="url(#paint2_linear_53_55)"/>
                        <path d="M595.356 178.583L74.377 347.532V326.927L595.356 157.993V178.583Z" fill="url(#paint3_linear_53_55)"/>
                        <path d="M593.387 233.927L142.253 380.233V358.896L593.387 212.606V233.927Z" fill="url(#paint4_linear_53_55)"/>
                        <path d="M437.55 288.331L65.4284 409.005V404.103L437.55 283.429V288.331Z" fill="var(--primary)"/>
                        <defs>
                            <linearGradient id="paint0_linear_53_55" x1="5.90132" y1="347.096" x2="300.081" y2="347.096" gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                            <linearGradient id="paint1_linear_53_55" x1="107.547" y1="184.797" x2="593.358" y2="184.797" gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                            <linearGradient id="paint2_linear_53_55" x1="33.7026" y1="269.142" x2="401.918" y2="269.142" gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                            <linearGradient id="paint3_linear_53_55" x1="74.3779" y1="252.758" x2="595.358" y2="252.758" gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                            <linearGradient id="paint4_linear_53_55" x1="142.26" y1="296.413" x2="593.388" y2="296.413" gradientUnits="userSpaceOnUse">
                                <stop offset="1" stop-color="var(--primary)"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <ul>
                        <li><span>{{ isset($args['image_title_big']) ? $args['image_title_big'] : '' }}</span></li>
                        <li><span>{{ isset($args['image_title_small']) ? $args['image_title_small'] : '' }}</span></li>
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 m-b30 about-content">
                <div class="section-head">
                    <span class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</span>
                    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                </div>
                <div class="row m-t40 m-sm-b20 m-b30">
                    @if (isset($args['icon_box']) && !empty($args['icon_box']))
                        @foreach($args['icon_box'] as $icon_box)
                        <div class="col-sm-6 m-sm-b20 m-b30 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon-bx-wraper style-2">
                                <div class="icon-bx"> 
                                    <span class="icon-cell">
                                        <img src="{{ DzHelper::getStorageImage('storage/magic-editor/'.@$icon_box['icon']) }}" alt="{{ __('image') }}">
                                    </span>
                                </div>
                                <div class="icon-content">
                                    <h5 class="dz-title">{{ isset($icon_box['title']) ? $icon_box['title'] : '' }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <div class="clearfix wow fadeInUp" data-wow-delay="1.0s">
                    @if (isset($args['learn_more_button']) && $args['learn_more_button'] == 'true' )
                        <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn btn-skew btn-lg btn-primary shadow-primary"><span>{{ isset($args['btn_text']) ? $args['btn_text'] : 'Get Started' }}</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Services -->