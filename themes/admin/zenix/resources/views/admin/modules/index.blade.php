@extends('admin.layout.default')

@section('content')

@php
	$filters = $filters ?? ['search' => '', 'type' => '', 'status' => '', 'update' => ''];
@endphp

<div class="container-fluid installed-modules-page">
	<div class="row align-items-start g-3 mb-3">
		<div class="col-12 col-lg-7">
			<h4 class="im-title">{{ __('Installed Modules') }}</h4>
			<p class="im-subtitle">{{ __('Manage your installed modules. Enable, disable, update or remove modules from your W3CMS installation.') }}</p>
		</div>
		<div class="col-12 col-lg-5 text-lg-end">
			<a class="btn btn-primary im-add-btn" href="{{ route('modules.admin.add_module') }}">
				<i class="icon-plus im-add-icon"></i> {{ __('Add Module') }}
			</a>
		</div>
	</div>

	<div class="row g-3 mb-3 im-stats">
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-purple"><i class="icon-box"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Total Modules') }}</span>
					<span class="im-stat-value" id="imStatTotal">{{ $stats['total'] }}</span>
					<span class="im-stat-hint">{{ __('All installed modules') }}</span>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-success"><i class="icon-play"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Active Modules') }}</span>
					<span class="im-stat-value" id="imStatActive">{{ $stats['active'] }}</span>
					<span class="im-stat-hint">{{ __('Currently enabled') }}</span>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-pink"><i class="icon-pause"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Inactive Modules') }}</span>
					<span class="im-stat-value" id="imStatInactive">{{ $stats['inactive'] }}</span>
					<span class="im-stat-hint">{{ __('Currently disabled') }}</span>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-warning"><i class="icon-refresh-cw"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Updates Available') }}</span>
					<span class="im-stat-value" id="imStatUpdates">{{ $stats['updates'] ?? '—' }}</span>
					<span class="im-stat-hint">{{ __('New versions available') }}</span>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-blue"><i class="icon-layers"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Core Modules') }}</span>
					<span class="im-stat-value" id="imStatCore">0</span>
					<span class="im-stat-hint">{{ __('System core modules') }}</span>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
			<div class="im-stat">
				<span class="im-stat-icon tone-teal"><i class="icon-puzzle"></i></span>
				<div>
					<span class="im-stat-label">{{ __('Add-on Modules') }}</span>
					<span class="im-stat-value" id="imStatAddon">0</span>
					<span class="im-stat-hint">{{ __('Dependent modules') }}</span>
				</div>
			</div>
		</div>
	</div>

	<form class="card im-toolbar-card mb-3" id="imFilterForm" method="get" action="{{ route('modules.admin.index') }}">
		<div class="card-body">
			<div class="row g-2 align-items-center">
				<div class="col-12 col-lg-4">
					<div class="im-search">
						<i class="icon-search im-search-icon" aria-hidden="true"></i>
						<input type="text" class="form-control im-search-input" id="imSearch" name="search"
							value="{{ $filters['search'] }}"
							placeholder="{{ __('Search installed modules...') }}" aria-label="{{ __('Search installed modules') }}">
					</div>
				</div>
				<div class="col-12 col-lg-8">
					<div class="row g-2">
						<div class="col">
							<select class="form-select im-select" id="imType" name="type" aria-label="{{ __('Filter by type') }}">
								<option value="">{{ __('All Types') }}</option>
								<option value="parent" @selected($filters['type'] === 'parent')>{{ __('Parent') }}</option>
								<option value="addon" @selected($filters['type'] === 'addon')>{{ __('Add-on') }}</option>
								<option value="standard" @selected($filters['type'] === 'standard')>{{ __('Standard') }}</option>
								<option value="core" @selected($filters['type'] === 'core')>{{ __('Core') }}</option>
							</select>
						</div>
						<div class="col">
							<select class="form-select im-select" id="imStatus" name="status" aria-label="{{ __('Filter by status') }}">
								<option value="">{{ __('All Status') }}</option>
								<option value="active" @selected($filters['status'] === 'active')>{{ __('Active') }}</option>
								<option value="inactive" @selected($filters['status'] === 'inactive')>{{ __('Inactive') }}</option>
							</select>
						</div>
						<div class="col">
							<select class="form-select im-select" id="imUpdate" name="update" aria-label="{{ __('Filter by update status') }}">
								<option value="">{{ __('All Update Status') }}</option>
								<option value="current" @selected($filters['update'] === 'current')>{{ __('Up to date') }}</option>
								<option value="available" @selected($filters['update'] === 'available')>{{ __('Update available') }}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="card im-bulk-card mb-3">
		<div class="card-body py-2">
			<div class="row g-2 align-items-center">
				<div class="col-auto">
					<input type="checkbox" class="form-check-input" id="imBulkAll" aria-label="{{ __('Select all modules on this page') }}">
				</div>
				<div class="col-auto">
					<select class="form-select im-bulk-select" id="imBulk" aria-label="{{ __('Bulk actions') }}">
						<option value="">{{ __('Bulk Actions') }}</option>
						<option value="activate">{{ __('Activate') }}</option>
						<option value="deactivate">{{ __('Deactivate') }}</option>
						<option value="update">{{ __('Update') }}</option>
						<option value="delete">{{ __('Delete') }}</option>
					</select>
				</div>
				<div class="col-auto">
					<button type="button" class="btn btn-primary im-apply" id="imApply">{{ __('Apply') }}</button>
				</div>
				<div class="col"></div>
				<div class="col-auto">
					<span class="im-count" id="imCount">{{ $count }} {{ $count === 1 ? __('module found') : __('modules found') }}</span>
				</div>
				<div class="col-auto">
					<div class="im-pager" id="imPager"></div>
				</div>
			</div>
		</div>
	</div>

	<div id="imTableWrap">
		@include('admin.modules.list_view')
	</div>

	<div class="im-empty" id="imEmpty" @if($count > 0) hidden @endif>
		<i class="icon-search" aria-hidden="true"></i>
		<p class="im-empty-title">{{ __('No modules found') }}</p>
		<p class="im-empty-text">{{ __('Try a different search or clear the filters.') }}</p>
		<button type="button" class="btn btn-light mt-3" id="imClear">{{ __('Clear Filters') }}</button>
	</div>

	<div class="offcanvas offcanvas-end" tabindex="-1" id="moduleDetailsDrawer" aria-labelledby="moduleDetailsLabel"></div>
