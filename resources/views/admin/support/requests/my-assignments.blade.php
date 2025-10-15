@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '내 할당 요청')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="fe fe-user me-2"></i>
                                내 할당 요청
                            </h1>
                            <p class="page-header-subtitle">나에게 할당된 지원 요청을 관리합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>전체 요청
                            </a>
                            <a href="{{ route('admin.support.auto-assignments.index') }}" class="btn btn-outline-warning">
                                <i class="fe fe-settings me-2"></i>자동 할당 설정
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 내 통계 요약 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-2">
                                <i class="fe fe-activity me-2"></i>
                                내 할당 현황
                            </h5>
                            <p class="text-muted mb-0">{{ Auth::user()->name }}님에게 할당된 요청 현황입니다.</p>
                        </div>
                        <div class="d-flex gap-4">
                            <div class="text-center">
                                <div class="fs-3 fw-bold text-primary">{{ $statistics['total'] }}</div>
                                <div class="text-muted small">전체</div>
                            </div>
                            <div class="text-center">
                                <div class="fs-3 fw-bold text-warning">{{ $statistics['pending'] }}</div>
                                <div class="text-muted small">대기중</div>
                            </div>
                            <div class="text-center">
                                <div class="fs-3 fw-bold text-info">{{ $statistics['in_progress'] }}</div>
                                <div class="text-muted small">처리중</div>
                            </div>
                            <div class="text-center">
                                <div class="fs-3 fw-bold text-success">{{ $statistics['resolved'] }}</div>
                                <div class="text-muted small">해결완료</div>
                            </div>
                            <div class="text-center">
                                <div class="fs-3 fw-bold text-secondary">{{ $statistics['closed'] }}</div>
                                <div class="text-muted small">종료</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 추가 통계 -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">오늘 할당</h6>
                    <div class="fs-4 fw-bold text-primary">{{ $todayAssigned }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">이번 주 할당</h6>
                    <div class="fs-4 fw-bold text-info">{{ $weekAssigned }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">평균 처리시간</h6>
                    <div class="fs-4 fw-bold text-success">{{ $avgResponseTime }}시간</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="card-title">처리 중인 요청</h6>
                    <div class="fs-4 fw-bold text-warning">{{ $statistics['in_progress'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.support.requests.my-assignments') }}">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="status" class="form-label">상태</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">전체</option>
                                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>대기중</option>
                                    <option value="in_progress" {{ $currentStatus === 'in_progress' ? 'selected' : '' }}>처리중</option>
                                    <option value="resolved" {{ $currentStatus === 'resolved' ? 'selected' : '' }}>해결완료</option>
                                    <option value="closed" {{ $currentStatus === 'closed' ? 'selected' : '' }}>종료</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="type" class="form-label">유형</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">전체</option>
                                    <option value="technical" {{ $currentType === 'technical' ? 'selected' : '' }}>기술 지원</option>
                                    <option value="billing" {{ $currentType === 'billing' ? 'selected' : '' }}>결제 문의</option>
                                    <option value="general" {{ $currentType === 'general' ? 'selected' : '' }}>일반 문의</option>
                                    <option value="bug_report" {{ $currentType === 'bug_report' ? 'selected' : '' }}>버그 리포트</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="priority" class="form-label">우선순위</label>
                                <select name="priority" id="priority" class="form-select">
                                    <option value="">전체</option>
                                    <option value="urgent" {{ $currentPriority === 'urgent' ? 'selected' : '' }}>긴급</option>
                                    <option value="high" {{ $currentPriority === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="normal" {{ $currentPriority === 'normal' ? 'selected' : '' }}>보통</option>
                                    <option value="low" {{ $currentPriority === 'low' ? 'selected' : '' }}>낮음</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_from" class="form-label">시작일</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $currentDateFrom }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to" class="form-label">종료일</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $currentDateTo }}">
                            </div>
                            <div class="col-md-2">
                                <label for="search" class="form-label">검색</label>
                                <div class="input-group">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="제목, 내용, 요청자..." value="{{ $currentSearch }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fe fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-2"></i>필터 적용
                                </button>
                                <a href="{{ route('admin.support.requests.my-assignments') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>초기화
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 요청 목록 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">내 할당 요청 목록</h4>
                    <div>
                        <span class="text-muted">총 {{ $supports->total() }}개</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($supports->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>제목</th>
                                        <th>유형</th>
                                        <th>우선순위</th>
                                        <th>상태</th>
                                        <th>요청자</th>
                                        <th>등록일</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supports as $support)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.cms.support.requests.show', $support->id) }}" class="text-decoration-none">
                                                {{ Str::limit($support->subject, 50) }}
                                            </a>
                                            @if($support->latestAssignment && $support->latestAssignment->action === 'self_assign')
                                                <span class="badge bg-info ms-2">자가할당</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($support->type === 'technical')
                                                <span class="badge bg-info">기술 지원</span>
                                            @elseif($support->type === 'billing')
                                                <span class="badge bg-warning">결제 문의</span>
                                            @elseif($support->type === 'general')
                                                <span class="badge bg-secondary">일반 문의</span>
                                            @elseif($support->type === 'bug_report')
                                                <span class="badge bg-danger">버그 리포트</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $support->type }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($support->priority === 'urgent')
                                                <span class="badge bg-danger">긴급</span>
                                            @elseif($support->priority === 'high')
                                                <span class="badge bg-warning">높음</span>
                                            @elseif($support->priority === 'normal')
                                                <span class="badge bg-info">보통</span>
                                            @elseif($support->priority === 'low')
                                                <span class="badge bg-secondary">낮음</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $support->priority }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($support->status === 'pending')
                                                <span class="badge bg-warning">대기중</span>
                                            @elseif($support->status === 'in_progress')
                                                <span class="badge bg-info">처리중</span>
                                            @elseif($support->status === 'resolved')
                                                <span class="badge bg-success">해결완료</span>
                                            @elseif($support->status === 'closed')
                                                <span class="badge bg-secondary">종료</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $support->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($support->user)
                                                {{ $support->user->name }}
                                                <br>
                                                <small class="text-muted">{{ $support->user->email }}</small>
                                            @else
                                                {{ $support->name ?? '익명' }}
                                                @if($support->email)
                                                    <br>
                                                    <small class="text-muted">{{ $support->email }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $support->created_at ? \Carbon\Carbon::parse($support->created_at)->format('Y-m-d H:i') : '' }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.cms.support.requests.show', $support->id) }}"
                                                   class="btn btn-outline-primary btn-sm" title="상세보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                @if($support->canBeAssigned())
                                                    <button type="button" class="btn btn-outline-warning btn-sm"
                                                            onclick="showTransferModal({{ $support->id }})" title="다른 관리자에게 이전">
                                                        <i class="fe fe-arrow-right"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                        onclick="showAssignmentHistory({{ $support->id }})" title="할당 이력">
                                                    <i class="fe fe-clock"></i>
                                                </button>
                                                <a href="{{ route('admin.cms.support.requests.edit', $support->id) }}"
                                                   class="btn btn-outline-secondary btn-sm" title="답변 작성">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- 페이지네이션 -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $supports->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fe fe-inbox fs-1 mb-3"></i>
                            <h5>할당된 요청이 없습니다</h5>
                            <p>현재 나에게 할당된 지원 요청이 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 이전 모달 -->
<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">다른 관리자에게 이전</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="transferForm">
                    <div class="mb-3">
                        <label for="newAssigneeSelect" class="form-label">새 담당자 선택</label>
                        <select class="form-select" id="newAssigneeSelect" name="new_assignee_id" required>
                            <option value="">담당자를 선택하세요</option>
                            <!-- 관리자 목록은 JavaScript로 로드 -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transferNote" class="form-label">이전 사유</label>
                        <textarea class="form-control" id="transferNote" name="note" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-warning" onclick="transferRequest()">이전하기</button>
            </div>
        </div>
    </div>
</div>

<!-- 할당 이력 모달 -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">할당 이력</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="historyContent">
                    <div class="text-center py-3">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">로딩 중...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentSupportId = null;

// 이전 모달 표시
function showTransferModal(id) {
    currentSupportId = id;

    // 관리자 목록 로드
    fetch('/admin/cms/support/requests/admins')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const select = document.getElementById('newAssigneeSelect');
            select.innerHTML = '<option value="">담당자를 선택하세요</option>';
            data.admins.forEach(admin => {
                select.innerHTML += `<option value="${admin.id}">${admin.name} (${admin.email})</option>`;
            });
        }
    });

    const modal = new bootstrap.Modal(document.getElementById('transferModal'));
    document.getElementById('transferForm').reset();
    modal.show();
}

