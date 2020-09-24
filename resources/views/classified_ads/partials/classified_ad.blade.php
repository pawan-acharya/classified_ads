<div class= "col-md-12">
    <a href= "{{ route('classified_ads.show',$classified_ad->id ) }}" class="card ad">
        <div class="card-body">
            <div class= "row">
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
                    <div class= "mt-2">{{ $classified_ad->title }}</div>
                    <div class="details pricings">
                        <ul class="d-flex price-list">
                            <li class="price-list-item">
                                <h5>
                                    {{$classified_ad->price}}  {{$classified_ad->price_for?'PER: ':''}} {{$classified_ad->price_for}}
                                </h5>
                            </li>
                        </ul>
                    </div>
                    <div class="ad-description-wrapper">
                        
                        <p class="ad-description-text"> {{ $classified_ad->descriptions }} </p>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@push('js')
    <script type="text/javascript">
    </script>
@endpush
