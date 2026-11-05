{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('appmanager::common.w3apps') }}</h4>
                <span>{{ __('appmanager::common.upload_theme') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.appmanager.themes') }}">{{ __('appmanager::common.w3apps') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('appmanager::common.upload_theme') }}</a></li>
            </ol>
        </div>
    </div>

	<div class="card">
		<div class="card-header">
			<h4 class="card-title">{{ __('appmanager::common.upload_theme') }}</h4>
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
                        <form action="{{ route('admin.appmanager.upload_theme', ['id' => optional($w3app)->id]) }}" method="POST">
                            @csrf
                            <div class="basic-form p-2 mt-2">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="title">{{ __('appmanager::common.title') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="title" id="title" class="form-control {{ $w3app ? '' : 'MakeSlug' }}" autocomplete="title" value="{{ old('title', optional($w3app)->title) }}" rel="{{ $w3app ? '' : 'slug' }}">
                                        @error('title')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="slug">{{ __('appmanager::common.slug') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="slug" id="slug" class="form-control" autocomplete="slug" value="{{ old('slug', optional($w3app)->slug) }}" readonly="readonly">
                                        @error('slug')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="author">{{ __('appmanager::common.author') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="author_id" class="form-control" id="Author" rel="author_email">
                                            <option value="">{{ __('appmanager::common.select_autor') }}</option>
                                            @forelse($authors as $author)
                                                <option value="{{ $author->id }}" @selected(old('author_id', optional($w3app)->author_id) == $author->id) data-author-email="{{ $author->email }}">{{ $author->full_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('author_id')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="author_email">{{ __('appmanager::common.author_email') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <input type="text" name="author_email" id="author_email" class="form-control" autocomplete="author_email" value="{{ old('author_email', optional($w3app)->author_email) }}">
                                        @error('author_email')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 form-group">
                                        <div class="dropzone dropzone-queue border" id="UploadFiles">
                                            <div class="row">
                                                <label class="col-lg-1 col-form-label">{{ __('appmanager::common.upload_files') }}:</label>
                                                <div class="col-lg-8">
                                                    <a class="dropzone-select btn btn-sm btn-primary me-2">Attach files</a>
                                                    <span class="form-text text-muted">Max file size is 2048MB.</span>
                                                    <div class="dropzone-panel mb-lg-0 mb-2">
                                                    </div>
                                                    <div class="dropzone-items wm-200px">
                                                        <div class="dropzone-item" style="display:none">
                                                            <div class="dropzone-file">
                                                                <div class="dropzone-filename">
                                                                    <span data-dz-name>some_image_file_name.jpg</span>
                                                                    <strong>(<span data-dz-size>340kb</span>)</strong>
                                                                </div>

                                                                <div class="dropzone-error" data-dz-errormessage></div>
                                                            </div>

                                                            <div class="dropzone-progress">
                                                                <div class="progress">
                                                                    <div
                                                                        class="progress-bar bg-primary"
                                                                        role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="dropzone-toolbar">
                                                                <span class="dropzone-delete" data-dz-remove><i class="fa fa-times"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="preview_image">{{ __('appmanager::common.preview') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="preview_image" class="form-control UploadFilesList" id="preview_image">
                                            <option value="">Select Preview</option>
                                        </select>
                                        <small>{{ __('Preview image should be: ') }}<strong>screenshot.png</strong></small>
                                        @error('preview_image')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="screenshots">{{ __('appmanager::common.theme_screenshots') }}</label>
                                        <select name="screenshots" class="form-control UploadFilesList" id="screenshots">
                                            <option value="">Select Screenshots</option>
                                        </select>
                                        @error('screenshots')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="package_zip">{{ __('appmanager::common.theme_package') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="package_zip" class="form-control UploadFilesList" id="package_zip">
                                            <option value="">Select Package</option>
                                        </select>
                                        @error('package_zip')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">{{ __('appmanager::common.status') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="P" @selected(old('status', optional($w3app)->status) == 'P')>Planing Mode</option>
                                            <option value="D" @selected(old('status', optional($w3app)->status) == 'D')>Development Mode</option>
                                            <option value="T" @selected(old('status', optional($w3app)->status) == 'T')>Testing Mode</option>
                                            <option value="L" @selected(old('status', optional($w3app)->status) == 'L')>Live Mode</option>
                                        </select>
                                        @error('status')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="demo_link">{{ __('appmanager::common.demo_link') }}</label>
                                        <input type="text" name="demo_link" class="form-control" id="demo_link" value="{{ old('demo_link', optional($w3app)->demo_link) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="documentation_link">{{ __('appmanager::common.documentation_link') }}</label>
                                        <input type="text" name="documentation_link" class="form-control" id="documentation_link" value="{{ old('documentation_link', optional($w3app)->documentation_link) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="launching_date">{{ __('appmanager::common.launching_date') }}</label>
                                        <input type="text" name="launching_date" class="form-control datetimepicker" id="launching_date" value="{{ old('launching_date', optional($w3app)->launching_date) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="technology_platform">{{ __('appmanager::common.technology_platform') }} {!! DzHelper::RequiredFieldIndicator() !!}</label>
                                        <select name="technology_platform" id="technology_platform" class="form-control">
                                            <option value="L" @selected(old('technology_platform', optional($w3app)->technology_platform) == 'L')>Laravel</option>
                                            <option value="PD" @selected(old('technology_platform', optional($w3app)->technology_platform) == 'PD')>Python dJango</option>
                                            <option value="C" @selected(old('technology_platform', optional($w3app)->technology_platform) == 'C')>Codeigniter</option>
                                            <option value="CK" @selected(old('technology_platform', optional($w3app)->technology_platform) == 'CK')>CakePHP</option>
                                        </select>
                                        @error('technology_platform')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="keywords">{{ __('appmanager::common.keywords') }}</label>
                                        <input type="text" name="keywords" class="form-control bootstrap-tagsinput" id="keywords" data-role="tagsinput" value="{{ old('keywords', optional($w3app)->keywords) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="feature_tags">{{ __('appmanager::common.feature_tags') }}</label>
                                        <input type="text" name="feature_tags" class="form-control bootstrap-tagsinput" id="feature_tags" data-role="tagsinput" value="{{ old('feature_tags', optional($w3app)->feature_tags) }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description">{{ __('appmanager::common.description') }}</label>
                                        <textarea name="description" id="description" class="form-control W3cmsCkeditor">{!! old('description', optional($w3app)->description) !!}</textarea>
                                        @error('description')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p>Presets</p>
                                            <button class="btn btn-outline-primary mb-2" id="AddMorePresetFields">Add More</button>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">{{ __('appmanager::common.save') }}</button>
                                        <a href="{{ route('admin.appmanager.themes') }}" class="btn btn-danger">{{ __('appmanager::common.back') }}</a>
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
                                    $w3app_files = optional($w3app)->w3app_files ?? array();
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

@push('inline-scripts')
    <script>
        handleCustomFieldInputTypeSelect() {
            // Colorpicker
            var groupedContainer = '';
            let groupedIndex = 0;

            {{-- $(document).on('change', '#customFieldInputTypeSelect', function () {

                if ($(this).val() == 'group') {

                    $('#GroupFieldsContainer').show().prop('disabled', false);
                    $('#CustomFieldFormSubPart').hide();

                    if ($('#GroupFieldsContainer .groupFieldItems').length === 0) {
                        addGroupField(groupedIndex);
                        groupedIndex++;
                    }

                    
                }else{
                    $('#GroupFieldsContainer').hide().prop('disabled', true);
                    $('#CustomFieldFormSubPart').show();
                }
            }); --}}

            $(document).on('click', '#AddMorePresetFields', function (e) {
                e.preventDefault();
                {{-- addGroupField(groupedIndex);
                groupedIndex++; --}}
            });
            $(document).on('click', '#RemoveGroupFields', function (e) {
                e.preventDefault();
                $(this).closest('.groupFieldItems').remove();
            });
        }

        handleCustomFieldInputTypeSelect();


        function addGroupField(groupedIndex) {

            var BoxCount = $('.preset-fields-box').length;
            alert(BoxCount);
            let template = '<div class="row border preset-fields-box"><div class="col-sm-6"><label for="preset_title">{{ __("Preset Title") }}</label><input type="text" name="preset_title" class="form-control" id="preset_title"></div><div class="col-sm-6"><label for="demo_link">{{ __("Preset Link") }}</label><input type="url" name="demo_link" class="form-control" id="demo_link"></div><div class="col-sm-6"><label for="preset_preview">{{ __("Preset Preview") }}</label><select name="preset_preview" class="form-control UploadFilesList" id="preset_preview"><option value="">Select Preview</option></select><small>{{ __("Preview image should be: ") }}<strong>screenshot.png</strong></small></div><div class="col-sm-6"><label for="preset_data_xml">{{ __('Preset Xml File') }}</label><select name="preset_data_xml" class="form-control UploadFilesList" id="preset_data_xml"><option value="">Select Preview</option></select></div></div>';

            {{-- let template = '<div class="row border preset-fields-box">
                                <div class="col-sm-6">
                                    <label for="preset_title">{{ __("Preset Title") }}</label>
                                    <input type="text" name="preset_title" class="form-control" id="preset_title">
                                </div>
                                <div class="col-sm-6">
                                    <label for="demo_link">{{ __("Preset Link") }}</label>
                                    <input type="url" name="demo_link" class="form-control" id="demo_link">
                                </div>
                                <div class="col-sm-6">
                                    <label for="preset_preview">{{ __("Preset Preview") }}</label>
                                    <select name="preset_preview" class="form-control UploadFilesList" id="preset_preview">
                                        <option value="">Select Preview</option>
                                    </select>
                                    <small>{{ __("Preview image should be: ") }}<strong>screenshot.png</strong></small>
                                </div>
                                <div class="col-sm-6">
                                    <label for="preset_data_xml">{{ __('Preset Xml File') }}</label>
                                    <select name="preset_data_xml" class="form-control UploadFilesList" id="preset_data_xml">
                                        <option value="">Select Preview</option>
                                    </select>
                                </div>
                            </div>'; --}}
            
            // Replace %key% with actual index
            {{-- template.find('[name]').each(function () {
                let name = $(this).attr('name');
                name = name.replace('%key%', groupedIndex);
                $(this).attr('name', name);
            }); --}}

            // Refresh aelect picker on every add item
            {{-- template.find('select').selectpicker('refresh'); --}}
            
            {{-- $('#GroupFieldsContainer').append(template); --}}
        }

    </script>
@endpush