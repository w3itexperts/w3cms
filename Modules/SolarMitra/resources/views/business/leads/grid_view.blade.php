<div class="row">
    @forelse ($leads as $lead)
    <!-- Start - Card -->
    <div class="col-xl-4">
        <div class="card leads-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fs-18 fw-semibold mb-0 d-flex gap-1 align-items-center">
                    {{$lead->full_name}} | {{$lead->phone}}
                    @can('SolarMitra > Business > LeadsController > edit')
                    <a href="{{ route('business.solarmitra.leads.edit',$lead->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl"><i class="icon icon-pencil text-primary fs-16"></i></a>
                    @endcan
                    </h5>

                    <div class="form-check leadCardItem">
                        <input type="checkbox" class="form-check-input check-input" name="selected_leads[]" value="{{$lead->id}}" data-stage-id="{{$lead->lead_stage->id}}">
                        @canany([
                            'SolarMitra > Business > LeadsController > edit',
                            'SolarMitra > Business > LeadsController > details',
                            'SolarMitra > Business > QuotationsController > create',
                            'SolarMitra > Business > LeadsController > destroy'
                        ])
                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                          <div class="btn btn-square rounded h-auto w-auto ms-2 p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fa-solid fa-gear text-black"></i>
                          </div>
                          <div class="dropdown-menu dropdown-menu-end">
                            @can('SolarMitra > Business > LeadsController > edit')
                            <a class="dropdown-item" href="{{ route('business.solarmitra.leads.edit',$lead->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl">{{ __('solarmitra::solarmitra.edit') }}</a>
                            @endcan
                            @can('SolarMitra > Business > LeadsController > details')
                            <a class="dropdown-item" href="{{ route('business.solarmitra.leads.details',$lead->id) }}">{{ __('solarmitra::solarmitra.details') }}</a>
                            @endcan
                            @can('SolarMitra > Business > QuotationsController > create')
                            <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.create',['lead_id' => $lead->id]) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">Add Quotation</a>
                            @endcan
                            @can('SolarMitra > Business > LeadsController > destroy')
                            <a class="dropdown-item deleteRecord" href="{{ route('business.solarmitra.leads.destroy',$lead->id) }}" >Delete Lead</a>
                            @endcan
                          </div>
                      </div>
                      @endcanany
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 fs-13 d-flex gap-1 align-items-center">
                        <i class="icon icon-map-pin"></i>
                        {{optional(@$lead->address)->address}}
                    </p>
                    <p class="m-0 fw-normal fs-13">
                        Potential:
                        @if ($lead->potential == 1)
                        <span class="d-inline-block width10 height10 bg-danger" style="border-radius: 2px;"></span>
                        <span class="text-black fw-medium">Low</span>
                        @elseif($lead->potential == 2)
                        <span class="d-inline-block width10 height10 bg-orange" style="border-radius: 2px;"></span>
                        <span class="text-black fw-medium">Medium</span>
                        @elseif($lead->potential == 3)
                        <span class="d-inline-block width10 height10 bg-success" style="border-radius: 2px;"></span>
                        <span class="text-black fw-medium">High</span>
                        @endif
                    </p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-1">
                        <div>
                            <select class="form-bsselect-sm selectpicker" disabled>
                                @forelse ($lead_stages as $key => $title)
                                <option value="{{$key}}" @selected($lead->lead_stage_id == $key)>{{$title}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        @if (optional(@$lead->source)->name)
                        <span class="badge badge-sm bg-primary-subtle text-bg-primary text-body fs-13 d-flex align-items-center">Source: {{optional(@$lead->source)->name}}</span>
                        @endif
                    </div>
                    @can('SolarMitra > Business > LeadsController > assign_lead')
                    <a href="{{ route('business.solarmitra.leads.assign_lead',$lead->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg"  class="m-0 fs-13 d-flex align-items-center btn p-0 btn-link">
                        <i class="icon icon-circle-user"></i>Assign / Followup
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <!-- End - Card -->
    @empty
    @endforelse
    
    
</div>