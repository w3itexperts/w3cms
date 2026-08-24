{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-4">

                <div class="card h-auto">
                    <div class="card-header d-block">
                        @if(@$channelObj->id)
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.channel') }}</h4>
                        @else
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.channel') }}</h4>
                        @endif
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">{{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', @$channelObj->title) }}"  >
                                    @error('title')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="is_active" class="form-label">{{ __('solarmitra::solarmitra.is_active') }} </label>
                                    <div class=" form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch" id="is_active" value="1" @checked(@$channelObj->is_active == 1)>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">{{ __('solarmitra::solarmitra.description') }}</label>
                                    <textarea name="description" id="description" class="form-control h-100" rows="5">{{ old('description', @$channelObj->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id" value="{{ @$channelObj->id }}">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            <a href="{{ route('business.solarmitra.leads.channels') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                        </div>
                    </form>
                </div>

            </div>
           
            <div class="col-xl-8">

                <!-- Start - Filtering -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="clearfix gap-2 d-flex align-items-center">
                        <form>
                        <div class="input-group message-search-area width250">
                            <input type="text" name="search" value="{{request('search')}}" class="form-control border-end-0" placeholder="{{ __('solarmitra::solarmitra.search') }} {{ __('solarmitra::solarmitra.channels') }}">
                            <div class="input-group-append">
                                <button class="input-group-text rounded-0 rounded-end border-start-0"><i class="flaticon-381-search-2 text-black"></i></button>
                            </div>
                        </div>
                        </form>
                        <a href="{{ route('business.solarmitra.leads.channels') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a> 
                    </div>
                </div>
                <!-- End - Filtering -->

                <!-- Start - Table -->
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless rounded m-0 quotation-tbl">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.title') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.is_active') }}</th>
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($channels as $channel)    
                                    <tr>
                                        <td>{{$channels->firstItem() + $loop->index}}</td>
                                        <td>{{$channel->title}}</td>
                                        <td>
                                            @if ($channel->is_active)
                                            <span class="badge bg-success">{{ __('solarmitra::solarmitra.active') }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ __('solarmitra::solarmitra.inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($channel->business_id) && $channel->business_id == app('currentBusinessId'))
                                                <a href="{{ route('business.solarmitra.leads.channels', $channel->id) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                                @can('SolarMitra > Business > LeadsController > destroy_channel')
                                                <a href="{{ route('business.solarmitra.leads.destroy_channel', $channel->id) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="fa fa-trash"></i></a>
                                                @endcan
                                            @else
                                                <span class="dropdown-item text-muted">Predefined</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('solarmitra::solarmitra.no_channels') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($channels && $channels->hasPages())
                    <div class="card-footer">
                        {{ $channels->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
                <!-- End - Table -->

            </div>

        </div>
    </div>

@endsection