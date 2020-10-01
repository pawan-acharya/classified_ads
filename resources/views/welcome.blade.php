@extends('layouts.app')

@section('content')

<section id="intro">
  <div class="container">
    <h2>Categories</h2>
    <div class="row category-collection">
      <div class="col-sm-2">
        <a class="category-item h-100" style="background: url('{{ asset('images/campfire.jpg') }}') center center;background-size: cover;">
          <div class="category-item-content">
            <i class="fas fa-campground"></i>
            <h5 class="cateogory-item-title">Camping</h5>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a class="category-item h-50 mb-2" style="background: url('{{ asset('images/chalet.jpg') }}') center center;background-size: cover;">
          <div class="category-item-content">
            <i class="fas fa-campground"></i>
            <h5 class="cateogory-item-title">Chalet</h5>
          </div>  
        </a>
        <a class="category-item h-50" style="background: url('{{ asset('images/rv-trailer.jpg') }}') center center;background-size: cover;">
          <div class="category-item-content">
            <i class="fas fa-campground"></i>  
            <h5 class="cateogory-item-title">RV & Trailer</h5>
          </div> 
        </a>
      </div>
      <div class="col-sm-2">
        <a class="category-item h-100" style="background: url('{{ asset('images/campfire.jpg') }}') center center;background-size: cover;">
          <div class="category-item-content">
            <i class="fas fa-campground"></i>    
            <h5 class="cateogory-item-title">Lodging</h5>
          </div>
        </a>
      </div>
      <div class="col-sm-5">
        <a class="category-item h-50" style="background: url('{{ asset('images/bbq.jpg') }}') center center;background-size: cover;">
          <div class="category-item-content">
            <i class="fas fa-campground"></i>    
            <h5 class="cateogory-item-title">Packages & Activities</h5>
          </div>
        </a>
        <div class="row h-50 m-0 mt-2">
          <div class="col-sm-5 p-0">
            <a class="category-item h-100" style="background: url('{{ asset('images/campfire.jpg') }}') center center;background-size: cover;">
              <div class="category-item-content">
                <i class="fas fa-campground"></i>    
                <h5 class="cateogory-item-title">Items for Sales</h5>
              </div>
            </a>
          </div>
          <div class="col-sm-7 p-0 pl-2">
            <a class="category-item h-100" style="background: url('{{ asset('images/campfire.jpg') }}') center center;background-size: cover;">
              <div class="category-item-content">
                <i class="fas fa-campground"></i>  
                <h5 class="cateogory-item-title">Services</h5>
    </div>
    <div class="col-md-12 form-wrapper main-search">
      <h6 class="text-white"><span class="text-theme-dark font-weight-bold">{{ number_format(\App\Ad::where('plan_id', '>', 0)->count())}}</span> {{ __('welcome.available_vehicle') }}</h6>
      <form method="GET" action="{{ route("classified_ads.index") }}">
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
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="home-featured-ads">
  <div class="container mx-auto">
    <div class="section-header">
        <h2>Featured Ads</h2>
        <p>Best curated ads and recommendation</p>
<section id="star-vehicles">
    <div class="container mx-auto">
        <div class="section-header">
            <div class="initial-line" style="width:17%;"></div>
            <p class="heading-text">
              <span>{{ __('welcome.star_vehicles') }}</span>
            </p>
         </div>

        <div class="row justify-content-between">
            <div class="col-md-9">
              <!-- Top content -->
              <div class="top-content">
                <div class="container-fluid">
                    <div id="carousel-home" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner row w-100 mx-auto" role="listbox">
                          @foreach ($featured_ads as $classified_ad)
                            <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-4 active">
                              <div class="effective-payment-wrapper">
                                <div class="row effective-payment bg-white pt-5">
                                  @if (!empty($classified_ad->file))
                                      <img src="{{ $classified_ad->file->getPathAttribute() }}" style="max-width: 100%;" />
                                  @else
                                      <img src="{{ asset('images/placeholder_car.png') }}" style="max-width: 100%;" />
                                  @endif
                                    <div class="col-md-6">
                                        <h6>{{$classified_ad->title}}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="text-green">{{$classified_ad->price}}<sup>$</sup></h3>
                                    </div>
                                </div>
                                <div class="row effective-payment bg-theme-dark text-white justify-content-center py-5">
                                      <h6>{{$classified_ad->location?? ''}}</h6>
                                      <h5></h5>
                                      <h5></h5>
                                      <a type="button"  href= "{{ route('classified_ads.show',$classified_ad->id ) }}" class="btn btn-secondary btn-round ml-2">{{ __('welcome.more_details') }}</a>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carousel-home" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-home" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
                <div class="my-3">
                    <img src="https://via.placeholder.com/230" />
                </div>
                <div class="my-3">
                    <img src="https://via.placeholder.com/230x65" />
                </div>
                <div class="my-3">
                    <img src="https://via.placeholder.com/230" />
                </div>
            </div>
    </div>
    <div class="row mb-3">
      <div class="col-sm-9 featured-ads-items">
        <div class="row">
        @for ($i = 0; $i < 7; $i++)
          <div class="col-sm-3 featured-ads-item">
            <div class="aspect-ratio-box">
                <img src="{{ asset('images/bbq.jpg') }}" width="100%">
            </div>
            <h6>Real estate Broker</h6>
            <h6 class="ads-item-price">$40 / night</h6>
          </div>
        @endfor
        </div>
      </div>
      <div class="col-sm-3 featured-ads-image" style="background: url('{{ asset('images/campfire.jpg') }}') center center; height:400px; background-size: cover;">
        <div class="featured-ads-image-content">
          <div class="featured-ads-image-title">
            <i class="fas fa-campground"></i>    
            <h5 class="cateogory-item-title">Best Camping near me</h5>
            <h6 class="cateogory-item-subtitle">Grasslands National Park</h6>
          </div>
          <div class="featured-ads-image-cta">
            <h5 class="cateogory-item-title">Explore Camping</h5>
            <a class="cateogory-item-button"><i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9 featured-ads-items">
        <div class="row">
        @for ($i = 0; $i < 7; $i++)
          <div class="col-sm-3 featured-ads-item">
            <div class="aspect-ratio-box">
                <img src="{{ asset('images/tree-snow.jpg') }}" width="100%">
            </div>
            <h6>Real estate Broker</h6>
            <h6 class="ads-item-price">$40 / night</h6>
          </div>
        @endfor
        </div>
      </div>
      <div class="col-sm-3 featured-ads-image" style="background: url('{{ asset('images/chalet.jpg') }}') center center; height:400px; background-size: cover;">
        <div class="featured-ads-image-content">
          <div class="featured-ads-image-title">
            <i class="fas fa-campground"></i>    
            <h5 class="cateogory-item-title">Best Camping near me</h5>
            <h6 class="cateogory-item-subtitle">Grasslands National Park</h6>
          </div>
          <div class="featured-ads-image-cta">
            <h5 class="cateogory-item-title">Explore Camping</h5>
            <a class="cateogory-item-button"><i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="long-ad-section" class="ads-display">
  <div class="container">
    <img src="{{ asset('images/long-ad.png') }}" width="100%" />
  </div>
</section>
@endsection

@push('scripts-vars')
    <script>
        var options ={!! json_encode(__('ads.model_options')) !!};
        var old_model = '{{old('model')}}';
    </script>
@endpush
