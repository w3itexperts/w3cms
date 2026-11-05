<form method="post" action="{{@$company->id ? route('admin.solarmitra.material_companies.update',@$company->id) : route('admin.solarmitra.material_companies.store')}}" class="AjaxModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;Loading... </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$company->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.material') }} {{ __('solarmitra::solarmitra.company') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{@$company->title}}">
                <p class="text-danger error-text title_error"></p>
            </div>
            <div class="col-sm-6 mb-3 ">
                <label class="form-label">{{ __('solarmitra::solarmitra.description') }} </label>
                <textarea name="description" class="form-control"> {{@$company->description}}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label mb-3">{{ __('solarmitra::solarmitra.item') }} {{ __('solarmitra::solarmitra.category') }} </label>
                <div class="row">
                    @forelse (SolarMitraHelper::getItemCategoryArr() as $id => $title)
                        <div class="col-sm-3 mb-2">
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    name="material_category_id[]" 
                                    multiple 
                                    type="checkbox" 
                                    value="{{ $id }}" 
                                    id="itemCategory{{ $id }}"
                                    {{ in_array($id, $selectedCategoryIds ?? []) ? 'checked' : '' }}
                                >
                                <label class="form-check-label text-body" for="itemCategory{{ $id }}">
                                    {{ $title }}
                                </label>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
                <p class="text-danger error-text material_category_id_error"></p>
            </div>
        </div>

        <div class="d-flex justify-content-end border-top pt-3 align-items-center">
            <button type="submit" class="btn btn-primary">{{ @$company->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.company') }}</button>
        </div>
    </div>
</form>