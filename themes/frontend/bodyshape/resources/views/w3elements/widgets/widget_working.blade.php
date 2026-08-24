<div class="widget widget_working">
    <h4 class="footer-title">{{ @$args['title'] }}</h4>
    <ul>
        @if (!empty($args['points']) && is_array($args['points']))
            @forelse ($args['points'] ?? array() as $point)
                <li>
                    @if (!empty($point['title']))    
                    <span class="days">{{@$point['title']}}</span>
                    @endif
                    @if (!empty($point['time']))
                    <span class="time"><a href="javascript:void(0);">{{@$point['time']}}</a></span>
                    @endif
                </li>
            @empty
            @endforelse
        @endif
    </ul>
    @if (@$args['button'] == 1)
        <a class="btn-link" href="{{@$args['button_url'] ?? 'javascript:void(0);'}}">{{@$args['button_text']}} <i class="fa-solid fa-arrow-right m-l10"></i></a>
    @endif
</div>