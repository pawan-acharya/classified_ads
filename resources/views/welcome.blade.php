@extends('layouts.app')

@section('content')

<section id="intro">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto text-white">
        <h1>{{ __('welcome.welcome_heading') }}</h1>
        <div class="col-md-12 d-flex justify-content-center">
          <div class="btn-toolbar mx-auto my-3 ">
            <a href="{{ url('/ads') }}" class="btn btn-primary btn-round mr-2">{{ __('welcome.find_a_rental') }}</a>
            <a href="{{ url('/ads/create') }}" class="btn btn-secondary btn-round ml-2"> {{ __('welcome.transfer_rental') }}</a>
          </div>
        </div>
      </div>
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
              <img class="key" src="{{ asset('images/key.png') }}" />
          </div>
      </form>
    </div>
  </div>
</section>

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
</section>

<section id="blog-articles" class="bg-light">
    <div class="container">
      <div class="section-header">
        <div class="initial-line" style="width:17%;"></div>
        <p class="heading-text">
          <span>{{ __('welcome.news_title') }}</span>
        </p>
      </div>
      <div class="row">
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
          <div class="blog-list-wrapper">
            <div class="blog-list">
              <a href="#" class="img-shadow">
                <img src="{{ asset('images/woman-driving-car.jpg') }}" style="max-width: 100%;" />
                <i class="fa fa-plus"></i> 
              </a>
            </div>
            <div class="py-3">
              <a href="#"><h6>Titre Lorem ipsum dolor sit amet consectetur adipiscing elit</h6></a>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...<a href="#"><span>{{ __('welcome.read_more') }}</span></a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
          <div class="blog-list-wrapper">
            <div class="blog-list">
              <a href="#" class="img-shadow">
                <img src="{{ asset('images/woman-driving-car.jpg') }}" style="max-width: 100%;" />
                <i class="fa fa-plus"></i> 
              </a>
            </div>
            <div class="py-3">
              <a href="#"><h6>Titre Lorem ipsum dolor sit amet consectetur adipiscing elit</h6></a>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...<a href="#"><span>{{ __('welcome.read_more') }}</span></a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
          <div class="blog-list-wrapper">
            <div class="blog-list">
              <a href="#" class="img-shadow">
                <img src="{{ asset('images/woman-driving-car.jpg') }}" style="max-width: 100%;" />
                <i class="fa fa-plus"></i> 
              </a>
            </div>
            <div class="py-3">
              <a href="#"><h6>Titre Lorem ipsum dolor sit amet consectetur adipiscing elit</h6></a>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...<a href="#"><span>{{ __('welcome.read_more') }}</span></a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <a href="{{ url('/articles') }}" class="btn btn-primary btn-round mr-2">{{ __('welcome.all_articles') }}</a>
      </div>
    </div>
</section>
@endsection

@push('scripts-vars')
    <script>
        var options ={!! json_encode(__('ads.model_options')) !!};
        var old_model = '{{old('model')}}';
    </script>
@endpush
