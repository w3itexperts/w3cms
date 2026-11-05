{{-- Extends layout --}}
@extends('solarmitra::business.layout.default')
{{-- Content --}}
@section('content')
<div class="container-fluid">
    
    <!-- Row starts -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-block">
                    <h4 class="card-title">{{ __('solarmitra::solarmitra.roles') }}</h4>
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-md mb-0">
                            <thead>
                                <tr>
                                    <th><strong>{{ __('solarmitra::solarmitra.s_no') }}</strong> </th>
                                    <th><strong>{{ __('solarmitra::solarmitra.user_name') }}</strong></th>
                                    <th><strong>{{ __('solarmitra::solarmitra.email') }}</strong></th>
                                    <th><strong>{{ __('solarmitra::solarmitra.actions') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $users->firstItem();
                                @endphp
                                @forelse($users as $user)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> {{ $user->full_name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('business.solarmitra.permissions.manage_user_permissions', $user->id) }}">{{ __('solarmitra::solarmitra.manage_permission') }}</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">
                                        <p class="text-center">{{ __('solarmitra::solarmitra.users_not_found') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection