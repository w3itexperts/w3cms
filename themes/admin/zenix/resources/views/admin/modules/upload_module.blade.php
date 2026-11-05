{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid upload-module-page">
	<div class="um-layout">
		<div class="um-main">
			<div class="im-header">
				<div>
					<h4 class="im-title">{{ __('Upload Module') }}</h4>
					<p class="im-subtitle">{{ __('Install a module from a ZIP package. You can upload a module developed by you or from a third party.') }}</p>
				</div>
			</div>

			<div class="um-card">
				<section class="um-sec um-sec-drop">
					<div class="um-drop" id="umDrop">
						<i class="icon-cloud-upload um-drop-ico"></i>
						<p class="um-drop-title">{{ __('Drag & Drop Module ZIP File Here') }}</p>
						<p class="um-drop-or">{{ __('or') }}</p>
						<label class="btn btn-primary um-drop-btn"><i class="icon-folder-open"></i> {{ __('Choose ZIP File') }}
							<input type="file" id="umFile" accept=".zip,application/zip" hidden>
						</label>
						<p class="um-drop-note">{{ __('Only .zip packages are supported. Maximum file size is 200MB.') }}</p>
					</div>
					<div class="um-drop" id="umBusy" hidden>
						<span class="spinner-border mb-2" role="status" aria-hidden="true"></span>
						<p class="um-drop-title" id="umBusyText">{{ __('Uploading package...') }}</p>
					</div>
					<div class="mod-note danger mt-2" id="umDropErr" hidden></div>
				</section>

				<div id="umDetected" hidden>
					<section class="um-sec um-sec-banner">
						<div class="um-banner" id="umBanner">
							<span class="um-banner-ico" id="umBannerIco"><i class="icon-check"></i></span>
							<div class="um-banner-txt">
								<strong id="umBannerTitle">{{ __('Module Package Detected') }}</strong>
								<p id="umBannerText">{{ __('The uploaded file is a valid W3CMS module package.') }}</p>
							</div>
							<button type="button" class="btn um-change" id="umChange"><i class="icon-rotate-cw"></i> {{ __('Change File') }}</button>
						</div>
					</section>

					<section class="um-sec um-sec-pkg">
						<div class="um-pkg">
							<span class="um-pkg-ico"><i class="icon-package"></i></span>
							<div class="um-pkg-txt">
								<h6 class="um-pkg-title"><span id="umPkgName"></span> <span class="mod-pill um-pkg-pill" id="umPkgPill" hidden></span></h6>
								<p class="um-pkg-desc" id="umPkgDesc"></p>
							</div>
							<table class="mod-meta-table um-meta">
								<tbody id="umMetaRows"></tbody>
							</table>
						</div>
						<div class="row um-checks">
							<div class="col-md-3">
								<div class="um-check" id="umChkPkg">
									<div class="um-check-h"><i class="icon-clipboard-list"></i>{{ __('Package Validation') }}</div>
									<ul id="umChkPkgList"></ul>
								</div>
							</div>
							<div class="col-md-3">
								<div class="um-check" id="umChkCompat">
									<div class="um-check-h"><i class="icon-circle-check"></i>{{ __('Compatibility Check') }}</div>
									<ul id="umChkCompatList"></ul>
								</div>
							</div>
							<div class="col-md-3">
								<div class="um-check" id="umChkDeps">
									<div class="um-check-h"><i class="icon-circle-check"></i>{{ __('Dependency Check') }}</div>
									<ul id="umChkDepsList"></ul>
								</div>
							</div>
							<div class="col-md-3">
								<div class="um-check" id="umChkSec">
									<div class="um-check-h"><i class="icon-shield"></i>{{ __('Security Scan') }}</div>
									<ul id="umChkSecList"></ul>
								</div>
							</div>
						</div>
					</section>

					<section class="um-sec um-sec-tabs">
						<div class="mod-tabs" id="umTabs">
							<button type="button" class="is-active" data-um="info"><i class="icon-info"></i> {{ __('Module Information') }}</button>
							<button type="button" data-um="files"><i class="icon-file-text"></i> {{ __('Files Preview') }}</button>
							<button type="button" data-um="json"><i class="icon-braces"></i> {{ __('Raw module.json') }}</button>
						</div>
					</section>

					<section class="um-sec um-sec-info">
						<div class="um-info" id="umPanelInfo">
							<div>
								<h6>{{ __('Description') }}</h6>
								<p id="umInfoDesc"></p>
							</div>
							<div id="umFeatWrap">
								<h6>{{ __('Key Features') }}</h6>
								<ul class="um-feats" id="umInfoFeats"></ul>
							</div>
						</div>

						<div class="um-tree" id="umPanelFiles" hidden>
							<div class="um-tree-h">
								<i class="icon-folder-open"></i>
								<span>{{ __('Package Contents') }}</span>
								<em id="umTreeCount"></em>
							</div>
							<ul class="um-tree-l" id="umTreeList"></ul>
						</div>

						<div class="um-raw" id="umPanelJson" hidden>
							<div class="um-raw-h"><i class="icon-code"></i><span>module.json</span></div>
							<pre><code id="umRawJson"></code></pre>
						</div>
					</section>

					<section class="um-sec um-sec-foot">
						<a class="btn um-cancel" href="{{ route('modules.admin.add_module') }}"><i class="icon-x"></i> {{ __('Cancel') }}</a>
						<button type="button" class="btn btn-primary um-install" id="umInstall" disabled><i class="icon-download"></i> {{ __('Install Module') }}</button>
					</section>
				</div>
			</div>
		</div>

		<aside class="um-side">
			<div class="um-scard um-help">
				<div class="um-card-hd">
					<span class="um-hd-tile"><i class="icon-circle-question-mark"></i></span>
					<h6>{{ __('How to Upload Module?') }}</h6>
				</div>
				<ol class="um-steps">
					<li>
						<span class="um-num">1</span>
						<div class="um-step-t">
							<strong>{{ __('Prepare Module ZIP') }}</strong>
							<p>{{ __('Your module should be in a valid W3CMS module structure with module.json file.') }}</p>
						</div>
					</li>
					<li>
						<span class="um-num">2</span>
						<div class="um-step-t">
							<strong>{{ __('Upload File') }}</strong>
							<p>{{ __('Choose or drag & drop your module ZIP file.') }}</p>
						</div>
					</li>
					<li>
						<span class="um-num">3</span>
						<div class="um-step-t">
							<strong>{{ __('Validate') }}</strong>
							<p>{{ __('System will automatically validate the package, check compatibility and dependencies.') }}</p>
						</div>
					</li>
					<li>
						<span class="um-num">4</span>
						<div class="um-step-t">
							<strong>{{ __('Install') }}</strong>
							<p>{{ __('Click on') }} <a href="#umInstall">{{ __('Install Module') }}</a> {{ __('to extract and install the module into your W3CMS installation.') }}</p>
						</div>
					</li>
				</ol>
			</div>

			<div class="um-scard um-notes">
				<div class="um-note">
					<div class="um-card-hd">
						<i class="icon-triangle-alert um-hd-ico um-hd-warn"></i>
						<h6>{{ __('Important Notes') }}</h6>
					</div>
					<ul class="um-note-l">
						<li>{{ __('Upload only trusted module packages.') }}</li>
						<li>{{ __('Make sure the module is compatible with your W3CMS version.') }}</li>
						<li>{{ __('Required dependencies must be installed before installation.') }}</li>
						<li>{{ __('After installation, you can activate the module from Installed Modules.') }}</li>
						<li class="is-dark">{{ __('Maximum file size: 200MB.') }}</li>
					</ul>
				</div>
			</div>

			<div class="um-scard um-links">
				<div class="um-linkbox">
					<div class="um-card-hd">
						<i class="icon-circle-question-mark um-hd-ico um-hd-blue"></i>
						<h6>{{ __('Need Help?') }}</h6>
					</div>
					<ul class="um-link-l">
						<li>
							<span class="um-link-ico"><i class="icon-square-arrow-out-up-right"></i></span>
							<a href="#">{{ __('W3CMS Module Development Guide') }}</a>
						</li>
						<li>
							<span class="um-link-ico"><i class="icon-square-arrow-out-up-right"></i></span>
							<a href="#">{{ __('Module Structure Documentation') }}</a>
						</li>
						<li>
							<span class="um-link-ico"><i class="icon-folder-archive"></i></span>
							<a href="#">{{ __('Example Module Package') }}</a>
						</li>
						<li>
							<span class="um-link-ico"><i class="icon-link"></i></span>
							<a href="https://w3cms.in" target="_blank" rel="noopener">{{ __('Visit W3CMS.in for Official Modules') }}</a>
							<i class="icon-square-arrow-out-up-right um-link-ext"></i>
						</li>
					</ul>
				</div>
			</div>
		</aside>
	</div>
</div>

@include('admin.modules.module_dialogs')

@endsection

@push('inline-css')
<link href="{{ theme_asset('css/installed-modules.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ theme_asset('css/modules.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ theme_asset('css/upload-module.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
<script>
	'use strict';
	(function () {
		var uploadRoute = '{{ route('modules.admin.install_upload_module') }}';
		var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		var maxBytes = 200 * 1024 * 1024;

		var el = {
			drop: document.getElementById('umDrop'),
			file: document.getElementById('umFile'),
			busy: document.getElementById('umBusy'),
			busyText: document.getElementById('umBusyText'),
			dropErr: document.getElementById('umDropErr'),
			detected: document.getElementById('umDetected'),
			banner: document.getElementById('umBanner'),
			bannerIco: document.getElementById('umBannerIco'),
			bannerTitle: document.getElementById('umBannerTitle'),
			bannerText: document.getElementById('umBannerText'),
			change: document.getElementById('umChange'),
			pkgName: document.getElementById('umPkgName'),
			pkgPill: document.getElementById('umPkgPill'),
			pkgDesc: document.getElementById('umPkgDesc'),
			metaRows: document.getElementById('umMetaRows'),
			chkPkg: document.getElementById('umChkPkgList'),
			chkCompat: document.getElementById('umChkCompatList'),
			chkDeps: document.getElementById('umChkDepsList'),
			chkSec: document.getElementById('umChkSecList'),
			install: document.getElementById('umInstall'),
			tabs: document.getElementById('umTabs'),
			panelInfo: document.getElementById('umPanelInfo'),
			panelFiles: document.getElementById('umPanelFiles'),
			panelJson: document.getElementById('umPanelJson'),
			infoDesc: document.getElementById('umInfoDesc'),
			featWrap: document.getElementById('umFeatWrap'),
			infoFeats: document.getElementById('umInfoFeats'),
			treeCount: document.getElementById('umTreeCount'),
			treeList: document.getElementById('umTreeList'),
			rawJson: document.getElementById('umRawJson')
		};

		var token = '';
		var pkg = null;
		var deps = null;
		var msgs = {};
		var durs = {};
		var ready = false;

		function esc(value) {
			return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
				return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
			});
		}
		function str(value) {
			return value == null ? '' : String(value);
		}
		function strip(html) {
			var d = document.createElement('div');
			d.innerHTML = str(html);
			return (d.textContent || '').replace(/\s+/g, ' ').trim();
		}
		function formatSize(bytes) {
			var units = ['B', 'KB', 'MB', 'GB'];
			var i = 0;
			var n = Number(bytes) || 0;
			while (n >= 1024 && i < 3) {
				n /= 1024;
				i++;
			}
			return (i ? n.toFixed(1) : Math.round(n)) + ' ' + units[i];
		}
		function typeLabel(json) {
			var raw = str(json && json.type).trim();
			if (!raw) {
				return 'Plugin';
			}
			var map = {
				p: 'Plugin', t: 'Theme', a: 'Add-on', c: 'Core',
				plugin: 'Plugin', theme: 'Theme', addon: 'Add-on', 'add-on': 'Add-on', core: 'Core'
			};
			return map[raw.toLowerCase()] || raw;
		}
		function authorText(json) {
			if (!json) {
				return '';
			}
			if (typeof json.author === 'string') {
				return json.author.trim();
			}
			if (json.author && typeof json.author === 'object') {
				return str(json.author.name || json.author.email).trim();
			}
			return str(json.author_email).trim();
		}

		function fillList(ul, items) {
			ul.innerHTML = items.map(function (text) {
				return '<li><i class="icon-circle-check"></i><span>' + esc(text) + '</span></li>';
			}).join('');
		}
		function failList(ul, message) {
			ul.innerHTML = '<li class="is-error"><i class="icon-circle-x"></i><span>' + esc(message) + '</span></li>';
		}
		function skipList(ul, message) {
			ul.innerHTML = '<li class="is-skip"><i class="icon-circle-alert"></i><span>' + esc(message) + '</span></li>';
		}

		function setBusy(on, text) {
			el.drop.hidden = on;
			el.busy.hidden = !on;
			if (text) {
				el.busyText.textContent = text;
			}
		}
		function showErr(message) {
			el.dropErr.textContent = message;
			el.dropErr.hidden = false;
		}
		function hideErr() {
			el.dropErr.hidden = true;
		}
		function resetAll() {
			ready = false;
			token = '';
			pkg = null;
			deps = null;
			msgs = {};
			durs = {};
			el.install.disabled = true;
			el.detected.hidden = true;
			el.busy.hidden = true;
			el.drop.hidden = false;
			hideErr();
			el.banner.classList.remove('is-error');
			el.bannerIco.innerHTML = '<i class="icon-check"></i>';
			el.bannerTitle.textContent = '{{ __('Module Package Detected') }}';
			el.bannerText.textContent = '{{ __('The uploaded file is a valid W3CMS module package.') }}';
			el.file.value = '';
		}

		function parseResponse(response) {
			return response.text().then(function (raw) {
				var data = null;
				try {
					data = JSON.parse(raw);
				} catch (e) {
					data = null;
				}
				if (!data) {
					throw new Error(response.ok ? '{{ __('Unexpected server response.') }}' : '{{ __('Request failed.') }}');
				}
				if (!response.ok || !data.success) {
					var message = str(data.message);
					if (!message && data.errors) {
						var keys = Object.keys(data.errors);
						if (keys.length) {
							var first = data.errors[keys[0]];
							message = Array.isArray(first) ? str(first[0]) : str(first);
						}
					}
					throw new Error(message || '{{ __('The request could not be processed.') }}');
				}
				return data;
			});
		}
		function post(body) {
			return fetch(uploadRoute, {
				method: 'POST',
				headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
				body: body
			}).then(parseResponse);
		}

		function handleFile(file) {
			if (!file) {
				return;
			}
			hideErr();
			if (!/\.zip$/i.test(file.name)) {
				showErr('{{ __('Only .zip packages are supported.') }}');
				return;
			}
			if (file.size > maxBytes) {
				showErr('{{ __('The selected file is larger than the 200MB limit.') }}');
				return;
			}
			resetAll();
			upload(file);
		}

		function upload(file) {
			var fd = new FormData();
			fd.append('module_zip', file);
			fd.append('stage', '1');
			var started = performance.now();
			setBusy(true, '{{ __('Uploading package...') }}');
			post(fd)
				.then(function (data) {
					token = str(data.token);
					if (!token || String(data.stage) !== '1') {
						throw new Error('{{ __('Upload did not start an installation session.') }}');
					}
					msgs[1] = str(data.message);
					durs[1] = ((performance.now() - started) / 1000).toFixed(1) + 's';
					runInspect(2);
				})
				.catch(function (err) {
					setBusy(false);
					showErr(err.message || '{{ __('Upload failed.') }}');
				});
		}

		var inspectLabels = {
			2: '{{ __('Validating package...') }}',
			3: '{{ __('Checking compatibility...') }}',
			4: '{{ __('Checking dependencies...') }}'
		};

		function runInspect(stage) {
			setBusy(true, inspectLabels[stage]);
			var started = performance.now();
			var body = new URLSearchParams();
			body.set('stage', String(stage));
			body.set('token', token);
			post(body)
				.then(function (data) {
					msgs[stage] = str(data.message);
					durs[stage] = ((performance.now() - started) / 1000).toFixed(1) + 's';
					if (stage === 2) {
						pkg = data.package || null;
					}
					if (stage === 4) {
						deps = Array.isArray(data.deps) ? data.deps : [];
					}
					if (stage < 4) {
						runInspect(stage + 1);
						return;
					}
					setBusy(false);
					ready = true;
					renderPanel(true);
				})
				.catch(function (err) {
					setBusy(false);
					onInspectFail(stage, err.message || '{{ __('Package check failed.') }}');
				});
		}

		function onInspectFail(stage, message) {
			// The server already cleared the session; the user must re-upload.
			token = '';
			if (pkg) {
				ready = false;
				renderPanel(false, stage, message);
				return;
			}
			showErr(message);
		}

		function renderPanel(success, failStage, failMsg) {
			var json = (pkg && pkg.json) || {};

			el.banner.classList.toggle('is-error', !success);
			if (success) {
				el.bannerIco.innerHTML = '<i class="icon-check"></i>';
				el.bannerTitle.textContent = '{{ __('Module Package Detected') }}';
				el.bannerText.textContent = '{{ __('The uploaded file is a valid W3CMS module package.') }}';
			} else {
				el.bannerIco.innerHTML = '<i class="icon-circle-x"></i>';
				el.bannerTitle.textContent = '{{ __('Package Check Failed') }}';
				el.bannerText.textContent = failMsg;
			}

			var label = typeLabel(json);
			el.pkgName.textContent = str(pkg.name);
			el.pkgPill.textContent = label + ' {{ __('Module') }}';
			el.pkgPill.hidden = false;
			el.pkgDesc.textContent = strip(json.description) || '{{ __('No description was declared in module.json.') }}';

			var version = str(json.version).trim();
			var parent = str(json.parent_module || json.parent).trim();
			var rows = [
				['{{ __('Version') }}', version ? 'v' + version : '—', false],
				['{{ __('Author') }}', authorText(json) || '—', false],
				['{{ __('Technology') }}', 'Laravel', false],
				['{{ __('Package Size') }}', formatSize(pkg.size), true]
			];
			if (parent) {
				rows.push(['{{ __('Parent Module') }}', parent, false]);
			}
			rows.push(['{{ __('Module Type') }}', label, false]);
			el.metaRows.innerHTML = rows.map(function (row) {
				return '<tr><td>' + esc(row[0]) + '</td><td' + (row[2] ? ' class="is-plain"' : '') + '>' + esc(row[1]) + '</td></tr>';
			}).join('');

			fillList(el.chkPkg, [
				'{{ __('Valid ZIP file format') }}',
				'{{ __('module.json found and parsed') }}',
				'{{ __('Valid module structure') }}',
				'{{ __('Files and folders are safe') }}'
			]);
			fillList(el.chkSec, [
				'{{ __('ZIP structure verified') }}',
				'{{ __('No unsafe file paths detected') }}',
				'{{ __('Module folder and manifest validated') }}'
			]);
			var phpReq = str(json.requires_php).trim();
			var w3Req = str(json.required_w3cms_version).trim();
			fillList(el.chkCompat, [
				w3Req ? '{{ __('Compatible with your W3CMS') }} (v' + w3Req + '+)' : '{{ __('No W3CMS version constraint declared') }}',
				phpReq ? '{{ __('Compatible with PHP') }} (v' + phpReq + '+)' : '{{ __('No PHP version constraint declared') }}',
				'{{ __('Technology platform: Laravel') }}'
			]);
			if (deps && deps.length) {
				var depItems = deps.map(function (dep) {
					return str(dep.name) + (str(dep.need) ? ' >= ' + str(dep.need) : '') +
						' ({{ __('Installed') }} ' + (str(dep.installed_version) || '?') + ')';
				});
				depItems.push('{{ __('All dependencies satisfied') }}');
				fillList(el.chkDeps, depItems);
			} else {
				fillList(el.chkDeps, ['{{ __('No module dependencies declared') }}']);
			}

			if (!success) {
				if (failStage === 3) {
					failList(el.chkCompat, failMsg);
					skipList(el.chkDeps, '{{ __('Not checked') }}');
				} else if (failStage === 4) {
					failList(el.chkDeps, failMsg);
				}
			}

			el.infoDesc.textContent = strip(json.description) || '{{ __('No description was declared in module.json.') }}';
			var features = json.keywords || json.features || [];
			if (typeof features === 'string') {
				features = features.split(',');
			}
			features = (Array.isArray(features) ? features : [])
				.map(function (feature) { return str(feature).trim(); })
				.filter(Boolean);
			el.featWrap.hidden = features.length === 0;
			el.infoFeats.innerHTML = features.map(function (feature) {
				return '<li><i class="icon-circle-check"></i><span>' + esc(feature) + '</span></li>';
			}).join('');

			renderTree();
			el.rawJson.textContent = str(pkg.rawJson);

			el.install.disabled = !success;
			el.detected.hidden = false;
		}

		function fileIcon(name) {
			return /\.(php|json|js|css|blade\.php)$/i.test(str(name)) ? 'icon-file-code' : 'icon-file';
		}
		function renderTree() {
			var all = Array.isArray(pkg.entries) ? pkg.entries : [];
			var order = [];
			var kids = {};
			all.forEach(function (entry) {
				var path = str(entry);
				if (!path || path.slice(-1) === '/') {
					return;
				}
				var parts = path.split('/');
				var top = parts[0];
				if (!top) {
					return;
				}
				if (!Object.prototype.hasOwnProperty.call(kids, top)) {
					kids[top] = [];
					order.push(top);
				}
				kids[top].push(parts.length > 1 ? parts.slice(1).join('/') : null);
			});

			var maxLines = 40;
			var lines = 0;
			var extra = 0;
			var html = '';
			order.forEach(function (top) {
				var children = kids[top].filter(function (child) { return child !== null; });
				if (children.length === 0) {
					if (lines >= maxLines) {
						extra++;
						return;
					}
					html += '<li><i class="' + fileIcon(top) + '"></i><span>' + esc(top) + '</span></li>';
					lines++;
					return;
				}
				if (lines >= maxLines) {
					extra += 1 + children.length;
					return;
				}
				html += '<li><i class="icon-folder"></i><span>' + esc(top) + '</span></li>';
				lines++;
				children.forEach(function (child) {
					if (lines >= maxLines) {
						extra++;
						return;
					}
					html += '<li class="is-sub"><i class="' + fileIcon(child) + '"></i><span>' + esc(child) + '</span></li>';
					lines++;
				});
			});
			if (extra > 0) {
				html += '<li class="is-sub"><i class="icon-file"></i><span>+ ' + extra + ' {{ __('more') }}</span></li>';
			}
			el.treeCount.textContent = str(pkg.entryCount || all.length) + ' {{ __('entries') }}';
			el.treeList.innerHTML = html || '<li><i class="icon-file"></i><span>{{ __('No entries') }}</span></li>';
		}

		// Tabs
		el.tabs.addEventListener('click', function (event) {
			var btn = event.target.closest('button[data-um]');
			if (!btn) {
				return;
			}
			el.tabs.querySelectorAll('button').forEach(function (b) {
				b.classList.toggle('is-active', b === btn);
			});
			el.panelInfo.hidden = btn.dataset.um !== 'info';
			el.panelFiles.hidden = btn.dataset.um !== 'files';
			el.panelJson.hidden = btn.dataset.um !== 'json';
		});

		// Change File
		el.change.addEventListener('click', function () {
			resetAll();
		});

		// Drop zone
		['dragenter', 'dragover'].forEach(function (name) {
			el.drop.addEventListener(name, function (event) {
				event.preventDefault();
				event.stopPropagation();
				el.drop.classList.add('is-over');
			});
		});
		['dragleave', 'drop'].forEach(function (name) {
			el.drop.addEventListener(name, function (event) {
				event.preventDefault();
				event.stopPropagation();
				el.drop.classList.remove('is-over');
			});
		});
		el.drop.addEventListener('drop', function (event) {
			var file = event.dataTransfer && event.dataTransfer.files && event.dataTransfer.files[0];
			if (file) {
				handleFile(file);
			}
		});
		el.file.addEventListener('change', function () {
			if (el.file.files && el.file.files[0]) {
				handleFile(el.file.files[0]);
			}
		});

		// Install -> timeline drawer (steps 1-4 pre-completed from the real inspect,
		// steps 5-8 driven by stages 5..8 of the same staged install).
		el.install.addEventListener('click', function () {
			if (!ready || !token || !pkg) {
				return;
			}
			ready = false;
			el.install.disabled = true;
			runProgress();
		});

		function drawerMarkup() {
			var json = pkg.json || {};
			var version = str(json.version).trim();
			var meta = [
				['{{ __('Version') }}', version ? 'v' + version : '—'],
				['{{ __('Author') }}', authorText(json) || '—'],
				['{{ __('Technology') }}', 'Laravel'],
				['{{ __('Package Size') }}', formatSize(pkg.size)],
				['{{ __('Requires') }}', (deps && deps.length) ? deps.length + ' {{ __('satisfied') }}' : '{{ __('None declared') }}']
			].map(function (pair) {
				return '<span class="k">' + esc(pair[0]) + '</span><span class="v">' + esc(pair[1]) + '</span>';
			}).join('');
			var letter = esc((str(pkg.name) || '?').charAt(0).toUpperCase());
			var steps = [
				['{{ __('Validating Package') }}', msgs[2] || '', true],
				['{{ __('Checking Compatibility') }}', msgs[3] || '', true],
				['{{ __('Checking Dependencies') }}', msgs[4] || '', true],
				['{{ __('Package Received') }}', msgs[1] || '', true],
				['{{ __('Extracting Files') }}', '{{ __('Extracting module files to /Modules/{slug}...') }}', false],
				['{{ __('Registering Module') }}', '{{ __('Enabling the module and running migrations...') }}', false],
				['{{ __('Refreshing Cache') }}', '{{ __('Clearing configuration, route and application caches...') }}', false],
				['{{ __('Finalizing Installation') }}', '{{ __('Seeding data and verifying the installation...') }}', false]
			];
			return '<div class="mod-pcard">' +
				'<span class="im-module-icon bg-primary-light">' + letter + '</span>' +
				'<div class="mod-pinfo"><div class="mod-pname"><h6>' + esc(pkg.name) + '</h6><span class="mod-pill is-primary">' + esc(typeLabel(json) + ' Module') + '</span></div>' +
				'<p>' + esc(strip(json.description)) + '</p></div>' +
				'<div class="mod-pmeta">' + meta + '</div></div>' +
				'<ol class="mod-ptl">' + steps.map(function (step, i) {
					var done = step[2];
					var side = done
						? '<span class="mod-pdur">' + esc(durs[i + 1] || '—') + '</span>' +
							'<span class="mod-pdone"><i class="icon-circle-check"></i>{{ __('Completed') }}</span>'
						: '';
					return '<li class="mod-pstep' + (done ? ' is-done' : '') + '"><span class="mod-pnode">' + (i + 1) + '</span>' +
						'<div class="mod-pbox"><div class="mod-ptext">' +
						'<div class="mod-ptitle">' + esc(step[0]) + '</div>' +
						'<div class="mod-pdesc">' + esc(step[1]).replace('{slug}', esc(str(pkg.name))) + '</div></div>' +
						'<div class="mod-pside">' + side + '</div></div></li>';
				}).join('') + '</ol>' +
				'<div class="mod-pnote"><i class="icon-info"></i><div><strong>{{ __('Please do not close this window') }}</strong>' +
				'<p>{{ __('The installation process may take a few moments. Keep this window open until the installation is complete.') }}</p></div></div>';
		}

		function runProgress() {
			var body = document.getElementById('modProgressBody');
			body.innerHTML = drawerMarkup();
			var subtitle = document.querySelector('#modProgress .offcanvas-header p');
			if (subtitle) {
				subtitle.textContent = str(pkg.name) + ' {{ __('is being installed from the uploaded package.') }}';
			}
			bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('modProgress')).show();

			var rows = body.querySelectorAll('.mod-pstep');
			var durations = [];
			var messages = [];
			var stage = 4; // rows 0-3 completed during the inspect; live from stage 5

			function setDesc(i, text) {
				var desc = rows[i].querySelector('.mod-pdesc');
				if (desc && text) {
					desc.textContent = text;
				}
			}
			function markDone(i, dur) {
				rows[i].classList.remove('is-active');
				rows[i].classList.add('is-done');
				var side = rows[i].querySelector('.mod-pside');
				side.innerHTML = '<span class="mod-pdur">' + esc(dur) + '</span>' +
					'<span class="mod-pdone"><i class="icon-circle-check"></i>{{ __('Completed') }}</span>';
				if (messages[i]) {
					setDesc(i, messages[i]);
				}
			}
			function markAllDone() {
				rows.forEach(function (row, i) {
					if (!row.classList.contains('is-done')) {
						markDone(i, durations[i] || '—');
					}
				});
			}
			function finishError(message, failedIndex) {
				var row = rows[failedIndex];
				if (row) {
					row.classList.remove('is-active');
					row.classList.add('is-error');
					setDesc(failedIndex, message);
					var side = row.querySelector('.mod-pside');
					if (side) {
						side.innerHTML = '<span class="mod-pfail"><i class="icon-x"></i>{{ __('Failed') }}</span>';
					}
				} else {
					var note = document.createElement('div');
					note.className = 'mod-note danger mt-3 dynamic-install-error';
					note.textContent = message;
					body.appendChild(note);
				}
			}
			function animateBar(row) {
				var fill = row.querySelector('.mod-pbar span');
				var pct = row.querySelector('.mod-ppct');
				var start = performance.now();
				function frame(now) {
					var ratio = Math.min(1, (now - start) / 400);
					var value = Math.round(ratio * 100);
					if (fill) {
						fill.style.width = value + '%';
					}
					if (pct) {
						pct.textContent = value + '%';
					}
					if (ratio < 1) {
						requestAnimationFrame(frame);
					}
				}
				requestAnimationFrame(frame);
			}
			function nextStage() {
				if (stage >= rows.length) {
					markAllDone();
					return;
				}
				var i = stage;
				var side = rows[i].querySelector('.mod-pside');
				rows[i].classList.add('is-active');
				side.innerHTML = '<div class="mod-pbar"><span></span></div><span class="mod-ppct">0%</span>';
				animateBar(rows[i]);
				var started = performance.now();
				var req = new URLSearchParams();
				req.set('stage', String(i + 1));
				req.set('token', token);
				post(req)
					.then(function (data) {
						durations[i] = ((performance.now() - started) / 1000).toFixed(1) + 's';
						messages[i] = str(data.message);
						markDone(i, durations[i]);
						stage += 1;
						if (stage >= rows.length) {
							markAllDone();
							if (window.toastr) {
								toastr.success(str(data.message) || '{{ __('Module installed successfully.') }}');
							}
						} else {
							nextStage();
						}
					})
					.catch(function (err) {
						finishError(err.message || '{{ __('Installation failed.') }}', i);
					});
			}
			nextStage();
		}
	})();
</script>
@endpush
