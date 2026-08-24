{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')
             
			<!-- Start - Transaction -->
			<div class="container-fluid">
                <div class="row">

                    <!-- Start - Filtering -->
                    <div class="col-xl-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="clearfix me-2 d-flex align-items-center">
                                <select class="form-control selectpicker me-2">
                                    <option selected>Chandan</option>
                                    <option>Kuldeep</option>
                                    <option>Yatin</option>
                                </select>
                                <a href="javascript:void(0);" class="btn btn-outline-primary w-50 me-2">+ Add BOQ</a>
                                <div class="input-group message-search-area me-2">
                                    <input type="text" class="form-control border-end-0" placeholder="Search Party">
                                    <div class="input-group-append">
                                        <button class="input-group-text rounded-0 rounded-end border-start-0 bg-white"><i class="flaticon-381-search-2"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-4 me-4">
                                <a href="javascript:void(0);"><i class="icon icon-download fs-22"></i></a>
                                <a href="javascript:void(0);"><i class="icon icon-pencil fs-22"></i></a>
                                <a href="javascript:void(0);"><i class="icon icon-trash-2 fs-22"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- End - Filtering -->

                    <!-- Start - Table -->
                    <div class="col-xl-12">
						<div class="card table-hover text-nowrap">
							<table class="table mb-0" id="example6">
								<thead>
									<tr>
										<th class="width20">{{ __('solarmitra::solarmitra.s_no') }}</th>
										<th class="width960">Items</th>
										<th class="text-end">OTY</th>
										<th class="text-end">Unit Rate (?)</th>
										<th class="text-end">Sales Price (?)</th>
                                    </tr>
                                </thead>
                                <tbody>
									<tr>
										<td>1</td>
										<td>Test</td>
										<td class="text-end">20</td>
										<td class="text-end">2000</td>
										<td class="text-end">3500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End - Table -->

                    <!-- Start - Bank Details -->
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xl-6 border-end">
                                    <div class="card-body">
                                        <div class="mb-5">
                                            <h6 class="card-title border-bottom py-2 mb-3">{{ __('solarmitra::solarmitra.bank_details') }}</h6>
                                            <p class="mb-2">Account Holder Name : <span>Chandan</Span></p>
                                            <p class="mb-2">Account Number : <span>143XXXXXX456</Span></p>
                                            <p class="mb-2">Bank Code : <span>2389542</Span></p>
                                        </div>
                                        <div class="mb-5">
                                            <h6 class="card-title border-bottom py-2 mb-3">{{ __('solarmitra::solarmitra.terms_and_conditions') }}</h6>
                                            <p class="m-0">Late payments may result in late payment fees. Please reach out to us in case of any Invoice errors. All disputes are subject to India jurisdiction only</p>
                                        </div>
                                        <div>
                                            <h6 class="card-title border-bottom py-2 mb-3">{{ __('solarmitra::solarmitra.note') }}</h6>
                                        </div>
                                        <div>
                                            <h6 class="card-title border-bottom py-2 mb-3">NA</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 p-0">
                                    <div class="card-body d-flex flex-column h-100">
                                        <div class="border-bottom">
                                            <div>
                                                <p class="d-flex justify-content-between mb-2">Item Sub Total <span class="">?200</span></p>
                                                <p class="d-flex justify-content-between mb-2">CGST <span class="">?18</span></p>
                                                <p class="d-flex justify-content-between mb-2">SGST <span class="">?17</span></p>
                                            </div>
                                            <div class="d-flex justify-content-between my-4">
                                                <a href="javascript:void(0);" class="text-gray">Additional Discount (%)</a>
                                                <input type="number" class="form-control width200" placeholder="0">
                                            </div>
                                            <div class="d-flex justify-content-between my-4">
                                                <a href="javascript:void(0);" class="text-gray">{{ __('solarmitra::solarmitra.additional_charges') }}</a>
                                                <input type="number" class="form-control width200" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-auto">
                                            <p class="mb-0">Total Amount</p>
                                            <span>?235</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Bank Details -->

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body d-flex row">
                                <div class="col-xl-4 border-end">
                                    <p class="m-0 text-center text-black">Cost Price: ? 0</p>
                                </div>
                                <div class="col-xl-4 border-end">
                                    <p class="m-0 text-center text-black">Markup: ? 0</p>
                                </div>
                                <div class="col-xl-4">
                                    <p class="m-0 text-center text-black">Total Amount: ? 0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<!-- End - Transaction -->


@endsection



