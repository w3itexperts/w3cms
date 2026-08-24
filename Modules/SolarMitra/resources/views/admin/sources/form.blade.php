<form action="{{ $source->exists ? route('admin.solarmitra.sources.update', $source->id) : route('admin.solarmitra.sources.store') }}" method="POST" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;Loading... </span>
    </div>
    <div class="modal-header">
        <h5 class="modal-title">{{ $source->exists ? 'Edit Source' : 'Add Source' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $source->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Channel</label>
            <select name="channel_id" class="form-select selectpicker" data-live-search="true">
                <option value="">Select Channel</option>
                @foreach($channels as $id => $title)
                    <option value="{{ $id }}" {{ old('channel_id', $source->channel_id) == $id ? 'selected' : '' }}>{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="">Select Type</option>
                @foreach(config('solarmitra.source_types') as $key => $type)
                    <option value="{{ $key }}" {{ old('type', $source->type) == $key ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
                <option value="1" @selected(old('is_active', $source->is_active) == 1)>Active</option>
                <option value="0" @selected(old('is_active', $source->is_active) == 0)>Inactive</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ $source->exists ? 'Update' : 'Save' }}</button>
    </div>
</form>