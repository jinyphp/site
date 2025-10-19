{{-- 페이지 전체 fluid --}}
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-0">

        <a class="navbar-brand" href="/">
            <img src="{{ asset(Site::logo()) }}" alt="{{ Site::brand() }}" />
        </a>

        <div class="order-lg-3 d-flex align-items-center">
            <div>
                <div class="d-flex align-items-center">
                    {{-- <div class="dropdown me-2">
                        <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
                            aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                            <i class="bi theme-icon-active"></i>
                            <span class="visually-hidden bs-theme-text">Toggle theme</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="light" aria-pressed="false">
                                    <i class="bi theme-icon bi-sun-fill"></i>
                                    <span class="ms-2">Light</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                    data-bs-theme-value="dark" aria-pressed="false">
                                    <i class="bi theme-icon bi-moon-stars-fill"></i>
                                    <span class="ms-2">Dark</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center active"
                                    data-bs-theme-value="auto" aria-pressed="true">
                                    <i class="bi theme-icon bi-circle-half"></i>
                                    <span class="ms-2">Auto</span>
                                </button>
                            </li>
                        </ul>
                    </div> --}}
                    <x-login class="btn btn-outline-primary shadow-sm me-2 d-none d-md-block">Sign In</x-login>
                    <x-register class="btn btn-primary d-none d-md-block me-2 me-lg-0">Sign Up</x-register>
                </div>
            </div>
            <!-- Button -->
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
        </div>

        @include('jiny-site::partials.navs.left.top')
    </div>
</nav>
