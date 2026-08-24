<?php

namespace Themes\frontend\bodyshape\includes\MagicEditor;
use App\Http\Traits\DzMeSettings;
use Illuminate\Http\Request;

class ElementsClass {
    use DzMeSettings;
    
    public $theme_elements;
    public $widget_elements;

    public function __construct() {
        $this->initializeSettings();
        $this->setThemeElements();
        $this->setWidgetElements();
    }

    public function __init() {
        $this->mergeThemesElements($this->theme_elements);
        $this->mergeWidgetsElements($this->widget_elements);
    }

    public function setThemeElements() {

        /* w3cms bodyshape elements start */

        $this->theme_elements['content_box_1'] = array(
            'name' => 'Content Box 1',
            'base' => 'content_box_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/content_box_1.png'),
            'description' => '',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Background Text',
                    "id"    => "bg_text",
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Learn More Button',
                    'id'    =>  'learn_more_button',
                    'default'         =>  'true',
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page',
                    'id'    =>  'page_id',
                    'options'       =>  $this->pages,
                    'group'         =>  'General',
                    'depend_on'     =>  'learn_more_button'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Btn Text',
                    "id"    => "btn_text",
                    "group"         => 'General',
                    'depend_on'     =>  'learn_more_button'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"       => 'Section Image',
                    "id"    => "image",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Background Image',
                    "id"            => "background_image",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Video btn',
                    'id'    => 'video_btn',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Video Btn Link',
                    "id"    => "video_btn_link",
                    "group"         => 'Advance',
                    'depend_on'     => 'video_btn'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Clients Logo',
                    'id'    => 'clients_logo',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Clients Logo Title',
                    "id"    => "clients_logo_title",
                    'depend_on'     => 'clients_logo',
                    "group"         => 'Advance',
                ),
                array(
                    'type'      => 'group',
                    'default'     => '',
                    "title"     => 'Add More Logo Images',
                    'id'        => 'clients_logo_images',
                    'depend_on' => 'clients_logo',
                    'group'     => 'Logo',
                    'params' => array(
                        array(
                            "type"      => "media",
                            "class"     => "",
                            "title"     => 'Upload Logo Image',
                            "id"        => "logo_image",
                        ),
                    ),
                ),
            )
        );

        $this->theme_elements['content_box_2'] = array(
            'name' => 'Content Box 2',
            'base' => 'content_box_2',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/content_box_2.png'),
            'description' => 'Shows Section of contact.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Section Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Learn More Button',
                    'id'    =>  'learn_more_button',
                    'default'         =>  'true',
                    'group'         =>  'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Btn Text',
                    "id"    => "btn_text",
                    "group"         => 'Advance',
                    'depend_on'     =>  'learn_more_button'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page',
                    'id'    =>  'page_id',
                    'options'       =>  $this->pages,
                    'group'         =>  'Advance',
                    'depend_on'     =>  'learn_more_button'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Image Title Big',
                    "id"    => "image_title_big",
                    "group"         => 'Advance',
                    "description"   => '',
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Image Title small',
                    "id"    => "image_title_small",
                    "group"         => 'Advance',
                    "description"   => '',
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"       => 'Column Image',
                    "id"    => "image",
                    "group"         => 'Advance',
                    "description"   => '',
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Icon Box',
                    'id'    => 'show_icon_box',
                    'default'         => 'true',
                    "group"         => 'Icon Box'
                ),
                array(
                    'type' => 'group',
                    'default' => '',
                    'id' => 'icon_box',
                    "title"       => 'Add More icon Box',
                    'group' => 'Icon Box',
                    'depend_on'     => 'show_icon_box',
                    'params' => array(
                        array(
                            "type"          => "text",
                            "class"         => "",
                            "title"       => 'Title',
                            "id"    => "title",
                        ),
                        array(
                            "type"          => "media",
                            "class"         => "",
                            "title"       => 'Icon',
                            "id"    => "icon",
                            "description"   => '',
                        ),
                    )
                ),
            )
        );

        $this->theme_elements['contact_us_form_1'] = array(
            'name' => 'Contact Us 1',
            'base' => 'contact_us_form_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/contact_us_form_1.png'),
            'description' => 'Shows Section of contact.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General',
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Address',
                    "id"    => "address",
                    "group"         => 'Advance',
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'E-mail',
                    "id"    => "email",
                    "group"         => 'Advance',
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Phone Number',
                    "id"    => "phone",
                    "group"         => 'Advance',
                ),
                array(
                    'type' => 'group',
                    'default' => '',
                    'id' => 'social_icon',
                    "title"       => 'Add More Social Icon',
                    'group' => 'Social Icons',
                    'params' => array(
                        array(
                            'type'          =>  'select',
                            "class"         =>  "",
                            'title'       =>  'Select icon',
                            'id'    =>  'icon',
                            'options'         =>  $this->social_icons,
                        ),
                        array(
                            "type"          => "text",
                            "class"         => "",
                            "title"       => 'Social Icon Link',
                            "id"    => "social_link",
                        ),
                    )
                )
            )
        );

        $this->theme_elements['content_box_3'] = array(
            'name' => 'Content Box 3',
            'base' => 'content_box_3',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/content_box_3.png'),
            'description' => 'Shows About Section.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Background Image',
                    "id"            => "bg_image",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Extra Padding from Top ',
                    'id'            => 'extra_top_padding',
                    'default'       => 'true',
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Tabs',
                    'id'    => 'show_tabs',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Tab Title 1',
                    "id"    => "tab_title_1",
                    'depend_on'     => 'show_tabs',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Tab Content 1',
                    "id"    => "tab_content_1",
                    'depend_on'     => 'show_tabs',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Tab Title 2',
                    "id"    => "tab_title_2",
                    'depend_on'     => 'show_tabs',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Tab content 2',
                    "id"    => "tab_content_2",
                    'depend_on'     => 'show_tabs',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Call Us Btn',
                    'id'    => 'show_call_us',
                    'default'         => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Call Us Number',
                    "id"    => "call_us_number",
                    'depend_on'     => 'show_call_us',
                    "group"         => 'Advance',
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"       => 'Image 1',
                    "id"    => "image1",
                    "group"         => 'Image Content'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Image 1 Title',
                    "id"    => "image_title_1",
                    "group"         => 'Image Content'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Video btn',
                    'id'    => 'video_btn',
                    'default'         => 'true',
                    "group"         => 'Image Content'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Video Btn Link',
                    "id"    => "video_btn_link",
                    'depend_on'     => 'video_btn',
                    "group"         => 'Image Content',
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"       => 'Image 2',
                    "id"    => "image2",
                    "group"         => 'Image Content'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Image 2 Title',
                    "id"    => "image_title_2",
                    "group"         => 'Image Content'
                ),

            )
        );

        $this->theme_elements['counter_1'] = array(
            'name' => 'Counter',
            'base' => 'counter_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/counter_1.png'),
            'description' => 'Video Box Section.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting 1',
                    "id"    => "counting1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting Title 1',
                    "id"    => "counting_title_1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting 2',
                    "id"    => "counting2",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting Title 2',
                    "id"    => "counting_title_2",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting 3',
                    "id"    => "counting3",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Counting Title 3',
                    "id"    => "counting_title_3",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"       => 'Side Image',
                    "id"    => "image",
                    "group"         => 'Advance'
                ),
            )
        );

        $this->theme_elements['post_slider_1'] = array(
            'name' => 'Post Slider 1',
            'base' => 'post_slider_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/post_slider_1.png'),
            'description' => 'Show post slider 1.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Categories",
                    "id"    => 'post_categories',
                    "options"         => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'Slider Pagination & Navigation',
                    'id'    =>  'pagination',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'        =>    'text',
                    'title'     =>    'No. of Posts',
                    'id'  =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'       =>    'Pagination'
                ),

                array(
                    'type'          =>  'select',
                    'title'       =>  'Order By',
                    'id'    =>  'orderby',
                    'options'         =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Order',
                    'id'    =>  'order',
                    'options'         =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'       =>  'View All Button',
                    'id'    =>  'view_all',
                    'default'         =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'       =>  'Select Page for View All',
                    'id'    =>  'page_id',
                    'options'         =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Space Between (in px)",
                    "id"    => "space_between",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Keyboard control",
                    "id"    => "keyboard_control",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Auto Play",
                    "id"    => "auto_play",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Auto Play Delay Time(in .ms)",
                    "id"    => "autoplay_delay",
                    "description"   => "Note: Works when Auto Play Checked",
                    "depend_on"     => "auto_play",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Looping",
                    "id"    =>  "loop",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Slider Basic",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slides Per View",
                    "id"    => "slides_per_view",
                    "description"   => "Note: Do Not Work with Fade, cards, Cube and Flip effect.( Default is 1 )",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Centered Slides",
                    "id"    => "centered_slides",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Free Mode Slider",
                    "id"    => "free_mode",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Slider Effects",
                    "id"    =>  "effect",
                    "options"         =>  array(
                                            "fade"      =>  "Fade",
                                            "coverflow" =>  "Coverflow",
                                            "cube"      =>  "Cube",
                                            "flip"      =>  "Flip",
                                            "cards"      =>  "Cards",
                                        ),
                    "group"         =>  "Slider Advance",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Sliding Speed (in .ms)",
                    "id"    => "speed",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slider Per View on min-width 575(px).( Default is 1 )",
                    "id"    => "breakpoint1",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slider Per View on min-width 768(px).( Default is 2 )",
                    "id"    => "breakpoint2",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slider Per View on min-width 992(px).( Default is 2 )",
                    "id"    => "breakpoint3",
                    "group"         => "Responsive",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slider Per View on min-width 1200(px).( Default is 3 )",
                    "id"    => "breakpoint4",
                    "group"         => "Responsive",
                ),
            )
        );

        $this->theme_elements['services_listing_2'] = array(
            'name' => 'Services List 2',
            'base' => 'services_listing_2',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/services_listing_2.png'),
            'description' => 'Shows services Box style 2.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Services Category",
                    "id"            => "post_categories",
                    "description"   => "",
                    "options"       => $this->getCPTCategories('services'),
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "servicesContainer",
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'id'            =>  'pagination_type',
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'options'       =>  [
                        'default'   =>   'Default',
                        'load_more' =>   'Load More'
                    ],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'         =>    'text',
                    'title'        =>    'No. of Posts Per Page',
                    'id'           =>    'no_of_posts',
                    'default'      =>     $this->limit,
                    'group'        =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'View All Link',
                    'id'            =>  'view_all',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'default'       =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    "type"      =>  "select",
                    "title"     =>  "Section Spacing",
                    "id"        =>  "section_class",
                    "options"   =>  array(
                                "content-inner"   => "Content inner",
                                "content-inner-1" => "Content inner 1",
                                "content-inner-2" => "Content inner 2",
                                "content-inner-3" => "Content inner 3"
                            ),
                    "default"   =>  'content-inner',
                    "group"     =>  "Extra"
                ),
            )
        );

        $this->theme_elements['portfolio_slider_1'] = array(
            'name' => 'Portfolio Slider 1',
            'base' => 'portfolio_slider_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/portfolio_slider_1.png'),
            'description' => 'Shows portfolio slider 1.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Portfolio Category",
                    "id"            => "post_categories",
                    "description"   => "",
                    "options"       => $this->getCPTCategories('portfolios'),
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "portfoliosContainer",
                ),
                array(
                    'type'         =>    'text',
                    'title'        =>    'No. of Posts Per Page',
                    'id'           =>    'no_of_posts',
                    'default'      =>     $this->limit,
                    'group'        =>    'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'View All Link',
                    'id'            =>  'view_all',
                    'default'       =>  'true',
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'default'       =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'General',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'       => 'Show Slider Pagination & Navigation',
                    'id'    => 'show_pagination',
                    'default'         => 'true',
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Space Between (in px)",
                    "id"    => "space_between",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Keyboard control",
                    "id"    => "keyboard_control",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Auto Play",
                    "id"    => "auto_play",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Auto Play Delay Time(in .ms)",
                    "id"    => "autoplay_delay",
                    "description"   => "Note: Works when Auto Play Checked",
                    "depend_on"     => "auto_play",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Looping",
                    "id"    =>  "loop",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Slider Basic",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slides Per View",
                    "id"    => "slides_per_view",
                    "description"   => "Note: Do Not Work with Fade, cards, Cube and Flip effect.",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Centered Slides",
                    "id"    => "centered_slides",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Free Mode Slider",
                    "id"    => "free_mode",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Slider Effects",
                    "id"    =>  "effect",
                    "options"         =>  array(
                                            "fade"      =>  "Fade",
                                            "coverflow" =>  "Coverflow",
                                            "cube"      =>  "Cube",
                                            "flip"      =>  "Flip",
                                            "cards"      =>  "Cards",
                                        ),
                    "group"         =>  "Slider Advance",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Sliding Speed (in .ms)",
                    "id"    => "speed",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"      =>  "select",
                    "title"     =>  "Section Spacing",
                    "id"        =>  "section_class",
                    "options"   =>  array(
                                "content-inner"   => "Content inner",
                                "content-inner-1" => "Content inner 1",
                                "content-inner-2" => "Content inner 2",
                                "content-inner-3" => "Content inner 3"
                            ),
                    "default"   =>  'content-inner',
                    "group"     =>  "Extra"
                ),
            )
        );

        $this->theme_elements['services_listing_1'] = array(
            'name' => 'Service Listing 1',
            'base' => 'services_listing_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/services_listing_1.png'),
            'description' => 'Shows Main Banner.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Services Category",
                    "id"            => "post_categories",
                    "description"   => "",
                    "options"       => $this->getCPTCategories('services'),
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "servicesContainer",
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'id'            =>  'pagination_type',
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'options'       =>  [
                        'default'   =>   'Default',
                        'load_more' =>   'Load More'
                    ],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'         =>    'text',
                    'title'        =>    'No. of Posts Per Page',
                    'id'           =>    'no_of_posts',
                    'default'      =>     $this->limit,
                    'group'        =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'View All Link',
                    'id'            =>  'view_all',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Btn Text',
                    "id"            => "btn_text",
                    "group"         => 'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'default'       =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    "type"      =>  "select",
                    "title"     =>  "Section Spacing",
                    "id"        =>  "section_class",
                    "options"   =>  array(
                                "content-inner"   => "Content inner",
                                "content-inner-1" => "Content inner 1",
                                "content-inner-2" => "Content inner 2",
                                "content-inner-3" => "Content inner 3"
                            ),
                    "default"   =>  'content-inner',
                    "group"     =>  "Extra"
                ),
            )
        );

        $this->theme_elements['subscription_box_1'] = array(
            'name' => 'Subscription Box 1',
            'base' => 'subscription_box_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/subscription_box_1.png'),
            'description' => 'Shows subscription box.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                )
            )
        );

        $this->theme_elements['testimonial_slider_1'] = array(
            'name' => 'Testimonial Slider 1',
            'base' => 'testimonial_slider_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/testimonial_slider_1.png'),
            'description' => 'Shows Swiper Testimonial.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Subtitle',
                    "id"    => "subtitle",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Section Title',
                    "id"    => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"       => 'Section Description',
                    "id"    => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => 'Background text',
                    "id"    => "background_text",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"       => "Select Testimonial Category",
                    "id"    => "post_categories",
                    "description"   => "",
                    "options"       => $this->getCPTCategories('testimonials'),
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "testimonialsContainer",
                ),
                array(
                    "id"            => "avatars",
                    "type"          => "gallery",
                    "title"         => "Users Gallery",
                    "class"         => "",
                    "group"         => "General"
                ),
                array(
                    "type"      =>  "select",
                    "title"     =>  "Section Spacing",
                    "id"        =>  "section_class",
                    "options"   =>  array(
                                "content-inner"   => "Content inner",
                                "content-inner-1" => "Content inner 1",
                                "content-inner-2" => "Content inner 2",
                                "content-inner-3" => "Content inner 3"
                            ),
                    "default"   =>  'content-inner',
                    "group"     =>  "General"
                ),
                array(
                    'type'         =>    'text',
                    'title'        =>    'No. of Posts Per Page',
                    'id'           =>    'no_of_posts',
                    'default'      =>     $this->limit,
                    'group'        =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'View All Link',
                    'id'            =>  'view_all',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Btn Text',
                    "id"            => "btn_text",
                    "group"         => 'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Select Page',
                    'id'            =>  'page_id',
                    'default'       =>  array(),
                    'options'       =>  $this->pages,
                    'group'         =>  'Pagination',
                    'depend_on'     =>  'view_all'
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "default"        => "1",
                    "title"         => 'Slider Pagination',
                    "id"            => "pagination",
                    "group"         => 'Slider Basic'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Space Between (in px)",
                    "id"    => "space_between",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Keyboard control",
                    "id"    => "keyboard_control",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Auto Play",
                    "id"    => "auto_play",
                    "default"         => "1",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Auto Play Delay Time(in .ms)",
                    "id"    => "autoplay_delay",
                    "description"   => "Note: Works when Auto Play Checked",
                    "depend_on"     => "auto_play",
                    "group"         => "Slider Basic"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Looping",
                    "id"    =>  "loop",
                    "options"         =>  array(
                                            "true"=>"True",
                                            "false"=>"False"
                                        ),
                    "group"         =>  "Slider Basic",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Slides Per View",
                    "id"    => "slides_per_view",
                    "description"   => "Note: Do Not Work with Fade, cards, Cube and Flip effect.",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Centered Slides",
                    "id"    => "centered_slides",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"       => "Free Mode Slider",
                    "id"    => "free_mode",
                    "default"         => "1",
                    "group"         => "Slider Advance"
                ),
                array(
                    "type"          =>  "select",
                    "title"       =>  "Select Slider Effects",
                    "id"    =>  "effect",
                    "options"         =>  array(
                                            "fade"      =>  "Fade",
                                            "coverflow" =>  "Coverflow",
                                            "cube"      =>  "Cube",
                                            "flip"      =>  "Flip",
                                            "cards"      =>  "Cards",
                                        ),
                    "group"         =>  "Slider Advance",
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"       => "Sliding Speed (in .ms)",
                    "id"    => "speed",
                    "group"         => "Slider Advance"
                ),
            )
        );

        $this->theme_elements['map_1'] = array(
            'name' => 'Map 1',
            'base' => 'map_1',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/bodyshape_map_1.png'),
            'description' => 'Shows Map.',
            'css' => '',
            'params' => array(
                array(
                    'type'          =>  'text',
                    "class"         =>  "",
                    'title'       =>  'iframe link of map',
                    'id'    =>  'iframe',
                    'group'         =>  'General',
                ),
            )
        );

        $this->theme_elements['blog_listing'] = array(
            'name' => 'Blog Listing (Grid Type)',
            'base' => 'blog_listing',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/blog_listing.png'),
            'description' => 'Shows Map.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_categories',
                    "default"       => array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Show Sidebar',
                    'id'            => 'sidebar',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Fields to Display",
                    "id"            => "post_fields",
                    "default"         => array(),
                    "options"       => $this->post_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'id'            =>  'pagination_type',
                    'options'       =>  ['default'=>'Default'],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
            )
        );

        $this->theme_elements['blog_listing_2'] = array(
            'name' => 'Blog Listing (List Type)',
            'base' => 'blog_listing_2',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/themes/frontend/bodyshape/images/MagicEditor/theme-elements/bodyshape/blog_listing_2.png'),
            'description' => 'Shows Map.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Categories",
                    "id"            => 'post_categories',
                    "default"       => array(),
                    "options"       => $this->categories,
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Show Sidebar',
                    'id'            => 'sidebar',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Post With Images Only',
                    'id'            => 'post_with_images',
                    'default'       => 'true',
                    "group"         => 'Advance'
                ),
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Fields to Display",
                    "id"            => "post_fields",
                    "default"         => array(),
                    "options"       => $this->post_fields,
                    "group"         => 'Advance'
                ),
                array(
                    'type'          =>  'checkbox',
                    'title'         =>  'Pagination',
                    'id'            =>  'pagination',
                    'default'       =>  'true',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'radio',
                    'title'         =>  'Pagination Type',
                    'id'            =>  'pagination_type',
                    'options'       =>  ['default'=>'Default'],
                    'default'       =>  'load_more',
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>    'text',
                    'title'         =>    'No. of Posts Per Page',
                    'id'            =>    'no_of_posts',
                    'default'       =>     $this->limit,
                    'group'         =>    'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'Pagination'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'Pagination'
                ),
            )
        );

        /* w3cms bodyshape elements end */
    }

    public function setWidgetElements() {
        
        $this->widget_elements['widget_about'] = array(
            'name' => 'Widget About',
            'base' => 'widget_about',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Widget About.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"         => 'Description',
                    "id"            => "description",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => 'Show Logo',
                    "id"            => "logo",
                    "default"         => "1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => 'Show Social Icons',
                    "id"            => "social_icons",
                    "default"         => "1",
                    "group"         => 'General',
                    "desc"          => 'Icons were Added from Theme Options in Social Setting'
                ),
                
            )
        );

        $this->widget_elements['recent_posts_footer'] = array(
            'name' => 'Recent Posts Footer',
            'base' => 'recent_posts_footer',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Recent Posts.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Number of posts to show',
                    "id"            => "number_of_posts",
                    "group"         => 'General'
                ),
                array(
                    'type'          => 'checkbox',
                    'title'         => 'Display post date',
                    'id'            => 'display_date',
                    'default'         => 'true',
                    "group"         => 'General'
                ),
            )
        );

        $this->widget_elements['widget_locations'] = array(
            'name' => 'Widget Locations',
            'base' => 'widget_locations',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Recent Posts.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Location Title',
                    "id"            => "location_title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "textarea",
                    "class"         => "",
                    "title"         => 'Description',
                    "id"            => "description",
                    "group"         => 'General'
                ),
            )
        );

        $this->widget_elements['widget_working'] = array(
            'name' => 'Widget Working',
            'base' => 'widget_working',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Recent Posts.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    'type' => 'group',
                    'default' => '',
                    'id' => 'points',
                    "title"       => 'Add More Points',
                    'group' => 'Working Schedule Points',
                    'params' => array(
                        array(
                            'type'      =>  'text',
                            "class"     =>  "",
                            'title'     =>  'Title',
                            'id'        =>  'title',
                        ),
                        array(
                            "type"      => "text",
                            "class"     => "",
                            "title"     => 'Timing',
                            "id"        => "time",
                        ),
                    )
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => 'Show Button',
                    "id"            => "button",
                    "default"       => "1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Button Text',
                    "id"            => "button_text",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Button Url',
                    "id"            => "button_url",
                    "group"         => 'General'
                ),
            )
        );

        $this->widget_elements['widget_contact_us'] = array(
            'name' => 'Widget Contact Us',
            'base' => 'widget_contact_us',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Contact Us Widget.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Title',
                    "id"            => "title",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Number',
                    "id"            => "number",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'E-mail',
                    "id"            => "email",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "media",
                    "class"         => "",
                    "title"         => 'Icon',
                    "id"            => "icon",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "checkbox",
                    "class"         => "",
                    "title"         => 'Show Button',
                    "id"            => "button",
                    "default"       => "1",
                    "group"         => 'General'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Button Text',
                    "id"            => "button_text",
                    "group"         => 'General',
                    'depend_on'     =>  'button'
                ),
                array(
                    "type"          => "text",
                    "class"         => "",
                    "title"         => 'Button Url',
                    "id"            => "button_url",
                    "group"         => 'General',
                    'depend_on'     =>  'button'
                ),
            )
        );

        $this->widget_elements['widget_services_listing'] = array(
            'name' => 'Widget Services Listing',
            'base' => 'widget_services_listing',
            'class' => '',
            'category' => 'Bodyshape',
            'icon' => asset('/images/MagicEditor/theme-elements/global/list-items.png'),
            'description' => 'Shows Services Listing Widget.',
            'css' => '',
            'params' => array(
                array(
                    "type"          => "multi_select",
                    "class"         => "",
                    "title"         => "Select Services Category",
                    "id"            => "post_categories",
                    "description"   => "",
                    "options"       => $this->getCPTCategories('services'),
                    "group"         => "General",
                    "ajax_url"      => \url('/').'/admin/magic_editors/get_post_by_cpt_category',
                    "ajax_container"=> "servicesContainer",
                ),
                array(
                    'type'         =>    'text',
                    'title'        =>    'No. of Posts Per Page',
                    'id'           =>    'no_of_posts',
                    'default'      =>     $this->limit,
                    'group'        =>    'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order By',
                    'id'            =>  'orderby',
                    'default'       =>  array(),
                    'options'       =>  $this->orderby_options,
                    'group'         =>  'General'
                ),
                array(
                    'type'          =>  'select',
                    'title'         =>  'Order',
                    'id'            =>  'order',
                    'default'       =>  array(),
                    'options'       =>  $this->order_options,
                    'group'         =>  'General'
                ),
            )
        );
    }

}
?>