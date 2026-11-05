{{-- AJAX fragment injected into #AjaxResultContainerXl (enable confirm) --}}
@php $eName = $module->getName(); @endphp
<div class="modal-header">
	<div class="mod-kicker">
		<span class="mod-kicker-icon"><i class="icon-play"></i></span>
		<div>
			<h5>{{ __('Enable module?') }}</h5>
			<p>{{ __('The module will be activated and its functionality made available.') }}</p>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	@include('admin.modules.module_summary')
	<div class="mod-section">
		<h6>{{ __('Impact') }}</h6>
		<div class="mod-check"><i class="icon-check"></i><div>{{ __('The module will become active immediately.') }}</div></div>
		<div class="mod-check"><i class="icon-check"></i><div>{{ __('Files and database data remain unchanged.') }}</div></div>
		<div class="mod-check"><i class="icon-check"></i><div>{{ __('You can deactivate the module again at any time.') }}</div></div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
	<a href="{{ route('modules.admin.enable', ['module' => $eName]) }}" class="btn btn-primary" data-action-run><i class="icon-play"></i> {{ __('Enable') }}</a>
</div>
