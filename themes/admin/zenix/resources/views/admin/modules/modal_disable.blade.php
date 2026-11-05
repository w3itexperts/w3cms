{{-- AJAX fragment injected into #AjaxResultContainerXl (deactivate confirm) --}}
@php
	$dName       = $module->getName();
	$dDependents = array_values(array_filter(array_map('trim', (array) ($dependents ?? []))));
	$dBlocked    = count($dDependents) > 0;
	$dCount      = count($dDependents);
	if ($dCount > 1) {
		$dList = implode(', ', array_slice($dDependents, 0, -1)) . ' ' . __('and') . ' ' . end($dDependents);
	} else {
		$dList = $dCount ? (string) reset($dDependents) : '';
	}
	$dVerb = $dCount > 1 ? __('depend') : __('depends');
@endphp
<div class="modal-header">
	<div class="mod-kicker">
		<span class="mod-kicker-icon"><i class="icon-power"></i></span>
		<div>
			<h5>{{ __('Deactivate') }} {{ $dName }}?</h5>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	@include('admin.modules.module_summary', ['statusLabel' => __('Currently Active'), 'showType' => false])
	<div class="mod-section is-band">
		<h6><i class="icon-info"></i>{{ __('Impact') }}</h6>
		<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Files will remain in the Modules directory') }}</div></div>
		<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Database data will remain unchanged') }}</div></div>
		<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Dependent features may stop working') }}</div></div>
	</div>
	@if($dBlocked)
		<div class="mod-note info">
			<i class="icon-triangle-alert"></i>
			<div>
				<p><strong>{{ $dName }} {{ __('cannot be deactivated') }}</strong> {{ __('because') }} {{ $dList }} {{ $dVerb }} {{ __('on it.') }}</p>
				<button type="button" class="btn btn-outline-primary btn-sm" data-view-dependents="{{ $dName }}">{{ __('View Dependent Modules') }} <i class="icon-arrow-right"></i></button>
			</div>
		</div>
	@endif
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
	@if($dBlocked)
		<button type="button" class="btn btn-primary" disabled><i class="icon-power"></i> {{ __('Deactivate') }}</button>
	@else
		<a href="{{ route('modules.admin.disable', ['module' => $dName]) }}" class="btn btn-primary" data-action-run><i class="icon-power"></i> {{ __('Deactivate') }}</a>
	@endif
</div>
