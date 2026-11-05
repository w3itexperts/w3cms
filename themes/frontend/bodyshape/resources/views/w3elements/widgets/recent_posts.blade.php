@php
    $blogObj = new \app\models\Blog();
    $limit = $args['number_of_posts'] ?? 3;
    $blogs = $blogObj->recentBlogs(['limit'=>$limit]);
@endphp
<div class="widget recent-posts-entry">
    <div class="widget-title">
        <h4 class="title">{{ $args['title'] ?? __('Recent Post') }}</h4>
    </div>
    <div class="widget-post-bx">
        @forelse($blogs as $blog)
            <div class="widget-post clearfix">
                <div class="dz-media">
                    <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}" width="200" height="143">
                </div>
                <div class="dz-info">
                    <h6 class="post-title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h6>
                    <div class="dz-meta">
                        <ul>
                            @if (!empty($args['display_date']))
                            <li class="post-date">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
</div>
