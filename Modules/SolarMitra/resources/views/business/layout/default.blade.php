{{-- Created this file if any customization and Extends default layout of admin --}}
@extends('admin.layout.default')

@section('nav-header')
    <div class="nav-header">
        <a href="{{url('/business');}}" class="brand-logo business-brand-logo">
            <img class="logo-abbr" src="{{asset('modules/solarmitra/images/logo-icon.png')}}">
            <img class="brand-title" src="{{asset('modules/solarmitra/images/text-logo.png')}}">
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
@endsection
@section('header')
    @include('solarmitra::business.components.header')
@endsection

@section('sidebar')
    @include('solarmitra::business.components.sidebar')
@endsection

@push('inline-css')
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/tempus-dominus/tempus-dominus.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/tagify/tagify.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/lightgallery/css/lightgallery.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ theme_asset('vendor/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('modules/solarmitra/css/business-custom.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
    <script>
        var brand_select_route = '{{route('business.solarmitra.get_items_by_cat_and_brand')}}';
        @php
            $date_format_map = [
                'F j, Y'   => 'MMMM d, yyyy',
                'Y-m-d'    => 'yyyy-MM-dd',
                'd-m-Y'    => 'dd-MM-yyyy',
                'd/m/Y'    => 'dd/MM/yyyy',
                'm/d/Y'    => 'MM/dd/yyyy',
                'M d, Y'   => 'MMM dd, yyyy',
                'd M Y'    => 'dd MMM yyyy',
                'D, d M Y' => 'EEE, dd MMM yyyy',
            ];

            $time_format_map = [
                'g:i a'   => 'h:mm T',
                'g:i A'   => 'h:mm T',
                'h:i A'   => 'hh:mm T',
                'H:i:s'   => 'HH:mm:ss',
                'H:i'     => 'HH:mm',
                'h:i:s A' => 'hh:mm:ss T',
            ];

            $php_date_format = config('solarmitra.date_format', 'F j, Y');
            $php_time_format = config('solarmitra.time_format', 'g:i A');

            $js_date_format = $date_format_map[$php_date_format] ?? $php_date_format;
            $js_time_format = $time_format_map[$php_time_format] ?? $php_time_format;

            $date_format = trim($js_date_format . ' ' . $js_time_format);
        @endphp
        var date_format = '{{ $date_format }}';

    </script>
    <script src="{{ theme_asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/popper/popper.min.js') }}"></script>

    <script src="{{ theme_asset('vendor/apexchart/apexchart.js') }}"></script>

    <script src="{{ theme_asset('vendor/lightgallery/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/daterangepicker/daterangepicker.js') }}"></script>


    <script src="{{ theme_asset('vendor/tempus-dominus/tempus-dominus.min.js') }}"></script>
    <script src="{{ theme_asset('vendor/tagify/tagify.js') }}"></script>
    <script src="{{ theme_asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
@endpush

@push('inline-modals')
    <div class="custom-offcanvas-width offcanvas offcanvas-end" id="AjaxOffCanvas"  role="dialog">
        <div class="  m-auto">
            <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
            <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
        </div>
    </div>
@endpush