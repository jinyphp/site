<!-- Sidebar -->
<style>
.navbar-heading {
    color: #8a94a6 !important;
    font-weight: 600 !important;
    font-size: 0.75rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 0.5rem !important;
    padding: 0.75rem 1.5rem 0.25rem 1.5rem !important;
}

.navbar-vertical .navbar-nav .navbar-heading:not(:first-child) {
    margin-top: 2rem !important;
}
</style>

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


            <li class="nav-item">
                <div class="navbar-heading">영업지원</div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.contact.index') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    상담요청
                </a>
            </li>

            {{-- @includeIf("jiny-store::partials.admin.menu") --}}


            {{-- ============================================
                고객지원
            ============================================ --}}
            <li class="nav-item">
                <div class="navbar-heading">고객지원</div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.help.dashboard') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    Help Center
                </a>
            </li>

            {{-- Help 관리 --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navHelp" aria-expanded="false" aria-controls="navHelp">
                    <i class="nav-icon fe fe-life-buoy me-2"></i>
                    Help 문서
                </a>
                <div id="navHelp" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.help.categories.index') }}">
                                <i class="fe fe-folder me-2"></i>
                                카테고리 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.help.docs.index') }}">
                                <i class="fe fe-file-text me-2"></i>
                                Help 문서
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            {{-- FAQ 관리 --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navFaq" aria-expanded="false" aria-controls="navFaq">
                    <i class="nav-icon fe fe-help-circle me-2"></i>
                    FAQ 관리
                </a>
                <div id="navFaq" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.faq.categories.index') }}">
                                <i class="bi bi-folder me-2"></i>
                                카테고리 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.faq.faqs.index') }}">
                                <i class="bi bi-chat-square-text me-2"></i>
                                FAQ 목록
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- 지원 요청 관리 --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navSupport" aria-expanded="false" aria-controls="navSupport">
                    <i class="nav-icon fe fe-headphones me-2"></i>
                    지원 요청 관리
                </a>
                <div id="navSupport" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.support.index') }}">
                                <i class="fe fe-pie-chart me-2"></i>
                                대시보드
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.support.requests.index') }}">
                                <i class="fe fe-list me-2"></i>
                                지원 요청 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.support.types.index') }}">
                                <i class="fe fe-settings me-2"></i>
                                지원 유형 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.support.templates.index') }}">
                                <i class="fe fe-file-text me-2"></i>
                                응답 템플릿
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.support.export') }}">
                                <i class="fe fe-download me-2"></i>
                                데이터 내보내기
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- 계시물 관리 --}}
            <li class="nav-item">
                <div class="navbar-heading">컨덴츠</div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.welcome.index') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    Welcome
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.blocks.index') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    Block
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.pages.index') }}">
                    <i class="nav-icon fe fe-grid me-2"></i>
                    Pages
                </a>
            </li>

            {{-- About 관리 --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navAbout" aria-expanded="false" aria-controls="navAbout">
                    <i class="nav-icon fe fe-info me-2"></i>
                    회사 소개
                </a>
                <div id="navAbout" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.about.history.index') }}">
                                <i class="bi bi-clock-history me-2"></i>
                                회사 연혁
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.about.location.index') }}">
                                <i class="bi bi-geo-alt me-2"></i>
                                위치 정보
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.about.organization.index') }}">
                                <i class="bi bi-diagram-3 me-2"></i>
                                조직 정보
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- jiny/post 패키지 --}}
            @includeIf("jiny-post::partials.admin.menu")

            {{-- ============================================
                서비스
            ============================================ --}}
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navServices" aria-expanded="false" aria-controls="navServices">
                    <i class="bi bi-briefcase me-2"></i>
                    Services
                </a>
                <div id="navServices" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.services.index') }}">
                                <i class="bi bi-list me-2"></i>
                                서비스 목록
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.site.services.categories.index') }}">
                                <i class="bi bi-tags me-2"></i>
                                서비스 카테고리
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.site.testimonials.index') }}">
                    <i class="bi bi-chat-quote me-2"></i>
                    리뷰
                </a>
            </li>




            {{-- 마케팅 --}}
            <li class="nav-item">
                <div class="navbar-heading">마케팅</div>
            </li>



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

                    </ul>
                </div>
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

            {{-- ============================================
                설정
            ============================================ --}}
            <li class="nav-item">
                <div class="navbar-heading">설정</div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navSettings" aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon fe fe-settings me-2"></i>
                    시스템 설정
                </a>
                <div id="navSettings" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.language.index') }}">
                                <i class="bi bi-translate me-2"></i>
                                언어 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.country.index') }}">
                                <i class="bi bi-globe2 me-2"></i>
                                국가 관리
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.currencies.index') }}">
                                <i class="fe fe-dollar-sign me-2"></i>
                                통화 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.exchange-rates.index') }}">
                                <i class="fe fe-trending-up me-2"></i>
                                환율 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.tax.index') }}">
                                <i class="fe fe-percent me-2"></i>
                                세율 관리
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>

            {{-- ============================================
                템플릿 관리
            ============================================ --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navTemplates" aria-expanded="false" aria-controls="navTemplates">
                    <i class="nav-icon fe fe-layout me-2"></i>
                    템플릿 관리
                </a>
                <div id="navTemplates" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.templates.layout.index') }}">
                                <i class="bi bi-grid-3x3 me-2"></i>
                                레이아웃
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.templates.header.index') }}">
                                <i class="bi bi-layout-text-window-reverse me-2"></i>
                                헤더
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.templates.footer.index') }}">
                                <i class="bi bi-layout-text-window me-2"></i>
                                푸터
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.templates.sidebar.index') }}">
                                <i class="bi bi-layout-sidebar-inset me-2"></i>
                                사이드바
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cms.templates.nav.index') }}">
                                <i class="bi bi-list me-2"></i>
                                네비게이션
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            {{-- menu --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.cms.menu.index') }}">
                    <i class="bi bi-menu-button-wide me-2"></i>
                    메뉴 관리
                </a>
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
