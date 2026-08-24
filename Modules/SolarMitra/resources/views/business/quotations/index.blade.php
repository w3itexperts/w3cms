{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">
        <div class="row">

            <!-- Start - Filtering -->
            <div class="col-xl-12">
                <form method="get" class="mb-3">
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
                        <div class="col-xl-1 col-md-3">
                            <select class="selectpicker form-control me-2" name="quotation_status_id[]" multiple>
                                <option value="">{{ __('solarmitra::solarmitra.all') }}</option>
                                @foreach (config('solarmitra.quotations_status') as $key => $value)
                                    <option value="{{$key}}" @selected(in_array($key, request('quotation_status_id',[]))) >{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-4">
                            <select name="sort_by" class="form-bsselect-sm selectpicker ">
                                <option value="">-- Sort by --</option>
                                <option value="title_asc" @selected('title_asc' == request('sort_by')) >Title Asc</option>
                                <option value="title_desc" @selected('title_desc' == request('sort_by'))>Title Desc</option>
                                <option value="created_asc" @selected('created_asc' == request('sort_by'))>Created Asc</option>
                                <option value="created_desc" @selected('created_desc' == request('sort_by'))>Created Desc</option>
                                <option value="modified_asc" @selected('modified_asc' == request('sort_by'))>Modified Asc</option>
                                <option value="modified_desc" @selected('modified_desc' == request('sort_by'))>Modified Desc</option>
                            </select>
                        </div>
                            
                        <div class="col-xl-3">
                            <button type="submit" class="btn btn-primary"  >{{ __('solarmitra::solarmitra.submit') }}</button>
                            <a href="{{ route('business.solarmitra.quotations.index') }}" class="btn btn-danger"  >{{ __('solarmitra::solarmitra.reset') }}</a>
                            @can(['SolarMitra > Business > QuotationsController > create','SolarMitra > Business > QuotationsController > store'])
                            <a href="{{route('business.solarmitra.quotations.create')}}" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.quotation') }}</a>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
            <!-- End - Filtering -->
            
            <!-- Start - Table -->
            <div class="col-xl-12">
                <ul class="nav nav-underline gap-3 nav-scroll nav-scroll-auto-xl mb-3 px-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="AllQuotations" data-bs-toggle="tab" data-bs-target="#AllQuotations-pane" type="button" role="tab" aria-controls="AllQuotations-pane" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Drafted" data-bs-toggle="tab" data-bs-target="#Drafted-pane" type="button" role="tab" aria-controls="Drafted-pane" aria-selected="false">Drafted</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Sent" data-bs-toggle="tab" data-bs-target="#Sent-pane" type="button" role="tab" aria-controls="Sent-pane" aria-selected="false">Sent</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="InDiscussion" data-bs-toggle="tab" data-bs-target="#InDiscussion-pane" type="button" role="tab" aria-controls="InDiscussion-pane" aria-selected="false">In Discussion</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="OnHold" data-bs-toggle="tab" data-bs-target="#OnHold-pane" type="button" role="tab" aria-controls="OnHold-pane" aria-selected="false">On Hold</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ClientConfirmed" data-bs-toggle="tab" data-bs-target="#ClientConfirmed-pane" type="button" role="tab" aria-controls="ClientConfirmed-pane" aria-selected="false">Client Confirmed</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Rejected" data-bs-toggle="tab" data-bs-target="#Rejected-pane" type="button" role="tab" aria-controls="Rejected-pane" aria-selected="false">Rejected</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="AllQuotations-pane" role="tabpanel" aria-labelledby="AllQuotations" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-bottom-borderless  rounded m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">
                                                    {{$quotation->title}}
                                                    <br>
                                                    @if (optional($quotation->status)->slug === 'draft')
                                                        <span class="badge text-bg-primary">Waiting for Send Quotationing</span>
                                                    @elseif (optional($quotation->status)->slug === 'sent')
                                                        <span class="badge text-bg-primary">Quotation Sent, Waiting for Approval</span>
                                                    @endif
                                                </td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($quotations && $quotations->hasPages())
                            <div class="card-footer">
                                {{ $quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Drafted-pane" role="tabpanel" aria-labelledby="Drafted" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($draft_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($draft_quotations && $draft_quotations->hasPages())
                            <div class="card-footer">
                                {{ $draft_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Sent-pane" role="tabpanel" aria-labelledby="Sent" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sent_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($sent_quotations && $sent_quotations->hasPages())
                            <div class="card-footer">
                                {{ $sent_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="InDiscussion-pane" role="tabpanel" aria-labelledby="InDiscussion" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inDiscussion_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($inDiscussion_quotations && $inDiscussion_quotations->hasPages())
                            <div class="card-footer">
                                {{ $inDiscussion_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="OnHold-pane" role="tabpanel" aria-labelledby="OnHold" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($onHold_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($onHold_quotations && $onHold_quotations->hasPages())
                            <div class="card-footer">
                                {{ $onHold_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ClientConfirmed-pane" role="tabpanel" aria-labelledby="ClientConfirmed" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clientConfirmed_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($clientConfirmed_quotations && $clientConfirmed_quotations->hasPages())
                            <div class="card-footer">
                                {{ $clientConfirmed_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Rejected-pane" role="tabpanel" aria-labelledby="Rejected" tabindex="0">
                        <div class="card table-hover h-auto text-nowrap">
                            <div class="card-body p-0 table-responsive">
                                <table class="table m-0 quotation-tbl">
                                    <thead>
                                        <tr>
                                            <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                                            <th class="width220">{{ __('solarmitra::solarmitra.date') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.subject') }}</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.client') }}</th>
                                            <th class=" width200">Est. Amount</th>
                                            <th class=" width200">{{ __('solarmitra::solarmitra.status') }}</th>
                                            <th class=" width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($rejected_quotations as $quotation)
                                            <tr class="pointer {{Str::slug(config('solarmitra.quotations_status.'.@$quotation->quotation_status_id))}}">
                                                <td>{{$quotation->quotation_number}}</td>
                                                <td>{{$quotation->date}}</td>
                                                <td class="">{{$quotation->title}}</td>
                                                <td class="">{{optional(@$quotation->client)->name}}</td>
                                                <td class="">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}}{{SolarMitraHelper::format_number($quotation->total_amount)}}</td>
                                                <td>{{config('solarmitra.quotations_status.'.@$quotation->quotation_status_id)}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                            <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="icon-ellipsis-vertical"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > edit') && auth('business')->user()->can('SolarMitra > Business > QuotationsController > update'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.edit',$quotation->id) }}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                                @endif
                                                                @if (!in_array(optional($quotation->status)->slug, ['confirmed']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > confirm_quotation'))
                                                                    <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.confirm_quotation',$quotation->id) }}">{{ __('Confirm Quotation') }}</a>
                                                                @endif
                                                                @can('SolarMitra > Business > QuotationsController > show')
                                                                <a class="dropdown-item AjaxOffCanvasShow" href="{{ route('business.solarmitra.quotations.show',$quotation->id) }}" >{{ __('solarmitra::solarmitra.view') }}</a>
                                                                @endcan
                                                                @can('SolarMitra > Business > QuotationsController > share_quotation')
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.share_quotation',$quotation->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Quotation') }}</a>
                                                                @endcan
                                                                @if (optional($quotation->status)->can_convert && !$quotation->invoice_generated && auth('business')->user()->can('SolarMitra > Business > QuotationsController > convert_to_invoice'))
                                                                <a class="dropdown-item" href="{{ route('business.solarmitra.quotations.convert_to_invoice',$quotation->id) }}">{{ __('Convert To Invoice') }}</a>
                                                                @endif
                                                                @if (in_array(optional($quotation->status)->slug, ['draft','rejected']) && auth('business')->user()->can('SolarMitra > Business > QuotationsController > destroy'))
                                                                <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.quotations.destroy',$quotation->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('solarmitra::solarmitra.no_quotations') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($rejected_quotations && $rejected_quotations->hasPages())
                            <div class="card-footer">
                                {{ $rejected_quotations->onEachSide(1)->appends(request()->all())->links('admin.elements.pagination')}}
                            </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- End - Table -->

        </div>
    </div>

@endsection

@push('inline-scripts')
    <script>
        jQuery(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation(); 
        });
    </script>
@endpush