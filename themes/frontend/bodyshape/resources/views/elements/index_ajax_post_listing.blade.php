@forelse($blogs as $blog)
    <div class="col-lg-6 m-b30">
        <div class="dz-card style-1 overlay-shine">
            <div class="dz-media ">
                <a href="{!! DzHelper::laraBlogLink($blog->id) !!}">
                    <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                </a>
            </div>
            <div class="dz-info">
                <div class="dz-meta">
                    <ul>
                        <li class="post-author">
                            <a href="{!! DzHelper::author($blog->user_id) !!}">
                                <span>{{ __('By') }} {{ optional($blog->user)->name }}</span>
                            </a>
                        </li>
                        <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                    </ul>
                </div>
                @php
                    if($blog->visibility != 'Pu'){
                        $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                    }else {
                        $blog_visibility = '';
                    }
                @endphp
                <h4 class="title"><a href="{!! DzHelper::laraBlogLink($blog->id) !!}">{{ $blog_visibility }}{{ Str::limit($blog->title, 30, ' ...') }}</a></h4>
                <p>{{ Str::limit($blog->excerpt, 60, ' ...') }}</p>
                <a href="{!! DzHelper::laraBlogLink($blog->id) !!}" class="btn btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
            </div>
        </div>
    </div>
@empty
@endforelse