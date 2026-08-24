{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12 mb-3">
                 <form>
                    <div class="row gy-2">
                        <div class="col-xl-2 col-md-3">
                            <input type="text" class="form-control " name="title" value="{{ request('title') }}" placeholder="{{ __('solarmitra::solarmitra.title') }}">
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <select class="selectpicker form-control me-2" name="project_id" data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_project') }}</option>
                                @foreach ($projects as $key => $title)
                                    <option value="{{$key}}" @selected(request('project_id') == $key)>{{$title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <select class="selectpicker form-control me-2" name="client_id" data-live-search="true">
                                <option value="">{{ __('solarmitra::solarmitra.select_client') }}</option>
                                @foreach (SolarMitraHelper::getContactsList('clients') as $key => $status)
                                    <option value="{{$key}}" @selected(request('client_id') == $key)>{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-3">
                            <select class="selectpicker form-control me-2" name="status">
                                <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.status') }}</option>
                                <option value="1" @selected(request('status') == 1)>{{ __('Unpaid') }}</option>
                                <option value="2" @selected(request('status') == 2)>{{ __('Paid') }}</option>
                            </select>
                        </div>
                            
                        <div class="col-xl-4">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.invoices.index') }}" class="btn btn-danger ms-2"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can(['SolarMitra > Business > InvoicesController > create','SolarMitra > Business > InvoicesController > store'])
                            <button class="btn btn-primary ms-2 float-end"  href="{{route('business.solarmitra.invoices.create')}}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">Add Invoice</button>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
            <!-- End - Filtering -->
            
            <!-- Start - Table -->
            <div class="col-xl-12">
                <div class="card table-hover h-auto text-nowrap">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bottom-borderless  rounded m-0 ">
                            <thead>
                                <tr>
                                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.date') }}</th>
                                    <th class="">{{ __('solarmitra::solarmitra.title') }}</th>
                                    <th class="">Est. Amount</th>
                                    <th class="">{{ __('solarmitra::solarmitra.status') }}</th>
                                    <th class="text-center width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td>{{$invoice->invoice_number}}</td>
                                        <td>{{$invoice->date}}</td>
                                        <td >
                                            <strong>{{$invoice->title}}</strong> 
                                            <br>
                                            Quotation : {{$invoice->quotation->title}}
                                            <br>
                                            Client : {{optional($invoice->client)->name}}
                                        </td>
                                        <td >

                                            <strong>Bill Amount : {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($invoice->total_amount)}}</strong><br>
                                            <span class="text-success">Paid : {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($invoice->paid_amount)}}</span><br>
                                            <span class="text-danger">Pending : {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($invoice->due_amount)}}</span>

                                        </td>
                                        <td > <strong class="{{@$invoice->status == 2 ? 'text-success' : 'text-danger'}}">{{ @$invoice->status == 2 ? 'Paid' : 'Unpaid' }}</strong> </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 justify-content-end">
                                                <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                    <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-ellipsis-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('SolarMitra > Business > InvoicesController > show')
                                                        <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.invoices.show', $invoice->id) }}">{{ __('solarmitra::solarmitra.view') }}</a>
                                                        @endcan
                                                        @can(['SolarMitra > Business > InvoicesController > edit','SolarMitra > Business > InvoicesController > update'])
                                                        <a class="dropdown-item " href="{{ route('business.solarmitra.invoices.edit',$invoice->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.edit') }} </a>
                                                        @endcan
                                                        @can(['SolarMitra > Business > QuotationsController > edit','SolarMitra > Business > QuotationsController > update'])
                                                        <a class="dropdown-item confirmEditInvoice" data-alert_title="You are trying to update <br> 'Approved Quotation'?<br>If yes Press 'Ok'" data-alert_text="Remember You need to Approve Quotation After Update" href="{{ route('business.solarmitra.quotations.edit',$invoice->quotation_id) }}">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.items') }}</a>
                                                        @endcan
                                                        @if (auth('business')->user()->can('SolarMitra > Business > InvoicesController > change_to_paid'))
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd" data-alert_text="Confirm to Change this invoice into Paid" href="{{ route('business.solarmitra.invoices.change_to_paid',$invoice->id) }}">{{ __('View Payments') }}</a>
                                                        @endif
                                                        @can('SolarMitra > Business > InvoicesController > share_invoice')
                                                        <a class="dropdown-item" href="{{ route('business.solarmitra.invoices.share_invoice',$invoice->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Invoice') }}</a>
                                                        @endcan
                                                        @can('SolarMitra > Business > InvoicesController > destroy')
                                                        <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.invoices.destroy',$invoice->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no') }} {{ __('solarmitra::solarmitra.invoices') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection
