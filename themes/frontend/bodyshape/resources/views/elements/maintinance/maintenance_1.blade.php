
@php
	$maintenance_footer_img  = config('ThemeOptions.maintenance_footer_img');
@endphp
<section class="under-construction cc" style="background-image:url({{$maintenance_bg}});background-repeat:no-repeat;background-size: cover;">
    <div class="inner-construction">
        <img class="warning-img" src="{{ $maintenence_icon }}" alt="{{ __('Warning Image') }}">
        @if(!empty($maintenance_title))
        <h1 class="dz-head">{!! $maintenance_title !!}</h1>
        @endif
        <p>{!! $maintenance_desc !!}</p>
    </div>
    <img class="shape1 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('503 Shape 1 Image') }}">
    <img class="shape2 rotate-360" src="{{ theme_asset('images/pattern/pattern1.svg') }}" alt="{{ __('503 Shape 2 Image') }}">
    <img class="shape3 dzmove1" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 3 Image') }}">
    <img class="shape4 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 4 Image') }}">
    <img class="shape5 dzmove2" src="{{ theme_asset('images/pattern/pattern2.svg') }}" alt="{{ __('503 Shape 5 Image') }}">
    @if(!empty($maintenance_footer_img))
        @if ($maintenance_footer_img && storage_path('app/public/configuration-images/'.$maintenance_footer_img))
            <img class="girl-img" src="{{asset('storage/configuration-images/'.$maintenance_footer_img)}}" alt="{{ __('Image') }} "/>
        @endif
    @endif
</section>

