<form action="{{ $channel->exists ? route('admin.solarmitra.channels.update', $channel->id) : route('admin.solarmitra.channels.store') }}" method="POST" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;Loading... </span>
    </div>
    <div class="modal-header">
        <h5 class="modal-title">{{ $channel->exists ? 'Edit Channel' : 'Add Channel' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $channel->title) }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $channel->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
                <option value="1" @selected(old('is_active', $channel->is_active) == 1)>Active</option>
                <option value="0" @selected(old('is_active', $channel->is_active) == 0)>Inactive</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ $channel->exists ? 'Update' : 'Save' }}</button>
    </div>
</form>