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
				<li class="breadcrumb-item"><a href="{{ route('admin.solarmitra.transaction_types.list') }}">{{ __('solarmitra::solarmitra.transaction_types') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('solarmitra::solarmitra.transaction_types') }}</a></li>
			</ol>
		</div>
	</div>

	<div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.search') }} {{ __('solarmitra::solarmitra.transaction_types') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.solarmitra.transaction_types.list') }}" method="get">
                        <div class="row">
                            <div class="col-sm-4 m-sm-0 form-group">
                                <input type="search" name="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', request()->input('title')) }}">
                            </div>
                            <div class="col-sm-8 text-sm-end">
                                <input type="submit" name="search" value="{{ __('solarmitra::solarmitra.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.solarmitra.transaction_types.list') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
		<div class="col-md-4">
			<div class="row">
                <!-- Column starts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-block">
                        	@if(@$transactionType->id)
                            	<h4 class="card-title">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.transaction_type') }}</h4>
                            @else
                            	<h4 class="card-title">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.transaction_type') }}</h4>
                        	@endif
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <label for="parent_id">{{ __('solarmitra::solarmitra.parent') }} {{ __('solarmitra::solarmitra.transaction_type') }}</label>
                                        <select name="parent_id" id="parent_id" class="default-select form-control">
                                            <option value="">{{ __('solarmitra::solarmitra.no_parent') }}</option>
                                            @forelse($list as $id => $title)
	                                            @if (@$transactionType->id != $id)
                                                	<option value="{{ $id }}" {{ old('parent_id', @$transactionType->parent_id) == $id ? 'selected="selected"' : '' }}>{{ $title }}</option>
	                                            @endif
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{ __('solarmitra::solarmitra.title') }}</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title', @$transactionType->title) }}" required >
                                        @error('title')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                    	<label for="description">{{ __('solarmitra::solarmitra.description') }}</label>
                                    	<textarea name="description" id="description" class="form-control h-100" rows="5">{{ old('description', @$transactionType->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input type="hidden" name="cat_id" value="{{ @$transactionType->id }}">
                                <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.save') }}</button>
                                <a href="{{ route('admin.solarmitra.transaction_types.list') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.back') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<!-- Column starts -->
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header d-block">
							<h4 class="card-title">{{ __('solarmitra::solarmitra.transaction_types') }}</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-responsive-md mb-0">
									<thead>
										<tr>
											<th> <strong> {{ __('solarmitra::solarmitra.s_no') }} </strong> </th>
											<th> <strong> {{ __('solarmitra::solarmitra.name') }} </strong> </th>
											<th> <strong> {{ __('solarmitra::solarmitra.created') }} </strong> </th>
											<th class="text-center"> <strong> {{ __('solarmitra::solarmitra.actions') }} </strong> </th>
										</tr>
									</thead>
									<tbody>
										@php
											$i = $transaction_types ? $transaction_types->firstItem() : 0;
										@endphp
										@forelse ($transaction_types as $transaction_type)
											<tr>
												<td> {{ $i++ }} </td>
												<td> {{ $transaction_type['title'] }} </td>
												<td> {{ $transaction_type['created_at'] }} </td>
												<td class="text-center">
													<a href="{{ route('admin.solarmitra.transaction_types.list', $transaction_type['id']) }}" class="btn btn-primary shadow btn-xs sharp me-1" title="{{ __('solarmitra::solarmitra.edit') }}"><i class="icon-pencil"></i></a>
													<a href="{{ route('admin.solarmitra.transaction_types.destroy', $transaction_type['id']) }}" class="btn btn-danger shadow btn-xs sharp" title="{{ __('solarmitra::solarmitra.delete') }}"><i class="icon-trash-2"></i></a>
												</td>
											</tr>
										@empty
											<tr><td class="text-center" colspan="5"><p>{{ __('solarmitra::solarmitra.no') }} {{ __('solarmitra::solarmitra.transaction_types') }}</p></td></tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
						@if ($transaction_types && $transaction_types->hasPages())
	                    <div class="card-footer">
	                        {{ $transaction_types->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
	                    </div>
	                    @endif
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


@endsection