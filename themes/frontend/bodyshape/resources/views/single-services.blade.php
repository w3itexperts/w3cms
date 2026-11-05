@extends('layout.default')

@section('content')
    @php
        if (isset($w3cms_option)) {
            extract($w3cms_option);
        }
        $requiredFieldIndicator = config('Discussion.name_email_require') ? DzHelper::requiredFieldIndicator() : '';
        $isRequired = config('Discussion.name_email_require') ? 'required' : '';
        $comment_author = !empty($_COOKIE['comment_author_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_author_'.config('constants.comment_cookie_hash')] : '';
        $comment_email = !empty($_COOKIE['comment_email_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_email_'.config('constants.comment_cookie_hash')] : '';
        $comment_url = !empty($_COOKIE['comment_website_'.config('constants.comment_cookie_hash')]) ? $_COOKIE['comment_website_'.config('constants.comment_cookie_hash')] : '';

        $cpt_services_layout = !empty($cpt_services_layout)?$cpt_services_layout:'style_1';
    @endphp

    @include('elements.banner-inner')
    
    @include('elements.service_template.'.$cpt_services_layout)
    
@endsection
