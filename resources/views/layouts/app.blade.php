<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @stack('scripts-vars')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXfPt8Ul2g0-2RU70lgvbIZW_5ZKSf4-I&callback=initMap" async  defer></script> --}}
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDR6v2elDctrDptLyvTjpTBEs6z7CLSfW8&libraries=places"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/wcl0int.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        @include('layouts.partials.header')
        <main>
            @yield('content')
        </main>
    </div>
    @include('layouts.partials.footer')
  @stack('js')
</body>
</html>
