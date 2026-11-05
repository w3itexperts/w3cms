{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

	<div class="container-fluid">
        <div class="row">

            <div class="col-xl-3">

                <div class="card h-auto">
                    <div class="card-header d-block">
                        @if($sourceObj->id)
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.source') }}</h4>
                        @else
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.source') }}</h4>
                        @endif
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">{{ __('solarmitra::solarmitra.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('solarmitra::solarmitra.name') }}" value="{{ old('name', $sourceObj->name) }}"  >
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">{{ __('solarmitra::solarmitra.type') }}</label>
                                    <select name="type" id="type" class="default-select form-control selectpicker">
                                        @forelse(config('solarmitra.source_types') as $key => $title)
                                            <option value="{{ $key }}" @selected(old('type', $sourceObj->type) == $key)>{{ $title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="channel_id" class="form-label">{{ __('solarmitra::solarmitra.channel') }}</label>
                                    <select name="channel_id" id="channel_id" class="default-select form-control selectpicker" data-live-search="true">
                                        @forelse($channels as $key => $title)
                                            <option value="{{ $key }}" @selected(old('channel_id', $sourceObj->channel_id) == $key)>{{ $title }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="is_active" class="form-label">{{ __('solarmitra::solarmitra.is_active') }} </label>
                                    <div class=" form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch" id="is_active" value="1" @checked(@$sourceObj->is_active == 1)>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id" value="{{ $sourceObj->id }}">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            <a href="{{ route('business.solarmitra.leads.sources') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                        </div>
                    </form>
                </div>

            </div>
           
            <div class="col-xl-9">

                <!-- Start - Filtering -->
                <form method="get">
                    <div class="row gy-2 mb-3">
                        
                        <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control " name="name" value="{{ request('name') }}" placeholder="{{ __('solarmitra::solarmitra.name') }}">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2" name="type[]" multiple data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_type') }}</option>
                                @foreach (config('solarmitra.source_types') as $key => $title)
                                    <option value="{{$key}}" @selected(in_array($key,request('type',[])))>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2" name="channel_id[]" multiple data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_channel') }}</option>
                                @forelse($channels as $key => $title)
                                    <option value="{{ $key }}" @selected(in_array($key,request('channel_id',[])))>{{ $title }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                            
                        <div class="col-xl-6">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.leads.sources') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                        </div>
                    </div>


                </form>
                <!-- End - Filtering -->

                <!-- Start - Table -->
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless rounded m-0 quotation-tbl">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.name') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.type') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.channel') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.is_active') }}</th>
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sources as $source)    
                                    <tr>
                                        <td>{{$sources->firstItem() + $loop->index}}</td>
                                        <td>{{$source->name}}</td>
                                        <td>{{config('solarmitra.source_types')[$source->type]}}</td>
                                        <td>{{optional($source->channel)->title}}</td>
                                        <td>
                                            @if ($source->is_active)
                                            <span class="badge bg-success">{{ __('solarmitra::solarmitra.active') }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ __('solarmitra::solarmitra.inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($source->business_id) && $source->business_id == app('currentBusinessId'))
                                                <a href="{{ route('business.solarmitra.leads.sources', $source->id) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                                @can('SolarMitra > Business > LeadsController > destroy_source')
                                                <a href="{{ route('business.solarmitra.leads.destroy_source', $source->id) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="fa fa-trash"></i></a>
                                                @endcan
                                            @else
                                                <span class="dropdown-item text-muted">Predefined</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('solarmitra::solarmitra.no_sources') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($sources && $sources->hasPages())
                    <div class="card-footer">
                        {{ $sources->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
                <!-- End - Table -->

            </div>

        </div>
    </div>

@endsection