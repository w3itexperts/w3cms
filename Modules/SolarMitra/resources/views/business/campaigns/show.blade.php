@extends('solarmitra::business.layout.default')

@section('content')

<div class="col-xl-12">
    <div class="card rounded-0 border-0 border-bottom m-0">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{$campaign->purpose}}</h4>
                <div class="d-flex gap-2">
                    @can('SolarMitra > Business > CampaignsController > edit')
                    <a href="{{ route('business.solarmitra.campaigns.edit', $campaign) }}" class="btn border px-2" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg" >{{ __('solarmitra::solarmitra.edit') }}</a>
                    @endcan
                    <a href="{{ route('business.solarmitra.campaigns.index') }}" class="btn border px-2">{{ __('solarmitra::solarmitra.back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.channel') }}</div>
                        <div class="col-6 text-end fw-bold">{{optional($campaign->channel)->title}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.source') }}</div>
                        <div class="col-6 text-end fw-bold">{{optional($campaign->source)->name}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.start_date') }}</div>
                        <div class="col-6 text-end fw-bold">{{$campaign->start_at}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.end_date') }}</div>
                        <div class="col-6 text-end fw-bold">{{$campaign->end_at}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.status') }}</div>
                        <div class="col-6 text-end fw-bold">
                            @php
                                $statuses = config('solarmitra.campaigns_status', []);
                                echo $statuses[$campaign->status] ?? $campaign->status;
                            @endphp
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.total_cost') }}</div>
                        <div class="col-6 text-end fw-bold">{{SolarMitraHelper::format_number($campaign->total_cost)}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.total_leads') }}</div>
                        <div class="col-6 text-end fw-bold">{{$campaign->total_leads}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 text-muted fs-13">{{ __('solarmitra::solarmitra.avg_cpl') }}</div>
                        <div class="col-6 text-end fw-bold">{{$campaign->avg_cpl ?? '-'}}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="campaignTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab" data-bs-target="#activities" type="button" role="tab" aria-controls="activities" aria-selected="true">
                                {{ __('solarmitra::solarmitra.activities') }} <span class="badge bg-primary ms-1">{{$campaign->activities_count}}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab" aria-controls="assignments" aria-selected="false">
                                {{ __('solarmitra::solarmitra.assignments') }} <span class="badge bg-secondary ms-1">{{$campaign->assignments_count ?? 0}}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="leads-tab" data-bs-toggle="tab" data-bs-target="#leads" type="button" role="tab" aria-controls="leads" aria-selected="false">
                                {{ __('solarmitra::solarmitra.leads') }} <span class="badge bg-info ms-1">{{$campaign->leads_count ?? 0}}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tags-tab" data-bs-toggle="tab" data-bs-target="#tags" type="button" role="tab" aria-controls="tags" aria-selected="false">
                                {{ __('solarmitra::solarmitra.tags') }} <span class="badge bg-warning ms-1">{{$campaign->tags_count ?? 0}}</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="campaignTabContent">
                        <!-- Activities Tab -->
                        <div class="tab-pane fade show active" id="activities" role="tabpanel" aria-labelledby="activities-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('solarmitra::solarmitra.name') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.channel') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.source') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.cost') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.leads') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.impressions') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.clicks') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.cpl') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.ctr') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.cpc') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($campaign->activities as $activity)
                                        <tr>
                                            <td>{{$activity->name}}</td>
                                            <td>{{optional($activity->channel)->title}}</td>
                                            <td>{{optional($activity->source)->name}}</td>
                                            <td>{{SolarMitraHelper::format_number($activity->cost)}}</td>
                                            <td>{{$activity->lead_count}}</td>
                                            <td>{{SolarMitraHelper::format_number($activity->impression)}}</td>
                                            <td>{{SolarMitraHelper::format_number($activity->clicks)}}</td>
                                            <td>{{$activity->cpl ?? '-'}}</td>
                                            <td>{{$activity->ctr ?? '-'}}%</td>
                                            <td>{{$activity->cpc ?? '-'}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">{{ __('solarmitra::solarmitra.no_data_found') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Assignments Tab -->
                        <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('solarmitra::solarmitra.staff_name') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($campaign->assignments as $assignment)
                                        <tr>
                                            <td>{{optional($assignment->user)->name}}</td>
                                            <td>{{$assignment->created_at}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4">{{ __('solarmitra::solarmitra.no_data_found') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Leads Tab -->
                        <div class="tab-pane fade" id="leads" role="tabpanel" aria-labelledby="leads-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('solarmitra::solarmitra.name') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.activity') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.source') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.assigned_to') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.is_primary') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($campaign->leads as $campaignLead)
                                        <tr>
                                            <td>{{$campaignLead->lead->full_name}}</td>
                                            <td>{{optional($campaignLead->activity)->name}}</td>
                                            <td>{{optional($campaignLead->source)->name}}</td>
                                            <td>{{optional($campaignLead->assignedUser)->name}}</td>
                                            <td>
                                                @if($campaignLead->is_primary)
                                    <span class="badge text-bg-success">{{ __('solarmitra::solarmitra.yes') }}</span>
                                @else
                                    <span class="badge text-bg-secondary">{{ __('solarmitra::solarmitra.no') }}</span>
                                @endif
                                            </td>
                                            <td>{{$campaignLead->created_at}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">{{ __('solarmitra::solarmitra.no_data_found') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Tags Tab -->
                        <div class="tab-pane fade" id="tags" role="tabpanel" aria-labelledby="tags-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('solarmitra::solarmitra.tag') }}</th>
                                            <th>{{ __('solarmitra::solarmitra.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($campaign->tags as $tag)
                                        <tr>
                                            <td>{{optional($tag)->title}}</td>
                                            <td>{{$tag->created_at}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4">{{ __('solarmitra::solarmitra.no_data_found') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('inline-scripts')
<script>
    $(document).ready(function() {
        // Tab persistence
        $('#campaignTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeCampaignTab', $(e.target).attr('href'));
        });
        
        // Restore active tab
        var activeTab = localStorage.getItem('activeCampaignTab');
        if (activeTab) {
            $('#campaignTabs a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>
@endpush