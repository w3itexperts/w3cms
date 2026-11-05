<form method="post" action="{{@$activity->id ? route('business.solarmitra.campaigns.activities.update', [$campaign, $activity]) : route('business.solarmitra.campaigns.activities.store', $campaign)}}" class="AjaxModalForm leads-modal">
    @csrf
    @method(@$activity->id ? 'PUT' : 'POST')
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" >{{ @$activity->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.activity') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body ">
        <div class="row">
            
            <div class="col-xl-12 ">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 col-form-label">{{ __('solarmitra::solarmitra.name') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', @$activity->name) }}">
                        <p class="text-danger error-text mb-0 name_error"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="channel_id" class="col-sm-4 col-form-label col-form-label-sm">{{ __('solarmitra::solarmitra.channel') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <select class="selectpicker" name="channel_id" id="channel_id" data-live-search="true">
                            <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.channel') }}</option>
                            @forelse ($channels as $key => $title)
                                <option value="{{$key}}" @selected(old('channel_id', @$activity->channel_id) == $key)>{{$title}}</option>
                            @empty
                            @endforelse
                        </select>
                        <p class="text-danger error-text mb-0 channel_id_error"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="source_id" class="col-sm-4 col-form-label col-form-label-sm">{{ __('solarmitra::solarmitra.source') }}</label>
                    <div class="col-sm-8">
                        <select class="selectpicker" name="source_id" id="source_id" data-live-search="true">
                            <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }}</option>
                            @forelse ($sources as $key => $title)
                                <option value="{{$key}}" @selected(old('source_id', @$activity->source_id) == $key)>{{$title}}</option>
                            @empty
                            @endforelse
                        </select>
                        <p class="text-danger error-text mb-0 source_id_error"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="cost" class="col-sm-4 col-form-label">{{ __('solarmitra::solarmitra.cost') }}</label>
                    <div class="col-sm-8">
                        <input type="number" step="0.01" min="0" class="form-control" name="cost" id="cost" value="{{ old('cost', @$activity->cost) }}">
                        <p class="text-danger error-text mb-0 cost_error"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="impression" class="col-sm-4 col-form-label">{{ __('solarmitra::solarmitra.impressions') }}</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" class="form-control" name="impression" id="impression" value="{{ old('impression', @$activity->impression) }}">
                        <p class="text-danger error-text mb-0 impression_error"></p>
                    </div>
                </div>
                <div class="row">
                    <label for="clicks" class="col-sm-4 col-form-label">{{ __('solarmitra::solarmitra.clicks') }}</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" class="form-control" name="clicks" id="clicks" value="{{ old('clicks', @$activity->clicks) }}">
                        <p class="text-danger error-text mb-0 clicks_error"></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
        <div class="modal-footer bg-body rounded-bottom">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
            <button type="submit" class="btn btn-primary">
                <i class="icon icon-save"></i>
                Save
            </button>
        </div>
</form>