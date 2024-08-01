<nav class="navbar navbar-expand-lg navbar-light w-100">
    <div class="container px-3">

        @include('site::menus.logo')

        <!-- 모바일 버튼 -->
        <button class="navbar-toggler offcanvas-nav-btn" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
            </svg>
        </button>

        <div class="offcanvas offcanvas-start offcanvas-nav" style="width: 20rem">
            <div class="offcanvas-header">
                <a href="/" class="text-inverse">
                    @if($title = config('jiny.site.headers.title'))
                    {{$title}}
                    @else
                    Title2
                    @endif
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body pt-0 align-items-center">

                {{$slot}}

                <div class="mt-2 mt-lg-0 d-flex align-items-center">

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-light btn-sm mx-2">Home</a>
                            <a href="{{ url('/account') }}" class="btn btn-success btn-sm mx-2">account</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-sm mx-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Create account</a>
                            @endif
                        @endauth
                    @endif

                </div>

            </div>
        </div>

    </div>
</nav>
