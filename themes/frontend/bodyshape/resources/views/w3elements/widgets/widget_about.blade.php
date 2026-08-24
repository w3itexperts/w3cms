@php
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
@endphp
<div class="widget widget_about">
    <div class="footer-logo logo-dark">
        @if (($args['logo'] ?? '') == 1)
            @if ($logo_type == 'text_logo')
                <div class="text-logo">
                    @if (!empty($logo_text))
                    <h1 class="site-title">
                        <a href="{{url( '/' )}}" title="{{$logo_title}}">
                            {{$logo_text}}
                        </a>
                    </h1>
                    @endif
                </div>
            @else
                <a href="{{url( '/' )}}" title="{{$logo_title}}">
                    <img src="{{$logo}}" style="max-width: 180px;" alt="{{$logo_alt}}"/>
                </a>
            @endif
        @endif
    </div>
    <p>{!! $args['description'] ?? '' !!}</p>

    @if(($args['social_icons'] ?? '') && $show_social_icon && $footer_social_on)
    <h6 class="m-b15">{{ __('Our Socials') }}</h6>
        <div class="dz-social-icon style-1">
            <ul>
                {!! get_social_icons('','') !!}
            </ul>
        </div>
    @endif
</div>