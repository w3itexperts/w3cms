{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('appmanager::common.w3apps') }}</h4>
                <span>{{ __('appmanager::common.all_w3apps') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.appmanager.index') }}">{{ __('appmanager::common.w3apps') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('appmanager::common.all_w3apps') }}</a></li>
            </ol>
        </div>
    </div>

    <!-- row -->

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('appmanager::common.w3apps') }} {{ $type[$w3app->type] }}</h4>
                    <div>
                        @can('Controllers > W3appsController > upload_theme')
                            <a href="{{ route('admin.appmanager.upload_theme') }}" class="btn btn-primary">{{ __('appmanager::common.upload_theme') }}</a>
                        @endcan
                        @can('Controllers > W3appsController > upload_plugin')
                            <a href="{{ route('admin.appmanager.upload_plugin') }}" class="btn btn-primary">{{ __('appmanager::common.upload_plugin') }}</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6  col-md-6 col-xxl-5 ">
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                @php
                                                    $screenshots = explode(',', $w3app->screenshots);
                                                    $keywords = explode(',', $w3app->keywords);
                                                    $feature_tags = explode(',', $w3app->feature_tags);
                                                    $i = $j = 1;
                                                @endphp
                                                @if($screenshots)
                                                    @foreach($screenshots as $image)
                                                        <div role="tabpanel" class="tab-pane fade {{ $i == 1 ? 'show active' : '' }}" id="image-{{ $i++ }}">
                                                            <img class="img-fluid" src="{{ asset('storage/w3apps-files/'.$w3app->slug.'/'.$image) }}" alt="{{ $image }}">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="tab-slide-content new-arrival-product mb-4 mb-xl-0">
                                                <!-- Nav tabs -->
                                                <ul class="nav slide-item-list mt-3" role="tablist">
                                                    @if($screenshots)
                                                        @foreach($screenshots as $image)
                                                            <li role="presentation" class="{{ $i == 1 ? 'show' : '' }}">
                                                                <a href="#image-{{ $j++ }}" role="tab" data-bs-toggle="tab">
                                                                    <img class="img-fluid" src="{{ asset('storage/w3apps-files/'.$w3app->slug.'/'.$image) }}" alt="{{ $image }}" width="50">
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="mt-2 text-center">
                                                <a href="{{ $w3app->demo_link }}" class="btn btn-primary btn-sm" title="{{ __('Demo Link') }}">{{ __('Demo Link') }}</a>
                                                <a href="{{ $w3app->documentation_link }}" class="btn btn-primary btn-sm" title="{{ __('Documentation Link') }}">{{ __('Documentation Link') }}</a>
                                                <a href="{{ asset('storage/w3apps-files/'.$w3app->slug.'/'.$w3app->package_zip) }}" class="btn btn-primary btn-sm" title="{{ __('Download Package') }}">{{ __('Download Package') }}</a>
                                            </div>
                                        </div>
                                        <!--Tab slider End-->
                                        <div class="col-xl-8 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                            <div class="product-detail-content">
                                                <!--Product details-->
                                                <div class="new-arrival-content pr">
                                                    <h4>{{ $w3app->title }}</h4>
                                                    <p>{{ __('appmanager::common.author') }}: <span class="item"> {{ $w3app->author->full_name }} </span>
                                                    <p>{{ __('appmanager::common.author') }}: <span class="item"> {{ $w3app->author_email }} </span>
                                                    <p>{{ __('appmanager::common.technology_platform') }}: <span class="item"> {{ $technology_platform[$w3app->technology_platform] }} {{ $type[$w3app->type] }}</span>
                                                    <p>{{ __('appmanager::common.status') }}: <span class="item"> {{ $status[$w3app->status] }} </span>
                                                    <p>{{ __('appmanager::common.launching_date') }}: <span class="item"> {{ $w3app->launching_date }} </span>
                                                    <p>{{ __('appmanager::common.downloads') }}: <span class="item"> {{ $w3app->downloads }} </span>
                                                    </p>
                                                    <p>{{ __('appmanager::common.keywords') }}:&nbsp;&nbsp;
                                                        @if($keywords)
                                                            @foreach($keywords as $keyword)
                                                                <span class="badge badge-success">{{ $keyword }}</span>
                                                            @endforeach
                                                        @endif
                                                    </p>
                                                    <p>{{ __('appmanager::common.feature_tags') }}:&nbsp;&nbsp;
                                                        @if($feature_tags)
                                                            @foreach($feature_tags as $feature_tag)
                                                                <span class="badge badge-info">{{ $feature_tag }}</span>
                                                            @endforeach
                                                        @endif
                                                    </p>
                                                    <div class="text-content">
                                                        {!! $w3app->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection