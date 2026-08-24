{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    <form action="{{ route('business.solarmitra.leads.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="lead_added_by_id" value="{{optional(auth('business')->user()->contact)->id}}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.lead') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.abbreviation') }} </label>
                                <select name="abbreviation" class="form-control  text-primary selectpicker" >
                                    <option value="">{{ __('solarmitra::solarmitra.abbreviation') }}</option>
                                    @forelse ($abbreviations as $title)
                                        <option value="{{$title}}" @selected(old('abbreviation') == $title)>{{$title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('abbreviation')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.first_name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.last_name') }} </label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.client_group') }} </label>
                                <select name="client_group_id" class="form-control  text-primary selectpicker" >
                                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.client_group') }}</option>
                                    @forelse ($client_groups as $key => $title)
                                        <option value="{{$key}}" @selected(old('client_group_id') == $key)>{{$title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('client_group_id')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="col-3 mb-3">
                                <label class="form-label">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }} <span class="text-danger">*</span></label>
                                <select name="lead_source_id" class="form-control  text-primary selectpicker" data-live-search="true" >
                                    <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }}</option>
                                    @forelse ($sources as $slug => $title)
                                        <option value="{{$slug}}" @selected(old('lead_source_id') == $slug)>{{$title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('lead_source_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-3 mb-3 ">
                                <label class="form-label">{{ __('solarmitra::solarmitra.potential') }} </label>
                                <select name="potential" class="form-control  text-primary selectpicker">
                                    @forelse (config('solarmitra.lead_potentials') as $key => $title)
                                        <option value="{{$key}}" @selected(old('potential') == $key)>{{$title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('potential')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-3 mb-3 ">
                                <label class="form-label">{{ __('solarmitra::solarmitra.repeat_followup') }} </label>
                                <select name="repeat_followup" class="form-control  text-primary selectpicker">
                                    @forelse (config('solarmitra.repeat_followups') as $key => $title)
                                        <option value="{{$key}}" @selected(old('repeat_followup') == $key)>{{$title}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('repeat_followup')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-3 mb-3 ">
                                <label for="email_opt_out" class="form-label">{{ __('solarmitra::solarmitra.email_opt_out') }} </label>
                                <div class=" form-switch">
                                    <input class="form-check-input" type="checkbox" name="email_opt_out" role="switch" id="email_opt_out" value="1" @checked(old('email_opt_out') == 1)>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                        <a href="{{ route('business.solarmitra.materials.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                    </div>
                </div>
            </div>  
            <div class="col-md-12">

                {!! CustomFieldHelper::custom_fields('leads', @$lead->id) !!}
            </div>
        </div>
    </form>
</div>
@endsection

