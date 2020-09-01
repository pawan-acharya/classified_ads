<div class="row featured-image">
    <div class="col-md-12 image">
    @if (!empty($classified_ad->file))
        <img src="{{ $classified_ad->file->getPathAttribute() }}" width="100%"/>
    @else
        <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
    @endif
    </div>
</div>

<div class="row thumbnails no-print">
    @foreach ($classified_ad->files as $file)
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
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <h5 class="ad-description-title"> {{ __('ads.ad_description') }} </h5>
        <p class="ad-description-text"> {{ $classified_ad->descriptions }} </p>
    </div>
    <div class="col-md-5 no-print">
        <img src="https://via.placeholder.com/200" />
    </div>
</div>