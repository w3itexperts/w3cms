@extends('solarmitra::business.layout.default')

@section('content')

@php
    
    function getActiveClass($key)
    {
        static $activeAssigned = false;

        if (
            !$activeAssigned &&
            auth('business')->user()->can('SolarMitra > Business > BusinessController > ' . $key)
        ) {
            $activeAssigned = true;
            return 'active';
        }

        return '';
    }

    function getActiveBodyClass($key)
    {
        static $activeAssigned = false;

        if (
            !$activeAssigned &&
            auth('business')->user()->can('SolarMitra > Business > BusinessController > ' . $key)
        ) {
            $activeAssigned = true;
            return 'show active';
        }

        return '';
    }

@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card dz-setting   " >
                <div class="card-header ">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.business_settings') }}</h4>
                </div>
                <div class="card-body " >
                    <div class="d-flex">
                        <ul class="ThemeOptionsMainMenu nav flex-column" role="tablist" aria-orientation="vertical">
                            @can('SolarMitra > Business > BusinessController > save_business')
                            <li class="nav-item ">
                                <a class="nav-link text-nowrap {{ getActiveClass('save_business') }}" data-bs-toggle="tab" href="#section_group_1">
                                    <i class="me-2 icon-user-round-pen"></i>
                                    <span>{{ __('solarmitra::solarmitra.profile') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('SolarMitra > Business > BusinessController > bank_account')
                            <li class="nav-item ">
                                <a class="nav-link text-nowrap {{ getActiveClass('bank_account') }}" data-bs-toggle="tab" href="#section_group_2">
                                    <i class="me-2 icon-landmark"></i>
                                    <span>{{ __('solarmitra::solarmitra.bank_details') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('SolarMitra > Business > BusinessController > address')
                            <li class="nav-item ">
                                <a class="nav-link text-nowrap {{ getActiveClass('address') }}" data-bs-toggle="tab" href="#section_group_3">
                                    <i class="me-2 icon-map-pin-house"></i>
                                    <span>{{ __('solarmitra::solarmitra.addresses') }}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                        <div class="tab-content">
                            @can('SolarMitra > Business > BusinessController > save_business')
                            <div class="tab-pane fade {{ getActiveBodyClass('save_business') }}" id="section_group_1" role="tabpanel">
                                <div >
                                    <form action="{{ route('business.solarmitra.save_business',@$business->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class=" mb-4">
                                            <h4 class="card-title"> {{ __('solarmitra::solarmitra.user') }} {{ __('Details') }}</h4>
                                            <p>Edit User Details Related to Business.</p>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-4">
                                                <label>{{ __('solarmitra::solarmitra.first_name') }} <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name',@$business->user->first_name) }}">
                                                @error('first_name')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-4">
                                                <label>{{ __('solarmitra::solarmitra.last_name') }} </label>
                                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name',@$business->user->last_name) }}">
                                                @error('last_name')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-4">
                                                <label>{{ __('solarmitra::solarmitra.email') }}<span class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email',@$business->user->email) }}">
                                                @error('email')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-sm-6">
                                                <label for="dz-password">{{ __('solarmitra::solarmitra.password') }}</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="dz-password" class="form-control" autocomplete="new-password" value="{{ old('password') }}">
                                                    <span class="input-group-text show-pass"> 
                                                        <i class="fa fa-eye-slash"></i>
                                                        <i class="fa fa-eye"></i>
                                                    </span>
                                                </div>
                                                @error('password')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-sm-6">
                                                <label for="dz-con-password">{{ __('solarmitra::solarmitra.confirm_password') }}</label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" id="dz-con-password" class="form-control" autocomplete="new-password" value="{{ old('password_confirmation') }}">
                                                    <span class="input-group-text show-con-pass"> 
                                                        <i class="fa fa-eye-slash"></i>
                                                        <i class="fa fa-eye"></i>
                                                    </span>
                                                </div>
                                                @error('password_confirmation')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class=" my-4">
                                            <h4 class="card-title"> {{ __('solarmitra::solarmitra.business_owner') }}</h4>
                                            <p>Edit Details Related to Business.</p>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-3 col-md-3">
                                                <label for="company_name">{{ __('solarmitra::solarmitra.company_name') }}<span class="text-danger">*</span></label>
                                                <input type="text" name="company_name" class="form-control" id="company_name" placeholder="{{ __('solarmitra::solarmitra.company_name') }}" value="{{ old('company_name',@$business->company_name) }}" required>
                                                @error('company_name')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-3">
                                                <label for="Phone">{{ __('solarmitra::solarmitra.phone') }}<span class="text-danger">*</span></label>
                                                <input type="number" name="phone" class="form-control" id="Phone" value="{{ old('phone',@$business->phone) }}" placeholder="{{ __('solarmitra::solarmitra.phone') }}">
                                                @error('phone')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-3">
                                                <label for="gst_no">{{ __('solarmitra::solarmitra.gst_no') }}</label>
                                                <input type="text" name="gst_no" class="form-control" id="gst_no" value="{{ old('gst_no',@$business->gst_no) }}" placeholder="{{ __('solarmitra::solarmitra.gst_no') }}" >
                                                @error('gst_no')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-3">
                                                <label for="pan_no">{{ __('solarmitra::solarmitra.pan_no') }}</label>
                                                <input type="text" name="pan_no" class="form-control" id="pan_no" value="{{ old('pan_no',@$business->pan_no) }}" placeholder="{{ __('solarmitra::solarmitra.pan_no') }}" >
                                                @error('pan_no')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <label for="About">{{ __('solarmitra::solarmitra.about') }}</label>
                                                <textarea name="about" class="form-control h-auto" id="About" rows="5">{{ old('about',@$business->about) }}</textarea>
                                                @error('about')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3 col-md-6">
                                                <div class=" img-parent-box"> 
                                                    <img src="{{ SolarMitraHelper::getAttachmentImage(@$business->logo) }}" class="img-for-onchange zoomable rounded mb-2" alt="" width="200px">
                                                    <input type="file" class="ps-2 form-control img-business-input-onchange" name="logo" accept=".png, .jpg, .jpeg">
                                               </div>
                                                @error('logo')
                                                    <p class="text-danger">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" title="{{ __('solarmitra::solarmitra.click_to_save') }} Business Details">{{ __('solarmitra::solarmitra.save') }}</button>
                                    </form>

                                </div>
                            </div>
                            @endcan
                            @can('SolarMitra > Business > BusinessController > bank_account')
                            <div class="tab-pane fade {{ getActiveBodyClass('bank_account') }}" id="section_group_2" role="tabpanel">
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <div class=" ">
                                        <h4 class="card-title">{{ __('solarmitra::solarmitra.bank_accounts') }}</h4>
                                        <p>Edit Bank Accounts Related to Business.</p>
                                    </div>
                                    <button class="btn btn-primary ms-2 AjaxOffCanvasShow"  href="{{route('business.solarmitra.bank_account')}}">Add Bank Account</button>
                                </div>
                                <div class="">
                                    @forelse ($business->bank_accounts as $bank_account)
                                        <div class="mb-3 d-flex align-items-center justify-content-between">
                                            <span class="">
                                                <h5>{{@$bank_account->bank_name}}</h5>
                                                <span>{{@$bank_account->bank_address}}</span>
                                            </span>
                                            <div>
                                                <span> Account Holder - {{@$bank_account->account_holder}}</span><br>
                                                <span> Account Number - {{@$bank_account->account_number}}</span><br>
                                                <span> IFSC Code - {{@$bank_account->ifsc_code}}</span><br>
                                            </div>
                                            <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-ellipsis-vertical"></i>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item AjaxOffCanvasShow" href="{{route('business.solarmitra.bank_account',$bank_account->id)}}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                    @can('SolarMitra > Business > BusinessController > bank_account_destroy')
                                                    <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.bank_account.destroy',$bank_account->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @endcan
                            @can('SolarMitra > Business > BusinessController > address')
                            <div class="tab-pane fade {{ getActiveBodyClass('address') }}" id="section_group_3" role="tabpanel">
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <div class=" ">
                                        <h4 class="card-title">Addresses</h4>
                                        <p>Manage Multiple Addresses Related to Business.</p>
                                    </div>
                                    <button class="btn btn-primary ms-2 AjaxOffCanvasShow"  href="{{route('business.solarmitra.address')}}">Add Address</button>
                                </div>
                                <div class="">
                                    @forelse ($business->addresses as $address)
                                        <div class="mb-3 d-flex align-items-center justify-content-between">
                                            <span class="">
                                                <h5>{{@$address->address_title}}</h5>
                                                <span>{{@$address->address}}</span>
                                            </span>
                                            <div class="dropdown custom-dropdown mb-0 tbl-orders-style">
                                                <div class="btn btn-square rounded" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icon-ellipsis-vertical"></i>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item AjaxOffCanvasShow" href="{{route('business.solarmitra.address',$address->id)}}">{{ __('solarmitra::solarmitra.edit') }}</a>
                                                    @can('SolarMitra > Business > BusinessController > address_make_primary')
                                                    <a class="dropdown-item" href="{{route('business.solarmitra.address_make_primary',$address->id)}}" >{{ __('Set to Primary') }}</a>
                                                    @endcan
                                                    @can('SolarMitra > Business > BusinessController > address_destroy')
                                                    <a class="dropdown-item text-danger deleteRecord" href="{{ route('business.solarmitra.address.destroy',$address->id) }}">{{ __('solarmitra::solarmitra.delete') }}</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
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