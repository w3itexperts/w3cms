@php
    $blog_view              = HelpDesk::getPostMeta(optional($blog)->id,'blog_view') ?? 0;
    $total_post_views       = $blog_start_view + $blog_view;

    if( !$show_sidebar || empty($sidebar) || $layout == 'sidebar_full')
    {
        $is_sidebar = false;
        $classes = 'col-lg-12';
    }
    else{
        $is_sidebar = true;
        $classes = 'col-xl-8 col-lg-7 mx-auto';
    }

    $classes .= $layout == "sidebar_left" ? " order-lg-1" : "";
    $container = ($is_sidebar)?'container':'min-container';
    
@endphp

<!-- Services Details Start -->
<div class="content-inner ">
    <div class="{{$container}}">
        <div class="row">
            <div class="{{ $classes }}">
                @if ($featured_image && $featured_img_on && !empty(@$blog->feature_img->value))
                <div class="dz-media m-b30">
                    <img src="{{ DzHelper::getStorageImage('storage/blog-images/'.@$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                </div>
                @endif
                <div class="dz-content">
                    <div class="m-b40">
                        @php
                            if($blog->visibility != 'Pu'){
                                $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ');
                            }else {
                                $blog_visibility = '';
                            }
                        @endphp
                        <h2>{{ $blog_visibility }}{{ $blog->title }}</h2>
                        {!! $blog->content !!}
                    </div>
                        
                    <div class="m-b40">
                        @php
                            $list_title = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'features_list_title',optional($blog)->id);
                            $list = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'features_list',optional($blog)->id);
                            $list_description = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'features_list_description',optional($blog)->id);
                        @endphp
                        @if ($list_title)
                        <h4 class="m-b15">{{$list_title}}</h4>
                        @endif
                        @if ($list)
                        <ul class="list-check-2 m-b30">
                            @forelse (explode(',', $list) as $element)
                                <li>{{$element}}</li>
                            @empty
                            @endforelse
                        </ul>
                        @endif
                        @if ($list_description)
                        <p>{{$list_description}}</p>
                        @endif
                    </div>
                    <div class="row align-items-center">
                        @php
                            $content_2_title = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'content_2_title',optional($blog)->id);
                            $content_2_description = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'content_2_description',optional($blog)->id);
                            $content_2_image = CustomFieldHelper::get_custom_field_value('cpt_'.$blog->post_type,'content_2_image',optional($blog)->id);
                        @endphp
                        <div class="{{ $content_2_image ? 'col-xl-6 m-b30' : 'col-12'}}">
                            @if ($content_2_title)
                                <h4 class="m-b10">{{$content_2_title}}</h4>
                            @endif
                            @if ($content_2_description)
                                <p class="m-b0">{!! $content_2_description !!}</p>
                            @endif
                        </div>
                        @if ($content_2_image)
                        <div class="col-xl-6 m-b30">
                            <div class="dz-media">
                                <img src="{{ DzHelper::getStorageImage('storage/custom-fields/'.$content_2_image) }}" class="img-cover" alt="">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @if($show_sidebar && !empty($sidebar) && $layout != 'sidebar_full')
            <div class="col-xl-4 col-lg-5 m-b30">
                <aside class="side-bar sticky-top {{ ($layout == "sidebar_left") ? "left" : "right" }}">
                    @php
                        $sidebar = DzHelper::getSidebar($sidebar);
                        $widgetIds = json_decode(optional($sidebar)->content);
                        $widgets = DzHelper::getSidebarWidgets($widgetIds);
                    @endphp
                    @forelse ($widgets as $widget)
                        {!! HelpDesk::shortcodeContent($widget->content,'widget') !!}
                    @empty
                    @endforelse
                </aside>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Services Details End -->