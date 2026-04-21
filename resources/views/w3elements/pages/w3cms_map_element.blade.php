

<div class="default-el">
    <div class="w3-container">
        @if (isset($args['title']) || isset($args['view_all']) || isset($args['page_id']))
        <div class="w3-section-head text-center">
            <div class="w3-content">
                <p class="w3-sub-title">{{ isset($args['subtitle']) ? $args['subtitle'] : '' }}</p>
                <h2 class="w3-title">{{ isset($args['title']) ? $args['title'] : '' }}</h2>
                <p class="w3-description">{{ isset($args['description']) ? $args['description'] : '' }}</p>
            </div>

            <div>
                @if (isset($args['view_all']) && $args['view_all'] == 'true')
                <a href="{{ isset($args['page_id']) ? DzHelper::laraPageLink($args['page_id']) : 'javascript:void(0);' }}" class="w3-btn">{{ __('View All') }}</a>
                @endif
            </div>
        </div>
        @endif
        @if (isset($args['map_url']) && !empty($args['map_url']))
        <iframe src="{{ $args['map_url'] }}" style="width:100%" height="{{ isset($args['height']) ? $args['height'] : 400 }}" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        @endif
    </div>
</div>
