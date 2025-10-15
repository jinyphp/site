@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 관리')

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
                                <i class="fe fe-headphones me-2"></i>
                                지원 요청 관리
                            </h1>
                            <p class="page-header-subtitle">고객 지원 요청을 관리하고 처리합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.help.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>Help 대시보드
                            </a>
                            <a href="{{ route('admin.support.requests.my-assignments') }}" class="btn btn-outline-info">
                                <i class="fe fe-user me-2"></i>내 할당 요청
                            </a>
                            <a href="{{ route('admin.support.auto-assignments.index') }}" class="btn btn-outline-warning">
                                <i class="fe fe-settings me-2"></i>자동 할당 설정
                            </a>
                            <a href="{{ route('admin.cms.support.index') }}" class="btn btn-outline-primary">
                                <i class="fe fe-bar-chart-2 me-2"></i>통계 분석
                            </a>
                            <a href="{{ route('admin.cms.support.export') }}" class="btn btn-outline-success">
                                <i class="fe fe-download me-2"></i>내보내기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 간단한 요약 통계 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-2">
                                <i class="fe fe-activity me-2"></i>
                                현재 상황 요약
                            </h5>
                            <p class="text-muted mb-0">상세한 통계는 '통계 분석' 버튼을 클릭하여 확인하세요.</p>
                        </div>
                        <div class="d-flex gap-4">
                            <div class="text-center">
                                <div class="h4 text-primary mb-0">{{ number_format($statistics['total']) }}</div>
                                <small class="text-muted">전체</small>
                            </div>
                            <div class="text-center">
                                <div class="h4 text-warning mb-0">{{ number_format($statistics['pending']) }}</div>
                                <small class="text-muted">대기중</small>
                            </div>
                            <div class="text-center">
                                <div class="h4 text-info mb-0">{{ number_format($statistics['in_progress']) }}</div>
                                <small class="text-muted">처리중</small>
                            </div>
                            <div class="text-center">
                                <div class="h4 text-success mb-0">{{ number_format($statistics['resolved']) }}</div>
                                <small class="text-muted">해결완료</small>
                            </div>
                            @if(isset($todayCount))
                            <div class="text-center border-start ps-4">
                                <div class="h4 text-secondary mb-0">{{ number_format($todayCount) }}</div>
                                <small class="text-muted">오늘</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">필터 및 검색</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.cms.support.requests.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">상태</label>
                                <select name="status" class="form-select">
                                    <option value="">모든 상태</option>
                                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>대기중</option>
                                    <option value="in_progress" {{ $currentStatus === 'in_progress' ? 'selected' : '' }}>처리중</option>
                                    <option value="resolved" {{ $currentStatus === 'resolved' ? 'selected' : '' }}>해결완료</option>
                                    <option value="closed" {{ $currentStatus === 'closed' ? 'selected' : '' }}>종료</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">유형</label>
                                <select name="type" class="form-select">
                                    <option value="">모든 유형</option>
                                    <option value="technical" {{ $currentType === 'technical' ? 'selected' : '' }}>기술 지원</option>
                                    <option value="billing" {{ $currentType === 'billing' ? 'selected' : '' }}>결제 문의</option>
                                    <option value="general" {{ $currentType === 'general' ? 'selected' : '' }}>일반 문의</option>
                                    <option value="bug_report" {{ $currentType === 'bug_report' ? 'selected' : '' }}>버그 리포트</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">우선순위</label>
                                <select name="priority" class="form-select">
                                    <option value="">모든 우선순위</option>
                                    <option value="low" {{ $currentPriority === 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="medium" {{ $currentPriority === 'medium' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ $currentPriority === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ $currentPriority === 'urgent' ? 'selected' : '' }}>긴급</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">담당자</label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">모든 담당자</option>
                                    <option value="unassigned" {{ $currentAssignee === 'unassigned' ? 'selected' : '' }}>미배정</option>
                                    @if(isset($assignees))
                                        @foreach($assignees as $assignee)
                                        <option value="{{ $assignee->id }}" {{ $currentAssignee == $assignee->id ? 'selected' : '' }}>
                                            {{ $assignee->name }}
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label">시작일</label>
                                <input type="date" name="date_from" class="form-control" value="{{ $dateFrom ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">종료일</label>
                                <input type="date" name="date_to" class="form-control" value="{{ $dateTo ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">정렬</label>
                                <select name="sort_by" class="form-select">
                                    <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>등록일</option>
                                    <option value="updated_at" {{ $sortBy === 'updated_at' ? 'selected' : '' }}>수정일</option>
                                    <option value="priority" {{ $sortBy === 'priority' ? 'selected' : '' }}>우선순위</option>
                                    <option value="status" {{ $sortBy === 'status' ? 'selected' : '' }}>상태</option>
                                    <option value="subject" {{ $sortBy === 'subject' ? 'selected' : '' }}>제목</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">검색</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="제목, 내용 검색..." value="{{ $searchKeyword }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fe fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-2"></i>필터 적용
                                </button>
                                <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>필터 초기화
                                </a>
                                <a href="{{ route('admin.cms.support.index') }}" class="btn btn-outline-info" target="_blank">
                                    <i class="fe fe-bar-chart-2 me-2"></i>상세 분석
                                </a>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fe fe-download me-2"></i>내보내기
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.cms.support.export', ['format' => 'csv'] + request()->all()) }}">CSV 파일</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.cms.support.export', ['format' => 'json'] + request()->all()) }}">JSON 파일</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 지원 요청 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">지원 요청 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="bulkDeleteBtn" disabled>
                            <i class="fe fe-trash-2 me-2"></i>선택 삭제
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($supports->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>제목</th>
                                        <th>유형</th>
                                        <th>우선순위</th>
                                        <th>상태</th>
                                        <th>요청자</th>
                                        <th>담당자</th>
                                        <th>등록일</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supports as $support)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_ids[]" value="{{ $support->id }}" class="form-check-input item-checkbox">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.support.requests.show', $support->id) }}" class="text-decoration-none">
                                                {{ Str::limit($support->subject, 50) }}
                                            </a>
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
                                            @elseif($support->priority === 'medium')
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
                                            @if($support->assignedTo)
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        {{ $support->assignedTo->name }}
                                                        @if($support->isAssignedTo(Auth::id()))
                                                            <span class="badge bg-primary ms-1">나</span>
                                                        @endif
                                                    </div>
                                                    @if($support->canBeAssigned())
                                                        <div class="btn-group" role="group">
                                                            @if($support->isAssignedTo(Auth::id()))
                                                                <button class="btn btn-outline-warning btn-sm"
                                                                        onclick="showTransferModal({{ $support->id }})"
                                                                        title="다른 관리자에게 이전">
                                                                    <i class="fe fe-arrow-right"></i>
                                                                </button>
                                                            @endif
                                                            <button class="btn btn-outline-secondary btn-sm"
                                                                    onclick="unassignRequest({{ $support->id }})"
                                                                    title="할당 해제">
                                                                <i class="fe fe-x"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="text-muted">미배정</span>
                                                    @if($support->canBeAssigned())
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-success btn-sm"
                                                                    onclick="selfAssignRequest({{ $support->id }})"
                                                                    title="내가하기">
                                                                <i class="fe fe-user-plus me-1"></i>내가하기
                                                            </button>
                                                            <button class="btn btn-outline-primary btn-sm"
                                                                    onclick="showAssignModal({{ $support->id }})"
                                                                    title="관리자 할당">
                                                                <i class="fe fe-users"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
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
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                        onclick="showAssignmentHistory({{ $support->id }})" title="할당 이력">
                                                    <i class="fe fe-clock"></i>
                                                </button>
                                                <a href="{{ route('admin.cms.support.requests.edit', $support->id) }}"
                                                   class="btn btn-outline-secondary btn-sm" title="수정">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteItem({{ $support->id }})" title="삭제">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
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
                            <h5>지원 요청이 없습니다</h5>
                            <p>현재 등록된 지원 요청이 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                선택한 지원 요청을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 벌크 작업 폼 -->
