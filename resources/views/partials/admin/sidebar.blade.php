<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/images/brand/logo/logo-inverse.svg') }}" alt="Jiny" />
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">

            {{-- ============================================
                대시보드
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link" href="/admin/auth">
                    <i class="nav-icon fe fe-home me-2"></i>
                    대시보드
                </a>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

            {{-- ============================================
                CMS 대시보드
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.dashboard') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    CMS 대시보드
                </a>
            </li>

            {{-- ============================================
                고객지원
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navCustomerSupport" aria-expanded="false" aria-controls="navCustomerSupport">
                    <i class="nav-icon fe fe-headphones me-2"></i>
                    고객지원
                </a>
                <div id="navCustomerSupport" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.contact.index') }}">
                                <i class="bi bi-envelope me-2"></i>
                                Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.faq.index') }}">
                                <i class="bi bi-question-circle me-2"></i>
                                FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.help.index') }}">
                                <i class="bi bi-life-preserver me-2"></i>
                                Help
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ============================================
                마케팅
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navMarketing" aria-expanded="false" aria-controls="navMarketing">
                    <i class="nav-icon fe fe-trending-up me-2"></i>
                    마케팅
                </a>
                <div id="navMarketing" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.sliders.index') }}">
                                <i class="bi bi-images me-2"></i>
                                Sliders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.banner.index') }}">
                                <i class="bi bi-megaphone me-2"></i>
                                Banner
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.event.index') }}">
                                <i class="bi bi-calendar-event me-2"></i>
                                Event
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ============================================
                알림
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.site.notification.index') }}">
                    <i class="nav-icon fe fe-bell me-2"></i>
                    Notification
                </a>
            </li>

            {{-- ============================================
                게시판
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navBoard" aria-expanded="false" aria-controls="navBoard">
                    <i class="nav-icon fe fe-message-square me-2"></i>
                    게시판
                </a>
                <div id="navBoard" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.board.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                대시보드
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.board.list') }}">
                                <i class="bi bi-layout-text-sidebar me-2"></i>
                                게시판 목록
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.board.table') }}">
                                <i class="bi bi-file-text me-2"></i>
                                게시글
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.board.related') }}">
                                <i class="bi bi-link-45deg me-2"></i>
                                관련글
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.board.trend') }}">
                                <i class="bi bi-graph-up-arrow me-2"></i>
                                트렌드글
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ============================================
                분석
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navAnalytics" aria-expanded="false" aria-controls="navAnalytics">
                    <i class="nav-icon fe fe-bar-chart-2 me-2"></i>
                    분석
                </a>
                <div id="navAnalytics" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.seo.index') }}">
                                <i class="bi bi-search me-2"></i>
                                SEO 분석
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.log.index') }}">
                                <i class="bi bi-graph-up me-2"></i>
                                Log 분석
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <div class="nav-divider"></div>
            </li>

        </ul>

        <!-- Help Card -->
        <div class="card bg-dark-primary shadow-none text-center mx-4 mt-5">
            <div class="card-body py-4">
                <h5 class="text-white-50">도움이 필요하신가요?</h5>
                <p class="text-white-50 fs-6 mb-3">CMS 관리 문서를 확인하세요</p>
                <a href="{{ route('admin.cms.dashboard') }}" class="btn btn-white btn-sm">
                    CMS 대시보드 바로가기
                </a>
            </div>
        </div>
    </div>
</nav>
