<!-- navbar login -->
<nav class="navbar navbar-expand-lg @@classList">
  <div class="container px-0">
    <a class="navbar-brand" href="#"><img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Geeks" /></a>
    <div class="d-flex align-items-center order-lg-3">
      <div class="d-flex align-items-center">
        <div class="dropdown me-2">
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
        <div class="d-none d-md-block me-2">
          <a href="https://themes.getbootstrap.com/product/geeks-academy-admin-template/" class="btn btn-primary">Buy Now</a>
        </div>
      </div>
      <div>
        <button
          class="navbar-toggler collapsed"
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
    </div>
    <!-- Button -->

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbar-default">
      <ul class="navbar-nav @@navbarAuto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Landings</a>
          <ul class="dropdown-menu" aria-labelledby="navbarLanding">
            <li>
              <h4 class="dropdown-header">Landings</h4>
            </li>
            <li>
              <a href="#" class="dropdown-item">
                <span>Home Default</span>
                
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item">
                <span>Home Abroad</span>
                
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item">
                <span>Home Mentor</span>
              </a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Home Education</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Home Academy</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Home Courses</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Home Sass</a>
            </li>
            <li class="border-bottom my-2"></li>
            <li>
              <a href="#" class="dropdown-item">Lead Course</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Request Access</a>
            </li>

            <li>
              <a href="#" class="dropdown-item">Job Listing</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarPages">
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Courses</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">
                    Course Grid
                    
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    Course List
                    
                  </a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="#">Course Category v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    Course Category v2
                    
                  </a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="#">Course Single v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Course Single v2</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    Course Single v3
                    
                  </a>
                </li>
                <li class="border-bottom my-2"></li>
                <li>
                  <a class="dropdown-item" href="#">Course Resume</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Course Checkout</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Add New Course</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="#">Projects
                <span class="badge bg-primary ms-2">New</span>
              </a>
              </li>
              <li>
              <a class="dropdown-item" href="#">Quizzes
                <span class="badge bg-primary ms-2">New</span>
              </a>
              </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Paths</a>
              <ul class="dropdown-menu">
                <li>
                  <a href="#" class="dropdown-item">Browse Path</a>
                </li>
                <li>
                  <a href="#" class="dropdown-item">Path Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Blog</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Article</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Category</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Sidebar</a>
                </li>
              </ul>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Career</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Overview</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Opening</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Portfolio</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                <span>Mentor</span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Job</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Grid</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Company List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Company Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Specialty</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Coming Soon</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Error 404</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Maintenance Mode</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Terms & Conditions</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>

            <li>
              <a class="dropdown-item" href="#">About</a>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Help Center</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Help Center</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">FAQ's</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Guide</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Guide Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Support</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="#">Pricing</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Compare Plan</a>
            </li>

            <li>
              <a class="dropdown-item" href="#">Contact</a>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-toggle" href="#">Dropdown levels</a>
              <ul class="dropdown-menu dropdown-menu-start" data-bs-popper="none">
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                <!-- dropdown submenu open right -->
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-toggle" href="#">Dropdown (end)</a>
                  <ul class="dropdown-menu" data-bs-popper="none">
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                  </ul>
                </li>

                <!-- dropdown submenu open left -->
                <li class="dropdown-submenu dropstart">
                  <a class="dropdown-item dropdown-toggle" href="#">Dropdown (start)</a>
                  <ul class="dropdown-menu" data-bs-popper="none">
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                    <li><a class="dropdown-item" href="#">Dropdown item</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarAccount" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Accounts</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAccount">
            <li>
              <h4 class="dropdown-header">Accounts</h4>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Instructor
                <span class="badge bg-primary ms-2">New</span>
              </a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Instructor</h5>
                  <p class="dropdown-text mb-0">Instructor dashboard for manage courses and earning.</p>
                </li>
                <li>
                  <hr class="mx-3" />
                </li>
                <li>
                  <a class="dropdown-item" href="#">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Profile</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">My Courses</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Orders</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Reviews</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Students</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Payouts</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Earning</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#">Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Single</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Result</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
             <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Students
                <span class="badge bg-primary ms-2">New</span>
              </a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                <h5 class="dropdown-header text-dark">Students</h5>
                <p class="dropdown-text mb-0">Students dashboard to manage your courses and subscriptions.</p>
                </li>
                <li>
                <hr class="mx-3" />
                </li>
                <li>
                <a class="dropdown-item" href="#">Dashboard</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">Subscriptions</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">Payments</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">Billing Info</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Invoice</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#">Invoice</a>
                      </li>
                      <li>
                      <a class="dropdown-item" href="#">Invoice Details</a>
                      </li>
                  </ul>
                  </li>
               
                
                <li>
                <a class="dropdown-item" href="#">Bookmarked</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">My Path</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">All Courses</a>
                </li>
                <li>
                <a class="dropdown-item" href="#">Learning Path</a>
                </li>
                
                <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                <ul class="dropdown-menu">
                  <li>
                  <a class="dropdown-item" href="#">Quiz</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Quiz Blank</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">My Quiz</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Quiz Attempt</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Quiz Single</a>
                  </li>
                 
                  <li>
                  <a class="dropdown-item" href="#">Quiz Result</a>
                  </li>
                </ul>
                </li>
                <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Certificate</a>
                <ul class="dropdown-menu">
                  <li>
                  <a class="dropdown-item" href="#">Certificate</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">My Certificate</a>
                  </li>
                </ul>
                </li>
                <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Learning</a>
                <ul class="dropdown-menu">
                  <li>
                  <a class="dropdown-item" href="#">My Learning</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Learning Single</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Learning Path Single</a>
                  </li>
                </ul>
                </li>
                <li class="dropdown-submenu dropend">
                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">My Projects</a>
                <ul class="dropdown-menu">
                  <li>
                  <a class="dropdown-item" href="#">Project Blank</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Dashboard Project</a>
                  </li>
                  <li>
                  <a class="dropdown-item" href="#">Project Single</a>
                  </li>
                </ul>
                </li>
              </ul>
              </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Admin</a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Master Admin</h5>
                  <p class="dropdown-text mb-0">Master admin dashboard to manage courses, user, site setting , and work with amazing apps.</p>
                </li>
                <li>
                  <hr class="mx-3" />
                </li>
                <li class="px-3 d-grid">
                  <a href="#" class="btn btn-sm btn-primary">Go to Dashboard</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>
            <li>
              <a class="dropdown-item" href="#">Sign In</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Sign Up</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Forgot Password</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Edit Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Security</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Social Profiles</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Notifications</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Privacy Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Delete Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Linked Accounts</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fe fe-more-horizontal"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDropdown">
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
