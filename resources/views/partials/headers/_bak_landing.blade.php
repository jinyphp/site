<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-0">
        <div class="d-flex">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Jiny" />
            </a>
            <div class="dropdown d-none d-md-block">
                <button class="btn btn-light-primary text-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fe fe-list me-2 align-middle"></i>
                    Category
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @include('partials.category-dropdown')
                </ul>
            </div>
        </div>

        <div class="ms-auto d-flex align-items-center order-lg-3">
            <div class="d-flex align-items-center">
                <form class="me-2 me-lg-3 d-none d-lg-block">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Search Courses" />
                        <span class="input-group-text">
                            <i class="fe fe-search"></i>
                        </span>
                    </div>
                </form>

                @include('partials.theme-switcher')

                <a href="#" class="btn btn-outline-primary me-2 d-none d-lg-block">Sign in</a>
                <a href="#" class="btn btn-primary d-none d-lg-block">Sign up</a>
            </div>

            <button
                class="navbar-toggler collapsed ms-2"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar-default"
                aria-controls="navbar-default"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="icon-bar top-bar mt-0"></span>
                <span class="icon-bar middle-bar"></span>
                <span class="icon-bar bottom-bar"></span>
            </button>
        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbar-default">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarBrowse" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Browse</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
                        <li><a class="dropdown-item" href="{{ url('/courses') }}">Web Development</a></li>
                        <li><a class="dropdown-item" href="{{ url('/courses') }}">Design</a></li>
                        <li><a class="dropdown-item" href="{{ url('/courses') }}">Mobile App</a></li>
                        <li><a class="dropdown-item" href="{{ url('/courses') }}">Marketing</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Landings</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarLanding">
                        <li><a href="#" class="dropdown-item">Home Default</a></li>
                        <li><a href="#" class="dropdown-item">Home Abroad</a></li>
                        <li><a href="#" class="dropdown-item">Home Academy</a></li>
                        <li><a href="#" class="dropdown-item">Home Courses</a></li>
                        <li><a href="#" class="dropdown-item">Home Education</a></li>
                        <li><a href="#" class="dropdown-item">Home Job</a></li>
                        <li><a href="#" class="dropdown-item">Home SaaS</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarPages">
                        <li><a class="dropdown-item" href="{{ url('/courses') }}">Course</a></li>
                        <li><a class="dropdown-item" href="{{ url('/instructor') }}">Instructor</a></li>
                        <li><a class="dropdown-item" href="{{ url('/student-list') }}">Students</a></li>
                        <li><a class="dropdown-item" href="{{ url('/help-center') }}">Help Center</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>