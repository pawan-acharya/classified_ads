<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Argon Dashboard') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('admin-assets') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->
    
        <!-- Icons -->
        <link href="{{ asset('admin-assets') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('admin-assets') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('admin-assets') }}/vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('admin-assets') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="d-block d-md-none">
                @include('layouts.admin.navbars.sidebar')
            </div>
        @endauth
        
        <div class="main-content">
            @include('layouts.admin.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.admin.footers.guest')
        @endguest
        
        @stack('scripts-vars')
        <script src="{{ asset('admin-assets') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('admin-assets') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('admin-assets') }}/js/argon.js?v=1.0.0"></script>
    </body>
</html>