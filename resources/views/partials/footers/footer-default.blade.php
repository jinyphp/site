@php
    use Jiny\Site\Facades\Footer;

    // Footer 설정 정보 가져오기
    $company = Footer::getCompany();
    $copyright = Footer::getCopyright();
    $logo = Footer::getLogo();
    $social = Footer::getSocial();
    $menuSections = Footer::getMenuSections();
    $companySection = Footer::getMenuSection('company');
    $communitySection = Footer::getMenuSection('community');
    $educationSection = Footer::getMenuSection('education');
    $legalSection = Footer::getMenuSection('legal');
@endphp

<!-- Footer -->
<footer class="footer bg-dark-stable py-8">
    <div class="container">
        <div class="row gy-6 gy-xl-0 pb-8">
            <div class="col-xl-3 col-lg-12 col-md-6 col-12">
                <div class="d-flex flex-column gap-4">
                    <div>
                        @if ($logo)
                            <img src="{{ asset($logo) }}" alt="{{ $company['name'] ?? 'Logo' }}" />
                        @else
                            <img src="{{ asset('assets/images/svg/geeks-logo.svg') }}" alt="geeks logo" />
                        @endif
                    </div>
                    <p class="mb-0">
                        {{ $company['description'] ?? '개발자들을 위한 풍부한 기능과 아름다운 Bootstrap UIKit을 제공하는 반응형 프레임워크입니다.' }}</p>
                    <div class="d-flex gap-2">
                        <a href="#langaugeModal" class="btn btn-outline-secondary" data-bs-toggle="modal">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                                    <path
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                                </svg>
                            </span>
                            <span class="ms-2">한국어</span>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-icon rounded-circle d-flex align-items-center"
                                type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="테마 변경 (자동)">
                                <i class="bi theme-icon-active"></i>
                                <span class="visually-hidden bs-theme-text">테마 변경</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text"
                                data-bs-theme="dark">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="light" aria-pressed="false">
                                        <i class="bi theme-icon bi-sun-fill"></i>
                                        <span class="ms-2">밝게</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark" aria-pressed="false">
                                        <i class="bi theme-icon bi-moon-stars-fill"></i>
                                        <span class="ms-2">어둡게</span>
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="auto" aria-pressed="true">
                                        <i class="bi theme-icon bi-circle-half"></i>
                                        <span class="ms-2">자동</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Section -->
            <div class="col-xl-2 col-md-3 col-6">
                <div class="d-flex flex-column gap-3">
                    <span class="text-white-stable">{{ $companySection['title'] ?? '회사' }}</span>
                    <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                        @if (!empty($companySection['links']))
                            @foreach ($companySection['links'] as $link)
                                <li>
                                    <a href="{{ $link['href'] }}" class="nav-link">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Fallback links -->
                            <li><a href="/about" class="nav-link">회사소개</a></li>
                            <li><a href="/contact" class="nav-link">문의하기</a></li>
                            <li><a href="/blog" class="nav-link">뉴스 및 블로그</a></li>
                            <li><a href="/jobs" class="nav-link">채용</a></li>
                            <li><a href="/investors" class="nav-link">투자자</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Community Section -->
            <div class="col-xl-2 col-md-3 col-6">
                <div class="d-flex flex-column gap-3">
                    <span class="text-white-stable">{{ $communitySection['title'] ?? '커뮤니티' }}</span>
                    <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                        @if (!empty($communitySection['links']))
                            @foreach ($communitySection['links'] as $link)
                                <li>
                                    <a href="{{ $link['href'] }}" class="nav-link">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Fallback links -->
                            <li><a href="/help" class="nav-link">도움말 및 지원</a></li>
                            <li><a href="/partners" class="nav-link">제휴</a></li>
                            <li><a href="/forum" class="nav-link">포룸</a></li>
                            <li><a href="/community" class="nav-link">개발자 커뮤니티</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Education Section -->
            <div class="col-xl-2 col-md-3 col-12">
                <div class="d-flex flex-column gap-3">
                    <span class="text-white-stable">{{ $educationSection['title'] ?? '교육' }}</span>
                    <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                        @if (!empty($educationSection['links']))
                            @foreach ($educationSection['links'] as $link)
                                <li>
                                    <a href="{{ $link['href'] }}" class="nav-link">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        @else
                            <!-- Fallback links -->
                            <li><a href="/instructor" class="nav-link">강사 지원</a></li>
                            <li><a href="/guide" class="nav-link">가이드</a></li>
                            <li><a href="/docs" class="nav-link">문서</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                <div class="d-flex flex-column gap-5">
                    <div class="d-flex flex-column gap-3">
                        <span class="text-white-stable">연락처</span>
                        <ul class="list-unstyled mb-0 d-flex flex-column nav nav-footer nav-x-0">
                            @if (!empty($company['phone']))
                                <li>
                                    무료 전화:
                                    <span class="fw-semibold">{{ $company['phone'] }}</span>
                                </li>
                            @endif
                            @if (!empty($company['hours']))
                                <li>
                                    운영 시간:
                                    <span class="fw-semibold">{{ $company['hours'] }}</span>
                                </li>
                            @endif
                            @if (!empty($company['email']))
                                <li>
                                    이메일:
                                    <span class="fw-semibold">{{ $company['email'] }}</span>
                                </li>
                            @endif
                            @if (!empty($company['address']))
                                <li>
                                    주소:
                                    <span class="fw-semibold">{{ $company['address'] }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="d-flex flex-row gap-2">
                        <a href="#"><img src="{{ asset('assets/images/svg/appstore.svg') }}" alt=""
                                class="img-fluid" /></a>
                        <a href="#"><img src="{{ asset('assets/images/svg/playstore.svg') }}" alt=""
                                class="img-fluid" /></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright Section -->
        <div class="row align-items-center g-0 border-top border-gray-800 pt-3 flex-column gap-1 flex-lg-row gap-lg-0">
            <!-- Copyright -->
            <div class="col-lg-6 col-12 text-center text-md-start">
                <span>
                    ©
                    <span id="copyright">
                        <script>
                            document.getElementById("copyright").appendChild(document.createTextNode(new Date().getFullYear()));
                        </script>
                    </span>
                    {{ $copyright ?: 'GeeksTheme. Powered Codescandy' }}
                </span>
            </div>

            <!-- Legal Links -->
            <div class="col-12 col-lg-6">
                <nav class="nav nav-footer justify-content-center justify-content-md-start justify-content-lg-end">
                    @if (!empty($legalSection['links']))
                        @foreach ($legalSection['links'] as $link)
                            <a class="nav-link" href="{{ $link['href'] }}">{{ $link['title'] }}</a>
                        @endforeach
                    @else
                        <!-- Fallback legal links -->
                        <a class="nav-link" href="/terms">이용약관</a>
                        <a class="nav-link" href="/privacy">개인정보처리방침</a>
                        <a class="nav-link" href="/cookies">쿠키 정책</a>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</footer>
