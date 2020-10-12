@extends('layouts.app')

@section('content')
<section id="single-ad-page" class="page review-page">
    <div class="container">
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
        <div class="row justify-content-center mb-3">
            <div class="row col-md-12 single-ad-tools ">
                <div class="col-md-6"> 
                    <a href="{{ route('classified_ads.edit', $classified_ad->id) }}" class="btn btn-primary btn-round ">
                        {{ __('ads.review.go_back_and_edit') }}
                    </a>    
                </div>
                @if (!($classified_ad->plan_id && $classified_ad->plan->ends_at> date('Y-m-d')))
                    <div class="col-md-6"> 
                        <a href="{{ route('payment.plans_form' , $classified_ad->id) }}" class="btn btn-secondary btn-round float-right">
                            {{ __('ads.review.approve_and_continue') }}
                        </a>    
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="text-center section-head">{{ __('ads.review.title') }}</h2>
    </div>
    <div class="container review-box">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center section-head">{{$classified_ad->title}}</h1>
                <div class="row ad-single">
                    <div class="col-md-6 col-12">
                        @include('classified_ads.partials.main')
                    </div>

                    <div class="col-md-6 col-12">
                        @include('classified_ads.partials.description')
                    </div>
                </div>
        </div>
    </div>
</section>

@endsection
