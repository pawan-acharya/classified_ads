@extends('layouts.app')

@section('content')
<section id="plan-intro">
    <div class="container">
            <h1 class="section-head mb-3">{{ __('payments.payment_title') }}</h1>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row plan-selection">
                <div class="col-md-4 plan-item featured">
                    <div class="plan-image pt-3">
                        <img src="{{ asset('images/payment-arrow-white.png') }}">
                        <h2>1 AD <span class="price">  20$</span></h2>
                    </div>
                    <div class="text-white pt-3">
                        <ul>
                            <li class="mb-0">{{ __('payments.payment_plans.exceptional.feature1') }}</li>
                            <li>{{ __('payments.payment_plans.exceptional.feature2') }}</li>
                        </ul>
                        <div>
                            <h6>{{ __('payments.payment_plans.exceptional.feature3_title') }}</h6>
                            <p>{{ __('payments.payment_plans.exceptional.feature3_body') }}</p>
                        </div>
                    </div>
                    <div class="row exceptional-box">
                        <div class="col-2 my-auto">
                            <h2 class="font-weight-bold">+</h2>
                        </div>
                        <div class="col-10 pl-2">
                            <h6 class="featured">{{ __('payments.payment_plans.exceptional.feature4') }}</h6>
                        </div>
                    </div>
                    <div>
                        <a type="button" class="btn btn-primary btn-round" href="{{route('bulk_payment_form', ['type'=> 'one'])}}">{{ __('payments.payment_link') }}</a>
                    </div>
                </div>
                <div class="col-md-4 plan-item featured">
                    <div class="plan-image pt-3">
                        <img src="{{ asset('images/payment-arrow-white.png') }}">
                        <h2>5 ADs<span class="price">  50$</span></h2>
                    </div>
                    <div class="text-white pt-3">
                        <ul>
                            <li class="mb-0">{{ __('payments.payment_plans.exceptional.feature1') }}</li>
                            <li>{{ __('payments.payment_plans.exceptional.feature2') }}</li>
                        </ul>
                        <div>
                            <h6>{{ __('payments.payment_plans.exceptional.feature3_title') }}</h6>
                            <p>{{ __('payments.payment_plans.exceptional.feature3_body') }}</p>
                        </div>
                    </div>
                    <div class="row exceptional-box">
                        <div class="col-2 my-auto">
                            <h2 class="font-weight-bold">+</h2>
                        </div>
                        <div class="col-10 pl-2">
                            <h6 class="featured">{{ __('payments.payment_plans.exceptional.feature4') }}</h6>
                        </div>
                    </div>
                    <div>
                        <a type="button" class="btn btn-primary btn-round" href="{{route('bulk_payment_form', ['type'=> 'five'])}}">{{ __('payments.payment_link') }}</a>
                    </div>
                </div>
                <div class="col-md-4 plan-item featured">
                    <div class="plan-image pt-3">
                        <img src="{{ asset('images/payment-arrow-white.png') }}">
                        <h2>10 ADs <span class="price">  75$</span></h2>
                    </div>
                    <div class="text-white pt-3">
                        <ul>
                            <li class="mb-0">{{ __('payments.payment_plans.exceptional.feature1') }}</li>
                            <li>{{ __('payments.payment_plans.exceptional.feature2') }}</li>
                        </ul>
                        <div>
                            <h6>{{ __('payments.payment_plans.exceptional.feature3_title') }}</h6>
                            <p>{{ __('payments.payment_plans.exceptional.feature3_body') }}</p>
                        </div>
                    </div>
                    <div class="row exceptional-box">
                        <div class="col-2 my-auto">
                            <h2 class="font-weight-bold">+</h2>
                        </div>
                        <div class="col-10 pl-2">
                            <h6 class="featured">{{ __('payments.payment_plans.exceptional.feature4') }}</h6>
                        </div>
                    </div>
                    <div>
                        <a type="button" class="btn btn-primary btn-round" href="{{route('bulk_payment_form', ['type'=> 'ten'])}}">{{ __('payments.payment_link') }}</a>
                    </div>
                </div>
            </div>
    </div>
</section>

@push('js')

@endpush
@endsection
