<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/brand/logo/logo-inverse.svg') }}" alt="Geeks" />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'dashboard') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navDashboard" aria-expanded="false"
                    aria-controls="navDashboard">
                    <i class="nav-icon fe fe-home me-2"></i>
                    Dashboard
                </a>
                <div id="navDashboard"
                    class="collapse @@if (context.page_group === 'dashboard') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'overview') { active }"
                                href="#">Overview</a>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'analytics') { active }"
                                href="#">Analytics</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'courses') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navCourses" aria-expanded="false"
                    aria-controls="navCourses">
                    <i class="nav-icon fe fe-book me-2"></i>
                    Courses
                </a>
                <div id="navCourses"
                    class="collapse @@if (context.page_group === 'courses') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'allcourses') { active }"
                                href="#">All Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'coursescategory') { active }"
                                href="#">Courses Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'categorysingle') { active }"
                                href="#">Category Single</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'user') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navProfile" aria-expanded="false"
                    aria-controls="navProfile">
                    <i class="nav-icon fe fe-user me-2"></i>
                    User
                </a>
                <div id="navProfile"
                    class="collapse @@if (context.page_group === 'user') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'instructor') { active }"
                                href="#">Instructor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'students') { active }"
                                href="#">Students</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'cms') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navCMS" aria-expanded="false"
                    aria-controls="navCMS">
                    <i class="nav-icon fe fe-book-open me-2"></i>
                    CMS
                </a>
                <div id="navCMS" class="collapse @@if (context.page_group === 'cms') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'overview') { active }"
                                href="#">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'allpost') { active }"
                                href="#">All Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'newpost') { active }"
                                href="#">New Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'category') { active }"
                                href="#">Category</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'project') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navProject" aria-expanded="false"
                    aria-controls="navProject">
                    <i class="nav-icon fe fe-file me-2"></i>
                    Project
                </a>
                <div id="navProject"
                    class="collapse @@if (context.page_group === 'project') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'grid') { active }"
                                href="#">Grid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'list') { active }"
                                href="#">List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page_group_second !== 'projectSingle') { collapsed }"
                                href="#" data-bs-toggle="collapse" data-bs-target="#navprojectSingle"
                                aria-expanded="false" aria-controls="navprojectSingle">
                                Single
                            </a>
                            <div id="navprojectSingle"
                                class="collapse @@if (context.page_group_second === 'projectSingle') { show }"
                                data-bs-parent="#navProject">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'overview') { active }"
                                            href="#">Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'task') { active }"
                                            href="#">Task</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'budget') { active }"
                                            href="#">Budget</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'team') { active }"
                                            href="#">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'files') { active }"
                                            href="#">Files</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'summary') { active }"
                                            href="#">Summary</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'create-project') { active }"
                                href="#">Create Project</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'authentication') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navAuthentication"
                    aria-expanded="false" aria-controls="navAuthentication">
                    <i class="nav-icon fe fe-lock me-2"></i>
                    Authentication
                </a>
                <div id="navAuthentication"
                    class="collapse @@if (context.page_group === 'authentication') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'signin') { active }"
                                href="#">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'signup') { active }"
                                href="#">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'forgetpassword') { active }"
                                href="#">Forget Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'notification') { active }"
                                href="#">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === '404error') { active }"
                                href="#">404 Error</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'ecommerce') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navecommerce" aria-expanded="false"
                    aria-controls="navecommerce">
                    <i class="nav-icon fe fe-shopping-bag me-2"></i>
                    Ecommerce
                </a>
                <div id="navecommerce"
                    class="collapse @@if (context.page_group === 'ecommerce') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page_group_second !== 'product') { collapsed }"
                                href="#" data-bs-toggle="collapse" data-bs-target="#navproduct"
                                aria-expanded="false" aria-controls="navproduct">
                                Product
                            </a>
                            <div id="navproduct"
                                class="collapse @@if (context.page_group_second === 'product') { show }"
                                data-bs-parent="#navProduct">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'productGrid') { active }"
                                            href="#">Grid</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'productGridSidebar') { active }"
                                            href="#">Grid Sidebar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'products') { active }"
                                            href="#">Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'productSingle') { active }"
                                            href="#">Product Single</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'productSinglev2') { active }"
                                            href="#">Product Single v2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'addProduct') { active }"
                                            href="#">Add Product</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'shoppingCart') { active }"
                                href="#">Shopping Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'checkout') { active }"
                                href="#">Checkout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'order') { active }"
                                href="#">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'orderSingle') { active }"
                                href="#">Order Single</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'orderHistory') { active }"
                                href="#">Order History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'orderSummary') { active }"
                                href="#">Order Summary</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'customer') { active }"
                                href="#">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'customerSingle') { active }"
                                href="#">Customer Single</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'addCustomer') { active }"
                                href="#">Add Customer</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'layouts') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navlayouts" aria-expanded="false"
                    aria-controls="navlayouts">
                    <i class="nav-icon fe fe-layout me-2"></i>
                    Layouts
                </a>
                <div id="navlayouts"
                    class="collapse @@if (context.page_group === 'layouts') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'layoutHorizontal') { active }"
                                href="#">Top</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'navbarVerticalMini') { active }"
                                href="#">Compact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'navbarVertical') { active }"
                                href="#">Vertical</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Apps</div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page === 'chatapp') { active }" href="#">
                    <i class="nav-icon fe fe-message-square me-2"></i>
                    Chat
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page === 'task') { active }" href="#">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-trello">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <rect x="7" y="7" width="3" height="9"></rect>
                            <rect x="14" y="7" width="3" height="5"></rect>
                        </svg>
                    </span>
                    <span class="ms-2">Task</span>
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page === 'mail') { active }" href="#">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-mail">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <span class="ms-2">Mail</span>
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page === 'calendarPage') { active }"
                    href="#">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </span>
                    <span class="ms-2">Calendar</span>
                </a>
            </li>
            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Components</div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'tables') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navTables" aria-expanded="false"
                    aria-controls="navTables">
                    <i class="nav-icon fe fe-database me-2"></i>
                    Tables
                </a>
                <div id="navTables"
                    class="collapse @@if (context.page_group === 'tables') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'basic') { active }"
                                href="#">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'datatables') { active }"
                                href="#">Data Tables</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page === 'helpcenter') { active }"
                    href="#">
                    <i class="nav-icon fe fe-help-circle me-2"></i>
                    Help Center
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'sitesetting') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navSiteSetting" aria-expanded="false"
                    aria-controls="navSiteSetting">
                    <i class="nav-icon fe fe-settings me-2"></i>
                    Site Setting
                </a>
                <div id="navSiteSetting"
                    class="collapse @@if (context.page_group === 'sitesetting') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'general') { active }"
                                href="#">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'google') { active }"
                                href="#">Google</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'social') { active }"
                                href="#">Social</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'sociallogin') { active }"
                                href="#">Social Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'payment') { active }"
                                href="#">Payment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'smpt') { active }"
                                href="#">SMPT</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link @@if (context.page_group !== 'menulevel') { collapsed }"
                    href="#" data-bs-toggle="collapse" data-bs-target="#navMenuLevel" aria-expanded="false"
                    aria-controls="navMenuLevel">
                    <i class="nav-icon fe fe-corner-left-down me-2"></i>
                    Menu Level
                </a>
                <div id="navMenuLevel"
                    class="collapse @@if (context.page_group === 'menulevel') { show }"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page === 'twolevel') { active }"
                                href="#" data-bs-toggle="collapse" data-bs-target="#navMenuLevelSecond"
                                aria-expanded="false" aria-controls="navMenuLevelSecond">
                                Two Level
                            </a>
                            <div id="navMenuLevelSecond" class="collapse" data-bs-parent="#navMenuLevel">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'navitem1') { active }"
                                            href="#">NavItem 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'navitem2') { active }"
                                            href="#">NavItem 2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @@if (context.page_group !== 'threelevel') { collapsed }"
                                href="#" data-bs-toggle="collapse" data-bs-target="#navMenuLevelThree"
                                aria-expanded="false" aria-controls="navMenuLevelThree">
                                Three Level
                            </a>
                            <div id="navMenuLevelThree"
                                class="collapse @@if (context.page_group === 'threelevel') { show }"
                                data-bs-parent="#navMenuLevel">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page_group !== 'navitemthree1') { collapsed }"
                                            href="#" data-bs-toggle="collapse"
                                            data-bs-target="#navMenuLevelThreeOne" aria-expanded="false"
                                            aria-controls="navMenuLevelThreeOne">
                                            NavItem 1
                                        </a>
                                        <div id="navMenuLevelThreeOne"
                                            class="collapse collapse @@if (context.page_group === 'navitemthree1') { show }"
                                            data-bs-parent="#navMenuLevelThree">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a class="nav-link @@if (context.page === 'navchilitem') { active }"
                                                        href="#">NavChild Item 1</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @@if (context.page === 'navitem2') { active }"
                                            href="#">Nav Item 2</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Documentation</div>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon fe fe-clipboard me-2"></i>
                    Documentation
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon fe fe-git-pull-request me-2"></i>
                    Changelog
                    <span class="text-primary ms-1" id="changelog"></span>
                </a>
            </li>
        </ul>
        <!-- Card -->
        <div class="card bg-dark-primary shadow-none text-center mx-4 my-8 border-0">
            <div class="card-body py-6">
                <img src="{{ asset('assets/images/background/giftbox.png') }}" alt="" />
                <div class="mt-4">
                    <h5 class="text-white">Unlimited Access</h5>
                    <p class="text-white-50 fs-6">Upgrade your plan from a Free trial, to select ‘Business Plan’. Start
                        Now</p>
                    <a href="#" class="btn btn-white btn-sm mt-2">Upgrade Now</a>
                </div>
            </div>
        </div>
    </div>
</nav>
