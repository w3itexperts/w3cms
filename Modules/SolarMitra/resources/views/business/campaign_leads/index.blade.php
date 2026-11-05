@extends('solarmitra::business.layout.default')

@section('content')



<div class="col-xl-12">
    <div class="card rounded-0 border-0 border-bottom m-0">
        <div class="card-body p-3">
            <form id="AjaxFilterForm" action="{{ route('business.solarmitra.campaigns.leads.index', $campaign) }}">
                <div class="d-flex gap-3 flex-wrap justify-content-between align-items-center">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.find_filter_criteria') }}</label>
                            <div class="input-group custom-search">
                                <button class="input-group-text border-end-0 px-2 bg-transparent ApplyAjaxFilter" >
                                    <i class="icon icon-search"></i>
                                </button>
                                <input type="text" name="full_name" class="form-control form-control-sm border-start-0 width180" placeholder="{{ __('solarmitra::solarmitra.search') }}">
                            </div>
                        </div>
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.activity') }}</label>
                            <select name="campaign_activity_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.activity') }}" data-filter-name="Activity" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                @forelse ($activities as $key => $title)
                                    <option value="{{$key}}" @selected(in_array($key, request('campaign_activity_id',[])))>{{$title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.source') }}</label>
                            <select name="source_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.source') }}" data-filter-name="Source" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                @forelse ($sources as $slug => $title)
                                    <option value="{{$slug}}" @selected(in_array($slug, request('source_id',[])))>{{$title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.is_primary') }}</label>
                            <select name="is_primary" class="form-bsselect-sm selectpicker ApplyAjaxFilter">
                                <option value="" selected>-- {{ __('solarmitra::solarmitra.all') }} --</option>
                                <option value="1" @selected(request('is_primary') === 1)>{{ __('solarmitra::solarmitra.yes') }}</option>
                                <option value="0" @selected(request('is_primary') === 0)>{{ __('solarmitra::solarmitra.no') }}</option>
                            </select>
                        </div>
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.assigned_to') }}</label>
                            <select name="assigned_user_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.assigned_to') }}" data-filter-name="Assigned To" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                @forelse (\Modules\SolarMitra\Helper\SolarMitraHelper::getContactsList('staff') as $id => $title)
                                    <option value="{{$id}}" @selected(in_array($id, request('assigned_user_id',[])))>{{$title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="wLeads">
                            <label class="form-label mb-1">{{ __('solarmitra::solarmitra.sort_by') }}</label>
                            <select name="sort_by" class="form-bsselect-sm selectpicker ApplyAjaxFilter">
                                <option disabled selected>-- {{ __('solarmitra::solarmitra.sort_by_default') }} --</option>
                                <option value="name_asc">{{ __('solarmitra::solarmitra.name_asc') }}</option>
                                <option value="name_desc">{{ __('solarmitra::solarmitra.name_desc') }}</option>
                                <option value="created_asc">{{ __('solarmitra::solarmitra.created_asc') }}</option>
                                <option value="created_desc">{{ __('solarmitra::solarmitra.created_desc') }}</option>
                                <option value="modified_asc">{{ __('solarmitra::solarmitra.modified_asc') }}</option>
                                <option value="modified_desc">{{ __('solarmitra::solarmitra.modified_desc') }}</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-danger" id="ResetAjaxFilter">{{ __('solarmitra::solarmitra.reset') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="d-flex gap-2">
        <div class="wLeadsSection w-100">
            <div class="row">
                <!-- Start - Leads Option -->
                <div class="col-xl-12">
                    <div class="card lead-option">
                        <div class="card-body ps-3">
                            <div class="d-flex gap-2 justify-content-between flex-wrap align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    
                                    <div class="dropdown check-dropdown me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check custom-checkbox mb-0">
                                                <input type="checkbox" class="form-check-input CheckAllInputs" required="">
                                            </div>   
                                            <div class="dropdown-toggle dropdown-toggle-split px-1" role="button" data-bs-toggle="dropdown" aria-expanded="false"></div>  
                                            <ul class="dropdown-menu">
                                                @can('SolarMitra > Business > CampaignLeadsController > destroy')
                                                <li><button class="dropdown-item BulkDeleteBtn" data-action="delete" data-alert_text="{{ __('Are you Sure you want to Delete Selected Leads.') }}" href="{{ route('business.solarmitra.campaigns.leads.multi_destroy', $campaign) }}">{{ __('solarmitra::solarmitra.delete') }}</button></li>
                                                @endcan
                                            </ul>   
                                        </div>   
                                    </div> 
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    @can(['SolarMitra > Business > CampaignLeadsController > create', 'SolarMitra > Business > CampaignLeadsController > store'])
                                    <a href="{{ route('business.solarmitra.campaigns.leads.create', $campaign) }}" class="btn border px-2" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" >+ {{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.lead') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-0 table-hover text-nowrap" id="CampaignLeadsTableContainer">
        <div class="table-responsive">
            @include('solarmitra::business.campaign_leads.list_view')
        </div>
    </div>
</div>


@endsection

@push('inline-scripts')
<script>
    $(document).ready(function() {
        // Bulk delete
        {{-- $(document).on('click', '.BulkDeleteBtn', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('href');
            var selected = $('.check-input:checked').map(function() { return $(this).val(); }).get();
            
            if (selected.length === 0) {
                Swal.fire({icon: 'warning', title: '{{__('Please select at least one item.')}}'});
                return;
            }
            
            Swal.fire({
                title: $btn.data('alert_text') || '{{__('Are you sure?')}}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{__('Yes, delete it!')}}',
                cancelButtonText: '{{__('Cancel')}}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {selected_leads: selected, _token: '{{ csrf_token() }}'},
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({icon: 'success', title: '{{__('Deleted Successfully')}}', timer: 1500, showConfirmButton: false});
                                $('#AjaxFilterForm').trigger('submit');
                            } else {
                                Swal.fire({icon: 'error', title: '{{__('Error')}}', text: response.message});
                            }
                        }
                    });
                }
            });
        }); --}}
        

    });
</script>
@endpush