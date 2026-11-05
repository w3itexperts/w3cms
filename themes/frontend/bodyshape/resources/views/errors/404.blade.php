@extends('layout.fullwidth')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
    @endphp

    @if (!empty($header_style))
        @include('elements/header/'.$header_style)
    @endif
        
    <!-- Content -->
    <div class="page-content bg-white">
        <section class="error-page" data-text="{{ __('ERROR') }}" style="background-image: url({{ $error_404_image }});">
            <div class="container">
                <div class="inner-content text-center">
                    <div class="dz_error">{{ $error_page_title }}</div>
                    <h2 class="error-head">{{ $error_page_text }}</h2>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-skew"><span>{{ $error_page_button_text }}</span></a>
                </div>
            </div>
        </section>
    </div>
    <!-- Content END-->
    <footer class="site-footer style-1 bg-img-fix footer-action" id="footer">
        @if(!empty($copyright_title))
        <!-- Footer Bottom Part -->
        <div class="container">
            <div class="footer-bottom">
                <div class="text-center">
                    <span class="copyright-text">
                        {!! $copyright_title !!}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </footer
@endsection
