{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container">


                <!-- Start - Table -->
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body ">
                        <table class="table table-bottom-borderless rounded m-0 quotation-tbl">
                            <thead>
                                <tr>
                                    <th class="width100">S.No.</th>
                                    <th class="">Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($project_phases as $project_phase)    
                                    <tr>
                                        <td>{{$project_phases->firstItem() + $loop->index}}</td>
                                        <td>{{$project_phase->title}}</td>
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


@endsection