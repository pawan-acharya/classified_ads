<div class= "col-md-6">
    @if($parent == 'index')
    <a href= "{{ route('ads.show',$ad->id ) }}" class="card ad  {{$index%2==0?'odd':'even'}} {{ $ad->is_special ? 'special': ''}}">
    @else
    <a href= "{{ route('ads.show',$ad->id ) }}" class="card ad">
    @endif
        <div class="card-body">
            <div class= "row">
                <div class= "col-12 col-sm-5 ad-image-wrapper">
                    <div class="aspect-ratio-box">
                    @if (!empty($ad->file))
                        <img src="{{ $ad->file->getPathAttribute() }}" width="100%"/>
                    @else
                        <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
                    @endif
                    </div>
                </div>
                <div class= "col-12 col-sm-7 ad-desc-wrapper"> 
                    <div class= "row"> <div class= "col-12 mt-2">{{ $ad->title }}</div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.current_mileage') }}:</div> <div class= "col-5"> {{$ad->lease->contract_kilometers}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.remaining_month') }}:</div> <div class= "col-5"> {{$ad->lease->contract_duration}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.monthly_payment') }}:</div> <div class= "col-5"> {{$ad->lease->monthly_payments_after_taxes}} </div></div>
                    <div class= "row"> <div class= "col-7">{{ __('ads.lease.effective_payment') }}:</div> <div class= "col-5"> <span class="price">{{$ad->formatted_payment}}</span><span>/{{ __('ads.month') }}</span></div></div>
                    @if($parent == 'edit')
                    <button type="button" class="btn btn-secondary btn-sm edit-ad"> {{ __('ads.edit') }} </button>
                    @elseif($parent == 'wishlist')
                    <button type="button" id="remove-from-whislists" class="btn btn-danger btn-sm" data-ad_id="{{$ad->id}}"> {{ __('ads.remove_wishlist') }} </button>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
@if($index == 0)
@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    var x = document.querySelectorAll(".edit-ad");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].onclick = function(event){
            event.preventDefault();
            window.location.href= "{{ route('ads.edit', $ad->id)}}";
        }
    }
});
</script>
@endpush
@endif
