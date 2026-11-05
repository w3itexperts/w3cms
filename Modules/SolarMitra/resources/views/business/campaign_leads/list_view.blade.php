@php
    $is_action =
        (
            auth('business')->user()->can('SolarMitra > Business > CampaignLeadsController > create') &&
            auth('business')->user()->can('SolarMitra > Business > CampaignLeadsController > store')
        ) ||
        (
            auth('business')->user()->can('SolarMitra > Business > CampaignLeadsController > edit') &&
            auth('business')->user()->can('SolarMitra > Business > CampaignLeadsController > update')
        ) ||
        auth('business')->user()->can('SolarMitra > Business > CampaignLeadsController > destroy');
@endphp

<table class="leads-tbl table table-bottom-borderless table mb-0" >
	<thead>
		<tr>
			<th class="sorting-disabled width50 align-middle">
				<i class="icon icon-arrow-right d-flex fs-18"></i>
			</th>
			<th class="mw-240">{{ __('solarmitra::solarmitra.name') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.activity') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.source') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.assigned_to') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.is_primary') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.created_at') }}</th>
			@if($is_action)
			<th class="sorting-disabled width100 ">{{ __('solarmitra::solarmitra.action') }}</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@forelse ($leads as $campaignLead)
		<tr id="Row_{{$campaignLead->id}}">
			<td id="Column_Checkbox_{{$campaignLead->id}}">
				<div class="form-check custom-checkbox">
					<input type="checkbox" class="form-check-input check-input" name="selected_leads[]" value="{{$campaignLead->id}}">
				</div>
			</td>
			<td id="Column_Name_{{$campaignLead->id}}">{{$campaignLead->lead->full_name}} <br/> {{$campaignLead->lead->phone}} {!! $campaignLead->lead->email ? ' <br/> '.$campaignLead->lead->email : '' !!}</td>
			<td id="Column_Activity_{{$campaignLead->id}}">{{optional($campaignLead->activity)->name}}</td>
			<td id="Column_Source_{{$campaignLead->id}}">{{optional($campaignLead->source)->name}}</td>
			<td id="Column_Assigned_{{$campaignLead->id}}">{{optional($campaignLead->assignedUser)->name}}</td>
			<td id="Column_Primary_{{$campaignLead->id}}">
				@if($campaignLead->is_primary)
					<span class="badge text-bg-success">{{ __('solarmitra::solarmitra.yes') }}</span>
				@else
					<span class="badge text-bg-secondary">{{ __('solarmitra::solarmitra.no') }}</span>
				@endif
			</td>
			<td id="Column_Created_{{$campaignLead->id}}">{{$campaignLead->created_at}}</td>
			@if($is_action)
			<td id="Column_Action_{{$campaignLead->id}}">
				<div class="dropdown">
					<div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="icon-ellipsis-vertical"></i>
					</div>
					<ul class="dropdown-menu">
						@can('SolarMitra > Business > CampaignLeadsController > edit')
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg" href="{{ route('business.solarmitra.campaigns.leads.edit', [$campaign, $campaignLead]) }}">{{ __('solarmitra::solarmitra.edit') }}</a></li>
						@endcan
						@can('SolarMitra > Business > CampaignLeadsController > destroy')
						<li><a class="dropdown-item deleteRecord" data-alert_text="{{ __('Are you Sure you want to Delete this Lead from Campaign.') }}" href="{{ route('business.solarmitra.campaigns.leads.destroy', [$campaign, $campaignLead]) }}">{{ __('solarmitra::solarmitra.delete') }}</a></li>
						@endcan
					</ul>
				</div>
			</td>
			@endif
		</tr>
		@empty
		<tr>
			<td colspan="8" class="text-center py-4">{{ __('solarmitra::solarmitra.no_records_found') }}</td>
		</tr>
		@endforelse
	</tbody>
</table>