<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

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

    <link rel="canonical" href="https://geeksui.codescandy.com/geeks/pages/dashboard-instructor.html" />
    <link rel="stylesheet" href="{{ asset('assets/libs/tiny-slider/dist/tiny-slider.css') }}" />

    @stack('styles')

    <title>@yield('title', 'Dashboard') | Geeks - Bootstrap 5 Template</title>
</head>

<body class="bg-white">
    <!-- Header -->
    @hasSection('header')
        {{-- blade에서 직접 header 섹션을 추가하는 경우 --}}
        @yield('header')
    @else
        @includeIf($header ?? 'jiny-site::partials.headers.' . ($header ?? 'header-default'))
    @endif

    <div class="container py-4">
        <div class="d-flex">
            <!-- 왼쪽 사이드바 -->
            <div class="flex-shrink-0" style="width: 250px; border-right: 2px dotted #dee2e6;">
                @include('jiny-site::partials.about-side')
            </div>

            <!-- 오른쪽 컨텐츠 영역 -->
            <div class="flex-grow-1 ms-5">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Footer -->
    @hasSection('footer')
        {{-- blade에서 직접 footer 섹션을 추가하는 경우 --}}
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
