@php
    $blog_view              = HelpDesk::getPostMeta(optional($blog)->id,'blog_view') ?? 0;
    $total_post_views       = $blog_start_view + $blog_view;

	$blog_options 	        = ThemeOption::GetBlogOptionById(optional($blog)->id);
    $post_pagination        = $blog_options['post_pagination'] ?? false;

	if( !$show_sidebar || empty($sidebar) || $layout == 'sidebar_full')
	{
		$is_sidebar = false;
		$classes = 'col-xl-12 col-lg-12';
		$blog_classes = 'blog-single dz-card ';
	}
    else{
		$is_sidebar = true;
		$classes = 'col-xl-8 col-lg-8';
		$blog_classes = 'blog-single dz-card sidebar';
	}
	$container = ($is_sidebar)?'container':'min-container';
@endphp

<section class="content-inner">
	<div class="{{ $container }}">
		<div class="row">
            <!-- Left sidebar area -->
			@if ($layout == 'sidebar_left' && $show_sidebar && $is_sidebar)
            <div class="col-xl-4 col-lg-4 ">
                <aside class="side-bar sticky-top left">
                    @include('elements.sidebar')
                </aside>
            </div>
			@endif
            <!-- End Left sidebar area -->

            <!--Content Side-->
			<div class="{{ $classes }}">

                <!-- Password protected block -->
                @include('elements.password_protected_block')
                <!-- End Password protected block -->

				@if ($status == 'unlock_'.$blog->id)
                    <div class="{{ $blog_classes }}">
                        <div class="dz-media">
                            @if ($featured_image && $featured_img_on && !empty(@$blog->feature_img->value))
                            <figure class="aligncenter">
                                <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                            </figure>
                            @endif
                        </div>
                        <div class="dz-info m-b30">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-author">
                                        <a href="{!! DzHelper::author($blog->user_id) !!}">
                                            <img src="{{ HelpDesk::user_img(optional(auth()->user())->profile) }}" alt="">
                                            <span>{{ __('By') }} {{ optional($blog->user)->name }}</span>
                                        </a>
                                    </li>
                                    @if(!empty($date_on))
                                    <li class="post-date">
                                        <i class="far fa-calendar fa-fw "></i>
                                        {{ $blog->publish_on }}
                                    </li>
									@endif
                                    @if(!empty($comment_count_on))
                                    <li class="post-comment">
                                        <i class="far fa-comment-alt fa-fw"></i>
                                        @if ($comment_count_on){{ $total_comments }}@endif
                                    </li>
                                    @endif
                                    @if(!empty($blog_view_on))
                                    <li class="post-view">
                                        <a href="javascript:void(0);"><i class="far fa-eye fa-fw"></i>
                                            <span> {{  $total_post_views }} </span>
                                        </a>
                                    </li>
                                    @endif
                                    @if(!empty($category_on) && !empty($blog->blog_categories))
										<li class="post-category">
											<i class="far fa-bookmark fa-fw"></i>
                                            {{ count($blog->blog_categories) }}
										</li>
									@endif
                                </ul>
                            </div>
                            @php
                                if($blog->visibility != 'Pu'){
                                    $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                                }else {
                                    $blog_visibility = '';
                                }
                            @endphp
                            @if (!$show_banner)
                                <h3 class="dz-title">{{ $blog_visibility }}{{ $blog->title }}</h3>
                            @endif

                            {!! $blog->content !!}

                            @if(optional($blog->video)->value)
                                <div>
                                    <iframe width="420" height="345" src="{{ $blog->video->value }}"></iframe>
                                </div>
                            @endif
                            
                            <div class="dz-share-post">
                                @if ($tag_on)
                                <div class="post-tags">
                                    <h6 class="m-b0 m-r10 d-inline">{{ __('Tags:') }}</h6>
                                    @forelse($blog->blog_tags as $blog_tag)
                                    <a href="{!! DzHelper::laraBlogTagLink($blog_tag->id); !!}"><span>{{ $blog_tag->title }}</span></a>
                                    @empty
                                    {{ __('No record found.') }}
                                    @endforelse
                                </div>
                                @endif
                                @if($post_sharing_on && $show_social_icon && $social_shaing_on_post)
                                    <div class="dz-social-icon dark">
                                        <ul>
                                            {!! get_social_icons('','') !!}
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Author block element -->
                    @include('elements.author_block_element')
                    <!-- End Author block element -->

                    <!-- Blog Pagination element -->
                    @include('elements.blog_pagination_element')
                    <!-- End Blog Pagination element -->

                    <!-- Related element -->
                    @include('elements.related_blog_element')
                    <!-- End Related element -->

                    <!-- Comment list block -->
                    @include('elements.comments_block')
                    <!-- End comment list block -->

                @endif
			</div>
            <!-- End Content Side-->

            <!-- Right sidebar area -->
			@if ($layout == 'sidebar_right' && $show_sidebar && $is_sidebar)
			<div class="col-xl-4 col-lg-4 ">
                <aside class="side-bar sticky-top right">
                    @include('elements.sidebar')
                </aside>
            </div>
			@endif
            <!-- End Right sidebar area -->
		</div>
	</div>
</section>
