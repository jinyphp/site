<nav class="navbar navbar-expand-lg">
    <div class="container px-0">
        <a class="navbar-brand" href="#"><img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Geeks" /></a>
        <div class="d-flex align-items-center order-lg-3 ms-lg-3">
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                        <i class="bi theme-icon-active"></i>
                        <span class="visually-hidden bs-theme-text">Toggle theme</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                                <i class="bi theme-icon bi-sun-fill"></i>
                                <span class="ms-2">Light</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                                <i class="bi theme-icon bi-moon-stars-fill"></i>
                                <span class="ms-2">Dark</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                                <i class="bi theme-icon bi-circle-half"></i>
                                <span class="ms-2">Auto</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <a href="https://themes.getbootstrap.com/product/geeks-academy-admin-template/" class="btn btn-outline-primary mx-2 d-none d-md-block">Sign in</a>
                <a href="https://themes.getbootstrap.com/product/geeks-academy-admin-template/" class="btn btn-primary d-none d-md-block">Sign up</a>
            </div>
            <button
                class="navbar-toggler collapsed ms-2 ms-lg-0"
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
        <!-- Button -->

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbar-default">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarListing" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Listing</a>
                    <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarListing">
                        <li>
                            <a class="dropdown-item" href="#">List</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Grid</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Single</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                    <ul class="dropdown-menu dropdown-menu-arrow dropdown-menu-end" aria-labelledby="navbarPages">
                        <li>
                            <a class="dropdown-item" href="#">Company List</a>
                        </li>
                        <li class="dropdown-submenu dropend">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Company Single</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">About</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Reviews</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Jobs</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Benifits</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Photos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Post A Job</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Upload Resume</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Back to Demo</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fe fe-more-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <div class="list-group">
                            <a class="list-group-item list-group-item-action border-0" href="#">
                                <div class="d-flex align-items-center">
                                    <i class="fe fe-file-text fs-3 text-primary"></i>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Documentations</h5>
                                        <p class="mb-0 fs-6">Browse the all documentation</p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action border-0" href="#">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-files fs-3 text-primary"></i>
                                    <div class="ms-3">
                                        <h5 class="mb-0">Snippet</h5>
                                        <p class="mb-0 fs-6">Bunch of Snippet</p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action border-0" href="#">
                                <div class="d-flex align-items-center">
                                    <i class="fe fe-layers fs-3 text-primary"></i>
                                    <div class="ms-3">
                                        <h5 class="mb-0">
                                            Changelog
                                            <span class="text-primary ms-1" id="changelog"></span>
                                        </h5>
                                        <p class="mb-0 fs-6">See what's new</p>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item list-group-item-action border-0" href="https://geeksui.codescandy.com/geeks-rtl/" target="_blank">
                                <div class="d-flex align-items-center">
                                    <i class="fe fe-toggle-right fs-3 text-primary"></i>
                                    <div class="ms-3">
                                        <h5 class="mb-0">RTL demo</h5>
                                        <p class="mb-0 fs-6">RTL Pages</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
