<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="vh-100" data-simplebar>
        <!-- Brand logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/images/brand/logo/logo-inverse.svg') }}" alt="Jiny" />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navDashboard" aria-expanded="false" aria-controls="navDashboard">
                    <i class="nav-icon fe fe-home me-2"></i>
                    대시보드
                </a>
                <div id="navDashboard" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/auth">
                                <i class="fe fe-activity me-2"></i>
                                개요
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fe fe-bar-chart me-2"></i>
                                분석
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navAuth" aria-expanded="false" aria-controls="navAuth">
                    <i class="nav-icon fe fe-lock me-2"></i>
                    Auth
                </a>
                <div id="navAuth" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.users.index') }}">
                                <i class="fe fe-users me-2"></i>
                                사용자 목록
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.users.create') }}">
                                <i class="fe fe-user-plus me-2"></i>
                                사용자 추가
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.user.types.index') }}">
                                <i class="fe fe-tag me-2"></i>
                                사용자 유형
                            </a>
                        </li>
                        {{-- 사용자 등급 (라우트 미정의)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.grades.index') }}">
                                <i class="fe fe-award me-2"></i>
                                사용자 등급
                            </a>
                        </li>
                        --}}
                        {{-- 이용약관 (라우트 미정의)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.terms.index') }}">
                                <i class="fe fe-file-text me-2"></i>
                                이용약관
                            </a>
                        </li>
                        --}}
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fe fe-shield me-2"></i>
                                권한 관리
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- 사용자 정보 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navUserInfo" aria-expanded="false" aria-controls="navUserInfo">
                    <i class="nav-icon fe fe-database me-2"></i>
                    사용자 정보
                </a>
                <div id="navUserInfo" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.address.index') }}">
                                <i class="fe fe-map-pin me-2"></i>
                                주소 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.phone.index') }}">
                                <i class="fe fe-phone me-2"></i>
                                전화번호 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.social.index') }}">
                                <i class="fe fe-share-2 me-2"></i>
                                소셜 계정
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            {{-- 사용자 설정 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navUserSettings" aria-expanded="false" aria-controls="navUserSettings">
                    <i class="nav-icon fe fe-sliders me-2"></i>
                    사용자 설정
                </a>
                <div id="navUserSettings" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.country.index') }}">
                                <i class="fe fe-globe me-2"></i>
                                국가 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.language.index') }}">
                                <i class="fe fe-message-circle me-2"></i>
                                언어 관리
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            {{-- 보안 관리 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navSecurity" aria-expanded="false" aria-controls="navSecurity">
                    <i class="nav-icon fe fe-shield me-2"></i>
                    보안 관리
                </a>
                <div id="navSecurity" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.blacklist.index') }}">
                                <i class="fe fe-slash me-2"></i>
                                블랙리스트
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.reserved.index') }}">
                                <i class="fe fe-alert-triangle me-2"></i>
                                예약어 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.logs.index') }}">
                                <i class="fe fe-activity me-2"></i>
                                사용자 로그
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            {{-- 커뮤니케이션 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navCommunication" aria-expanded="false" aria-controls="navCommunication">
                    <i class="nav-icon fe fe-mail me-2"></i>
                    커뮤니케이션
                </a>
                <div id="navCommunication" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.message.index') }}">
                                <i class="fe fe-send me-2"></i>
                                메시지 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.review.index') }}">
                                <i class="fe fe-star me-2"></i>
                                리뷰 관리
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            {{-- 금융 관리 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navFinance" aria-expanded="false" aria-controls="navFinance">
                    <i class="nav-icon fe fe-dollar-sign me-2"></i>
                    금융 관리
                </a>
                <div id="navFinance" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.emoney.index') }}">
                                <i class="fe fe-credit-card me-2"></i>
                                전자지갑 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.emoney.deposits') }}">
                                <i class="fe fe-download me-2"></i>
                                입금 관리
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.emoney.withdrawals') }}">
                                <i class="fe fe-upload me-2"></i>
                                출금 관리
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            {{-- 통합 설정 (라우트 미정의)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navIntegration" aria-expanded="false" aria-controls="navIntegration">
                    <i class="nav-icon fe fe-link me-2"></i>
                    통합 설정
                </a>
                <div id="navIntegration" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auth.oauth.providers.index') }}">
                                <i class="fe fe-share-2 me-2"></i>
                                소셜 로그인 프로바이더
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            --}}

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                    data-bs-target="#navSettings" aria-expanded="false" aria-controls="navSettings">
                    <i class="nav-icon fe fe-settings me-2"></i>
                    Settings
                </a>
                <div id="navSettings" class="collapse" data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fe fe-globe me-2"></i>
                                General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fe fe-lock me-2"></i>
                                Security
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fe fe-mail me-2"></i>
                                Email
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon fe fe-file-text me-2"></i>
                    Reports
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="nav-icon fe fe-help-circle me-2"></i>
                    Help & Support
                </a>
            </li>
        </ul>

        <!-- Navbar nav -->
        <div class="card bg-dark-primary shadow-none text-center mx-4 mt-5">
            <div class="card-body py-4">
                <h5 class="text-white-50">Need Help?</h5>
                <p class="text-white-50 fs-6">Check our docs</p>
                <a href="#" class="btn btn-white btn-sm">Documentation</a>
            </div>
        </div>
    </div>
</nav>