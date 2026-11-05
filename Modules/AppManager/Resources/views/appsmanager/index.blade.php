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

    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->title) || request()->author_id || request()->technology_platform || request()->type || request()->status || request()->launching_date_from || request()->launching_date_to || request()->keywords || request()->feature_tags)
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                    <span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('appmanager::common.search_w3apps') }}</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    {{ html()->form('get')->route('admin.appmanager.index')->open() }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <input type="text" name="title" class="form-control" placeholder="{{ __('appmanager::common.title') }}" value="{{ old('title', request()->title) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <select name="author_id" class="form-control">
                                    <option value="">Select Author</option>
                                    @forelse($authors as $author)
                                        <option value="{{ $author->id }}" @selected(request()->author_id == $author->id)>{{ $author->full_name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="technology_platform" class="form-control">
                                    <option value="">Select Technology Platform</option>
                                    @forelse($technology_platform as $key => $value)
                                        <option value="{{ $key }}" @selected(request()->technology_platform == $key)>{{ $value }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="type" class="form-control">
                                    <option value="">Select Type</option>
                                    @forelse($type as $key => $value)
                                        <option value="{{ $key }}" @selected(request()->type == $key)>{{ $value }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    @forelse($status as $key => $value)
                                        <option value="{{ $key }}" @selected(request()->status == $key)>{{ $value }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="launching_date_from" class="form-control datetimepicker" placeholder="{{ __('appmanager::common.launching_date_from') }}" value="{{ old('launching_date', request()->launching_date_from) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="launching_date_to" class="form-control datetimepicker" placeholder="{{ __('appmanager::common.launching_date_to') }}" value="{{ old('launching_date', request()->launching_date_to) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="keywords" class="form-control" placeholder="{{ __('appmanager::common.keywords') }}" value="{{ old('keywords', request()->keywords) }}">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="feature_tags" class="form-control" placeholder="{{ __('appmanager::common.feature_tags') }}" value="{{ old('feature_tags', request()->feature_tags) }}">
                            </div>
                            <div class="col-md-3">
                                <input type="submit" name="search" value="{{ __('appmanager::common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.appmanager.index') }}" class="btn btn-danger">{{ __('appmanager::common.reset') }}</a>
                            </div>
                        </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- row -->

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('appmanager::common.w3apps') }}</h4>
                    @can('Controllers > RolesController > create')
                        <a href="{{ route('admin.appmanager.create') }}" class="btn btn-primary">{{ __('appmanager::common.add_w3app') }}</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('appmanager::common.sno') }}</th>
                                    <th>{{ __('appmanager::common.preview') }}</th>
                                    <th>{{ __('appmanager::common.title') }}</th>
                                    <th>{{ __('appmanager::common.author') }}</th>
                                    <th>{{ __('appmanager::common.technology_platform') }}</th>
                                    <th>{{ __('appmanager::common.downloads') }}</th>
                                    <th>{{ __('appmanager::common.status') }}</th>
                                    <th>{{ __('appmanager::common.launching_date') }}</th>
                                    <th>{{ __('appmanager::common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $screenshots = array();
                                @endphp
                                @forelse($w3apps as $w3app)
                                    @if($w3app->screenshots && is_array($w3app->screenshots))
                                        @foreach($w3app->screenshots as $image)
                                            @php
                                                $screenshots[] = array('src' => asset('storage/w3apps-files/'.$w3app->slug.'/'.$image));
                                            @endphp
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <img src="{{ asset('storage/w3apps-files/'.$w3app->slug.'/'.$w3app->preview_image) }}" width="100px" width="100px">
                                        </td>
                                        <td>
                                            <a href="{{ $w3app->demo_link }}">{{ $w3app->title }}</a>
                                            <br>
                                            <a href="{{ $w3app->documentation_link }}" class="badge badge-primary badge-sm">{{ __('Documentation') }}</a>
                                        </td>
                                        <td>{{ @$w3app->author->full_name }}<br>({{ $w3app->author_email }})</td>
                                        <td>{{ $technology_platform[$w3app->technology_platform] }} {{ $type[$w3app->type] }}</td>
                                        <td>{{ $w3app->downloads }}</td>
                                        <td>{{ $status[$w3app->status] }}</td>
                                        <td>{{ $w3app->launching_date }}</td>
                                        <td>
                                            <a href="{{ route('admin.appmanager.edit', $w3app->id) }}" class="btn btn-primary shadow btn-xs sharp"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="{{ route('admin.appmanager.delete', $w3app->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                            <a href="{{ route('admin.appmanager.view_w3app', $w3app->id) }}" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">{{ __('appmanager::common.no_record_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $w3apps->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('inline-scripts')
    <script>
        if(jQuery('.preview_images').length > 0)
        {
            $('.preview_images').magnificPopup({
                type: 'image',
                items: JSON.parse(jQuery('.preview_images:last').attr('rel')),
                gallery: {
                  enabled: true
                }
            });
        }
    </script>
@endpush