<form id="bulkActionForm" method="POST" action="{{ route('admin.cms.support.bulkAction') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkAction">
    <input type="hidden" name="selected_ids" id="bulkSelectedIds">
</form>

@endsection

<!-- 관리자 할당 모달 -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">관리자 할당</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm">
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">담당자 선택</label>
                        <select class="form-select" id="assigneeSelect" name="assignee_id" required>
                            <option value="">담당자를 선택하세요</option>
                            @foreach($assignees as $assignee)
                                <option value="{{ $assignee->id }}">{{ $assignee->name }} ({{ $assignee->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assignNote" class="form-label">할당 사유 (선택사항)</label>
                        <textarea class="form-control" id="assignNote" name="note" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="assignRequest()">할당하기</button>
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
                            @foreach($assignees as $assignee)
                                @if($assignee->id != Auth::id())
                                    <option value="{{ $assignee->id }}">{{ $assignee->name }} ({{ $assignee->email }})</option>
                                @endif
                            @endforeach
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

@push('scripts')
<script>
let currentSupportId = null;

// 자가 할당
function selfAssignRequest(id) {
    console.log('🚀 selfAssignRequest 호출됨, ID:', id);

    if (!confirm('이 요청을 본인에게 할당하시겠습니까?')) {
        console.log('❌ 사용자가 취소함');
        return;
    }

    const url = `/admin/cms/support/requests/${id}/self-assign`;
    console.log('📡 API 요청 URL:', url);

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('❌ CSRF 토큰을 찾을 수 없습니다!');
        alert('CSRF 토큰 오류입니다. 페이지를 새로고침해주세요.');
        return;
    }
    console.log('🔐 CSRF 토큰:', csrfToken.getAttribute('content'));

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('📨 응답 상태:', response.status);
        console.log('📨 응답 헤더:', response.headers);

        if (!response.ok) {
            console.error('❌ HTTP 오류:', response.status, response.statusText);
        }

        return response.json();
    })
    .then(data => {
        console.log('📊 응답 데이터:', data);

        if (data.success) {
            console.log('✅ 할당 성공!');
            alert(data.message);
            location.reload();
        } else {
            console.error('❌ 할당 실패:', data.message);
            alert('오류: ' + data.message);
        }
    })
    .catch(error => {
        console.error('💥 네트워크 오류:', error);
        alert('네트워크 오류가 발생했습니다: ' + error.message);
    });
}

