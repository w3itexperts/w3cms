{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<!-- Start - Filter Criteria -->
<div class="col-xl-12">
    <div class="card rounded-0 border-0 border-bottom m-0">
        <div class="card-body p-3">
            <form id="AjaxFilterForm" action="{{ route('business.solarmitra.leads.index') }}">
                <div class="d-flex gap-3 flex-wrap justify-content-between align-items-center">
                    <div class="row w-100">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.find_filter_criteria') }}</label>
                                    <div class="input-group custom-search">
                                        <button class="input-group-text border-end-0 px-2 bg-transparent ApplyAjaxFilter" >
                                            <i class="icon icon-search"></i>
                                        </button>
                                        <input type="text" name="full_name" class="form-control form-control-sm border-start-0 width180" placeholder="{{ __('solarmitra::solarmitra.search') }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.phone_number') }}</label>
                                    <input type="number" name="phone" class="form-control form-control-sm ApplyAjaxFilter" placeholder="{{ __('solarmitra::solarmitra.phone_number') }}">
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.client_group') }}</label>
                                    <select name="client_group_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.client_group') }}" data-filter-name="List" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        @forelse ($client_groups as $key => $title)
                                            <option value="{{$key}}">{{$title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.lead_stage') }}</label>
                                    <select name="lead_stage_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.lead_stage') }}" data-filter-name="Lead Stage" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        @forelse ($lead_stages as $key => $title)
                                            <option value="{{$key}}" @selected(in_array($key, request('lead_stage_id',[])))>{{$title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.lead_source') }}</label>
                                    <select name="lead_source_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.lead_source') }}" data-filter-name="Lead Source" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        @forelse ($sources as $slug => $title)
                                            <option value="{{$slug}}" @selected(in_array($slug, request('lead_source_id',[])))>{{$title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.lead_potential') }}</label>
                                    <select name="lead_potential[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.lead_potential') }}" data-filter-name="Lead Source" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        @forelse (config('solarmitra.lead_potentials') as $key => $title)
                                            <option value="{{$key}}" @selected(in_array($key, request('lead_potential',[])))>{{$title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @if (auth('business')->user()->hasRole('Business'))
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.lead_added_by') }}</label>
                                    <select name="lead_added_by_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.lead_added_by') }}" data-filter-name="Lead Added By" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        <option value="{{auth('business')->id()}}">Self</option>
                                        @forelse ($staff_list as $staff)
                                            <option value="{{$staff['id']}}">{{$staff['name']}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                @endif
                                <div class="col-sm-3">
                                    <label class="form-label mb-1">{{ __('solarmitra::solarmitra.assigned_to') }}</label>
                                    <select name="assigned_to[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="{{ __('solarmitra::solarmitra.assigned_to') }}" data-filter-name="Assigned To" class="leads-filter js-filter-select form-bsselect-sm selectpicker ApplyAjaxFilter">
                                        @forelse (SolarMitraHelper::getContactsList('staff') as $id => $title)
                                            <option value="{{$id}}" @selected(@$follow_up->assigned_to == $id)>{{$title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 mt-2">
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
                        <div class="col-sm-10 align-self-end">
                            <ul class="nav nav-pills nav-pills-all gap-2 justify-content-end" id="justify-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active avatar avatar-sm rounded-circle light" id="leads-tbl-tab" data-bs-toggle="pill" data-bs-target="#leads-tbl" type="button" role="tab" aria-controls="leads-tbl" aria-selected="true">
                                    <i class="icon icon-layout-list"></i>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link avatar avatar-sm rounded-circle light" id="leads-card-tab" data-bs-toggle="pill" data-bs-target="#leads-card" type="button" role="tab" aria-controls="leads-card" aria-selected="false" tabindex="-1">
                                    <i class="icon icon-layout-grid"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End - Filter Criteria -->

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
                                                @forelse ($lead_stages as $key => $title)
                                                    <li><button class="dropdown-item LeadStageDropdownItem" data-value="{{$key}}">{{$title}}</button></li>
                                                @empty
                                                @endforelse
                                            </ul>   
                                        </div>
                                    </div>   
                                    @canany([
                                        'SolarMitra > Business > LeadsController > multi_destroy',
                                        'SolarMitra > Business > LeadsController > lead_change_stage',
                                        'SolarMitra > Business > LeadsController > lead_client_group',
                                        'SolarMitra > Business > LeadsController > lead_source',
                                        'SolarMitra > Business > LeadsController > lead_potential'
                                    ])
                                    <span >
                                        {{-- Total Leads: {{$leads->total()}} --}}
                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                            <div class="btn border px-2 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-expanded="false">
                                                {{ __('solarmitra::solarmitra.bulk_update') }}
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                @can('SolarMitra > Business > LeadsController > multi_destroy')
                                                <a class="dropdown-item BulkDeleteBtn" data-action="delete" data-alert_text="{{ __('Are you Sure you want to Delete Selected Leads.') }}" data-button_text="{{ __('Yes, Delete it!') }}" href="{{ route('business.solarmitra.leads.multi_destroy') }}">{{ __('solarmitra::solarmitra.delete') }}</a> 
                                                @endcan
                                                @can('SolarMitra > Business > LeadsController > lead_change_stage')
                                                <div class="dropdown-submenu position-relative">
                                                    <div class="dropdown-item">
                                                      <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                                        {{ __('solarmitra::solarmitra.lead_stage') }}
                                                      </div>
                                                      <ul class="dropdown-menu" data-url="{{ route('business.solarmitra.leads.lead_change_stage') }}" data-alert_text="{{ __('Are you Sure you want to Change Stage of Selected Leads.') }}">
                                                        @forelse ($lead_stages as $key => $title)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                  <input class="form-check-input LeadChangeStatus" type="radio" name="lead_stage" value="{{$key}}" id="LeadStageCheck{{$key}}">
                                                                  <label class="form-check-label" for="LeadStageCheck{{$key}}">{{$title}} </label>
                                                                </div>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                      </ul>
                                                    </div>
                                                </div>
                                                @endcan
                                                @can('SolarMitra > Business > LeadsController > lead_client_group')
                                                <div class="dropdown-submenu position-relative">
                                                    <div class="dropdown-item">
                                                      <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                                        {{ __('solarmitra::solarmitra.client_group') }}
                                                      </div>
                                                      <ul class="dropdown-menu" data-url="{{ route('business.solarmitra.leads.lead_client_group') }}" data-alert_text="{{ __('Are you Sure you want to Change Client of Selected Leads.') }}">
                                                        @forelse ($client_groups as $key => $title)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                  <input class="form-check-input LeadClientGroup" type="radio" name="client_group" value="{{$key}}" id="ClientGroupCheck{{$key}}">
                                                                  <label class="form-check-label" for="ClientGroupCheck{{$key}}">{{$title}} </label>
                                                                </div>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                      </ul>
                                                    </div>
                                                </div>
                                                @endcan
                                                @can('SolarMitra > Business > LeadsController > lead_source')
                                                <div class="dropdown-submenu position-relative">
                                                    <div class="dropdown-item">
                                                      <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                                        {{ __('solarmitra::solarmitra.lead_source') }}
                                                      </div>
                                                      <ul class="dropdown-menu" data-url="{{ route('business.solarmitra.leads.lead_source') }}" data-alert_text="{{ __('Are you Sure you want to Change Source of Selected Leads.') }}">
                                                        @forelse ($sources as $slug => $title)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                  <input class="form-check-input LeadSource" type="radio" name="lead_source" value="{{$slug}}" id="LeadSourceCheck{{$slug}}">
                                                                  <label class="form-check-label" for="LeadSourceCheck{{$slug}}">{{$title}} </label>
                                                                </div>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                      </ul>
                                                    </div>
                                                </div>
                                                @endcan
                                                @can('SolarMitra > Business > LeadsController > lead_potential')
                                                <div class="dropdown-submenu position-relative">
                                                    <div class="dropdown-item">
                                                      <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                                        {{ __('solarmitra::solarmitra.lead_potential') }}
                                                      </div>
                                                      <ul class="dropdown-menu" data-url="{{ route('business.solarmitra.leads.lead_potential') }}" data-alert_text="{{ __('Are you Sure you want to Change Potential of Selected Leads.') }}">
                                                        @forelse (config('solarmitra.lead_potentials') as $key => $title)
                                                            <li class="dropdown-item">
                                                                <div class="form-check">
                                                                  <input class="form-check-input LeadPotential" type="radio" name="lead_potential" value="{{$key}}" id="LeadPotentialCheck{{$key}}">
                                                                  <label class="form-check-label" for="LeadPotentialCheck{{$key}}">{{$title}} </label>
                                                                </div>
                                                            </li>
                                                        @empty
                                                        @endforelse
                                                      </ul>
                                                    </div>
                                                </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </span>
                                    @endcanany
                                    <span class="ps-2 border-start" id="SelectedItemsTextBox"></span>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    @can(['SolarMitra > Business > LeadsController > create', 'SolarMitra > Business > LeadsController > store'])
									<a href="{{ route('business.solarmitra.leads.create') }}" class="btn border px-2" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" >+ {{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.lead') }}</a>
                                    @endcan
                                    @can('SolarMitra > Business > LeadsController > client_group')
                                    <a href="{{ route('business.solarmitra.leads.client_group') }}" class="btn border px-2" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" >+ {{ __('solarmitra::solarmitra.client_groups') }}</a>
                                    @endcan
                                    @can('SolarMitra > Business > LeadsController > export')
                                    <a href="{{ route('business.solarmitra.leads.export') }}" class="btn border px-2" >
                                        <i class="icon icon-download fs-16"></i>
                                        <span class="text-black">{{ __('solarmitra::solarmitra.export_leads') }}</span>
                                    </a>
                                    @endcan
                                    @can('SolarMitra > Business > LeadsController > import')
                                    <a href="{{ route('business.solarmitra.leads.import') }}" class="btn border px-2" >
                                        <i class="icon icon-arrow-up-from-line fs-16"></i>
                                        <span class="text-black">{{ __('solarmitra::solarmitra.import_leads') }}</span>
                                    </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Leads Option -->
                <div class="col-xl-12">
                    <div class="tab-content" id="LeadsTabContent">
                        <!-- Start - Leads Table -->
                        <div class="tab-pane fade show active" id="leads-tbl" role="tabpanel" aria-labelledby="leads-tbl-tab" tabindex="0">
                            <div class="table-responsive check-wrapper rounded card" id="LeadsTableContainer">
                                @include('solarmitra::business.leads.list_view')
                            </div>
                        </div>
                        <!-- End - Leads Table -->
                        <!-- Start - Leads Card -->
                        <div class="tab-pane fade" id="leads-card" role="tabpanel" aria-labelledby="leads-card-tab" tabindex="0">
                            <div id="LeadsCardsContainer">
                                @include('solarmitra::business.leads.grid_view')
                            </div>
                        </div>
                        <!-- End - Leads Card -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('inline-scripts')
    <script>
        jQuery(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation(); 
        });

        $(document).on('change', '.check-input[name="selected_leads[]"]', function () {
            var val = $(this).val();
            $('.check-input[name="selected_leads[]"]').not(this).filter(function () {
                return $(this).val() === val;
            }).prop('checked', $(this).is(':checked'));
        });
    </script>
@endpush