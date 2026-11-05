@php
	$protectedModules = $protectedModules ?? [];
@endphp
@if(count($modules))
<div class="card im-table-card" id="imTableCard">
	<div class="card-body p-0 table-responsive">
		<table class="table im-table mb-0">
			<thead>
				<tr>
					<th scope="col"><input type="checkbox" class="form-check-input" id="imSelectAll" aria-label="{{ __('Select all modules on this page') }}"></th>
					<th scope="col">#</th>
					<th scope="col">{{ __('Module') }}</th>
					<th scope="col">{{ __('Description') }}</th>
					<th scope="col">{{ __('Version') }}</th>
					<th scope="col">{{ __('Type') }}</th>
					<th scope="col">{{ __('Parent Module') }}</th>
					<th scope="col">{{ __('Status') }}</th>
					<th scope="col">{{ __('Update') }}</th>
					<th scope="col">{{ __('Auto Update') }}</th>
					<th scope="col" class="text-end">{{ __('Actions') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach($modules as $module)
					@php
						$name            = $module->getName();
						$desc            = $module->getDescription() ?: '—';
						$isEnabled       = $module->isEnabled();
						$isProtected     = in_array($name, $protectedModules);
						$type            = $isProtected ? 'core' : 'standard';
						$typeLabel       = $isProtected ? __('Core') : __('Standard');
						$version         = $module->get('version') ?: '—';
						$autoUpdate      = (bool) $module->get('auto_update');
						$updateState     = $updateStates[$name] ?? 'unknown';
						$confirmEnable   = route('modules.admin.confirm_enable', ['module' => $name]);
						$confirmDisable  = route('modules.admin.confirm_disable', ['module' => $name]);
						$confirmDelete   = route('modules.admin.confirm_delete', ['module' => $name]);
						$confirmUpdate   = route('modules.admin.confirm_update', ['module' => $name]);
						$rowDetailsUrl   = route('modules.admin.row_details', ['module' => $name]);
					@endphp
					<tr class="im-row">
						<td><input type="checkbox" class="form-check-input im-check" value="{{ $name }}" aria-label="{{ __('Select') }} {{ $name }}"></td>
						<td class="im-num">{{ $loop->iteration }}</td>
						<td>
							<div class="im-module">
								@include('admin.modules.module_badge', ['name' => $name])
								<div>
									<div class="im-module-name">{{ $name }}</div>
									<div class="im-chips"><span class="im-chip is-{{ $type }}">{{ $typeLabel }}</span></div>
								</div>
							</div>
						</td>
						<td class="im-desc">{{ $desc }}</td>
						<td class="im-version">{{ $version }}</td>
						<td><span class="im-type is-{{ $type }}">{{ $typeLabel }}</span></td>
						<td class="im-parent">—</td>
						<td>
							@if($isEnabled)
								<span class="im-status is-active"><i class="icon-circle-check"></i> {{ __('Active') }}</span>
							@else
								<span class="im-status is-inactive"><i class="icon-circle-x"></i> {{ __('Inactive') }}</span>
							@endif
						</td>
						<td>
							@if($updateState === 'available')
								<span class="im-update is-available"><i class="icon-download"></i> {{ __('Update available') }}</span>
							@elseif($updateState === 'current')
								<span class="im-update is-current"><i class="icon-circle-check"></i> {{ __('Up to date') }}</span>
							@else
								<span class="im-update">{{ __('No data') }}</span>
							@endif
						</td>
						<td>
							<div class="form-check form-switch im-switch">
								<input class="form-check-input im-auto" type="checkbox" role="switch" aria-label="{{ __('Auto update') }} {{ $name }}" {{ $autoUpdate ? 'checked' : '' }}>
							</div>
						</td>
						<td>
							<div class="im-actions">
								@if($isProtected)
									<button type="button" class="btn btn-sm im-primary-action btn-outline-secondary" disabled>{{ __('Protected') }}</button>
								@elseif($isEnabled)
									<a href="{{ $confirmDisable }}" class="btn btn-sm im-primary-action btn-outline-secondary" data-load-modal>{{ __('Disable') }}</a>
								@else
									<a href="{{ $confirmEnable }}" class="btn btn-sm im-primary-action btn-primary" data-load-modal>{{ __('Enable') }}</a>
								@endif
								<div class="dropdown">
									<button type="button" class="btn btn-sm btn-light im-kebab" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" aria-label="{{ __('More actions for') }} {{ $name }}">
										<i class="icon-ellipsis"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-end">
										<a href="{{ $rowDetailsUrl }}" class="dropdown-item" data-load-canvas="#moduleDetailsDrawer">{{ __('Details') }}</a>
										@if(!$isProtected)
											@if($isEnabled)
												<a href="{{ $confirmDisable }}" class="dropdown-item" data-load-modal>{{ __('Deactivate') }}</a>
											@else
												<a href="{{ $confirmEnable }}" class="dropdown-item" data-load-modal>{{ __('Activate') }}</a>
											@endif
											<a href="{{ $confirmDelete }}" class="dropdown-item" data-load-modal>{{ __('Delete') }}</a>
										@endif
										<a href="{{ $confirmUpdate }}" class="dropdown-item" data-load-modal>{{ __('Update') }}</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endif
