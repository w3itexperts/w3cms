@php
	$sSummaryName    = $module->getName();
	$sSummaryDesc    = $module->getDescription() ?: '—';
	$sSummaryVersion = $module->get('version') ?: '—';
	$sSummaryAuthor  = trim((string) ($module->get('author') ?: ''));
	$sSummaryCore    = in_array($sSummaryName, $protectedModules ?? []);
	$sSummaryType    = $sSummaryCore ? __('Core') : __('Standard');
	$sStatusLabel    = $statusLabel ?? null;
	$sShowType       = $showType ?? true;
@endphp
<div class="mod-summary">
	@include('admin.modules.module_badge', ['name' => $sSummaryName])
	<div>
		@if($sStatusLabel !== null)
			<div class="mod-sum-top">
				<div>
					<h6>{{ $sSummaryName }}</h6>
					<div class="mod-pills">
						<span class="mod-pill">{{ $sSummaryVersion === '—' ? '—' : 'v' . $sSummaryVersion }}</span>
						@if($sSummaryAuthor !== '')
							<span class="mod-pill">{{ __('By') }} {{ $sSummaryAuthor }}</span>
						@endif
					</div>
				</div>
				<span class="mod-status-active">{{ $sStatusLabel }}</span>
			</div>
			<p>{{ $sSummaryDesc }}</p>
		@else
			<h6>{{ $sSummaryName }}</h6>
			<p>{{ $sSummaryDesc }}</p>
			<div class="mod-pills">
				<span class="mod-pill">{{ $sSummaryVersion === '—' ? '—' : 'v' . $sSummaryVersion }}</span>
				@if($sSummaryAuthor !== '')
					<span class="mod-pill">{{ __('By') }} {{ $sSummaryAuthor }}</span>
				@endif
				@if($sShowType)
					<span class="mod-pill is-primary">{{ $sSummaryType }}</span>
				@endif
			</div>
		@endif
	</div>
</div>
