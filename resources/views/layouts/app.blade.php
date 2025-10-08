<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />

    <!-- darkmode js -->
    <script src="{{ asset('assets/js/vendors/darkMode.js') }}"></script>

    <!-- Libs CSS -->
    <link href="{{ asset('assets/fonts/feather/feather.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    @stack('styles')

    <title>@yield('title', 'Jiny - Bootstrap 5 Template')</title>
</head>

<body class="@yield('body-class', 'bg-white')">

    <!-- Header -->
    @hasSection('header')
        @yield('header')
    @else
        @includeIf('jiny-site::partials.headers.' . ($header ?? 'header-default'))
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @hasSection('footer')
        @yield('footer')
    @else
        @includeIf($footer ?? 'jiny-site::partials.footers.footer')
    @endif

    <!-- Modal -->
    @include('jiny-site::partials.modals')

    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
