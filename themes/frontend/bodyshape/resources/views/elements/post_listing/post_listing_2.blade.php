@forelse($blogs as $blog)
<div class="col-lg-12 m-b40 card-container">
    <div class="dz-card style-1 blog-half overlay-shine m-b40">
        <div class="dz-media">
            <a href="{{DzHelper::laraBlogLink($blog->id)}}">
                <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
            </a>
        </div>
        <div class="dz-info">
            <div class="dz-meta">
                <ul>
                    <li class="post-author">
                        <a href="{{DzHelper::author($blog->user_id)}}">
                            <img src="{{ HelpDesk::user_img(optional($blog->user)->profile) }}" alt="">
                            <span>{{ __('By') }} {{ optional($blog->user)->name }}</span>
                        </a>
                    </li>
                    @if(!empty($date_on))
                    <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                    @endif
                </ul>
            </div>
            @php
                if($blog->visibility != 'Pu'){
                    $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                }else {
                    $blog_visibility = '';
                }

                $blog_title = ($post_title_length_type == 'on_words') ? Str::words($blog->title, $post_title_length, ' ...') : Str::limit($blog->title, $post_title_length, ' ...');
                $blog_excerpt = ($post_excerpt_length_type == 'on_words') ? Str::words($blog->excerpt, $post_excerpt_length, ' ...') : Str::limit($blog->excerpt, $post_excerpt_length, ' ...');
            @endphp
            <h4 class="dz-title"><a href="{{DzHelper::laraBlogLink($blog->id)}}">{{ $blog_visibility }}{{ $blog_title }}</a></h4>
            <p>{{ $blog_excerpt }}</p>
            <a href="{{DzHelper::laraBlogLink($blog->id)}}" class="btn btn-sm btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
        </div>
    </div>
</div>
@empty
@endforelse