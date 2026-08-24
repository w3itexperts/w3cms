@if($currentViewName == 'single')
    @php
        $blog_options = ThemeOption::GetBlogOptionById($blog->id);
        $post_banner_setting    = $blog_options['post_banner_setting'] ?? 'theme_default';

        if($post_banner_setting == 'custom')
        {
            $banner_image    = $blog_options['post_banner'] ?? null;
            $banner_image    = !empty($banner_image) ? asset('storage/blog-options/'.$banner_image) : theme_asset('images/banner/bg2.png');

            $banner_height   = $blog_options['post_banner_height'] ?? 'page_banner_medium';
            $custom_height   = $blog_options['post_banner_custom_height'];
            $show_breadcrumb = $blog_options['post_breadcrumb'];
        }
        else
        {
            $banner_height   = config('ThemeOptions.post_general_banner_height','page_banner_medium');
            $custom_height   = config('ThemeOptions.post_general_banner_custom_height','100');
            $banner_image    = config('ThemeOptions.post_general_banner');
            $banner_image    = !empty($banner_image) ? asset('storage/theme-options/'.$banner_image) : theme_asset('images/banner/bg2.png');
            $show_breadcrumb = config('ThemeOptions.show_breadcrumb',true);
        }

        $page_heading_classes = 'dz-bnr-inr-entry';
        $banner_class = '';
        $banner_custom_height = '';


        if($banner_height == 'page_banner_big') {
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-lg ';
            $page_heading_classes = 'dz-bnr-inr-entry';
        }else if($banner_height == 'page_banner_medium'){
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-md ';
        }else if($banner_height == 'page_banner_small'){
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-sm ';
        }else if($banner_height == 'page_banner_custom'){
            /*but you can't add height attribute here as per themeforest requirement*/
            $banner_custom_height .= $custom_height;
            $banner_class .= ' dz-bnr-inr d-flex align-items-center style-1 text-center';
        }

        $bnr_style = "style=";

        if(!empty($banner_image)) {
            $bnr_style .= 'background-image:url('.$banner_image.');';
        }
        if($banner_height == 'page_banner_custom'){
            $bnr_style .= 'height:'.$banner_custom_height.'px;';
        }

        $subTitleClass = 'sub-title';

    @endphp
    @if ($show_banner)
        <div class="dlab-bnr-inr {{ $banner_class }} m-b30" {{ $bnr_style }}>
            <div class="container">
                <div class="{{$page_heading_classes}}">
                    <h1>{{ $blog->title }}</h1>

                    @if ($show_breadcrumb)
                    <!-- Breadcrumb row -->
                    <div class="breadcrumb-row">
                        <ul class="list-inline">
                            <li><a href="{{ url('/') }}"><i class="ti-home"></i> {{ __('Home') }} </a> <i class="fas fa-chevron-right"></i></li>
                            <li>{{ $blog->title}}</li>
                        </ul>
                    </div>
                    <!-- Breadcrumb row END -->
                    @endif

                    @if ($banner_class == 'page_banner_big')
                    <span class="line"></span>
                    @endif
                </div>
            </div>
        </div>
    @endif
