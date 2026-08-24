@extends('admin.layout.fullwidth')

@section('content')
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            @include('admin.elements.alert_message')

            <div class="d-flex justify-content-center align-items-center py-5 vh-100" style="min-height:480px;">
                <div class="card shadow-sm p-4 h-auto" style="width:400px; border-radius:16px;">
                    <div class="text-center mb-4">
                        <div class="icon-wrap mx-auto mb-3" style="width:64px;height:64px;border-radius:50%;background:#eef5ff;display:flex;align-items:center;justify-content:center;">
                            @if($type == 'email')
                                <i class="icon-mail fs-3 text-primary"></i>
                            @else
                                <i class="icon-phone fs-3 text-success"></i>
                            @endif
                        </div>
                        <h5 class="fw-semibold mb-1">Update {{ ucfirst($type) }}</h5>
                        <p class="text-muted small mb-0">
                            Enter your new {{ $type }} address. You'll need to verify it after updating.
                        </p>
                    </div>

                    <form action="{{ route('business.solarmitra.auth.update_contact') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Current {{ ucfirst($type) }}</label>
                            <input type="text" class="form-control" value="{{ $type == 'email' ? $user->email : $user->mobile }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">New {{ ucfirst($type) }}</label>
                            @if($type == 'email')
                                <input type="email" name="value" class="form-control @error('value') is-invalid @enderror" 
                                       value="{{ old('value') }}" placeholder="Enter new email address" required>
                            @else
                                <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" 
                                       value="{{ old('value') }}" placeholder="Enter new 10-digit mobile number" 
                                       pattern="[0-9]{10}" maxlength="10" required>
                            @endif
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('business.solarmitra.auth.verification') }}" class="btn btn-secondary flex-fill">{{ __('solarmitra::solarmitra.cancel') }}</a>
                            <button type="submit" class="btn btn-primary flex-fill">Update & Verify</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection