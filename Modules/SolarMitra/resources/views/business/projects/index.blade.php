{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

			
<div class="container-fluid">	
	<div class="row">
		<div class="col-lg-12">
				<form method="get" class="mb-3">
					<div class="row gy-2">
						<div class="col-xl-2 col-md-4">
								<input type="text" class="form-control " name="title" value="{{ request('title') }}" placeholder="{{ __('solarmitra::solarmitra.title') }}">
						</div>
						<div class="col-xl-2 col-md-4">
							<select class="selectpicker form-control me-2" name="client_id" data-live-search="true">
								<option value="">{{ __('solarmitra::solarmitra.select_client') }}</option>
								@foreach (SolarMitraHelper::getContactsList('clients') as $key => $status)
									<option value="{{$key}}" @selected(request('client_id') == $key)>{{$status}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xl-2 col-md-4">
							<select class="selectpicker form-control me-2" name="status[]" multiple>
								<option value="" @selected(in_array(null, request('status',[])))>{{ __('solarmitra::solarmitra.all') }}</option>
								@foreach (config('solarmitra.projects_status') as $key => $status)
									<option value="{{$key}}" @selected(in_array($key, request('status',[])))>{{$status}}</option>
								@endforeach
							</select>
						</div>
            <div class="col-xl-2 col-md-4">
                <select name="sort_by" class="form-bsselect-sm selectpicker ">
                    <option value="">-- Sort by --</option>
                    <option value="title_asc" @selected('title_asc' == request('sort_by')) >{{ __('solarmitra::solarmitra.title_asc') }}</option>
                    <option value="title_desc" @selected('title_desc' == request('sort_by'))>{{ __('solarmitra::solarmitra.title_desc') }}</option>
                    <option value="created_asc" @selected('created_asc' == request('sort_by'))>{{ __('solarmitra::solarmitra.created_asc') }}</option>
                    <option value="created_desc" @selected('created_desc' == request('sort_by'))>{{ __('solarmitra::solarmitra.created_desc') }}</option>
                    <option value="modified_asc" @selected('modified_asc' == request('sort_by'))>{{ __('solarmitra::solarmitra.modified_asc') }}</option>
                    <option value="modified_desc" @selected('modified_desc' == request('sort_by'))>{{ __('solarmitra::solarmitra.modified_desc') }}</option>
                </select>
            </div>
							
						<div class="col-xl-4">
							<button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
							<a href="{{ route('business.solarmitra.projects.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
							@can(['SolarMitra > Business > ProjectsController > create', 'SolarMitra > Business > ProjectsController > store'])
							<a href="{{ route('business.solarmitra.projects.create') }}" class="btn btn-primary me-auto ms-2 float-end"  >{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.project') }}</a>
							@endcan
						</div>
					</div>
				</form>
			<div class="">
			</div>


			<div class="row">
				@php
					$i = $projects->firstItem();
				@endphp
				@forelse ($projects as $project)
					@php
            $step = SolarMitraHelper::getProjectStep($project->id);
						$doc = $project->project_documents;

		        $document_route = ($step == 'done') ? 'documents' : $step;

		        $project_class = match ($project->status) {
		        	1 => 'draft',
		        	2 => 'running',
		        	3 => 'completed',
		        	4 => 'hold',
		        	default => null,
		        };

		         $project_card_colors = [
		        	'draft' => '#F3F4F6',
		        	'running' => '#DBEAFE',
		        	'completed' => '#DCFCE7',
		        	'hold' => '#FEF3C7',

		        ];

		        $badge_class = match ($project->status) {
		        	1 => 'bg-gray',
		        	2 => 'bg-info',
		        	3 => 'bg-success',
		        	4 => 'bg-warning',
		        	default => 'bg-primary',
		        };
					@endphp
					<!-- Start - First List -->
					<div class="col-md-6 col-xl-4 project-{{ $project_class }}">
						<div class="card" 
						>
							<div class="card-body">
								<div class="row g-1">
									<div class="col-12 col-sm-6">
										@if(auth('business')->user()->can('SolarMitra > Business > ProjectsController > dashboard'))
										<a href="{{ route('business.solarmitra.projects.dashboard' , $project->id) }}">
											<h4 class="m-0 lh-sm">
												{{$project->title}}
											</h4>
										</a>
										@else
											<h4 class="m-0 lh-sm">
												{{$project->title}}
											</h4>
										@endif
										<p class="m-0">
										@forelse ($project->addresses as $projectAddress)
											<span>{{$projectAddress->address_title}} : {{$projectAddress->address}}, {{$projectAddress->city->name}}</span>
										@empty
										@endforelse
										</p>
									</div>
									<div class="col-12 col-sm-6">
										<div class="d-flex gap-1 flex-sm-column align-items-center align-items-sm-end justify-content-between">
											<div class="d-flex align-items-center">
												@if(auth('business')->user()->can('SolarMitra > Business > ProjectsController > ' . $document_route))
												<a href="{{ route('business.solarmitra.projects.'.$document_route , $project->id) }}" class="d-flex align-items-center gap-2">
													<p class="m-0 text-warning fs-13 text-capitalize">{{$step}}</p>
													<div class="step-progress {{$step}}">
														<div class="step"></div>
														<div class="step"></div>
														<div class="step {{ !empty(@$doc->government_subsidy) ? '' : 'd-none'}}"></div>
														<div class="step"></div>
														<div class="step"></div>
														<div class="step"></div>
													</div>
												</a>
												@else
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
												@endif
												@if (
													(
														auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') &&
														auth('business')->user()->can('SolarMitra > Business > QuotationsController > update')
													) ||
													(
														auth('business')->user()->can('SolarMitra > Business > ProjectsController > edit') &&
														auth('business')->user()->can('SolarMitra > Business > ProjectsController > update')
													) ||
													auth('business')->user()->can('SolarMitra > Business > ProjectsController > destroy')
												)
												<div class="dropdown custom-dropdown mb-0 tbl-orders-style">
													<div class="btn btn-square rounded h-auto w-auto ms-2 p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-gear text-black"></i>
													</div>
													<div class="dropdown-menu dropdown-menu-end">
														@can(['SolarMitra > Business > ProjectsController > edit', 'SolarMitra > Business > ProjectsController > update'])
														<a class="dropdown-item" href="{{ route('business.solarmitra.projects.edit' , $project->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
														@endcan
														@if ($project->quotation && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
														<a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$project->quotation->id) }}">Project Quotation</a>
														@endif
															@can('SolarMitra > Business > ProjectsController > destroy')
															<a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.projects.destroy' , $project->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
															@endcan
													</div>
												</div>
												@endif
											</div>
											<h4 class="m-0 fs-16">{{@$project->capacity}}</h4>
											<span class="badge badge-sm {{$badge_class}}">{{$project_class}}</span>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start - Card Footer -->
							<div class="card-footer">
								<div class="row">
									<p class="col-12 col-sm-6 m-0">Project Value : <span class="text-success">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($project->project_value ?? 0)}}</span></p>
									<p class="col-12 col-sm-6 text-sm-end m-0">
										@if(auth('business')->user()->can('SolarMitra > Business > ProjectsController > assign_project'))
											@if (optional(@$project->project_member)->name)
											Managed By: <a class="btn btn-link text-primary p-0" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxSm" href="{{ route('business.solarmitra.projects.assign_project',$project->id) }}">{{optional(@$project->project_member)->name}}</a>
											@else
											<a class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxSm" href="{{ route('business.solarmitra.projects.assign_project',$project->id) }}">Assign Project</a>
											@endif
										@else
											@if (optional(@$project->project_member)->name)
											Managed By: <span class="text-primary">{{optional(@$project->project_member)->name}}</span>
											@endif
										@endif
									</p>
								</div>
							</div>
							<!-- End - Card Footer -->

						</div>
					</div>
					<!-- End - First List -->
				@empty
					<div class="text-center my-5">
						<svg clip-rule="evenodd" fill-rule="evenodd" height="40" fill="var(--bs-primary)" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 48 48" width="40" xmlns="http://www.w3.org/2000/svg" id="fi_8302404"><g transform="translate(-48 -144)"><g id="Icon"><g transform="translate(-384 96)"><path d="m467 83h-3c-.552 0-1 .448-1 1s.448 1 1 1h3v3c0 .552.448 1 1 1s1-.448 1-1v-3h3c.552 0 1-.448 1-1s-.448-1-1-1h-3v-3c0-.552-.448-1-1-1s-1 .448-1 1z"></path></g><g transform="translate(0 -4)"><path d="m58 167h20c.552 0 1-.448 1-1s-.448-1-1-1h-20c-.552 0-1 .448-1 1s.448 1 1 1z"></path></g><g transform="translate(0 2)"><path d="m58 167h20c.552 0 1-.448 1-1s-.448-1-1-1h-20c-.552 0-1 .448-1 1s.448 1 1 1z"></path></g><g transform="translate(0 8)"><path d="m58 167h12c.552 0 1-.448 1-1s-.448-1-1-1h-12c-.552 0-1 .448-1 1s.448 1 1 1z"></path></g><g transform="translate(0 14)"><path d="m58 167h12c.552 0 1-.448 1-1s-.448-1-1-1h-12c-.552 0-1 .448-1 1s.448 1 1 1z"></path></g><path d="m82.804 190.936c-.262.042-.53.064-.804.064-6.926 0-21.074 0-28 0-2.761 0-5-2.239-5-5 0-8.367 0-27.633 0-36 0-1.326.527-2.598 1.464-3.536.938-.937 2.21-1.464 3.536-1.464h18.343c1.326 0 2.598.527 3.536 1.464 2.295 2.296 7.361 7.362 9.657 9.657.937.938 1.464 2.21 1.464 3.536v9.758c4.615 1.307 8 5.554 8 10.585 0 6.071-4.929 11-11 11-.404 0-.802-.022-1.196-.064zm1.196-19.936c4.967 0 9 4.033 9 9s-4.033 9-9 9-9-4.033-9-9 4.033-9 9-9zm1-1.955v-9.388c0-.223-.025-.443-.073-.657h-6.927c-2.761 0-5-2.239-5-5v-6.927c-.214-.048-.434-.073-.657-.073h-18.343c-.796 0-1.559.316-2.121.879-.563.562-.879 1.325-.879 2.121v36c0 1.657 1.343 3 3 3h23.677c-2.828-1.991-4.677-5.281-4.677-9 0-6.071 4.929-11 11-11 .337 0 .67.015 1 .045zm-1.414-12.045-8.586-8.586v5.586c0 1.657 1.343 3 3 3z"></path></g></g></svg>
						<h4 class="mt-2">{{ __('solarmitra::solarmitra.no_projects') }}</h4>
						<p>{{ __('Create your first project to start tracking installations, documents, and payments.') }}</p>
					</div>
				@endforelse

				@if ($projects && $projects->hasPages())
				<div class="col-12">
					<div class="card">
		        <div class="card-footer">
		            {{ $projects->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
		        </div>
					</div>
				</div>
        @endif
			</div>
		</div>
	</div>
	
	
</div>


@endsection

@push('inline-modals')
<div class="modal fade" id="ProjectAddModal" tabindex="-1" aria-labelledby="ProjectAddModalLabel" >
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<form action="{{ route('business.solarmitra.projects.store') }}" id="ProjectAddForm" method="post" enctype="multipart/form-data">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="ProjectAddModalLabel">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.project') }}</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
						@csrf
						<div class="row">
							<div class="form-group mb-3  col-md-3">
								<label class="form-label" for="title">{{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
								<input type="text" name="title" class="form-control" id="title" placeholder="{{ __('solarmitra::solarmitra.title') }}" value="{{ old('title') }}">
								<p class="text-danger" id="titleError"></p>
							</div>
							<div class="form-group mb-3 col-md-3">
								<label class="form-label" for="start_date">{{ __('solarmitra::solarmitra.start_date') }}</label>
								<input type="datetime-local" name="start_date" class="form-control" id="start_date" placeholder="{{ __('solarmitra::solarmitra.start_date') }}" value="{{ old('start_date') }}"  >
								
							</div>
							<div class="form-group mb-3 col-md-3">
								<label class="form-label" for="end_date">{{ __('solarmitra::solarmitra.end_date') }}</label>
								<input type="datetime-local" name="end_date" class="form-control" id="end_date" placeholder="{{ __('solarmitra::solarmitra.end_date') }}" value="{{ old('end_date') }}"  >
								
							</div>
							<div class="form-group mb-3 col-md-3">
								<label class="form-label" for="project_value">{{ __('solarmitra::solarmitra.project_value') }}</label>
								<input type="number" name="project_value" class="form-control" id="project_value" placeholder="{{ __('solarmitra::solarmitra.project_value') }}" value="{{ old('project_value') }}"  >
								
							</div>

						</div>
						@include('solarmitra::admin.components.address')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
					<button  class="btn btn-primary" type="submit">{{ __('solarmitra::solarmitra.save_changes') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endpush

@push('inline-scripts')
<script>
  $(document).ready(function () {
    $('#ProjectAddForm').on('submit', function (e) {
      e.preventDefault();

      $('#titleError').text('');

      $.ajax({
        url: "{{ route('business.solarmitra.projects.store') }}", 
        headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          window.location.reload();
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            if (errors.title) {
              $('#titleError').text(errors.title[0]);
            }
          } else {
            alert('Something went wrong!');
          }
        }
      });
    });
  });
</script>
@endpush