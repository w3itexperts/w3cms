{{-- Static dialog shells for the Add Modules page (content loaded by AJAX) --}}

<div class="offcanvas offcanvas-end mod-drawer mod-drawer-wide" tabindex="-1" id="modDetails" aria-label="{{ __('Module Details') }}">
	<div class="offcanvas-header md-header">
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body" id="modDetailsBody"></div>
</div>

<div class="modal fade mod-dialog" id="modMissing" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="mod-kicker">
					<span class="mod-kicker-icon"><i class="icon-download"></i></span>
					<div>
						<h5>{{ __('Additional Module Required') }}</h5>
						<p id="modMissingLead"></p>
					</div>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="modMissingBody">
				<div class="mod-chain">
					<div class="mod-chain-card">
						<strong id="missingName"></strong>
						<span id="missingDesc"></span>
						<div class="mod-pills"><span class="mod-pill" id="missingVersion"></span><span class="mod-pill" id="missingSize"></span></div>
					</div>
					<i class="icon-arrow-right"></i>
					<div class="mod-chain-card">
						<strong>{{ __('Business Core') }}</strong>
						<span>{{ __('Core business management features.') }}</span>
						<div class="mod-note danger mt-2 mb-0">{{ __('Not installed. Business Core is not installed.') }}</div>
					</div>
				</div>
				<div class="mod-section">
					<h6>{{ __('Requirements and Compatibility') }}</h6>
					<div class="mod-check"><i class="icon-check"></i><div>{{ __('Requires Business Core 2.0+') }}<small>{{ __('This module needs Business Core 2.0 or higher.') }}</small></div></div>
					<div class="mod-check"><i class="icon-check"></i><div>{{ __('Compatible with your current W3CMS version') }}</div></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
				<button type="button" class="btn btn-primary" id="modMissingGo"><i class="icon-download"></i> {{ __('Install both') }}</button>
			</div>
		</div>
	</div>
</div>

<div class="offcanvas offcanvas-end mod-drawer mod-drawer-wide" tabindex="-1" id="modProgress" aria-labelledby="modProgressTitle">
	<div class="offcanvas-header">
		<div>
			<h5 class="offcanvas-title" id="modProgressTitle">{{ __('Installing Module') }}</h5>
			<p class="text-secondary small mb-0">{{ __('The module is being downloaded and installed into your W3CMS installation.') }}</p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body" id="modProgressBody"></div>
</div>
