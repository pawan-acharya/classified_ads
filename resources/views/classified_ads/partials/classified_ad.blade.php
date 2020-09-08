<div class= "col-md-6">
    <a href= "{{ route('classified_ads.show',$classified_ad->id ) }}" class="card ad">
        <div class="card-header">{{$classified_ad->title}}</div>
        <div class="card-body">
            <div class= "row">
                <div class= "col-12 col-sm-5 ad-image-wrapper">
                    <div class="aspect-ratio-box">
                    @if (!empty($classified_ad->file))
                        <img src="{{ $classified_ad->file->getPathAttribute() }}" width="100%"/>
                    @else
                        <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
                    @endif
                    </div>
                </div>
                <div class= "col-12 col-sm-7 ad-desc-wrapper"> 
                    {{-- <div class= "row"> <div class= "col-12 mt-2">{{ $classified_ad->title }}</div></div> --}}
                    {{-- <div class= "row"> <div class= "col-7">{{ __('ads.lease.current_mileage') }}:</div> <div class= "col-5"> {{$classified_ad->lease->contract_kilometers}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.remaining_month') }}:</div> <div class= "col-5"> {{$classified_ad->lease->contract_duration}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.monthly_payment') }}:</div> <div class= "col-5"> {{$classified_ad->lease->monthly_payments_after_taxes}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.effective_payment') }}:</div> <div class= "col-5"> <span class="price">{{$classified_ad->formatted_payment}}</span><span>/{{ __('ads.month') }}</span></div></div> --}}
                </div>
            </div>
        </div>
    </a>
</div>
@push('js')
    <script type="text/javascript">
    </script>
@endpush
