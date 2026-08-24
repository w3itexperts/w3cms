<form method="post" action="{{@$campaign->id ? route('business.solarmitra.campaigns.update',@$campaign->id) : route('business.solarmitra.campaigns.store')}}" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$campaign->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.campaign') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
                <label class="form-label"> {{ __('solarmitra::solarmitra.purpose') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="purpose" value="{{@$campaign->purpose}}">
                <p class="text-danger error-text purpose_error"></p>
                
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.channel') }} <span class="text-danger">*</span></label>
                <select name="channel_id" class="form-control">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.channel') }}</option>
                    @forelse ($channels as $slug => $title)
                        <option value="{{$slug}}" @selected(@$campaign->channel_id == $slug)>{{$title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text channel_id_error"></p>
            </div>
            <div class="col-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }} <span class="text-danger">*</span></label>
                <select name="source_id" class="form-control">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }}</option>
                    @forelse ($sources as $slug => $title)
                        <option value="{{$slug}}" @selected(@$campaign->source_id == $slug)>{{$title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text source_id_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.start_date') }} </label>
                <input type="text" class="form-control DateTimePicker" name="start_at" value="{{@$campaign->start_at ?? Carbon\Carbon::now()->format(config('solarmitra.date_time_format'))}}">
                <p class="text-danger error-text start_at_error"></p>
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.end_date') }} </label>
                <input type="text" class="form-control DateTimePicker" name="end_at" value="{{@$campaign->end_at ?? Carbon\Carbon::now()->format(config('solarmitra.date_time_format'))}}">
                <p class="text-danger error-text end_at_error"></p>
            </div>

            <div class="col-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.status') }}</label>
                <select name="status" class="form-control">
                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.status') }}</option>
                    @forelse (config('solarmitra.campaigns_status') as $key => $title)
                        <option value="{{$key}}" @selected(@$campaign->status == $key)>{{$title}}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text status_error"></p>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$campaign->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.campaign') }}</button>
        </div>
    </div>
</form>