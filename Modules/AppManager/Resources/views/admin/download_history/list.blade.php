{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.downloadHistory') }}</h4>
				<span>{{ __('common.downloadHistory') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.download-history.reports') }}">{{ __('Download History Reports') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all') }} {{ __('Download History Reports') }}</a></li>
			</ol>
		</div>
	</div>


	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('Countries') }}</h4>
				</div>
				<div class="card-body">
					@forelse ($country_list as $val)
						<div class="d-flex align-items-center justify-content-between">
							{{-- <span>{{ $val->country_code }}</span> --}}
							<span>{{ $val->country ?? 'Others' }}</span>
							<span>{{ $val->total_downloads }}</span>
						</div>
						<hr>
					@empty
					@endforelse
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card h-auto">
				<div class="card-header border-0 flex-wrap pb-0">
					<div class="mb-3">
						<h4 class="fs-20 text-black">{{ __('common.users_overview') }}</h4>
						<p class="mb-0 fs-12 ">{{ __('common.how_many_users_join_text') }}</p>
					</div>
				</div>
				<div class="card-body pb-2 px-3">
					<div id="revenueMap" class="market-line" data-series="{{ json_encode($graph_data) }}"></div>
				</div>
			</div>
			<div class="card  h-auto">
				<div class="card-header bg-primary">
					@if(request()->year)
					<h4 class="card-title text-white">
						Records : Year - 
						{{request()->year}} | <a class="text-white" href="{{ route('admin.download-history.reports', \Arr::except(request()->query(), ['year'])) }}">All Time</a>
					</h4>
					@elseif(request()->month)
					<h4 class="card-title text-white">
						Records : Month | {{\Carbon\Carbon::parse(request()->month)->format('M')}}
						| Year - 
						<a class="text-white link" href="{{ route('admin.download-history.reports', array_merge(['year'=>\Carbon\Carbon::parse(request()->month)->format('Y')],\Arr::except(request()->query(), ['month']))) }}">
							{{\Carbon\Carbon::parse(request()->month)->format('Y')}}
						</a>
						| 
						<a class="text-white" href="{{ route('admin.download-history.reports', \Arr::except(request()->query(), ['month'])) }}">All Time</a>
					</h4>
					@elseif(request()->date)
					<h4 class="card-title text-white">
						Records : Date - {{\Carbon\Carbon::parse(request()->date)->format('d')}} 
						| Month -  
						<a class="text-white link" href="{{ route('admin.download-history.reports', array_merge(['month'=>\Carbon\Carbon::parse(request()->date)->format('Y-m')],\Arr::except(request()->query(), ['date']))) }}">
							{{\Carbon\Carbon::parse(request()->date)->format('M')}}
						</a>
						| Year - 
						<a class="text-white link" href="{{ route('admin.download-history.reports', array_merge(['year'=>\Carbon\Carbon::parse(request()->date)->format('Y')],\Arr::except(request()->query(), ['date']))) }}">
							{{\Carbon\Carbon::parse(request()->date)->format('Y')}}
						</a>
						| 
						<a class="text-white" href="{{ route('admin.download-history.reports', \Arr::except(request()->query(), ['date'])) }}">All Time</a>
					</h4>
					@else
					<h4 class="card-title text-white">All Time Data</h4>
					@endif
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table mb-0">
							<thead>
								<tr>
									@if(request()->year)
									<th>Month</th>
									@elseif(request()->month)
									<th>Date</th>
									@elseif(request()->date)
									<th>Time</th>
									@else
									<th>Year</th>
									@endif
									<th width="100px">Projects</th>
								</tr>
							</thead>
							<tbody>
						@php
							$date_type = 'created_at';
						@endphp
						@if(request()->year)
					    	@forelse ($records as $record)
								@php
									$month = \Carbon\Carbon::parse($record->$date_type)->format('Y-m');
								@endphp
								<tr>
									<td>
										<a href="{{ route('admin.download-history.reports', \Arr::except( array_merge(['month'=>$month],request()->query()), ['year'])) }}">
											{{ \Carbon\Carbon::parse($record->$date_type)->format('M')}}
										</a>
									</td>
									<td>{{$record->total_items}}</td>
								</tr>
							@empty
							@endforelse
						@elseif(request()->month)
							@forelse ($records as $record)
								@php
									$month = \Carbon\Carbon::parse($record->$date_type)->format('Y-m-d');
								@endphp
								<tr>
									<td>
										<a href="{{ route('admin.download-history.reports',  \Arr::except(array_merge(['date'=>$month],request()->query()), ['month'])) }}">
											{{\Carbon\Carbon::parse($record->$date_type)->format('d')}}
										</a>
									</td>
									<td>{{$record->total_items}}</td>
								</tr>
							@empty
							@endforelse
						@elseif(request()->date)
							@forelse ($records as $record)
								@php
									$date = \Carbon\Carbon::parse($record->$date_type)->format('h:i:s');
								@endphp
								<tr>
									<td>
										<a href="javascript:void(0);">{{$date}}</a>
									</td>
									<td>{{$record->total_items}}</td>
								</tr>
							@empty
							@endforelse
						@else
							@forelse ($records as $record)
								@php
									$year = \Carbon\Carbon::parse($record->$date_type)->format('Y');
								@endphp
								<tr>
									<td>
										<a href="{{ route('admin.download-history.reports', array_merge(['year'=>$year],request()->query())) }}">{{$year}}</a>
									</td>
									<td>{{$record->total_items}}</td>
								</tr>
								
							@empty
							@endforelse
						@endif
								<tr>
									<td>
										<b></b>
									</td>
									<td>
										<b>{{$records->sum('total_items')}}</b>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection


@push('inline-scripts')
	<script>

		/* apex chart start */
		var projectChart2 = function(){ 
			
			if(jQuery('#revenueMap').length == 0){
				return false;
			}

			var options = {
				series: [{
				      name: "Projects",
				      data: jQuery('#revenueMap').data('series'),
				    }],

				  chart: {
				  id: 'area-datetime',
				  type: 'area',
				  height: 350,
				  zoom: {
					autoScaleYaxis: true
				  }
				},
				annotations: {
				  yaxis: [{
					y: 30,
					borderColor: '#999',
					label: {
					  show: true,
					  text: 'Support',
					  style: {
						color: "#fff",
						background: '#00E396'
					  }
					}
				  }],
				  xaxis: [{
					borderColor: '#999',
					yAxisIndex: 0,
					label: {
					  show: true,
					  text: 'Rally',
					  style: {
						color: "#fff",
						background: '#775DD0'
					  }
					}
				  }]
				},
				dataLabels: {
				  enabled: false
				},
				markers: {
				  size: 0,
				  style: 'hollow',
				},
				xaxis: {
				  type: 'datetime',
				  tickAmount: 6,
				  labels: {
				      datetimeFormatter: {
				        year: 'yyyy',
				        month: 'MMM',
				      	day: 'dd MMM',
				      }
				    }
				},
				tooltip: {
				  x: {
					format: 'dd MMM yyyy'
				  },
				},

				fill: {
				  type: 'gradient',
				  gradient: {
					shadeIntensity: 1,
					opacityFrom: 0.7,
					opacityTo: 0.9,
					stops: [0, 100]
				  }
				},
			};

			var chart = new ApexCharts(document.querySelector("#revenueMap"), options);
			
			chart.render();
		  
		}
		/* apex chart end */

		projectChart2();
	</script>
@endpush