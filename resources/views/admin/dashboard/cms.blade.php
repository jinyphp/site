<div class="row">
    <div class="col-12 col-md-6 mb-3">
        @includeIf('jiny-site-board::admin.dashboard.post')
    </div>

    <div class="col-12 col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">
                            <a href="/admin/site/board" class="text-decoration-none">
                                게시판
                            </a>
                        </h5>
                        <h6 class="card-subtitle text-muted mb-0">
                            게시판을 관리합니다.
                        </h6>
                    </div>
                    <div>
                        <i class="bi bi-info-circle fs-4 text-muted"></i>
                    </div>
                </div>
            </div>
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>제목</th>
                        <th width="100px">작성글</th>
                        <th width="100px">생성일자</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $boards = function_exists('getBoards') ? getBoards(5) : [];
                    @endphp
                    @forelse ($boards as $item)
                    <tr>
                        <td>{{ $item->title ?? '-' }}</td>
                        <td width="100px">{{ $item->post ?? '0' }}</td>
                        <td width="100px">{{ isset($item->created_at) ? substr($item->created_at, 0, 10) : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            등록된 게시판이 없습니다.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
                            고객지원
                        </h5>
                        <h6 class="card-subtitle text-muted mb-0">
                            고객과의 소통을 통하여 문제를 해결합니다.
                        </h6>
                    </div>
                    <div>
                        <i class="bi bi-headset fs-4 text-success"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <a href="/admin/site/contact" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">Contact</span>
                </a>

                <a href="/admin/site/help" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">Help</span>
                </a>

                <a href="/admin/site/faq" class="text-decoration-none">
                    <span class="badge bg-secondary mb-2 me-1">FAQ</span>
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

</div>
