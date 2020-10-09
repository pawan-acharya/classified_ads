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
    </div>
    <div class="row mb-3">
      <div class="col-sm-9 featured-ads-items">
        <div class="row">
        @foreach ($featured_ads as $classified_ad)
          <a class="col-sm-3 featured-ads-item" href="{{ route('classified_ads.show', $classified_ad->title) }}">
            <div class="aspect-ratio-box">
            @if (!empty($classified_ad->file))
                <img src="{{ $classified_ad->file->getPathAttribute() }}" style="max-width: 100%;" />
            @else
                <img src="{{ asset('images/placeholder_car.png') }}" style="max-width: 100%;" />
            @endif
            </div>
            <h6>{{$classified_ad->title}}</h6>
            <h6 class="ads-item-price">${{$classified_ad->price}}/ night</h6>
            <h6>{{$classified_ad->location?? ''}}</h6>
          </a>
        @endforeach
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
        @foreach ($featured_ads as $classified_ad)
          <div class="col-sm-3 featured-ads-item">
            <div class="aspect-ratio-box">
            @if (!empty($classified_ad->file))
                <img src="{{ $classified_ad->file->getPathAttribute() }}" style="max-width: 100%;" />
            @else
                <img src="{{ asset('images/placeholder_car.png') }}" style="max-width: 100%;" />
            @endif
            </div>
            <h6>{{$classified_ad->title}}</h6>
            <h6 class="ads-item-price">${{$classified_ad->price}}/ night</h6>
            <h6>{{$classified_ad->location?? ''}}</h6>
          </div>
        @endforeach
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
