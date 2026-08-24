{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

			@include('solarmitra::business.components.project_detail_navigation')
			
			<!-- End - Project Tabs -->

				<div class="card rounded-0 border-0 border-bottom m-0">
	        		<div class="card-body p-3">
						<!-- Start - Filtering -->
						<form id="AjaxFilterForm" action="{{ route('business.solarmitra.contacts.'.(@$type ?? 'index')) }}">
			                <div class="d-flex gap-2 flex-wrap justify-content-between align-items-end">
			                    <div class="d-flex flex-wrap gap-2 align-items-center">
			                        <div class="wLeads">
		                    			<label for="basic-search" class="form-label mb-1">{{ __('solarmitra::solarmitra.find_filter_criteria') }}</label>
			                            <div class="input-group custom-search">
			                                <button class="input-group-text border-end-0 px-2 bg-transparent ApplyAjaxFilter" >
			                                    <i class="icon icon-search"></i>
			                                </button>
		                            		<input type="text" name="name" class="form-control border-start-0 width180" placeholder="{{ __('solarmitra::solarmitra.search') }}">
			                            </div>
			                        </div>
			                        @if (!@$type)
			                        <div class="wLeads">
			                            <label for="type" class="form-label mb-1">{{ __('solarmitra::solarmitra.user_type') }}</label>
			                            <select id="type" name="type[]" multiple class="form-control selectpicker text-primary ApplyAjaxFilter">
											<option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.type') }}</option>
											@foreach (config('solarmitra.business_user_types', []) as $element => $title)
												<option value="{{$element}}" @selected(in_array($element, SolarMitraHelper::getContactTypes(@$contact->id)))>{{$title}}</option>
											@endforeach
										</select>
			                        </div>
			                        @endif
			                        <div class="wLeads">
		                            <label for="basic-search" class="form-label mb-1">{{ __('solarmitra::solarmitra.email') }}</label>
		                            <input type="text" name="email" class="form-control ApplyAjaxFilter" placeholder="{{ __('solarmitra::solarmitra.email') }}">
			                        </div>
			                        <div class="wLeads">
		                            <label for="basic-search" class="form-label mb-1">{{ __('solarmitra::solarmitra.phone') }}</label>
		                            <input type="text" name="phone_number" class="form-control ApplyAjaxFilter" placeholder="{{ __('solarmitra::solarmitra.phone') }}">
			                        </div>
			                        <div class="wLeads">
		                            <label for="basic-search" class="form-label mb-1">{{ __('solarmitra::solarmitra.sort_by') }}</label>
		                            <select name="sort_by" class="form-select selectpicker ApplyAjaxFilter" title="{{ __('solarmitra::solarmitra.sort_by_default') }}">
		                                <option selected disabled>{{ __('solarmitra::solarmitra.sort_by_default') }}</option>
		                                <option value="name_asc">{{ __('solarmitra::solarmitra.name_asc') }}</option>
		                                <option value="name_desc">{{ __('solarmitra::solarmitra.name_desc') }}</option>
		                                <option value="created_asc">{{ __('solarmitra::solarmitra.created_asc') }}</option>
		                                <option value="created_desc">{{ __('solarmitra::solarmitra.created_desc') }}</option>
		                                <option value="modified_asc">{{ __('solarmitra::solarmitra.modified_asc') }}</option>
		                                <option value="modified_desc">{{ __('solarmitra::solarmitra.modified_desc') }}</option>
			                            </select>
			                        </div>
			                    </div>
		                     <button class="btn btn-danger" id="ResetAjaxFilter">{{ __('solarmitra::solarmitra.reset') }}</button>
			                </div>
			            </form>
						<!-- End - Filtering -->
					</div>
				</div>
             
			<!-- Start - Transaction -->
			<div class="container-fluid">

				<!-- Start - Table -->
				<div class="col-xl-12">
                    <div class="card lead-option">
                        <div class="card-body ps-3">
                            <div class="d-flex gap-2 justify-content-between flex-wrap align-items-center">
                                <div class="d-flex align-items-center gap-2">

                                    <div class="dropdown check-dropdown me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check custom-checkbox mb-0">
                                                <input type="checkbox" class="form-check-input CheckAllInputs" required="">
                                            </div>   
                                             <div class="dropdown-toggle dropdown-toggle-split px-1" role="button" data-bs-toggle="dropdown" aria-expanded="false"></div>  
                                             <ul class="dropdown-menu">
		                            <li><a class="dropdown-item" href="#">{{ __('solarmitra::solarmitra.active') }}</a></li>
                                            </ul>   
                                        </div>
                                    </div> 

									@can('SolarMitra > Business > ContactsController > multi_destroy')
                                    <span >
                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                            <div class="btn border px-2 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-expanded="false">
		                                    {{ __('solarmitra::solarmitra.bulk_action') }}
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-end">
		                                        <a class="dropdown-item BulkDeleteBtn" data-action="delete" data-alert_text="{{ __('solarmitra::solarmitra.delete_selected_contacts') }}" href="{{ route('business.solarmitra.contacts.multi_destroy') }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                            </div>
                                        </div>
                                    </span>
									@endcan

                                    <span class="ps-2 border-start" id="SelectedItemsTextBox"></span>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
									@can(['SolarMitra > Business > ContactsController > create', 'SolarMitra > Business > ContactsController > store'])
									<a href="{{ route('business.solarmitra.contacts.create',['type'=>@$type]) }}" id="AddContactBtn" class="btn border px-2 AjaxOffCanvasShow" >+ {{ __('solarmitra::solarmitra.add') }} {{ucfirst(Str::singular(@$type ?? 'Contact'))}}</a>
									@endcan
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="card mb-0 table-hover text-nowrap" id="ContactsTableContainer">
						<div class="table-responsive">
                        	@include('solarmitra::business.contacts.list_view')
						</div>
					</div>
				</div>
				<!-- End - Table -->
			</div>
			<!-- End - Transaction -->


@endsection


@push('inline-modals')
     <!-- Start - Remove Image Modal -->
    <div class="modal fade" id="imageRemoveConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content stylish-modal text-center p-3">
                <div class="text-danger mb-2">
                    <i class="icon icon-trash-2 fs-26"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Are you sure?</h5>
                <p class="text-muted mb-3">You want to remove this image.</p>
            
                <!-- Image preview -->
                <div class="preview-wrapper mb-3 rounded shadow-sm overflow-hidden">
                    <img id="previewImageInModal" src="" alt="Preview" class="img-fluid w-100" />
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-2">
		                     <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-1" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.cancel') }}</button>
		                     <button type="button" class="btn btn-danger rounded-pill px-4 py-1" id="confirmRemoveImageBtn">{{ __('solarmitra::solarmitra.yes_remove') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End - Remove Image Modal -->   
@endpush