</div>

@endsection

@push('inline-css')
<link href="{{ theme_asset('css/installed-modules.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ theme_asset('css/modules.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
<script>
	'use strict';
	(function () {
		var filterForm = document.getElementById('imFilterForm');
		if (!filterForm) return;
		var wrap = document.getElementById('imTableWrap');
		var emptyEl = document.getElementById('imEmpty');
		var modalEl = document.getElementById('AjaxModalBoxXl');
		var modalBody = document.getElementById('AjaxResultContainerXl');
		var bulkUrl = '{{ route('modules.admin.bulk_action') }}';
		var autoUpdateUrl = '{{ route('modules.admin.auto_update') }}';
		var csrfMeta = document.querySelector('meta[name="csrf-token"]');
		var csrf = csrfMeta ? csrfMeta.getAttribute('content') : '';
		var trouble = 'Sorry! There is some problem. please check function calling.';
		var ajaxLoader = '<div class="d-flex p-3 flex-column align-items-center"><img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading"><span>&nbsp;&nbsp;Loading...</span></div>';
		var searchTimer = null;
		var fetchSeq = 0;

		function toast(type, message) {
			if (window.toastr && typeof toastr[type] === 'function') toastr[type](message);
			else if (type === 'error') alert(message);
		}
		function setText(id, value) {
			var el = document.getElementById(id);
			if (el) el.textContent = value == null ? '' : value;
		}
		function loadHtml(url) {
			return fetch(url, { headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' } })
				.then(function (response) {
					if (!response.ok) throw new Error(trouble);
					return response.text();
				});
		}
		function loadJson(url) {
			return fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
				.then(function (response) { return response.json(); });
		}
		function closeModal() {
			var instance = modalEl && bootstrap.Modal.getInstance(modalEl);
			if (instance) instance.hide();
		}
		function setRowChecks(checked) {
			if (!wrap) return;
			Array.prototype.forEach.call(wrap.querySelectorAll('.im-check'), function (box) {
				box.checked = checked;
			});
		}

		// Server-rendered rows + count + stats (latest request wins)
		function fetchRows() {
			var seq = ++fetchSeq;
			var url = filterForm.action + '?' + new URLSearchParams(new FormData(filterForm)).toString();
			loadJson(url).then(function (data) {
				if (seq !== fetchSeq) return;
				if (wrap) wrap.innerHTML = data.table_html || '';
				setText('imCount', data.count_text);
				if (emptyEl) emptyEl.hidden = !data.empty;
				if (data.stats) {
					setText('imStatTotal', data.stats.total);
					setText('imStatActive', data.stats.active);
					setText('imStatInactive', data.stats.inactive);
					if (data.stats.updates !== null && data.stats.updates !== undefined) {
						setText('imStatUpdates', data.stats.updates);
					}
				}
			}).catch(function () {
				if (seq === fetchSeq) toast('error', trouble);
			});
		}

		// Filters: submit, selects, search debounce
		filterForm.addEventListener('submit', function (event) {
			event.preventDefault();
			fetchRows();
		});
		filterForm.addEventListener('change', function (event) {
			if (event.target && event.target.tagName === 'SELECT') fetchRows();
		});
		var searchInput = document.getElementById('imSearch');
		if (searchInput) {
			searchInput.addEventListener('input', function () {
				clearTimeout(searchTimer);
				searchTimer = setTimeout(fetchRows, 300);
			});
		}

		// [data-load-modal] -> confirm fragment into #AjaxModalBoxXl
		// [data-load-canvas="#sel"] -> drawer fragment
		// [data-view-dependents="Name"] -> close confirm, filter list to that module
		document.addEventListener('click', function (event) {
			var depBtn = event.target.closest('[data-view-dependents]');
			if (depBtn && document.contains(depBtn)) {
				event.preventDefault();
				var depName = depBtn.getAttribute('data-view-dependents') || '';
				closeModal();
				if (searchInput) {
					searchInput.value = depName;
				}
				fetchRows();
				return;
			}
			var modalLink = event.target.closest('[data-load-modal]');
			if (modalLink && document.contains(modalLink)) {
				event.preventDefault();
				var modalUrl = modalLink.getAttribute('href');
				if (!modalUrl || modalUrl === '#') return;
				if (modalBody) modalBody.innerHTML = ajaxLoader;
				if (modalEl) modalEl.classList.add('mod-dialog');
				bootstrap.Modal.getOrCreateInstance(modalEl).show();
				loadHtml(modalUrl).then(function (html) {
					if (modalBody) modalBody.innerHTML = html;
				}).catch(function () {
					toast('error', trouble);
				});
				return;
			}
			var canvasLink = event.target.closest('[data-load-canvas]');
			if (canvasLink && document.contains(canvasLink)) {
				event.preventDefault();
				var canvasUrl = canvasLink.getAttribute('href');
				var canvas = document.querySelector(canvasLink.getAttribute('data-load-canvas'));
				if (!canvasUrl || canvasUrl === '#' || !canvas) return;
				canvas.innerHTML = ajaxLoader;
				loadHtml(canvasUrl).then(function (html) {
					canvas.innerHTML = html;
					bootstrap.Offcanvas.getOrCreateInstance(canvas).show();
				}).catch(function () {
					toast('error', trouble);
				});
			}
		});

		// Confirm button: existing action route as XHR -> JSON -> toast + refresh
		document.addEventListener('click', function (event) {
			var btn = event.target.closest('[data-action-run]');
			if (!btn || !document.contains(btn)) return;
			event.preventDefault();
			var actionUrl = btn.getAttribute('href');
			if (!actionUrl || actionUrl === '#') return;
			btn.classList.add('pe-none');
			loadJson(actionUrl).then(function (data) {
				btn.classList.remove('pe-none');
				if (data.success) {
					closeModal();
					fetchRows();
				}
				toast(data.success ? 'success' : 'error', data.message || trouble);
			}).catch(function () {
				btn.classList.remove('pe-none');
				toast('error', trouble);
			});
		});

		// Select-all sync (delegated: survives table re-render)
		document.addEventListener('change', function (event) {
			var target = event.target;
			if (!target || !document.contains(target)) return;
			if (target.id === 'imSelectAll' || target.id === 'imBulkAll') {
				var other = document.getElementById(target.id === 'imSelectAll' ? 'imBulkAll' : 'imSelectAll');
				if (other) other.checked = target.checked;
				setRowChecks(target.checked);
			}
			if (target.classList && target.classList.contains('im-check')) {
				var row = target.closest('tr.im-row');
				if (row) row.classList.toggle('is-selected', target.checked);
			}
		});

		// Auto update switch -> POST preference -> module.json (revert on failure)
		document.addEventListener('change', function (event) {
			var input = event.target;
			if (!input || !input.classList || !input.classList.contains('im-auto')) return;
			var row = input.closest('tr.im-row');
			var nameEl = row ? row.querySelector('.im-module-name') : null;
			var name = nameEl ? nameEl.textContent.trim() : '';
			if (!name) {
				input.checked = !input.checked;
				return;
			}
			var wasChecked = input.checked;
			input.disabled = true;
			fetch(autoUpdateUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrf,
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: new URLSearchParams({ module: name, auto: wasChecked ? '1' : '0' }).toString()
			}).then(function (response) {
				return response.json();
			}).then(function (data) {
				input.disabled = false;
				toast(data.success ? 'success' : 'error', data.message || trouble);
				if (!data.success) input.checked = !wasChecked;
			}).catch(function () {
				input.disabled = false;
				input.checked = !wasChecked;
				toast('error', trouble);
			});
		});

		// Bulk actions -> POST JSON -> toast + refresh
		document.addEventListener('click', function (event) {
			var applyBtn = event.target.closest('#imApply');
			if (!applyBtn || !document.contains(applyBtn)) return;
			var actionEl = document.getElementById('imBulk');
			var action = actionEl ? actionEl.value : '';
			var checked = wrap ? Array.prototype.slice.call(wrap.querySelectorAll('.im-check:checked')) : [];
			if (!action) {
				toast('warning', {!! json_encode(__('Choose a bulk action first.')) !!});
				return;
			}
			if (!checked.length) {
				toast('warning', {!! json_encode(__('Select at least one module first.')) !!});
				return;
			}
			var body = new URLSearchParams();
			body.set('action', action);
			checked.forEach(function (box) { body.append('modules[]', box.value); });
			applyBtn.classList.add('pe-none');
			fetch(bulkUrl, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrf,
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: body.toString()
			}).then(function (response) {
				return response.json();
			}).then(function (data) {
				applyBtn.classList.remove('pe-none');
				toast(data.success ? 'success' : 'warning', data.message);
				fetchRows();
			}).catch(function () {
				applyBtn.classList.remove('pe-none');
				toast('error', trouble);
			});
		});

		// Clear filters (empty state)
		document.addEventListener('click', function (event) {
			if (!event.target.closest('#imClear')) return;
			filterForm.reset();
			fetchRows();
		});
	})();
</script>
@endpush
