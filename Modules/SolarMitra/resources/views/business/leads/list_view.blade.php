@php
    $is_action =
		(
			auth()->user()->can('SolarMitra > Business > QuotationsController > create') &&
			auth()->user()->can('SolarMitra > Business > QuotationsController > store')
		) ||
		(
			auth()->user()->can('SolarMitra > Business > LeadsController > edit') &&
			auth()->user()->can('SolarMitra > Business > LeadsController > update')
		) ||
		auth()->user()->can('SolarMitra > Business > LeadsController > destroy');

@endphp

<table class="leads-tbl table table-bottom-borderless table mb-0" >
    <thead>
        <tr>
            <th class="sorting-disabled width50 align-middle">
                <i class="icon icon-arrow-right d-flex fs-18"></i>
            </th>
            <th class="mw-240">{{ __('solarmitra::solarmitra.name') }}</th>
            <th class="mw-220">{{ __('solarmitra::solarmitra.info') }}</th>
            <th class="mw-230">Assign & Activity</th>
            <th class="mw-150">Dates</th>
            @if($is_action)
            <th class="sorting-disabled width150 mw-120">{{ __('solarmitra::solarmitra.action') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse ($leads as $lead)
        <tr id="Row_{{$lead->id}}">
            <td id="Column_Checkbox_{{$lead->id}}">
                <div class="form-check custom-checkbox">
                    <input type="checkbox" class="form-check-input check-input" name="selected_leads[]" value="{{$lead->id}}" data-stage-id="{{$lead->lead_stage->id}}">
                </div>
            </td>
            <td id="Column_Name_{{$lead->id}}">{{$lead->full_name}} <br/> {{$lead->phone}} {!! $lead->email ? ' <br/> '.$lead->email : '' !!}</td>
            <td id="Column_Info_{{$lead->id}}">
                Potential:
                @if ($lead->potential == 1)
                <span class="badge text-bg-danger">Low</span>
                @elseif($lead->potential == 2)
                <span class="badge text-bg-info">Medium</span>
                @elseif($lead->potential == 3)
                <span class="badge text-bg-primary">High</span>
                @endif
                
                <br/>
                Status: {{$lead->lead_stage->name}} Lead
                <br/>
                Source: {{optional($lead->source)->name}}
            </td>
            <td id="Column_Assign_Activity_{{$lead->id}}">
                Lead Owner: {{optional(@$lead->added_by_user)->full_name}} 

                @php
                    $showButton = optional($lead->last_followup_log)->scheduled_at ? Carbon\Carbon::createFromFormat(
                        config('solarmitra.date_time_format'),
                        $lead->last_followup_log->scheduled_at
                    )->between(
                        now(),
                        now()->addDays(SolarMitraHelper::getBusinessConfig('followup_alert_before_days', 3))
                    ) : false;
                @endphp
                @if ($lead->last_followup_log && $lead->last_followup_log->status == 1 && $showButton)
                <a class="btn btn-link text-danger p-0" href="{{ route('business.solarmitra.leads.lead_followed',$lead->id) }}">!Followup</a>
                @endif
                <br>
                Assign To: {{optional(optional(@$lead->last_follow_up)->assigned_user)->name}} 
                @can('SolarMitra > Business > LeadsController > assign_lead')
                <a class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg" href="{{ route('business.solarmitra.leads.assign_lead',$lead->id) }}">Assign / Followup</a>
                @endcan
                <br>
                @if (optional($lead->last_followup_log)->scheduled_at)
                    Next Follow Up Date: {{optional($lead->last_followup_log)->scheduled_at}}
                @endif
            </td>
            <td id="Column_Dates_{{$lead->id}}">Created: {{@$lead->created_at}} <br/> Updated:{{@$lead->updated_at}}</td>
            @if($is_action)
            <td id="Column_Action_{{$lead->id}}" class="">
                @can(['SolarMitra > Business > LeadsController > edit','SolarMitra > Business > LeadsController > update'])
                <a href="{{ route('business.solarmitra.leads.edit',$lead->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">
                    <i class="icon icon-pencil fs-14 text-primary"></i>
                    Edit Lead
                </a>
                <br/>
                @endcan
                @can('SolarMitra > Business > LeadsController > destroy')
                <a href="{{ route('business.solarmitra.leads.destroy',$lead->id) }}" class="deleteRecord">
                    <i class="icon icon-trash-2 fs-14 text-primary"></i>
                    Delete Lead
                </a>
                <br/>
                @endcan
                @can(['SolarMitra > Business > QuotationsController > create','SolarMitra > Business > QuotationsController > store'])
                <a href="{{ route('business.solarmitra.quotations.create',['lead_id' => $lead->id]) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">
                    <i class="icon icon-file fs-14 text-primary"></i>
                    Add Quotation
                </a>
                @endcan
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="14" class="text-center">{{ __('solarmitra::solarmitra.no_leads') }}</td>
        </tr>
        @endforelse
        
    </tbody>
</table>
@if ($leads && $leads->hasPages())
<div class="p-3">
    {{ $leads->onEachSide(1)->appends(request()->all())->links('admin.elements.ajax_pagination')}}
</div>
@endif