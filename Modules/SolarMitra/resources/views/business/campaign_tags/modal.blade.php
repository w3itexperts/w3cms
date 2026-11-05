
<div class="modal-header">
    <h5 class="modal-title">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.tag') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form id="AjaxModalForm" action="{{ route('business.solarmitra.campaigns.tags.store', $campaign) }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label class="form-label">{{ __('solarmitra::solarmitra.tag') }} <span class="text-danger">*</span></label>
                <select name="tag_id" class="form-select selectpicker" data-live-search="true" required>
                    <option value="">{{ __('solarmitra::solarmitra.select_tag') }}</option>
                    @foreach ($availableTags as $id => $title)
                        <option value="{{ $id }}">{{ $title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
    </div>
</form>