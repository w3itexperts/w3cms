@php
	$author = $module->author ?? null;
	if (is_array($author)) {
		$author = $author['name'] ?? null;
	} elseif (is_object($author)) {
		$author = $author->name ?? null;
	}
	$author    = $author ?: ($module->author_email ?: 'W3CMS');
	$updated   = !empty($module->updated_at) ? \Illuminate\Support\Carbon::parse($module->updated_at)->diffForHumans() : '';
	$descPlain = trim(preg_replace('/\s+/', ' ', strip_tags($module->description ?? '')));
	$descPlain = $descPlain !== '' ? $descPlain : __('No description provided yet.');
	$logo      = $module->logo ?? null;
	$installed = !empty($module->installed);
	$slug      = $module->slug;
	$title     = $module->title;
	$typeRaw   = $module->type ?? 'P';

	if (in_array($typeRaw, ['Core', 'Add-on', 'Core Extension'], true)) {
		$badgeLabel = $typeRaw;
		$badgeClass = ['Core' => 'am-badge-solid', 'Add-on' => 'am-badge-addon', 'Core Extension' => 'am-badge-purple'][$typeRaw];
	} else {
		$badgeLabel = $typeRaw === 'T' ? __('Theme') : __('Plugin');
		$badgeClass = 'am-badge-indigo';
	}

	$dlCount     = (int) ($module->downloads ?? 0);
	$tags        = implode(' ', array_filter(array_map('trim', (array) ($module->tags ?? []))));
	$dataUpdated = $updated !== '' ? __('Updated') . ' ' . $updated : '';
@endphp
<div class="col-xl-3 col-md-6 am-item" data-id="{{ $slug }}" data-name="{{ $title }}" data-author="{{ $author }}" data-desc="{{ \Illuminate\Support\Str::limit($descPlain, 200) }}" data-tags="{{ $tags }}" data-updated="{{ $dataUpdated }}" data-installs="{{ number_format($dlCount) }}" data-installed="{{ $installed ? 1 : 0 }}" data-missing="0" data-type="{{ $badgeLabel }}">
	<article class="card h-100 am-card">
		<div class="card-body d-flex flex-column">
			<button type="button" class="am-fav" data-fav aria-label="{{ __('Save') }} {{ $title }}"><i class="icon-heart"></i></button>
			<div class="d-flex align-items-start gap-3 pe-4 am-head">
				<span class="im-module-icon bg-primary-light">
					@if(!empty($logo))
						<img src="{{ $logo }}" alt="{{ $title }}">
					@else
						{{ strtoupper(mb_substr($title, 0, 1)) }}
					@endif
				</span>
				<div>
					<h3 class="h6 fw-bold">{{ $title }}</h3>
					<div class="d-flex flex-wrap gap-2"><span class="am-badge {{ $badgeClass }}">{{ $badgeLabel }}</span></div>
				</div>
			</div>
			<div class="am-meta mt-2"><span class="am-star">★★★★★</span> <span class="am-rating-score">(4.8)</span><span class="am-sep">|</span><span class="am-rating-count">{{ number_format($dlCount) }} {{ $dlCount === 1 ? __('install') : __('installs') }}</span></div>
			@if($updated !== '')
				<div class="am-meta am-updated mt-1"><i class="icon-clock"></i> {{ __('Updated') }} {{ $updated }}</div>
			@endif
			<div class="am-meta am-ok fw-semibold mt-1">
				{{-- @if (version_compare(config('constants.version'), $version, '>=')) --}}
				<i class="icon-circle-check"></i> {{ __('Compatible with your W3CMS (v:version+)', ['version' => config('constants.version')]) }}
				{{-- @else
				<i class="icon-circle-x"></i> {{ __('Not compatible with your W3CMS (v:version+)', ['version' => config('constants.version')]) }}
				@endif --}}
			</div>
			<p class="am-desc mt-2 mb-3 flex-grow-1">{{ \Str::limit($descPlain, 160) }}</p>
			<div class="row g-2 mt-auto">
				<div class="col-6">
					@if($installed)
						<a class="btn btn-light w-100" data-installed-link href="{{ route('modules.admin.index') }}">{{ __('Installed') }}</a>
					@else
						<a class="btn btn-primary w-100" href="{{ route('modules.admin.install_confirm', ['slug' => $slug]) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">{{ __('Install Now') }}</a>
						<a class="btn btn-light w-100 d-none" data-installed-link href="{{ route('modules.admin.index') }}">{{ __('Installed') }}</a>
					@endif
				</div>
				<div class="col-6"><a class="btn btn-light w-100" href="{{ route('modules.admin.module_details', ['slug' => $slug]) }}" data-details data-name="{{ $title }}">{{ __('View Details') }}</a></div>
			</div>
		</div>
	</article>
</div>
