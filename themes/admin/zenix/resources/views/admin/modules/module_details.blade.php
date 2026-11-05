{{-- AJAX content for #modDetails .offcanvas-body (module details) --}}
{{-- Matches docs/html/add-modules.html #modDetails (md-hero / md-meta / md-* panels) --}}
<div class="installed-modules-page add-modules-page">
	@if(empty($module))
		<div class="mod-note danger">{{ $api_error ?: __('Unable to fetch module details.') }}</div>
	@else
		@php
			$author      = $module['author']['name'] ?? null;
			$author      = $author ?: ($module['author_email'] ?: 'W3CMS');
			$isOfficial  = strcasecmp((string) $author, 'W3CMS') === 0;
			$typeLabel   = ($module['type'] ?? 'P') === 'T' ? __('Theme') : __('Plugin');
			$screens     = array_values(array_filter((array) ($module['screenshots'] ?? []), function ($src) {
				return str_starts_with((string) $src, 'http');
			}));
			$docsLink    = $module['documentation_link'] ?? '';
			$logo        = $module['preview_image'] ?? null;
			$downloads   = $module['downloads'] ?? 0;
			$version     = $module['version'] ?? '';
			$size        = $module['size'] ?? '';
			$released    = $module['launching_date'] ?? '';
			$tags        = $module['tags'] ?? [];
			if (is_string($tags)) {
				$tags = explode(',', $tags);
			}
			$tags = array_slice(array_values(array_filter(array_map('trim', (array) $tags))), 0, 5);
			$features = [];
			if (!empty($module['feature_tags'])) {
				$features = array_values(array_filter(array_map('trim', explode(',', (string) $module['feature_tags']))));
			}
			$allowedTags = ['p','br','strong','b','em','i','u','s','ul','ol','li','a','img','h1','h2','h3','h4','h5','h6','blockquote','pre','code','table','thead','tbody','tr','th','td','hr','figure','figcaption','span','div','small','sup','sub','del','ins','dl','dt','dd'];
			$descHtml    = $module['description'] ? strip_tags($module['description'], '<' . implode('><', $allowedTags) . '>') : '';
			$tones       = ['tone-primary', 'tone-warning', 'tone-purple', 'tone-primary', 'tone-success', 'tone-warning', 'tone-info', 'tone-teal', 'tone-pink'];
			$tone        = $tones[crc32($module['slug']) % count($tones)];
		@endphp
		<div class="md-hero">
			<div class="md-hero-main">
				<span class="md-hero-icon {{ $tone }}">
					@if(!empty($logo))
						<img src="{{ $logo }}" alt="{{ $module['title'] }}">
					@else
						{{ strtoupper(mb_substr($module['title'], 0, 1)) }}
					@endif
				</span>
				<div class="md-hero-text">
					<h4 class="md-hero-title">{{ $module['title'] }}</h4>
					<div class="md-hero-badges">
						<span class="md-badge-solid">{{ $typeLabel }}</span>
						@if($isOfficial)
							<span class="md-badge-soft">{{ __('Official') }}</span>
						@endif
						<span class="md-by">{{ __('by') }} {{ $author }} @if($isOfficial)<i class="icon-circle-check"></i>@endif</span>
					</div>
					@if(!empty($tags))
						<div class="md-tags">
							@foreach($tags as $tag)
								<span class="md-tag">{{ $tag }}</span>
							@endforeach
						</div>
					@endif
				</div>
			</div>
			<div class="md-hero-actions">
				<button type="button" class="md-fav" aria-label="{{ __('Save') }} {{ $module['title'] }}"><i class="icon-heart"></i></button>
				@if(!empty($module['installed']))
					<span class="btn btn-primary md-install disabled">{{ __('Installed') }}</span>
				@else
					<a class="btn btn-primary md-install" href="{{ route('modules.admin.install_confirm', ['slug' => $module['slug']]) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl"><i class="icon-upload"></i> {{ __('Install Now') }}</a>
				@endif
			</div>
		</div>

		<div class="md-meta">
			<span class="md-meta-item"><span class="am-star">★★★★★</span></span>
			<span class="md-meta-item"><i class="icon-trending-up"></i> <strong>{{ number_format($downloads) }}</strong> {{ __('installations') }}</span>
			<span class="md-meta-item"><i class="icon-calendar"></i> {{ __('Last updated:') }} <strong>{{ $module['updated_at_human'] }}</strong></span>
		</div>

		<div class="mod-tabs" id="modDetailTabs">
			<button type="button" class="is-active" data-panel="overview">{{ __('Overview') }}</button>
			<button type="button" data-panel="screenshots">{{ __('Screenshots') }}</button>
			<button type="button" data-panel="dependencies">{{ __('Dependencies') }}</button>
			<button type="button" data-panel="changelog">{{ __('Changelog') }}</button>
			<button type="button" data-panel="requirements">{{ __('Requirements') }}</button>
			<button type="button" data-panel="docs">{{ __('Documentation') }}</button>
		</div>
		<div id="modDetailPanels">
			<div data-panel-body="overview">
				<div class="row g-3">
					<div class="col-12 col-xl-7">
						<div class="md-card">
							<h5 class="md-card-title">{{ __('Description') }}</h5>
							@if($descHtml !== '')
								<div class="md-text mb-0">{!! $descHtml !!}</div>
							@else
								<p class="md-text mb-0">{{ __('No description provided yet.') }}</p>
							@endif
						</div>
						<div class="md-card">
							<h5 class="md-card-title">{{ __('Key Features') }}</h5>
							<div class="mod-feature-list md-features">
								@if(!empty($features))
									@foreach($features as $feature)
										<div><i class="icon-circle-check"></i> {{ $feature }}</div>
									@endforeach
								@else
									<div><i class="icon-circle-check"></i> {{ __('Works with your W3CMS installation') }}</div>
									<div><i class="icon-circle-check"></i> {{ $typeLabel }} {{ __('module') }}</div>
									<div><i class="icon-circle-check"></i> {{ __('Author:') }} {{ $author }}</div>
									@if($version !== '')
										<div><i class="icon-circle-check"></i> {{ __('Version') }} {{ $version }}</div>
									@endif
								@endif
							</div>
						</div>
						@if(!empty($module['installed']))
							<div class="md-note">
								<i class="icon-info"></i>
								<div>{{ __('This module is installed on your system. You can activate it from the Installed Modules page.') }}</div>
							</div>
						@endif
					</div>
					<div class="col-12 col-xl-5">
						<div class="md-card">
							<h5 class="md-card-title">{{ __('Module Information') }}</h5>
							<div class="md-info">
								@if($version !== '')
									<div class="md-info-row"><span>{{ __('Version') }}</span><strong>{{ $version }}</strong></div>
								@endif
								<div class="md-info-row"><span>{{ __('Type') }}</span><strong>{{ $typeLabel }}</strong></div>
								<div class="md-info-row"><span>{{ __('Author') }}</span><strong class="md-ok">{{ $author }} <i class="icon-circle-check"></i></strong></div>
								<div class="md-info-row"><span>{{ __('Technology') }}</span><strong>Laravel <span class="md-tech">L</span></strong></div>
								<div class="md-info-row"><span>{{ __('Requires W3CMS') }}</span><strong>5.0+</strong></div>
								@if($size !== '')
									<div class="md-info-row"><span>{{ __('Package Size') }}</span><strong>{{ $size }}</strong></div>
								@endif
								@if($released !== '')
									<div class="md-info-row"><span>{{ __('Released') }}</span><strong>{{ $released }}</strong></div>
								@endif
								<div class="md-info-row"><span>{{ __('Downloads') }}</span><strong>{{ number_format($downloads) }}</strong></div>
								<div class="md-info-row"><span>{{ __('License') }}</span><strong>{{ __('Free (Official)') }}</strong></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div data-panel-body="screenshots" hidden>
				@if(!empty($screens))
					<div class="row g-2">
						@foreach($screens as $shot)
							<div class="col-6 mb-2"><a href="{{ $shot }}" target="_blank" rel="noopener"><img class="img-fluid rounded border" src="{{ $shot }}" alt="{{ $module['title'] }}"></a></div>
						@endforeach
					</div>
				@else
					<p class="text-secondary mb-0">{{ __('No screenshots available.') }}</p>
				@endif
			</div>
			<div data-panel-body="dependencies" hidden>
				@if(!empty($module['dependencies']))
					<div class="mod-note warn">{{ __('Requires Business Core 2.0 or newer before installation.') }}</div>
				@else
					<div class="mod-note info">{{ __('Dependencies for this module are satisfied.') }}</div>
					<div class="mod-section mb-0">
						<h6>{{ __('Required Modules') }}</h6>
						<div class="mod-check mb-0"><i class="icon-circle-check"></i><div>{{ __('No missing dependencies detected') }}</div></div>
					</div>
				@endif
			</div>
			<div data-panel-body="changelog" hidden>
				<p class="mb-0">{{ __('Latest listed update:') }} <span id="detailUpdated">{{ $module['updated_at_human'] }}</span>.</p>
			</div>
			<div data-panel-body="requirements" hidden>
				<div class="mod-facts">
					<div class="mod-fact"><i class="icon-layers"></i><div><small>W3CMS</small><strong>5.0+</strong></div></div>
					<div class="mod-fact"><i class="icon-code"></i><div><small>PHP</small><strong>{{ PHP_VERSION }}</strong></div></div>
					<div class="mod-fact"><i class="icon-layers"></i><div><small>Laravel</small><strong>{{ app()->version() }}</strong></div></div>
				</div>
				<div class="mod-compat"><i class="icon-circle-check"></i><div><strong>{{ __('Compatible with your W3CMS (v5.0+)') }}</strong><span>{{ __('Verified against your current installation.') }}</span></div></div>
				<div class="mod-compat mb-0"><i class="icon-circle-check"></i><div><strong>{{ __('PHP :v detected', ['v' => PHP_VERSION]) }}</strong><span>{{ __('Your server meets the requirements.') }}</span></div></div>
			</div>
			<div data-panel-body="docs" hidden>
				<div class="mod-section mb-0">
					<h6>{{ __('Documentation') }}</h6>
					<div class="mod-check mb-0"><i class="icon-circle-check"></i><div>
						@if($docsLink !== '')
							<a href="{{ $docsLink }}" target="_blank" rel="noopener">{{ __('Open documentation') }}</a>
						@else
							{{ __('Documentation is published with the module package on W3CMS.in.') }}
						@endif
					</div></div>
				</div>
			</div>
		</div>
	@endif
</div>
