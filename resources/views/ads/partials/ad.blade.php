<div class= "col-md-3">
    @if($parent == 'index')
    <a href= "{{ route('classified_ads.show',$ad->title ) }}" class="card ad  {{$index%2==0?'odd':'even'}} {{ $ad->is_special ? 'special': ''}}">
    @else
    <a href= "{{ route('classified_ads.review',$ad->id ) }}" class="card ad">
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
                    <h3 class="profile-ad-title">{{ $ad->title }}</h3>
                    <button type="button" id="remove-from-whislists" class="btn btn-danger btn-sm" data-ad_id="{{$ad->id}}"> {{ __('ads.details') }} </button>
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
