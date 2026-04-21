{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('w3cpt::common.taxonomies') }}</h4>
                <span>{{ $blog->id ? __('w3cpt::common.edit_taxonomy') : __('w3cpt::common.add_taxonomy') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cpt_taxo.admin.index') }}">{{ __('w3cpt::common.taxonomies') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $blog->id ? __('w3cpt::common.edit_taxonomy') : __('w3cpt::common.add_taxonomy') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $blog->id ? __('w3cpt::common.edit_taxonomy') : __('w3cpt::common.add_new_taxonomy') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('cpt_taxo.admin.save', $blog->id) }}" method="post" id="reading-filters" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <input type="text" name="title" class="form-control" placeholder="{{ __('w3cpt::common.add_title') }}" value="{{ old('title', $blog->title) }}">
                                </div>
                            </div>
                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label class="d-block" for="cpt_tax_name">{{ __('w3cpt::common.taxonomy_name') }}<span class="text-danger">*</span></label>
													<input type="text" name="BlogMeta[cpt_tax_name]" id="cpt_tax_name" class="form-control" value="{{ old('BlogMeta[cpt_tax_name]', isset($blogMeta['cpt_tax_name']) ? $blogMeta['cpt_tax_name'] : '') }}">
                                                    <small>{{ __('w3cpt::common.taxonomy_name_description') }}<strong>{{ __('e.g. service-areas') }}</strong></small>
                                                </div>
												<div class="form-group col-md-3">
                                                    <label class="d-block" for="cpt_tax_label">{{ __('w3cpt::common.label') }}</label>
													 <input type="text" name="BlogMeta[cpt_tax_label]" id="cpt_tax_label" class="form-control" value="{{ old('BlogMeta[cpt_tax_label]', isset($blogMeta['cpt_tax_label']) ? $blogMeta['cpt_tax_label'] : '') }}">
                                                    <small>{{ __('w3cpt::common.tax_label_description') }}<strong>{{ __('e.g. Service Areas') }}</strong></small>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="d-block" for="cpt_tax_singular_name">{{ __('w3cpt::common.singular_name') }}</label>
													 <input type="text" name="BlogMeta[cpt_tax_singular_name]" id="cpt_tax_singular_name" class="form-control" value="{{ old('BlogMeta[cpt_tax_singular_name]', isset($blogMeta['cpt_tax_singular_name']) ? $blogMeta['cpt_tax_singular_name'] : '') }}">
                                                    <small>{{ __('w3cpt::common.tax_singular_name_description') }} <strong>{{ __('e.g. Service Area') }}</strong></small>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="d-block" for="cpt_tax_show_ui">{{ __('w3cpt::common.display_ui') }}</label>
													<select name="BlogMeta[cpt_tax_show_ui]" id="cpt_tax_show_ui" class="form-control">
                                                        <option value="1">{{ __('w3cpt::common.true_default') }}</option>
                                                        <option value="0" @selected(isset($blogMeta['cpt_tax_show_ui']) && $blogMeta['cpt_tax_show_ui'] == 0)>{{ __('w3cpt::common.false') }}</option>
                                                    </select>
                                                    <small>{{ __('w3cpt::common.tax_display_ui_description') }}</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('w3cpt::common.post_types') }}</label>
													<div class="row mx-0">	
													<div class="form-check custom-checkbox col-md-3">
                                                        <input type="checkbox" name="BlogMeta[cpt_tax_post_types][]" class="form-check-input" id="cpt_tax_post_types_post" value="blog" @checked(in_array('blog', $cpt_tax_post_types))> 
                                                        <label class="form-check-label" for="cpt_tax_post_types_post">{{ __('common.blogs') }}</label>
                                                    </div>
                                                    <div class="form-check custom-checkbox col-md-3">
                                                        <input type="checkbox" name="BlogMeta[cpt_tax_post_types][]" class="form-check-input" id="cpt_tax_post_types_page" value="page" @checked(in_array('page', $cpt_tax_post_types))> 
                                                        <label class="form-check-label" for="cpt_tax_post_types_page">{{ __('common.pages') }}</label>
                                                    </div>
                                                    @forelse($blogs as $blogValue)
                                                        <div class="form-check custom-checkbox col-md-3">
                                                            <input type="checkbox" name="BlogMeta[cpt_tax_post_types][]" class="form-check-input" id="cpt_tax_post_types_{{ $blogValue['cpt_name'] }}" value="{{ $blogValue['cpt_name'] }}" @checked(in_array($blogValue['cpt_name'], $cpt_tax_post_types))> 
                                                            <label class="form-check-label" for="cpt_tax_post_types_{{ $blogValue['cpt_name'] }}">{{ DzHelper::admin_lang($blogValue['cpt_label']) }}</label>
                                                        </div>
                                                    @empty
                                                    @endforelse
														</div>
                                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">{{ __('w3cpt::common.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection