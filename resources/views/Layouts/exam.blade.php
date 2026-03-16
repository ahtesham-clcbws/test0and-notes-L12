<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>{{ env('APP_NAME') }} - Online Examination</title>
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="icon">
        <link type="image/x-icon" href="{{ asset('logos/logo-white-square.png') }}" rel="shortcut-icon">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Extracted CSS Imports -->
        <link href="{{ asset('skillup/css/plugins/animation.css') }}" rel="stylesheet">
        <link href="{{ asset('bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('skillup/css/plugins/themify.css') }}" rel="stylesheet">
        <link href="{{ asset('skillup/css/plugins/font-awesome.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('skillup/css/styles.min.css') }}" rel="stylesheet">

        @yield('css')
    </head>
    <body class="bg-light">
        <div id="main-wrapper">
            {{-- Focused Main Content Wrapper with No Navbar or Footer --}}
            <div class="py-3">
                @yield('main')
                @if (isset($slot))
                    {{ $slot }}
                @endif
            </div>
        </div>

        <!-- JS FILES -->
        <script src="{{ asset('frontend/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('skillup/js/custom.js') }}" defer></script>

        @yield('js')
        @stack('scripts')
    </body>
</html>
