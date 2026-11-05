@extends('admin.layout.fullwidth')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-5">
                <div class="form-input-content text-center error-page">
                    <h1 class="error-text fw-bold">{{ __('503') }}</h1>
                    <h4><i class="fa fa-times-circle text-danger"></i> Service Unavailable!</h4>
                    <p>{{ __("the server is temporarily not ready to handle the request or is in maintenance mode.") }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection