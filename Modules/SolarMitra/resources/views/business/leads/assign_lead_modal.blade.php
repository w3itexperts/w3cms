<form method="post" action="{{route('business.solarmitra.leads.assign_lead',@$lead->id)}}" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ $page_title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @php
            $isDisabled = !empty(@$lead->do_not_followup) ? 'disabled' : '';
        @endphp
        <div class="">
            <div class="row mb-3">
                <label for="staff_id" class="col-sm-4 col-form-label col-form-label-sm">{{ __('solarmitra::solarmitra.assigned_to') }}</label>
                <div class="col-sm-8">
                    <select class="selectpicker" name="staff_id" id="staff_id" data-live-search="true">
                        <option value="">{{ __('solarmitra::solarmitra.select_staff') }}</option>
                        @forelse (SolarMitraHelper::getContactsList('staff') as $id => $title)
                            <option value="{{$id}}" @selected($id == @$last_follow_up->assigned_to)>{{$title}}</option>
                        @empty
                        @endforelse
                    </select>
                    <p class="text-danger error-text mb-0 staff_id_error"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="RepeatFollowUpDate" class="col-sm-4 col-form-label col-form-label-sm">Next follow-up date</label>
                <div class="col-sm-8">
                    <input class="form-control DateTimePicker" type="text" name="follow_up_date" id="RepeatFollowUpDate" {{$isDisabled}} value="{{@$last_follow_up->date_time ? @$last_follow_up->date_time : Carbon\Carbon::now()->format(config('solarmitra.date_time_format'))}}">
                    <p class="text-danger error-text mb-0 follow_up_date_error"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="RepeatFollowUpNote" class="col-sm-4 col-form-label col-form-label-sm">Next follow-up notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="1" id="RepeatFollowUpNote" {{$isDisabled}} name="follow_up_note">{{@$last_follow_up->note}}</textarea>
                    <p class="text-danger error-text mb-0 follow_up_note_error"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="RepeatFollowUpSelect" class="col-sm-4 col-form-label col-form-label-sm">Repeat follow-up</label>
                <div class="col-sm-8">
                    <select name="repeat_followup" class="selectpicker" id="RepeatFollowUpSelect" {{$isDisabled}}>
                        @forelse (config('solarmitra.repeat_followups') as $key => $title)
                            <option value="{{$key}}" @selected(old('repeat_followup',@$last_follow_up->repeat_followup) == $key)>{{$title}}</option>
                        @empty
                        @endforelse
                    </select>
                    <p class="text-danger error-text mb-0 repeat_followup_error"></p>
                </div>

            </div>

            <div class="row mb-3">
                <label for="DonotFollowToggle" class="col-sm-4 col-form-label col-form-label-sm">Do not follow-up</label>
                <div class="col-sm-8">
                    <div class="form-check form-switch d-flex gap-3 m-0 align-items-center">
                        <input class="form-check-input" type="checkbox" role="switch" name="do_not_follow_up" id="DonotFollowToggle" value="1" @checked(@$lead->do_not_followup)>
                        <div>
                            <input class="form-control " type="text" name="no_follow_up_reason" id="NoFollowUpReasonText" style="{{!empty(@$lead->do_not_followup) ? '' : 'display:none;'}}" placeholder="Do not Follow Up Reason" value="{{@$last_follow_up->note}}">
                            <p class="text-danger error-text mb-0 no_follow_up_reason_error"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="d-flex  align-items-center">
            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
        </div>
        
    </div>
</form>