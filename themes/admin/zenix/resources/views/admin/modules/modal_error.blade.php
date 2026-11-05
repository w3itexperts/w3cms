{{-- AJAX fragment injected into #AjaxResultContainerXl (module not found) --}}
<div class="modal-header">
	<div class="mod-kicker">
		<span class="mod-kicker-icon"><i class="icon-triangle-alert"></i></span>
		<div>
			<h5>{{ __('Module not found') }}</h5>
			<p>{{ __('The requested module could not be found in this installation.') }}</p>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="mod-note danger">{{ $name !== '' ? __('Module') . ': ' . $name : __('Module not found.') }}</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
</div>
