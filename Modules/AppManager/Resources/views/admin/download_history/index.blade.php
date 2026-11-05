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
				<li class="breadcrumb-item"><a href="{{ route('admin.download-history') }}">{{ __('common.downloadHistory') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all') }} {{ __('common.downloadHistory') }}</a></li>
			</ol>
		</div>
	</div>



	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('common.downloadHistory') }}</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table class="table table-striped verticle-middle table-responsive-lg mb-0">
							<thead>
								<tr>
									<th> <strong> {{ __('common.s_no') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('user_id', __('common.user_id')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('user_ip', __('common.user_ip')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('city', __('common.city')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('country', __('common.country')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('country_code', __('common.country_code')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('longitude', __('common.longitude')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('latitude', __('common.latitude')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('browser', __('common.browser')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('os', __('common.os')) !!} </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>


								</tr>
							</thead>
							<tbody>
								@php
									$i = $list->firstItem();
								@endphp
								@forelse ($list as $val)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ $val->user_id }} </td>
										<td> {{ $val->user_ip }} </td>
                                        <td> {{ $val->city }} </td>
                                        <td> {{ $val->country }} </td>
										<td> {{ $val->country_code }} </td>
                                        <td> {{ $val->longitude }} </td>
                                        <td> {{ $val->latitude }} </td>
                                        <td> {{ $val->browser }} </td>
                                        <td> {{ $val->os }} </td>
                                        <td> {{ $val->created_at }} </td>

									</tr>
								@empty
									<tr><td class="text-center" colspan="6"><p>{{ __('common.downloads_not_found') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
					{!! $list->onEachSide(1)->appends(Request::input())->links() !!}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection
