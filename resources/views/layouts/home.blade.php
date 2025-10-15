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

  <body>
    <!-- Page Content -->
    @include('jiny-auth::partials.home-top')

    @include('jiny-auth::partials.home-side')

    <div class="db-content">
      @yield('content')
    </div>

    <!-- Scroll top -->
    <div class="btn-scroll-top">
    <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
        <path d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
    </svg>
</div>

    <!-- Scripts -->
    <!-- Libs JS -->
<script src="{{ asset('assets/libs/@popperjs/core/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Theme JS -->

@stack('scripts')

  </body>
</html>
