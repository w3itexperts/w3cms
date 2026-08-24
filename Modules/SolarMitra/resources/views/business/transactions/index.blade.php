{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

             
			<!-- Start - Transaction -->
			<div class="container-fluid">
				@if ($project)
					<h4>{{$project->title}}</h4>
				@endif
				<div class="row">

					<div class="col-xl-12">
					    <form method="get">
					        <div class="card mb-3">
					            <div class="card-body">
					                <div class="row g-3 align-items-end">
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.search') }}</label>
					                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Description, amount, number...">
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.type') }}</label>
					                        <select class="form-select selectpicker" name="transfer_type" data-live-search="true">
					                            <option value="">{{ __('solarmitra::solarmitra.all_types') }}</option>
					                            <option value="cr" @selected(request('transfer_type') == 'cr')>Credit (Income)</option>
					                            <option value="dr" @selected(request('transfer_type') == 'dr')>Debit (Expense)</option>
					                        </select>
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.payment_mode') }}</label>
					                        <select class="form-select selectpicker" name="transfer_mode" data-live-search="true">
					                            <option value="">{{ __('solarmitra::solarmitra.all_modes') }}</option>
					                            @foreach(config('solarmitra.transfer_modes') as $key => $mode)
					                                <option value="{{ $key }}" @selected(request('transfer_mode') == $key)>{{ $mode }}</option>
					                            @endforeach
					                        </select>
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.category') }}</label>
					                        <select class="form-select selectpicker" name="transaction_type_id" data-live-search="true">
					                            <option value="">{{ __('solarmitra::solarmitra.all_categories') }}</option>
					                            @foreach($transaction_types as $type)
					                                <option value="{{ $type->id }}" @selected(request('transaction_type_id') == $type->id)>{{ $type->title }}</option>
					                            @endforeach
					                        </select>
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.references') }}</label>
					                        <select class="form-select selectpicker" name="reference_type" data-live-search="true">
					                            <option value="">{{ __('solarmitra::solarmitra.all_references') }}</option>
					                            <option value="invoice" @selected(request('reference_type') == 'invoice')>{{ __('solarmitra::solarmitra.invoice') }}</option>
					                            <option value="project" @selected(request('reference_type') == 'project')>Project</option>
					                        </select>
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.from_date') }}</label>
					                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
					                    </div>
					                    <div class="col-xl-2 col-md-4">
					                        <label class="form-label fw-medium">{{ __('solarmitra::solarmitra.to_date') }}</label>
					                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
					                    </div>
					                    <div class="col">
					                        <div class="d-flex gap-2 align-items-center justify-content-end">
					                            <button type="submit" class="btn btn-primary">{{ __('solarmitra::solarmitra.filter') }}</button>
					                            <a href="{{ route('business.solarmitra.transactions.index') }}" class="btn btn-danger">{{ __('solarmitra::solarmitra.reset') }}</a>
					                            <!-- Start - Create Transaction Dropdown -->
												<div class="dropdown">
													<button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
														Create Transaction +
													</button>
													<div class="dropdown-menu p-4 width440">
															
														<div class="mb-2">
															<p class="fs-12 text-gray py-1 border-bottom border-dotted">{{ __('solarmitra::solarmitra.payment') }}</p>
															<div class="row g-3">
																<div class="col-6">
																	<a href="{{ route('business.solarmitra.transactions.create','income') }}" class="btn btn-sm btn-success light w-100 AjaxOffCanvasShow"  >Payment Input</a>
																</div>
																<div class="col-6">
																	<a href="{{ route('business.solarmitra.transactions.create','expense') }}" class="btn btn-sm btn-danger light w-100 AjaxOffCanvasShow"  >Payment Output</a>
																</div>
															</div>
														</div>
														<div class="mb-2">
															<p class="fs-12 text-gray py-1 border-bottom border-dotted">Sales</p>
															<div class="row g-3">
																<div class="col-6">
																	<a href="{{ route('business.solarmitra.transactions.create','income-invoice-payment') }}" class="btn btn-sm btn-dark light w-100 AjaxOffCanvasShow"  >Sales Invoice</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- End - Create Transaction Dropdown -->
					                        </div>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </form>
					</div>
					<!-- End - Filtering -->

					<!-- Start - Invoice -->
					<div class="col-xl-4">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<span class="text-black">Invoice Income (Paid)</span>
										<span class="cursor-pointe text-black">
											<svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Invoice without GST : ?0  GST : ?0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="" style="width:var(--ng-icon__size, 1em);height:var(--ng-icon__size, 1em);stroke-width:var(--ng-icon__stroke-width, 2)"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
										</span>
										<h2 class="mb-0 text-black">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($invoice_payment_in ?? 0) }}</h2>
									</div>
									<div>
										<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M29.1693 4.16797H12.5026C11.3975 4.16797 10.3377 4.60696 9.55633 5.38836C8.77492 6.16976 8.33594 7.22957 8.33594 8.33464V41.668C8.33594 42.773 8.33595 44.793 8.33595 45.8346L14.586 41.668L19.7943 45.8346L25.0026 41.668L30.211 45.8346L35.4193 41.668L41.6693 45.8346C41.6693 45.8346 41.6693 42.773 41.6693 41.668V16.668V6.16797C41.6693 5.0634 40.7738 4.16797 39.6693 4.16797H29.1693Z" stroke="#5580E7" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M25.0026 27.082H14.5859" stroke="#5580E7" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M25.0026 33.332H14.5859" stroke="#5580E7" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M33.3333 27.082H31.25" stroke="#5580E7" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M33.3333 33.332H31.25" stroke="#5580E7" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M17.2057 13.4883V20.832H15.1641V13.4883H17.2057Z" fill="#5580E7" fill-opacity="0.5"/>
											<path d="M26.2122 20.832H24.1705L21.4517 16.7279V20.832H19.4101V13.4883H21.4517L24.1705 17.6445V13.4883H26.2122V20.832Z" fill="#5580E7" fill-opacity="0.5"/>
											<path d="M35.5627 13.4883L33.0314 20.832H30.4168L27.8752 13.4883H30.0627L31.7293 18.7904L33.3856 13.4883H35.5627Z" fill="#5580E7" fill-opacity="0.5"/>
										</svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End - Invoice -->

					<!-- Start - Expense -->
					<div class="col-xl-4">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<span class="text-black">{{ __('solarmitra::solarmitra.debit_expense') }}</span>
										<span class="cursor-pointe text-black">
											<svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Expenses without GST : ?0  GST : ?0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="" style="width:var(--ng-icon__size, 1em);height:var(--ng-icon__size, 1em);stroke-width:var(--ng-icon__stroke-width, 2)"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
										</span>
										<h2 class=" mb-0 text-danger">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($payment_expence_total ?? 0) }}</h2>
									</div>
									<div>
										<svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M36 41C33 41 32.25 38.5 32.25 37.25V23.5M36 41C37.6667 41 41 40.25 41 37.25V23.5H32.25M36 41H7.25C2.25 41 1 36.8333 1 34.75V1L8.5 4.75L16 1L24.75 4.75L32.25 1V23.5M12.25 14.75H21M7.25 23.5H24.75M7.25 32.25H24.75" stroke="#504879" stroke-opacity="0.5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End - Expense -->

					<!-- Start - Margin -->
					<div class="col-xl-4">
						<div class="card">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<span class="text-black">{{ __('solarmitra::solarmitra.credit_income') }}</span>
										<span class="cursor-pointe text-black">
											<svg data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Margin without GST : ?0  GST : ?0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="" style="width:var(--ng-icon__size, 1em);height:var(--ng-icon__size, 1em);stroke-width:var(--ng-icon__stroke-width, 2)"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
										</span>
										<h2 class="mb-0 text-success">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($payment_income_total ?? 0) }}</h2>
									</div>
									<div>
										<svg width="53" height="50" viewBox="0 0 53 50" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M46.25 45.4961H11.25C9.92392 45.4961 8.65215 44.9693 7.71447 44.0316C6.77678 43.0939 6.25 41.8222 6.25 40.4961V17.9961C6.25 16.67 6.77678 15.3982 7.71447 14.4606C8.65215 13.5229 9.92392 12.9961 11.25 12.9961H46.25C47.5761 12.9961 48.8479 13.5229 49.7855 14.4606C50.7232 15.3982 51.25 16.67 51.25 17.9961V40.4961C51.25 41.8222 50.7232 43.0939 49.7855 44.0316C48.8479 44.9693 47.5761 45.4961 46.25 45.4961Z" stroke="#248B00" stroke-opacity="0.5" stroke-width="1.7"/>
											<path d="M40 30.4961C39.6685 30.4961 39.3505 30.3644 39.1161 30.13C38.8817 29.8956 38.75 29.5776 38.75 29.2461C38.75 28.9146 38.8817 28.5966 39.1161 28.3622C39.3505 28.1278 39.6685 27.9961 40 27.9961C40.3315 27.9961 40.6495 28.1278 40.8839 28.3622C41.1183 28.5966 41.25 28.9146 41.25 29.2461C41.25 29.5776 41.1183 29.8956 40.8839 30.13C40.6495 30.3644 40.3315 30.4961 40 30.4961Z" fill="#248B00" fill-opacity="0.5" stroke="#248B00" stroke-opacity="0.5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M43.75 12.9989V9.50642C43.7498 8.74018 43.5735 7.98423 43.2347 7.29696C42.8958 6.6097 42.4036 6.00949 41.796 5.5427C41.1883 5.07591 40.4815 4.75502 39.7301 4.60482C38.9788 4.45462 38.2029 4.47911 37.4625 4.67642L9.9625 12.0089C8.89763 12.2927 7.95635 12.9203 7.28497 13.7942C6.6136 14.6682 6.24976 15.7394 6.25 16.8414V17.9989" stroke="#248B00" stroke-opacity="0.5" stroke-width="1.7"/>
										</svg>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End - Margin -->
					
				</div>
				<div class="row">

					<!-- Start - Table -->
					<div class="col-12">
						<div class="card mb-0 table-hover text-nowrap h-auto">
							<table class="table mb-4" id="example6">
								<thead>
									<tr>
										<th class="mw-200">{{ __('solarmitra::solarmitra.party') }}</th>
										<th class="mw-150 text-center">{{ __('solarmitra::solarmitra.details') }}</th>
										<th class="mw-150 text-end">{{ __('solarmitra::solarmitra.status') }}</th>
										<th class="width50 text-end">{{ __('solarmitra::solarmitra.action') }}</th>
									</tr>	
								</thead>
								<tbody>
								@php
									$i = $transactions->firstItem();
									$transfer_modes = config('solarmitra.transfer_modes');
								@endphp
								@forelse ($transactions as $transaction)
									<tr>
										<td class="d-flex align-items-center gap-2">
											<div class="d-grid">
												<span class=" {{ $transaction->transfer_type === 'dr' ? 'bg-danger' : 'bg-success' }} p-2 pb-0 text-white rounded-top">{{ \Carbon\Carbon::createFromFormat(config('solarmitra.date_time_format'),@$transaction->date)->format('d M') }}</span>
												<span class=" {{ $transaction->transfer_type === 'dr' ? 'bg-danger' : 'bg-success' }}-subtle p-2 pt-1 text-center rounded-bottom">
													
													{!! $transaction->transfer_type === 'dr' ? config('solarmitra.payment-output-svg') : config('solarmitra.payment-input-svg') !!}
													
												</span>
											</div>
											<div class="d-grid">

												<p class="text-black m-0"><strong>Sender:</strong>	{{@$transaction->sender->name}}</p>
												<p class="text-black m-0"><strong>Receiver:</strong>{{@$transaction->receiver->name}}</p>
												<span class="fs-12">{{$transaction->transaction_type->title}} @if ($transaction->reference_type === 'invoice')<a class="link AjaxOffCanvasShow" href="{{ route('business.solarmitra.invoices.show', $transaction->reference_id) }}">Check Invoice</a>@endif</span>

											</div>
										</td>
										<td class="text-center">
											<p class="mb-2">{{$transaction->description}}</p>
										</td>
										<td class="text-end">
											<p class="fs-14 text-black mb-1">{{$transaction->amount}}</p>
											<span class="badge bg-primary text-white">{{@$transfer_modes[$transaction->transfer_mode]}}</span>
										</td>
										<td class="text-center">
											<div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-ellipsis-vertical"></i>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item AjaxOffCanvasShow"  href="{{ route('business.solarmitra.transactions.edit',$transaction->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                    <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.transactions.destroy',$transaction->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                </div>
                                            </div>
										</td>
									</tr>
									
								@empty
									<tr><td class="text-center" colspan="4"><p>{{ __('solarmitra::solarmitra.no_transaction') }}</p></td></tr>
								@endforelse
								</tbody>
							</table>
							@if ($transactions->hasPages())
							<div class="card-footer">
							    {{ $transactions->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination') }}
							</div>
							@endif
						</div>
					</div>
					<!-- End - Table -->
				
				</div>
			

			</div>
			<!-- End - Transaction -->


@endsection


@push('inline-scripts')
<script>
$(document).ready(function () {
});
</script>

@endpush

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
                    <button type="button" class="btn btn-danger rounded-pill px-4 py-1" id="confirmRemoveImageBtn">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End - Remove Image Modal -->   
@endpush