@extends('admin.layout.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('w3cpt::common.w3cpts_full') }}</h4>
                <span>{{ $blog->id ? __('w3cpt::common.edit_cpt') : __('w3cpt::common.add_new_cpt') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('cpt.admin.index') }}">{{ $blog->id ? __('w3cpt::common.edit_cpt') : __('w3cpt::common.w3cpt') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('w3cpt::common.add_new_cpt') }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $blog->id ? __('w3cpt::common.edit_cpt') : __('w3cpt::common.add_new_cpt') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('cpt.admin.save', $blog->id) }}" method="post" id="reading-filters" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <input type="text" name="title" class="form-control" placeholder="{{ __('w3cpt::common.add_title') }}" value="{{ old('title', $blog->title) }}">
                                    @error('slug')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                   
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_name">{{ __('w3cpt::common.cpt_name') }}<span class="text-danger">*</span></label>
										 <input type="text" name="BlogMeta[cpt_name]" id="cpt_name" class="form-control" value="{{ old('cpt_name', isset($blogMeta['cpt_name']) ? $blogMeta['cpt_name'] : '') }}">
										<small class="text-muted">{{ __('w3cpt::common.cpt_name_description') }} <strong>{{ __('w3cpt::common.cpt_name_exmp') }}</strong></small>
										
									</div>
								
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_label">{{ __('w3cpt::common.cpt_label') }}</label>
										<input type="text" name="BlogMeta[cpt_label]" id="cpt_label" class="form-control" value="{{ old('cpt_label', isset($blogMeta['cpt_label']) ? $blogMeta['cpt_label'] : '') }}">
										<small class="text-muted">{{ __('w3cpt::common.cpt_description') }} <strong>{{ __('w3cpt::common.cpt_label_exmp') }}</strong></small>
										
									</div>
								  
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_singular_name">{{ __('w3cpt::common.singular_name') }}</label>
										<input type="text" name="BlogMeta[cpt_singular_name]" id="cpt_singular_name" class="form-control" value="{{ old('cpt_singular_name', isset($blogMeta['cpt_singular_name']) ? $blogMeta['cpt_singular_name'] : '') }}">
										<small class="text-muted">{{ __('w3cpt::common.singular_name_description') }} <strong>{{ __('w3cpt::common.singular_name_exmp') }}</strong></small>
										
									</div>
								   
									<div class="form-group col-md-12">
										<label class="d-block" for="cpt_description">{{ __('w3cpt::common.description') }}</label>
										<textarea name="BlogMeta[cpt_description]" id="cpt_description" class="form-control h-auto" rows="4">{{ old('cpt_description', isset($blogMeta['cpt_description']) ? $blogMeta['cpt_description'] : '') }}</textarea>
										<small class="text-muted">{{ __('w3cpt::common.cpt_description_txt_description') }}</small>
									</div>
								
									<div class="col-md-12">
										<h5 class="head-sefrator">{{ __('w3cpt::common.visibility') }}</h5>
									</div>
							   
									<div class="form-group col-md-12">
										<label class="d-block" for="cpt_public">{{ __('w3cpt::common.public') }}</label>
										<select name="BlogMeta[cpt_public]" id="cpt_public" class="form-control">
											<option value="1">{{ __('w3cpt::common.true_default') }}</option>
											<option value="0" @selected(isset($blogMeta['cpt_public']) && $blogMeta['cpt_public'] == 0)>{{ __('w3cpt::common.false') }}</option>
										</select>
										<small class="text-muted">{{ __('w3cpt::common.whether_post_type_used_publicly') }}</small>
									</div>
									
									<div class="col-md-12">
										<h5 class="head-sefrator">{{ __('w3cpt::common.admin_menu_options') }}</h5>
									</div>
							   
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_show_ui">{{ __('w3cpt::common.display_ui') }}</label>
										<select name="BlogMeta[cpt_show_ui]" id="cpt_show_ui" class="form-control">
											<option value="1">{{ __('w3cpt::common.true_default') }}</option>
											<option value="0" @selected(isset($blogMeta['cpt_show_ui']) && $blogMeta['cpt_show_ui'] == 0)>{{ __('w3cpt::common.false') }}</option>
										</select>
										<small class="text-muted">{{ __('w3cpt::common.display_ui_description') }}</small>
									</div>
								   
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_show_in_menu">{{ __('w3cpt::common.show_menu') }}</label>
										<select name="BlogMeta[cpt_show_in_menu]" id="cpt_show_in_menu" class="form-control">
											<option value="1">{{ __('w3cpt::common.true_default') }}</option>
											<option value="0" @selected(isset($blogMeta['cpt_show_in_menu']) && $blogMeta['cpt_show_in_menu'] == 0)>{{ __('w3cpt::common.false') }}</option>
										</select>
										<small class="text-muted">{{ __('w3cpt::common.show_menu_description') }}</small>
									</div>
								   
									<div class="form-group col-md-4">
										<label class="d-block" for="cpt_icon_slug">{{ __('w3cpt::common.menu_icon') }}</label>
										<input type="text" name="BlogMeta[cpt_icon_slug]" id="cpt_icon_slug" class="form-control" value="{{ old('cpt_icon_slug', isset($blogMeta['cpt_icon_slug']) ? $blogMeta['cpt_icon_slug'] : '') }}" placeholder="flaticon-381-push-pin">
										<small class="text-muted">{!! __('w3cpt::common.menu_icon_description', ['MenuIcon' => '(<a href="'.theme_asset('icons/flaticon/flaticon.html').'" class="text-primary" target="__blank">'.__('w3cpt::common.menu_icons').'</a>)']) !!}
										</small>
									</div>
									<div class="col-md-12">
										<h5 class="head-sefrator">{{ __('w3cpt::common.cpt_integration') }}</h5>
									</div>
									<div class="form-group col-md-12">
										<label class="d-block" for="cpt_supports">{{ __('w3cpt::common.included_fields') }}</label>
										<div class="row mx-0">
											@forelse($screenOption['cpt_options'] as $key => $value)
											<div class="form-check custom-checkbox col-md-3">
												<input type="checkbox" name="BlogMeta[cpt_supports][]" class="form-check-input" id="cpt_{{ $key }}" value="{{ $key }}" @checked(in_array($key, $cpt_supports))> 
												<label class="form-check-label" for="cpt_{{ $key }}">{{ __('w3cpt::common.'.$value['display_title']) }}</label>
											</div>
											@empty
											@endforelse
										</div>	
										<small class="text-muted">{{ __('w3cpt::common.included_fields_description') }}</small>
									</div>
								   
									<div class="form-group col-md-12">
										<label class="d-block" for="cpt_builtin_taxonomies">{{ __('w3cpt::common.inbuilt_taxonomies') }}</label>
										<div class="row mx-0">	
											@forelse($screenOption['taxonomy_options'] as $key => $value)
											<div class="form-check custom-checkbox col-md-3">
												<input type="checkbox" name="BlogMeta[cpt_builtin_taxonomies][]" class="form-check-input" id="cpt_builtin_{{ $key }}" value="{{ $key }}" @checked(in_array($key, $cpt_builtin_taxonomies))> 
												<label class="form-check-label" for="cpt_builtin_{{ $key }}">{{ __('w3cpt::common.'.$value['display_title']) }}</label>
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
