{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-xl-7">
            <div class="row">

                <!-- Start - Lead Profile -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-md-0 mb-2">
                                <div class="d-flex gap-2">
                                    <div class="avatar avatar-lg border-0">
                                        <svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle opacity="0.2" cx="35" cy="35" r="35" fill="#0176D3"/>
                                            <g clip-path="url(#clip0_2144_914)">
                                                <path d="M34.9997 34.9996C41.0135 34.9996 45.8886 30.1245 45.8886 24.1107C45.8886 18.0969 41.0135 13.2218 34.9997 13.2218C28.986 13.2218 24.1108 18.0969 24.1108 24.1107C24.1108 30.1245 28.986 34.9996 34.9997 34.9996Z" fill="#0176D3"/>
                                                <path d="M34.9998 38.6293C25.9833 38.6393 18.6765 45.9461 18.6665 54.9626C18.6665 55.9649 19.479 56.7774 20.4813 56.7774H49.5183C50.5206 56.7774 51.3331 55.9649 51.3331 54.9626C51.3231 45.9461 44.0164 38.6392 34.9998 38.6293Z" fill="#0176D3"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_2144_914">
                                                    <rect width="43.5556" height="43.5556" fill="white" transform="translate(13.2222 13.2218)"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                        <h5 class="fs-18 fw-medium m-0">{{$lead->full_name}}</h5>
                                        <p class="m-0 fs-13">{{$lead->phone}} </p>
                                        <a class="fs-13 text-primary">{!! $lead->email !!} <i class="icon-external-link"></i></a>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('business.solarmitra.leads.edit',$lead->id) }}" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxXl" class="btn btn-sm btn-square rounded-pill btn-primary light"><i class="icon-pencil"></i></a>
                                    <div>
                                        <button class="btn btn-sm btn-square rounded-pill btn-primary light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="icon-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">View Profile Photo</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Share Lead Info</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Move</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Clone</a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0);">{{ __('solarmitra::solarmitra.delete') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <p class="mb-2 mb-md-0 fs-13">Added by {{optional($lead->added_by_user)->full_name}} on {{$lead->created_at}} via {{optional($lead->source)->name}}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-square btn-primary light border-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{$lead->phone}}">
                                        <i class="icon-phone"></i>
                                    </button>
                                    <button class="btn btn-square btn-success light border-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{$lead->phone}}">
                                        <i class="icon-message-circle-more"></i>
                                    </button>
                                    <button class="btn btn-square btn-info light border-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{$lead->phone}}">
                                        <i class="icon-message-square"></i>
                                    </button>
                                    <button class="btn btn-square btn-danger light border-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="{{$lead->email}}">
                                        <i class="icon-mail"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-underline border-bottom gap-3" id="nav-tab" role="tablist">
                            <li class="nav-item ps-3" role="presentation">
                                <button class="nav-link px-0 fw-medium border-3 active" id="underline-profile-tab" data-bs-toggle="tab" data-bs-target="#underline-profile" type="button" role="tab" aria-controls="underline-profile" aria-selected="true">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-0 fw-medium border-3" id="underline-info-tab" data-bs-toggle="tab" data-bs-target="#underline-info" type="button" role="tab" aria-controls="underline-info" aria-selected="false" tabindex="-1">Info +</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-0 fw-medium border-3" id="underline-leads-tab" data-bs-toggle="tab" data-bs-target="#underline-leads" type="button" role="tab" aria-controls="underline-leads" aria-selected="false" tabindex="-1">Related Leads</button>
                            </li>
                        </ul>
                        <div class="tab-content p-3" id="underline-tabContent">
                            <div class="tab-pane fade active show" id="underline-profile" role="tabpanel" aria-labelledby="underline-profile-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <a class="d-flex align-items-center gap-2 mb-2">
                                            <i class="icon-mail text-primary fs-16"></i>
                                            <p class="m-0 text-body">{{$lead->email}}</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <a class="d-flex align-items-center gap-2 mb-2">
                                            <i class="icon-phone text-primary fs-16"></i>
                                            <p class="m-0 text-body">{{$lead->phone}}</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <a class="d-flex align-items-center gap-2 mb-2">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_2151_1201)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3475 2.616C13.663 0.93 11.4235 0.00075 9.03772 0C4.12147 0 0.120219 4.0005 0.117969 8.919C0.117219 10.491 0.528219 12.0255 1.30897 13.3785L0.0429688 18L4.77097 16.7595C6.07372 17.4705 7.54072 17.8448 9.03322 17.8455H9.03697C13.9525 17.8455 17.9545 13.8443 17.9567 8.92575C17.9582 6.543 17.0312 4.30125 15.3475 2.616ZM9.03772 16.3387H9.03472C7.70422 16.3387 6.39997 15.981 5.26147 15.3052L4.99072 15.1448L2.18497 15.8805L2.93422 13.1445L2.75797 12.864C2.01547 11.6835 1.62397 10.3193 1.62472 8.919C1.62622 4.8315 4.95247 1.506 9.04147 1.506C11.0215 1.506 12.883 2.2785 14.2825 3.6795C15.682 5.08125 16.4522 6.9435 16.4515 8.92425C16.4492 13.0133 13.1237 16.3387 9.03772 16.3387ZM13.1042 10.7865C12.8815 10.6747 11.7857 10.1355 11.581 10.0612C11.377 9.987 11.2285 9.9495 11.0792 10.1722C10.93 10.395 10.504 10.8975 10.3735 11.0468C10.2437 11.1953 10.1132 11.214 9.89047 11.1023C9.66772 10.9905 8.94922 10.7558 8.09797 9.996C7.43572 9.405 6.98797 8.67525 6.85822 8.45175C6.72847 8.22825 6.84472 8.10825 6.95572 7.99725C7.05622 7.8975 7.17847 7.737 7.29022 7.6065C7.40272 7.4775 7.43947 7.3845 7.51447 7.23525C7.58872 7.08675 7.55197 6.95625 7.49572 6.8445C7.43947 6.7335 6.99397 5.63625 6.80872 5.19C6.62797 4.755 6.44422 4.81425 6.30697 4.8075C6.17722 4.80075 6.02872 4.8 5.87947 4.8C5.73097 4.8 5.48947 4.8555 5.28547 5.079C5.08147 5.3025 4.50547 5.84175 4.50547 6.93825C4.50547 8.0355 5.30422 9.09525 5.41522 9.24375C5.52622 9.39225 6.98647 11.6438 9.22222 12.609C9.75397 12.8385 10.1695 12.9757 10.4927 13.0785C11.0267 13.248 11.5127 13.224 11.8967 13.167C12.325 13.1032 13.2152 12.6277 13.4012 12.1072C13.5872 11.5867 13.5872 11.1397 13.531 11.0475C13.4755 10.9537 13.327 10.8982 13.1042 10.7865Z" fill="#0176D3"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_2151_1201">
                                                        <rect width="18" height="18" fill="white"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p class="m-0 text-body">{{$lead->phone}}</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="mb-md-0 mb-2 text-primary fw-medium">+ Add Telephone (Office)</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <a class="d-flex align-items-center gap-2">
                                            <i class="icon-map-pin text-primary fs-16"></i>
                                            <p class="m-0 text-body">{{optional($lead->address)->address}}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="underline-info" role="tabpanel" aria-labelledby="underline-info-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 mb-2">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Lead Note</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-2">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Organization Note</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-2">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Linkedin</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-md-0 mb-2">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Add Website</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6 mb-md-0 mb-2">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Date Of Birth</p>
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads">
                                            <p class="text-primary fw-medium m-0">+ Add Special Event Date</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="underline-leads" role="tabpanel" aria-labelledby="underline-leads-tab" tabindex="0">
                                <p class="m-0 text-center">No related leads found</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Lead Profile -->

                <!-- Start - Assignment -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">Assignment & Follow-up</h5>
                            <button data-bs-toggle="modal" data-bs-target="#addLeads" class="btn btn-sm btn-square rounded-pill btn-primary light"><i class="icon-pencil"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <div class="avatar avatar-sm avatar-primary light rounded-circle border-dashed border-2 border-primary fs-28 fw-light">+</div>
                                <div class="d-flex flex-column gap-1">
                                    <p class="fs-12 m-0">Assign To: {{optional(optional(@$lead->last_follow_up)->assigned_user)->name}} </p>
                                    <a class="btn btn-sm btn-info text-uppercase" data-bs-toggle="modal" data-bs-target="#AjaxModalBoxLg" href="{{ route('business.solarmitra.leads.assign_lead',$lead->id) }}">Edit Current Schedule</a>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div>
                                @forelse ($lead->follow_ups as $key => $follow_up)
                                    <div class="bg-primary-subtle border rounded d-flex gap-2 p-3 mb-3">
                                        <div class="d-flex flex-column gap-1">
                                            <p class="m-0 fw-medium fs-14"> {{($key+1)}}. {{config('solarmitra.repeat_followups.'.$follow_up->repeat_followup)}} Schedule <span class="fs-12 text-muted">{{$follow_up->date_time}}</span> - {{$follow_up->note}}</p>
                                            <div class="ps-4 pt-2">
                                                @forelse ($follow_up->followup_logs as $log)
                                                    <p class=" fw-medium fs-14 lh-sm">
                                                        {{config('solarmitra.followup_logs_status.'.$log->status)}} : 
                                                        <span class="fs-12 text-muted">{{$log->scheduled_at}}</span> - 
                                                        <span class="fs-12 text-muted">{{$log->completed_at}}</span>
                                                    </p>
                                                @empty
                                                @endforelse
                                                
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Assignment -->

                <!-- Start - Qualifiers -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">{{ __('solarmitra::solarmitra.qualifiers') }}</h5>
                            <button data-bs-toggle="modal" data-bs-target="#addLeads" class="btn btn-sm btn-square rounded-pill btn-primary light"><i class="icon-pencil"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge bg-warning-subtle text-body d-flex gap-1 align-items-center">
                                    <i class="icon-funnel text-warning"></i>
                                    Customer
                                </span>
                                <span class="badge bg-primary-subtle text-body d-flex gap-1 align-items-center">
                                    <i class="icon-star text-primary"></i>
                                    High
                                </span>
                                <span class="badge bg-success-subtle text-body d-flex gap-1 align-items-center">
                                    <i class="icon-dollar-sign text-success"></i>
                                    2500000 INR
                                </span>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex gap-3">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Notes :
                                        </h6>
                                        <a class="text-body fw-medium" data-bs-toggle="modal" data-bs-target="#addLeads">+ Add Notes</a>
                                    </div>
                                </div>
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex gap-3">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Product Group :
                                        </h6>
                                        <span class="badge bg-primary">Sample - HelloLeads LMS</span>
                                    </div>
                                </div>
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex gap-3">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Customer Group :
                                        </h6>
                                        <span class="badge bg-success">Sample - Individual</span>
                                    </div>
                                </div>
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex gap-3">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Tages :
                                        </h6>
                                        <a class="text-body fw-medium" data-bs-toggle="modal" data-bs-target="#addLeads">+ Select Tags</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Qualifiers -->

                <!-- Start - Sales -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h5 class="card-title">{{ __('solarmitra::solarmitra.sales_transactions') }}</h5>
                            <button data-bs-toggle="modal" data-bs-target="#addLeads" class="btn btn-sm btn-square rounded-pill btn-primary light"><i class="icon-pencil"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Quotes (0)
                                        </h6>
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads"><i class="icon-external-link text-primary"></i></a></a>
                                    </div>
                                </div>
                                <div class="bg-primary-subtle border border-primary p-3 rounded">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fs-14 d-flex gap-2 align-items-center m-0">
                                            <i class="icon-file-pen text-primary"></i>
                                            Invoice (0)
                                        </h6>
                                        <a data-bs-toggle="modal" data-bs-target="#addLeads"><i class="icon-external-link text-primary"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Sales -->

            </div>
        </div>

        <div class="col-xl-5">

            <div class="row sticky-top sticky-top-70 z-0">
                <div class="col-xl-12">
                    <div class="card vh-90">
                        <ul class="nav nav-underline lead-detail gap-0 border-bottom" id="nav-tab" role="tablist">
                            <li class="nav-item w-25" role="presentation">
                                <button class="nav-link w-100 border-4 py-3 active" id="chat-tab" data-bs-toggle="tab" data-bs-target="#Chat" type="button" role="tab" aria-controls="Chat" aria-selected="true">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2144_1087)">
                                            <path d="M7.25 15H2.5C1.25583 15 0 14.055 0 11.945V7.74503C0.0175226 5.83017 0.734522 3.98779 2.01598 2.56482C3.29744 1.14184 5.05493 0.236473 6.9575 0.0191962C8.03113 -0.0587419 9.10896 0.0953475 10.1178 0.470994C11.1265 0.84664 12.0426 1.43504 12.8038 2.19621C13.565 2.95738 14.1534 3.87349 14.529 4.88228C14.9047 5.89107 15.0588 6.9689 14.9808 8.04253C14.7633 9.94588 13.8571 11.704 12.4332 12.9855C11.0092 14.267 9.16567 14.9835 7.25 15ZM16.6667 7.5667H16.6567C16.6567 7.7642 16.6567 7.9617 16.6467 8.16003C16.325 12.6667 12.2058 16.4817 7.57 16.6509V16.6634C8.15384 17.676 8.99364 18.5172 10.0052 19.1029C11.0167 19.6885 12.1645 19.9979 13.3333 20H17.5C18.163 20 18.7989 19.7366 19.2678 19.2678C19.7366 18.799 20 18.1631 20 17.5V13.3334C19.9988 12.1643 19.6902 11.0161 19.1051 10.0039C18.5201 8.99175 17.6791 8.15124 16.6667 7.5667Z" fill="#555F72"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2144_1087">
                                                <rect width="20" height="20" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </li>
                            <li class="nav-item w-25" role="presentation">
                                <button class="nav-link w-100 border-4 py-3" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments" type="button" role="tab" aria-controls="attachments" aria-selected="false" tabindex="-1">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2144_1090)">
                                            <path d="M6.52828 13.4742C6.06411 13.01 5.71578 12.4683 5.46078 11.89L6.76911 10.5817C6.91494 11.2158 7.22577 11.815 7.70661 12.2958C8.37578 12.965 9.26494 13.3333 10.2108 13.3333C11.1566 13.3333 12.0466 12.965 12.7149 12.2958L17.2983 7.71251C17.9674 7.04335 18.3358 6.15418 18.3358 5.20835C18.3358 4.26251 17.9674 3.37251 17.2983 2.70418C15.9174 1.32335 13.6716 1.32335 12.2899 2.70418L11.4524 3.54251C10.9158 3.41001 10.3616 3.33418 9.79411 3.33418C9.62078 3.33418 9.44994 3.34668 9.27911 3.35918L11.1116 1.52668C13.1424 -0.504987 16.4466 -0.504987 18.4774 1.52668C20.5083 3.55751 20.5083 6.86168 18.4774 8.89251L13.8941 13.4758C12.9108 14.46 11.6024 15.0017 10.2116 15.0017C8.82077 15.0017 7.51244 14.46 6.52911 13.4758L6.52828 13.4742ZM0.00244141 14.7917C0.00244141 16.1825 0.544108 17.4908 1.52827 18.4742C2.51161 19.4583 3.81911 20 5.21077 20C6.60244 20 7.90994 19.4583 8.89327 18.4742L10.7266 16.6408C10.5558 16.6533 10.3841 16.6658 10.2116 16.6658C9.64411 16.6658 9.08994 16.59 8.55327 16.4575L7.71494 17.2958C7.04578 17.965 6.15661 18.3333 5.21077 18.3333C4.26494 18.3333 3.37577 17.965 2.70661 17.2958C2.03744 16.6267 1.66911 15.7375 1.66911 14.7917C1.66911 13.8458 2.03744 12.9558 2.70661 12.2875L7.28994 7.70418C7.95911 7.03501 8.84828 6.66668 9.79411 6.66668C10.7399 6.66668 11.6291 7.03501 12.2974 7.70335C12.7783 8.18501 13.0891 8.78418 13.2349 9.41835L14.5433 8.11001C14.2883 7.53168 13.9399 6.99001 13.4758 6.52585C12.4924 5.54168 11.1841 5.00001 9.79327 5.00001C8.40244 5.00001 7.09411 5.54168 6.11078 6.52585L1.52827 11.1092C0.544108 12.0925 0.00244141 13.4008 0.00244141 14.7917Z" fill="#555F72"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2144_1090">
                                                <rect width="20" height="20" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </li>
                            <li class="nav-item w-25" role="presentation">
                                <button class="nav-link w-100 border-4 py-3" id="todo-tab" data-bs-toggle="tab" data-bs-target="#to-do" type="button" role="tab" aria-controls="to-do" aria-selected="false" tabindex="-1">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2144_1093)">
                                            <path d="M19.9998 9.99999C19.9998 8.64499 19.4048 7.36665 18.3957 6.56332C18.5123 5.21165 18.029 3.88749 17.0707 2.92832C16.1123 1.97082 14.7915 1.48832 13.5065 1.63249C11.8282 -0.497514 8.20233 -0.537514 6.56317 1.60332C5.20983 1.48332 3.88733 1.96915 2.929 2.92832C1.9715 3.88665 1.48817 5.21165 1.63317 6.49249C-0.496833 8.17082 -0.537666 11.7967 1.604 13.4367C1.48733 14.7883 1.97067 16.1125 2.929 17.0717C3.88733 18.0292 5.20983 18.5133 6.49317 18.3675C8.1715 20.4975 11.7973 20.5375 13.4365 18.3967C14.7865 18.51 16.1115 18.0308 17.0707 17.0717C18.0282 16.1133 18.5115 14.7883 18.3665 13.5075C19.4048 12.6342 19.9998 11.3558 19.9998 10.0008V9.99999ZM14.6165 8.80499L10.6673 12.6117C9.69817 13.5792 8.11233 13.5708 7.14317 12.6008L5.2665 10.8575C4.92983 10.5442 4.90983 10.0167 5.22317 9.67999C5.53733 9.34249 6.06567 9.32415 6.40067 9.63665L8.299 11.4008C8.64733 11.7483 9.174 11.7475 9.499 11.4217L13.459 7.60415C13.7907 7.28582 14.3182 7.29499 14.6373 7.62582C14.9573 7.95665 14.9473 8.48499 14.6165 8.80415V8.80499Z" fill="#555F72"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2144_1093">
                                                <rect width="20" height="20" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </li>
                            <li class="nav-item w-25" role="presentation">
                                <button class="nav-link w-100 border-4 py-3" id="recent-activity-tab" data-bs-toggle="tab" data-bs-target="#recent-activity" type="button" role="tab" aria-controls="recent-activity" aria-selected="false" tabindex="-1">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2144_1096)">
                                            <path d="M10.0001 0C7.55401 0.00719092 5.1949 0.908156 3.36675 2.53333L2.25592 1.4225C2.13937 1.30599 1.9909 1.22665 1.82928 1.19451C1.66765 1.16237 1.50012 1.17888 1.34787 1.24193C1.19562 1.30499 1.06548 1.41178 0.973915 1.54878C0.882344 1.68579 0.833451 1.84687 0.833416 2.01167V5.83333C0.833416 6.05435 0.921213 6.26631 1.07749 6.42259C1.23377 6.57887 1.44574 6.66667 1.66675 6.66667H5.48842C5.65321 6.66663 5.81429 6.61774 5.9513 6.52617C6.08831 6.4346 6.19509 6.30446 6.25815 6.15221C6.32121 5.99996 6.33771 5.83243 6.30557 5.67081C6.27343 5.50918 6.19409 5.36071 6.07758 5.24417L5.13175 4.29833C6.2355 3.35545 7.58916 2.75314 9.0285 2.56449C10.4678 2.37583 11.931 2.60894 13.2405 3.23553C14.5499 3.86211 15.6494 4.85524 16.4055 6.09444C17.1616 7.33363 17.5418 8.76562 17.5001 10.2167C17.4465 12.0916 16.6923 13.8783 15.3863 15.2246C14.0803 16.5708 12.3172 17.3788 10.4448 17.4893C8.57244 17.5998 6.72662 17.0046 5.27137 15.8213C3.81613 14.6379 2.8571 12.9522 2.58342 11.0967C2.54434 10.795 2.39727 10.5176 2.16945 10.316C1.94163 10.1144 1.64847 10.0021 1.34425 10C1.16772 9.99772 0.992736 10.0331 0.830987 10.1039C0.669238 10.1746 0.524449 10.2791 0.40629 10.4103C0.288131 10.5414 0.199324 10.6963 0.145801 10.8645C0.0922778 11.0328 0.0752707 11.2105 0.0959159 11.3858C0.442758 13.8408 1.68791 16.0799 3.59041 17.6697C5.49292 19.2596 7.91754 20.0872 10.3951 19.9925C12.9015 19.8717 15.2731 18.8218 17.0475 17.0474C18.8219 15.2731 19.8718 12.9014 19.9926 10.395C20.0442 9.04993 19.8241 7.70826 19.3453 6.45022C18.8666 5.19218 18.139 4.04361 17.2062 3.0732C16.2734 2.10279 15.1544 1.33047 13.9162 0.802433C12.6781 0.274392 11.3461 0.00147357 10.0001 0Z" fill="#555F72"/>
                                            <path d="M9.5835 5.83337C9.25198 5.83337 8.93403 5.96507 8.69961 6.19949C8.46519 6.43391 8.3335 6.75185 8.3335 7.08337V10.6609C8.33359 11.1029 8.50925 11.5267 8.82183 11.8392L10.316 13.3334C10.5517 13.5611 10.8675 13.6871 11.1952 13.6842C11.523 13.6814 11.8365 13.5499 12.0683 13.3181C12.3 13.0864 12.4315 12.7729 12.4343 12.4451C12.4372 12.1174 12.3112 11.8016 12.0835 11.5659L10.8335 10.3159V7.08337C10.8335 6.75185 10.7018 6.43391 10.4674 6.19949C10.233 5.96507 9.91502 5.83337 9.5835 5.83337Z" fill="#555F72"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2144_1096">
                                                <rect width="20" height="20" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content" id="underline-tabContent">
                                <div class="tab-pane fade show active" id="Chat" role="tabpanel" aria-labelledby="chat-tab" tabindex="0">
                                    
                                    <div class="position-relative mb-4">
                                        <input type="text" class="form-control form-control-lg" placeholder="Type Your Comment Here...." style="padding-right: 60px;">
                                        <span class="position-absolute top-50 end-0 translate-middle">
                                            <a class="btn btn-primary light btn-sm btn-square rounded-pill"><i class="icon-send"></i></a>
                                        </span>
                                    </div>

                                    <div class="bg-primary-subtle border rounded d-flex gap-2 p-3">
                                        <div class="avatar avatar-secondary avatar-xs border-0 rounded-circle">
                                            <i class="icon-user"></i>
                                        </div>
                                        <div class="d-flex flex-column gap-1">
                                            <p class="m-0 fw-medium fs-14">Kuldeep Gaur</p>
                                            <span class="fs-10 text-muted">2026-02-06  18:55</span>
                                            <p class="m-0 fw-medium fs-14 lh-sm">Hello My Name Is Kuldeep Gaur</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="attachments-tab" tabindex="0">
                                    
                                    <form action="#" class="dropzone dropzone-sm mb-4">
                                        <div class="fallback">                                                              
                                            <input name="file" type="file" multiple>
                                        </div>
                                    </form>

                                    <div class="d-flex gap-2 flex-column align-items-center">
                                        <i class="icon-file-input fs-26"></i>
                                        <h6 class="m-0">No attachments yet.</h6>
                                        <p class="m-0 fs-12 text-center">Upload files here to keep all lead-related documents organized and accessible to your entire team.</p>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="to-do" role="tabpanel" aria-labelledby="todo-tab" tabindex="0">
                                    
                                    <div class="d-flex justify-content-between align-items center pb-2 border-bottom mb-4">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="icon-badge-check fs-16 text-primary"></i>
                                            To-do List (0)
                                        </div>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createToDo">+ Create To-do</button>
                                    </div>

                                    <div class="d-flex gap-2 flex-column align-items-center">
                                        <i class="icon-circle-check fs-26"></i>
                                        <h6 class="m-0">No To-do items found.</h6>
                                        <p class="m-0 fs-12 text-center">There are no To-do tasks associated with this lead yet.</p>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createToDo">+ Create To-do</button>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="recent-activity" role="tabpanel" aria-labelledby="recent-activity-tab" tabindex="0">
                                    
                                    <div class="d-flex gap-2 align-items-center mb-4">
                                        <i class="icon-cog fs-16 text-warning"></i>
                                        <p class="m-0">Automated system logs and changes for this lead/customer.</p>
                                    </div>

                                    <div class="d-flex gap-2 flex-column align-items-center">
                                        <i class="icon-cog fs-26"></i>
                                        <h6 class="m-0">No system logs found.</h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection

@push('inline-modals')
     <div class="modal" id="createToDo" tabindex="-1" aria-labelledby="createToDo" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel7">Create New To-do</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-body">
                    
                    <div class="mb-3">
                        <label for="task" class="form-label">To-do Task</label>
                        <textarea class="form-control" id="task" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label mb-1">{{ __('solarmitra::solarmitra.assigned_to') }}</label>
                        <select id="assigned" class="form-select selectpicker" title="-- Select User --">
                            <option>Kuldeep Gaur</option>
                            <option>Yugank Gaur</option>
                        </select>
                    </div>

                    <div>
                        <label for="date&time" class="form-label">Due Date & Time</label>
                        <input id="date&time" class="form-control bs-datepicker" type="text" value="" placeholder="Select Date">
                    </div>

                </div>
                <div class="modal-footer bg-body rounded-bottom">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.cancel') }}</button>
                    <button type="button" class="btn btn-primary">
                        <i class="icon icon-check"></i>
                        Create To-do
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush