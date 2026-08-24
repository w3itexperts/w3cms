{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('solarmitra::solarmitra.welcome_back_title') }}</h4>
				<p class="mb-0">{{ __('solarmitra::solarmitra.welcome_back_desc') }}</p>
		    </div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.solarmitra.businesses.index') }}">{{ __('solarmitra::solarmitra.businesses') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('solarmitra::solarmitra.businesses') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.search') }} {{ __('solarmitra::solarmitra.businesses') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.solarmitra.businesses.index') }}" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4 m-sm-0 form-group">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="col-sm-4 m-sm-0 form-group">
                                <input type="search" name="phone" class="form-control" placeholder="{{ __('solarmitra::solarmitra.phone') }}" value="{{ old('phone', request()->input('phone')) }}">
                            </div>
                            <div class="col-sm-4 text-sm-end">
                                <input type="submit" name="search" value="{{ __('solarmitra::solarmitra.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.solarmitra.businesses.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('solarmitra::solarmitra.businesses') }}</h4>
					<a href="{{ route('admin.solarmitra.businesses.create') }}" class="btn btn-primary">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.business') }}</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0 min-width-40" >
							<thead>
								<tr>
									<th> <strong> {{ __('solarmitra::solarmitra.s_no') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.logo') }} </strong> </th>
									<th> <strong> {{ __('Info') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.phone') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.city') }} </strong> </th>
									<th> <strong> {{ __('solarmitra::solarmitra.state') }} </strong> </th>
									<th class="text-center"> <strong> {{ __('solarmitra::solarmitra.actions') }} </strong> </th>
                                   
								</tr>
							</thead>
							<tbody>
								@php
									$i = $businesses->firstItem();
								@endphp
								@forelse ($businesses as $business)
									<tr>
										{{-- @dd($business->addresses->first()->city->name) --}}
										<td> {{ $i++ }} </td>
										<td> 
											@if($business->logo && file_exists(public_path().'/storage/business/'.$business->logo))
												<img src="{{ asset('storage/business/'.$business->logo) }}" alt="{{ $business->logo }}" width="60px">
											@else
												<img src="{{ asset('images/noimage.jpg') }}" alt="No Image" width="60px">
											@endif
										</td>
										<td> 
											User: {{ optional($business->user)->fullname }} 
											<br>
											App Key: {{$business->business_uuid}}
										</td>
										<td> {{ $business->phone }} </td>
										<td> {{ optional(optional($business->addresses->first())->city)->name }} </td>
										<td> {{ optional(optional($business->addresses->first())->state)->name }} </td>
										<td class="text-center">
											<a href="{{ route('admin.solarmitra.businesses.edit', $business->id) }}" class="btn btn-primary shadow btn-xs sharp me-1 " title="{{ __('solarmitra::solarmitra.edit') }}"><i class="icon-pencil"></i></a>	
											<a href="{{ route('admin.solarmitra.businesses.destroy', $business->id) }}" class="btn btn-danger shadow btn-xs sharp deleteRecord" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="icon-trash-2"></i></a>
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="8"><p>{{ __('solarmitra::solarmitra.no_businesses') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				@if ($businesses && $businesses->hasPages())
				<div class="card-footer">
					{{ $businesses->onEachSide(1)->appends(request()->input())->links('admin.elements.pagination') }}
				</div>
				@endif
			</div>
		</div>
	</div>

</div>


@endsection