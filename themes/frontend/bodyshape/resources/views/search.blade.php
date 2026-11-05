@extends('layout.default')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
    @endphp

    @include('elements.banner-inner')

    <!-- Blog Post Start -->
    <div class="section-full bg-white content-inner">
        <div class="container">
            <div class="row">
                <!-- Left sidebar area -->
                @if ( !empty($sidebar) && $show_sidebar && $layout == 'sidebar_left')
                <div class="col-xl-4 col-lg-4 ">
                    <aside class="side-bar sticky-top left">
                        @include('elements.sidebar')
                    </aside>
                </div>
                @endif
                <!-- End Left sidebar area -->

                <!-- Content Side-->
                <div class="{{empty($sidebar) || !$show_sidebar || $layout == 'sidebar_full' ? 'col-sm-12' : 'col-lg-8 col-md-7 col-sm-12 col-12' }}" >
                    <div class="widget search-bx widget_search w-100">
                        <form method="get" action="{{ route('permalink.search') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-skew">
                                    <input name="s" class="form-control" placeholder="{{ __('Search..') }}" value="{{ $pageTitle }}" type="search" required>
                                </div>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary sharp radius-no"><i class="fa-solid fa-magnifying-glass scale3"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <!-- Blogs Listing --> 
                    <h4 class="m-b30">{{ __('Blogs') }}</h4>
                    <div class="row" id="BlogsLoadmoreContent">
                        @include('elements.post_listing.'.$post_listing_style)
                    </div>
                    <div class="d-block text-center mt-lg-4 mt-0 mb-4">
                        @if ($disable_ajax_pagination == 'load_more')
                            @if ($blogs->hasMorePages())
                            <form id="W3AjaxPostForm">
                                <input type="hidden" name="ajax_container" value="BlogsLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_search_blog_listing">
                                <input type="hidden" name="view_name" value="search">
                                <input type="hidden" name="search_type" value="blog">
                                <input type="hidden" name="s" value="{{$title}}">
                                <button  class="btn btn-primary btn-skew ajax-load-more" data-form-id="W3AjaxPostForm"><span>{{ __('Load More') }}</span></button>
                            </form>
                            @else
                            <a href="javascript:void(0);" class="btn btn-primary btn-skew disabled"><span>{{ DzHelper::theme_lang('No More Posts') }}</span></a>
                            @endif
                        @else
                        {!! $blogs->links('elements.pagination') !!}
                        @endif
                    </div>
                    <!-- Blogs Listing End--> 

                    <!-- Pages Listing End--> 
                    <h4 class="m-b30">{{ __('Pages') }}</h4>
                    <div class="row" id="PagesLoadmoreContent">
                        @include('elements.page_listing.page_listing_1')
                    </div>
                    <div class="d-block text-center mt-lg-4 mt-0 mb-4">
                        @if ($pages->isNotEmpty() && $disable_ajax_pagination == 'load_more')
                            @if ($pages->hasMorePages())
                            <form id="W3AjaxPageForm">
                                <input type="hidden" name="ajax_container" value="PagesLoadmoreContent">
                                <input type="hidden" name="no_of_posts" value="{{config('Reading.nodes_per_page')}}">
                                <input type="hidden" name="page" value="2">
                                <input type="hidden" name="ajax_view" value="ajax_search_page_listing">
                                <input type="hidden" name="view_name" value="search">
                                <input type="hidden" name="search_type" value="page">
                                <input type="hidden" name="s" value="{{$title}}">
                                <button class="btn btn-primary btn-skew ajax-load-more" data-form-id="W3AjaxPageForm"><span>{{ __('Load More') }}</span></button>
                            </form>
                            @else
                            <a href="javascript:void(0);" class="btn btn-primary btn-skew disabled"><span>{{ DzHelper::theme_lang('No More Posts') }}</span></a>
                            @endif
                        @else
                        {!! $pages->links('elements.pagination') !!}
                        @endif
                    </div>
                    <!-- Pages Listing End--> 
                </div>
                <!-- End Content Side-->

                <!-- Right sidebar area -->
                @if (!empty($sidebar) && $show_sidebar && $layout == 'sidebar_right')
                <div class="col-xl-4 col-lg-4 ">
                    <aside class="side-bar sticky-top right">
                        @include('elements.sidebar')
                    </aside>
                </div>
                @endif
                <!-- End Right sidebar area -->
            </div>
        </div>
    </div>
<!-- Content end -->
@endsection