// 이전 실행
function transferRequest() {
    const form = document.getElementById('transferForm');
    const formData = new FormData(form);

    fetch(`/admin/cms/support/requests/${currentSupportId}/transfer`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('transferModal')).hide();
            location.reload();
        } else {
            alert('오류: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('네트워크 오류가 발생했습니다.');
    });
}

// 할당 이력 표시
function showAssignmentHistory(id) {
    const modal = new bootstrap.Modal(document.getElementById('historyModal'));
    const content = document.getElementById('historyContent');

    // 로딩 상태 표시
    content.innerHTML = `
        <div class="text-center py-3">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">로딩 중...</span>
            </div>
        </div>
    `;

    modal.show();

    fetch(`/admin/cms/support/requests/${id}/assignment-history`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.assignments.length === 0) {
                content.innerHTML = '<div class="text-center text-muted py-3">할당 이력이 없습니다.</div>';
            } else {
                let html = '<div class="timeline">';
                data.assignments.forEach(assignment => {
                    const actionClass = {
                        'assign': 'bg-success',
                        'transfer': 'bg-warning',
                        'unassign': 'bg-danger',
                        'self_assign': 'bg-info'
                    }[assignment.action] || 'bg-secondary';

                    html += `
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <span class="badge ${actionClass}">${assignment.action_label}</span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">${assignment.assigned_to.name}</div>
                                    ${assignment.assigned_from ? `<small class="text-muted">by ${assignment.assigned_from.name}</small>` : ''}
                                    ${assignment.note ? `<div class="mt-1">${assignment.note}</div>` : ''}
                                    <small class="text-muted">${assignment.created_at}</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                content.innerHTML = html;
            }
        } else {
            content.innerHTML = '<div class="text-center text-danger py-3">오류: ' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="text-center text-danger py-3">네트워크 오류가 발생했습니다.</div>';
    });
}
</script>
@endpush
