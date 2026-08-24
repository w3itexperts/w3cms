@php
    $is_action =
		auth()->user()->can('SolarMitra > Business > ContactsController > assign_type') ||
		(
			auth()->user()->can('SolarMitra > Business > ContactsController > edit') &&
			auth()->user()->can('SolarMitra > Business > ContactsController > update')
		) ||
		auth()->user()->can('SolarMitra > Business > ContactsController > destroy');
@endphp

<div class="table-responsive check-wrapper">
	<table class="table table-bottom-borderless mb-0 leads-tbl rounded overflow-hidden">
		<thead>
			<tr>
				<th class="sorting-disabled width50">
					<i class="icon icon-arrow-right d-flex fs-18"></i>
				</th>
				<th class="">{{ __('solarmitra::solarmitra.name') }}</th>
				<th class="width300 mw-300">{{ __('solarmitra::solarmitra.type') }}</th>
				<th class="width300 mw-300">{{ __('solarmitra::solarmitra.other_info') }}</th>
				<th class="width300 mw-300">{{ __('solarmitra::solarmitra.dates') }}</th>
				@if($is_action)
				<th class="sorting-disabled width250 mw-200">{{ __('solarmitra::solarmitra.action') }}</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@forelse ($contacts as $contact)
			@php
				$contact_types = [];
				if ($contact->client) {
		            $contact_types[] = 'client';
		        }
		        if ($contact->supplier) {
		            $contact_types[] = 'supplier';
		        }
		        if ($contact->investor) {
		            $contact_types[] = 'investor';
		        }
		        if ($contact->contractor) {
		            $contact_types[] = 'contractor';
		        }
		        if ($contact->partner) {
		            $contact_types[] = 'partner';
		        }
		        if ($contact->staff) {
		            $contact_types[] = 'staff';
		        }
			@endphp
			<tr id="Row_{{$contact->id}}">
				<td>
					<div class="form-check custom-checkbox">
						<input type="checkbox" class="form-check-input check-input" value="{{$contact->id}}" data-id="{{$contact->id}}">
					</div>
				</td>
				<td>
					{{$contact->name}} 
					<br/> 
					{{$contact->phone_number}} 
					@if ($contact->user && $contact->user->is_mobile_verified)
						<span class="badge bg-success badge-xs mb-2">{{ __('solarmitra::solarmitra.mobile_verified') }}</span>
					@elseif ($contact->user && !$contact->user->is_mobile_verified)
						<span class="badge bg-warning badge-xs mb-2">{{ __('solarmitra::solarmitra.mobile_not_verified') }}</span>
					@endif
					
					{!! $contact->email ? ' <br/> '.$contact->email : '' !!} 
					@if ($contact->user && $contact->user->is_email_verified)
						<span class="badge bg-success badge-xs mb-2">{{ __('solarmitra::solarmitra.email_verified') }}</span>
					@elseif ($contact->user && !$contact->user->is_email_verified)
						<span class="badge bg-warning badge-xs mb-2">{{ __('solarmitra::solarmitra.email_not_verified') }}</span>
					@endif
				</td>
				<td>
					<div class="d-flex flex-wrap gap-1">
						@if (@$type == 'staff' && optional($contact->user)->roles)
							@forelse ($contact->user->roles as $element)
							<p class="badge bg-primary mb-0">{{$element->name}}</p>
							@empty
							<p class="link">{{ __('solarmitra::solarmitra.not_assigned') }}</p>
							@endforelse
						@else
							@forelse ($contact_types as $element)
							<p class="badge bg-primary mb-0">{{ucfirst($element)}}</p>
							@empty
							<p class="link">{{ __('solarmitra::solarmitra.not_assigned') }}</p>
							@endforelse
						@endif
					</div>
				</td>
				<td>
				{{ __('solarmitra::solarmitra.aadhar_no') }} {{@$contact->aadhar_no}}
				<br/>
				{{ __('solarmitra::solarmitra.gst_no') }} {{@$contact->gst_no}}
				<br/>
				{{ __('solarmitra::solarmitra.pan_no') }} {{@$contact->pan_no}}
				</td>
				<td>{{ __('solarmitra::solarmitra.created') }} {{@$contact->created_at}} <br/> {{ __('solarmitra::solarmitra.updated') }} {{@$contact->updated_at}}</td>
				@if($is_action)
				<td class="">
					@if (!@$type && auth('business')->user()->can('SolarMitra > Business > ContactsController > assign_type'))
					<a href="{{ route('business.solarmitra.contacts.assign_type',$contact->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxSm">
						<i class="icon icon-pencil fs-14 text-primary"></i>
						{{ __('solarmitra::solarmitra.assign_type') }}
					</a>
					<br/>
					@endif
					@can(['SolarMitra > Business > ContactsController > edit','SolarMitra > Business > ContactsController > update'])
					<a href="{{ route('business.solarmitra.contacts.edit',['type' => @$type,'id' => $contact->id]) }}" class="AjaxOffCanvasShow">
						<i class="icon icon-file fs-14 text-primary"></i>
						{{ __('solarmitra::solarmitra.edit') }} {{ucfirst(Str::singular(@$type ?? 'Contact'))}}
					</a>
					<br/>
					@endcan
					@if (@$type == 'staff' && auth('business')->user()->can('SolarMitra > Business > ContactsController > assign_login'))
					<a href="{{ route('business.solarmitra.contacts.assign_login', ['contact_id' => $contact->id, 'type' => $type]) }}" class="AjaxOffCanvasShow">
					    <i class="icon icon-user fs-14 text-primary"></i>
					    {{ $contact->user ? __('solarmitra::solarmitra.update_assigned_user') : __('solarmitra::solarmitra.assign_login_to_user') }}
					</a>
					<br/>
					@endif
					@if (@$type == 'staff' && $contact->user && auth('business')->user()->can('SolarMitra > Business > ContactsController > verify_user_modal'))
					<a href="{{ route('business.solarmitra.contacts.verify_user_modal', $contact->id) }}"
					   class="verifyUserDirect"
					   data-contact_name="{{ $contact->name }}"
					   data-contact_id="{{ $contact->id }}"
					   data-email_verified="{{ $contact->user->is_email_verified }}"
					   data-mobile_verified="{{ $contact->user->is_mobile_verified }}"
					   data-bs-toggle="modal"
					   data-bs-target="#AjaxModalBoxMd">
					    <i class="icon icon-badge-check fs-14"></i>
					    {{ __('solarmitra::solarmitra.verify_user') }}
					</a>
					<br/>
					@endif
					@if (app()->environment('local') && auth('business')->user()->can('SolarMitra > Business > ContactsController > destroy'))
					<a href="{{ route('business.solarmitra.contacts.destroy',['type' => @$type,'id' => $contact->id]) }}" class="deleteRecord" data-alert_text="This will remove the {{@$type ?? implode(', ', $contact_types)}} from Contact">
						<i class="icon icon-trash fs-14 text-primary"></i>
						{{ __('solarmitra::solarmitra.delete') }} {{ucfirst(Str::singular(@$type ?? 'Contact'))}}
					</a>
					@endif
				</td>
				@endif
			</tr>
			@empty
			<tr><td class="text-center" colspan="{{ $is_action ? 6 : 5 }}"><p>{{ __('solarmitra::solarmitra.no_'.(@$type ?? 'contacts')) }}</p></td></tr>
			@endforelse
		</tbody>
	</table>
</div>
@if ($contacts && $contacts->hasPages())
<div class="card-footer">
    {{ $contacts->onEachSide(1)->appends(request()->all())->links('admin.elements.ajax_pagination') }}
</div>
@endif