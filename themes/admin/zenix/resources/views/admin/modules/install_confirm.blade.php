{{-- AJAX content for #AjaxModalBoxXl .modal-content (install confirm) --}}
{{-- Matches docs/html/add-modules.html #modInstall; design #modInstall CSS is re-scoped to .mod-install --}}
<div class="installed-modules-page add-modules-page">
	@if(empty($module))
		<div class="modal-header">
			<div class="mod-kicker">
				<span class="mod-kicker-icon"><i class="icon-download"></i></span>
				<div>
					<h5 id="modInstallTitle">{{ __('Install module?') }}</h5>
					<p>{{ __('You are about to download and install this module from W3CMS.in.') }}</p>
				</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body" id="modInstallBody">
			<div class="mod-note danger">{{ $api_error ?: __('Unable to fetch module details.') }}</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
		</div>
	@else
		@php
			$tones  = ['tone-primary', 'tone-warning', 'tone-purple', 'tone-primary', 'tone-success', 'tone-warning', 'tone-info', 'tone-teal', 'tone-pink'];
			$tone   = $tones[crc32($module['slug']) % count($tones)];
			$author = $module['author']['name'] ?? null;
			$author = $author ?: ($module['author_email'] ?: 'W3CMS');
			$descPlain = trim(preg_replace('/\s+/', ' ', strip_tags($module['description'] ?? '')));
			$descPlain = $descPlain !== '' ? $descPlain : __('No description provided yet.');
			$logo   = $module['preview_image'] ?? null;
			$type   = ($module['type'] ?? 'P') === 'T' ? __('Theme') : __('Plugin');
		@endphp
		<div class="modal-header">
			<div class="mod-kicker">
				<span class="mod-kicker-icon"><i class="icon-download"></i></span>
				<div>
					<h5 id="modInstallTitle">{{ __('Install module?') }}</h5>
					<p>{{ __('You are about to download and install this module from W3CMS.in.') }}</p>
				</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body" id="modInstallBody">
			<div class="mod-summary">
				<span class="im-module-icon {{ $tone }}">
					@if(!empty($logo))
						<img src="{{ $logo }}" alt="{{ $module['title'] }}">
					@else
						{{ strtoupper(mb_substr($module['title'], 0, 1)) }}
					@endif
				</span>
				<div>
					<h6>{{ $module['title'] }}</h6>
					<p>{{ \Illuminate\Support\Str::limit($descPlain, 140) }}</p>
					<div class="mod-pills">
						@if(!empty($module['version']))
							<span class="mod-pill">v{{ $module['version'] }}</span>
						@endif
						<span class="mod-pill">{{ __('By') }} {{ $author }}</span>
						@if(!empty($module['size']))
							<span class="mod-pill">{{ $module['size'] }}</span>
						@endif
						<span class="mod-pill is-primary">{{ $type }}</span>
					</div>
				</div>
			</div>
			<div class="mod-section">
				<h6>{{ __('Requirements & Compatibility') }}</h6>
				<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Requirements are verified before anything changes') }}<small>{{ __('PHP and W3CMS version requirements are checked before files are modified.') }}</small></div></div>
				<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Package integrity is checked') }}<small>{{ __('ZIP structure and module.json are validated before extraction.') }}</small></div></div>
				<div class="mod-check"><i class="icon-circle-check"></i><div>{{ __('Dependencies are checked') }}<small>{{ __('Required modules must be installed and up to date.') }}</small></div></div>
			</div>
			<div class="mod-note info">
				<div class="mod-note-head"><i class="icon-info"></i><strong>{{ __('Installation Information') }}</strong></div>
				<p>{{ __('The package will be downloaded from W3CMS.in and installed into your website\'s Modules directory. The module will be ready to use after installation is complete.') }}</p>
			</div>
			@if(!empty($module['installed']))
				<div class="mod-note warn">{{ __('This module is already installed on your system.') }}</div>
			@endif
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
			@if(!empty($module['installed']))
				<a class="btn btn-primary disabled" href="{{ route('modules.admin.index') }}">{{ __('Installed') }}</a>
			@else
				<button type="button" class="btn btn-primary" id="modInstallGo"
					data-package="{{ $module['package'] }}"
					data-slug="{{ $module['slug'] }}"
					data-name="{{ $module['title'] }}"
					data-desc="{{ \Illuminate\Support\Str::limit($descPlain, 140) }}"
					data-version="{{ $module['version'] ?? '' }}"
					data-author="{{ $author }}"
					data-size="{{ $module['size'] ?? '' }}"
					data-type="{{ $type }}"
					data-tone="{{ $tone }}"
					data-icon="{{ $logo }}"><i class="icon-download"></i> {{ __('Install') }}</button>
			@endif
		</div>
	@endif
</div>
