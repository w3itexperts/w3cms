@extends('admin.layout.default')

@section('content')

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                <form method="get">
                    <div class="row gy-2">
                        <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search subject, description...">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control" name="feedback_type" data-live-search="true">
                                <option value="">All Types</option>
                                @foreach(['Suggestion', 'Issue', 'Feature Request', 'Improvement', 'Other'] as $type)
                                    <option value="{{ $type }}" @selected(request('feedback_type') == $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control" name="priority" data-live-search="true">
                                <option value="">All Priorities</option>
                                @foreach(['Low', 'Medium', 'High'] as $priority)
                                    <option value="{{ $priority }}" @selected(request('priority') == $priority)>{{ $priority }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control" name="status" data-live-search="true">
                                <option value="">All Status</option>
                                @foreach(['New', 'In Review', 'In Progress', 'Completed', 'Rejected'] as $status)
                                    <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-4">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('admin.solarmitra.app_feedbacks.index') }}" class="btn btn-danger ms-2">{{ __('solarmitra::solarmitra.reset') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End - Filtering -->

            <!-- Start - Table -->
            <div class="col-xl-12">
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless rounded m-0">
                            <thead>
                                <tr>
                                    <th class="width100">S.No.</th>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Module</th>
                                    <th>User</th>
                                    <th>Business</th>
                                    <th>Date</th>
                                    <th class="width100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedbacks->firstItem() + $loop->index }}</td>
                                        <td><strong>{{ $feedback->subject }}</strong></td>
                                        <td>
                                            @switch($feedback->feedback_type)
                                                @case('Issue')
                                                    <span class="badge bg-danger">{{ $feedback->feedback_type }}</span>
                                                    @break
                                                @case('Feature Request')
                                                    <span class="badge bg-primary">{{ $feedback->feedback_type }}</span>
                                                    @break
                                                @case('Suggestion')
                                                    <span class="badge bg-info">{{ $feedback->feedback_type }}</span>
                                                    @break
                                                @case('Improvement')
                                                    <span class="badge bg-warning">{{ $feedback->feedback_type }}</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $feedback->feedback_type }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($feedback->priority)
                                                @case('High')
                                                    <span class="badge bg-danger">{{ $feedback->priority }}</span>
                                                    @break
                                                @case('Medium')
                                                    <span class="badge bg-warning">{{ $feedback->priority }}</span>
                                                    @break
                                                @case('Low')
                                                    <span class="badge bg-success">{{ $feedback->priority }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($feedback->status)
                                                @case('New')
                                                    <span class="badge bg-primary">{{ $feedback->status }}</span>
                                                    @break
                                                @case('In Review')
                                                    <span class="badge bg-info">{{ $feedback->status }}</span>
                                                    @break
                                                @case('In Progress')
                                                    <span class="badge bg-warning">{{ $feedback->status }}</span>
                                                    @break
                                                @case('Completed')
                                                    <span class="badge bg-success">{{ $feedback->status }}</span>
                                                    @break
                                                @case('Rejected')
                                                    <span class="badge bg-danger">{{ $feedback->status }}</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $feedback->module_name ?? '-' }}</td>
                                        <td>{{ optional($feedback->user)->name ?? '-' }}</td>
                                        <td>{{ optional($feedback->business)->company_name ?? '-' }}</td>
                                        <td>{{ $feedback->created_at }}</td>
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#FeedbackDetailModal{{ $feedback->id }}">{{ __('solarmitra::solarmitra.view') }}</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Modal -->
                                            <div class="modal fade" id="FeedbackDetailModal{{ $feedback->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $feedback->subject }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">Feedback Type</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->feedback_type }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">Priority</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->priority }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">Status</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->status }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">Module</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->module_name ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">User</label>
                                                                    <p class="fw-bold mb-0">{{ optional($feedback->user)->name ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-muted mb-1">Business</label>
                                                                    <p class="fw-bold mb-0">{{ optional($feedback->business)->company_name ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted mb-1">Description</label>
                                                                <p class="mb-0">{{ $feedback->description }}</p>
                                                            </div>
                                                            @if ($feedback->page_url)
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted mb-1">Page URL</label>
                                                                <p class="mb-0"><a href="{{ $feedback->page_url }}" target="_blank">{{ $feedback->page_url }}</a></p>
                                                            </div>
                                                            @endif
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label text-muted mb-1">Browser</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->browser ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label text-muted mb-1">OS</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->operating_system ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label text-muted mb-1">App Version</label>
                                                                    <p class="fw-bold mb-0">{{ $feedback->app_version ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                            @if ($feedback->ip_address)
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted mb-1">IP Address</label>
                                                                <p class="mb-0">{{ $feedback->ip_address }}</p>
                                                            </div>
                                                            @endif
                                                            @if ($feedback->attachment)
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted mb-1">Attachment</label>
                                                                <p class="mb-0"><a href="{{ asset('storage/' . $feedback->attachment) }}" target="_blank">View Attachment</a></p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No feedbacks found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($feedbacks && $feedbacks->hasPages())
                    <div class="card-footer">
                        {{ $feedbacks->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection