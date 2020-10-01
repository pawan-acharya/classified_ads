

@extends('layouts.app')

@section('content')

<section id="search-page">
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-head"> {{ __('ads.search.find_a_rental') }} </h1>
            <div class="col-md-12 form-wrapper main-search">
                <h6 class="text-white"><span class="text-theme-dark font-weight-bold">
                    {{ number_format($classified_ads_count) }} </span>  add found in this search
                </h6>
                <form>
                    <div class="form-row input-group">
                        <div class="form-group selectdiv align-middle col-md-2 my-auto">
                            <label for="category" class="col-form-label ">{{ __('ads.category') }}</label>
                            <select id="search-category" class="form-control @error('category') is-invalid @enderror" name="category">
                                <option value="" selected disabled></option>
                                <option value=""> {{ __('ads.all') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if (request()->get('category') == $category->id) selected @endif> {{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group selectdiv col-md-2 my-auto">
                            <label for="ad-name" class="col-form-label ">Ad Name</label>
                            <input id="search-ad-name" class="form-control @error('brand') is-invalid @enderror" name="ad_name" value="{{request()->get('ad_name')}}">  
                        </div>
                        <div class="form-group selectdiv col-md-2 my-auto">
                            <label for="ad-location" class="col-form-label ">Ad Location</label>
                            <input id="search-ad-location" class="form-control @error('location') is-invalid @enderror" name="location" value="{{request()->get('location')}}">  
                        </div>
                        <div class="form-group buttondiv col-md-1 my-auto text-center">
                            <button type="submit" class="btn btn-primary btn-circular bg-theme m-auto ">GO</button>
                        </div>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</section>
<section id="search-page-body">
    <div class="container">
        <div class="row">
            <div class="row col-12 search-body-head pt-2 pb-3">
                <div class="col-9">
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
                <div class="col-3 mt-2">
                    <div class= "row"><span class="font-weight-bold">{{ __('ads.results') }}</span>&nbsp;{{$classified_ads->firstItem()}} - {{$classified_ads->lastItem()}} {{ __('ads.of') }} {{$classified_ads->total()}}</div>
                    <div class= "row"><span class="font-weight-bold">{{ __('ads.page') }}</span>&nbsp;{{$classified_ads->currentPage()}} {{ __('ads.of') }} {{ceil($classified_ads->total()/$classified_ads->perPage())}}</div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    
                    <div class="row col-12 search-body-head pt-2 pb-3">
                        <div class="col-9">
                            <form>
                                <div class="form-row input-group">
                                   {{--  <div class="form-group selectdiv col-md-3 my-auto">
                                        <label for="brand" class="col-form-label ">{{ __('ads.sort_by') }}</label>
                                        <select class="form-control filters" id="sort_by" name="order_by">
                                            <option value="" selected disabled></option>
                                            @foreach (__('ads.sort_by_options') as $key => $option)
                                            <option value="{{ request()->fullUrlWithQuery(['sort_by' => $key]) }}" @if ( app('request')->input('sort_by') == $key) selected @endif> {{$option}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
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
                        <div class="col-3 mt-2">
           		           <div class= "row"><span class="font-weight-bold">{{ __('ads.results') }}</span>&nbsp;{{$classified_ads->firstItem()}} - {{$classified_ads->lastItem()}} {{ __('ads.of') }} {{$classified_ads->total()}}</div>
                            <div class= "row"><span class="font-weight-bold">{{ __('ads.page') }}</span>&nbsp;{{$classified_ads->currentPage()}} {{ __('ads.of') }} {{ceil($classified_ads->total()/$classified_ads->perPage())}}</div>
                        </div>
                    </div>
                    <div class="row col-12 search-body-head pt-2 pb-3">
                    	
                    </div>
                    @php($index = 0)
                    @foreach ($classified_ads as $classified_ad)
                    @include('classified_ads.partials.classified_ad',['parent' => 'index'])
                    @php($index++)
                    @endforeach
                    
                </div>
            </div>
            <div class="col-12 col-sm-3 search-sidebar form-wrapper d-none d-md-block">
                <div class="card mb-3 p-4">
                    <div class="card-header filter-header">{{ __('ads.search.new_search') }}</div>
                    <div class="card-body"> 
                        
                    </div>
                </div>
            </div>
            <div class="col-12">
        	   {{ $classified_ads->appends(request()->input())->links() }} 
            </div>
        </div>
        <div class="featured-ads-items">
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
        <section id="long-ad-section" class="ads-display">
            <div class="container">
                <img src="{{ asset('images/long-ad.png') }}" width="100%" />
            </div>
        </section>
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
