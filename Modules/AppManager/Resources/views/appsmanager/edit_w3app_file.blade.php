@extends('admin.layout.default')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0 mb-3">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>{{ __('appmanager::common.w3apps') }}</h4>
                    <span>{{ __('appmanager::common.edit_w3app') }}</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.appmanager.index') }}">{{ __('appmanager::common.w3apps') }}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('appmanager::common.edit_w3app') }}</a></li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ __('appmanager::common.edit_attached_file') }}</h4>
            </div>
            <form action="{{ route('admin.appmanager.edit_w3app_file', $w3appFile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="title">{{ __('appmanager::common.title') }}</label>
                                <input type="text" name="title" id="title" class="form-control" autocomplete="title" value="{{ old('title', $w3appFile->title) }}">
                                @error('title')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="detail">{{ __('appmanager::common.description') }}</label>
                                <textarea name="detail" id="detail" class="form-control" cols="30" rows="10">{!! old('detail', $w3appFile->detail) !!}</textarea>
                                @error('detail')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <input type="file" name="file" id="file" multiple="multiple">
                                @error('file')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">{{ __('appmanager::common.save') }}</button>
                    <a href="{{ route('admin.appmanager.index') }}" class="btn btn-danger">{{ __('appmanager::common.back') }}</a>
                </div>
            </form>
        </div>

    </div>
@endsection
