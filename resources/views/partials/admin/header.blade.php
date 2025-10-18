<style>
.mega-menu {
    width: 550px;
    padding: 20px;
    margin-top: -4px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #fff;
    z-index: 1050;
}

.mega-menu-container {
    display: flex;
    gap: 24px;
}

.mega-menu-column {
    flex: 1;
    min-width: 160px;
}

.mega-menu-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 13px;
}

.mega-menu-header i {
    width: 16px;
    height: 16px;
    margin-right: 6px;
    font-size: 14px;
}

.mega-menu-items {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.mega-menu-item {
    display: flex;
    align-items: center;
    padding: 8px 10px;
    color: #6b7280;
    text-decoration: none;
    font-size: 13px;
    border-radius: 4px;
    transition: all 0.15s ease;
}

.mega-menu-item:hover {
    background-color: #f8f9fa;
    color: #374151;
    text-decoration: none;
}

.mega-menu-item i {
    width: 14px;
    height: 14px;
    margin-right: 8px;
    font-size: 12px;
    color: #9ca3af;
}

.mega-menu-item span {
    white-space: nowrap;
    font-weight: 400;
}

/* 드롭다운 링크 스타일 */
.dropdown-toggle {
    cursor: pointer;
    user-select: none;
    font-size: 14px;
}

.dropdown-toggle:hover {
    color: #495057 !important;
}

/* 검색창과 메뉴 사이 간격 */
.ms-4 {
    margin-left: 1.5rem !important;
}

@media (max-width: 768px) {
    .mega-menu {
        width: 320px;
        padding: 16px;
    }

    .mega-menu-container {
        flex-direction: column;
        gap: 16px;
    }

    .mega-menu-item span {
        white-space: normal;
    }

    .ms-4 {
        margin-left: 1rem !important;
    }
}
</style>

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

        <!-- Mega Dropdown Menu -->
        <div class="d-flex align-items-center ms-4">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-normal me-3 px-3" href="#" role="button"
                   id="megaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    메뉴
                </a>
                <div class="dropdown-menu mega-menu" aria-labelledby="megaDropdown">
                    <div class="mega-menu-container">
                        <!-- Auth 섹션 -->
                        <div class="mega-menu-column">
                            <div class="mega-menu-header">
                                <i class="fe fe-users text-primary"></i>
                                <span class="text-primary">인증 관리</span>
                            </div>
                            <div class="mega-menu-items">
                                <a href="/admin/auth" class="mega-menu-item">
                                    <i class="fe fe-home"></i>
                                    <span>Auth 대시보드</span>
                                </a>
                                <a href="/admin/auth/users" class="mega-menu-item">
                                    <i class="fe fe-user"></i>
                                    <span>사용자 관리</span>
                                </a>
                                <a href="/admin/auth/admin" class="mega-menu-item">
                                    <i class="fe fe-shield"></i>
                                    <span>관리자 관리</span>
                                </a>
                            </div>
                        </div>

                        <!-- CMS 섹션 -->
                        <div class="mega-menu-column">
                            <div class="mega-menu-header">
                                <i class="fe fe-edit text-success"></i>
                                <span class="text-success">CMS 관리</span>
                            </div>
                            <div class="mega-menu-items">
                                <a href="/admin/cms" class="mega-menu-item">
                                    <i class="fe fe-grid"></i>
                                    <span>CMS 대시보드</span>
                                </a>
                                <a href="/admin/cms/help" class="mega-menu-item">
                                    <i class="fe fe-life-buoy"></i>
                                    <span>Help Center</span>
                                </a>
                                <a href="/admin/cms/contact" class="mega-menu-item">
                                    <i class="fe fe-phone"></i>
                                    <span>상담요청</span>
                                </a>
                            </div>
                        </div>

                        <!-- Store 섹션 -->
                        <div class="mega-menu-column">
                            <div class="mega-menu-header">
                                <i class="fe fe-shopping-cart text-warning"></i>
                                <span class="text-warning">스토어 관리</span>
                            </div>
                            <div class="mega-menu-items">
                                <a href="/admin/store" class="mega-menu-item">
                                    <i class="fe fe-shopping-cart"></i>
                                    <span>스토어 대시보드</span>
                                </a>
                                <a href="/admin/store/products" class="mega-menu-item">
                                    <i class="fe fe-package"></i>
                                    <span>상품 관리</span>
                                </a>
                                <a href="/admin/store/ecommerce/orders" class="mega-menu-item">
                                    <i class="fe fe-file-text"></i>
                                    <span>주문 관리</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <div class="border-bottom px-3 pb-3 d-flex justify-content-between align-items-center">
                                <span class="h4 mb-0">알림</span>
                                <a href="#">
                                    <span class="align-middle">
                                        <i class="fe fe-settings me-1"></i>
                                    </span>
                                </a>
                            </div>
                            <!-- List group -->
                            <ul class="list-group list-group-flush" data-simplebar style="max-height: 300px">
                                <li class="list-group-item bg-light">
                                    <div class="row">
                                        <div class="col">
                                            <a class="text-body" href="#">
                                                <div class="d-flex">
                                                    <div class="avatar avatar-md rounded-circle bg-primary-soft text-primary">
                                                        <i class="fe fe-user"></i>
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5 class="fw-bold mb-1">새로운 회원 가입</h5>
                                                        <p class="mb-3">3명의 새로운 회원이 가입했습니다.</p>
                                                        <span class="fs-6">
                                                            <span class="fe fe-thumbs-up text-success me-1"></span>
                                                            2시간 전
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="border-top px-3 pt-3 pb-0">
                                <a href="#" class="text-link fw-semibold">모든 알림 보기</a>
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
                                    @auth
                                        <h5 class="mb-1">{{ auth()->user()->name ?? 'User' }}</h5>
                                        <p class="mb-0">{{ auth()->user()->email }}</p>
                                    @else
                                        <h5 class="mb-1">Guest</h5>
                                        <p class="mb-0">guest@example.com</p>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <ul class="list-unstyled">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fe fe-user me-2"></i>
                                    프로필
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fe fe-settings me-2"></i>
                                    설정
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <ul class="list-unstyled">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fe fe-power me-2"></i>
                                        로그아웃
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
