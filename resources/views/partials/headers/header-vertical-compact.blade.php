<!-- Sidebar -->
<nav class="navbar-vertical-compact">
    <!-- Brand logo -->
    <a class="navbar-brand" href="#">
        <img src="{{ asset('assets/images/brand/logo/logo-icon.svg') }}" alt="Geeks" class="text-inverse"
            height="30" />
    </a>
    <div class="h-100" data-simplebar>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item dropdown dropend">
                <a class="nav-link" href="#" id="dashboardDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-home"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dashboardDropdown">
                    <li><span class="dropdown-header">Dashboard</span></li>
                    <li><a class="dropdown-item" href="#">Overview</a></li>
                    <li><a class="dropdown-item" href="#">Analytics</a></li>
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
                        <a class="dropdown-item" href="#">All Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Courses Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Category Single</a>
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
                        <a class="dropdown-item" href="#">Instructor</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Students</a>
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
                        <a class="dropdown-item" href="#">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">All Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">New Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Category</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown dropend">
                <a class="nav-link" href="#" id="projectDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-file"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="projectDropdown">
                    <li><span class="dropdown-header">Project</span></li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Grid</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">List</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Task</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Budget</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Summary</a>
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
                        <a class="dropdown-item" href="#">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Forget Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">404 Error</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown dropend">
                <a class="nav-link" href="#" id="ecommerceDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-shopping-bag"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="ecommerceDropdown">
                    <li><span class="dropdown-header">Ecommerce</span></li>
                    <li class="dropdown-submenu dropend">
                        <a class="dropdown-item dropdown-toggle d-flex justify-content-between"
                            href="#">Products</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Grid</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Grid Sidebar</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Product Single</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Product Single v2</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Add Product</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Shopping Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Order Single</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Order History</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Order Summary</a>
                    </li>

                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Customer Single</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Add Customer</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown dropend">
                <a class="nav-link" href="#" id="layoutsDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-layout"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="layoutsDropdown">
                    <li><span class="dropdown-header">Layouts</span></li>

                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Top</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Vertical</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Compact</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdownTooltip" href="#" data-template="chat">
                    <i class="nav-icon fe fe-message-square"></i>
                    <div id="chat" class="d-none">
                        <span class="fw-semibold fs-6">Chat</span>
                    </div>
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link dropdownTooltip" href="#" data-template="task">
                    <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-trello">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
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
                <a class="nav-link dropdownTooltip" href="#" data-template="mail">
                    <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-mail">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
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
                <a class="nav-link dropdownTooltip" href="#" data-template="calendar">
                    <span class="me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
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
                <a class="nav-link" href="#" id="tableDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-database"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="tableDropdown">
                    <li><span class="dropdown-header">Tables</span></li>

                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Basic</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Data Tables</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdownTooltip" href="#" data-template="helpCenter">
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
                        <a class="dropdown-item" href="#">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Google</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Social</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Social Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">SMPT</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown dropend">
                <a class="nav-link" href="#" id="menulevelDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="nav-icon fe fe-corner-left-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="menulevelDropdown">
                    <li><span class="dropdown-header">Menu Level</span></li>
                    <li class="dropdown-submenu dropend">
                        <a class="dropdown-item dropdown-toggle d-flex justify-content-between" href="#">Two
                            level</a>
                        <ul class="dropdown-menu">
                            <li class="nav-item">
                                <a class="dropdown-item" href="#">Three Level</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="#">Three Level</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Card -->
    </div>
</nav>
