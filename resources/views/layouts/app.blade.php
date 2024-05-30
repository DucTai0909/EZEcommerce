<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EZ Ecommerce') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icon/favicon-16x16.png">    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    
    {{-- Own Carousel --}}
    <link rel="stylesheet" href={{ asset('assets/css/owl.carousel.min.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/owl.theme.default.min.css') }}>

    {{-- ExZoom --}}
    <link rel="stylesheet" href={{ asset('assets/exzoom/jquery.exzoom.css') }}>

    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Scripts -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div id="app">
        @include('layouts.inc.frontend.navbar')
    
        <main>
            @yield('content')
        </main>

        @include('layouts.inc.frontend.footer')

    </div>
    
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('message', (event) => {
                alertify.set('notifier','position', 'top-right');
                if(event.type == 'success'){
                    alertify.success(event.message);
                }else if(event.type == 'error'){
                    alertify.error(event.message);
                }
            });
        });

    </script>

    <!-- Add this script to the end of your HTML file or in a separate JavaScript file -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all the navigation items
        var navItems = document.querySelectorAll('.nav-item');

        // Add click event listeners to each navigation item
        navItems.forEach(function (item) {
            item.addEventListener('click', function () {
                // Remove the 'active' class from all items
                navItems.forEach(function (navItem) {
                    navItem.classList.remove('active');
                });

                // Add the 'active' class to the clicked item
                item.classList.add('active');
            });
        });
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}" ></script>

<script src="{{ asset('assets/exzoom/jquery.exzoom.js') }}" ></script>

@yield('script')

    @livewireScripts
    @stack('scripts')
</body>
</html>
