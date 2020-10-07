@extends('layouts.app')

@section('content')
<section class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 content-wrapper mt-4">
                <h1 class="text-center">{{ __('auth.confirm_password') }}</h1>
                
                {{ __('auth.confirm_password_text') }}

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password" class="col-form-label">{{ __('auth.password') }}</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-main w-100">
                            {{ __('auth.confirm_password') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-main w-100" href="{{ route('password.request') }}">
                                {{ __('auth.forgot_your_password') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
