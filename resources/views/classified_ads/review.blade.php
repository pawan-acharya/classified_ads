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
    <div class="container review-box">
        <div class="row ad-single mb-4">
            <div class="col-md-9 col-12">
                @include('classified_ads.partials.main')
                @include('classified_ads.partials.description')
                <div class="featured-ads-items">
                    <h2>Ad's Recently Visited</h2>
                    <div class="row">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col-sm-2 featured-ads-item">
                            <div class="aspect-ratio-box">
                                <img src="{{ asset('images/tree-snow.jpg') }}" width="100%">
                            </div>
                            <h6>Real estate Broker</h6>
                            <h6 class="ads-item-price">$40 / night</h6>
                        </div>
                    @endfor
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-div">
                    <h2>{{$classified_ad->user->first_name}}{{$classified_ad->user->name}}</h2>
                    <div class="reveal-number">
                        <span>Phone Number</span>
                        <p class="phonenumber">{{$classified_ad->user->home_phone}}</p>
                        <a class="revealphone">Reveal Host Contact</a>
                    </div>
                    @if (Auth::check() )
                        @if ($classified_ad->user->id != Auth::id())
                            <form action="{{route('feedbacks.create',['classified_ad'=> $classified_ad->id])}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea id="message-host" name="message" rows="4">Your Message to the Host...</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-message">
                                    <i class="fas fa-comment-alt"></i><span>{{ __('ads.contact_announcer') }}</span>
                                </button> 
                            </form>
                        @endif
                    @endif
                </div>
                <img src="{{ asset('images/sidebar-ad.png') }}" width="100%" class="mt-2"/>
            </div>
        </div>
    </div>
</section>

@endsection