@else
    @php
        $header_style = isset($w3cms_option['header_style'])?$w3cms_option['header_style']:'header_1';
        $template_name = 'page_general';
        if ($currentViewName == 'page') {
            $page_options = ThemeOption::GetPageOptionById($page->id);
        }

        $page_banner_setting    = !empty($page_options['page_banner_setting'])?$page_options['page_banner_setting']:'theme_default';
        $title_prefix           = '';

        if($currentViewName == 'author'){
            $template_name  = 'author_page';
            $title_prefix   = __('Author :');
        }
        else if($currentViewName == 'search'){
            $template_name  = 'search_page';
            $title_prefix   = __('Search :');
        }
        else if($currentViewName == 'category'){
            $template_name  = 'category_page';
            $title_prefix   = __('Category :');
        }
        else if($currentViewName == 'tag'){
            $template_name  = 'tag_page';
            $title_prefix   = __('Tag :');
        }
        else if($currentViewName == 'archive'){
            $template_name  = 'archive_page';
            $title_prefix   = __('Archive :');
        }

        $page_banner_title = $page_banner_sub_title = '';

        if($page_banner_setting == 'custom')
        {
            $show_banner        = $page_options['page_banner_on'] ?? null;
            $placeholder_text	= $page_options['page_general_banner_placeholder_text'] ?? null;
            $banner_type        = $page_options['page_banner_type'] ?? null;
            $custom_height      = $page_options['page_banner_custom_height'] ?? null;
            $banner_image       = $page_options['page_banner'] ?? null;
            $banner_image       = !empty($banner_image) ? asset('storage/page-options/'.$banner_image) : theme_asset('images/banner/bg2.png');

            $banner_height            = $page_options['page_banner_height'] ?? 'page_banner_medium';
            $banner_hide            = $page_options['page_banner_hide'] ?? null;
            $page_banner_title      = $page_options['page_banner_title'] ?? null;
            $page_banner_sub_title  = $page_options['page_banner_sub_title'] ?? null;
            $show_breadcrumb    = $page_options['page_breadcrumb'] ?? null;
        }
        else
        {
            $title_prefix       = config('ThemeOptions.'.$template_name.'_title',$title_prefix);
            $show_banner        = config('ThemeOptions.'.$template_name.'_banner_on',true);
            $placeholder_text   = config('ThemeOptions.'.$template_name.'_banner_placeholder_text',null);
            $banner_type        = config('ThemeOptions.'.$template_name.'_banner_type','image');
            $banner_height      = config('ThemeOptions.'.$template_name.'_banner_height','page_banner_medium');
            $custom_height      = config('ThemeOptions.'.$template_name.'_banner_custom_height','100');
            $banner_image       = config('ThemeOptions.'.$template_name.'_banner');
            $banner_image       = !empty($banner_image) ? asset('storage/theme-options/'.$banner_image) : theme_asset('images/banner/bg2.png');
            $show_breadcrumb    = config('ThemeOptions.show_breadcrumb',true);
            $banner_hide        = config('ThemeOptions.'.$template_name.'_banner_hide');
        }

        $page_heading_classes = 'dz-bnr-inr-entry';
        $banner_class = '';

        if($banner_height == 'page_banner_big') {
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-lg ';
            $page_heading_classes = 'dz-bnr-inr-entry';
        }else if($banner_height == 'page_banner_medium'){
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-md ';
        }else if($banner_height == 'page_banner_small'){
            $banner_class .= 'dz-bnr-inr style-1 text-center dz-bnr-inr-sm ';
        }else if($banner_height == 'page_banner_custom'){
            /*but you can't add height attribute here as per themeforest requirement*/
            $banner_class .= ' dz-bnr-inr d-flex align-items-center style-1 text-center';
        }

        $bnr_style = "style=";


        if(empty($banner_hide) && !empty($banner_image)) {
            $bnr_style .= 'background-image:url('.$banner_image.');';
        }
        if($banner_height == 'page_banner_custom'){
            $bnr_style .= 'height:'.$custom_height.'px;';
        }

    @endphp

    @if ($show_banner != 0)
        <!-- Banner  -->
        <div class="{{ $banner_class }}" data-text="{{ $placeholder_text }}" {{$bnr_style}}>
            <div class="container">
                <div class="{{$page_heading_classes}}">
                    @if ($header_style == 'header_3' && !empty($page_banner_sub_title))
                    <p>{{ $page_banner_sub_title }}</p>
                    @endif
                    <h1>
                       {{ !empty($page_banner_title) ? $page_banner_title : $title_prefix.' '.$pageTitle }}
                    </h1>
                    @if ($show_breadcrumb)
                    <!-- Breadcrumb Row -->
                    <nav aria-label="breadcrumb" class="breadcrumb-row">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ !empty($page_banner_title) ? $page_banner_title : $title_prefix.' '.$pageTitle }}</li>
                        </ul>
                    </nav>
                    <!-- Breadcrumb Row End -->
                    @endif
                </div>
            </div>
        </div>
        <!-- Banner End -->
    @endif
@endif
