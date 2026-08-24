@php
    $blogObj = new \app\models\Blog();
    $limit = $args['number_of_posts'] ?? 3;
    $blogs = $blogObj->recentBlogs(['limit'=>$limit]);
    $i = 0;
@endphp
<div class="widget recent-posts-entry">
    <h4 class="footer-title">{{ $args['title'] ?? __('Blog Posts') }}</h4>
    <div class="widget-post-bx">
        @forelse($blogs as $blog)
        @php $i++; @endphp
        @if ($i > 1)
            <div class="post-separator"></div>
        @endif
        <div class="widget-post clearfix">
            <div class="dz-info">
                <h6 class="title"><a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 40, ' ...') }}</a></h6>
                <span class="post-date"> 
                    @if (!empty($args['display_date']))
                    <li class="post-date">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</li>
                    @endif
                </span>
            </div>
        </div>
        
        @empty
        @endforelse
    </div>
</div>
