<form method="post" action="{{route('business.solarmitra.leads.client_group',@$customerGroupObj->id)}}" id="ClientGroupModalForm">
    @csrf
    <div class="formLoading d-none">
        <img src="{{ asset('images/ajax-loader.gif') }}" alt="loading" width="50px" class="loading">
        <span>&nbsp;&nbsp;{{ __('solarmitra::solarmitra.loading_ellipsis') }} </span>
    </div>
        <input type="hidden" name="business_id" value="{{app('currentBusinessId')}}">
    
    <div class="modal-header">
        <h5 class="modal-title" id="date-filter">{{ @$customerGroupObj->id ? __('solarmitra::solarmitra.edit') : __('solarmitra::solarmitra.add') }} {{ __('solarmitra::solarmitra.client_group') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body ">
        <div class="row">
                    
            <div class="col-12 mb-3">
                <label class="form-label">{{ __('solarmitra::solarmitra.client_group') }} {{ __('solarmitra::solarmitra.title') }} <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" autocomplete="title" value="{{ old('title',@$customerGroupObj->user->title) }}">
                <p class="text-danger m-0 error-text title_error"></p>
                
            </div>
            
            
        </div>

        <div class="d-flex  align-items-center mb-3">
            <button type="submit" class="btn btn-primary">{{ @$customerGroupObj->id ? __('solarmitra::solarmitra.update') : __('solarmitra::solarmitra.create') }} {{ __('solarmitra::solarmitra.client_group') }}</button>
        </div>

        

        <table class="table m-0">
            <thead>
                <tr>
                    <th class="width100">{{ __('solarmitra::solarmitra.s_no') }}</th>
                    <th class="">{{ __('solarmitra::solarmitra.name') }}</th>
                    @can('SolarMitra > Business > LeadsController > destroy_client_group')
                    <th class="width100">{{ __('solarmitra::solarmitra.actions') }}</th>
                    @endcan
                </tr>
            </thead>
            <tbody id="ClientGroupTableBody">
                @forelse ($customer_groups as $key => $customer_group)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$customer_group->title}}</td>
                    @can('SolarMitra > Business > LeadsController > destroy_client_group')
                    <td>
                        <a href="{{ route('business.solarmitra.leads.destroy_client_group',$customer_group->id) }}" class="btn btn-danger shadow btn-xs py-2 sharp deleteClientGroup" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                    @endcan
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</form>