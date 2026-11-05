@php
    $args['post_type'] = 'services';
    $services = HelpDesk::elementPostsByArgs($args);
@endphp

<div class="widget service_menu_nav">
    <ul>
        @forelse ($services as $service)
            <li><a href="{{DzHelper::laraBlogLink($service->id)}}">{{$service->title}}</a> </li>
        @empty
        @endforelse
    </ul>
    <svg width="250" height="70" viewBox="0 0 250 70" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 38L250 0L210 70L0 38Z" fill="url(#paint0_linear_306_1296)"></path>
        <defs>
            <linearGradient id="paint0_linear_306_1296" x1="118.877" y1="35.552" x2="250.365" y2="35.552" gradientUnits="userSpaceOnUse">
            <stop offset="1" stop-color="var(--primary)"></stop>
            </linearGradient>
        </defs>
    </svg>
</div>