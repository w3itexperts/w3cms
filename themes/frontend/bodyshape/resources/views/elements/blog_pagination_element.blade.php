@if ($pre_next_post_on && $post_pagination && isset($blogs) && count($blogs) > 0)
<div class="post-btn">
    <div class="prev-post">
        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blogs[0]->feature_img->value) }}" alt="{{ __('Blog Image') }}">
        <h6 class="title">
            <a href="{{ DzHelper::laraBlogLink($blogs[0]->id) }}">{{ Str::limit($blogs[0]->title, 24, '..') }}</a>
            <span class="post-date">{{ $blogs[0]->publish_on }}</span>
        </h6>
    </div>
    <div class="next-post">
        <h6 class="title">
        <a href="{{ DzHelper::laraBlogLink($blogs[1]->id) }}">{{ Str::limit($blogs[1]->title, 24, '..') }}</a>
        <span class="post-date">{{ $blogs[1]->publish_on }}</span></h6>
        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blogs[1]->feature_img->value) }}" alt="{{ __('Blog Image') }}">
    </div>
</div>
@endif