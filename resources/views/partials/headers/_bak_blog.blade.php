<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-0">
    <a class="navbar-brand" href="/"><img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Jiny" /></a>
    <div class="order-lg-3 d-flex align-items-center">
      <div>
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
          <a href="#" class="btn btn-outline-primary shadow-sm me-2 d-none d-md-block">Sign In</a>
          <a href="#" class="btn btn-primary d-none d-md-block me-2 me-lg-0">Sign Up</a>
        </div>
      </div>
      <!-- Button -->
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

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbar-default">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarBrowse" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">Browse</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Web Development</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Bootstrap</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">React</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">GraphQl</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Gatsby</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Node</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Design</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="#">Graphic</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Illustrator</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">UX / UI</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Figma Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Adobe XD</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Sketch</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="#">Mobile App</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">IT Software</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Marketing</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Music</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Life Style</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Business</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Photography</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarBlog" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">블로그</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBlog">
            <li>
              <h4 class="dropdown-header">블로그 레이아웃</h4>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="fe fe-grid me-2"></i>그리드 레이아웃 (Newsroom)
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="fe fe-sidebar me-2"></i>사이드바 레이아웃
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="fe fe-filter me-2"></i>카테고리별 보기
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="fe fe-file-text me-2"></i>블로그 상세 페이지
              </a>
            </li>
            <li>
              <hr class="mx-3" />
            </li>
            <li>
              <h4 class="dropdown-header">카테고리</h4>
            </li>
            <li>
              <a class="dropdown-item" href="#">강좌</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">워크샵</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">튜토리얼</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">회사 소식</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarPages">
            <li>
              <a class="dropdown-item" href="#">Course Single</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Course Single v2</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Course Resume</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Course Category</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Course Checkout</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Course List/Grid</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Add New Course</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarAccounts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Accounts</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAccounts">
            <li>
              <h4 class="dropdown-header">Accounts</h4>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Instructor</a>
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
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Students</a>
              <ul class="dropdown-menu">
                <li class="text-wrap">
                  <h5 class="dropdown-header text-dark">Students</h5>
                  <p class="dropdown-text mb-0">Students dashboard for manage your courses and subscriptions.</p>
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
                <li>
                  <a class="dropdown-item" href="#">Invoice</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Invoice Details</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">Bookmarked</a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">My Path</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#">Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Attempt</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">Result</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>