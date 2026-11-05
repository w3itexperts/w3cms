<form class="AjaxModalForm" action="{{ route('business.solarmitra.campaigns.assignments.store', $campaign) }}" method="POST">

    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>

    <div class="modal-header">
        <h5 class="modal-title">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.assignment') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label class="form-label">{{ __('solarmitra::solarmitra.staff_name') }} <span class="text-danger">*</span></label>
                <select name="user_id[]" class="form-select selectpicker" multiple data-live-search="true" >
                    @foreach ($staff as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                <p class="text-danger error-text mb-0 user_id_error"></p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
    </div>
</form>

@push('inline-scripts')
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
@endpush