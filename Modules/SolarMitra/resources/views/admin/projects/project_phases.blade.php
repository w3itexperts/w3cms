{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
        <div class="row">

            <div class="col-xl-4">

                <div class="card h-auto">
                    <div class="card-header d-block">
                        @if(@$projectPhaseObj->id)
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.project_phase') }}</h4>
                        @else
                            <h4 class="card-title">{{ __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.project_phase') }}</h4>
                        @endif
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">{{ __('solarmitra::solarmitra.title') }}</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', @$projectPhaseObj->title) }}"  >
                                    @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">{{ __('solarmitra::solarmitra.description') }}</label>
                                    <textarea name="description" id="description" class="form-control h-100" rows="5">{{ old('description', @$projectPhaseObj->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <input type="hidden" name="id" value="{{ @$projectPhaseObj->id }}">
                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                            <a href="{{ route('admin.solarmitra.projects.project_phases') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                        </div>
                    </form>
                </div>

            </div>
           
            <div class="col-xl-8">


                <!-- Start - Table -->
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body ">
                        <table class="table table-bottom-borderless rounded m-0 quotation-tbl ">
                            <thead>
                                <tr>
                                    <th class="width100">S.No.</th>
                                    <th class="">Title</th>
                                    <th class=" width100">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($project_phases as $project_phase)    
                                    <tr>
                                        <td>{{$project_phases->firstItem() + $loop->index}}</td>
                                        <td>{{$project_phase->title}}</td>
                                        <td>
                                            <a href="{{ route('admin.solarmitra.projects.project_phases', $project_phase->id) }}" class="btn btn-primary shadow py-2 btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="icon-pencil"></i></a>
                                            <a href="{{ route('admin.solarmitra.projects.destory_project_phase', $project_phase->id) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">{{ __('solarmitra::solarmitra.no_project_phases') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($project_phases && $project_phases->hasPages())
                    <div class="card-footer">
                        {{ $project_phases->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
                    </div>
                    @endif
                </div>
                <!-- End - Table -->

            </div>

        </div>
    </div>


@endsection