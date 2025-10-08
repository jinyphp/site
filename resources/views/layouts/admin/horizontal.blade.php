<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.css') }}" />
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

    <title>@yield('title', 'Dashboard') - Admin Horizontal Layout | Jiny</title>
    @stack('styles')
</head>

<body>
    <!-- Wrapper -->
    <main>
        <!-- navbar vertical -->

        <!-- Page Content -->

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container px-0">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/brand/logo/logo.svg') }}"
                        alt="Jiny" style="height: 1.875rem" /></a>

                <div class="ms-lg-3 d-none d-md-none d-lg-block">
                    <!-- Form -->
                    <form class="d-flex align-items-center">
                        <span class="position-absolute ps-3 search-icon">
                            <i class="fe fe-search"></i>
                        </span>
                        <input type="search" class="form-control ps-6" placeholder="Search Entire Dashboard" />
                    </form>
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <ul class="navbar-nav navbar-right-wrap d-flex nav-top-wrap">
                        <li class="dropdown stopevent">
                            <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary" href="#"
                                role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fe fe-bell"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg"
                                aria-labelledby="dropdownNotification">
                                <div>
                                    <div
                                        class="border-bottom px-3 pb-3 d-flex justify-content-between align-items-center">
                                        <span class="h4 mb-0">Notifications</span>
                                        <a href="# ">
                                            <span class="align-middle">
                                                <i class="fe fe-settings me-1"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- List group -->
                                    <ul class="list-group list-group-flush" style="height: 300px" data-simplebar>
                                        <li class="list-group-item bg-light">
                                            <div class="row">
                                                <div class="col">
                                                    <a class="text-body" href="#">
                                                        <div class="d-flex">
                                                            <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                                                alt="" class="avatar-md rounded-circle" />
                                                            <div class="ms-3">
                                                                <h5 class="fw-bold mb-1">Kristin Watson:</h5>
                                                                <p class="mb-3 text-body">Krisitn Watsan like your
                                                                    comment on course Javascript Introduction!</p>
                                                                <span class="fs-6">
                                                                    <span>
                                                                        <span
                                                                            class="fe fe-thumbs-up text-success me-1"></span>
                                                                        2 hours ago,
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
                                                    <div>
                                                        <a href="#" class="bg-transparent"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Remove">
                                                            <i class="fe fe-x"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">
                                                    <a class="text-body" href="#">
                                                        <div class="d-flex">
                                                            <img src="{{ asset('assets/images/avatar/avatar-2.jpg') }}"
                                                                alt="" class="avatar-md rounded-circle" />
                                                            <div class="ms-3">
                                                                <h5 class="fw-bold mb-1">Brooklyn Simmons</h5>
                                                                <p class="mb-3 text-body">Just launched a new Courses
                                                                    React for Beginner.</p>
                                                                <span class="fs-6">
                                                                    <span>
                                                                        <span
                                                                            class="fe fe-thumbs-up text-success me-1"></span>
                                                                        Oct 9,
                                                                    </span>
                                                                    <span class="ms-1">1:20 PM</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-auto text-center me-2">
                                                    <a href="#" class="badge-dot bg-secondary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Mark as unread"></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">
                                                    <a class="text-body" href="#">
                                                        <div class="d-flex">
                                                            <img src="{{ asset('assets/images/avatar/avatar-3.jpg') }}"
                                                                alt="" class="avatar-md rounded-circle" />
                                                            <div class="ms-3">
                                                                <h5 class="fw-bold mb-1">Jenny Wilson</h5>
                                                                <p class="mb-3 text-body">Krisitn Watsan like your
                                                                    comment on course Javascript Introduction!</p>
                                                                <span class="fs-6">
                                                                    <span>
                                                                        <span
                                                                            class="fe fe-thumbs-up text-info me-1"></span>
                                                                        Oct 9,
                                                                    </span>
                                                                    <span class="ms-1">1:56 PM</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-auto text-center me-2">
                                                    <a href="#" class="badge-dot bg-secondary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Mark as unread"></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col">
                                                    <a class="text-body" href="#">
                                                        <div class="d-flex">
                                                            <img src="{{ asset('assets/images/avatar/avatar-4.jpg') }}"
                                                                alt="" class="avatar-md rounded-circle" />
                                                            <div class="ms-3">
                                                                <h5 class="fw-bold mb-1">Sina Ray</h5>
                                                                <p class="mb-3 text-body">You earn new certificate for
                                                                    complete the Javascript Beginner course.</p>
                                                                <span class="fs-6">
                                                                    <span>
                                                                        <span
                                                                            class="fe fe-award text-warning me-1"></span>
                                                                        Oct 9,
                                                                    </span>
                                                                    <span class="ms-1">1:56 PM</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-auto text-center me-2">
                                                    <a href="#" class="badge-dot bg-secondary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Mark as unread"></a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="border-top px-3 pt-3 pb-0">
                                        <a href="{{ '#' }}"
                                            class="text-link fw-semibold">See all Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- List -->
                        <li class="dropdown ms-2">
                            <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <p class="mb-0">annette@geeksui.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="list-unstyled">
                                    <li class="dropdown-submenu dropstart-lg">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">
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
                                        <a class="dropdown-item" href="{{ route('profile-edit') }}">
                                            <i class="fe fe-user me-2"></i>
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('student-subscriptions') }}">
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
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="fe fe-power me-2"></i>
                                            Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Button -->
                <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="icon-bar top-bar mt-0"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-default py-0 py-lg-2">
            <div class="container px-0">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbar-default">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDashboard"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-bs-display="static">Dashboard</a>
                            <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarDashboard">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('admin') }}">Overview</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Analytics</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarPages"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarPages">
                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                        href="#">Courses</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">All Courses</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Course Category</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Category Single</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                        href="#">Users</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Instructor</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Students</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                        href="#">CMS</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Overview</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">All Post</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">New Post</a>
                                        </li>
                                        <li>
                                            <a href="{{ '#' }}"
                                                class="dropdown-item">Category</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                        href="#">Project</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Grid</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">List</a>
                                        </li>

                                        <li class="dropdown-submenu dropend">
                                            <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                                href="#">Single</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Overview</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Task</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Budget</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Team</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Files</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ '#' }}">Summary</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Create Project</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                        href="#">Site Setting</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">General</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">google</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Social</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Social
                                                Login</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Payment</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">SMPT</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarApps"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Apps</a>
                            <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarApps">
                                <li>
                                    <a class="dropdown-item" href="{{ '#' }}">Chat</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ '#' }}">Task</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ '#' }}">Mail</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Calendar</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarAuthentication"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Authentication</a>
                            <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAuthentication">
                                <li>
                                    <a class="dropdown-item" href="{{ route('sign-in') }}">Sign In</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('sign-up') }}">Sign Up</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('forget-password') }}">Forgot
                                        Password</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Notifications</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('404-error') }}">404 Error</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="ecommerceDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Ecommerce</a>
                            <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="ecommerceDropdown">
                                <li><span class="dropdown-header">Ecommerce</span></li>
                                <li class="dropdown-submenu dropend">
                                    <a class="dropdown-item dropdown-toggle d-flex justify-content-between"
                                        href="#">Products</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Grid</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Grid
                                                Sidebar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Product
                                                Single</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Product
                                                Single v2</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dropdown-item"
                                                href="{{ '#' }}">Add
                                                Product</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Shopping Cart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Checkout</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Order Single</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Order History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Order Summary</a>
                                </li>

                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Customer
                                        Single</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Add Customer</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="layoutsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Layouts</a>
                            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="layoutsDropdown">
                                <li><span class="dropdown-header">Layouts</span></li>

                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Top</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Compact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Vertical</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarTables"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tables</a>
                            <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarTables">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Basic</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ '#' }}">Datatables</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fe fe-more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDropdown">
                                <div class="list-group">
                                    <a class="list-group-item list-group-item-action border-0"
                                        href="{{ route('docs') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fe fe-file-text fs-3 text-primary"></i>
                                            <div class="ms-3">
                                                <h5 class="mb-0">Documentations</h5>
                                                <p class="mb-0 fs-6">Browse the all documentation</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item list-group-item-action border-0"
                                        href="{{ route('docs.bootstrap-5-snippets') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-files fs-3 text-primary"></i>
                                            <div class="ms-3">
                                                <h5 class="mb-0">Snippet</h5>
                                                <p class="mb-0 fs-6">Bunch of Snippet</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item list-group-item-action border-0"
                                        href="{{ route('docs.changelog') }}">
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
                                    <a class="list-group-item list-group-item-action border-0"
                                        href="https://geeksui.codescandy.com/geeks-rtl/" target="_blank">
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

        @yield('content')


    </main>

    <!-- Scripts -->
    @stack('scripts')
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->

    <script src="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    @stack('page-scripts')
</body>

</html>
