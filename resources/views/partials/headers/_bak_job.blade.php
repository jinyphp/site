<!-- 채용 포털 헤더 -->
<!-- 국가/언어 선택 바 -->
<div class="bg-dark py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="text-white-50 small me-3">글로벌 채용 플랫폼</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="countryDropdown" data-bs-toggle="dropdown">
                        <i class="fe fe-globe me-1"></i>
                        <img src="https://flagcdn.com/16x12/kr.png" alt="KR" class="me-1">
                        한국
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="countryDropdown">
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/kr.png" alt="KR" class="me-2">한국</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/us.png" alt="US" class="me-2">미국</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/jp.png" alt="JP" class="me-2">일본</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/cn.png" alt="CN" class="me-2">중국</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/sg.png" alt="SG" class="me-2">싱가포르</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/gb.png" alt="UK" class="me-2">영국</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/de.png" alt="DE" class="me-2">독일</a></li>
                        <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/ca.png" alt="CA" class="me-2">캐나다</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-success me-2"><i class="fe fe-wifi me-1"></i>원격근무 5,234개</span>
                <span class="badge bg-info"><i class="fe fe-map me-1"></i>디지털노마드 환영 1,023개</span>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <!-- 로고 -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="Jiny Jobs Global" height="30" />
        </a>

        <!-- 모바일 토글 버튼 -->
        <button class="navbar-toggler collapsed ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbar-job" aria-controls="navbar-job" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="icon-bar top-bar mt-0"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>
        </button>

        <!-- 네비게이션 메뉴 -->
        <div class="collapse navbar-collapse" id="navbar-job">
            <!-- 메인 메뉴 -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="jobsDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-briefcase me-1"></i>채용정보
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg p-3" aria-labelledby="jobsDropdown" style="min-width: 480px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="dropdown-header px-3 mb-3">채용 정보</h6>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-list me-2"></i>전체 채용공고
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-grid me-2"></i>채용공고 그리드
                                </a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 mb-1 rounded" href="#">
                                    <span><i class="fe fe-trending-up me-2"></i>인기 채용공고</span>
                                    <span class="badge bg-warning text-dark ms-3">HOT</span>
                                </a>
                                <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 rounded" href="#">
                                    <span><i class="fe fe-clock me-2"></i>마감임박 공고</span>
                                    <span class="badge bg-danger ms-3">긴급</span>
                                </a>
                            </div>
                            <div class="col-lg-6 border-start">
                                <h6 class="dropdown-header px-3 mb-3">직무별 채용</h6>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-code me-2"></i>개발자
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-layout me-2"></i>디자이너
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-trending-up me-2"></i>마케터
                                </a>
                                <a class="dropdown-item px-3 py-2 rounded" href="#">
                                    <i class="fe fe-edit me-2"></i>기획자
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="companiesDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-home me-1"></i>기업정보
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="companiesDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-list me-2"></i>기업 목록
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-info me-2"></i>기업 소개
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-star me-2"></i>기업 리뷰
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-briefcase me-2"></i>기업별 채용
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-gift me-2"></i>복리후생
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-image me-2"></i>기업 문화
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="talentDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-users me-1"></i>인재풀
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="talentDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-search me-2"></i>인재 검색
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-user-check me-2"></i>추천 인재
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-award me-2"></i>전문가 프로필
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-code me-2"></i>개발자
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-layout me-2"></i>디자이너
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-trending-up me-2"></i>마케터
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-briefcase me-2"></i>PM/기획자
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="careerDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-trending-up me-1"></i>커리어
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="careerDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-user me-2"></i>커리어 성장
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-book me-2"></i>직무 인터뷰
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-award me-2"></i>성공 스토리
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-dollar-sign me-2"></i>연봉 정보
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-bar-chart me-2"></i>취업 트렌드
                        </a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="educationDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-book-open me-1"></i>교육/취업연계
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg p-3" aria-labelledby="educationDropdown" style="min-width: 500px;">
                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="dropdown-header px-3 mb-3">교육 프로그램</h6>
                                <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 mb-1 rounded" href="#">
                                    <span><i class="fe fe-monitor me-2"></i>부트캠프</span>
                                    <span class="badge bg-danger ms-4">HOT</span>
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-code me-2"></i>개발자 과정
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-layout me-2"></i>디자이너 과정
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-database me-2"></i>데이터 분석 과정
                                </a>
                                <a class="dropdown-item px-3 py-2 rounded" href="#">
                                    <i class="fe fe-trending-up me-2"></i>마케팅 과정
                                </a>
                            </div>
                            <div class="col-lg-6 border-start">
                                <h6 class="dropdown-header px-3 mb-3">취업 연계</h6>
                                <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2 mb-1 rounded" href="#">
                                    <span><i class="fe fe-award me-2"></i>국비지원 교육</span>
                                    <span class="badge bg-success ms-4">무료</span>
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-briefcase me-2"></i>취업 보장 과정
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-users me-2"></i>기업 연계 프로그램
                                </a>
                                <a class="dropdown-item px-3 py-2 mb-1 rounded" href="#">
                                    <i class="fe fe-gift me-2"></i>취업 성공 패키지
                                </a>
                                <a class="dropdown-item px-3 py-2 rounded" href="#">
                                    <i class="fe fe-check-circle me-2"></i>수료생 현황
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-file-text me-1"></i>취업 지원
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-upload me-2"></i>이력서 업로드
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-edit-3 me-2"></i>이력서 작성법
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-users me-2"></i>면접 가이드
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-check-circle me-2"></i>합격 자소서
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fe fe-book-open me-2"></i>취업 블로그
                        </a></li>
                    </ul>
                </li>

                <!-- 모바일용 버튼들 -->
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="#">로그인</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="#">회원가입</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="#">
                        <i class="fe fe-plus me-1"></i>채용공고 등록
                    </a>
                </li>
            </ul>

            <!-- 우측 버튼 영역 -->
            <div class="d-flex align-items-center">
                <!-- 검색 버튼 (간단) -->
                <button class="btn btn-ghost btn-icon d-none d-lg-block me-2" type="button" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="fe fe-search"></i>
                </button>

                <!-- 알림 아이콘 -->
                <div class="dropdown d-none d-lg-block me-2">
                    <button class="btn btn-ghost btn-icon" type="button" id="notificationDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fe fe-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            3
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                        <li class="dropdown-header">알림 (3개)</li>
                        <li><a class="dropdown-item" href="#">
                            <small class="text-muted">2시간 전</small><br>
                            <strong>네이버</strong>에서 이력서를 열람했습니다
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <small class="text-muted">5시간 전</small><br>
                            <strong>카카오</strong> 지원 결과가 발표되었습니다
                        </a></li>
                        <li><a class="dropdown-item" href="#">
                            <small class="text-muted">1일 전</small><br>
                            관심 기업 <strong>토스</strong>에서 신규 채용을 시작했습니다
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#">모든 알림 보기</a></li>
                    </ul>
                </div>

                <!-- 로그인/회원가입 버튼 -->
                <a href="#" class="btn btn-outline-primary btn-sm me-2 d-none d-lg-block">로그인</a>
                <a href="#" class="btn btn-primary btn-sm me-2 d-none d-lg-block">회원가입</a>

                <!-- 기업회원 채용공고 등록 버튼 -->
                <a href="#" class="btn btn-success btn-sm d-none d-lg-block">
                    <i class="fe fe-plus me-1"></i>채용공고 등록
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- 검색 모달 -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel">채용 검색</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">직무/회사명</label>
                            <input type="text" class="form-control" placeholder="예: 프론트엔드, 네이버">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">지역</label>
                            <select class="form-select">
                                <option selected>전체</option>
                                <option>서울</option>
                                <option>경기</option>
                                <option>인천</option>
                                <option>부산</option>
                                <option>대구</option>
                                <option>대전</option>
                                <option>광주</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">경력</label>
                            <select class="form-select">
                                <option selected>전체</option>
                                <option>신입</option>
                                <option>1-3년</option>
                                <option>3-5년</option>
                                <option>5-10년</option>
                                <option>10년 이상</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">고용형태</label>
                            <select class="form-select">
                                <option selected>전체</option>
                                <option>정규직</option>
                                <option>계약직</option>
                                <option>인턴</option>
                                <option>프리랜서</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">연봉</label>
                            <select class="form-select">
                                <option selected>전체</option>
                                <option>~3000만원</option>
                                <option>3000-4000만원</option>
                                <option>4000-5000만원</option>
                                <option>5000-7000만원</option>
                                <option>7000만원~</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary">검색</button>
            </div>
        </div>
    </div>
</div>