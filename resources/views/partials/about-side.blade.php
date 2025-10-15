<div >
    <nav class="navbar navbar-expand-lg sidenav sidenav-navbar">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenavNavbar">
            <div class="navbar-nav flex-column d-flex flex-column gap-3">
                <ul class="list-unstyled mb-0">
                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                            <i class="bi bi-house-door nav-icon"></i>
                            회사 개요
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/history*') ? 'active' : '' }}"
                            href="{{ url('/about/history') }}">
                            <i class="bi bi-clock-history nav-icon"></i>
                            회사 연혁
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/vision*') ? 'active' : '' }}"
                            href="{{ url('/about/vision') }}">
                            <i class="bi bi-eye nav-icon"></i>
                            비전 & 미션
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/leadership*') ? 'active' : '' }}"
                            href="{{ url('/about/leadership') }}">
                            <i class="bi bi-people nav-icon"></i>
                            경영진
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/organization*') ? 'active' : '' }}"
                            href="{{ url('/about/organization') }}">
                            <i class="bi bi-diagram-3 nav-icon"></i>
                            조직도
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/location*') ? 'active' : '' }}"
                            href="{{ url('/about/location') }}">
                            <i class="bi bi-geo-alt nav-icon"></i>
                            오시는 길
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about/contact*') ? 'active' : '' }}"
                            href="{{ url('/about/contact') }}">
                            <i class="bi bi-telephone nav-icon"></i>
                            연락처
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<style>
    /* sidenav의 스크롤 고정 기능만 제거하고 완전히 상단에 붙이기 */
    .sidenav {
        position: static !important;
        top: auto !important;
        left: auto !important;
        height: auto !important;
        transform: none !important;
        z-index: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        border-right: none !important; /* 오른쪽 세로 점선 제거 */
    }

    /* 사이드바가 페이지와 함께 스크롤되도록 설정 */
    .sidenav-navbar {
        position: static !important;
        padding: 0 !important;
        margin: 0 !important;
        border-right: none !important; /* 오른쪽 세로 점선 제거 */
    }

    /* navbar-nav 모든 여백 제거 */
    .navbar-nav {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* navbar-collapse 여백 제거 */
    .navbar-collapse {
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 전체 사이드바 컨테이너 여백 제거 */
    .sidenav .navbar-nav,
    .sidenav .navbar-collapse,
    .sidenav-navbar .navbar-nav,
    .sidenav-navbar .navbar-collapse {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* 사이드바 전체 컨테이너에서 오른쪽 테두리 제거 */
    .sidenav,
    .sidenav *,
    .sidenav-navbar,
    .sidenav-navbar * {
        border-right: none !important;
    }
</style>
