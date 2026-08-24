@php
    $tagObj = new \app\models\Blog();
    $tags = $tagObj->tagsWidget();
@endphp
<div class="widget widget_tag_cloud">
    <div class="widget-title">
        <h4 class="title">{{ $args['title'] ?? __('Popular Tags') }}</h4>
    </div>
    <div class="tagcloud">
        @forelse($tags as $tag)
        <a href="{{DzHelper::laraBlogTagLink($tag->id)}}"><span>{{ $tag->title }}</span></a>
        @empty
        @endforelse
    </div>
</div>
