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
                    <div class= "row"> <div class= "col-12 mt-2">
                        ${{ $classified_ad->price }}
                        @if($classified_ad->price_for)- {{ $classified_ad->price_for }}@endif
                    </div></div>
                    <div class= "row"> <div class= "col-7">{{$classified_ad->location}}</div> </div>
                    <?php 
                        $secondary_prices= $classified_ad->category->form_items()->where('type', 'secondary_price')->get()
                    ?>
                    @foreach ($secondary_prices as $secondary_price)
                        <div class= "row"> <div class= "col-7">{{$secondary_price->name}}:</div> <div class= "col-5"> ${{json_decode($classified_ad->form_values, TRUE)[$secondary_price->id]}} </div></div>
                    @endforeach
                    <?php 
                        $activities= $classified_ad->category->form_items()->where('type', 'activity')->get()
                    ?>
                    @foreach ($activities as $activity)
                        <div class= "row"> 
                            <div class= "col-7">
                                @foreach ($activity->children as $child)
                                    @if (array_key_exists($child->id, json_decode($classified_ad->form_values, TRUE)))
                                        <img src="{{asset('storage')}}/{{$child->logo}}" style="height: 15px;">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    {{-- 
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
