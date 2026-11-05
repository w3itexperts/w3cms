{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    @php

        $is_action =
		(
			auth('business')->user()->can('SolarMitra > Business > CampaignTagsController > create') &&
			auth('business')->user()->can('SolarMitra > Business > CampaignTagsController > store')
		) ||
		auth('business')->user()->can('SolarMitra > Business > CampaignTagsController > destroy');

    @endphp

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                <form method="get" action="{{ route('business.solarmitra.campaigns.tags.index', $campaign) }}">
                    <div class="row gy-2">

                         <div class="col-xl-2 col-md-4">
                            <input type="text" class="form-control " name="tag_name" value="{{ request('tag_name') }}" placeholder="{{ __('solarmitra::solarmitra.search') }}">
                        </div>
                        <div class="col-xl-10 col-md-8">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.campaigns.tags.index', $campaign) }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can('SolarMitra > Business > CampaignTagsController > destroy')
                            <div class="dropdown check-dropdown d-inline-block ms-2 align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="form-check custom-checkbox mb-0">
                                        <input type="checkbox" class="form-check-input CheckAllInputs">
                                    </div>
                                     <div class="dropdown-toggle dropdown-toggle-split px-2" role="button" data-bs-toggle="dropdown" aria-expanded="false"></div>
                                     <ul class="dropdown-menu">
                                        <li><button class="dropdown-item TagsBulkDeleteBtn" data-alert_text="{{ __('Are you Sure you want to Delete Selected Tags.') }}" href="{{ route('business.solarmitra.campaigns.tags.multi_destroy', $campaign) }}">{{ __('solarmitra::solarmitra.delete') }}</button></li>
                                    </ul>
                                </div>
                            </div>
                            @endcan
                            @can([
                                'SolarMitra > Business > CampaignTagsController > create',
                                'SolarMitra > Business > CampaignTagsController > store'
                            ])
                            <a href="{{ route('business.solarmitra.campaigns.tags.create', $campaign) }}" class="btn btn-primary me-auto ms-2 float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.tag') }}</a>
                            @endcan
                        </div>
                    </div>


                </form>
            </div>
            <!-- End - Filtering -->

            <div class="col-xl-12">
                 <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless  rounded m-0 quotation-tbl" id="campaignTagsTbl">
                            <thead>
                                <tr>
                                    <th class="width50 align-middle">
                                        <div class="form-check custom-checkbox mb-0">
                                            <input type="checkbox" class="form-check-input CheckAllInputs">
                                        </div>
                                    </th>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.tag') }}</th>
                                    <th class=" ">{{ __('solarmitra::solarmitra.created_at') }}</th>
                                    @if($is_action)
                                    <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $tag)
                                    <tr id="Row_{{ $tag->id }}">
                                        <td>
                                            <div class="form-check custom-checkbox">
                                                <input type="checkbox" class="form-check-input check-input" name="selected_tags[]" value="{{ $tag->id }}">
                                            </div>
                                        </td>
                                        <td>{{$tags->firstItem() + $loop->index}}</td>
                                        <td>{{optional($tag->tag)->title}}</td>
                                        <td>{{$tag->created_at}}</td>
                                        @if($is_action)
                                        <td>
                                            <div>
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('SolarMitra > Business > CampaignTagsController > destroy')
                                                        <a class="dropdown-item text-danger deleteRecord" data-alert_text="{{ __('Are you Sure you want to Delete this Tag.') }}" href="{{ route('business.solarmitra.campaigns.tags.destroy', [$campaign, $tag]) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('solarmitra::solarmitra.no_data_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($tags && $tags->hasPages())
                    <div class="card-footer">
                        {{ $tags->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('inline-scripts')
<script>
    $(document).ready(function() {
        @if(session('success'))
        toastr.success('{!! session('success') !!}');
        @endif

        // Bulk delete: confirm -> AJAX (selected_tags) -> full page refresh
        $(document).on('click', '.TagsBulkDeleteBtn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('href');
            var alert_text = $btn.data('alert_text');
            var selected = $('.check-input:checked').map(function() { return $(this).val(); }).get();

            if (selected.length === 0) {
                toastr.warning('{{ __('Please select at least one item.') }}');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: alert_text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { selected_tags: selected },
                        success: function(response) {
                            if (response.status) {
                                toastr.success(response.message);
                                window.location.reload();
                            } else {
                                toastr.error(response.message || '{{ __('Something went wrong.') }}');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('{{ __('Something went wrong.') }}');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
