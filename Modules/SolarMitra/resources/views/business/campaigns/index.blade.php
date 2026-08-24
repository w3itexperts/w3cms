{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

@php
    $is_action =
		(
			auth()->user()->can('SolarMitra > Business > CampaignsController > edit') &&
			auth()->user()->can('SolarMitra > Business > CampaignsController > update')
		) ||
		auth()->user()->can('SolarMitra > Business > CampaignsController > destroy');
@endphp

	<div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                <form method="get">
                    <div class="row gy-2">
                        
                        <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control " name="purpose" value="{{ request('purpose') }}" placeholder="{{ __('solarmitra::solarmitra.purpose') }}">
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2" name="channel_id[]" multiple data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_channel') }}</option>
                                @foreach ($channels as $key => $title)
                                    <option value="{{$key}}" @selected(in_array($key, request('channel_id',[])))>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select class="selectpicker form-control me-2" name="source_id[]" multiple data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_source') }}</option>
                                @foreach ($sources as $key => $title)
                                    <option value="{{$key}}" @selected(in_array($key, request('source_id',[])))>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                            
                        <div class="col-xl-6">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.campaigns.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can(['SolarMitra > Business > CampaignsController > create','SolarMitra > Business > CampaignsController > store'])
                            <a href="{{ route('business.solarmitra.campaigns.create') }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.campaigns') }}</a>
                            @endcan
                        </div>
                    </div>


                </form>
            </div>
            <!-- End - Filtering -->
            
            <!-- Start - Table -->
            <div class="col-xl-12">
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless  rounded m-0">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.purpose') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.channel') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.source') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.status') }}</th>
                                    @if($is_action)
                                    <th class="width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($campaigns as $campaign)
                                    <tr>
                                        <td>{{$campaigns->firstItem() + $loop->index}}</td>
                                        <td>{{$campaign->purpose}}</td>
                                        <td>{{optional(@$campaign->channel)->title}}</td>
                                        <td>{{optional(@$campaign->source)->name}}</td>
                                        <td>{{config('solarmitra.campaigns_status')[@$campaign->status]}}</td>
                                        @if($is_action)
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can(['SolarMitra > Business > CampaignsController > edit','SolarMitra > Business > CampaignsController > update'])
                                                        <a class="dropdown-item" href="{{ route('business.solarmitra.campaigns.edit',$campaign->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                        @endcan
                                                        @can('SolarMitra > Business > CampaignsController > destroy')
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.campaigns.destroy',$campaign->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $is_action ? 6 : 5 }}" class="text-center">{{ __('solarmitra::solarmitra.no_campaigns') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($campaigns && $campaigns->hasPages())
                    <div class="card-footer">
                        {{ $campaigns->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                    </div>
                    @endif
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection

@push('inline-scripts')
    <script>
        jQuery(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation(); 
        });
    </script>
@endpush