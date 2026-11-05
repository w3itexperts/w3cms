
<div class="modal-header">
    <h5 class="modal-title">{{ isset($lead) ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.lead') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="AjaxModalForm" action="{{ isset($lead) ? route('business.solarmitra.campaigns.leads.update', [$campaign, $lead]) : route('business.solarmitra.campaigns.leads.store', $campaign) }}" method="POST">
    @csrf
    @if(isset($lead))
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                @if(isset($lead))
                     <label class="form-label">{{ __('solarmitra::solarmitra.lead') }}</label>
                     <input type="text" class="form-control" value="{{ $lead->lead->full_name }} - {{ $lead->lead->phone }}" disabled>
                     <input type="hidden" name="lead_id[]" value="{{ $lead->lead_id }}">
                 @else
                     <label class="form-label">{{ __('solarmitra::solarmitra.lead') }} <span class="text-danger">*</span></label>
                     <select name="lead_id[]" class="form-select selectpicker" multiple data-live-search="true" data-actions-box="true" required>
                         @foreach ($leads as $id => $name)
                             <option value="{{ $id }}">{{ $name }}</option>
                         @endforeach
                     </select>
                 @endif
             </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <label class="form-label">{{ __('solarmitra::solarmitra.activity') }}</label>
                <select name="campaign_activity_id" class="form-select selectpicker" data-live-search="true">
                    <option value="">{{ __('solarmitra::solarmitra.select_activity') }}</option>
                    @foreach ($activities as $id => $name)
                        <option value="{{ $id }}" {{ isset($lead) && $lead->campaign_activity_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label">{{ __('solarmitra::solarmitra.source') }}</label>
                <select name="source_id" class="form-select selectpicker" data-live-search="true">
                    <option value="">{{ __('solarmitra::solarmitra.select_source') }}</option>
                    @foreach ($sources as $id => $name)
                        <option value="{{ $id }}" {{ isset($lead) && $lead->source_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6">
                <label class="form-label">{{ __('solarmitra::solarmitra.assigned_to') }}</label>
                <select name="assigned_user_id" class="form-select selectpicker" data-live-search="true">
                    <option value="">{{ __('solarmitra::solarmitra.select_staff') }}</option>
                    @foreach ($staff as $id => $name)
                        <option value="{{ $id }}" {{ isset($lead) && $lead->assigned_user_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label">{{ __('solarmitra::solarmitra.is_primary') }}</label>
                <select name="is_primary" class="form-select selectpicker">
                    <option value="0" {{ isset($lead) && !$lead->is_primary ? 'selected' : (!isset($lead) ? 'selected' : '') }}>{{ __('solarmitra::solarmitra.no') }}</option>
                    <option value="1" {{ isset($lead) && $lead->is_primary ? 'selected' : '' }}>{{ __('solarmitra::solarmitra.yes') }}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
    </div>
</form>