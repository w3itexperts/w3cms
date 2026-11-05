{{-- AJAX fragment injected into #AjaxResultContainerXl (update confirm — inert for now) --}}
@php
	$uName    = $module->getName();
	$uVersion = $module->get('version') ?: '—';
	$uLive    = $liveVersion ?? null;
@endphp
<div class="modal-header">
	<div class="mod-kicker">
		<span class="mod-kicker-icon"><i class="icon-download"></i></span>
		<div>
			<h5>{{ __('Update module?') }}</h5>
			<p>{{ __('You are about to update this module to a newer version from W3CMS.in.') }}</p>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	@include('admin.modules.module_summary')
	<div class="mod-versions">
		<div class="mod-version-box">
			<small>{{ __('Current Version') }}</small>
			<strong>{{ $uVersion }}</strong>
			<span>{{ __('Installed on your website') }}</span>
		</div>
		<span class="mod-version-arrow" aria-hidden="true"><i class="icon-arrow-right"></i></span>
		<div class="mod-version-box is-new">
			<div class="mod-version-head"><small>{{ __('New Version') }}</small></div>
			<strong>{{ $uLive ?: '—' }}</strong>
			@if($uLive !== null)
				<span>{{ __('Available on W3CMS.in') }}</span>
			@endif
		</div>
	</div>
	<div class="mod-note warn">{{ __('Module updates will be available in a future release.') }}</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
	<button type="button" class="btn btn-primary" disabled><i class="icon-download"></i> {{ __('Update') }}</button>
</div>
