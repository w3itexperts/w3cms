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
						
					<div class="col-xl-6">
						<button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
						<a href="{{ route('business.solarmitra.projects.archived_projects') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
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
					@endphp
					<!-- Start - First List -->
					<div class="col-md-6 col-xl-4">
						<div class="card">
							<div class="card-body">
								<div class="row g-1">
									<div class="col-12 col-sm-6">
											<h4 class="m-0 lh-sm">
												{{$project->title}}
											</h4>
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
												<a href="javascript:void(0);" class="d-flex align-items-center gap-2">
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
												@can('SolarMitra > Business > ProjectsController > move_to_projects')
												<div class="dropdown custom-dropdown mb-0 tbl-orders-style">
													<div class="btn btn-square rounded h-auto w-auto ms-2 p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
														<i class="fa-solid fa-gear text-black"></i>
													</div>
													<div class="dropdown-menu dropdown-menu-end">
														<a class="dropdown-item" href="{{ route('business.solarmitra.projects.move_to_projects' , $project->id) }}">Move to Projects</a>
														{{-- @if ($project->status == config('solarmitra.projects_status_keys.Draft'))@dd($project->quotation->status) --}}
														@can('SolarMitra > Business > ProjectsController > destroy')
															<a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.projects.destroy' , $project->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
															@endcan
														{{-- @endif --}}
													</div>
												</div>
												@endcan
											</div>
											<h4 class="m-0 fs-16">{{@$project->capacity}}</h4>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Start - Card Footer -->
							<div class="card-footer">
								<div class="row">
									<p class="col-12 col-sm-6 m-0">Project Value : <span class="text-success">{{$project->project_value ?? 0}}</span></p>
									<p class="col-12 col-sm-6 text-sm-end m-0">

										@if (optional(@$project->project_member)->name)
										Managed By: <a class="btn btn-link text-primary p-0" href="javascript:void(0);">{{optional(@$project->project_member)->name}}</a>
										@else
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
						<h4 class="mt-2">{{ __('solarmitra::solarmitra.no_archived_projects') }}</h4>
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

