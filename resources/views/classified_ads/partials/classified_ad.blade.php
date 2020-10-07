<div class= "col-md-12">
    <a href= "{{ route('classified_ads.show',$classified_ad->id ) }}" class="card ad">
        <div class="card-body">
            <div class= "row listing-ad-wrapper">
                <div class= "col-12 col-sm-4 ad-image-wrapper">
                    <div class="aspect-ratio-box">
                    @if (!empty($classified_ad->file))
                        <img src="{{ $classified_ad->file->getPathAttribute() }}" width="100%"/>
                    @else
                        <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
                    @endif
                    </div>
                </div>
                <div class= "col-12 col-sm-8 ad-desc-wrapper"> 
                    <h3 class="listing-ad-title">{{ $classified_ad->title }}</h3>
                    <div class="ad-description-wrapper">
                        <h6 class="ad-description-text"><span class="ad-listed-date">{{ date('d F, Y', strtotime($classified_ad->created_at)) }} </span><span class="ad-listed-location"> {{ $classified_ad->location }}</span> </h6>
                        <p class="ad-description-text"> {!! Str::limit($classified_ad->descriptions, 250, ' ...') !!}</p>
                    </div>
                    <div class="details pricings">
                        <ul class="d-flex price-list">
                            <li class="price-list-item">
                                <h5>${{$classified_ad->price}}  {{$classified_ad->price_for?'PER: ':''}} {{$classified_ad->price_for}}</h5>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