// 관리자 할당 모달 표시
function showAssignModal(id) {
    currentSupportId = id;
    const modal = new bootstrap.Modal(document.getElementById('assignModal'));
    document.getElementById('assignForm').reset();
    modal.show();
}

// 관리자 할당 실행
function assignRequest() {
    const form = document.getElementById('assignForm');
    const formData = new FormData(form);

    fetch(`/admin/cms/support/requests/${currentSupportId}/assign`, {
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
            bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
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

// 이전 모달 표시
function showTransferModal(id) {
    currentSupportId = id;
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

// 할당 해제
function unassignRequest(id) {
    if (!confirm('이 요청의 할당을 해제하시겠습니까?')) return;

    fetch(`/admin/cms/support/requests/${id}/unassign`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
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

document.addEventListener('DOMContentLoaded', function() {
    // 전체 선택 체크박스
    const selectAllCheckbox = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    selectAllCheckbox.addEventListener('change', function() {
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkButtons();
    });

    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButtons);
    });

    function updateBulkButtons() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        const hasChecked = checkedItems.length > 0;

        bulkDeleteBtn.disabled = !hasChecked;

        // 전체 선택 체크박스 상태 업데이트
        selectAllCheckbox.checked = checkedItems.length === itemCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedItems.length > 0 && checkedItems.length < itemCheckboxes.length;
    }

    // 벌크 삭제
    bulkDeleteBtn.addEventListener('click', function() {
        const checkedItems = document.querySelectorAll('.item-checkbox:checked');
        if (checkedItems.length === 0) return;

        if (confirm(`선택한 ${checkedItems.length}개 항목을 삭제하시겠습니까?`)) {
            const selectedIds = Array.from(checkedItems).map(cb => cb.value);
            document.getElementById('bulkAction').value = 'delete';
            document.getElementById('bulkSelectedIds').value = selectedIds.join(',');
            document.getElementById('bulkActionForm').submit();
        }
    });
});

function deleteItem(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ route('admin.cms.support.requests.index') }}/${id}`;
    modal.show();
}
</script>
@endpush
