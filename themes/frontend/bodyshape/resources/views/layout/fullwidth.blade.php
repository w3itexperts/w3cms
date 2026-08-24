@php
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- PAGE TITLE HERE -->
    <title>{{ !empty($seoMeta['title']) ? $seoMeta['title'] : config('Site.title') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Meta Tags --}}
    @include('elements.meta')
    {{-- Meta Tags --}}

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- FAVICONS ICON -->
    @if(config('ThemeOptions.favicon') && Storage::exists('public/configuration-images/'.config('ThemeOptions.favicon')))
        <link sdsdsdsd rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/configuration-images/'.config('ThemeOptions.favicon')) }}">
    @else
        <link sdsdsd rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    @endif

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{{ theme_asset('vendor/magnific-popup/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/style.css') }}">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ theme_asset('css/skin/skin-1.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body id="bg">
	<div class="page-wraper">

		@yield('content')

	</div>
	<!-- JAVASCRIPT FILES -->
	<script>var dynamicDate = "{{ config('Site.comingsoon_date') }}";</script>
    <script src="{{ theme_asset('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
    <script src="{{ theme_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
    <script src="{{ theme_asset('vendor/countdown/kinetic.js') }}"></script><!-- KINETIC JS -->
    <script src="{{ theme_asset('vendor/countdown/jquery.final-countdown.js') }}"></script><!-- COUNTDOWN JS -->
    <script src="{{ theme_asset('js/custom.js') }}"></script><!-- CUSTOM JS -->
	<script src="{{ theme_asset('js/w3cms_frontend.js') }}"></script> <!-- W3cms_Frontend JS -->
</body>
</html>
