

@extends('layouts.app')

@section('content')

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

</script>
@endpush
@endsection
