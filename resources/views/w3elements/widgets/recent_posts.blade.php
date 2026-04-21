@php
    $blogObj = new \app\models\Blog();
    $limit = $args['number_of_posts'] ?? 3;
    $blogs = $blogObj->recentBlogs(['limit'=>$limit]);
@endphp
<div class="widget widget_recent_posts">
    <h6 class="widget-title"><span>{{ $args['title'] ?? __('Recent Post') }}</span></h6>
    <div class="widget-post-bx">
        @forelse($blogs as $blog)
        <div class="widget-post">
            <div class="dlab-post-media"> 
                <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
            </div>
            <div class="dlab-post-info">
                <div class="dlab-post-header">
                    <h6 class="post-title">
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 24, ' ...') }}</a>
                    </h6>
                </div>
                <div class="dlab-post-meta">
                    <ul>
                        @if (!empty($args['display_date']))
                        <li class="post-date">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @empty
        <div>{{ __('No record found.') }}</div>
        @endforelse
    </div>
</div>