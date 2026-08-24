<form action="{{route('business.solarmitra.address',@$address->id)}}" method="post" class="AjaxModalForm">
    @csrf
    <input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
    @if (request()->contact_id || @$contact_id)
        <input type="hidden" name="contact_id" value="{{request()->contact_id ?? @$contact_id}}">
    @endif
    @if (request()->project_id || @$project_id)
        <input type="hidden" name="project_id" value="{{request()->project_id ?? @$project_id}}">
    @endif
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>

    <div class="offcanvas-header d-flex justify-content-between border-5 border-bottom border-primary">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <div class="flex-column">
                <h5 class="fs-14 fw-bold m-0">{{ @$address->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.address') }}</h5>
            </div>
        </div>
        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-xl-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.address_title') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address_title" value="{{@$address->address_title}}">
                <p class="text-danger error-text address_title_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.address') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="address" value="{{@$address->address}}">
                <p class="text-danger error-text address_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label class="form-label" for="city_id">{{ __('solarmitra::solarmitra.city') }}</label>
                <select name="city_id" data-live-search="true" class="form-control selectpicker" id="city_id">
                    <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.city') }}</option>
                    @forelse(SolarMitraHelper::getCitiesList() as $cityId => $cityTitle)
                        <option value="{{ $cityId }}" {{ old('city_id',@$address->city_id) == $cityId ? 'selected="selected"' : '' }}>{{ $cityTitle }}</option>
                    @empty
                    @endforelse
                </select>
                <p class="text-danger error-text city_id_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label class="form-label" for="state_id">{{ __('solarmitra::solarmitra.state') }}</label>
                <select name="state_id" data-live-search="true" class="form-control selectpicker" id="state_id">
                        <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.state') }}</option>
                        @forelse(SolarMitraHelper::getStatesList() as $stateId => $stateTitle)
                            <option value="{{ $stateId }}" {{ old('state_id',@$address->state_id) == $stateId ? 'selected="selected"' : '' }}>{{ $stateTitle }}</option>
                        @empty
                        @endforelse
                </select>
                <p class="text-danger error-text state_id_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label class="form-label" for="country_id">{{ __('solarmitra::solarmitra.country') }}</label>
                <select name="country_id" data-live-search="true" class="form-control selectpicker" id="country_id">
                        <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.country') }}</option>
                        @forelse(SolarMitraHelper::getCountriesList() as $countryId => $countryTitle)
                            <option value="{{ $countryId }}" {{ old('country_id',@$address->country_id) == $countryId ? 'selected="selected"' : '' }}>{{ $countryTitle }}</option>
                        @empty
                        @endforelse
                </select>
                <p class="text-danger error-text country_id_error"></p>
            </div>

            <div class="col-xl-6 mb-3">
                <label class="form-label" for="address_type">{{ __('solarmitra::solarmitra.address_type') }}</label>
                <select name="address_type" class="form-control selectpicker" id="address_type">
                        <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.address_type') }}</option>
                        @forelse(config('solarmitra.address_type') as $address_type_id => $address_type_title)
                            <option value="{{ $address_type_id }}" {{ old('address_type',@$address->address_type) == $address_type_id ? 'selected="selected"' : '' }}>{{ $address_type_title }}</option>
                        @empty
                        @endforelse
                </select>
                <p class="text-danger error-text address_type_error"></p>
            </div>
            
        </div>
    </div>
</form>