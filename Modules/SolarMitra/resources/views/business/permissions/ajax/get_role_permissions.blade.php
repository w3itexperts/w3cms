<div class="modal-header">
    <h5 class="modal-title"><i class="fas fa-key me-2"></i>Permissions > {{ $role->name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

    @php
        // Group permissions by controller
        // Permission name format: "SolarMitra > Business > InvoicesController > store"
        $grouped = $permissions->groupBy(function ($p) {
            $parts = explode(' > ', $p->name);
            // Controller is second-to-last segment
            return $parts[count($parts) - 2] ?? 'Other';
        });
    @endphp

    @if($permissions->count())

        <p class="text-muted mb-3">Total: {{ $permissions->count() }} permissions across {{ $grouped->count() }} controllers</p>

        @foreach($grouped as $controllerName => $controllerPermissions)

            @php
                // Extract module from first permission name segment
                $firstParts = explode(' > ', $controllerPermissions->first()->name);
                $module = $firstParts[0] ?? '';
                $subModule = $firstParts[1] ?? '';
                $heading = $module . ' > ' . $subModule . ' > ' . str_replace('Controller', '', $controllerName);
            @endphp

            <div class="accordion accordion-bordered mb-2 accordion-primary custom-accordion" id="perm-accordion-{{ $loop->index }}">
                <div class="accordion-item">
                    <div class="accordion-header p-2 collapsed" data-bs-toggle="collapse" data-bs-target="#perm-collapse-{{ $loop->index }}">
                        <span class="accordion-header-text">
                            <strong>Controller: {{ $heading }}</strong>
                        </span>
                        <span class="badge bg-primary-subtle text-primary ms-auto me-2">{{ $controllerPermissions->count() }}</span>
                    </div>
                    <div id="perm-collapse-{{ $loop->index }}" class="accordion__body collapse" data-bs-parent="#perm-accordion-{{ $loop->index }}">
                        <div class="accordion-body-text table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th width="40%">{{ __('solarmitra::solarmitra.permission') }}</th>
                                        <th>{{ __('solarmitra::solarmitra.description') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($controllerPermissions as $index => $perm)
                                        @php
                                            $actionParts = explode('@', $perm->action);
                                            $methodName = end($actionParts);
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <span class="fw-semibold">{{ $methodName }}</span>
                                                <br><small class="text-muted"><code>{{ $perm->action }}</code></small>
                                            </td>
                                            <td>
                                                {{ $perm->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    @else
        <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle me-1"></i> No permissions assigned to this role.
        </div>
    @endif

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
</div>