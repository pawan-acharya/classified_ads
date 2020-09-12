<div class= "col-md-6">
    @if($parent == 'index')
    <a href= "{{ route('classified_ads.show',$ad->id ) }}" class="card ad  {{$index%2==0?'odd':'even'}} {{ $ad->is_special ? 'special': ''}}">
    @else
    <a href= "{{ route('classified_ads.show',$ad->id ) }}" class="card ad">
    @endif
        <div class="card-header">{{$ad->title}}</div>
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
                    <button type="button" id="remove-from-whislists" class="btn btn-danger btn-sm" data-ad_id="{{$ad->id}}"> {{ __('ads.remove_wishlist') }} </button>
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
