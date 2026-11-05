<!-- Our Services -->
<section class="{{ $args['section_class'] ?? 'content-inner' }} overflow-hidden" style="background-image: url({{ theme_asset('images/background/bg1.png') }});">
    <div class="container">
        @if (isset($args['subtitle']) || isset($args['title']) || (isset($args['view_all']) && $args['view_all'] == 'true'))
        <div class="row justify-content-between align-items-center m-b20">
            <div class="col-md-9 col-lg-8 col-xl-7">
                <div class="section-head side-line">
                    <h5 class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</h5>
                    <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
                </div>
            </div>
            <div class="col-md-3 d-none d-md-block text-md-end wow fadeInUp" data-wow-delay="0.6s">
                @if (isset($args['view_all']) && $args['view_all'] == 'true')
                    <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="btn btn-primary btn-skew"><span>{{ isset($args['btn_text']) ? $args['btn_text'] : 'Get Started' }}</span></a>
                @endif
            </div>
        </div>
        @endif
        <div class="row">
            @if (isset($args['post_categories']) && !empty($args['post_categories']))
                @php
                    $args['post_type'] = 'services';
                    $blogs = HelpDesk::elementPostsByArgs($args);
                @endphp
                @forelse($blogs as $blog)
                @php
                    $png_icon = CustomFieldHelper::get_custom_field_value('cpt_services','png_icon',optional($blog)->id);
                @endphp
                <div class="col-xl-3 col-md-6 m-b30 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="icon-bx-wraper style-1 box-hover">
                        <div class="icon-bx m-b30"> 
                            <span class="icon-cell">
                                <img src="{{ DzHelper::getStorageImage('storage/custom-fields/'.@$png_icon) }}" alt="{{ __('image') }}">
                            </span>
                        </div>
                        <div class="icon-content">
                            <h5 class="dz-title m-b10"><a href="{{DzHelper::laraBlogLink($blog->id)}}">{{ $blog->title }}</a></h5>
                            <p class="m-b25">{{ $blog->excerpt }}</p>
                            <a href="{{DzHelper::laraBlogLink($blog->id)}}" class="btn btn-primary shadow-primary btn-skew"><span>{{ __('Read More') }}</span></a>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            @endif
        </div>
    </div>
</section>
<!-- Our Services -->