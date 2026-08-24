<form method="post" action="{{ route('business.solarmitra.contacts.assign_type',$contact->id) }}" id="AssignTypeForm" class="AjaxModalForm">
	@csrf
	<div class="formLoading d-none">
	    <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
	    <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
	</div>

	<input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
	<div class="modal-header">
		<h5 class="modal-title">{{ __('solarmitra::solarmitra.assign_type') }}</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		
		<div class="mb-3">
			<select name="type"  class="form-select">
				@foreach (config('solarmitra.business_user_types', []) as $element => $title)
					<option value="{{$element}}" >{{$title}}</option>
				@endforeach
			</select>
		</div>
		
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Apply</button>
	</div>
</form>