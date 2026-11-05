{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('appmanager::common.w3apps') }}</h4>
                <span>{{ __('appmanager::common.add_w3app') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.appmanager.index') }}">{{ __('appmanager::common.w3apps') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('appmanager::common.add_w3app') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('appmanager::common.add_w3app') }}</h4>
		</div>
		<form action="{{ route('admin.appmanager.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
			<div class="card-body">
				<div class="basic-form">
					<div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">{{ __('appmanager::common.title') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                            <input type="text" name="title" id="title" class="form-control MakeSlug" autocomplete="title" value="{{ old('title') }}" rel="slug">
                            @error('title')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="slug">{{ __('appmanager::common.slug') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                            <input type="text" name="slug" id="slug" class="form-control slug" autocomplete="slug" value="{{ old('slug') }}" readonly="readonly">
                            @error('slug')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="author">{{ __('appmanager::common.author') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                            <input type="text" name="author" id="author" class="form-control" autocomplete="author" value="{{ old('author') }}">
                            @error('author')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="author_email">{{ __('appmanager::common.author_email') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                            <input type="text" name="author_email" id="author_email" class="form-control" autocomplete="author_email" value="{{ old('author_email') }}">
                            @error('author_email')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">{{ __('appmanager::common.status') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="D">Development Mode</option>
                                <option value="L">Live Mode</option>
                                <option value="P">Planing Mode</option>
                                <option value="T">Testing Mode</option>
                            </select>
                            @error('status')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="code">{{ __('appmanager::common.code') }}</label>
                            <input type="text" name="code" id="code" class="form-control" autocomplete="code" value="{{ old('code') }}">
                            @error('code')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">{{ __('appmanager::common.description') }}</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <input type="file" name="file[]" id="file" multiple="multiple">
                            @error('file')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
				</div>
			</div>
			<div class="card-footer text-end">
				<button type="submit" class="btn btn-primary">{{ __('appmanager::common.save') }}</button>
				<a href="{{ route('admin.appmanager.index') }}" class="btn btn-danger">{{ __('appmanager::common.back') }}</a>
			</div>
		</form>
	</div>

</div>

@endsection