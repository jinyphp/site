<style>
.hover-bg-light:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.hover-bg-light {
    transition: all 0.2s ease;
}

.help-section-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    height: 100%;
    transition: all 0.3s ease;
    background: #fff;
}

.help-section-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #dee2e6;
}

.icon-wrapper {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.help-section-card:hover .icon-wrapper {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.text-sm {
    font-size: 0.875rem;
}

.help-section-card .btn {
    transition: all 0.2s ease;
}

.help-section-card .btn:hover {
    transform: translateY(-1px);
}

.card-header {
    border-bottom: 1px solid #e9ecef;
    background-color: #fff;
}
</style>

<div class="row">
    <!-- Board Management 전체 섹션 -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1 text-primary">
                            <i class="bi bi-journal-text me-2"></i>게시판 관리 시스템
                        </h4>
                        <p class="card-subtitle text-muted mb-0">
                            다양한 게시판과 게시글을 효율적으로 관리하는 종합 시스템
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-info">운영중</span>
                        <i class="bi bi-gear text-muted" style="cursor: pointer;" title="설정"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- 게시판 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary rounded-circle me-3">
                                    <i class="bi bi-list-ul text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Board List</h5>
                                    <small class="text-muted">게시판 목록</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>활성 게시판</span>
                                    <span class="fw-bold text-primary">8</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>비활성</span>
                                    <span class="fw-bold text-muted">2</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>총 카테고리</span>
                                    <span class="fw-bold text-primary">15</span>
                                </div>
                            </div>
                            <a href="/admin/cms/board/list" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>게시판 관리
                            </a>
                        </div>
                    </div>

                    <!-- 게시글 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-success rounded-circle me-3">
                                    <i class="bi bi-file-earmark-text text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Posts</h5>
                                    <small class="text-muted">게시글 관리</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>전체 게시글</span>
                                    <span class="fw-bold text-success">1,247</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>오늘 작성</span>
                                    <span class="fw-bold text-success">12</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>대기중</span>
                                    <span class="fw-bold text-warning">3</span>
                                </div>
                            </div>
                            <a href="/admin/cms/board/posts" class="btn btn-outline-success btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>게시글 관리
                            </a>
                        </div>
                    </div>

                    <!-- 댓글 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-warning rounded-circle me-3">
                                    <i class="bi bi-chat-left-text text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Comments</h5>
                                    <small class="text-muted">댓글 관리</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>전체 댓글</span>
                                    <span class="fw-bold text-warning">856</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>오늘 댓글</span>
                                    <span class="fw-bold text-warning">24</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>신고됨</span>
                                    <span class="fw-bold text-danger">1</span>
                                </div>
                            </div>
                            <a href="/admin/cms/board/comments" class="btn btn-outline-warning btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>댓글 관리
                            </a>
                        </div>
                    </div>

                    <!-- 통계 및 분석 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info rounded-circle me-3">
                                    <i class="bi bi-graph-up-arrow text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Analytics</h5>
                                    <small class="text-muted">통계 분석</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>일일 방문</span>
                                    <span class="fw-bold text-info">2.3K</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>인기 게시판</span>
                                    <span class="fw-bold text-info">공지사항</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>평균 조회수</span>
                                    <span class="fw-bold text-info">78</span>
                                </div>
                            </div>
                            <a href="/admin/cms/board" class="btn btn-outline-info btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>통계 보기
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 최근 게시글 목록 -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="border-top pt-3">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-clock-history me-1"></i>최근 게시글
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>게시판</th>
                                            <th>제목</th>
                                            <th>작성자</th>
                                            <th>조회수</th>
                                            <th>작성일</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $boards = function_exists('getBoards') ? getBoards(5) : [];
                                        @endphp
                                        @forelse ($boards as $item)
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $item->title ?? '공지사항' }}</span>
                                            </td>
                                            <td>
                                                <a href="#" class="text-decoration-none">{{ $item->title ?? '새로운 업데이트 공지' }}</a>
                                            </td>
                                            <td>
                                                <small class="text-muted">관리자</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $item->post ?? rand(50, 200) }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ isset($item->created_at) ? substr($item->created_at, 0, 10) : date('Y-m-d') }}</small>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">공지사항</span>
                                            </td>
                                            <td>
                                                <a href="#" class="text-decoration-none">시스템 점검 안내</a>
                                            </td>
                                            <td>
                                                <small class="text-muted">관리자</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">156</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ date('Y-m-d') }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">자유게시판</span>
                                            </td>
                                            <td>
                                                <a href="#" class="text-decoration-none">신규 기능 소개</a>
                                            </td>
                                            <td>
                                                <small class="text-muted">사용자1</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">89</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ date('Y-m-d', strtotime('-1 day')) }}</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">Q&A</span>
                                            </td>
                                            <td>
                                                <a href="#" class="text-decoration-none">사용법 문의</a>
                                            </td>
                                            <td>
                                                <small class="text-muted">사용자2</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">42</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ date('Y-m-d', strtotime('-2 days')) }}</small>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            마케팅
                        </h5>
                        <h6 class="card-subtitle text-muted mb-0">
                            사이트 활성화를 위한 콘텐츠를 관리합니다.
                        </h6>
                    </div>
                    <div>
                        <i class="bi bi-megaphone fs-4 text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="/admin/site/sliders" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">슬라이더</span>
                </a>

                <a href="/admin/site/banner" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">배너</span>
                </a>

                <a href="/admin/site/event" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">Event</span>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            알람 및 메시징
                        </h5>
                        <h6 class="card-subtitle text-muted mb-0">
                            회원 대상으로 알람 및 메시징을 관리합니다.
                        </h6>
                    </div>
                    <div>
                        <i class="bi bi-bell fs-4 text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="/admin/site/notification" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">Notification</span>
                </a>

                <a href="/admin/site/subscribe" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">구독</span>
                </a>
            </div>
        </div>
    </div>


    <div class="col-12 col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            분석
                        </h5>
                        <h6 class="card-subtitle text-muted mb-0">
                            사이트 활동을 분석합니다.
                        </h6>
                    </div>
                    <div>
                        <i class="bi bi-graph-up fs-4 text-info"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="/admin/site/seo" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">SEO분석</span>
                </a>

                <a href="/admin/site/log" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">로그분석</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Help & Support 전체 섹션 -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1 text-primary">
                            <i class="bi bi-headset me-2"></i>고객지원 & Help Center
                        </h4>
                        <p class="card-subtitle text-muted mb-0">
                            고객과의 소통 및 문제 해결을 위한 종합 관리 시스템
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-success">활성</span>
                        <i class="bi bi-gear text-muted" style="cursor: pointer;" title="설정"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Contact 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-primary rounded-circle me-3">
                                    <i class="bi bi-envelope text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Contact</h5>
                                    <small class="text-muted">문의 관리</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>신규 문의</span>
                                    <span class="fw-bold text-primary">12</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>처리 중</span>
                                    <span class="fw-bold text-warning">8</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>완료</span>
                                    <span class="fw-bold text-success">156</span>
                                </div>
                            </div>
                            <a href="/admin/site/contact" class="btn btn-outline-primary btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>문의 관리
                            </a>
                        </div>
                    </div>

                    <!-- Help 문서 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-info rounded-circle me-3">
                                    <i class="bi bi-question-circle text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Help Docs</h5>
                                    <small class="text-muted">도움말 관리</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>카테고리</span>
                                    <span class="fw-bold text-info">8</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>문서</span>
                                    <span class="fw-bold text-info">42</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>조회수 (월)</span>
                                    <span class="fw-bold text-info">1.2K</span>
                                </div>
                            </div>
                            <a href="/admin/cms/help" class="btn btn-outline-info btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>도움말 관리
                            </a>
                        </div>
                    </div>

                    <!-- FAQ 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-warning rounded-circle me-3">
                                    <i class="bi bi-patch-question text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">FAQ</h5>
                                    <small class="text-muted">자주 묻는 질문</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>FAQ 수</span>
                                    <span class="fw-bold text-warning">24</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>카테고리</span>
                                    <span class="fw-bold text-warning">6</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>인기 FAQ</span>
                                    <span class="fw-bold text-warning">5</span>
                                </div>
                            </div>
                            <a href="/admin/cms/faq" class="btn btn-outline-warning btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>FAQ 관리
                            </a>
                        </div>
                    </div>

                    <!-- Support 티켓 관리 -->
                    <div class="col-md-3">
                        <div class="help-section-card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-wrapper bg-success rounded-circle me-3">
                                    <i class="bi bi-life-preserver text-white fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Support</h5>
                                    <small class="text-muted">기술지원 관리</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>진행 중 티켓</span>
                                    <span class="fw-bold text-success">3</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm mb-1">
                                    <span>해결됨</span>
                                    <span class="fw-bold text-success">89</span>
                                </div>
                                <div class="d-flex justify-content-between text-sm">
                                    <span>평균 응답시간</span>
                                    <span class="fw-bold text-success">2h</span>
                                </div>
                            </div>
                            <a href="/admin/cms/support" class="btn btn-outline-success btn-sm w-100">
                                <i class="bi bi-arrow-right me-1"></i>지원 관리
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 최근 활동 요약 -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="border-top pt-3">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-clock-history me-1"></i>최근 활동
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle p-1 me-2" style="width: 8px; height: 8px;"></div>
                                        <small class="text-muted">새로운 문의가 도착했습니다</small>
                                        <span class="ms-auto text-muted small">2분 전</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle p-1 me-2" style="width: 8px; height: 8px;"></div>
                                        <small class="text-muted">Support 티켓이 해결되었습니다</small>
                                        <span class="ms-auto text-muted small">15분 전</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info rounded-circle p-1 me-2" style="width: 8px; height: 8px;"></div>
                                        <small class="text-muted">Help 문서가 업데이트되었습니다</small>
                                        <span class="ms-auto text-muted small">1시간 전</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle p-1 me-2" style="width: 8px; height: 8px;"></div>
                                        <small class="text-muted">새로운 FAQ가 추가되었습니다</small>
                                        <span class="ms-auto text-muted small">3시간 전</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
