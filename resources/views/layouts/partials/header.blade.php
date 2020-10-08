<header class="header">
    <div class="main-header-area">
        <div class="container">
            <div class="d-flex header-divs">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="nav-logo" src="{{ asset('images/logo.png') }}" width="100" />
                </a>
                <div class="search-sec">
                    <form method="GET" action="{{ route('classified_ads.index') }}">
                        <div class="d-flex">
                            <div class="p-0">
                                <input type="text" id="search-ad-location" class="form-control search-slt  @error('location') is-invalid @enderror" name="location" value="{{request()->get('location')}}" placeholder="Enter Pickup City">
                            </div>
                            <div class="p-0 flex-fill">
                                <input type="text" class="form-control search-slt  @error('brand') is-invalid @enderror" name="ad_name" value="{{request()->get('ad_name')}}" placeholder="Search by Locations,Type of camping & More">
                            </div>
                            <div class="p-0 flex-fill">
                                <select class="form-control search-slt @error('category') is-invalid @enderror" name="category" id="search-category" >
                                    <option value=""> {{ __('ads.all') }}</option>
                                    @foreach (\App\Category::all() as $category)
                                    <option value="{{$category->id}}" @if (request()->get('category') === $category->id) selected @endif> {{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-0">
                                <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="navbarResponsiveAccount">
                    <ul class="navbar-nav account-menu flex-row">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('welcome.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('welcome.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{ route('chatrooms.index') }}"><i class="fas fa-comment-alt"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{ route('wishlists') }}"><i class="fas fa-heart"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Good morning, {{ Auth::user()->name }} 
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('lang','en') }}">En</a>
                                <a class="dropdown-item" href="{{ route('lang','fr') }}">Fr</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('welcome.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                        
                    
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white" id="mainNav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mr-auto">
                    @foreach (\App\Category::all() as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::segment(1) == 'classified_ads' && Request::segment(2) == '') ? 'active' : '' }}" 
                        href="{{ route('classified_ads.index', ['category'=> $category->id]) }}">
                        <span class="nav-text">{{ $category->category_name }}</span>
                        </a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'articles' ? 'active' : '' }}" href="{{ url('/classified_ads') }}">
                        <span class="nav-text">{{ __('welcome.itemsforsale') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'contact' ? 'active' : '' }}" href="{{ url('/classified_ads') }}">
                        <span class="nav-text">{{ __('welcome.services') }}</span>
                        </a>
                    </li>
                    <li class="nav-item btn-main">
                        <a class="nav-link" href="{{ url('/classified_ads/create') }}">
                        <span class="nav-text">Post an Ad <i class="fas fa-chevron-right"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>