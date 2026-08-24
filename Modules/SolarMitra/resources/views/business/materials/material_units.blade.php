{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-4">

                <div class="card h-auto">
                    <div class="card-header d-block">
                        @if(@$materialUnitObj->id)
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('Material Unit') }}</h4>
                        @else
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.create') }} {{ __('Material Unit') }}</h4>
                        @endif
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">{{ __('solarmitra::solarmitra.title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', @$materialUnitObj->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id" value="{{ @$materialUnitObj->id }}">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            <a href="{{ route('business.solarmitra.material_units.list') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
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
                            <input type="text" name="search" value="{{request('search')}}" class="form-control border-end-0" placeholder="{{ __('solarmitra::solarmitra.search') }} {{ __('Material Unit') }}">
                            <div class="input-group-append">
                                <button class="input-group-text rounded-0 rounded-end border-start-0"><i class="flaticon-381-search-2 text-black"></i></button>
                            </div>
                        </div>
                        </form>
                        <a href="{{ route('business.solarmitra.material_units.list') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a> 
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
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($material_units as $material_unit)    
                                    <tr>
                                        <td>{{$material_units->firstItem() + $loop->index}}</td>
                                        <td>{{$material_unit->title}}</td>
                                        <td>
                                            <a href="{{ route('business.solarmitra.material_units.list', $material_unit->id) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                            @can('SolarMitra > Business > MaterialUnitsController > destroy')
                                            <a href="{{ route('business.solarmitra.material_units.destroy', $material_unit->id) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('No Units.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($material_units && $material_units->hasPages())
                    <div class="card-footer">
                        {{ $material_units->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
                <!-- End - Table -->

            </div>

        </div>
    </div>

@endsection