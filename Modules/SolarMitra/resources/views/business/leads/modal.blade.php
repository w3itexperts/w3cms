<form method="post" action="{{@$lead->id ? route('business.solarmitra.leads.update',@$lead->id) : route('business.solarmitra.leads.store')}}" class="AjaxModalForm leads-modal">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
    
    <div class="modal-header">
        <h5 class="modal-title" >{{ @$lead->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.lead') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body py-0 px-2 bg-body">
        <div class="row">
                    
            <div class="col-md-2 border-end">
                <ul class="nav leads-nav nav-pills nav-pills-all flex-column align-items-center px-3 py-4" id="justify-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex gap-2 flex-column align-items-center" id="justify-home-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab" aria-controls="justify-home" aria-selected="true">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M30 33.3333C30 30.6811 28.9464 28.1375 27.0711 26.2622C25.1957 24.3868 22.6522 23.3333 20 23.3333C17.3478 23.3333 14.8043 24.3868 12.9289 26.2622C11.0536 28.1375 10 30.6811 10 33.3333" stroke="#0176D3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 23.3333C23.6819 23.3333 26.6667 20.3486 26.6667 16.6667C26.6667 12.9848 23.6819 10 20 10C16.3181 10 13.3334 12.9848 13.3334 16.6667C13.3334 20.3486 16.3181 23.3333 20 23.3333Z" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 36.6666C29.2048 36.6666 36.6667 29.2047 36.6667 19.9999C36.6667 10.7952 29.2048 3.33325 20 3.33325C10.7953 3.33325 3.33337 10.7952 3.33337 19.9999C3.33337 29.2047 10.7953 36.6666 20 36.6666Z" fill="#919FBA" fill-opacity="0.1" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        Profile
                        </button>
                    </li>
                    @if (!@$lead->id)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-follow-up-tab" data-bs-toggle="pill" data-bs-target="#follow-up" type="button" role="tab" aria-controls="justify-contact" aria-selected="false" tabindex="-1">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 8.75V17.5H11.6666" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.5 32.0834C25.5541 32.0834 32.0833 25.5542 32.0833 17.5001C32.0833 9.44593 25.5541 2.91675 17.5 2.91675C9.44581 2.91675 2.91663 9.44593 2.91663 17.5001C2.91663 25.5542 9.44581 32.0834 17.5 32.0834Z" fill="#919FBA" fill-opacity="0.1" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Follow-up
                        </button>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-profile-tab" data-bs-toggle="pill" data-bs-target="#qualifires" type="button" role="tab" aria-controls="justify-profile" aria-selected="false" tabindex="-1">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.29834 27.5772C9.92063 25.9033 11.0402 24.4599 12.5067 23.4408C13.9732 22.4217 15.7164 21.8757 17.5023 21.8762C19.2881 21.8767 21.031 22.4236 22.497 23.4435C23.9629 24.4633 25.0817 25.9073 25.7031 27.5816" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.5 21.8749C20.7216 21.8749 23.3333 19.2632 23.3333 16.0416C23.3333 12.8199 20.7216 10.2083 17.5 10.2083C14.2783 10.2083 11.6666 12.8199 11.6666 16.0416C11.6666 19.2632 14.2783 21.8749 17.5 21.8749Z" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Qualifiers
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="col-md-10">
                
                <div class="tab-content" id="justify-tabContent">
                    
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile" tabindex="0">
                        <div class="row">
                            <div class="p-4 " style="height: 70vh; overflow-y: scroll;">
                                
                                <div class="col-xl-12 border rounded p-3 mb-3">
                                    
                                    <div class=" d-flex justify-content-between align-items-center mb-1">
                                        <p class="fs-14 m-0 text-black">{{ __('solarmitra::solarmitra.client_group') }}</p>
                                    </div>
                                    
                                    <div class="btn-group custom-btn-group gap-2" role="group" aria-label="Basic radio toggle button group">
                                        @forelse ($client_groups as $key => $title)
                                            <input type="radio" class="btn-check" name="client_group_id" id="btnradio{{$key}}" value="{{$key}}" @checked(old('client_group_id', @$lead->client_group_id) == $key)>
                                            <label class="btn btn-sm rounded btn-outline-primary" for="btnradio{{$key}}">
                                                {{$title}}
                                            </label>
                                        @empty
                                        @endforelse
                                    </div>
                                
                                </div>
                                
                                <div class="col-xl-12 border rounded p-3 mb-3">
                                    <div class="row">
                                        
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.abbreviation') }} </label>
                                            <select name="abbreviation" class="selectpicker" >
                                                <option value="">{{ __('solarmitra::solarmitra.abbreviation') }}</option>
                                                @forelse ($abbreviations as $title)
                                                    <option value="{{$title}}" @selected(old('abbreviation',@$lead->abbreviation) == $title)>{{$title}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <p class="text-danger error-text mb-0 abbreviation_error"></p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.first_name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name',@$lead->first_name) }}">
                                            <p class="text-danger error-text mb-0 first_name_error"></p>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.last_name') }} </label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name',@$lead->last_name) }}">
                                            <p class="text-danger error-text mb-0 last_name_error"></p>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label for="email_opt_out" class="form-label">{{ __('solarmitra::solarmitra.email_opt_out') }} </label>
                                            <div class=" form-switch">
                                                <input class="form-check-input" type="checkbox" name="email_opt_out" role="switch" id="email_opt_out" value="1" @checked(old('email_opt_out',@$lead->email_opt_out) == 1)>
                                            </div>
                                            <p class="text-danger error-text mb-0 email_opt_out_error"></p>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }} <span class="text-danger">*</span></label>
                                            <select name="lead_source_id" class="selectpicker" data-live-search="true" >
                                                <option value="">{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.source') }}</option>
                                                @forelse ($sources as $slug => $title)
                                                    <option value="{{$slug}}" @selected(old('lead_source_id', @$lead->lead_source_id) == $slug)>{{$title}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <p class="text-danger error-text mb-0 lead_source_id_error"></p>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3 d-none">
                                            <label class="form-label d-block">{{ __('solarmitra::solarmitra.potential') }} </label>
                                            <div class="btn-group custom-btn-group gap-2" role="group" aria-label="Basic radio toggle button group">
                                                @forelse (config('solarmitra.lead_potentials') as $key => $title)
                                                    <input type="radio" class="btn-check" name="potential" id="btnPotential{{$key}}" value="{{$key}}" @checked(old('potential', @$lead->potential) == $key)>
                                                    <label class="btn btn-sm rounded btn-outline-primary" for="btnPotential{{$key}}">
                                                        {{$title}}
                                                    </label>
                                                @empty
                                                @endforelse
                                            </div>
                                            <p class="text-danger error-text mb-0 potential_error"></p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.email') }}</label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email',@$lead->email) }}">
                                            <p class="text-danger error-text mb-0 email_error"></p>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">{{ __('solarmitra::solarmitra.phone') }} <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone',@$lead->phone) }}">
                                            <p class="text-danger error-text mb-0 phone_error"></p>
                                        </div>

                                    </div>
                                </div>
                                
                                <div class="col-xl-12 border rounded p-3 mb-3">
                                    <div class="row">
                                        @php
                                            $address = @$lead->address;
                                        @endphp
                                        <div class="form-group mb-3 col-md-6">
                                            <label class="form-label" for="address_title">{{ __('solarmitra::solarmitra.address_title') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="address_title" class="form-control" id="address_title" value="{{ old('address_title', @$address->address_title) }}" placeholder="{{ __('solarmitra::solarmitra.address_title') }}"  >
                                            @error('address_title')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-danger error-text mb-0 address_title_error"></p>
                                        </div>
                                        <div class="form-group mb-3 col-md-6">
                                            <label class="form-label" for="address">{{ __('solarmitra::solarmitra.address') }} <span class="text-danger">*</span></label>
                                            <textarea name="address" class="form-control" id="address" rows="5">{{ old('address', @$address->address) }}</textarea>
                                            @error('address')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="text-danger error-text mb-0 address_error"></p>
                                        </div>
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="form-label" for="state_id">{{ __('solarmitra::solarmitra.state') }}</label>
                                            <select name="state_id" class="selectpicker" id="state_id" data-live-search="true" >
                                                    <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.state') }}</option>
                                                    @forelse(SolarMitraHelper::getStatesList() as $stateId => $stateTitle)
                                                        <option value="{{ $stateId }}" {{ old('state_id',(@$address->state_id ?? config('solarmitra.state_id_rajasthan'))) == $stateId ? 'selected="selected"' : '' }}>{{ $stateTitle }}</option>
                                                    @empty
                                                    @endforelse
                                            </select>
                                            @error('state_id')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="form-label" for="city_id">{{ __('solarmitra::solarmitra.city') }}</label>
                                            <select name="city_id" class="selectpicker" id="city_id"  data-live-search="true" >
                                                    <option value="" >{{ __('solarmitra::solarmitra.select') }} {{ __('solarmitra::solarmitra.city') }}</option>
                                                @forelse(SolarMitraHelper::getCitiesList() as $cityId => $cityTitle)
                                                    <option value="{{ $cityId }}" {{ old('city_id',@$address->city_id) == $cityId ? 'selected="selected"' : '' }}>{{ $cityTitle }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('city_id')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    @if (!@$lead->id)
                    <div class="tab-pane fade" id="follow-up" role="tabpanel" aria-labelledby="follow-up" tabindex="0">
                        
                        <div class=" row p-4" style="height: 70vh; overflow-y: scroll;">
                        
                            <div class="col-xl-12 border rounded p-3 mb-3">
                                <div class="row mb-3">
                                    <label for="assigned_to" class="col-sm-3 col-form-label col-form-label-sm">{{ __('solarmitra::solarmitra.assigned_to') }} <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="selectpicker" name="assigned_to" id="assigned_to" data-live-search="true">
                                            <option value="">{{ __('solarmitra::solarmitra.select_staff') }}</option>
                                            @forelse (SolarMitraHelper::getContactsList('staff') as $id => $title)
                                                <option value="{{$id}}" @selected(old('assigned_to') == $id)>{{$title}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <p class="text-danger error-text mb-0 mb-0 assigned_to_error"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="RepeatFollowUpDate" class="col-sm-3 col-form-label col-form-label-sm">Next follow-up date</label>
                                    <div class="col-sm-9">
                                        <input class="form-control DateTimePicker" type="text" name="follow_up_date" id="RepeatFollowUpDate" value="{{ Carbon\Carbon::now()->format(config('solarmitra.date_time_format'))}}">
                                    </div>
                                        <p class="text-danger error-text mb-0 mb-0 follow_up_date_error"></p>
                                </div>
                                <div class="row mb-3">
                                    <label for="RepeatFollowUpNote" class="col-sm-3 col-form-label col-form-label-sm">Next follow-up notes <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="1" id="RepeatFollowUpNote" name="follow_up_note">{{old('follow_up_note')}}</textarea>
                                        <p class="text-danger error-text mb-0 mb-0 follow_up_note_error"></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="RepeatFollowUpSelect" class="col-sm-3 col-form-label col-form-label-sm">Repeat follow-up</label>
                                    <div class="col-sm-9">
                                        <select name="repeat_followup" class="selectpicker" id="RepeatFollowUpSelect">
                                            @forelse (config('solarmitra.repeat_followups') as $key => $title)
                                                <option value="{{$key}}" @selected(old('repeat_followup') == $key)>{{$title}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <p class="text-danger error-text mb-0 mb-0 repeat_followup_error"></p>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <label for="DonotFollowToggle" class="col-sm-3 col-form-label col-form-label-sm">Do not follow-up</label>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch d-flex gap-3 m-0 align-items-center">
                                            <input class="form-check-input" type="checkbox" role="switch" name="do_not_follow_up" id="DonotFollowToggle" value="1" @checked(@$lead->do_not_followup)>
                                            <input class="form-control " type="text" name="no_follow_up_reason" id="NoFollowUpReasonText" style="display:none;" placeholder="Do not Follow Up Reason">
                                            <p class="text-danger error-text mb-0 mb-0 no_follow_up_reason_error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        
                    </div>
                    @endif
                    
                    <div class="tab-pane fade" id="qualifires" role="tabpanel" aria-labelledby="qualifires" tabindex="0">
                        <div class="row">
                            <div class="p-4" style="height: 70vh; overflow-y: scroll;">
                                
                                <div class="col-xl-12 border rounded p-3 mb-3">
                                    <div class="row mb-3">
                                        <label for="Capacity" class="col-sm-2 col-form-label">{{ __('solarmitra::solarmitra.capacity') }}</label>
                                        <div class="col-sm-8">
                                            {{CustomFieldHelper::custom_field('Lead.capacity','leads',@$lead->id)}}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="lead_added_by_id" class="col-sm-2 col-form-label">{{ __('solarmitra::solarmitra.lead_added_by') }} (Optional)</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" name="lead_added_by_id" id="lead_added_by_id" data-live-search="true">
                                                <option value="{{optional(auth('business')->user())->id}}" @selected(@$lead->lead_added_by_id == optional(auth('business')->user())->id)>Self</option>
                                                @forelse ($lead_staff as $staff)
                                                    <option value="{{$staff['id']}}" @selected(@$lead->lead_added_by_id == $staff['id'])>{{$staff['name']}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <p class="text-danger error-text mb-0 mb-0 lead_added_by_id_error"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="LeadPotential" class="col-sm-2 col-form-label">{{ __('solarmitra::solarmitra.lead_potential') }}</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" id="LeadPotential" name="potential">
                                                @forelse (config('solarmitra.lead_potentials') as $key => $title)
                                                    <option value="{{$key}}" @selected(old('potential', @$lead->potential) == $key)>{{$title}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="LeadStage" class="col-sm-2 col-form-label">{{ __('solarmitra::solarmitra.lead_stage') }}</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" data-live-search="true" id="LeadStage" name="lead_stage_id">
                                                @forelse ($lead_stages as $key => $title)
                                                    <option value="{{$key}}" @selected(old('lead_stage_id', @$lead->lead_stage_id) == $key)>{{$title}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 pb-3 border-bottom">
                                        <label for="Tags" class="col-sm-2 col-form-label">{{ __('solarmitra::solarmitra.tags') }}</label>
                                        <div class="col-sm-8">
                                            <input class="form-control basic-tagify" name='tags' id="Tags" value="{{optional(optional(@$lead->lead_tags)->pluck('title'))->implode(',')}}" autofocus>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h5 class="fs-16 d-flex gap-2">
                                            Custom Fields
                                            <a  data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Click for More Information"><i class="icon icon-circle-question-mark fs-20"></i></a>
                                        </h5>
                                        <p class="fs-13">
                                            In addition to above standard qualifiers, your business may need some more specific information to be captured at the time of adding leads - Custom fields can fulfill this purpose.
                                            <a class="text-primary ">{{ __('solarmitra::solarmitra.learn_more') }}</a>
                                        </p>
                                        <ul class="qualifiers-list">
                                            <li class="fs-13">To create new Custom field and map to the list. <a class="text-primary">(click here)</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
        </div>
    </div>
    <div class="modal-footer bg-body rounded-bottom">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('solarmitra::solarmitra.close') }}</button>
        <button type="submit" class="btn btn-primary">
            <i class="icon icon-save"></i>
            Save
        </button>
    </div>
</form>