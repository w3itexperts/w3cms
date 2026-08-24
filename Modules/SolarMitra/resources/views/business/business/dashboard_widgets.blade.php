

<!-- Start - New Leads -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.new_leads') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$new_leads}}</p>
		</div>
	</div>
</div>
<!-- End - New Leads -->

<!-- Start - Active Projects -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-1 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.active_projects') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$active_projects}}</p>
		</div>
	</div>
</div>
<!-- End - Active Projects -->

<!-- Start - Pending Quotations -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-1 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.pending_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$pending_quotations}}</p>
			<p class="fs-13 mb-1 lh-sm">{{ __('solarmitra::solarmitra.sent') }}, {{ __('solarmitra::solarmitra.in_discussion') }} {{ __('solarmitra::solarmitra.and') }} {{ __('solarmitra::solarmitra.on_hold') }}</p>
		</div>
	</div>
</div>
<!-- End - Pending Quotations -->

<!-- Start - Outstanding -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-1 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.outstanding') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium lh-1 mb-1 text-danger">{{SolarMitraHelper::format_number($outstanding_payments,0)}}</p>
			<p class="fs-13 mb-1 lh-sm">{{ __('solarmitra::solarmitra.payment') }}</p>
		</div>
	</div>
</div>
<!-- End - Outstanding -->

<!-- Start - Installed Capacity -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-1 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.installed_capacity') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$installed_capacities}} {{ __('solarmitra::solarmitra.kw') }}</p>
		</div>
	</div>
</div>
<!-- End - Installed Capacity -->

<!-- Start - Material Alerts -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card bg-secondary-subtle">
		<div class="card-header pb-1 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.material_alerts') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$material_alerts}}</p>
			<p class="fs-13 mb-1 lh-sm">{{ __('solarmitra::solarmitra.low_stock') }}</p>
		</div>
	</div>
</div>
<!-- End - Material Alerts -->

<!-- Start - Quotations Related -->
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.draft_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$draft_quotations}}</p>
		</div>
	</div>
</div>
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.sent_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$sent_quotations}}</p>
		</div>
	</div>
</div>
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.in_discussion_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$in_discussion_quotations}}</p>
		</div>
	</div>
</div>
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.on_hold_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$on_hold_quotations}}</p>
		</div>
	</div>
</div>
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.client_confirmed_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$client_confirmed_quotations}}</p>
		</div>
	</div>
</div>
<div class="col-xxl-2 col-xl-4 col-md-6">
	<div class="card">
		<div class="card-header pb-0 border-0">
			<h4 class="fs-15 fw-medium">{{ __('solarmitra::solarmitra.rejected_quotations') }}</h4>
		</div>
		<div class="card-body pt-0">
			<p class="fs-40 fw-medium text-black lh-1 mb-1">{{$rejected_quotations}}</p>
		</div>
	</div>
</div>
<!-- End - Quotations Related -->

<!-- Start - Sales Funnel -->
<div class="col-xl-12">
	<div class="card">
		<div class="card-header">
			<h4 class="fs-15 fw-medium m-0">{{ __('solarmitra::solarmitra.sales_funnel') }}</h4>
		</div>
		<div class="card-body p-0">
			<div class="d-flex flex-xl-nowrap flex-wrap align-items-center">

				<div class="w-100 sale-funnel">
					<div class="d-flex justify-content-between p-3">
						<div class="d-flex flex-column gap-1">
							<span class="fs-15">{{ __('solarmitra::solarmitra.total_lead') }}</span>
							<p class="m-0 fs-40 text-black">{{$total_leads}}</p>
						</div>
						<p class="avatar border-0 bg-body-secondary m-0 text-black rounded-pill">1</p>
					</div>
					<div class="d-flex justify-content-between align-items-center border-top py-2 px-3 content">
						<a href="javascript:void(0);">
							<i class="icon-arrow-right fs-20 text-primary"></i>
						</a>
					</div>
				</div>

				<div class="w-100 sale-funnel">
					<div class="d-flex justify-content-between p-3 content">
						<div class="d-flex flex-column gap-1">
							<span class="fs-15">{{ __('solarmitra::solarmitra.qualified_leads') }}</span>
							<p class="m-0 fs-40 text-black">{{$total_qualified}}</p>
						</div>
						<p class="avatar border-0 bg-body-secondary m-0 text-black rounded-pill">2</p>
					</div>
					<div class="d-flex justify-content-between align-items-center border-top py-2 px-3 content">
						<a href="javascript:void(0);">
							<i class="icon-arrow-right fs-20 text-primary"></i>
						</a>
					</div>
				</div>

				<div class="w-100 sale-funnel">
					<div class="d-flex justify-content-between p-3 content">
						<div class="d-flex flex-column gap-1">
							<span class="fs-15">{{ __('solarmitra::solarmitra.quotation_sent') }}</span>
							<p class="m-0 fs-40 text-black">{{$total_quotation_send}}</p>
						</div>
						<p class="avatar border-0 bg-body-secondary m-0 text-black rounded-pill">3</p>
					</div>
					<div class="d-flex justify-content-between align-items-center border-top py-2 px-3 content">
						<a href="javascript:void(0);">
							<i class="icon-arrow-right fs-20 text-primary"></i>
						</a>
					</div>
				</div>

				<div class="w-100 sale-funnel">
					<div class="d-flex justify-content-between p-3 content">
						<div class="d-flex flex-column gap-1">
							<span class="fs-15">{{ __('solarmitra::solarmitra.project_quotation_won') }}</span>
							<p class="m-0 fs-40 text-black">{{$apporoved_quotations}}</p>
						</div>
						<p class="avatar border-0 bg-body-secondary m-0 text-black rounded-pill">4</p>
					</div>
					<div class="d-flex justify-content-between align-items-center border-top py-2 px-3 content">
						<a href="javascript:void(0);">
							<i class="icon-arrow-right fs-20 text-primary"></i>
						</a>
					</div>
				</div>

				<div class="w-100 sale-funnel">
					<div class="d-flex justify-content-between p-3 content">
						<div class="d-flex flex-column gap-1">
							<span class="fs-15">{{ __('solarmitra::solarmitra.penal_installed') }}</span>
							<p class="m-0 fs-40 text-black">{{$installed_panels}}</p>
						</div>
						<p class="avatar border-0 bg-body-secondary m-0 text-black rounded-pill">5</p>
					</div>
					<div class="d-flex justify-content-between align-items-center border-top py-2 px-3 content">
						<a href="javascript:void(0);">
							<i class="icon-arrow-right fs-20 text-primary"></i>
						</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- End - Sales Funnel -->
