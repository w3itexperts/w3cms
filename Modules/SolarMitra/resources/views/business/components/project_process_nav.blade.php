@if (isset($project_id))
@php
    $step = SolarMitraHelper::getProjectStep($project_id);

    $stepIndex = [
        'documents' => 1,
        'verification' => 2,
        'subsidy' => 3,
        'structure' => 4,
        'netmeter' => 5,
        'handover' => 6,
        'done' => 7,
    ];

    $currentStep = $stepIndex[$step];
    $isDraft = !empty($project) && $project->status == config('solarmitra.projects_status_keys.Draft');
@endphp
<fieldset {{ !empty($project) && $project->status == config('solarmitra.projects_status_keys.Archived') ? 'hidden' : '' }}>
<ul class="nav nav-pills nav-pills-all nav-arrow-nav flex-nowrap" id="tabProjectStatus" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('business.solarmitra.projects.edit',$project_id) }}" class="nav-link p-3 {{ request()->routeIs('business.solarmitra.projects.edit') ? 'active' : '' }} rounded-0">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 16C12.4187 16 16 12.4187 16 8C16 3.58125 12.4187 0 8 0C3.58125 0 0 3.58125 0 8C0 12.4187 3.58125 16 8 16ZM7 5C7 4.44688 7.44688 4 8 4C8.55313 4 9 4.44688 9 5C9 5.55312 8.55313 6 8 6C7.44688 6 7 5.55312 7 5ZM6.75 7H8.25C8.66562 7 9 7.33437 9 7.75V10.5H9.25C9.66562 10.5 10 10.8344 10 11.25C10 11.6656 9.66562 12 9.25 12H6.75C6.33437 12 6 11.6656 6 11.25C6 10.8344 6.33437 10.5 6.75 10.5H7.5V8.5H6.75C6.33437 8.5 6 8.16562 6 7.75C6 7.33437 6.33437 7 6.75 7Z" fill="white"/>
            </svg>
        </a>
    </li>
    @can('SolarMitra > Business > ProjectsController > documents')
    <li class="nav-item" role="presentation">
        <a href="{{ route('business.solarmitra.projects.documents',$project_id) }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.documents') ? 'active' : '' }}">Document</a>
    </li>
    @endcan
    @can('SolarMitra > Business > ProjectsController > verification')
    <li class="nav-item" role="presentation">
        <a href="{{ (!$isDraft || $currentStep >= 2) ? route('business.solarmitra.projects.verification',$project_id) : 'javascript:void(0)' }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.verification') ? 'active' : '' }} {{ $isDraft ? 'disabled' : '' }}">Verification  @if($isDraft) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</a>
    </li>
    @endcan
    @if (@$project_documents && !empty(@$project_documents->government_subsidy) && auth('business')->user()->can('SolarMitra > Business > ProjectsController > subsidy'))
    <li class="nav-item" role="presentation">
        <a href="{{ (!$isDraft || $currentStep >= 3) ? route('business.solarmitra.projects.subsidy',$project_id) : 'javascript:void(0)' }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.subsidy') ? 'active' : '' }} {{ $isDraft ? 'disabled' : '' }}">Subsidy  @if($isDraft) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</a>
    </li>
    @endif
    @can('SolarMitra > Business > ProjectsController > structure')
    <li class="nav-item" role="presentation">
        <a href="{{ (!$isDraft || $currentStep >= 4) ? route('business.solarmitra.projects.structure',$project_id) : 'javascript:void(0)' }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.structure') ? 'active' : '' }} {{ $isDraft ? 'disabled' : '' }}">Installation  @if($isDraft) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</a>
    </li>
    @endcan
    @can('SolarMitra > Business > ProjectsController > netmeter')
    <li class="nav-item" role="presentation">
        <a href="{{ (!$isDraft || $currentStep >= 5) ? route('business.solarmitra.projects.netmeter',$project_id) : 'javascript:void(0)' }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.netmeter') ? 'active' : '' }} {{ $isDraft ? 'disabled' : '' }}">Net Metering  @if($isDraft) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</a>
    </li>
    @endcan
    @can('SolarMitra > Business > ProjectsController > handover')
    <li class="nav-item" role="presentation">
        <a href="{{ (!$isDraft || $currentStep >= 6) ? route('business.solarmitra.projects.handover',$project_id) : 'javascript:void(0)' }}" class="nav-link py-3 rounded-0 {{ request()->routeIs('business.solarmitra.projects.handover') ? 'active' : '' }} {{ $isDraft ? 'disabled' : '' }}">Handover  @if($isDraft) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</a>
    </li>
    @endcan
</ul>
</fieldset>
@endif