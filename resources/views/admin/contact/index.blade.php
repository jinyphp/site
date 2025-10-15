@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

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
                                <i class="bi bi-headset me-2"></i>
                                {{ $config['title'] ?? '상담 관리' }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] ?? '고객 상담 요청을 관리합니다' }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.contact.types.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fe fe-tag me-2"></i>상담 유형 관리
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bulkModal">
                                <i class="fe fe-settings me-2"></i>대량 작업
                            </button>
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

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 상담</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-chat-dots"></i>
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
                            <h4 class="card-title mb-1">대기 중</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['pending'] ?? 0) }}</h2>
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
                            <h4 class="card-title mb-1">처리 중</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['processing'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="bi bi-gear"></i>
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
                            <h4 class="card-title mb-1">내 담당</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['my_assigned'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="bi bi-person-check"></i>
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
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="상담번호, 제목, 이름, 이메일" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">상태</label>
                            <select name="status" class="form-select">
                                <option value="">전체</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>대기 중</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>처리 중</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>완료</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>취소</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">우선순위</label>
                            <select name="priority" class="form-select">
                                <option value="">전체</option>
                                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>낮음</option>
                                <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>보통</option>
                                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>높음</option>
                                <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>긴급</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">담당자</label>
                            <select name="assignee" class="form-select">
                                <option value="">전체</option>
                                @if(isset($assignees))
                                    @foreach($assignees as $assignee)
                                    <option value="{{ $assignee->id }}" {{ request('assignee') == $assignee->id ? 'selected' : '' }}>
                                        {{ $assignee->name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>등록일</option>
                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>수정일</option>
                                <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>상태</option>
                                <option value="priority" {{ request('sort_by') == 'priority' ? 'selected' : '' }}>우선순위</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.contact.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 상담 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">상담 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            선택 삭제
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkAction('assign')">
                            <i class="fe fe-user-plus me-1"></i>담당자 할당
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="bulkAction('status')">
                            <i class="fe fe-refresh-cw me-1"></i>상태 변경
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- 알림 메시지 영역 -->
                    <div id="alertContainer" class="p-3" style="display: none;"></div>

                    @if(isset($contacts) && $contacts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th width="120">상담번호</th>
                                        <th>제목</th>
                                        <th width="150">문의자</th>
                                        <th width="100">유형</th>
                                        <th width="100">상태</th>
                                        <th width="100">우선순위</th>
                                        <th width="120">담당자</th>
                                        <th width="120">등록일</th>
                                        <th width="150">관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                    <tr data-id="{{ $contact->id }}">
                                        <td>
                                            <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" class="form-check-input contact-checkbox">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.contact.show', $contact->id) }}" class="text-decoration-none fw-bold">
                                                {{ $contact->contact_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ Str::limit($contact->subject, 40) }}</strong>
                                                @if($contact->user)
                                                <span class="badge bg-success ms-2">회원</span>
                                                @else
                                                <span class="badge bg-secondary ms-2">비회원</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ $contact->name }}</div>
                                            <div class="text-muted small">{{ $contact->email }}</div>
                                        </td>
                                        <td>
                                            @if(isset($contact->contactType))
                                            <span class="badge bg-light text-dark">{{ $contact->contactType->name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $contact->status_class ?? 'secondary' }}">{{ $contact->status_text ?? $contact->status }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $contact->priority_class ?? 'secondary' }}">{{ $contact->priority_text ?? $contact->priority }}</span>
                                        </td>
                                        <td>
                                            @if(isset($contact->assignedUser))
                                                {{ $contact->assignedUser->name }}
                                            @else
                                                <span class="text-muted">미할당</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $contact->created_at->format('Y.m.d') }}</div>
                                            <div class="text-muted small">{{ $contact->created_at->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                <a href="{{ route('admin.cms.contact.show', $contact->id) }}"
                                                   class="btn btn-outline-info btn-sm" title="보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-primary btn-sm" title="담당자 할당"
                                                        onclick="assignContact({{ $contact->id }})">
                                                    <i class="fe fe-user-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm" title="상태 변경"
                                                        onclick="updateStatus({{ $contact->id }})">
                                                    <i class="fe fe-refresh-cw"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                        onclick="deleteContact({{ $contact->id }})">
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
                        @if(isset($contacts) && method_exists($contacts, 'links'))
                        <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                            <div class="text-muted">
                                총 {{ number_format($contacts->total()) }}개 중
                                {{ number_format($contacts->firstItem()) }} - {{ number_format($contacts->lastItem()) }}개 표시
                            </div>
                            <div>
                                {{ $contacts->appends(request()->query())->links() }}
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5 px-3">
                            <i class="fe fe-inbox fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">상담을 찾을 수 없습니다</h5>
                            <p class="text-muted mb-3">검색 조건을 변경하거나 새로운 상담이 접수되기를 기다려주세요.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 대량 작업 모달 -->
<div class="modal fade" id="bulkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">대량 작업</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bulkForm">
                    <div class="mb-3">
                        <label class="form-label">작업 선택</label>
                        <select class="form-select" id="bulkAction" required>
                            <option value="">선택하세요</option>
                            <option value="assign">담당자 할당</option>
                            <option value="status">상태 변경</option>
                            <option value="delete">삭제</option>
                        </select>
                    </div>
                    <div class="mb-3" id="bulkValueContainer" style="display: none;">
                        <label class="form-label">값</label>
                        <select class="form-select" id="bulkValue"></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">실행</button>
            </div>
        </div>
    </div>
</div>

<style>
.icon-shape {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.icon-shape i {
    font-size: 1.5rem;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.page-header-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}
</style>

<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 대량 작업 타입 변경
document.addEventListener('DOMContentLoaded', function() {
    const bulkActionSelect = document.getElementById('bulkAction');
    if (bulkActionSelect) {
        bulkActionSelect.addEventListener('change', function() {
            const valueContainer = document.getElementById('bulkValueContainer');
            const valueSelect = document.getElementById('bulkValue');

            if (this.value === 'delete') {
                valueContainer.style.display = 'none';
                return;
            }

            valueContainer.style.display = 'block';
            valueSelect.innerHTML = '';

            if (this.value === 'assign') {
                valueSelect.innerHTML = '<option value="">담당자 선택</option>';
                @if(isset($assignees))
                    @foreach($assignees as $assignee)
                    valueSelect.innerHTML += '<option value="{{ $assignee->id }}">{{ $assignee->name }}</option>';
                    @endforeach
                @endif
            } else if (this.value === 'status') {
                valueSelect.innerHTML = `
                    <option value="">상태 선택</option>
                    <option value="pending">대기 중</option>
                    <option value="processing">처리 중</option>
                    <option value="completed">완료</option>
                    <option value="cancelled">취소</option>
                `;
            }
        });
    }
});

// 대량 작업 실행
function executeBulkAction() {
    const selectedIds = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
                            .map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    const action = document.getElementById('bulkAction').value;
    const value = document.getElementById('bulkValue').value;

    if (!action) {
        alert('작업을 선택해주세요.');
        return;
    }

    if (action !== 'delete' && !value) {
        alert('값을 선택해주세요.');
        return;
    }

    if (action === 'delete' && !confirm('정말 삭제하시겠습니까?')) {
        return;
    }

    fetch('/admin/cms/contact/bulk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            action: action,
            value: value,
            ids: selectedIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            location.reload();
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 일괄 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.contact-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedIds.length}개 항목을 삭제하시겠습니까?`)) {
        return;
    }

    // 대량 작업 모달 열기
    const modal = new bootstrap.Modal(document.getElementById('bulkModal'));
    document.getElementById('bulkAction').value = action;
    document.getElementById('bulkAction').dispatchEvent(new Event('change'));
    modal.show();
}

// 담당자 할당
function assignContact(id) {
    // 담당자 할당 로직 구현
    const assigneeId = prompt('담당자 ID를 입력하세요:');
    if (assigneeId) {
        fetch(`/admin/cms/contact/${id}/assign`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ assigned_to: assigneeId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', '오류가 발생했습니다.');
        });
    }
}

// 상태 변경
function updateStatus(id) {
    const status = prompt('변경할 상태를 입력하세요 (pending, processing, completed, cancelled):');
    if (status) {
        fetch(`/admin/cms/contact/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', '오류가 발생했습니다.');
        });
    }
}

// 상담 삭제
function deleteContact(id) {
    if (!confirm('정말 삭제하시겠습니까?')) return;

    fetch(`/admin/cms/contact/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', '상담이 삭제되었습니다.');
            location.reload();
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 알림 표시
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const iconClass = type === 'success' ? 'fe-check-circle' : 'fe-alert-circle';

    alertContainer.style.display = 'block';
    alertContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fe ${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
}
</script>
@endsection
