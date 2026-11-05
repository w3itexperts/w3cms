{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')
{{-- Content --}}
@section('content')
<!-- Start - Project Details -->
<div class="col-xl-12">
   <div class="card border-0 border-bottom rounded-0 mb-2">
      <div class="card-body">
         <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
            <div class="d-flex gap-3">
               <div class="avatar border-0 avatar-primary rounded">
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M4.66674 16.3331C4.44596 16.3339 4.22951 16.272 4.04252 16.1546C3.85553 16.0372 3.70568 15.8692 3.61038 15.6701C3.51508 15.4709 3.47825 15.2488 3.50416 15.0296C3.53006 14.8103 3.61765 14.6029 3.75674 14.4315L15.3067 2.53145C15.3934 2.43144 15.5114 2.36387 15.6416 2.3398C15.7717 2.31574 15.9061 2.33663 16.0228 2.39904C16.1394 2.46144 16.2314 2.56166 16.2836 2.68324C16.3358 2.80482 16.3452 2.94054 16.3101 3.06812L14.0701 10.0915C14.004 10.2682 13.9818 10.4584 14.0054 10.6456C14.029 10.8329 14.0977 11.0116 14.2055 11.1664C14.3133 11.3213 14.4571 11.4477 14.6246 11.5348C14.792 11.6219 14.978 11.6671 15.1667 11.6665H23.3334C23.5542 11.6657 23.7706 11.7276 23.9576 11.845C24.1446 11.9623 24.2945 12.1304 24.3898 12.3295C24.4851 12.5287 24.5219 12.7508 24.496 12.97C24.4701 13.1893 24.3825 13.3967 24.2434 13.5681L12.6934 25.4681C12.6068 25.5681 12.4887 25.6357 12.3586 25.6598C12.2285 25.6838 12.0941 25.6629 11.9774 25.6005C11.8607 25.5381 11.7687 25.4379 11.7165 25.3163C11.6643 25.1947 11.655 25.059 11.6901 24.9315L13.9301 17.9081C13.9961 17.7313 14.0183 17.5412 13.9947 17.3539C13.9711 17.1667 13.9025 16.988 13.7946 16.8331C13.6868 16.6783 13.543 16.5519 13.3756 16.4648C13.2082 16.3777 13.0221 16.3325 12.8334 16.3331H4.66674Z" stroke="var(--bs-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </div>
               <div class="d-flex gap-1 flex-column">
                  <h2 class="fs-18 fw-semibold m-0">{{ $project->title }}</h2>
                  <div class="d-flex flex-wrap gap-3 align-items-center">
                     <span class="fs-13">Project ID: {{ $project->id }}</span>
                     |
                     <span class="fs-13">Capacity: {{ $project->capacity }}</span>
                     <span class="badge text-bg-primary">{{ $project->project_type }}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card-footer py-2">
         <div class="d-flex flex-wrap gap-3 justify-content-between">
            
            <!-- Project Overview -->
            <div class="d-flex flex-wrap gap-3 align-items-center">
               <!-- Client Name -->
               <div class="d-flex align-items-center gap-2">
                  <i class="icon-circle-user-round fs-24 text-primary"></i>
                  <div>
                     <span class="fs-12 lh-sm">{{ __('solarmitra::solarmitra.client_name') }}</span>
                     <p class="m-0 fs-13 text-black lh-sm">{{ $project->client->name ?? 'N/A' }}</p>
                  </div>
               </div>
               <span class="fs-16 d-none d-sm-block">|</span>
               <!-- Location -->
               <div class="d-flex align-items-center gap-2">
                  <i class="icon-map-pin fs-24 text-primary"></i>
                  <div>
                     <span class="fs-12 lh-sm">{{ __('solarmitra::solarmitra.location') }}</span>
                     <p class="m-0 fs-13 text-black lh-sm">{{ $project->location ?? 'N/A' }}</p>
                  </div>
               </div>
               <span class="fs-16 d-none d-sm-block">|</span>
               <!-- Assigned to -->
               <div class="d-flex align-items-center gap-2">
                  <i class="icon-contact-round fs-24 text-primary"></i>
                  <div>
                     <span class="fs-12 lh-sm">{{ __('solarmitra::solarmitra.assigned_to') }}</span>
                     <p class="m-0 fs-13 text-black lh-sm">{{ $project->project_member->name ?? 'N/A' }}</p>
                  </div>
               </div>
            </div>
            <!-- Project Dates -->
            <div class="d-flex flex-wrap gap-3 align-items-center">
               <p class="m-0 fs-14 text-black lh-sm"><span class="text-primary">Start Date: </span>{{ $project->start_date ? $project->start_date : '' }}</p>
               <span class="d-sm-block d-none">|</span>
               <p class="m-0 fs-14 text-black lh-sm"><span class="text-primary">End Date: </span>{{ $project->end_date ? $project->end_date : '' }}</p>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End - Project Details -->
<!-- Start - Project Tabs -->
<ul class="nav nav-underline project-nav border-bottom" id="nav-tab" role="tablist">
   <li class="nav-item" role="presentation">
      <button class="nav-link active" id="underline-overview-tab" data-bs-toggle="tab" data-bs-target="#underline-overview" type="button" role="tab" aria-controls="underline-overview" aria-selected="true">Overview</button>
   </li>
   <li class="nav-item" role="presentation">
      <button class="nav-link " {{$project->status == config('solarmitra.projects_status_keys.Draft') ? 'disabled' : ''}}  id="underline-financials-tab" data-bs-toggle="tab" data-bs-target="#underline-financials" type="button" role="tab" aria-controls="underline-financials" aria-selected="false" tabindex="-1">Financials @if($project->status == config('solarmitra.projects_status_keys.Draft')) <i class="icon d-inline-block icon-lock fs-10 ms-1"></i> @endif</button>
   </li>
   <li class="nav-item" role="presentation">
      <button class="nav-link" id="underline-activity-tab" data-bs-toggle="tab" data-bs-target="#underline-activity" type="button" role="tab" aria-controls="underline-activity" aria-selected="false" tabindex="-1">{{ __('solarmitra::solarmitra.activity') }}</button>
   </li>
</ul>
<!-- End - Project Tabs -->
<div class="container-fluid">
   <div class="tab-content" id="underline-tabContent">
      <!-- Start - Overview Tab -->
      <div class="tab-pane fade show active" id="underline-overview" role="tabpanel" aria-labelledby="underline-overview-tab" tabindex="0">
         <div class="row">
           
            <div class="col-xl-12" id="ProjectInfoBox">
               @include('solarmitra::business.elements.projects.form2')
            </div>
          
            
            <!-- Start - Project Timeline Info -->
            <div class="col-xl-2 order-xl-2 project-timeline-info">
               <div class="row sticky-top z-0">
                  <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                           <h3 class="fs-15 fw-medium align-items-center m-0">{{ __('solarmitra::solarmitra.project_info') }}</h3>
                        </div>
                        <div class="card-body">
                           <div class="mb-2 bg-danger p-3 pb-2 rounded d-flex justify-content-between">
                              <div class="d-flex flex-column gap-2">
                                 <span class="text-white fs-14 fw-semibold">{{ __('solarmitra::solarmitra.payment_overdue') }}</span>
                                 <p class="m-0 fs-24 fw-bold text-white">{{ SolarMitraHelper::getBusinessConfig('currency_symbol', '₹') . SolarMitraHelper::format_number($payment_overdue ?? 0) }}</p>
                              </div>
                              <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M25.3518 20.9996L16.0185 4.66628C15.815 4.30718 15.5199 4.0085 15.1632 3.80069C14.8066 3.59289 14.4012 3.4834 13.9885 3.4834C13.5757 3.4834 13.1704 3.59289 12.8138 3.80069C12.4571 4.0085 12.162 4.30718 11.9585 4.66628L2.62516 20.9996C2.41946 21.3559 2.31159 21.7602 2.31251 22.1715C2.31342 22.5829 2.42307 22.9867 2.63035 23.3421C2.83763 23.6974 3.13517 23.9916 3.49281 24.1949C3.85045 24.3982 4.25547 24.5033 4.66683 24.4996H23.3335C23.7429 24.4992 24.1449 24.3911 24.4993 24.1861C24.8537 23.9811 25.1479 23.6865 25.3524 23.3319C25.5569 22.9773 25.6645 22.5751 25.6644 22.1657C25.6643 21.7563 25.5565 21.3541 25.3518 20.9996Z" fill="#FAE62E" stroke="#FAE62E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M14 10.5V15.1667" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M14 19.833H14.01" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </div>
                           <div class="mb-3 bg-success p-3 pb-2 rounded d-flex justify-content-between">
                              <div class="d-flex flex-column gap-2">
                                 <span class="text-white fs-14 fw-semibold">{{ __('solarmitra::solarmitra.timeline') }}</span>
                                 <p class="m-0 fs-24 fw-bold text-white">{{ $project_timeline ?? 0 }} Day</p>
                              </div>
                              <i class="icon-clock-9 fs-28 text-white"></i>
                           </div>
                           @can('SolarMitra > Business > ProjectsController > save_project_phase')
                           <form action="{{ route('business.solarmitra.projects.save_project_phase',$project->id) }}" method="post" id="ProjectPhasesForm">
                              @csrf
                              <ul class="list-group list-group-flush mb-3">
                                 @forelse ($project_phases as $phaseId => $phaseTitle)
                                    <li class="list-group-item px-0 d-flex justify-content-between">
                                       <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="project_phases[]" id="project_phases_{{$phaseId}}" value="{{$phaseId}}" @checked($project->phases->contains($phaseId))>
                                          <label class="form-check-label" for="project_phases_{{$phaseId}}">{{$phaseTitle}} <i class="icon-info"></i></label>
                                       </div>
                                    </li>
                                 @empty
                                 @endforelse
                              </ul>
                              <button type="submit" class="btn btn-primary fw-bold w-100">{{ __('solarmitra::solarmitra.save') }}</button>
                           </form>
                           @endcan
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End - Project Timeline Info -->
            <!-- Start - Project Status Wizard -->
            <div class="col-xl-10 order-xl-1">
            @canany([
               'SolarMitra > Business > ProjectsController > documents',
               'SolarMitra > Business > ProjectsController > verification',
               'SolarMitra > Business > ProjectsController > subsidy',
               'SolarMitra > Business > ProjectsController > structure',
               'SolarMitra > Business > ProjectsController > netmeter',
               'SolarMitra > Business > ProjectsController > handover'
            ])
               <div class="row">
                  <div class="col-12" id="DocumentWizard">
                     @include('solarmitra::business.elements.projects.document-wizard')
                  </div>
               </div>
            @endcanany
            </div>
            <!-- End - Project Status Wizard -->
         </div>
      </div>
      <!-- End - Overview Tab -->
      <!-- Start - Financials Tab -->
      <div class="tab-pane fade" id="underline-financials" role="tabpanel" aria-labelledby="underline-financials-tab" tabindex="0">
         <div class="row">
            
            <!-- Start - Transaction Table -->
            <div class="col-xl-6">
               <div class="card">
                  <div class="card-header align-items-center">
                     <div class="d-flex align-items-center gap-2">
                        <i class="icon-badge-indian-rupee text-primary fs-20"></i>
                        <h3 class="fs-15 fw-medium m-0">{{ __('solarmitra::solarmitra.transactions') }}</h3>
                     </div>
                     <div class="d-flex gap-2">
                        <a href="{{ route('business.solarmitra.transactions.create',['project_id' => $project->id,'type'=> 'income']) }}" class="btn btn-sm btn-success AjaxOffCanvasShow">
                           <i class="icon-arrow-down-from-line me-1"></i> Payment In
                        </a>
                        <a href="{{ route('business.solarmitra.transactions.create',['project_id' => $project->id,'type'=> 'expense']) }}" class="btn btn-sm btn-danger AjaxOffCanvasShow">
                           <i class="icon-arrow-up-from-line me-1"></i> Payment Out
                        </a>
                     </div>
                  </div>
                  <div class="card-body pt-0 mx-h410 overflow-auto">

                     <table class="table transaction-table table-borderless m-0">
                        <thead>
                           <tr>
                              <th>{{ __('solarmitra::solarmitra.date') }}</th>
                              <th>{{ __('solarmitra::solarmitra.type') }}</th>
                              <th>{{ __('solarmitra::solarmitra.description') }}</th>
                              <th class="text-end">{{ __('solarmitra::solarmitra.amount') }}</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse ($project_transactions as $transaction)
                           <tr>
                              <td class="text-muted fs-13">{{ $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('d M Y') : '' }}</td>
                              <td>
                                 @if($transaction->transfer_type == 'cr')
                                    <span class="badge text-bg-success-subtle text-success border border-success-subtle">
                                       <i class="icon-arrow-down-from-line fs-10 me-1"></i> {{$transaction->transaction_type->title}}
                                    </span>
                                 @else
                                    <span class="badge text-bg-danger-subtle text-danger border border-danger-subtle">
                                       <i class="icon-arrow-up-from-line fs-10 me-1"></i> {{$transaction->transaction_type->title}}
                                    </span>
                                 @endif
                              </td>
                              <td>
                                 <p class="m-0 fs-13 text-black">{{ $transaction->description ?: '-' }}</p>
                                 @if($transaction->reference_type === 'invoice' && $transaction->reference_id)
                                    <a class="link AjaxOffCanvasShow" href="{{ route('business.solarmitra.invoices.show', $transaction->reference_id) }}">Check Invoice</a>
                                 @endif
                              </td>

                              <td class="{{ $transaction->transfer_type == 'cr' ? 'text-success' : 'text-danger' }} text-end fw-semibold">
                                 {{ $transaction->transfer_type == 'cr' ? '+' : '-' }} {{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}} {{ SolarMitraHelper::format_number($transaction->amount) }}
                              </td>
                           </tr>
                           @empty
                           <tr>
                              <td colspan="5" class="text-center text-muted py-4">
                                 <i class="icon-badge-indian-rupee fs-30 d-block mb-2"></i>
                                 No transactions found.
                              </td>
                           </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <!-- End - Transaction Table -->
            <!-- Start - Invoice Table -->
            <div class="col-xl-6">
               <div class="card">
                  <div class="card-header align-items-center">
                     <div class="d-flex align-items-center gap-2">
                        <i class="icon-receipt-text text-primary fs-20"></i>
                        <h3 class="fs-15 fw-medium m-0">{{ __('solarmitra::solarmitra.invoice') }}</h3>
                     </div>
                  </div>
               <div class="card-body table-responsive check-wrapper">
                     <table class="table  overflow-visible" id="invoiceTable">
                        <thead>
                           <tr>
                              <th class="sorting-disabled width10 text-center">#</th>
                              <th class="sorting-disabled mw-80">Invoice No.</th>
                              <th class="sorting-disabled mw-80">{{ __('solarmitra::solarmitra.date') }}</th>
                              <th class="sorting-disabled mw-80">Amount ({{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}})</th>
                              <th class="sorting-disabled mw-50">{{ __('solarmitra::solarmitra.status') }}</th>
                              <th class="sorting-disabled width50">{{ __('solarmitra::solarmitra.action') }}</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse ($project_invoices as $invoice)
                           <tr>
                              <td class="text-center">{{ $loop->iteration }}</td>
                              <td class="text-primary">{{ $invoice->invoice_number }}</td>
                              <td class="text-muted">{{ $invoice->date ? $invoice->date : '' }}</td>
                              <td class="text-muted">{{SolarMitraHelper::getBusinessConfig('currency_symbol', '₹')}} {{ SolarMitraHelper::format_number($invoice->amount) }}</td>
                              <td>
                                 @if($invoice->status == '2')
                                 <span class="badge badge-sm text-bg-success">{{ __('solarmitra::solarmitra.paid') }}</span>
                                 @elseif($invoice->status == '1')
                                 <span class="badge badge-sm text-bg-danger">{{ __('solarmitra::solarmitra.unpaid') }}</span>
                                 @endif
                              </td>
                              <td>
                                 <div class="dropdown">
                                    <button class="btn btn-sm btn-square border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-ellipsis"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                       <a class="dropdown-item confirmEditInvoice" data-alert_title="You are trying to update <br> 'Approved Quotation'?<br>If yes Press 'Ok'" data-alert_text="Remember You need to Approve Quotation After Update" href="{{ route('business.solarmitra.quotations.edit',$invoice->quotation_id) }}">{{ __('solarmitra::solarmitra.edit') }} {{ __('solarmitra::solarmitra.items') }}</a>
                                       <a class="dropdown-item" href="{{ route('business.solarmitra.invoices.share_invoice',$invoice->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxMd">{{ __('Share Invoice') }}</a>
                                       <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.invoices.destroy',$invoice->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           @empty
                           <tr>
                              <td colspan="6" class="text-center text-muted py-4">No invoices found.</td>
                           </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <!-- End - Invoice Table -->
         </div>
      </div>
      <!-- End - Financials Tab -->
      <!-- Start - Activity Tab -->
      <div class="tab-pane fade" id="underline-activity" role="tabpanel" aria-labelledby="underline-activity-tab" tabindex="0">
         
         <!-- Activity Timeline -->
         <div class="col-xl-12">
            <div class="card">
               <div class="card-header">
                  <div class="d-flex align-items-center gap-2">
                     <i class="icon-square-activity text-primary fs-20"></i>
                     <h3 class="fs-15 fw-medium align-items-center m-0">{{ __('solarmitra::solarmitra.project_activity') }}</h3>
                  </div>
               </div>
               <div class="card-body overflow-auto vh-75">
                  @if ($project->change_note)

                  @php
                     $changes = collect(preg_split('/\r\n|\r|\n/', trim($project->change_note)))
                               ->filter()
                               ->map(function ($line) {
                                   preg_match('/^\[(.*?)\]\s+(.*)$/', $line, $matches);

                                   $date = $matches[1] ?? null;
                                   $message = $matches[2] ?? '';

                                   $name = null;
                                   $text = $message;

                                   if (preg_match('/^(.*?)\s+By\s+(.+)$/i', $message, $parts)) {
                                       $text = trim($parts[1]);
                                       $name = trim($parts[2]);
                                   }

                                   return [
                                       'name' => $name,
                                       'date' => $date,
                                       'text' => $text,
                                   ];
                               })
                               ->values()
                               ->toArray();
                  @endphp  

                  <div class="project-activity-timeline">
                     <ul class="timeline">
                        @forelse ($changes as $change)
                        <li>
                           <div class="timeline-status">
                              <span class="text-primary fs-14">{{ $change['date'] ? \Carbon\Carbon::parse($change['date'])->format('d F Y') : ''}}</span>
                              <span class="fs-12">{{ $change['date'] ? \Carbon\Carbon::parse($change['date'])->format('h:i A') : ''}}</span>
                           </div>
                           <div class="timeline-badge border-dark"></div>
                           <div class="timeline-panel">
                              <div class="max-w850 border rounded px-2 py-3 d-flex gap-2">
                                 <div class="avatar bg-dark rounded-pill">
                                    <i class="icon-user text-white"></i>
                                 </div>
                                 <div>
                                    <p class="fs-13 mb-2 fw-bold">{{$change['name'] ?? ''}}</p>
                                    <p class="m-0">{{$change['text'] ?? ''}}</p>
                                 </div>
                              </div>
                           </div>
                        </li>
                        @empty
                        @endforelse
                     </ul>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
      <!-- End - Activity Tab -->
   </div>
</div>
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
                    <button type="button" class="btn btn-danger rounded-pill px-4 py-1" id="confirmRemoveImageBtn">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End - Remove Image Modal -->   
@endpush
