<div class="row featured-image">
    <div class="col-md-12 image">
    @if (!empty($ad->file))
        <img src="{{ $ad->file->getPathAttribute() }}" width="100%"/>
    @else
        <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
    @endif
    </div>
</div>

<div class="row thumbnails no-print">
    @foreach ($ad->files as $file)
    <div class="col-md-4 col-4 thumbnail">
        <div class="aspect-ratio-box">
            <img src="{{ $file->getPathAttribute() }}" width="100%"/>
        </div>
    </div>
    @endforeach
</div>

<div class="row single-ad-description">
    <div class="col-md-2">
        <img src="{{ asset('images/short-logo.png') }}" />
    </div>
    <div class="card col-md-10">
        <div class="card-body text-white">
            @php($province_langkey = 'auth.province_options.'.$ad->user->province)
            <div class= "row"> <div class= "col-md-7">{{ __('ads.location') }} :</div> <div class= "col-md-5"> {{Str::ucfirst($ad->user->city)}}, {{ __($province_langkey) }}</div></div>
            <div class= "row"> <div class= "col-md-7">{{ __('ads.incentive') }} :</div> <div class= "col-md-5"> {{$ad->lease->formatted_incentive_amount}}</div></div>
            <div class= "row"> <div class= "col-md-7">{{ __('ads.remaining_kms') }} :</div> <div class= "col-md-5"> {{$ad->remaining_monthly_kms}} </div></div>
            <div class= "row"> <div class= "col-md-7">{{ __('ads.payment') }} :</div> <div class= "col-md-5"> {{$ad->formatted_payment}} </div></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <h5 class="ad-description-title"> {{ __('ads.ad_description') }} </h5>
        <p class="ad-description-text"> {{ $ad->description }} </p>
    </div>
    <div class="col-md-5 no-print">
        <img src="https://via.placeholder.com/200" />
    </div>
</div>