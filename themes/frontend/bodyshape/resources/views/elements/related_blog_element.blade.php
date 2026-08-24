@if(isset($related_blogs) && !empty($related_blogs) && $related_post_on)
<div class="widget-title">
    <h4 class="title">{{ $related_post_title }}</h4>
</div>
<div class="row m-b30 m-sm-b10">
    @include('elements.post_listing.'.$post_listing_style,['blogs' => $related_blogs])
</div>
@endif
