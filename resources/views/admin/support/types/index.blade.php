@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 유형 관리')

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
                                <i class="fe fe-layers me-2"></i>
                                지원 요청 유형 관리
                            </h1>
                            <p class="page-header-subtitle">기술문의 종류를 등록하고 관리합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>지원 요청 목록
                            </a>
                            <a href="{{ route('admin.cms.support.types.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 유형 추가
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mt-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 유형</h4>
                            <h2 class="text-primary mb-0">{{ number_format($statistics['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-layers"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">활성 유형</h4>
                            <h2 class="text-success mb-0">{{ number_format($statistics['active']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">비활성 유형</h4>
                            <h2 class="text-secondary mb-0">{{ number_format($statistics['inactive']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-secondary text-white rounded-circle">
                            <i class="fe fe-x-circle"></i>
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
                    <form method="GET" action="{{ route('admin.cms.support.types.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">상태</label>
                                <select name="status" class="form-select">
                                    <option value="">모든 상태</option>
                                    <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>활성</option>
                                    <option value="inactive" {{ $currentStatus === 'inactive' ? 'selected' : '' }}>비활성</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">기본 우선순위</label>
                                <select name="priority" class="form-select">
                                    <option value="">모든 우선순위</option>
                                    <option value="low" {{ $currentPriority === 'low' ? 'selected' : '' }}>낮음</option>
                                    <option value="normal" {{ $currentPriority === 'normal' ? 'selected' : '' }}>보통</option>
                                    <option value="high" {{ $currentPriority === 'high' ? 'selected' : '' }}>높음</option>
                                    <option value="urgent" {{ $currentPriority === 'urgent' ? 'selected' : '' }}>긴급</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">정렬</label>
                                <select name="sort_by" class="form-select">
                                    <option value="sort_order" {{ $sortBy === 'sort_order' ? 'selected' : '' }}>정렬 순서</option>
                                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>이름</option>
                                    <option value="code" {{ $sortBy === 'code' ? 'selected' : '' }}>코드</option>
                                    <option value="created_at" {{ $sortBy === 'created_at' ? 'selected' : '' }}>생성일</option>
                                    <option value="total_requests" {{ $sortBy === 'total_requests' ? 'selected' : '' }}>요청 수</option>
                                    <option value="resolution_rate" {{ $sortBy === 'resolution_rate' ? 'selected' : '' }}>해결률</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">검색</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="이름, 코드, 설명 검색..." value="{{ $searchKeyword }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fe fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-filter me-2"></i>필터 적용
                                </button>
                                <a href="{{ route('admin.cms.support.types.index') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>필터 초기화
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 지원 요청 유형 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">지원 요청 유형 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-success btn-sm" id="reorderBtn">
                            <i class="fe fe-move me-2"></i>순서 변경
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="bulkDeleteBtn" disabled>
                            <i class="fe fe-trash-2 me-2"></i>선택 삭제
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($types->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="typesTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>순서</th>
                                        <th>아이콘</th>
                                        <th>이름/코드</th>
                                        <th>설명</th>
                                        <th>우선순위</th>
                                        <th>기본 담당자</th>
                                        <th>예상 해결시간</th>
                                        <th>요청 수</th>
                                        <th>해결률</th>
                                        <th>상태</th>
                                        <th>관리</th>
                                    </tr>
                                </thead>
                                <tbody id="sortableBody">
                                    @foreach($types as $type)
                                    <tr data-id="{{ $type->id }}" data-sort-order="{{ $type->sort_order }}">
                                        <td>
                                            <input type="checkbox" name="selected_ids[]" value="{{ $type->id }}" class="form-check-input item-checkbox">
                                        </td>
                                        <td>
                                            <span class="sort-handle" style="cursor: grab;">
                                                <i class="fe fe-move text-muted"></i>
                                            </span>
                                            <span class="ms-2">{{ $type->sort_order }}</span>
                                        </td>
                                        <td>
                                            @if($type->icon)
                                                <i class="{{ $type->icon }}" style="color: {{ $type->color }}; font-size: 1.2em;"></i>
                                            @else
                                                <i class="fe fe-circle text-muted"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <a href="{{ route('admin.cms.support.types.show', $type->id) }}" class="text-decoration-none">
                                                    <strong>{{ $type->name }}</strong>
                                                </a>
                                                <br>
                                                <small class="text-muted">{{ $type->code }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="max-width: 200px;">
                                                {{ Str::limit($type->description, 80) }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $type->priority_class }}">
                                                {{ $type->priority_label }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($type->defaultAssignee)
                                                {{ $type->defaultAssignee->name }}
                                            @else
                                                <span class="text-muted">미설정</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $type->formatted_resolution_time }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ number_format($type->total_requests) }}</span>
                                        </td>
                                        <td>
                                            @if($type->total_requests > 0)
                                                <span class="badge bg-success">{{ number_format($type->resolution_rate, 1) }}%</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $type->status_class }}">
                                                {{ $type->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.cms.support.types.show', $type->id) }}"
                                                   class="btn btn-outline-primary btn-sm" title="상세보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.cms.support.types.edit', $type->id) }}"
                                                   class="btn btn-outline-secondary btn-sm" title="수정">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteItem({{ $type->id }})" title="삭제">
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
                            {{ $types->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fe fe-layers fs-1 mb-3"></i>
                            <h5>등록된 지원 요청 유형이 없습니다</h5>
                            <p>새로운 지원 요청 유형을 추가해보세요.</p>
                            <a href="{{ route('admin.cms.support.types.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>첫 번째 유형 추가
                            </a>
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
                선택한 지원 요청 유형을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.
                <div class="alert alert-warning mt-3">
                    <i class="fe fe-alert-triangle me-2"></i>
                    이 유형을 사용하는 지원 요청이 있는 경우 삭제할 수 없습니다.
                </div>
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
<form id="bulkActionForm" method="POST" action="{{ route('admin.cms.support.types.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkAction">
    <input type="hidden" name="selected_ids" id="bulkSelectedIds">
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
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

    // 드래그 앤 드롭 정렬
    let sortable = null;
    const reorderBtn = document.getElementById('reorderBtn');

    reorderBtn.addEventListener('click', function() {
        if (sortable) {
            // 정렬 모드 비활성화
            sortable.destroy();
            sortable = null;
            reorderBtn.innerHTML = '<i class="fe fe-move me-2"></i>순서 변경';
            reorderBtn.classList.remove('btn-warning');
            reorderBtn.classList.add('btn-outline-success');
        } else {
            // 정렬 모드 활성화
            sortable = Sortable.create(document.getElementById('sortableBody'), {
                handle: '.sort-handle',
                animation: 150,
                onEnd: function(evt) {
                    updateSortOrder();
                }
            });
            reorderBtn.innerHTML = '<i class="fe fe-save me-2"></i>순서 저장';
            reorderBtn.classList.remove('btn-outline-success');
            reorderBtn.classList.add('btn-warning');
        }
    });

    function updateSortOrder() {
        const rows = document.querySelectorAll('#sortableBody tr');
        const items = [];

        rows.forEach((row, index) => {
            items.push({
                id: row.dataset.id,
                sort_order: index + 1
            });
        });

        // AJAX로 순서 업데이트
        fetch('{{ route("admin.cms.support.types.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: items })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 순서 번호 업데이트
                rows.forEach((row, index) => {
                    row.querySelector('td:nth-child(2) span:last-child').textContent = index + 1;
                });

                // 알림 표시
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message || '순서 업데이트에 실패했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', '순서 업데이트 중 오류가 발생했습니다.');
        });
    }

    function showAlert(type, message) {
        // 간단한 알림 표시 (실제 환경에서는 토스트나 다른 알림 시스템 사용)
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // 페이지 상단에 알림 추가
        const container = document.querySelector('.container-fluid');
        container.insertAdjacentHTML('afterbegin', alertHtml);

        // 3초 후 자동 제거
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) alert.remove();
        }, 3000);
    }
});

function deleteItem(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ route('admin.cms.support.types.index') }}/${id}`;
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.sort-handle {
    cursor: grab !important;
}

.sort-handle:active {
    cursor: grabbing !important;
}

.sortable-ghost {
    opacity: 0.4;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush
