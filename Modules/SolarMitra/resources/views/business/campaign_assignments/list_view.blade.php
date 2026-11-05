@php
    $is_action =
        (
            auth('business')->user()->can('SolarMitra > Business > CampaignAssignmentsController > create') &&
            auth('business')->user()->can('SolarMitra > Business > CampaignAssignmentsController > store')
        ) ||
        auth('business')->user()->can('SolarMitra > Business > CampaignAssignmentsController > destroy');
@endphp

<table class="leads-tbl table table-bottom-borderless table mb-0" >
	<thead>
		<tr>
			<th class="sorting-disabled width50 align-middle">
				<i class="icon icon-arrow-right d-flex fs-18"></i>
			</th>
			<th class="mw-240">{{ __('solarmitra::solarmitra.staff_name') }}</th>
			<th class="mw-150">{{ __('solarmitra::solarmitra.created_at') }}</th>
			@if($is_action)
			<th class="sorting-disabled width150 mw-120">{{ __('solarmitra::solarmitra.action') }}</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@forelse ($assignments as $assignment)
		<tr id="Row_{{$assignment->id}}">
			<td id="Column_Checkbox_{{$assignment->id}}">
				<div class="form-check custom-checkbox">
					<input type="checkbox" class="form-check-input check-input" name="selected_assignments[]" value="{{$assignment->id}}">
				</div>
			</td>
			<td id="Column_Name_{{$assignment->id}}">{{optional($assignment->user)->name}}</td>
			<td id="Column_Created_{{$assignment->id}}">{{$assignment->created_at}}</td>
			@if($is_action)
			<td id="Column_Action_{{$assignment->id}}">
				<div class="dropdown">
					<button class="btn border px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						{{ __('solarmitra::solarmitra.action') }}
					</button>
					<ul class="dropdown-menu">
						@can('SolarMitra > Business > CampaignAssignmentsController > destroy')
						<li><a class="dropdown-item deleteRecord"  data-alert_text="{{ __('Are you Sure you want to Delete this Assignment.') }}" href="{{ route('business.solarmitra.campaigns.assignments.destroy', [$campaign, $assignment]) }}">{{ __('solarmitra::solarmitra.delete') }}</a></li>
						@endcan
					</ul>
				</div>
			</td>
			@endif
		</tr>
		@empty
		<tr>
			<td colspan="4" class="text-center py-4">{{ __('solarmitra::solarmitra.records_not_found') }}</td>
		</tr>
		@endforelse
	</tbody>
</table>