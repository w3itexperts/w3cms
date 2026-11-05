{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid installed-modules-page add-modules-page">
	@if(!empty($api_error))
		<div class="alert alert-danger">{{ __('Could not reach the module store:') }} {{ $api_error }}</div>
	@endif
	@if(!empty($installed_module))
		<div class="alert alert-success">{{ __('Module') }} {{ $installed_module }} {{ __('installed successfully.') }}</div>
	@endif
	@if(!empty($install_error))
		<div class="alert alert-danger">{{ $install_error }}</div>
	@endif

	<div class="im-header">
		<div>
			<h4 class="im-title">{{ __('Add Modules') }}</h4>
			<p class="im-subtitle">{{ __('Extend your website with powerful modules. Browse, install and activate modules from W3CMS.in.') }}</p>
		</div>
		<a class="btn btn-primary" href="{{ route('modules.admin.upload_module') }}"><i class="icon-upload"></i> {{ __('Upload Module') }}</a>
	</div>
	<div class="row align-items-center g-3 mb-3">
		<div class="col-xl-6">
			<div class="input-group">
				<input type="search" class="form-control" id="amSearch" placeholder="{{ __('Search modules... (name, description, author, tag)') }}" aria-label="{{ __('Search modules') }}">
				<select class="form-select flex-grow-0" id="amKeyword" aria-label="{{ __('Keyword') }}" style="width:8.5rem">
					<option value="all">{{ __('Keyword') }}</option>
					<option value="name">{{ __('Name') }}</option>
					<option value="author">{{ __('Author') }}</option>
					<option value="tag">{{ __('Tag') }}</option>
				</select>
				<button type="button" class="btn btn-primary" id="amSearchBtn"><i class="icon-search"></i> {{ __('Search') }}</button>
			</div>
		</div>
		<div class="col-xl-6">
			<div class="am-chips d-inline-flex gap-2 bg-white border rounded-3 px-2 pt-2 pb-3 mb-0 justify-content-xl-end ms-auto" id="amChips">
				<button type="button" class="am-chip is-active" data-chip="featured"><i class="icon-star"></i> {{ __('Featured') }}</button>
				<button type="button" class="am-chip" data-chip="popular"><i class="icon-flame"></i> {{ __('Popular') }}</button>
				<button type="button" class="am-chip" data-chip="recommended"><i class="icon-thumbs-up"></i> {{ __('Recommended') }}</button>
				<button type="button" class="am-chip" data-chip="newest"><i class="icon-sparkles"></i> {{ __('Newest') }}</button>
				<button type="button" class="am-chip" data-chip="updated"><i class="icon-refresh-cw"></i> {{ __('Recently Updated') }}</button>
			</div>
		</div>
	</div>
	<div class="row g-3" id="amGrid">
		@foreach(($modules ?? []) as $module)
			@include('admin.modules.module_card')
		@endforeach
	</div>
	<p class="text-secondary mt-3 d-none" id="amEmpty">{{ __('No modules match this search.') }}</p>
</div>

@include('admin.modules.module_dialogs')

@endsection

@push('inline-css')
<link href="{{ theme_asset('css/installed-modules.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ theme_asset('css/modules.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ theme_asset('css/add-modules.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
<script>
	'use strict';
	(function () {
		var chip = "featured";
		var items = Array.prototype.slice.call(document.querySelectorAll(".am-item"));
		var addModuleRoute = '{{ route('modules.admin.add_module') }}';
		var installRoute = '{{ route('modules.admin.install_module') }}';
		var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		var ajaxLoader = '<div class="d-flex p-3 flex-column align-items-center"><img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading"><span>&nbsp;&nbsp;Loading...</span></div>';
		var trouble = "Sorry! There is some problem. please check function calling.";
		// The install-confirm content loads into the layout #AjaxModalBoxXl; the design's
		// #modInstall CSS is re-scoped to .mod-install (see css/add-modules.css).
		var modalXl = document.getElementById("AjaxModalBoxXl");
		if (modalXl) {
			modalXl.addEventListener("hidden.bs.modal", function () {
				modalXl.classList.remove("mod-install");
			});
		}

		function setGridLoading(on) {
			var grid = document.getElementById("amGrid");
			var btn = document.getElementById("amSearchBtn");
			if (grid) {
				grid.classList.toggle("opacity-50", on);
				grid.classList.toggle("pe-none", on);
			}
			if (btn) btn.disabled = on;
		}
		function updateEmpty() {
			var empty = document.getElementById("amEmpty");
			if (empty) empty.classList.toggle("d-none", items.length > 0);
		}
		function loadHtml(url) {
			return fetch(url, { headers: { "Accept": "text/html", "X-Requested-With": "XMLHttpRequest" } })
				.then(function (response) {
					if (!response.ok) throw new Error("Request failed.");
					return response.text();
				});
		}
		function fetchModules() {
			var body = new URLSearchParams();
			body.set("search_apps", document.getElementById("amSearch").value.trim());
			body.set("keyword", document.getElementById("amKeyword").value);
			body.set("filter", chip);
			setGridLoading(true);
			fetch(addModuleRoute, {
				method: "POST",
				headers: { "X-CSRF-TOKEN": csrf, "Accept": "text/html", "X-Requested-With": "XMLHttpRequest" },
				body: body
			})
			.then(function (response) {
				if (!response.ok) throw new Error("Request failed.");
				return response.text();
			})
			.then(function (html) {
				document.getElementById("amGrid").innerHTML = html;
				items = Array.prototype.slice.call(document.querySelectorAll("#amGrid .am-item"));
				updateEmpty();
			})
			.catch(function () {
				alert(trouble);
			})
			.then(function () {
				setGridLoading(false);
			});
		}
		// Markup-driven AJAX modal: <a data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" href="...">
		document.addEventListener("click", function (event) {
			var link = event.target.closest('a[data-bs-toggle="modal"][data-bs-target="#AjaxModalBoxXl"]');
			if (!link) return;
			event.preventDefault();
			var url = link.getAttribute("href");
			if (!url || url === "#") return;
			var modalEl = document.getElementById("AjaxModalBoxXl");
			var container = document.getElementById("AjaxResultContainerXl");
			if (container) container.innerHTML = ajaxLoader;
			document.querySelectorAll(".offcanvas.show").forEach(function (el) {
				var offcanvas = bootstrap.Offcanvas.getInstance(el);
				if (offcanvas) offcanvas.hide();
			});
			loadHtml(url)
				.then(function (html) {
					if (container) container.innerHTML = html;
					if (modalEl) modalEl.classList.add("mod-dialog", "mod-install");
					bootstrap.Modal.getOrCreateInstance(modalEl).show();
				})
				.catch(function () {
					alert(trouble);
				});
		});
		// AJAX offcanvas: [data-details] href -> #modDetails body
		document.addEventListener("click", function (event) {
			var link = event.target.closest("[data-details]");
			if (!link) return;
			event.preventDefault();
			var url = link.getAttribute("href");
			if (!url || url === "#") return;
			var body = document.getElementById("modDetailsBody");
			if (body) body.innerHTML = ajaxLoader;
			loadHtml(url)
				.then(function (html) {
					if (body) body.innerHTML = html;
					bootstrap.Offcanvas.getOrCreateInstance(document.getElementById("modDetails")).show();
				})
				.catch(function () {
					if (body) body.innerHTML = "";
					alert(trouble);
				});
		});
		// Install confirm -> timeline drawer + real install request
		document.addEventListener("click", function (event) {
			var btn = event.target.closest("#modInstallGo");
			if (!btn) return;
			var modal = bootstrap.Modal.getInstance(document.getElementById("AjaxModalBoxXl"));
			if (modal) modal.hide();
			runProgress(btn.getAttribute("data-package"), btn.getAttribute("data-slug"), {
				name: btn.dataset.name || "",
				desc: btn.dataset.desc || "",
				version: btn.dataset.version || "",
				author: btn.dataset.author || "",
				size: btn.dataset.size || "",
				type: btn.dataset.type || "",
				tone: btn.dataset.tone || "",
				icon: btn.dataset.icon || "",
				requires: "{{ __('Checked during installation') }}",
				verb: "{{ __('installation') }}"
			});
		});
		var modSteps = [
			["{{ __('Downloading Package') }}", "{{ __('Downloading from W3CMS.in...') }}"],
			["{{ __('Validating Package') }}", "{{ __('Checking ZIP file structure and module.json...') }}"],
			["{{ __('Checking Compatibility') }}", "{{ __('Verifying PHP and W3CMS version requirements...') }}"],
			["{{ __('Checking Dependencies') }}", "{{ __('Validating required modules...') }}"],
			["{{ __('Extracting Files') }}", "{{ __('Extracting module files to /Modules/{slug}...') }}"],
			["{{ __('Registering Module') }}", "{{ __('Enabling the module and running migrations...') }}"],
			["{{ __('Refreshing Cache') }}", "{{ __('Clearing configuration, route and application caches...') }}"],
			["{{ __('Finalizing Installation') }}", "{{ __('Seeding data and verifying the installation...') }}"]
		];
		function escHtml(value) {
			return String(value == null ? "" : value).replace(/[&<>"']/g, function (c) {
				return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
			});
		}
		function progressMarkup(info, slug) {
			var meta = [
				["{{ __('Version') }}", info.version ? "v" + info.version : "—"],
				["{{ __('Author') }}", info.author],
				["{{ __('Technology') }}", "Laravel"],
				["{{ __('Package Size') }}", info.size || "—"],
				["{{ __('Requires') }}", info.requires]
			].map(function (pair) {
				return '<span class="k">' + escHtml(pair[0]) + '</span><span class="v">' + escHtml(pair[1]) + '</span>';
			}).join("");
			var iconHtml = info.icon
				? '<img src="' + escHtml(info.icon) + '" alt="' + escHtml(info.name) + '">'
				: escHtml((info.name || "?").charAt(0).toUpperCase());
			return '<div class="mod-pcard">' +
				'<span class="im-module-icon ' + escHtml(info.tone) + '">' + iconHtml + '</span>' +
				'<div class="mod-pinfo"><div class="mod-pname"><h6>' + escHtml(info.name) + '</h6><span class="mod-pill is-primary">' + escHtml(info.type) + '</span></div>' +
				'<p>' + escHtml(info.desc) + '</p></div>' +
				'<div class="mod-pmeta">' + meta + '</div></div>' +
				'<ol class="mod-ptl">' + modSteps.map(function (step, i) {
					return '<li class="mod-pstep"><span class="mod-pnode">' + (i + 1) + '</span>' +
						'<div class="mod-pbox"><div class="mod-ptext">' +
						'<div class="mod-ptitle">' + escHtml(step[0]) + '</div>' +
						'<div class="mod-pdesc">' + escHtml(step[1]).replace("{slug}", escHtml(slug)) + '</div></div>' +
						'<div class="mod-pside"></div></div></li>';
				}).join("") + '</ol>' +
				'<div class="mod-pnote"><i class="icon-info"></i><div><strong>{{ __('Please do not close this window') }}</strong>' +
				'<p>{{ __('The :verb process may take a few moments. Keep this window open until the :verb is complete.', ['verb' => 'installation']) }}</p></div></div>';
		}
		function animateBar(row) {
			var fill = row.querySelector(".mod-pbar span");
			var pct = row.querySelector(".mod-ppct");
			var start = performance.now();
			function frame(now) {
				var ratio = Math.min(1, (now - start) / 400);
				var value = Math.round(ratio * 100);
				if (fill) fill.style.width = value + "%";
				if (pct) pct.textContent = value + "%";
				if (ratio < 1) requestAnimationFrame(frame);
			}
			requestAnimationFrame(frame);
		}
		function runProgress(packageUrl, slug, info) {
			if (!packageUrl || !slug) return;
			var body = document.getElementById("modProgressBody");
			body.innerHTML = progressMarkup(info, slug);
			bootstrap.Offcanvas.getOrCreateInstance(document.getElementById("modProgress")).show();
			var rows = body.querySelectorAll(".mod-pstep");
			var durations = [];
			var messages = [];
			var stage = 0;
			var token = "";
			function setDesc(i, text) {
				var desc = rows[i].querySelector(".mod-pdesc");
				if (desc && text) desc.textContent = text;
			}
			function markDone(i, dur) {
				rows[i].classList.remove("is-active");
				rows[i].classList.add("is-done");
				var side = rows[i].querySelector(".mod-pside");
				side.innerHTML = '<span class="mod-pdur">' + escHtml(dur) + '</span>' +
					'<span class="mod-pdone"><i class="icon-circle-check"></i>{{ __('Completed') }}</span>';
				if (messages[i]) setDesc(i, messages[i]);
			}
			function markAllDone() {
				rows.forEach(function (row, i) {
					if (!row.classList.contains("is-done")) markDone(i, durations[i] || "—");
				});
			}
			function finishError(message, failedIndex) {
				var row = failedIndex != null ? rows[failedIndex] : null;
				if (row) {
					row.classList.remove("is-active");
					row.classList.add("is-error");
					setDesc(failedIndex, message);
					var side = row.querySelector(".mod-pside");
					if (side) {
						side.innerHTML = '<span class="mod-pfail"><i class="icon-x"></i>{{ __('Failed') }}</span>';
					}
				} else {
					var note = document.createElement("div");
					note.className = "mod-note danger mt-3 dynamic-install-error";
					note.textContent = message;
					body.appendChild(note);
				}
			}
			function nextStage() {
				if (stage >= rows.length) {
					markAllDone();
					return;
				}
				var i = stage;
				var side = rows[i].querySelector(".mod-pside");
				rows[i].classList.add("is-active");
				side.innerHTML = '<div class="mod-pbar"><span></span></div><span class="mod-ppct">0%</span>';
				animateBar(rows[i]);
				var started = performance.now();
				var req = new URLSearchParams();
				req.set("package", packageUrl);
				req.set("module_name", slug);
				req.set("stage", String(i + 1));
				if (token) req.set("token", token);
				fetch(installRoute, {
					method: "POST",
					headers: { "X-CSRF-TOKEN": csrf, "Accept": "application/json", "X-Requested-With": "XMLHttpRequest" },
					body: req
				})
				.then(function (response) {
					return response.text().then(function (raw) {
						var data;
						try { data = JSON.parse(raw); } catch (e) { throw new Error("Installation failed."); }
						if (!response.ok || !data.success) throw new Error(data.message || "Installation failed.");
						return data;
					});
				})
				.then(function (data) {
					if (data.token) token = data.token;
					durations[i] = ((performance.now() - started) / 1000).toFixed(1) + "s";
					messages[i] = data.message || "";
					markDone(i, durations[i]);
					stage += 1;
					if (stage >= rows.length) {
						markAllDone();
						if (window.toastr) toastr.success(data.message || "Installation complete.");
						fetchModules();
					} else {
						nextStage();
					}
				})
				.catch(function (err) {
					finishError(err.message || "Installation failed.", i);
				});
			}
			nextStage();
		}
		// Details drawer tabs (content is AJAX-loaded)
		document.addEventListener("click", function (event) {
			var btn = event.target.closest("#modDetailTabs [data-panel]");
			if (!btn) return;
			document.querySelectorAll("#modDetailTabs [data-panel]").forEach(function (el) {
				el.classList.toggle("is-active", el === btn);
			});
			document.querySelectorAll("[data-panel-body]").forEach(function (el) {
				el.hidden = el.dataset.panelBody !== btn.dataset.panel;
			});
		});
		// Favourites + chips/search
		document.getElementById("amGrid").addEventListener("click", function (event) {
			var fav = event.target.closest("[data-fav]");
			if (fav) fav.classList.toggle("is-on");
		});
		document.getElementById("amChips").addEventListener("click", function (event) {
			var btn = event.target.closest("[data-chip]");
			if (!btn) return;
			chip = btn.dataset.chip;
			document.querySelectorAll("#amChips .am-chip").forEach(function (el) {
				el.classList.toggle("is-active", el === btn);
			});
			fetchModules();
		});
		document.getElementById("amSearchBtn").addEventListener("click", function () {
			fetchModules();
		});
		document.getElementById("amSearch").addEventListener("keydown", function (event) {
			if (event.key === "Enter") document.getElementById("amSearchBtn").click();
		});
		updateEmpty();
	})();
</script>
@endpush
