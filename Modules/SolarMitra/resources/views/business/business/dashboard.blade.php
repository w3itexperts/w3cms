{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

	<div class="d-flex align-items-center justify-content-between mb-3">
		<h2 class="fs-20 fw-medium">{{ __('solarmitra::solarmitra.welcome') }} <span class="text-primary">{{auth('business')->user()->name}}</span></h2>
		@can('SolarMitra > Business > BusinessController > dashboard')
		<form action="{{ route('business.solarmitra.dashboard') }}" class="d-flex align-items-center justify-content-end filter-box" id="FilterBusinessDashboardForm" style="gap: 5px;">
	        <select name="sort_by" class="form-control w-auto" id="BusinessDashboardFilterSelect">
	            {{-- <option value="custom">Custom</option> --}}
	            <option value="all_time">{{ __('solarmitra::solarmitra.all_time') }}</option>
	            <option value="last_24_hours">{{ __('solarmitra::solarmitra.last_24_hours') }}</option>
	            <option value="last_7_days">{{ __('solarmitra::solarmitra.last_7_days') }}</option>
	            <option value="this_week">{{ __('solarmitra::solarmitra.this_week') }}</option>
	            <option value="this_month">{{ __('solarmitra::solarmitra.this_month') }}</option>
	            <option value="this_year">{{ __('solarmitra::solarmitra.this_year') }}</option>
	            <option value="range">{{ __('solarmitra::solarmitra.range') }}</option>
	        </select>
	        <div class="" id="BusinessDashboardFilterRange" style="display: none;">
	            <input class="form-control w-auto DateRangePicker" type="text" name="daterange" value="">
	        </div>
	        <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.filter') }}</button>
	    </form>
		@endcan
	</div>
	@can('SolarMitra > Business > BusinessController > dashboard')
	<div class="row" id="BusinessDashboardWidgets">

		@include('solarmitra::business.business.dashboard_widgets')

	</div>
	
	<div class="row">


		<!-- Start - Financial Snapshot -->
		<div class="col-xl-6">
			<div class="card financial-snapshot">
				<div class="card-header flex-wrap align-items-center py-0 pt-sm-0 pt-3 gap-2">
					<h4 class="fs-15 fw-medium m-0">{{ __('solarmitra::solarmitra.financial_snapshot') }}</h4>
					<ul class="nav solar-financeNav nav-underline" id="nav-tab" role="tablist">
						<li class="nav-item">
						<button class="nav-link active" id="underline-home-tab" data-series="Week" data-bs-toggle="tab" data-bs-target="#underline-home" type="button" role="tab" aria-controls="underline-home" aria-selected="true">{{ __('solarmitra::solarmitra.week') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-profile-tab" data-series="Month" data-bs-toggle="tab" data-bs-target="#underline-profile" type="button" role="tab" aria-controls="underline-profile" aria-selected="false">{{ __('solarmitra::solarmitra.month') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-contact-tab" data-series="Year" data-bs-toggle="tab" data-bs-target="#underline-contact" type="button" role="tab" aria-controls="underline-contact" aria-selected="false">{{ __('solarmitra::solarmitra.year') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-contact-tab" data-series="All" data-bs-toggle="tab" data-bs-target="#underline-contact" type="button" role="tab" aria-controls="underline-contact" aria-selected="false">{{ __('solarmitra::solarmitra.all') }}</button>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="d-flex flex-wrap stats">
						<div>
							<p class="fs-24 text-black fw-semibold mb-1">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($total_revenue)}} {{-- <span class="fs-12 text-success">+2.7%</span> --}}</p>
						<p class="m-0 fs-14">{{ __('solarmitra::solarmitra.revenue') }}</p>
					</div>
					<div>
						<p class="fs-24 text-black fw-semibold mb-1 d-flex gap-2 align-items-center"> <span class="text-danger fs-24 fw-semibold">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($total_unpaid_invoices->total)}}</span></p>
						<p class="m-0 fs-14">{{ __('solarmitra::solarmitra.pending_invoices') }}</p>
					</div>
					<div>
						<p class="fs-24 text-black fw-semibold mb-1 d-flex gap-2 align-items-center"> <span class="text-success fs-24 fw-semibold">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($total_paid_invoices->total)}}</span></p>
						<p class="m-0 fs-14">{{ __('solarmitra::solarmitra.paid_invoices') }}</p>
						</div>
					</div>
					<div id="financialChart" data-url="{{ route('business.solarmitra.get_invoice_series') }}"></div>
				</div>
			</div>
		</div>
		<!-- End - Financial Snapshot -->

		<!-- Start - Project Status Overview -->
		<div class="col-xl-6">
			<div class="card">
				<div class="card-header border-0 align-items-center py-0 pt-sm-0 pt-3 border-bottom flex-wrap">
					<h4 class="fs-15 fw-medium m-0">{{ __('solarmitra::solarmitra.project_status_overview') }}</h4>
					<ul class="nav solar-projectstatsNav nav-underline" id="nav-tab" role="tablist">
						<li class="nav-item">
						<button class="nav-link active" id="underline-draft-tab" data-bs-toggle="tab" data-bs-target="#underline-draft" type="button" role="tab" aria-controls="underline-draft" aria-selected="true">{{ __('solarmitra::solarmitra.draft') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-running-tab" data-bs-toggle="tab" data-bs-target="#underline-running" type="button" role="tab" aria-controls="underline-running" aria-selected="false">{{ __('solarmitra::solarmitra.running') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-completed-tab" data-bs-toggle="tab" data-bs-target="#underline-completed" type="button" role="tab" aria-controls="underline-completed" aria-selected="false">{{ __('solarmitra::solarmitra.completed') }}</button>
					</li>
					<li class="nav-item">
						<button class="nav-link" id="underline-hold-tab" data-bs-toggle="tab" data-bs-target="#underline-hold" type="button" role="tab" aria-controls="underline-hold" aria-selected="false">{{ __('solarmitra::solarmitra.hold') }}</button>
						</li>
					</ul>
				</div>
				<div class="card-body p-0 height410 overflow-auto">
					<div class="tab-content" id="underline-tabContent">

						<!-- Start - Draft Tab -->
						<div class="tab-pane fade show active" id="underline-draft" role="tabpanel" aria-labelledby="underline-draft-tab" tabindex="0">
							<div class="table-responsive check-wrapper">
								<table class="table table-project-status table-bordered mb-0 table-bottom-borderless" id="projectstatusTable">
									<thead>
										<tr>
											<th class="sorting-disabled width340 fs-14 text-black">{{ __('solarmitra::solarmitra.project_name') }}</th>
											<th class="sorting-disabled width160 fs-14 text-black text-nowrap">{{ __('solarmitra::solarmitra.client') }}</th>
											<th class="sorting-disabled mw-300 fs-14 text-black">{{ __('solarmitra::solarmitra.current_step') }}</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($draft_projects as $draft_project)
										@php
											$step = SolarMitraHelper::getProjectStep($draft_project->id);
											$doc = $draft_project->project_documents;
										@endphp
										<tr>
											<td class="d-inline-block fw-semibold text-black text-truncate" style="max-width: 340px;">{{$draft_project->title}}</td>
											<td>{{optional(optional($draft_project)->client)->name ?? 'N/A'}}</td>
											<td>
												<div class="d-flex align-items-center gap-2">
													<p class="m-0 text-warning fs-13 text-capitalize">{{$step}}</p>
													<div class="step-progress {{$step}}">
														<div class="step"></div>
														<div class="step"></div>
														<div class="step {{ !empty(@$doc->government_subsidy) ? '' : 'd-none'}}"></div>
														<div class="step"></div>
														<div class="step"></div>
														<div class="step"></div>
													</div>
												</div>
											</td>
										</tr>
										@empty
										<tr><td colspan="3" class="text-center">{{ __('solarmitra::solarmitra.no_draft_projects') }}</td></tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
						<!-- End - Draft Tab -->

						<!-- Start - Running Tab -->
						<div class="tab-pane fade" id="underline-running" role="tabpanel" aria-labelledby="underline-running-tab" tabindex="0">
							<div class="table-responsive check-wrapper">
								<table class="table table-project-status table-bordered mb-0 table-bottom-borderless" id="projectstatusTable">
									<thead>
										<tr>
											<th class="sorting-disabled width340 fs-14 text-black">{{ __('solarmitra::solarmitra.project_name') }}</th>
											<th class="sorting-disabled width160 fs-14 text-black text-nowrap">{{ __('solarmitra::solarmitra.client') }}</th>
											<th class="sorting-disabled mw-300 fs-14 text-black">{{ __('solarmitra::solarmitra.current_step') }}</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($running_projects as $running_project)
										@php
											$step = SolarMitraHelper::getProjectStep($running_project->id);
											$doc = $running_project->project_documents;
										@endphp
										<tr>
											<td class="d-inline-block fw-semibold text-black text-truncate" style="max-width: 340px;">{{$running_project->title}}</td>
											<td>{{optional(optional($running_project)->client)->name ?? 'N/A'}}</td>
											<td>
												<div class="d-flex align-items-center gap-2">
													<p class="m-0 text-warning fs-13 text-capitalize">{{$step}}</p>
													<div class="step-progress {{$step}}">
														<div class="step"></div>
														<div class="step"></div>
														<div class="step {{ !empty(@$doc->government_subsidy) ? '' : 'd-none'}}"></div>
														<div class="step"></div>
														<div class="step"></div>
														<div class="step"></div>
													</div>
												</div>
											</td>
										</tr>
										@empty
										<tr><td colspan="3" class="text-center">{{ __('solarmitra::solarmitra.no_running_projects') }}</td></tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
						<!-- End - Running Tab -->

						<!-- Start - Completed Tab -->
						<div class="tab-pane fade" id="underline-completed" role="tabpanel" aria-labelledby="underline-completed-tab" tabindex="0">
							<div class="table-responsive check-wrapper">
								<table class="table table-project-status table-bordered mb-0 table-bottom-borderless" id="projectstatusTable">
									<thead>
										<tr>
											<th class="sorting-disabled width340 fs-14 text-black">{{ __('solarmitra::solarmitra.project_name') }}</th>
											<th class="sorting-disabled width160 fs-14 text-black text-nowrap">{{ __('solarmitra::solarmitra.client') }}</th>
											<th class="sorting-disabled mw-300 fs-14 text-black">{{ __('solarmitra::solarmitra.current_step') }}</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($completed_projects as $completed_project)
										@php
											$step = SolarMitraHelper::getProjectStep($completed_project->id);
											$doc = $completed_project->project_documents;
										@endphp
										<tr>
											<td class="d-inline-block fw-semibold text-black text-truncate" style="max-width: 340px;">{{$completed_project->title}}</td>
											<td>{{optional(optional($completed_project)->client)->name ?? 'N/A'}}</td>
											<td>
												<div class="d-flex align-items-center gap-2">
													<p class="m-0 text-warning fs-13 text-capitalize">{{$step}}</p>
													<div class="step-progress {{$step}}">
														<div class="step"></div>
														<div class="step"></div>
														<div class="step {{ !empty(@$doc->government_subsidy) ? '' : 'd-none'}}"></div>
														<div class="step"></div>
														<div class="step"></div>
														<div class="step"></div>
													</div>
												</div>
											</td>
										</tr>
										@empty
										<tr><td colspan="3" class="text-center">{{ __('solarmitra::solarmitra.no_completed_projects') }}</td></tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
						<!-- End - Completed Tab -->

						<!-- Start - Hold Tab -->
						<div class="tab-pane fade" id="underline-hold" role="tabpanel" aria-labelledby="underline-hold-tab" tabindex="0">
							<div class="table-responsive check-wrapper">
								<table class="table table-project-status table-bordered mb-0 table-bottom-borderless" id="projectstatusTable">
									<thead>
										<tr>
											<th class="sorting-disabled width340 fs-14 text-black">{{ __('solarmitra::solarmitra.project_name') }}</th>
											<th class="sorting-disabled width160 fs-14 text-black text-nowrap">{{ __('solarmitra::solarmitra.client') }}</th>
											<th class="sorting-disabled mw-300 fs-14 text-black">{{ __('solarmitra::solarmitra.current_step') }}</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($hold_projects as $hold_project)
										@php
											$step = SolarMitraHelper::getProjectStep($hold_project->id);
											$doc = $hold_project->project_documents;
										@endphp
										<tr>
											<td class="d-inline-block fw-semibold text-black text-truncate" style="max-width: 340px;">{{$hold_project->title}}</td>
											<td>{{optional(optional($hold_project)->client)->name ?? 'N/A'}}</td>
											<td>
												<div class="d-flex align-items-center gap-2">
													<p class="m-0 text-warning fs-13 text-capitalize">{{$step}}</p>
													<div class="step-progress {{$step}}">
														<div class="step"></div>
														<div class="step"></div>
														<div class="step {{ !empty(@$doc->government_subsidy) ? '' : 'd-none'}}"></div>
														<div class="step"></div>
														<div class="step"></div>
														<div class="step"></div>
													</div>
												</div>
											</td>
										</tr>
										@empty
										<tr><td colspan="3" class="text-center">{{ __('solarmitra::solarmitra.no_hold_projects') }}</td></tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
						<!-- End - Hold Tab -->

					</div>
					

				</div>
			</div>
		</div>
		<!-- End - Project Status Overview -->

	</div>
	@endcan
	
</div>

@endsection