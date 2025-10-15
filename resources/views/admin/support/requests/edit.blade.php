@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 수정')

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
                                <i class="fe fe-edit me-2"></i>
                                지원 요청 수정
                            </h1>
                            <p class="page-header-subtitle">지원 요청의 상태와 답변을 관리합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.support.requests.show', $support->id) }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>상세보기
                            </a>
                            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-primary">
                                <i class="fe fe-list me-2"></i>목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 수정 폼 -->
    <div class="row mt-4">
        <div class="col-xl-8">
            <form method="POST" action="{{ route('admin.cms.support.requests.edit', $support->id) }}">
                @csrf

                <!-- 기본 정보 카드 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">지원 요청 정보</h4>
                    </div>
                    <div class="card-body">
                        <!-- 요청 정보 (읽기 전용) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">제목</label>
                                <input type="text" class="form-control" value="{{ $support->subject }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">요청자</label>
                                <input type="text" class="form-control"
                                       value="{{ $support->user ? $support->user->name . ' (' . $support->user->email . ')' : ($support->name ?? '익명') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">유형</label>
                                <input type="text" class="form-control"
                                       value="@if($support->type === 'technical')기술 지원@elseif($support->type === 'billing')결제 문의@elseif($support->type === 'general')일반 문의@elseif($support->type === 'bug_report')버그 리포트@else{{ $support->type }}@endif" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">우선순위 <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="low" {{ $support->priority === 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="medium" {{ $support->priority === 'medium' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ $support->priority === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ $support->priority === 'urgent' ? 'selected' : '' }}>긴급</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">상태 <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ $support->status === 'pending' ? 'selected' : '' }}>대기중</option>
                                    <option value="in_progress" {{ $support->status === 'in_progress' ? 'selected' : '' }}>처리중</option>
                                    <option value="resolved" {{ $support->status === 'resolved' ? 'selected' : '' }}>해결완료</option>
                                    <option value="closed" {{ $support->status === 'closed' ? 'selected' : '' }}>종료</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">담당자 배정</label>
                                <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                                    <option value="">담당자 선택</option>
                                    @php
                                        // 관리자 사용자 목록을 가져오기 (실제 환경에서는 적절한 방법으로 구현)
                                        $admins = \App\Models\User::where('isAdmin', true)->get();
                                    @endphp
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $support->assigned_to == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">등록일</label>
                                <input type="text" class="form-control"
                                       value="{{ $support->created_at ? \Carbon\Carbon::parse($support->created_at)->format('Y-m-d H:i:s') : '' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 요청 내용 (읽기 전용) -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">요청 내용</h4>
                    </div>
                    <div class="card-body">
                        <div class="content-area">
                            @if($support->content)
                                {!! nl2br(e($support->content)) !!}
                            @else
                                <span class="text-muted">요청 내용이 입력되지 않았습니다.</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 관리자 답변 -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">관리자 답변</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="admin_reply" class="form-label">답변 내용</label>
                            <textarea name="admin_reply" id="admin_reply"
                                      class="form-control @error('admin_reply') is-invalid @enderror"
                                      rows="8" placeholder="고객에게 전달할 답변을 입력하세요...">{{ old('admin_reply', $support->admin_reply) }}</textarea>
                            @error('admin_reply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                이 답변은 고객에게 이메일로 전송됩니다.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="send_email" id="send_email" value="1" checked>
                                    <label class="form-check-label" for="send_email">
                                        고객에게 이메일 알림 발송
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="auto_close" id="auto_close" value="1">
                                    <label class="form-check-label" for="auto_close">
                                        답변 후 자동으로 상태를 '해결완료'로 변경
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 내부 메모 -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">내부 메모</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="internal_note" class="form-label">내부 메모</label>
                            <textarea name="internal_note" id="internal_note"
                                      class="form-control @error('internal_note') is-invalid @enderror"
                                      rows="4" placeholder="관리자 전용 메모 (고객에게 표시되지 않음)">{{ old('internal_note', $support->internal_note) }}</textarea>
                            @error('internal_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                이 메모는 관리자만 볼 수 있으며 고객에게 공개되지 않습니다.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-save me-2"></i>저장
                                </button>
                                <a href="{{ route('admin.cms.support.requests.show', $support->id) }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>취소
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSupport()">
                                    <i class="fe fe-trash-2 me-2"></i>삭제
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 사이드바 -->
        <div class="col-xl-4">
            <!-- 빠른 상태 변경 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">빠른 상태 변경</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($support->status === 'pending')
                        <button type="button" class="btn btn-info btn-sm" onclick="changeStatus('in_progress')">
                            <i class="fe fe-play me-2"></i>처리 시작
                        </button>
                        @endif

                        @if($support->status === 'in_progress')
                        <button type="button" class="btn btn-success btn-sm" onclick="changeStatus('resolved')">
                            <i class="fe fe-check me-2"></i>해결 완료
                        </button>
                        @endif

                        @if($support->status !== 'closed')
                        <button type="button" class="btn btn-secondary btn-sm" onclick="changeStatus('closed')">
                            <i class="fe fe-x me-2"></i>종료
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 지원 요청 정보 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">요청 정보</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>티켓 ID:</strong>
                        <div class="mt-1">#{{ $support->id }}</div>
                    </div>
                    <div class="mb-3">
                        <strong>현재 상태:</strong>
                        <div class="mt-1">
                            @if($support->status === 'pending')
                                <span class="badge bg-warning">대기중</span>
                            @elseif($support->status === 'in_progress')
                                <span class="badge bg-info">처리중</span>
                            @elseif($support->status === 'resolved')
                                <span class="badge bg-success">해결완료</span>
                            @elseif($support->status === 'closed')
                                <span class="badge bg-secondary">종료</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>우선순위:</strong>
                        <div class="mt-1">
                            @if($support->priority === 'urgent')
                                <span class="badge bg-danger">긴급</span>
                            @elseif($support->priority === 'high')
                                <span class="badge bg-warning">높음</span>
                            @elseif($support->priority === 'medium')
                                <span class="badge bg-info">보통</span>
                            @elseif($support->priority === 'low')
                                <span class="badge bg-secondary">낮음</span>
                            @endif
                        </div>
                    </div>
                    @if($support->resolved_at)
                    <div class="mb-3">
                        <strong>해결일:</strong>
                        <div class="mt-1">{{ \Carbon\Carbon::parse($support->resolved_at)->format('Y-m-d H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 템플릿 답변 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">템플릿 답변</h4>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="insertTemplate('resolved')">
                            해결완료 템플릿
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="insertTemplate('investigating')">
                            조사중 템플릿
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm w-100" onclick="insertTemplate('more_info')">
                            추가정보 요청 템플릿
                        </button>
                    </div>
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
                이 지원 요청을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form method="POST" action="{{ route('admin.cms.support.requests.delete', $support->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF 토큰 설정
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function changeStatus(status) {
    if (confirm('상태를 변경하시겠습니까?')) {
        // 상태 변경 버튼 비활성화
        const buttons = document.querySelectorAll('button[onclick^="changeStatus"]');
        buttons.forEach(btn => btn.disabled = true);

        fetch(`{{ route('admin.cms.support.requests.updateStatus', $support->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 성공 메시지 표시
                alert(data.message);
                // 폼의 상태 선택값 업데이트
                const statusSelect = document.querySelector('select[name="status"]');
                statusSelect.value = status;

                // 자동 종료 체크박스 업데이트
                const autoCloseCheckbox = document.getElementById('auto_close');
                if (status === 'resolved') {
                    autoCloseCheckbox.checked = true;
                }

                // 버튼 다시 활성화
                buttons.forEach(btn => btn.disabled = false);
            } else {
                alert('오류: ' + data.message);
                // 버튼 다시 활성화
                buttons.forEach(btn => btn.disabled = false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('상태 변경 중 오류가 발생했습니다.');
            // 버튼 다시 활성화
            buttons.forEach(btn => btn.disabled = false);
        });
    }
}

function deleteSupport() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function insertTemplate(type) {
    const textarea = document.getElementById('admin_reply');
    let template = '';

    switch(type) {
        case 'resolved':
            template = '안녕하세요.\n\n문의해 주신 내용에 대해 검토를 완료하였습니다.\n\n[해결 방법 또는 답변 내용을 여기에 입력하세요]\n\n추가 문의사항이 있으시면 언제든지 연락 주시기 바랍니다.\n\n감사합니다.';
            break;
        case 'investigating':
            template = '안녕하세요.\n\n문의해 주신 내용을 확인하였습니다.\n\n현재 관련 부서에서 해당 사항에 대해 조사 중이며, 조사가 완료되는 대로 빠른 시일 내에 답변 드리겠습니다.\n\n조금 더 시간이 필요할 수 있으니 양해 부탁드립니다.\n\n감사합니다.';
            break;
        case 'more_info':
            template = '안녕하세요.\n\n문의해 주신 내용을 확인하였습니다.\n\n정확한 답변을 위해 추가 정보가 필요합니다:\n\n1. [필요한 정보 1]\n2. [필요한 정보 2]\n3. [필요한 정보 3]\n\n위 정보를 회신해 주시면 빠른 시일 내에 답변 드리겠습니다.\n\n감사합니다.';
            break;
    }

    textarea.value = template;
    textarea.focus();
}

// 상태 변경 시 자동 처리
document.querySelector('select[name="status"]').addEventListener('change', function() {
    const autoCloseCheckbox = document.getElementById('auto_close');
    if (this.value === 'resolved') {
        autoCloseCheckbox.checked = true;
    } else {
        autoCloseCheckbox.checked = false;
    }
});
</script>
@endpush

@push('styles')
<style>
.content-area {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
    min-height: 100px;
}
</style>
@endpush
