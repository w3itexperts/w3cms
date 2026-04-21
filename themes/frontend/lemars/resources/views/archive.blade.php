@extends('layout.default')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
    @endphp

    @include('elements.banner-inner')

    <!-- Blog Post Start -->
    <div class="section-full bg-white content-inner p-b0">
        <div class="container">
            <div class="row">
                <!-- Left sidebar area -->
                @if ( !empty($sidebar) && $show_sidebar && $layout == 'sidebar_left')
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="side-bar p-l30 sticky-top">
                        @include('elements.sidebar')
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif
                <!-- End Left sidebar area -->

                <!-- Content Side-->
                <div class="{{empty($sidebar) || !$show_sidebar || $layout == 'sidebar_full' ? 'col-sm-12' : 'col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12' }}" >
                    <div class="row masonry" id="BlogsLoadmoreContent">
                        @include('elements.post_listing.'.$post_listing_style)
                    </div>

                    <!-- Blogs Pagination --> 
                    
                    <!-- Blogs Pagination End--> 
                </div>
                <!-- End Content Side-->

                <!-- Right sidebar area -->
                @if ( !empty($sidebar) && $show_sidebar && $layout == 'sidebar_right')
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="side-bar p-r20 sticky-top">
                        @include('elements.sidebar')
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif
                <!-- End Right sidebar area -->
            </div>
        </div>
    </div>
    <!-- Blog Post End -->
@endsection
