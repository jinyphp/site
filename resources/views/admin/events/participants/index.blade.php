@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $event->title . ' - 참여자 관리')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.site.event.index') }}">이벤트 관리</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.site.event.show', $event->id) }}">{{ $event->title }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">참여자 관리</li>
                                </ol>
                            </nav>
                            <h1 class="page-header-title">
                                <i class="bi bi-people me-2"></i>
                                참여자 관리
                            </h1>
                            <p class="page-header-subtitle">{{ $event->title }} 이벤트의 참여자를 관리합니다</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.event.participants.create', $event->id) }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>참여자 직접 등록
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 알림 메시지 -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fe fe-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fe fe-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- 이벤트 정보 카드 -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="text-muted mb-2">{{ $event->description }}</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-{{ $event->enable ? 'success' : 'secondary' }}">
                            {{ $event->enable ? '활성화' : '비활성화' }}
                        </span>
                        <span class="badge bg-info">{{ $event->status }}</span>
                        @if($event->allow_participation)
                        <span class="badge bg-success">참여신청 가능</span>
                        @if($event->approval_type === 'manual')
                        <span class="badge bg-warning text-dark">수동승인</span>
                        @endif
                        @else
                        <span class="badge bg-secondary">참여신청 불가</span>
                        @endif
                    </div>
                    @if($event->max_participants)
                    <div class="mt-2">
                        <small class="text-muted">최대 참여 인원: {{ number_format($event->max_participants) }}명</small>
                    </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.site.event.show', $event->id) }}" class="btn btn-outline-info">
                                <i class="fe fe-eye me-1"></i>이벤트 보기
                            </a>
                            <a href="{{ route('admin.site.event.edit', $event->id) }}" class="btn btn-outline-primary">
                                <i class="fe fe-edit me-1"></i>이벤트 수정
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">총 신청자</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">승인됨</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['approved']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">대기중</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['pending']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">거부됨</h4>
                            <h2 class="text-danger mb-0">{{ number_format($stats['rejected']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-danger text-white rounded-circle">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.site.event.participants.index', $event->id) }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="이름, 이메일, 전화번호로 검색...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">상태</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">전체</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>대기중</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>승인됨</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>거부됨</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>취소됨</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">정렬</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>신청일</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>이름</option>
                        <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>이메일</option>
                        <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>상태</option>
                        <option value="approved_at" {{ request('sort') === 'approved_at' ? 'selected' : '' }}>승인일</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 참여자 목록 -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">참여자 목록</h4>

                <!-- 대량 작업 -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            id="bulkActions" data-bs-toggle="dropdown" aria-expanded="false">
                        대량 작업
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="bulkActions">
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('approve')">
                            <i class="bi bi-check-circle me-2 text-success"></i>승인
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('reject')">
                            <i class="bi bi-x-circle me-2 text-danger"></i>거부
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('cancel')">
                            <i class="bi bi-slash-circle me-2 text-warning"></i>취소
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                            <i class="fe fe-trash-2 me-2"></i>삭제
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($participants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>참여자</th>
                            <th>연락처</th>
                            <th>상태</th>
                            <th>신청/승인 정보</th>
                            <th width="150">작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participant)
                        <tr data-participant-id="{{ $participant->id }}">
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $participant->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <div class="avatar-title bg-light rounded-circle">
                                            <i class="bi bi-person text-muted"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="mb-0">
                                                <a href="#" onclick="showParticipantDetail({{ $participant->id }}); return false;"
                                                   class="text-decoration-none text-dark">
                                                    {{ $participant->name }}
                                                </a>
                                            </h6>
                                            @if($participant->user)
                                            <small class="badge bg-info">회원</small>
                                            @else
                                            <small class="badge bg-secondary">비회원</small>
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            <a href="#" onclick="showParticipantDetail({{ $participant->id }}); return false;"
                                               class="text-decoration-none text-muted">
                                                {{ $participant->email }}
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($participant->phone)
                                    <i class="bi bi-telephone me-1"></i>{{ $participant->phone }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $participant->status_class }} participant-status">
                                    {{ $participant->status_text }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-plus me-1"></i>신청:
                                        {{ $participant->applied_at ? $participant->applied_at->format('Y-m-d H:i') : '-' }}
                                    </small>
                                </div>
                                @if($participant->approved_at || $participant->approved_by)
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="bi bi-check-circle me-1"></i>승인:
                                        {{ $participant->approved_at ? $participant->approved_at->format('Y-m-d H:i') : '-' }}
                                        @if($participant->approved_by)
                                        <span class="text-primary">({{ $participant->approved_by }})</span>
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info"
                                            onclick="showParticipantDetail({{ $participant->id }})" title="상세보기">
                                        <i class="fe fe-eye"></i>
                                    </button>

                                    <a href="{{ route('admin.site.event.participants.edit', [$event->id, $participant->id]) }}"
                                       class="btn btn-outline-primary" title="수정">
                                        <i class="fe fe-edit"></i>
                                    </a>

                                    @if($participant->status !== 'approved')
                                    <button type="button" class="btn btn-outline-success"
                                            onclick="approveParticipant({{ $participant->id }})" title="승인">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    @endif

                                    @if($participant->status !== 'rejected')
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="rejectParticipant({{ $participant->id }})" title="거부">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    @endif

                                    @if($participant->status !== 'cancelled')
                                    <button type="button" class="btn btn-outline-warning"
                                            onclick="cancelParticipant({{ $participant->id }})" title="취소">
                                        <i class="bi bi-slash-circle"></i>
                                    </button>
                                    @endif

                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="deleteParticipant({{ $participant->id }}, '{{ $participant->name }}')" title="삭제">
                                        <i class="fe fe-trash-2"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3">참여자가 없습니다</h5>
                <p class="text-muted">아직 신청한 참여자가 없습니다.</p>
                <a href="{{ route('admin.site.event.participants.create', $event->id) }}" class="btn btn-primary">
                    <i class="fe fe-plus me-2"></i>참여자 직접 등록
                </a>
            </div>
            @endif
        </div>

        @if($participants->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    {{ $participants->firstItem() }}-{{ $participants->lastItem() }} / {{ $participants->total() }}명 표시
                </small>
                {{ $participants->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- 참여자 상세 모달 -->
<div class="modal fade" id="participantDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">참여자 상세정보</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="participantDetailContent">
                <!-- 상세 내용이 여기에 로드됩니다 -->
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">참여자 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>다음 참여자를 삭제하시겠습니까?</p>
                <p class="fw-bold" id="deleteParticipantName"></p>
                <p class="text-danger small">이 작업은 되돌릴 수 없습니다.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">삭제</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 참여자 승인
function approveParticipant(participantId) {
    updateParticipantStatus(participantId, 'approve', '승인');
}

// 참여자 거부
function rejectParticipant(participantId) {
    updateParticipantStatus(participantId, 'reject', '거부');
}

// 참여자 취소
function cancelParticipant(participantId) {
    updateParticipantStatus(participantId, 'cancel', '취소');
}

// 참여자 상태 업데이트
function updateParticipantStatus(participantId, action, actionName) {
    fetch(`/admin/site/event/{{ $event->id }}/participants/${participantId}/${action}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 시 페이지 새로고침
            location.reload();
        } else {
            alert(data.message || `${actionName} 처리에 실패했습니다.`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`${actionName} 처리 중 오류가 발생했습니다.`);
    });
}

// 참여자 상세 보기
function showParticipantDetail(participantId) {
    fetch(`/admin/site/event/{{ $event->id }}/participants/${participantId}`)
    .then(response => response.text())
    .then(html => {
        document.getElementById('participantDetailContent').innerHTML = html;
        new bootstrap.Modal(document.getElementById('participantDetailModal')).show();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('참여자 정보를 불러오는 중 오류가 발생했습니다.');
    });
}

// 참여자 삭제
let deleteParticipantId = null;

function deleteParticipant(participantId, participantName) {
    deleteParticipantId = participantId;
    document.getElementById('deleteParticipantName').textContent = participantName;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteParticipantId) {
        fetch(`/admin/site/event/{{ $event->id }}/participants/${deleteParticipantId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || '삭제에 실패했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('삭제 중 오류가 발생했습니다.');
        });
    }

    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
});

// 대량 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('작업할 참여자를 선택해주세요.');
        return;
    }

    const actionNames = {
        'approve': '승인',
        'reject': '거부',
        'cancel': '취소',
        'delete': '삭제'
    };

    if (!confirm(`선택한 ${selectedIds.length}명의 참여자를 ${actionNames[action]}하시겠습니까?`)) {
        return;
    }

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('action', action);
    selectedIds.forEach(id => formData.append('ids[]', id));

    fetch('/admin/site/event/{{ $event->id }}/participants/bulk', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || '작업 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('작업 중 오류가 발생했습니다.');
    });
}
</script>
@endpush
