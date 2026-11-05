@extends('admin.layout.default')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 mb-3">
            <form method="get">
                <div class="row gy-2">
                    <div class="col-xl-2 col-md-4">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search channel...">
                    </div>
                    <div class="col-xl-4">
                        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.submit') }}</button>
                        <a href="{{ route('admin.solarmitra.channels.index') }}" class="btn btn-danger ms-2">{{ __('solarmitra::solarmitra.reset') }}</a>
                        <a href="{{ route('admin.solarmitra.channels.create') }}" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">Add Channel</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-bottom-borderless m-0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($channels as $channel)
                            <tr>
                                <td>{{ $channels->firstItem() + $loop->index }}</td>
                                <td>{{ $channel->title }}</td>
                                <td>{{ Str::limit($channel->description, 50) }}</td>
                                <td>
                                    @if($channel->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                        <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-ellipsis-vertical"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin.solarmitra.channels.edit', $channel->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.edit') }}</a>
                                            <form action="{{ route('admin.solarmitra.channels.destroy', $channel->id) }}" method="POST" class="d-inline deleteForm">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger deleteRecord">{{ __('solarmitra::solarmitra.delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No channels found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($channels->hasPages())
                <div class="card-footer">
                    {{ $channels->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('inline-css')
     <link href="{{ theme_asset('vendor/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/>
     <link href="{{ asset('modules/solarmitra/css/business-custom.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('inline-scripts')
    <script src="{{ theme_asset('vendor/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('modules/solarmitra/js/business-custom.js') }}"></script>
@endpush