{{-- AJAX fragment injected into #moduleDetailsDrawer (row details canvas) --}}
@if($module)
	@php
		$rName         = $module->getName();
		$rDesc         = $module->getDescription() ?: '—';
		$rVersion      = $module->get('version') ?: '—';
		$rIsActive     = $module->isEnabled();
		$rIsProtected  = in_array($rName, $protectedModules ?? []);
		$rType         = $rIsProtected ? __('Core') : __('Standard');
		$rAuthor       = $module->get('author') ?: '—';
		$rRequiresPhp  = trim((string) ($module->get('requires_php') ?: ''));
		$rPhpOk        = $rRequiresPhp !== '' ? version_compare(PHP_VERSION, $rRequiresPhp, '>=') : null;
		$rRequiresW3   = trim((string) ($module->get('required_w3cms_version') ?: ''));
		$rW3Ok         = $rRequiresW3 !== '' ? version_compare((string) config('constants.version'), $rRequiresW3, '>=') : null;
		$rUpdateState  = $updateState ?? 'unknown';
	@endphp
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="moduleDetailsLabel">{{ $rName }}</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<p class="im-detail-desc">{{ $rDesc }}</p>
		<div class="im-detail-row"><span>{{ __('Version') }}</span><strong>{{ $rVersion }}</strong></div>
		<div class="im-detail-row"><span>{{ __('Type') }}</span><strong>{{ $rType }}</strong></div>
		<div class="im-detail-row"><span>{{ __('Author') }}</span><strong>{{ $rAuthor }}</strong></div>
		<div class="im-detail-row"><span>{{ __('Parent module') }}</span><strong>—</strong></div>
		<div class="im-detail-row"><span>{{ __('Requires PHP') }}</span><strong>
			@if($rRequiresPhp !== '')
				{{ $rRequiresPhp }}+ <span class="{{ $rPhpOk ? 'text-success' : 'text-danger' }}">{{ $rPhpOk ? __('Compatible') : __('Incompatible') }}</span>
			@else
				—
			@endif
		</strong></div>
		<div class="im-detail-row"><span>{{ __('Requires W3CMS') }}</span><strong>
			@if($rRequiresW3 !== '')
				{{ $rRequiresW3 }}+ <span class="{{ $rW3Ok ? 'text-success' : 'text-danger' }}">{{ $rW3Ok ? __('Compatible') : __('Incompatible') }}</span>
			@else
				—
			@endif
		</strong></div>
		<div class="im-detail-row"><span>{{ __('Status') }}</span><strong>{{ $rIsActive ? __('Active') : __('Inactive') }}</strong></div>
		<div class="im-detail-row"><span>{{ __('Update') }}</span><strong>
			@if($rUpdateState === 'available')
				<span class="im-update is-available"><i class="icon-download"></i> {{ __('Update available') }}</span>
			@elseif($rUpdateState === 'current')
				<span class="im-update is-current"><i class="icon-circle-check"></i> {{ __('Up to date') }}</span>
			@else
				<span class="im-update">{{ __('No data') }}</span>
			@endif
		</strong></div>
	</div>
@else
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="moduleDetailsLabel">{{ __('Module details') }}</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="mod-note danger">{{ __('Module not found.') }}</div>
	</div>
@endif
