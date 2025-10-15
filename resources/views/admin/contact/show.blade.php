@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '상담 상세정보')

@section('content')
<div class="container-fluid p-6">

    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-headset me-2"></i>상담 상세정보
                            </h1>
                            <p class="page-header-subtitle">{{ $contact->contact_number ?? '' }}번 상담의 상세 정보를 확인합니다.</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-warning me-2" onclick="showStatusModal()">
                                <i class="fe fe-refresh-cw me-2"></i>상태 변경
                            </button>
                            <button type="button" class="btn btn-info me-2" onclick="showAssignModal()">
                                <i class="fe fe-user-plus me-2"></i>담당자 할당
                            </button>
                            <a href="{{ route('admin.cms.contact.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['total_contacts'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">전체 상담</p>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-3">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['pending_contacts'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">대기 중</p>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-3">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['processing_contacts'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">처리 중</p>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-3">
                            <i class="bi bi-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">
                                <span class="badge bg-{{ $contact->status_class ?? 'secondary' }}">{{ $contact->status_text ?? $contact->status ?? '-' }}</span>
                            </h4>
                            <p class="text-muted mb-0">현재 상태</p>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-3">
                            <i class="bi bi-flag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 상담 정보 -->
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">상담 정보</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">상담번호</label>
                                <div class="p-3 bg-light rounded">
                                    <span class="badge bg-primary fs-6">{{ $contact->contact_number ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">제목</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $contact->subject ?? '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">문의자</label>
                                <div class="p-3 bg-light rounded">
                                    <div><strong>{{ $contact->name ?? '-' }}</strong></div>
                                    <div class="text-muted">{{ $contact->email ?? '-' }}</div>
                                    @if($contact->phone)
                                    <div class="text-muted">{{ $contact->phone }}</div>
                                    @endif
                                    @if(isset($contact->user))
                                    <span class="badge bg-success mt-2">회원</span>
                                    @else
                                    <span class="badge bg-secondary mt-2">비회원</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">상담 유형</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $contact->contactType->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">상태</label>
                                <div class="p-3 bg-light rounded">
                                    <span class="badge bg-{{ $contact->status_class ?? 'secondary' }}">{{ $contact->status_text ?? $contact->status ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">우선순위</label>
                                <div class="p-3 bg-light rounded">
                                    <span class="badge bg-{{ $contact->priority_class ?? 'secondary' }}">{{ $contact->priority_text ?? $contact->priority ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">담당자</label>
                                <div class="p-3 bg-light rounded">
                                    @if(isset($contact->assignedUser))
                                        {{ $contact->assignedUser->name }}
                                    @else
                                        <span class="text-muted">미할당</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">공개 설정</label>
                                <div class="p-3 bg-light rounded">
                                    @if($contact->is_public ?? false)
                                        <span class="badge bg-success">공개</span>
                                    @else
                                        <span class="badge bg-secondary">비공개</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">문의 내용</label>
                                <div class="p-3 bg-light rounded">
                                    @if($contact->message ?? false)
                                        {!! nl2br(e($contact->message)) !!}
                                    @else
                                        <em class="text-muted">문의 내용이 없습니다.</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">등록일</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $contact->created_at ? $contact->created_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">최종 수정일</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $contact->updated_at ? $contact->updated_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">처리일</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $contact->processed_at ? $contact->processed_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 댓글/답변 섹션 -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">댓글/답변</h4>
                    <button type="button" class="btn btn-primary btn-sm" onclick="showCommentModal()">
                        <i class="fe fe-plus me-2"></i>댓글 추가
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($contact->comments) && $contact->comments->count() > 0)
                        @foreach($contact->comments as $comment)
                        <div class="border rounded p-3 mb-3 {{ $comment->is_internal ? 'border-warning bg-warning bg-opacity-10' : 'border-info bg-info bg-opacity-10' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <strong>{{ $comment->user->name ?? 'System' }}</strong>
                                        @if($comment->is_internal)
                                        <span class="badge bg-warning ms-2">내부 메모</span>
                                        @else
                                        <span class="badge bg-info ms-2">공개 답변</span>
                                        @endif
                                        <small class="text-muted ms-2">{{ $comment->created_at ? $comment->created_at->format('Y-m-d H:i') : '' }}</small>
                                    </div>
                                    <div>{!! nl2br(e($comment->comment ?? '')) !!}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-message-square text-muted fs-1 mb-3"></i>
                            <h5 class="text-muted">댓글이 없습니다</h5>
                            <p class="text-muted">첫 번째 댓글을 추가해보세요.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 액션 버튼 -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn btn-warning me-2" onclick="showStatusModal()">
                                <i class="fe fe-refresh-cw me-2"></i>상태 변경
                            </button>
                            <button type="button" class="btn btn-info me-2" onclick="showAssignModal()">
                                <i class="fe fe-user-plus me-2"></i>담당자 할당
                            </button>
                            <a href="{{ route('admin.cms.contact.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fe fe-list me-2"></i>목록
                            </a>
                        </div>
                        <div>
                            <form action="{{ route('admin.cms.contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('정말로 이 상담을 삭제하시겠습니까?\n\n이 작업은 되돌릴 수 없습니다.')">
                                    <i class="fe fe-trash me-2"></i>삭제
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 상담 관리 -->
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-settings me-2"></i>상담 관리
                    </h5>
                </div>
                <div class="card-body">
                    <h6>상태 변경</h6>
                    <p class="text-muted small mb-3">상담의 처리 상태를 변경할 수 있습니다.</p>

                    <h6>담당자 할당</h6>
                    <p class="text-muted small mb-3">상담을 처리할 담당자를 지정할 수 있습니다.</p>

                    <h6>댓글 유형</h6>
                    <ul class="text-muted small mb-0">
                        <li><strong>공개 답변</strong>: 고객이 볼 수 있는 답변</li>
                        <li><strong>내부 메모</strong>: 관리자만 볼 수 있는 메모</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-info me-2"></i>상담 통계
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>전체 댓글</span>
                        <span class="badge bg-primary">{{ isset($contact->comments) ? $contact->comments->count() : 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>공개 답변</span>
                        <span class="badge bg-info">{{ isset($contact->comments) ? $contact->comments->where('is_internal', false)->count() : 0 }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>내부 메모</span>
                        <span class="badge bg-warning">{{ isset($contact->comments) ? $contact->comments->where('is_internal', true)->count() : 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 상태 변경 모달 -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">상태 변경</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <div class="mb-3">
                        <label class="form-label">상태 선택</label>
                        <select class="form-select" id="statusSelect" required>
                            <option value="">선택하세요</option>
                            <option value="pending" {{ ($contact->status ?? '') === 'pending' ? 'selected' : '' }}>대기 중</option>
                            <option value="processing" {{ ($contact->status ?? '') === 'processing' ? 'selected' : '' }}>처리 중</option>
                            <option value="completed" {{ ($contact->status ?? '') === 'completed' ? 'selected' : '' }}>완료</option>
                            <option value="cancelled" {{ ($contact->status ?? '') === 'cancelled' ? 'selected' : '' }}>취소</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus()">변경</button>
            </div>
        </div>
    </div>
</div>

<!-- 담당자 할당 모달 -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">담당자 할당</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm">
                    <div class="mb-3">
                        <label class="form-label">담당자 선택</label>
                        <select class="form-select" id="assigneeSelect" required>
                            <option value="">선택하세요</option>
                            @if(isset($assignees))
                                @foreach($assignees as $assignee)
                                <option value="{{ $assignee->id }}" {{ (isset($contact->assigned_to) && $contact->assigned_to == $assignee->id) ? 'selected' : '' }}>
                                    {{ $assignee->name }}
                                </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="assignContact()">할당</button>
            </div>
        </div>
    </div>
</div>

<!-- 댓글 추가 모달 -->
<div class="modal fade" id="commentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">댓글 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="commentForm">
                    <div class="mb-3">
                        <label class="form-label">댓글 유형</label>
                        <select class="form-select" id="commentType" required>
                            <option value="0">공개 답변 (고객이 볼 수 있음)</option>
                            <option value="1">내부 메모 (관리자만 볼 수 있음)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">내용</label>
                        <textarea class="form-control" id="commentContent" rows="6" required maxlength="5000"></textarea>
                        <div class="form-text">최대 5,000자까지 입력 가능합니다.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="addComment()">추가</button>
            </div>
        </div>
    </div>
</div>

<style>
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

.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-md {
    width: 48px;
    height: 48px;
}
</style>

<script>
function showStatusModal() {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

function showAssignModal() {
    const modal = new bootstrap.Modal(document.getElementById('assignModal'));
    modal.show();
}

function showCommentModal() {
    const modal = new bootstrap.Modal(document.getElementById('commentModal'));
    modal.show();
}

function updateStatus() {
    const status = document.getElementById('statusSelect').value;
    if (!status) {
        alert('상태를 선택해주세요.');
        return;
    }

    fetch(`/admin/cms/contact/{{ $contact->id }}/status`, {
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
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('오류가 발생했습니다.');
    });
}

function assignContact() {
    const assigneeId = document.getElementById('assigneeSelect').value;
    if (!assigneeId) {
        alert('담당자를 선택해주세요.');
        return;
    }

    fetch(`/admin/cms/contact/{{ $contact->id }}/assign`, {
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
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('오류가 발생했습니다.');
    });
}

function addComment() {
    const isInternal = document.getElementById('commentType').value;
    const content = document.getElementById('commentContent').value;

    if (!content.trim()) {
        alert('댓글 내용을 입력해주세요.');
        return;
    }

    fetch(`/admin/cms/contact/{{ $contact->id }}/comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            comment: content,
            is_internal: isInternal
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('오류가 발생했습니다.');
    });
}
</script>
@endsection
