{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('appmanager::common.w3apps') }}</h4>
                <span>{{ __('appmanager::common.edit_w3app') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.appmanager.index') }}">{{ __('appmanager::common.w3apps') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('appmanager::common.edit_w3app') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('appmanager::common.edit_w3app') }}</h4>
		</div>
        <div class="card-body">
            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#laraapp-edit-form"><i class="la la-home me-2"></i> {{ __('appmanager::common.w3app_form') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#attached-files"><i class="la la-user me-2"></i> {{ __('appmanager::common.attached_files') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="laraapp-edit-form" role="tabpanel">
                        <form action="{{ route('admin.appmanager.update', $w3app->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="basic-form p-2 mt-2">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">{{ __('appmanager::common.title') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="title" id="title" class="form-control MakeSlug" autocomplete="title" value="{{ old('title', $w3app->title) }}" rel="slug">
                                        @error('title')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="slug">{{ __('appmanager::common.slug') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="slug" id="slug" class="form-control" autocomplete="slug" value="{{ old('slug', $w3app->slug) }}" readonly="readonly">
                                        @error('slug')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="author">{{ __('appmanager::common.author') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="author" id="author" class="form-control" autocomplete="author" value="{{ old('author', $w3app->author) }}">
                                        @error('author')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="author_email">{{ __('appmanager::common.author_email') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="author_email" id="author_email" class="form-control" autocomplete="author_email" value="{{ old('author_email', $w3app->author_email) }}">
                                        @error('author_email')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">{{ __('appmanager::common.status') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="P" {{ old('status', $w3app->status) == 0 ? 'selected' : '' }}>Planing Mode</option>
                                            <option value="D" {{ old('status', $w3app->status) == 1 ? 'selected' : '' }}>Development Mode</option>
                                            <option value="T" {{ old('status', $w3app->status) == 2 ? 'selected' : '' }}>Testing Mode</option>
                                            <option value="L" {{ old('status', $w3app->status) == 3 ? 'selected' : '' }}>Live Mode</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="code">{{ __('appmanager::common.code') }}</label>
                                        <input type="text" name="code" id="code" class="form-control" autocomplete="code" value="{{ old('code', $w3app->code) }}">
                                        @error('code')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description">{{ __('appmanager::common.description') }}</label>
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ old('description', $w3app->description) }}</textarea>
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
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">{{ __('appmanager::common.save') }}</button>
                                        <a href="{{ route('admin.appmanager.index') }}" class="btn btn-danger">{{ __('appmanager::common.back') }}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="attached-files">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('appmanager::common.image') }}</th>
                                    <th>{{ __('appmanager::common.title') }}</th>
                                    <th>{{ __('appmanager::common.description') }}</th>
                                    <th>{{ __('appmanager::common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $w3app_files = optional($w3app)->w3app_files;
                                @endphp
                                @forelse($w3app_files as $w3app_file)
                                <tr>
                                    <td>{{ $w3app_file->file }}</td>
                                    <td>{{ $w3app_file->title }}</td>
                                    <td>{{ $w3app_file->detail }}</td>
                                    <td>
                                        <a href="{{ route('admin.appmanager.edit_w3app_file', $w3app_file->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil-alt"></i></a>
                                        <a href="{{ route('admin.appmanager.delete_w3app_file', $w3app_file->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">
                                           {{ __('appmanager::common.no_record_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
	</div>

</div>

@endsection