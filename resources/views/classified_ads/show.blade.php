
@extends('layouts.app')

@section('content')
<section id="long-ad-section" class="ads-display mt-2">
    <div class="container">
        <img src="{{ asset('images/long-ad.png') }}" width="100%" />
    </div>
</section>
<section id="single-ad-page" class="my-1">
    <div class="container">
        <div class="row ad-single mb-4">
            <div class="col-md-9 col-12">
                @include('classified_ads.partials.main')
                @include('classified_ads.partials.description')
            </div>
            <div class="col-md-3">
                <div class="contact-div">
                    <h2>{{$classified_ad->user->first_name}}{{$classified_ad->user->name}}</h2>
                    <div class="reveal-number">
                        <p class="phonenumber">{{$classified_ad->user->home_phone}}</p>
                        <a class="revealphone">Reveal Host Contact</a>
                    </div>
                    <form>
                        <textarea id="message-host" name="message-host" rows="4">Your Message to the Host.</textarea>
                        <button type="submit" class="btn btn-primary btn-message">
                            <i class="fas fa-comment-alt"></i>{{ __('ads.contact_announcer') }}
                        </button>   
                    </form>
                </div>
                <img src="{{ asset('images/sidebar-ad.png') }}" width="100%" class="mt-2"/>
            </div>
        </div>
        <div class="single-page-featured">
            <h3>Featured Listing</h3>
            <h5>Best quarter list of ad’s for your choice</h5>
            <div class="owl-carousel">
            @foreach ($featured_ads as $classified_ad)
            <a class="item featured-ads-item" href="/classified_ads/{{$classified_ad->id}}">
                <div class="aspect-ratio-box">
                @if (!empty($classified_ad->file))
                    <img src="{{ $classified_ad->file->getPathAttribute() }}" style="max-width: 100%;" />
                @else
                    <img src="{{ asset('images/placeholder_car.png') }}" style="max-width: 100%;" />
                @endif
                </div>
                <h6>{{$classified_ad->title}}</h6>
                <h6 class="ads-item-price">${{$classified_ad->price}}/ night</h6>
                <h6>{{$classified_ad->location?? ''}}</h6>
            </a>
            @endforeach
            </div>
        </div>
    </div>
</section>

@push('js')
<script type="text/javascript">
    function addToFavoutires(id){
            url= "{{route('wishlists.create', ':classified_ad_id')}}";
            url= url.replace(':classified_ad_id', id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
            })
            .done(function( data ) {
            });
    }
</script>

@endpush

@endsection




