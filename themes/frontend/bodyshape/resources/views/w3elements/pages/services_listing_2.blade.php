<!-- TRAINING CLASSESS -->
<section class="clearfix {{ $args['section_class'] ?? '' }}">
    <div class="container">
        @if (isset($args['subtitle']) && $args['title'] && $args['description'])
        <div class="section-head text-center">
            <span class="sub-title wow fadeInUp" data-wow-delay="0.2s">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</span>
            <h2 class="title wow fadeInUp" data-wow-delay="0.4s">{!! isset($args['title']) ? $args['title'] : '' !!}</h2>
            <p class="wow fadeInUp" data-wow-delay="0.6s">{!! isset($args['description']) ? $args['description'] : '' !!}</p>
        </div>
        @endif
    </div>
    <div class="fitness-classes">
        @if (isset($args['post_categories']) && !empty($args['post_categories']))
        <div class="row g-0">
            @php
                $image_direction = 'right';
                $count = 1;
                $isBlack = true;
                $args['post_type'] = 'services';
                $blogs = HelpDesk::elementPostsByArgs($args);
            @endphp
            @forelse($blogs as $key => $blog)
                @if ($image_direction == 'left')
                <div class="col-xl-3 col-md-6">
                    <div class="dz-media">
                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="">
                    </div>
                </div>
                @endif

                <div class="col-xl-3 col-md-6">
                    <div class="dz-info {{ ($isBlack) ? 'bg-secondary' : 'bg-primary' }}">
                        <div class="clearfix text-white">
                            <span class="{{ ($isBlack) ? 'text-primary' : '' }} subtitle">{{ implode(',', $blog->blog_categories->pluck('title')->toArray()) }}</span>
                            <h4 class="title text-white">{{ $blog->title }}</h4>
                            <p>{{ $blog->excerpt }}</p>
                            <a href="{{DzHelper::laraBlogLink($blog->id)}}" class="btn {{ ($isBlack) ? 'btn-primary' : 'btn-secondary' }} btn-skew"><span>{{ __('Read More') }}</span></a>
                        </div>
                    </div>
                </div>

                @if ($image_direction == 'right')
                <div class="col-xl-3 col-md-6">
                    <div class="dz-media">
                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="">
                    </div>
                </div>
                @endif
                @php
                    $count--;
                    if ($count == 0) {
                        $isBlack = !$isBlack;
                        $count = 2;
                    }
                    if (($key+1) % 2 == 0 ) {
                        $image_direction = $image_direction == 'right' ? 'left' : 'right';
                    }
                @endphp
            @empty
            @endforelse
        </div>
        @endif
    </div>
</section>
<!-- TRAINING PROGRAMS -->