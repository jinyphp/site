<!-- Navbar -->
<nav class="navbar-default navbar navbar-expand-lg">
    <a id="nav-toggle" href="#">
        <i class="fe fe-menu"></i>
    </a>
    <div class="ms-lg-3 d-none d-md-none d-lg-block">
        <!-- Form -->
        <form class="d-flex align-items-center">
            <span class="position-absolute ps-3 search-icon">
                <i class="fe fe-search"></i>
            </span>
            <input type="search" class="form-control ps-6" placeholder="Search Entire Dashboard" />
        </form>
    </div>
    <!-- Navbar nav -->
    <div class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
        <div class="dropdown">
            <button class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" type="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fe fe-bell"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg" aria-labelledby="dropdownNotification">
                <div>
                    <div class="border-bottom px-3 pb-3 d-flex justify-content-between align-items-center">
                        <span class="h4 mb-0">Notifications</span>
                        <a href="#">
                            <span class="align-middle">
                                <i class="fe fe-settings me-1"></i>
                            </span>
                        </a>
                    </div>
                    <div data-simplebar style="height: 300px">
                        <!-- List group -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-light">
                                <div class="row">
                                    <div class="col">
                                        <a class="text-body" href="#">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="" class="avatar-md rounded-circle" />
                                                <div class="ms-3">
                                                    <h5 class="fw-bold mb-1">Kristin Watson:</h5>
                                                    <p class="mb-3 text-body">
                                                        Krisitn Waston commented on your post.
                                                    </p>
                                                    <span class="fs-6 text-muted">
                                                        <span>
                                                            <span class="fe fe-thumbs-up text-success me-1"></span>
                                                            2 hours ago,
                                                        </span>
                                                        <span class="ms-1">2:19 PM</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="border-top px-3 pt-3 pb-0">
                        <a href="#" class="text-link fw-semibold">
                            See all Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- User -->
        <div class="dropdown">
            <button class="btn btn-light btn-icon rounded-circle text-muted" type="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img alt="avatar" src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" class="rounded-circle avatar avatar-md" />
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                <div class="dropdown-item">
                    <div class="d-flex">
                        <div class="avatar avatar-md">
                            <img alt="avatar" src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" class="rounded-circle" />
                        </div>
                        <div class="ms-3 lh-1">
                            <h5 class="mb-1">Annette Black</h5>
                            <p class="mb-0 text-muted">annette@geeks.com</p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <ul class="list-unstyled">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fe fe-power me-2"></i>
                            Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>