

@extends('layouts.app')

@section('content')
<section id="search-page-body">
    <div class="search-body-head pt-2 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-5 ml-auto">
                    <form>
                        <div class="form-row input-group">
                            <div class="form-group selectdiv col-md-3 my-auto">
                                <label for="brand" class="col-form-label ">{{ __('ads.sort_by') }}</label>
                                <select class="form-control filters" id="sort_by" name="order_by">
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.sort_by_options') as $key => $option)
                                    <option value="{{ request()->fullUrlWithQuery(['sort_by' => $key]) }}" @if ( app('request')->input('sort_by') == $key) selected @endif> {{$option}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group selectdiv col-md-3 my-auto">
                                <label for="brand" class="col-form-label ">{{ __('ads.order') }}</label>
                                <select class="form-control filters" id="order" name="order_by">
                                    <option value="" selected disabled></option>
                                    @foreach (__('ads.order_options') as $key => $option)
                                    <option value="{{ request()->fullUrlWithQuery(['order' => $key]) }}" @if (app('request')->input('order') == $key) selected @endif> {{$option}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="row col-md-9 mb-4">
            @php($index = 0)
            @foreach ($classified_ads as $classified_ad)
            @include('classified_ads.partials.classified_ad',['parent' => 'index'])
            @php($index++)
            @endforeach
            </div>
            <div class="col-md-3 as">
                <img src="{{ asset('images/sidebar-ad.png') }}" width="100%" />
                <img src="{{ asset('images/sidebar-ad2.png') }}" width="100%" style="display:block !important;" />
                <img src="{{ asset('images/sidebar-ad3.png') }}" width="100%" style="display:block !important;" />
                <img src="{{ asset('images/sidebar-ad4.png') }}" width="100%" style="display:block !important;" />
            </div>
            <div class="col-12">
        	   {{ $classified_ads->appends(request()->input())->links() }} 
            </div>
        </div>
        <div class="featured-ads-items">
            <h2>Ad's Recently Visited</h2>
            <div class="row">
            @for ($i = 0; $i < 5; $i++)
                <div class="col-sm-2 featured-ads-item">
                    <div class="aspect-ratio-box">
                        <img src="{{ asset('images/tree-snow.jpg') }}" width="100%">
                    </div>
                    <h6>Real estate Broker</h6>
                    <h6 class="ads-item-price">$40 / night</h6>
                </div>
            @endfor
            </div>
        </div>
    </div>
</section>
<section id="long-ad-section" class="ads-display">
    <div class="container">
        <img src="{{ asset('images/long-ad.png') }}" width="100%" />
    </div>
</section>
    
@push('scripts-vars')
    <script>
        var options ={!! json_encode(__('ads.model_options')) !!};
        var old_model = '{{request()->get('model')}}';
    </script>
@endpush

@push('js')
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    (function($) {
        $('body').on('change', '.filters', function () {
            var that = $(this);
            console.log(that.val());
            window.location.href = that.val();
        }); 
    })(jQuery);
});

    function initialize() {
      var input = document.getElementById('search-ad-location');
      new google.maps.places.Autocomplete(input);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endpush
@endsection
