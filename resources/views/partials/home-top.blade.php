<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid px-0">
    <a class="navbar-brand" href="../index.html"><img src="../assets/images/brand/logo/logo.svg" alt="Geeks" /></a>
    <!-- Mobile view nav wrap -->
    <div class="ms-auto d-flex align-items-center order-lg-3">
      <ul class="navbar-nav navbar-right-wrap flex-row d-none d-md-block">
        <!-- 메시지 알림 -->
        <li class="dropdown d-inline-block stopevent position-static me-2">
          @php
            $unreadMessages = \Illuminate\Support\Facades\DB::table('user_messages')
              ->where('user_id', auth()->id())
              ->whereNull('readed_at')
              ->orderBy('created_at', 'desc')
              ->limit(5)
              ->get();
            $unreadCount = $unreadMessages->count();
          @endphp
          <a
            class="btn btn-light btn-icon rounded-circle {{ $unreadCount > 0 ? 'indicator indicator-primary' : '' }}"
            href="#"
            role="button"
            id="dropdownMessageSecond"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            <i class="fe fe-mail"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg position-absolute mx-3 my-5" aria-labelledby="dropdownMessageSecond">
            <div>
              <div class="border-bottom px-3 pb-3 d-flex align-items-center justify-content-between">
                <span class="h5 mb-0">메시지</span>
                <a href="{{ route('home.message.index') }}" class="text-muted">
                  <span class="align-middle"><i class="fe fe-settings me-1"></i></span>
                </a>
              </div>
              <ul class="list-group list-group-flush" style="height: 300px" data-simplebar>
                @forelse($unreadMessages as $msg)
                  <li class="list-group-item bg-light">
                    <div class="row">
                      <div class="col">
                        <a class="text-body" href="{{ route('home.message.show', $msg->id) }}">
                          <div class="d-flex">
                            <div class="avatar avatar-md me-3">
                              <div class="avatar-initials rounded-circle bg-primary text-white">
                                {{ substr($msg->from_name ?: 'S', 0, 1) }}
                              </div>
                            </div>
                            <div class="ms-3">
                              <h5 class="fw-bold mb-1">
                                @if($msg->notice)
                                  <span class="badge bg-warning me-1">공지</span>
                                @endif
                                {{ \Illuminate\Support\Str::limit($msg->subject, 30) }}
                              </h5>
                              <p class="mb-3 text-body">
                                <strong>{{ $msg->from_name ?: '시스템' }}</strong> -
                                {{ \Illuminate\Support\Str::limit(strip_tags($msg->message), 50) }}
                              </p>
                              <span class="fs-6">
                                <span class="fe fe-clock me-1"></span>
                                {{ \Carbon\Carbon::parse($msg->created_at)->diffForHumans() }}
                              </span>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="list-group-item text-center py-5">
                    <i class="fe fe-inbox mb-2" style="font-size: 32px; opacity: 0.3;"></i>
                    <p class="text-muted mb-0">새로운 메시지가 없습니다</p>
                  </li>
                @endforelse
              </ul>
              <div class="border-top px-3 pt-3 pb-0">
                <a href="{{ route('home.message.index') }}" class="text-link fw-semibold">모든 메시지 보기</a>
              </div>
            </div>
          </div>
        </li>

        <!-- 일반 알림 -->
        <li class="dropdown d-inline-block stopevent position-static">
          @php
            $unreadNotifications = \Illuminate\Support\Facades\DB::table('user_notifications')
              ->where('user_id', auth()->id())
              ->whereNull('read_at')
              ->orderBy('created_at', 'desc')
              ->limit(5)
              ->get();
            $unreadNotifCount = $unreadNotifications->count();
          @endphp
          <a
            class="btn btn-light btn-icon rounded-circle {{ $unreadNotifCount > 0 ? 'indicator indicator-primary' : '' }}"
            href="#"
            role="button"
            id="dropdownNotificationSecond"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            <i class="fe fe-bell"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg position-absolute mx-3 my-5" aria-labelledby="dropdownNotificationSecond">
            <div>
              <div class="border-bottom px-3 pb-3 d-flex align-items-center justify-content-between">
                <span class="h5 mb-0">알림</span>
                <a href="{{ route('home.notifications.index') }}" class="text-muted">
                  <span class="align-middle"><i class="fe fe-settings me-1"></i></span>
                </a>
              </div>
              <ul class="list-group list-group-flush" style="height: 300px" data-simplebar>
                @forelse($unreadNotifications as $notif)
                  <li class="list-group-item bg-light">
                    <div class="row">
                      <div class="col">
                        <a class="text-body" href="{{ $notif->action_url ?: route('home.notifications.index') }}">
                          <div class="d-flex">
                            <div class="me-3">
                              @php
                                $iconClass = match($notif->type) {
                                    'message' => 'fe-mail text-primary',
                                    'system' => 'fe-bell text-info',
                                    'achievement' => 'fe-award text-warning',
                                    'warning' => 'fe-alert-triangle text-danger',
                                    default => 'fe-info text-secondary'
                                };
                                $bgClass = match($notif->priority) {
                                    'urgent' => 'bg-danger',
                                    'high' => 'bg-warning',
                                    'low' => 'bg-secondary',
                                    default => 'bg-primary'
                                };
                              @endphp
                              <div class="icon-shape icon-md rounded-circle {{ $bgClass }} bg-opacity-10 d-flex align-items-center justify-content-center">
                                <i class="fe {{ $iconClass }}"></i>
                              </div>
                            </div>
                            <div class="ms-3">
                              <h5 class="fw-bold mb-1">{{ \Illuminate\Support\Str::limit($notif->title, 30) }}</h5>
                              <p class="mb-3 text-body">{{ \Illuminate\Support\Str::limit($notif->message, 60) }}</p>
                              <span class="fs-6">
                                <span class="fe fe-clock me-1"></span>
                                {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                              </span>
                            </div>
                          </div>
                        </a>
                      </div>
                      <div class="col-auto text-center me-2">
                        <form action="{{ route('home.notifications.mark-read', $notif->id) }}" method="POST">
                          @csrf
                          <button type="submit" class="badge-dot bg-info border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="읽음 처리"></button>
                        </form>
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="list-group-item text-center py-5">
                    <i class="fe fe-bell mb-2" style="font-size: 32px; opacity: 0.3;"></i>
                    <p class="text-muted mb-0">새로운 알림이 없습니다</p>
                  </li>
                @endforelse
              </ul>
              <div class="border-top px-3 pt-3 pb-0">
                <a href="{{ route('home.notifications.index') }}" class="text-link fw-semibold">모든 알림 보기</a>
              </div>
            </div>
          </div>
        </li>

        <li class="dropdown ms-2 d-inline-block position-static">
          <a class="rounded-circle" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <div class="avatar avatar-md avatar-indicators avatar-online">
              @if(auth()->check())
                @if(auth()->user()->avatar)
                  <img alt="avatar" src="{{ auth()->user()->avatar }}" class="rounded-circle" />
                @else
                  <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; font-weight: bold;">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                  </div>
                @endif
              @else
                <img alt="avatar" src="../assets/images/avatar/avatar-1.jpg" class="rounded-circle" />
              @endif
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end position-absolute mx-3 my-5">
            <div class="dropdown-item">
              <div class="d-flex">
                <div class="avatar avatar-md avatar-indicators avatar-online">
                  @if(auth()->check())
                    @if(auth()->user()->avatar)
                      <img alt="avatar" src="{{ auth()->user()->avatar }}" class="rounded-circle" />
                    @else
                      <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                      </div>
                    @endif
                  @else
                    <img alt="avatar" src="../assets/images/avatar/avatar-1.jpg" class="rounded-circle" />
                  @endif
                </div>
                <div class="ms-3 lh-1">
                  @if(auth()->check())
                    <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    <p class="mb-0">{{ auth()->user()->email }}</p>
                  @else
                    <h5 class="mb-1">Guest</h5>
                    <p class="mb-0">guest@example.com</p>
                  @endif
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <ul class="list-unstyled">
              <li>
                <a class="dropdown-item" href="{{ route('home.dashboard') }}">
                  <i class="fe fe-home me-2"></i>
                  대시보드
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.account.edit') }}">
                  <i class="fe fe-user me-2"></i>
                  프로필 수정
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.account.avatar') }}">
                  <i class="fe fe-image me-2"></i>
                  아바타 관리
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.profile.phone') }}">
                  <i class="fe fe-phone me-2"></i>
                  전화번호 관리
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.profile.address') }}">
                  <i class="fe fe-map-pin me-2"></i>
                  주소 관리
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.notifications.index') }}">
                  <i class="fe fe-bell me-2"></i>
                  알림
                  @php
                    $userNotifCount = \Illuminate\Support\Facades\DB::table('user_notifications')
                      ->where('user_id', auth()->id())
                      ->whereNull('read_at')
                      ->count();
                  @endphp
                  @if($userNotifCount > 0)
                    <span class="badge bg-danger ms-1">{{ $userNotifCount }}</span>
                  @endif
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.message.index') }}">
                  <i class="fe fe-mail me-2"></i>
                  메시지
                  @php
                    $unreadMsgCount = \Illuminate\Support\Facades\DB::table('user_messages')
                      ->where('user_id', auth()->id())
                      ->whereNull('readed_at')
                      ->count();
                  @endphp
                  @if($unreadMsgCount > 0)
                    <span class="badge bg-primary ms-1">{{ $unreadMsgCount }}</span>
                  @endif
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('home.account.logs') }}">
                  <i class="fe fe-clock me-2"></i>
                  활동 로그
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('account.terms.index') }}">
                  <i class="fe fe-file-text me-2"></i>
                  약관 동의
                </a>
              </li>
            </ul>
            <div class="dropdown-divider"></div>
            <ul class="list-unstyled">
              <li>
                <a class="dropdown-item" href="/logout">
                  <i class="fe fe-power me-2"></i>
                  로그아웃
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div>
      <!-- Button -->
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
      <ul class="navbar-nav mt-3 mt-lg-0 mx-xxl-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarBrowse" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-display="static">Categories</a>
          <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Web Development</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Bootstrap</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">React</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">GraphQl</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Gatsby</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Grunt</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Svelte</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Meteor</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">HTML5</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Angular</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Design</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Graphic Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Illustrator</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">UX / UI Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Figma Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Adobe XD</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Sketch</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Icon Design</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Photoshop</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Mobile App</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">IT Software</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Marketing</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Music</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Life Style</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Business</a>
            </li>
            <li>
              <a href="../pages/course-category.html" class="dropdown-item">Photography</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarLanding" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Landings</a>
          <ul class="dropdown-menu" aria-labelledby="navbarLanding">
            <li>
              <h4 class="dropdown-header">Landings</h4>
            </li>
            <li>
              <a href="../index.html" class="dropdown-item">
                <span>Home Default</span>
              </a>
            </li>
            <li>
              <a href="../pages/landings/landing-abroad.html" class="dropdown-item">
                <span>Home Abroad</span>
              </a>
            </li>
            <li>
              <a href="../mentor/mentor.html" class="dropdown-item">
                <span>Home Mentor</span>
              </a>
            </li>
            <li>
              <a href="../pages/landings/landing-education.html" class="dropdown-item">Home Education</a>
            </li>
            <li>
              <a href="../pages/landings/home-academy.html" class="dropdown-item">Home Academy</a>
            </li>
            <li>
              <a href="../pages/landings/landing-courses.html" class="dropdown-item">Home Courses</a>
            </li>
            <li>
              <a href="../pages/landings/landing-sass.html" class="dropdown-item">Home Sass</a>
            </li>
            <li class="border-bottom my-2"></li>
            <li>
              <a href="../pages/landings/course-lead.html" class="dropdown-item">Lead Course</a>
            </li>
            <li>
              <a href="../pages/landings/request-access.html" class="dropdown-item">Request Access</a>
            </li>

            <li>
              <a href="../pages/landings/landing-job.html" class="dropdown-item">Job Listing</a>
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
                  <a class="dropdown-item" href="../pages/course-filter-grid.html">Course Grid</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-filter-list.html">Course List</a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="../pages/course-category.html">Course Category v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-category-v2.html">Course Category v2</a>
                </li>
                <li class="border-bottom my-2"></li>

                <li>
                  <a class="dropdown-item" href="../pages/course-single.html">Course Single v1</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-single-v2.html">Course Single v2</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-single-v3.html">Course Single v3</a>
                </li>
                <li class="border-bottom my-2"></li>
                <li>
                  <a class="dropdown-item" href="../pages/course-resume.html">Course Resume</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/course-checkout.html">Course Checkout</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/add-course.html">Add New Course</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/dashboard-project.html">
                Projects
                <span class="badge bg-primary ms-2">New</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/dashboard-quiz.html">
                Quizzes
                <span class="badge bg-primary ms-2">New</span>
              </a>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Paths</a>
              <ul class="dropdown-menu">
                <li>
                  <a href="../pages/course-path.html" class="dropdown-item">Browse Path</a>
                </li>
                <li>
                  <a href="../pages/course-path-single.html" class="dropdown-item">Path Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Blog</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/blog.html">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/blog-single.html">Article</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/blog-category.html">Category</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/blog-sidebar.html">Sidebar</a>
                </li>
              </ul>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Career</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/career.html">Overview</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/career-list.html">Listing</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/career-single.html">Opening</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Portfolio</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/portfolio.html">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/portfolio-single.html">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                <span>Mentor</span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../mentor/mentor.html">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../mentor/mentor-list.html">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../mentor/mentor-single.html">Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Job</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/landings/landing-job.html">Home</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/jobs/job-listing.html">List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/jobs/job-grid.html">Grid</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/jobs/job-single.html">Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/jobs/company-list.html">Company List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/jobs/company-about.html">Company Single</a>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Specialty</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/coming-soon.html">Coming Soon</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/404-error.html">Error 404</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/maintenance-mode.html">Maintenance Mode</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/terms-condition-page.html">Terms & Conditions</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>

            <li>
              <a class="dropdown-item" href="../pages/about.html">About</a>
            </li>

            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Help Center</a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../pages/help-center.html">Help Center</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/help-center-faq.html">FAQ's</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/help-center-guide.html">Guide</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/help-center-guide-single.html">Guide Single</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/help-center-support.html">Support</a>
                </li>
              </ul>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/pricing.html">Pricing</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/compare-plan.html">Compare Plan</a>
            </li>

            <li>
              <a class="dropdown-item" href="../pages/contact.html">Contact</a>
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
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                Instructor
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
                  <a class="dropdown-item" href="../pages/dashboard-instructor.html">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-profile.html">Profile</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-courses.html">My Courses</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-order.html">Orders</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-reviews.html">Reviews</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-students.html">Students</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-payouts.html">Payouts</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/instructor-earning.html">Earning</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/instructor-quiz.html">Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/instructor-quiz-details.html">Single</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/instructor-quiz-result.html">Result</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="dropdown-submenu dropend">
              <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                Students
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
                  <a class="dropdown-item" href="../pages/dashboard-student.html">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/student-subscriptions.html">Subscriptions</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/payment-method.html">Payments</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/billing-info.html">Billing Info</a>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Invoice</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/invoice.html">Invoice</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/invoice-details.html">Invoice Details</a>
                    </li>
                  </ul>
                </li>

                <li>
                  <a class="dropdown-item" href="../pages/dashboard-student.html">Bookmarked</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/dashboard-student.html">My Path</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/all-courses.html">All Courses</a>
                </li>
                <li>
                  <a class="dropdown-item" href="../pages/learning-path.html">Learning Path</a>
                </li>

                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Quiz</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/student-quiz.html">Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/quiz-blank.html">Quiz Blank</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/my-quiz.html">My Quiz</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/student-quiz-attempt.html">Quiz Attempt</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/student-quiz-start.html">Quiz Single</a>
                    </li>

                    <li>
                      <a class="dropdown-item" href="../pages/quiz-result.html">Quiz Result</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Certificate</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/certificate-blank.html">Certificate</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/my-certificate.html">My Certificate</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">Learning</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/my-learning.html">My Learning</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/learning-single.html">Learning Single</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/learning-path-single.html">Learning Path Single</a>
                    </li>
                  </ul>
                </li>
                <li class="dropdown-submenu dropend">
                  <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">My Projects</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="../pages/project-blank.html">Project Blank</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/dashboard-project.html">Dashboard Project</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="../pages/project-single.html">Project Single</a>
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
                  <a href="../pages/dashboard/admin-dashboard.html" class="btn btn-sm btn-primary">Go to Dashboard</a>
                </li>
              </ul>
            </li>
            <li>
              <hr class="mx-3" />
            </li>
            <li>
              <a class="dropdown-item" href="../pages/sign-in.html">Sign In</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/sign-up.html">Sign Up</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/forget-password.html">Forgot Password</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/profile-edit.html">Edit Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/security.html">Security</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/social-profile.html">Social Profiles</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/notifications.html">Notifications</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/profile-privacy.html">Privacy Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/delete-profile.html">Delete Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="../pages/linked-accounts.html">Linked Accounts</a>
            </li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fe fe-more-horizontal"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDropdown">
            <div class="list-group">
              <a class="list-group-item list-group-item-action border-0" href="../docs/index.html">
                <div class="d-flex align-items-center">
                  <i class="fe fe-file-text fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">Documentations</h5>
                    <p class="mb-0 fs-6">Browse the all documentation</p>
                  </div>
                </div>
              </a>
              <a class="list-group-item list-group-item-action border-0" href="../docs/bootstrap-5-snippets.html">
                <div class="d-flex align-items-center">
                  <i class="bi bi-files fs-3 text-primary"></i>
                  <div class="ms-3">
                    <h5 class="mb-0">Snippet</h5>
                    <p class="mb-0 fs-6">Bunch of Snippet</p>
                  </div>
                </div>
              </a>
              <a class="list-group-item list-group-item-action border-0" href="../docs/changelog.html">
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
      <form class="mt-3 mt-lg-0 me-lg-5 d-flex align-items-center">
        <span class="position-absolute ps-3 search-icon">
          <i class="fe fe-search"></i>
        </span>
        <label for="search" class="visually-hidden"></label>
        <input type="search" id="search" class="form-control ps-6" placeholder="Search Courses" />
      </form>
    </div>
  </div>
</nav>
