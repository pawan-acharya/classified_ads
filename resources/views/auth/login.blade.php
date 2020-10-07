@extends('layouts.app')

@section('content')
<section id="login-page" class="login-background">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4 content-wrapper">
                <h1 class="login-head">{{ __('auth.login') }}</h1>
                @if(session('status'))
                    <div class="alert alert-success row" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger row" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <p class="login-subtitle border-top border-bottom">{{ __('auth.email_text') }}</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">{{ __('auth.email') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">{{ __('auth.password') }}</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="checkbox-inline" for="remember">
                                {{ __('auth.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-main w-100">
                            {{ __('auth.login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('auth.forgot_your_password') }}
                            </a>
                        @endif
                    </div>
                </form>
                <p class="login-subtitle">{{ __('auth.social_account') }}</p>
                <div class="social-logins">
                    <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-main btn-black w-100 mb-1"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="{{ url('/auth/redirect/google') }}" class="btn btn-main btn-black w-100"><i class="fab fa-google"></i> Google</a>
                </div>

                <p class="login-subtitle border-top mt-3">{{ __('auth.no_account') }}</p>
                <a href="{{ url('/register') }}" class="btn btn-transparent w-100">Register</a>
            </div>
        </div>
    </div>
</section>
@endsection
