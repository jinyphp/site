@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '자동 할당 설정')

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
                                <i class="fe fe-settings me-2"></i>
                                자동 할당 설정
                            </h1>
                            <p class="page-header-subtitle">카테고리별 기술지원 요청 자동 할당을 설정합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>요청 관리
                            </a>
                            <a href="{{ route('admin.support.auto-assignments.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 설정 추가
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.support.auto-assignments.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="type" class="form-label">유형</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">전체 유형</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ $currentType === $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="enable" class="form-label">상태</label>
                                <select name="enable" id="enable" class="form-select">
                                    <option value="">전체</option>
                                    <option value="1" {{ $currentEnable === '1' ? 'selected' : '' }}>활성화</option>
                                    <option value="0" {{ $currentEnable === '0' ? 'selected' : '' }}>비활성화</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="assignee_id" class="form-label">담당자</label>
                                <select name="assignee_id" id="assignee_id" class="form-select">
                                    <option value="">전체 담당자</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ $currentAssigneeId == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fe fe-filter me-2"></i>필터 적용
                                </button>
                                <a href="{{ route('admin.support.auto-assignments.index') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>초기화
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 자동 할당 설정 목록 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">자동 할당 설정 목록</h4>
                    <div>
                        <span class="text-muted">총 {{ $autoAssignments->total() }}개</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($autoAssignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>유형</th>
                                        <th>우선순위</th>
                                        <th>담당자</th>
                                        <th>순서</th>
                                        <th>상태</th>
                                        <th>설명</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($autoAssignments as $assignment)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $assignment->type_label }}</span>
                                        </td>
                                        <td>
                                            @if($assignment->priority)
                                                @if($assignment->priority === 'urgent')
                                                    <span class="badge bg-danger">긴급</span>
                                                @elseif($assignment->priority === 'high')
                                                    <span class="badge bg-warning">높음</span>
                                                @elseif($assignment->priority === 'normal')
                                                    <span class="badge bg-info">보통</span>
                                                @elseif($assignment->priority === 'low')
                                                    <span class="badge bg-secondary">낮음</span>
                                                @endif
                                            @else
                                                <span class="text-muted">모든 우선순위</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $assignment->assignee->name }}</div>
                                                    <small class="text-muted">{{ $assignment->assignee->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $assignment->order }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       {{ $assignment->enable ? 'checked' : '' }}
                                                       onchange="toggleAssignment({{ $assignment->id }})">
                                                <label class="form-check-label">
                                                    {{ $assignment->enable ? '활성' : '비활성' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ Str::limit($assignment->description, 50) }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.support.auto-assignments.show', $assignment->id) }}"
                                                   class="btn btn-outline-primary btn-sm" title="상세보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.support.auto-assignments.edit', $assignment->id) }}"
                                                   class="btn btn-outline-secondary btn-sm" title="수정">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteAssignment({{ $assignment->id }})" title="삭제">
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
                            {{ $autoAssignments->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fe fe-settings fs-1 mb-3"></i>
                            <h5>자동 할당 설정이 없습니다</h5>
                            <p>새로운 자동 할당 설정을 추가해보세요.</p>
                            <a href="{{ route('admin.support.auto-assignments.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>설정 추가
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 도움말 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info">
                <h6 class="alert-heading">
                    <i class="fe fe-info me-2"></i>자동 할당 설정 안내
                </h6>
                <ul class="mb-0">
                    <li><strong>유형</strong>: 기술지원 요청의 유형별로 설정할 수 있습니다.</li>
                    <li><strong>우선순위</strong>: 특정 우선순위만 자동 할당하거나, 비워두면 모든 우선순위에 적용됩니다.</li>
                    <li><strong>순서</strong>: 낮은 번호부터 우선 적용됩니다. (0이 가장 높은 우선순위)</li>
                    <li><strong>중복 설정</strong>: 같은 유형과 우선순위에 여러 담당자를 설정할 수 없습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">설정 삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                이 자동 할당 설정을 삭제하시겠습니까?<br>
                삭제된 설정은 복구할 수 없습니다.
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

@endsection

@push('scripts')
<script>
// 자동 할당 설정 활성/비활성 토글
function toggleAssignment(id) {
    fetch(`/admin/support/auto-assignments/${id}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 시 페이지 새로고침으로 상태 반영
            location.reload();
        } else {
            alert('오류: ' + data.message);
            // 실패 시 체크박스 상태 되돌리기
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('네트워크 오류가 발생했습니다.');
        location.reload();
    });
}

// 삭제 확인
function deleteAssignment(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/support/auto-assignments/${id}`;
    modal.show();
}
</script>
@endpush
