<div class="row">
	<div class="form-group mb-3 col-md-4">
		<label class="form-label" for="city_id">{{ __('solarmitra::solarmitra.city') }}</label>
		<select name="city_id" class="default-select form-control" id="city_id">
				<option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.city') }}</option>
			@forelse(SolarMitraHelper::getCitiesList() as $cityId => $cityTitle)
				<option value="{{ $cityId }}" {{ old('city_id',@$address->city_id) == $cityId ? 'selected="selected"' : '' }}>{{ $cityTitle }}</option>
			@empty
			@endforelse
		</select>
		@error('city_id')
			<p class="text-danger">
				{{ $message }}
			</p>
		@enderror
	</div>
	<div class="form-group mb-3 col-md-4">
		<label class="form-label" for="state_id">{{ __('solarmitra::solarmitra.state') }}</label>
		<select name="state_id" class="default-select form-control" id="state_id">
				<option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.state') }}</option>
				@forelse(SolarMitraHelper::getStatesList() as $stateId => $stateTitle)
					<option value="{{ $stateId }}" {{ old('state_id',@$address->state_id) == $stateId ? 'selected="selected"' : '' }}>{{ $stateTitle }}</option>
				@empty
				@endforelse
		</select>
		@error('state_id')
			<p class="text-danger">
				{{ $message }}
			</p>
		@enderror
	</div>
	<div class="form-group mb-3 col-md-4">
		<label class="form-label" for="country_id">{{ __('solarmitra::solarmitra.country') }}</label>
		<select name="country_id" class="default-select form-control" id="country_id">
				<option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.country') }}</option>
				@forelse(SolarMitraHelper::getCountriesList() as $countryId => $countryTitle)
					<option value="{{ $countryId }}" {{ old('country_id',@$address->country_id) == $countryId ? 'selected="selected"' : '' }}>{{ $countryTitle }}</option>
				@empty
				@endforelse
		</select>
		@error('country_id')
			<p class="text-danger">
				{{ $message }}
			</p>
		@enderror
	</div>
	<div class="form-group mb-3 col-md-6">
		<label class="form-label" for="address_title">{{ __('solarmitra::solarmitra.address_title') }}</label>
		<input type="text" name="address_title" class="form-control" id="address_title" value="{{ old('address_title', @$address->address_title) }}" placeholder="{{ __('solarmitra::solarmitra.address_title') }}"  >
		@error('address_title')
			<p class="text-danger">
				{{ $message }}
			</p>
		@enderror
	</div>
	<div class="form-group mb-3 col-md-6">
		<label class="form-label" for="address">{{ __('solarmitra::solarmitra.address') }}</label>
		<textarea name="address" class="form-control" id="address" rows="5">{{ old('address', @$address->address) }}</textarea>
		@error('address')
			<p class="text-danger">
				{{ $message }}
			</p>
		@enderror
	</div>
</div>


@push('inline-scripts')
<script>
	
</script>
@endpush