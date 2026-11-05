@php
    $Obj = '';

    if (!empty($blog)) {
        $Obj = $blog;
    }
    if (!empty($page)) {
        $Obj = $page;
    }

@endphp

@if (!empty($Obj) && !empty($status) && $Obj->visibility == 'PP' && $status == 'locked')
    
    @if (!empty($page))
    <div class="container">
    @endif
        <form method="POST" class="{{ !$show_banner ? 'my-5 py-5' : ''}}">
            @csrf
            <h5 class="text-primary mb-3">{{ __('This content is password protected. To view it please enter your password below:') }}</h5>
            <div class="row">
                <div class="col-md-8 d-flex">
                    <div class="input-area col-sm-8">
                        <label for="password" class="form-control-label">{{ __('Password') }}</label>
                        <div class=" input-line">
                            <input id="password" type="password" class="form-control" required name="password">
                        </div>
                    </div>
                    <div class="col-4 text-end d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-skew align-self-end">
                            <span>{{ __('Login') }}</span>
                        </button>
                    </div>
                </div>
                @error('password')
                <p class="text-danger mt-2">
                    {{ $message }}
                </p>
                @enderror
            </div>
        </form>
    @if (!empty($page))
    </div>
    @endif
    

@endif
