@extends('layouts.app')

@section('content')

<section id="contact-intro">
    <h1 class="section-head">{{ __('pages.contact') }}</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-7 form-wrapper">
                <form method="POST" action="{{ route('contact.mail') }}">
                    <h4>{{ __('pages.detail_information') }}</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ __('pages.successful') }}
                        </div>
                    @endif
                   
                        @csrf
                        <div class="form-group mb-2">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="{{ __('pages.contact_form.name') }}">
                        </div>
                        <div class="form-group mb-2">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" placeholder="{{ __('pages.contact_form.email')}}">
                        </div>
                        <div class="form-group mb-2">
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="{{ __('pages.contact_form.subject') }}">
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="5" placeholder="{{ __('pages.contact_form.message') }}"></textarea>
                        </div>
                        <button type="submit" value="Submit" class="btn btn-primary btn-round d-flex justify-content-center mx-auto mt-4">{{ __('pages.to_send') }}</button>
                    </form>
            </div>
            <div class="col-md-5">
                <div class="contact-page-logo px-4 mx-auto mb-auto">
                    <img src="{{ asset('images/logo-footer.png') }}" />
                </div>
                <div class="address">
                    <p>{{ __('pages.address') }} : {{ __('pages.address_text') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
