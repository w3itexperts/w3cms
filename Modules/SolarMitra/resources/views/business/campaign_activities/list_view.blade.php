@php
    $is_action =
        (
            auth('business')->user()->can('SolarMitra > Business > CampaignActivitiesController > edit') &&
            auth('business')->user()->can('SolarMitra > Business > CampaignActivitiesController > update')
        ) ||
        auth('business')->user()->can('SolarMitra > Business > CampaignActivitiesController > destroy');
@endphp
<table class="leads-tbl table table-bottom-borderless table mb-0" >
	<thead>
		<tr>
			<th class="sorting-disabled width50 align-middle">
				<i class="icon icon-arrow-right d-flex fs-18"></i>
			</th>
			<th class="mw-240">{{ __('solarmitra::solarmitra.name') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.channel') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.source') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.cost') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.leads') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.impressions') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.clicks') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.cpl_cost_per_lead') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.ctr_click_through_rate') }}</th>
			<th class="mw-100">{{ __('solarmitra::solarmitra.cpc_click_through_rate') }}</th>
			@if($is_action)
			<th class="sorting-disabled width100 ">{{ __('solarmitra::solarmitra.action') }}</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@forelse ($activities as $activity)
		<tr id="Row_{{$activity->id}}">
			<td id="Column_Checkbox_{{$activity->id}}">
				<div class="form-check custom-checkbox">
					<input type="checkbox" class="form-check-input check-input" name="selected_activities[]" value="{{$activity->id}}" data-stage-id="{{$activity->status}}">
				</div>
			</td>
			<td id="Column_Name_{{$activity->id}}">{{$activity->name}}</td>
			<td id="Column_Channel_{{$activity->id}}">{{optional($activity->channel)->title}}</td>
			<td id="Column_Source_{{$activity->id}}">{{optional($activity->source)->name}}</td>
			<td id="Column_Cost_{{$activity->id}}">{{SolarMitraHelper::format_number($activity->cost)}}</td>
			<td id="Column_Leads_{{$activity->id}}">{{$activity->lead_count}}</td>
			<td id="Column_Impressions_{{$activity->id}}">{{SolarMitraHelper::format_number($activity->impression)}}</td>
			<td id="Column_Clicks_{{$activity->id}}">{{SolarMitraHelper::format_number($activity->clicks)}}</td>
			<td id="Column_CPL_{{$activity->id}}">{{$activity->cpl ?? '-'}}</td>
			<td id="Column_CTR_{{$activity->id}}">{{$activity->ctr ?? '-'}}%</td>
			<td id="Column_CPC_{{$activity->id}}">{{$activity->cpc ?? '-'}}</td>
			@if($is_action)
			<td id="Column_Action_{{$activity->id}}">
				<div class="dropdown custom-dropdown mb-0 tbl-orders-style">
					<div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="icon-ellipsis-vertical"></i>
					</div>
					<ul class="dropdown-menu">
						@can('SolarMitra > Business > CampaignActivitiesController > edit')
						<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" href="{{ route('business.solarmitra.campaigns.activities.edit', [$campaign, $activity]) }}">{{ __('solarmitra::solarmitra.edit') }}</a></li>
						@endcan
						@can('SolarMitra > Business > CampaignActivitiesController > destroy')
						<li><a class="dropdown-item deleteRecord" data-alert_text="{{ __('Are you Sure you want to Delete this Activity.') }}" href="{{ route('business.solarmitra.campaigns.activities.destroy', [$campaign, $activity]) }}">{{ __('solarmitra::solarmitra.delete') }}</a></li>
						@endcan
					</ul>
				</div>
			</td>
			@endif
		</tr>
		@empty
		<tr>
			<td colspan="13" class="text-center py-4">{{ __('solarmitra::solarmitra.records_not_found') }}</td>
		</tr>
		@endforelse
	</tbody>
</table>