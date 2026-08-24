@php
    $blogs = HelpDesk::elementPostsByArgs($args);
    if (isset($w3cms_option)) {
        extract($w3cms_option);
    }
@endphp
<!-- Our Blog -->
@if (!empty($args['sidebar']) && $args['sidebar'] == true)
<section class="{{ $args['section_class'] ?? 'content-inner' }}">
    <div class="container">
        <div class="row ">
            <div class="col-xl-8 col-lg-8">
@endif
                <div class="row masonry" id="BlogsLoadmoreContent">
                    @forelse($blogs as $blog)
                        <div class="{{ empty($sidebar) || ($layout == 'sidebar_full') ? 'col-lg-4' : 'col-lg-6'; }} card-container m-b30">
                            <div class="dz-card style-1 overlay-shine">
                                <div class="dz-media ">
                                    <a href="{{DzHelper::laraBlogLink($blog->id)}}">
                                        <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                                    </a>
                                </div>
                                <div class="dz-info">
                                    <div class="dz-meta">
                                        <ul>
                                            <li class="post-author">
                                                <a href="{{DzHelper::author($blog->user_id)}}">
                                                    <img src="{{ HelpDesk::user_img(optional($blog->user)->profile) }}" alt="">
                                                    <span>{{ __('By') }} {{ optional($blog->user)->name }}</span>
                                                </a>
                                            </li>
                                            @if(!empty($date_on))
                                            <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    @php
                                        if($blog->visibility != 'Pu'){
                                            $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                                        }else {
                                            $blog_visibility = '';
                                        }

                                        $blog_title = ($post_title_length_type == 'on_words') ? Str::words($blog->title, $post_title_length, ' ...') : Str::limit($blog->title, $post_title_length, ' ...');
                                        $blog_excerpt = ($post_excerpt_length_type == 'on_words') ? Str::words($blog->excerpt, $post_excerpt_length, ' ...') : Str::limit($blog->excerpt, $post_excerpt_length, ' ...');
                                    @endphp
                                    <h4 class="title">
                                        <a href="{{DzHelper::laraBlogLink($blog->id)}}">
                                            {{ $blog_visibility }}{{ $blog_title }}
                                        </a>
                                    </h4>
                                    <p>{{ $blog_excerpt }}</p>
                                    <a href="{{DzHelper::laraBlogLink($blog->id)}}" class="btn btn-primary btn-skew"><span>{{ __('Read More') }}</span></a>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>

                @if ($args['pagination'] ?? false)
                <!-- Blogs Pagination --> 
                <div class="d-block text-center mt-lg-4 mt-0 mb-4">
                    @if ($args['pagination_type'] == 'load_more')
                        @if ($blogs->hasMorePages())
                        <form id="W3AjaxIndexForm">
                            <input type="hidden" name="ajax_container" value="BlogsLoadmoreContent">
                            <input type="hidden" name="no_of_posts" value="{{$args['no_of_posts']}}">
                            <input type="hidden" name="page" value="2">
                            <input type="hidden" name="ajax_view" value="ajax_blog_listing">
                            <input type="hidden" name="view_name" value="index">
                            <button  class="btn btn-primary btn-skew ajax-load-more" data-form-id="W3AjaxIndexForm"><span>{{ __('Load More') }}</span></button>
                        </form>
                        @else
                        <a href="javascript:void(0);" class="btn btn-primary btn-skew disabled"><span>{{ DzHelper::theme_lang('No More Posts') }}</span></a>
                        @endif
                    @else
                    {!! $blogs->links('elements.pagination') !!}
                    @endif
                </div>
                <!-- Blogs Pagination End--> 
                @endif

@if (!empty($args['sidebar']) && $args['sidebar'] == true)
            </div>
            <div class="col-xl-4 col-lg-4">
                <aside class="side-bar sticky-top left">
                    @include('elements.sidebar')
                </aside>
            </div>
        </div>
    </div>
</section>
@endif