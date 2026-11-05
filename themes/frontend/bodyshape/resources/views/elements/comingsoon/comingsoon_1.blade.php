@php
$comingsoon_page_placeholder_text = config('ThemeOptions.comingsoon_page_placeholder_text');
$comingsoon_footer_img = config('ThemeOptions.comingsoon_footer_img');


$data_text = (!empty($comingsoon_page_placeholder_text))? $comingsoon_page_placeholder_text:'';
@endphp

<!-- coming-soon-page -->
<div class="coming-soon" data-text="{{ $data_text }}" style="background-image: url({{$comingsoon_bg}})">
    <div class="inner-content">
        <div class="logo-header logo-dark">
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
                <img src="{{$logo}}" alt="{{$logo_alt}}"/>
            </a>
            @endif
        </div>
        @if(!empty($comingsoon_page_title))
        <h1 class="dz-head">{!! $comingsoon_page_title  !!}</h1>
        @endif
        @if(!empty($comingsoon_page_desc))
        <p>{!! $comingsoon_page_desc !!}</p>
        @endif

        <div class="countdown countdown-timer" data-date="{{ $comingsoon_launch_date }}">
            <div class="date clock-days">
                <div class="items-days">
                    <div id="canvas-days" class="clock-canvas"></div>
                    <p class="val">0</p>
                </div>
                <span class="type-days type-time" data-border-color="#FF8139">{{ __('Days') }}</span>
            </div>
            <div class="date clock-hours">
                <div class="items-days">
                    <div id="canvas-hours" class="clock-canvas"></div>
                    <p class="val">0</p>
                </div>
                <span class="type-hours type-time" data-border-color="#FF8139">{{ __('Hours') }}</span>
            </div>
            <div class="date clock-minutes">
                <div class="items-days">
                    <div id="canvas-minutes" class="clock-canvas"></div>
                    <p class="val">0</p>
                </div>
                <span class="type-minutes type-time" data-border-color="#FF8139">{{ __('Minutes') }}</span>
            </div>
            <div class="date clock-seconds">
                <div class="items-days">
                    <div id="canvas-seconds" class="clock-canvas"></div>
                    <p class="val">0</p>
                </div>
                <span class="type-seconds type-time" data-border-color="#FF8139">{{ __('Second') }}</span>
            </div>
        </div>

        @if(!empty($comingsoon_button_on))
            <a href="{{ $comingsoon_button_url }}" class="btn btn-primary btn-skew m-r15"><span>{{ $comingsoon_button_text }}</span></a>
        @endif
    </div>

    <img class="shape1 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('pattern 1') }}">
    <img class="shape2 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('pattern 1') }}">
    <img class="shape3 dzmove1" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('pattern 2') }}">
    <img class="shape4 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('pattern 1') }}">
    @if(!empty($comingsoon_footer_img))
        @if (is_file(storage_path('app/public/configuration-images/'.$comingsoon_footer_img)))
            <img class="girl-img" src="{{asset('storage/configuration-images/'.$comingsoon_footer_img)}}" alt="{{__('Image')}}"/>
        @endif
    @endif
</div>


<div class="modal fade inquiry-modal" id="SubscribeModal" tabindex="-1" aria-labelledby="SubscribeModal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="inquiry-adv">
            <img src="{{ theme_asset('images/banner/pic1.jpg') }}" alt="Image">
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa-solid fa-envelope"></i>
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Subscribe To Our Newsletter') }}</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="dz-subscription dzSubscribe">
                    <div class="dzSubscribeMsg"></div>
                    <div class="input-group mb-3">
                        <input name="dzName" required type="text" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="input-group mb-3">
                        <input name="dzEmail" required="required" type="email" class="form-control" placeholder="Your Email Address">
                    </div>
                    <div class="form-group text-center">
                        <button name="submit" type="submit" value="Submit" class="btn btn-dark effect">{{ __('SUBSCRIBE NOW') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
