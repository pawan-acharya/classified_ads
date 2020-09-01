

@extends('layouts.app')

@section('content')
<section id="search-page">
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-head"> {{ __('ads.search.find_a_rental') }} </h1>
            <div class="col-md-12 form-wrapper main-search">
            <h6 class="text-white"><span class="text-theme-dark font-weight-bold">{{ number_format(\App\Ad::where('plan_id', '!=', null)->count())}}</span> {{ __('welcome.available_vehicle') }}</h6>
               
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
        </div>
        <div class="row">
            <div class="col-12 col-sm-3 search-sidebar form-wrapper d-none d-md-block"">
                <div class="card mb-3 p-4">
                    <div class="card-header filter-header">{{ __('ads.search.new_search') }}</div>
                    <div class="card-body"> 
                        
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
                       		
                        </div>
                    </div>
                    <div class="row col-12 search-body-head pt-2 pb-3">
                    	<table class="table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">First</th>
						      <th>Category Name</th>
						      <th>
						      	View
						      </th>
						    </tr>
						  </thead>
						  <tbody>
						   	@foreach ($classified_ads as $classified_ad)
	                			<tr>
	                				<td>
	                					#
	                				</td>
	                				<td>
	                					{{$classified_ad->title}}
	                				</td>
	                				<td>
	                					{{$classified_ad->category->category_name}}
	                				</td>
	                				<th>
	                					<a href="{{route('classified_ads.show', ['classified_ad'=>$classified_ad->id])}}">{{$classified_ad->title}}
                                        </a>
	                				</th>
	                			</tr>
		       			 	@endforeach
						  </tbody>
						</table>
                    	
                    </div>
                    
                </div>
            </div>
            <div class="col-12">
            	
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

</script>
@endpush
@endsection
