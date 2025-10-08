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

    <title>@yield('title', 'Dashboard') - Admin Compact Layout | Jiny</title>
    @stack('styles')
</head>

<body style="overflow-x: hidden !important; overflow-y: auto !important; padding: 0 !important">
    <!-- Wrapper -->
    <div id="db-wrapper" class="h-100">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        <nav class="navbar-vertical-compact">
            <!-- Brand logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/brand/logo/logo-icon.svg') }}" alt="Jiny" class="text-inverse"
                    height="30" />
            </a>
            <div class="h-100" data-simplebar>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="dashboardDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-home"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dashboardDropdown">
                            <li><span class="dropdown-header">Dashboard</span></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('admin') }}">Overview</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ '#' }}">Analytics</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="courseDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="nav-icon fe fe-book"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="courseDropdown">
                            <li><span class="dropdown-header">Courses</span></li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">All
                                    Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Courses Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Category
                                    Single</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="nav-icon fe fe-user"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><span class="dropdown-header">Users</span></li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Instructor</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Students</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="cmsDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="nav-icon fe fe-book-open"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="cmsDropdown">
                            <li><span class="dropdown-header">CMS</span></li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">All
                                    Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">New
                                    Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Category</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="projectDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-file"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="projectDropdown">
                            <li><span class="dropdown-header">Project</span></li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Grid</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">List</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Task</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Budget</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Summary</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="authenticationDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-lock"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="authenticationDropdown">
                            <li><span class="dropdown-header">Authentication</span></li>

                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('login') }}">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('sign-up') }}">Sign Up</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('forget-password') }}">Forget
                                    Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('404-error') }}">404 Error</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="ecommerceDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-shopping-bag"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="ecommerceDropdown">
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
                                            href="{{ '#' }}">Add Product</a>
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
                                    href="{{ '#' }}">Customer Single</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Add Customer</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="layoutsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-layout"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="layoutsDropdown">
                            <li><span class="dropdown-header">Layouts</span></li>

                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Top</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Vertical</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Compact</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdownTooltip" href="{{ '#' }}"
                            data-template="chat">
                            <i class="nav-icon fe fe-message-square"></i>
                            <div id="chat" class="d-none">
                                <span class="fw-semibold fs-6">Chat</span>
                            </div>
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link dropdownTooltip" href="{{ '#' }}"
                            data-template="task">
                            <span class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-trello">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <rect x="7" y="7" width="3" height="9"></rect>
                                    <rect x="14" y="7" width="3" height="5"></rect>
                                </svg>
                            </span>
                            <div id="task" class="d-none">
                                <span class="fw-semibold fs-6">Task</span>
                            </div>
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link dropdownTooltip" href="{{ '#' }}"
                            data-template="mail">
                            <span class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <div id="mail" class="d-none">
                                <span class="fw-semibold fs-6">Mail</span>
                            </div>
                        </a>
                    </li>
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link dropdownTooltip" href="{{ '#' }}"
                            data-template="calendar">
                            <span class="me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            <div id="calendar" class="d-none">
                                <span class="fw-semibold fs-6">Calendar</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="tableDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-database"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="tableDropdown">
                            <li><span class="dropdown-header">Tables</span></li>

                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Basic</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Data
                                    Tables</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dropdownTooltip" href="{{ route('help') }}"
                            data-template="helpCenter">
                            <i class="nav-icon fe fe-help-circle"></i>
                            <div id="helpCenter" class="d-none">
                                <span class="fw-semibold fs-6">Help Center</span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="siteSettingDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-settings"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="siteSettingDropdown">
                            <li><span class="dropdown-header">Site Setting</span></li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Google</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Social</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Social Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item"
                                    href="{{ '#' }}">Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">SMPT</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown dropend">
                        <a class="nav-link" href="#" id="menulevelDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="nav-icon fe fe-corner-left-down"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="menulevelDropdown">
                            <li><span class="dropdown-header">Menu Level</span></li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle d-flex justify-content-between"
                                    href="#">Two level</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a class="dropdown-item"
                                            href="{{ '#' }}">Three Level</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ '#' }}">Three
                                    Level</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Card -->
            </div>
        </nav>

        <!-- Page Content -->
        <main id="page-content-for-mini">
            <div class="header">
                <!-- navbar -->
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
                    <!--Navbar nav -->
                    <div class="ms-auto d-flex">
                        <ul class="navbar-nav navbar-right-wrap d-flex nav-top-wrap">
                            <li class="dropdown stopevent">
                                <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary"
                                    href="#" role="button" id="dropdownNotification"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                        <ul class="list-group list-group-flush" data-simplebar
                                            style="max-height: 300px">
                                            <li class="list-group-item bg-light">
                                                <div class="row">
                                                    <div class="col">
                                                        <a class="text-body" href="#">
                                                            <div class="d-flex">
                                                                <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                                                    alt="" class="avatar-md rounded-circle" />
                                                                <div class="ms-3">
                                                                    <h5 class="fw-bold mb-1">Kristin Watson:</h5>
                                                                    <p class="mb-3">Krisitn Watsan like your comment
                                                                        on course Javascript Introduction!</p>
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
                                                        <a href="#" class="badge-dot bg-info"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Mark as read"></a>
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
                                                                    <p class="mb-3">Just launched a new Courses React
                                                                        for Beginner.</p>
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
                                                                    <p class="mb-3">Krisitn Watsan like your comment
                                                                        on course Javascript Introduction!</p>
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
                                                                    <p class="mb-3">You earn new certificate for
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
                </nav>
            </div>

            @yield('content')


        </main>
    </div>

    <!-- Scripts -->
    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->

    @stack('scripts')
    @stack('page-scripts')
</body>

</html>
