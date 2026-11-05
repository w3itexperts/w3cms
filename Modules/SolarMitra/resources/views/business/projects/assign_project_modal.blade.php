<form method="post" action="{{route('business.solarmitra.projects.assign_project',@$project_id)}}" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ $page_title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-3">
                {!! SolarMitraHelper::getContactDropdown('staff','',@$projectStaff->staff_id) !!}
                <p class="text-danger error-text staff_id_error"></p>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
        </div>
    </div>
</form>