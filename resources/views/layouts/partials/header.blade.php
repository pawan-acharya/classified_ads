<nav class="navbar navbar-expand-lg navbar-light bg-white" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="nav-logo" src="{{ asset('images/logo.png') }}" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == '' ? 'active' : '' }}" href="{{ url('/') }}">
                    <span class="nav-text">{{ __('welcome.home')}}</span> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::segment(1) == 'classified_ads' && Request::segment(2) == 'create') ? 'active' : '' }}" href="{{ route('classified_ads.create') }}">
                    <span class="nav-text">{{ __('welcome.transfer_rental') }}</span> 
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (Request::segment(1) == 'classified_ads' && Request::segment(2) == '') ? 'active' : '' }}" href="{{ url('/classified_ads') }}">
                    <span class="nav-text">{{ __('welcome.find_a_rental') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'articles' ? 'active' : '' }}" href="{{ url('/articles') }}">
                    <span class="nav-text">{{ __('welcome.articles') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'contact' ? 'active' : '' }}" href="{{ url('/contact') }}">
                    <span class="nav-text">{{ __('welcome.contact') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto account-menu">
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
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <img src="{{ asset('images/short-logo-dark.png') }}" width=28>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('home') }}">{{ __('welcome.my_account') }}</a>
                        <a class="dropdown-item" href="{{ route('wishlists') }}">{{ __('welcome.wishlist') }}</a>
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
                
                <li class="nav-item language-option">
                    <a href="{{ route('lang','en') }}">En</a> | <a href="{{ route('lang','fr') }}">Fr</a>
                </li>
            </ul>
        </div>
    </div>
</nav>