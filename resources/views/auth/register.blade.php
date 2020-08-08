@extends('layouts.app')

@section('content')
<section id="register-page" class="primary-background">  
    <h1 class="section-head">{{ __('auth.create_my_account') }}</h1>
    <div class="container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row">
                <div class="col-md-4 p-5">
                    <div class="image-wrapper">
                        <img class="" src="../images/short-logo.png"/>
                        <h1 class="text-weight-bold text-white">{{ __('auth.enter_information') }}</h1>
                    </div>
                </div>
                <div class="col-md-8 p-5">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="first_name" class="col-form-label">{{ __('auth.first_name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="col-form-label">{{ __('auth.name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="home_phone" class="col-form-label">{{ __('auth.home_phone') }}</label>
                                <input id="home_phone" type="text" class="form-control @error('home_phone') is-invalid @enderror" name="home_phone" value="{{ old('home_phone') }}" required autocomplete="home_phone" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$">

                                @error('home_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="mobile_phone" class="col-form-label">{{ __('auth.mobile_phone') }}</label>
                                <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone" value="{{ old('mobile_phone') }}" autocomplete="mobile_phone" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$">

                                @error('mobile_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="correspondence_language" class="col-form-label">{{ __('auth.correspondence_language') }}</label>
                                <select class="custom-select form-control @error('correspondence_language') is-invalid @enderror" id="correspondence_language" name="correspondence_language" required >
                                    <option value="French" @if (old('correspondence_language') === 'French') selected @endif>{{ __('auth.French') }}</option>
                                    <option value="English" @if (old('correspondence_language') === 'English') selected @endif>{{ __('auth.English') }}</option>
                                </select>
                                @error('correspondence_language')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                            <input type="checkbox" name="consent" id ="consent" @if (old('consent') === "on") checked @endif required> <label class="checkbox-inline">{{ __('auth.consent') }}</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="city" class="col-form-label">{{ __('auth.city') }}</label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" >

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="province" class="col-form-label">{{ __('auth.province') }}</label>
                                <select class="custom-select form-control @error('province') is-invalid @enderror" id="province" name="province" required >
                                <option value="" selected disabled></option>
                                @foreach (__('auth.province_options') as $key => $province)
                                    <option value="{{$key}}" @if (old('province') === $key) selected @endif> {{$province}}</option>
                                @endforeach
                                </select>
                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="postal_code" class="col-form-label">{{ __('auth.postal_code') }}</label>
                            <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" required autocomplete="postal_code" pattern="^(?:[a-zA-Z]\d[a-zA-Z][ -]?\d[a-zA-Z]\d)$">

                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="password" class="col-form-label">{{ __('auth.password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="col-form-label">{{ __('auth.password_confirm') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email" class="col-form-label">{{ __('auth.email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="heard_about" class="col-form-label">{{ __('auth.heard_about') }}</label>
                                <select class="custom-select form-control @error('heard_about') is-invalid @enderror" id="heard_about" name="heard_about" require>
                                    <option value="" selected disabled></option>
                                    @foreach (__('auth.heard_about_options') as $key => $option)
                                        <option value="{{$key}}" @if (old('heard_about') === $key) selected @endif> {{$option}}</option>
                                    @endforeach
                                    </select>

                                @error('heard_about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="security_question" class="col-form-label">{{ __('auth.security_question') }}</label>
                                <input id="security_question" type="security_question" class="form-control @error('security_question') is-invalid @enderror" name="security_question" value="{{ old('security_question') }}" required autocomplete="security_question">

                                @error('security_question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="security_answer" class="col-form-label">{{ __('auth.security_answer') }}</label>
                                <input id="security_answer" type="text" class="form-control @error('security_answer') is-invalid @enderror" name="security_answer" value="{{ old('security_answer') }}" autocomplete="security_answer">

                                @error('security_answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                </div>
                <div class="col-md-12 text-center bg-theme-light py-4"> 
                    <button type="submit" class="btn btn-primary btn-bg-theme-dark btn-round">
                        {{ __('auth.create_an_account') }}
                    </button>    
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts-vars')
<script>
    var validationRequired = "{{ __('auth.required') }}";
    var validationPattern = "{{ __('auth.invalid_info') }}";
</script>
@endpush

@endsection
