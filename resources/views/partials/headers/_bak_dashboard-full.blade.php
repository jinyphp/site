<div class="header">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#">
            <i class="nav-icon fe fe-menu"></i>
        </a>
        <div class="ms-lg-3 d-none d-md-none d-lg-block">
            <!-- Form -->
            <form class="d-flex align-items-center">
                <input type="search" class="form-control" placeholder="Search" />
            </form>
        </div>
        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <li class="dropdown stopevent">
                <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted" href="#"
                    role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fe fe-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg" aria-labelledby="dropdownNotification">
                    <div>
                        <div class="border-bottom px-3 pb-3 d-flex justify-content-between align-items-center">
                            <span class="h4 mb-0">Notifications</span>
                            <a href="# ">
                                <span class="align-middle">
                                    <i class="fe fe-settings me-1"></i>
                                </span>
                            </a>
                        </div>
                        <!-- List group -->
                        <ul class="list-group list-group-flush notification-list-scroll">
                            <!-- List group item -->
                            <li class="list-group-item bg-light">
                                <div class="row">
                                    <div class="col">
                                        <a class="text-body" href="#">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                                    alt="" class="avatar-md rounded-circle" />
                                                <div class="ms-3">
                                                    <h5 class="fw-bold mb-1">Kristin Watson:</h5>
                                                    <p class="mb-3 text-body">
                                                        Krisitn Commented on your article...
                                                    </p>
                                                    <span class="fs-6">
                                                        <span>
                                                            <span class="fe fe-thumbs-up text-success me-1"></span>
                                                            2 hours ago
                                                        </span>
                                                        <span class="ms-1">2:19 PM</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-auto text-center me-2">
                                        <a href="#" class="badge-dot bg-info" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Mark as read"></a>
                                    </div>
                                </div>
                            </li>
                            <!-- List group item -->
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        <a class="text-body" href="#">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/avatar/avatar-2.jpg') }}"
                                                    alt="" class="avatar-md rounded-circle" />
                                                <div class="ms-3">
                                                    <h5 class="fw-bold mb-1">Brooklyn Simmons</h5>
                                                    <p class="mb-3 text-body">
                                                        Just launched a new Courses React for Beginner.
                                                    </p>
                                                    <span class="fs-6">
                                                        <span>
                                                            <span class="fe fe-thumbs-up text-success me-1"></span>
                                                            Oct 9
                                                        </span>
                                                        <span class="ms-1">1:20 PM</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-auto text-center me-2">
                                        <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Mark as unread"></a>
                                    </div>
                                </div>
                            </li>
                            <!-- List group item -->
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        <a class="text-body" href="#">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/avatar/avatar-3.jpg') }}"
                                                    alt="" class="avatar-md rounded-circle" />
                                                <div class="ms-3">
                                                    <h5 class="fw-bold mb-1">Jenny Wilson</h5>
                                                    <p class="mb-3 text-body">
                                                        Krisitn Commented on your article...
                                                    </p>
                                                    <span class="fs-6">
                                                        <span>
                                                            <span class="fe fe-thumbs-up text-info me-1"></span>
                                                            Oct 9
                                                        </span>
                                                        <span class="ms-1">1:56 PM</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-auto text-center me-2">
                                        <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Mark as unread"></a>
                                    </div>
                                </div>
                            </li>
                            <!-- List group item -->
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col">
                                        <a class="text-body" href="#">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/avatar/avatar-4.jpg') }}"
                                                    alt="" class="avatar-md rounded-circle" />
                                                <div class="ms-3">
                                                    <h5 class="fw-bold mb-1">Sina Ray</h5>
                                                    <p class="mb-3 text-body">
                                                        You have 2 hours left to complete the quiz
                                                    </p>
                                                    <span class="fs-6">
                                                        <span>Oct 10</span>
                                                        <span class="ms-1">3:16 PM</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-auto text-center me-2">
                                        <a href="#" class="badge-dot bg-secondary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Mark as unread"></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="border-top px-3 pt-3 pb-0">
                            <a href="#" class="text-link fw-semibold">See all Notifications</a>
                        </div>
                    </div>
                </div>
            </li>
            <!-- List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                            class="rounded-circle" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="dropdown-item">
                        <div class="d-flex">
                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                <img alt="avatar" src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                    class="rounded-circle" />
                            </div>
                            <div class="ms-3 lh-1">
                                <h5 class="mb-1">Annette Black</h5>
                                <p class="mb-0 text-muted">annette@geeksui.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <ul class="list-unstyled">
                        <li class="dropdown-submenu dropstart-lg">
                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                <i class="fe fe-circle me-2"></i>
                                Status
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="badge-dot bg-success me-2"></span>
                                        Online
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="badge-dot bg-secondary me-2"></span>
                                        Offline
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="badge-dot bg-warning me-2"></span>
                                        Away
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <span class="badge-dot bg-danger me-2"></span>
                                        Busy
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fe fe-user me-2"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fe fe-star me-2"></i>
                                Subscription
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fe fe-settings me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
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
            </li>
        </ul>
    </nav>
</div>
