<div class="container {{ $args['section_class'] ?? 'content-inner-1' }}">
    <div class="map-iframe">
        <iframe src="{{  !empty($args['iframe']) ? $args['iframe'] : '' }}"
            style="border:0; margin-bottom: -7px; width: 100%;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>