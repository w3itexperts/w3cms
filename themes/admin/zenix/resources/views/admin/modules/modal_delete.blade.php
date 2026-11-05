{{-- AJAX fragment injected into #AjaxResultContainerXl (delete confirm, server-gated) --}}
@php
	$xName      = $module->getName();
	$xIsActive  = $module->isEnabled();
	$xProtected = in_array($xName, $protectedModules ?? []);
@endphp
<div class="modal-header">
	<div class="mod-kicker">
		<span class="mod-kicker-icon"><i class="icon-triangle-alert"></i></span>
		<div>
			<h5>{{ __('Delete module?') }}</h5>
			<p>{{ __('Are you sure you want to delete this module from your W3CMS installation?') }}</p>
		</div>
	</div>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	@include('admin.modules.module_summary')
	<div class="mod-note danger"><i class="icon-circle-alert"></i><div>{{ __('This action will remove the module files from this W3CMS installation.') }}</div></div>
	<div class="mod-section">
		<h6>{{ __('Important Information') }}</h6>
		<div class="mod-check"><i class="icon-triangle-alert"></i><div>{{ __('The module must be deactivated before deletion.') }}</div></div>
		<div class="mod-check"><i class="icon-database"></i><div>{{ __('Database data may remain unless the module provides cleanup.') }}</div></div>
		<div class="mod-check"><i class="icon-refresh-cw"></i><div>{{ __('You can reinstall the module later from W3CMS.in.') }}</div></div>
	</div>
	@if($xProtected)
		<div class="mod-status-card">
			<i class="icon-info"></i>
			<div>
				<strong>{{ __('Current Status') }}</strong>
				<p>{{ __('This module is protected and cannot be deleted.') }}</p>
			</div>
			<span class="mod-status-pill">{{ __('Protected') }}</span>
		</div>
	@elseif($xIsActive)
		<div class="mod-status-card is-blocked">
			<i class="icon-info"></i>
			<div>
				<strong>{{ __('Current Status') }}</strong>
				<p>{{ __('This module is currently active and must be deactivated before it can be deleted.') }}</p>
			</div>
			<a href="{{ route('modules.admin.confirm_disable', ['module' => $xName]) }}" class="mod-status-pill" data-load-modal>{{ __('Deactivate first') }}</a>
		</div>
	@else
		<div class="mod-status-card is-ready">
			<i class="icon-info"></i>
			<div>
				<strong>{{ __('Current Status') }}</strong>
				<p>{{ __('This module is currently inactive and can be deleted safely.') }}</p>
			</div>
			<span class="mod-status-pill">{{ __('Ready to delete') }}</span>
		</div>
	@endif
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
	@if($xProtected || $xIsActive)
		<button type="button" class="btn btn-danger" disabled><i class="icon-trash-2"></i> {{ __('Delete Module') }}</button>
	@else
		<a href="{{ route('modules.admin.delete', ['module' => $xName]) }}" class="btn btn-danger" data-action-run><i class="icon-trash-2"></i> {{ __('Delete Module') }}</a>
	@endif
</div>
