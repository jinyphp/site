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
        {{-- blade에서 직접 header 섹션을 추가하는 경우 --}}
        @yield('header')
    @else
        @includeIf($header ?? 'jiny-site::partials.headers.' . ($header ?? 'header-default'),[
            'menu' => $headerMenuCode ?? 'default'
        ])
    @endif


    <!-- Main Content -->
    @yield('content')

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

    <!-- Global Cart Functionality -->
    <script>
        // 전역 장바구니 기능
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCountElement = document.querySelector('.cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = data.count;
                        if (data.count > 0) {
                            cartCountElement.style.display = 'inline-block';
                        } else {
                            cartCountElement.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // 페이지 로드 시 장바구니 개수 업데이트
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        // 전역에서 사용할 수 있는 장바구니 카운트 업데이트 함수
        window.updateCartCount = updateCartCount;
    </script>

    @stack('scripts')
</body>
</html>
