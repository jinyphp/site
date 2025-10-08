    <nav class="navbar navbar-expand-lg">
        <div class="container px-0">
            <a class="navbar-brand" href="/"><img src="{{ asset('assets/images/brand/logo/logo.svg') }}"
                    alt="Jiny" /></a>
            <!-- Mobile view nav wrap -->
            <div class="ms-auto d-flex align-items-center order-lg-3">
                <div class="d-flex gap-2 align-items-center">
                    <a href="#langaugeModal" class="text-inherit me-2" data-bs-toggle="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-globe text-gray-500" viewBox="0 0 16 16">
                            <path
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z" />
                        </svg>
                    </a>
                    <a href="/login" class="btn btn-outline-dark">로그인</a>
                    <a href="/sign-up" class="btn btn-dark d-none d-md-block">지금 가입</a>
                </div>
            </div>
            <div>
                <!-- Button -->
                <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarBrowse" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" data-bs-display="static">카테고리</a>
                        <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarBrowse">
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">웹 개발</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Bootstrap</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">React</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">GraphQl</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Gatsby</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Grunt</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Svelte</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Meteor</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">HTML5</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Angular</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">디자인</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Graphic Design</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Illustrator</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">UX / UI Design</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Figma Design</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Adobe XD</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Sketch</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Icon Design</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/course-category">Photoshop</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">모바일 앱</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">IT 소프트웨어</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">마케팅</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">음악</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">라이프스타일</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">비즈니스</a>
                            </li>
                            <li>
                                <a href="/course-category" class="dropdown-item">사진</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarLanding"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">랜딩</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarLanding">
                            <li>
                                <h4 class="dropdown-header">랜딩</h4>
                            </li>
                            <li>
                                <a href="/" class="dropdown-item">
                                    <span>홈 기본</span>

                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    <span>홈 해외</span>

                                </a>
                            </li>
                            <li>
                                <a href="/mentor" class="dropdown-item">
                                    <span>홈 멘토</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">홈 교육</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">홈 아카데미</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">홈 강좌</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">홈 SaaS</a>
                            </li>
                            <li class="border-bottom my-2"></li>
                            <li>
                                <a href="#" class="dropdown-item">리드 강좌</a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">액세스 요청</a>
                            </li>

                            <li>
                                <a href="#" class="dropdown-item">채용 목록</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarPages"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">페이지</a>
                        <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarPages">
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">강좌</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/courses-grid">
                                            강좌 그리드

                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/courses">
                                            강좌 목록

                                        </a>
                                    </li>
                                    <li class="border-bottom my-2"></li>

                                    <li>
                                        <a class="dropdown-item" href="/course-category">강좌 카테고리 v1</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            강좌 카테고리 v2

                                        </a>
                                    </li>
                                    <li class="border-bottom my-2"></li>

                                    <li>
                                        <a class="dropdown-item" href="/course-single">강좌 상세 v1</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">강좌 상세
                                            v2</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            강좌 상세 v3

                                        </a>
                                    </li>
                                    <li class="border-bottom my-2"></li>
                                    <li>
                                        <a class="dropdown-item" href="#">강좌
                                            이어하기</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">강좌
                                            결제</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">새 강좌 추가</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">프로젝트
                                    <span class="badge bg-primary ms-2">신규</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">퀴즈
                                    <span class="badge bg-primary ms-2">신규</span>
                                </a>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">학습 경로</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#" class="dropdown-item">경로 찾아보기</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">경로
                                            상세</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">블로그</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/blog">목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/blog-single">글</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">카테고리</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">사이드바</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">채용</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">개요</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">채용 공고</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">포트폴리오</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">상세</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">
                                    <span>멘토</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/mentor">홈</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/mentor-list">목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/mentor-single">상세</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">채용</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">홈</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">그리드</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">상세</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">회사
                                            목록</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">회사
                                            상세</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">특수 페이지</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">준비 중</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">오류 404</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">유지보수
                                            모드</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">이용약관</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <hr class="mx-3" />
                            </li>

                            <li>
                                <a class="dropdown-item" href="/about">소개</a>
                            </li>

                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle" href="#">고객센터</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">고객센터</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">자주 묻는 질문</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">가이드</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">가이드
                                            상세</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="#">지원</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/pricing">가격</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">플랜 비교</a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/contact">연락처</a>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle" href="#">드롭다운 단계</a>
                                <ul class="dropdown-menu dropdown-menu-start" data-bs-popper="none">
                                    <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                    <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                    <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                    <!-- dropdown submenu open right -->
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-toggle" href="#">드롭다운 (끝)</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                            <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                        </ul>
                                    </li>

                                    <!-- dropdown submenu open left -->
                                    <li class="dropdown-submenu dropstart">
                                        <a class="dropdown-item dropdown-toggle" href="#">드롭다운 (시작)</a>
                                        <ul class="dropdown-menu" data-bs-popper="none">
                                            <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                            <li><a class="dropdown-item" href="#">드롭다운 항목</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarAccount"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">계정</a>
                        <ul class="dropdown-menu dropdown-menu-arrow" aria-labelledby="navbarAccount">
                            <li>
                                <h4 class="dropdown-header">계정</h4>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">강사
                                    <span class="badge bg-primary ms-2">신규</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="text-wrap">
                                        <h5 class="dropdown-header text-dark">강사</h5>
                                        <p class="dropdown-text mb-0">강좌 관리 및 수익 확인을 위한 강사 대시보드입니다.</p>
                                    </li>
                                    <li>
                                        <hr class="mx-3" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/instructor/dashboard">대시보드</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">프로필</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">내
                                            강좌</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">주문</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">리뷰</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="#">수강생</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">지급금</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">수익</a>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">퀴즈</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">퀴즈</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">상세</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">결과</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">수강생
                                    <span class="badge bg-primary ms-2">신규</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="text-wrap">
                                        <h5 class="dropdown-header text-dark">수강생</h5>
                                        <p class="dropdown-text mb-0">강좌 및 구독을 관리하기 위한 수강생 대시보드입니다.</p>
                                    </li>
                                    <li>
                                        <hr class="mx-3" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/student/dashboard">대시보드</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="#">구독</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="#">결제</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">청구
                                            정보</a>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">인보이스</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">인보이스</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">인보이스 상세</a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="/student/dashboard">북마크</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/student/dashboard">내 학습 경로</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">전체 강좌</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">학습
                                            경로</a>
                                    </li>

                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">퀴즈</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">퀴즈</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">퀴즈
                                                    빈 화면</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">내
                                                    퀴즈</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">퀴즈 응시</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">퀴즈 상세</a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="#">퀴즈
                                                    결과</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">인증서</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">인증서</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">내 인증서</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">학습</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#">내
                                                    학습</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">학습 상세</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">학습 경로
                                                    상세</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu dropend">
                                        <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                            href="#">내 프로젝트</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#">프로젝트
                                                    빈 화면</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="#">대시보드 프로젝트</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">프로젝트
                                                    상세</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-list-group-item dropdown-toggle"
                                    href="#">관리자</a>
                                <ul class="dropdown-menu">
                                    <li class="text-wrap">
                                        <h5 class="dropdown-header text-dark">마스터 관리자</h5>
                                        <p class="dropdown-text mb-0">강좌, 사용자, 사이트 설정을 관리하고 다양한 앱을 사용할 수 있는 마스터 관리자 대시보드입니다.</p>
                                    </li>
                                    <li>
                                        <hr class="mx-3" />
                                    </li>
                                    <li class="px-3 d-grid">
                                        <a href="#" class="btn btn-sm btn-primary">관리자로
                                            이동</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <hr class="mx-3" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="/login">로그인</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/sign-up">회원가입</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/forget-password">비밀번호 찾기</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">프로필 수정</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">보안</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">소셜
                                    프로필</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="#">알림</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">개인정보
                                    설정</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">프로필
                                    삭제</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">연동된
                                    계정</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fe fe-more-horizontal"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md" aria-labelledby="navbarDropdown">
                            <div class="list-group">
                                <a class="list-group-item list-group-item-action border-0" href="/docs">
                                    <div class="d-flex align-items-center">
                                        <i class="fe fe-file-text fs-3 text-primary"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">문서</h5>
                                            <p class="mb-0 fs-6">모든 문서 둘러보기</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action border-0"
                                    href="#">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-files fs-3 text-primary"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">스니펫</h5>
                                            <p class="mb-0 fs-6">다양한 스니펫 모음</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action border-0"
                                    href="#">
                                    <div class="d-flex align-items-center">
                                        <i class="fe fe-layers fs-3 text-primary"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">
                                                변경 이력
                                                <span class="text-primary ms-1" id="changelog"></span>
                                            </h5>
                                            <p class="mb-0 fs-6">새로운 내용 확인하기</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="list-group-item list-group-item-action border-0"
                                    href="https://geeksui.codescandy.com/geeks-rtl/" target="_blank">
                                    <div class="d-flex align-items-center">
                                        <i class="fe fe-toggle-right fs-3 text-primary"></i>
                                        <div class="ms-3">
                                            <h5 class="mb-0">RTL 데모</h5>
                                            <p class="mb-0 fs-6">RTL 페이지</p>
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
