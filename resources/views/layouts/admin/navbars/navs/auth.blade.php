<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand pt-0 d-none d-md-block" href="{{ route('home') }}">
            <img src="{{ asset('admin-assets') }}/img/brand/blue.png" class="navbar-brand-img">
        </a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown ">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold dropdown-toggle">{{ auth()->user()->first_name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('admin.welcome') }}</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('welcome.logout') }}
                </a>
                </div>
            </li>
            <li class="nav-item language-option">
                <a class="nav-link pr-0" href="{{ route('lang','en') }}">En</a></a>
            </li>
            <li class="nav-item language-option">
               <a class="nav-link pr-0" href="{{ route('lang','fr') }}">Fr</a>
            </li>
        </ul>
    </div>
</nav>