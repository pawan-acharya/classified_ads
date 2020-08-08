@extends('layouts.app')

@section('content')
<section id="search-page">
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-head"> {{ __('ads.search.find_a_rental') }} </h1>
            <div class="col-md-12 form-wrapper main-search">
            <h6 class="text-white"><span class="text-theme-dark font-weight-bold">{{ number_format(\App\Ad::where('plan_id', '!=', null)->count())}}</span> {{ __('welcome.available_vehicle') }}</h6>
                <form>
                    <div class="form-row input-group">
                        <div class="form-group selectdiv align-middle col-md-2 my-auto">
                            <label for="category" class="col-form-label ">{{ __('ads.category') }}</label>
                            <select id="search-category" class="form-control @error('category') is-invalid @enderror" name="category">
                                <option value="" selected disabled></option>
                                <option value=""> {{ __('ads.all') }}</option>
                                @foreach (__('ads.category_options') as $key => $category)
                                <option value="{{$key}}" @if (request()->get('category') === $key) selected @endif> {{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group selectdiv col-md-2 my-auto">
                            <label for="brand" class="col-form-label ">{{ __('ads.brand') }}</label>
                            <select id="search-brand" class="form-control @error('brand') is-invalid @enderror" name="brand">
                                <option value="" selected disabled></option>
                                <option value=""> {{ __('ads.all') }}</option>
                                @foreach (__('ads.brand_options') as $key => $brand)
                                <option value="{{$key}}" @if (request()->get('brand') === $key) selected @endif> {{$brand}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group selectdiv col-md-2 my-auto">
                            <label for="model" class="col-form-label ">{{ __('ads.model') }}</label>
                            <select id="search-model" class="form-control @error('model') is-invalid @enderror" name="model">
                                <option value="" selected disabled></option>
                                <option value=""> {{ __('ads.all') }}</option>
                                <option value="" >{{ __('ads.select_model') }}</option>        
                            </select>
                        </div>
                        <div class="form-group selectdiv col-md-2 my-auto">
                            <label for="province" class="col-form-label ">{{ __('auth.province') }}</label>
                            <select id="search-province" class="custom-select form-control @error('province') is-invalid @enderror"  name="province" >
                                <option value="" selected disabled></option>
                                <option value=""> {{ __('ads.all') }}</option>
                                @foreach (__('auth.province_options') as $key => $province)
                                    <option value="{{$key}}" @if (request()->get('province') === $key) selected @endif> {{$province}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group selectdiv col-md-1 col-5 my-auto">
                            <label for="from_payment" class="col-form-label ">{{ __('ads.payment') }}</label>
                            <select class="custom-select form-control" id="search-from-payment" name="from_payment">
                            <option value="" selected disabled></option>
                            <option value=""> {{ __('ads.all') }}</option>
                            @foreach ($payment_options as  $key => $amount)
                                <option value="{{$key}}" @if ((integer)request()->get('from_payment') == $key) selected @endif> {{$amount}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group selectdiv my-auto">
                            <label class="col-form-label mt-4 mx-1">{{ __('ads.to') }}</label>
                        </div>
                        <div class="form-group selectdiv col-md-1 col-5 my-auto">
                            <label for="to_payment" class="col-form-label "> </label>
                            <select class="custom-select form-control " id="search-to-payment" name="to_payment">
                            <option value="" selected disabled></option>
                            <option value=""> {{ __('ads.all') }}</option>
                            @foreach ($payment_options as $key => $amount)
                                <option value="{{$key}}" @if ((integer)request()->get('to_payment') === $key) selected @endif> {{$amount}}</option>
                            @endforeach
                            </select>
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
        <div class="section-header">
            <div class="initial-line"></div>
            <p class="heading-text">
            <span>{{ __('ads.search_results') }}</span>
            </p>
        </div>
        <div class="col-12">
            {{ $ads->appends(request()->input())->links() }}    
        </div>
        <div class="row">
            <div class="col-12 col-sm-3 search-sidebar form-wrapper d-none d-md-block"">
                <div class="card mb-3 p-4">
                    <div class="card-header filter-header">{{ __('ads.search.new_search') }}</div>
                    <div class="card-body"> 
                        <form method="GET" action="{{ route('ads.index') }}" enctype="multipart/form-data">
                            <div class="form-group form-row">
                                <div class="col-md-12">
                                    <label for="category" class="col-form-label ">{{ __('ads.category') }}</label>
                                    <select id="category" class="form-control" name="category">
                                        <option value="" selected disabled></option>
                                        <option value=""> {{ __('ads.all') }}</option>
                                        @foreach (__('ads.category_options') as $key => $category)
                                            <option value="{{$key}}" @if (request()->get('category') === $key) selected @endif> {{$category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="brand" class="col-form-label ">{{ __('ads.brand') }}</label>
                                    <select id="brand" class="form-control" name="brand">
                                        <option value="" selected disabled></option>
                                        <option value=""> {{ __('ads.all') }}</option>
                                        @foreach (__('ads.brand_options') as $key => $brand)
                                            <option value="{{$key}}" @if (request()->get('brand') === $key) selected @endif> {{$brand}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="model" class="col-form-label ">{{ __('ads.model') }}</label>
                                    <select id="model" class="form-control" name="model">
                                        <option value="" selected disabled></option>
                                        <option value=""> {{ __('ads.all') }}</option>      
                                        <option value="" >{{ __('ads.select_model') }}</option>        
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="province" class="col-form-label ">{{ __('auth.province') }}</label>
                                    <select class="custom-select form-control " id="province" name="province">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach (__('auth.province_options') as $key => $province)
                                        <option value="{{$key}}" @if (request()->get('province') === $key) selected @endif> {{$province}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="from_payment" class="col-form-label ">{{ __('ads.payment') }}</label>
                                    <select class="custom-select form-control" id="from_payment" name="from_payment">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($payment_options as  $key => $amount)
                                        <option value="{{$key}}" @if ((integer)request()->get('from_payment') == $key) selected @endif> {{$amount}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="label-inbetween">
                                    {{ __('ads.to') }}
                                </div>
                                <div class="col-6">
                                    <label for="from_payment" class="col-form-label "> </label>
                                    <select class="custom-select form-control " id="to_payment" name="to_payment">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($payment_options as $key => $amount)
                                        <option value="{{$key}}" @if ((integer)request()->get('to_payment') === $key) selected @endif> {{$amount}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="from_vehicle_year" class="col-form-label" style="width:150px">{{ __('ads.vehicle_year') }}</label>
                                    <select class="custom-select form-control" id="from_vehicle_year" name="from_vehicle_year">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($vehicle_year_options as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('from_vehicle_year') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="label-inbetween">
                                    {{ __('ads.to') }}
                                </div>
                                <div class="col-6">
                                    <label for="to_vehicle_year" class="col-form-label "> </label>
                                    <select class="custom-select form-control " id="to_vehicle_year" name="to_vehicle_year">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($vehicle_year_options as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('to_vehicle_year') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="from_contract_duration" class="col-form-label" style="width:180px">{{ __('ads.lease.remaining_month') }}</label>
                                    <select class="custom-select form-control" id="from_contract_duration" name="from_contract_duration">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($contract_duration_options as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('from_contract_duration') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="label-inbetween">
                                    {{ __('ads.to') }}
                                </div>
                                <div class="col-6">
                                    <label for="to_contract_duration" class="col-form-label "> </label>
                                    <select class="custom-select form-control " id="to_contract_duration" name="to_contract_duration">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($contract_duration_options as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('to_contract_duration') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="from_remaining_monthly_kms" class="col-form-label" style="width:200px">{{ __('ads.remaining_monthly_kms') }}</label>
                                    <select class="custom-select form-control" id="from_remaining_monthly_kms" name="from_remaining_monthly_kms">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($remaining_monthly_kms as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('from_remaining_monthly_kms') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="label-inbetween">
                                    {{ __('ads.to') }}
                                </div>
                                <div class="col-6">
                                    <label for="to_remaining_monthly_kms" class="col-form-label "> </label>
                                    <select class="custom-select form-control " id="to_remaining_monthly_kms" name="to_remaining_monthly_kms">
                                    <option value="" selected disabled></option>
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach ($remaining_monthly_kms as $key => $value)
                                        <option value="{{$key}}" @if ((integer)request()->get('to_remaining_monthly_kms') === $key) selected @endif> {{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-round">{{ __('ads.search.new_search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col">
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
                            <div class= "row"><span class="font-weight-bold">{{ __('ads.results') }}</span>&nbsp;{{$ads->firstItem()}} - {{$ads->lastItem()}} {{ __('ads.of') }} {{$ads->total()}}</div>
                            <div class= "row"><span class="font-weight-bold">{{ __('ads.page') }}</span>&nbsp;{{$ads->currentPage()}} {{ __('ads.of') }} {{ceil($ads->total()/$ads->perPage())}}</div>
                        </div>
                    </div>
                    @php($index = 0)
                    @foreach ($ads as $ad)
                    @if($index == 5)
                    <div class="col-md-6 even pl-5">
                        <img src="https://via.placeholder.com/200x200" />
                    </div>
                    @php($index++)
                    @endif
                    @include('ads.partials.ad',['parent' => 'index'])
                    @php($index++)
                    @endforeach
                </div>
            </div>
            <div class="col-12">
                {{ $ads->appends(request()->input())->links() }}
            </div>
        </div>
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
</script>
@endpush
@endsection
