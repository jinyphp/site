@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '상담 유형 관리')

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
                                <i class="bi bi-tags me-2"></i>상담 유형 관리
                            </h1>
                            <p class="page-header-subtitle">상담 카테고리를 관리합니다</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.contact.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fe fe-headphones me-2"></i>상담 관리
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fe fe-plus me-2"></i>새 유형 추가
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
                            <h4 class="card-title mb-1">전체 유형</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-tags"></i>
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
                            <h4 class="card-title mb-1">활성화됨</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['active'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
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
                            <h4 class="card-title mb-1">비활성화됨</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['inactive'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-x-circle"></i>
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
                            <h4 class="card-title mb-1">사용 중</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['in_use'] ?? 0) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-message-circle"></i>
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
                        <div class="col-md-4">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control"
                                   placeholder="유형명, 설명" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">활성화 상태</label>
                            <select name="enable" class="form-select">
                                <option value="all">전체</option>
                                <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>활성화됨</option>
                                <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>비활성화됨</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="sort_order" {{ request('sort_by') == 'sort_order' ? 'selected' : '' }}>순서</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>유형명</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">순서</label>
                            <select name="order" class="form-select">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>오름차순</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>내림차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.contact.types.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 유형 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">상담 유형 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            선택 삭제
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkEnable()">
                            <i class="fe fe-check-circle me-1"></i>선택 활성화
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="bulkDisable()">
                            <i class="fe fe-x-circle me-1"></i>선택 비활성화
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- 알림 메시지 영역 -->
                    <div id="alertContainer" class="p-3" style="display: none;"></div>

                    @if(isset($types) && $types->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th width="60" class="sortable" data-sort="id">
                                            ID <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th class="sortable" data-sort="name">
                                            유형 정보 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="100" class="sortable" data-sort="enable">
                                            상태 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="120" class="sortable" data-sort="sort_order">
                                            순서 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="100">사용량</th>
                                        <th width="200">관리</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach($types as $type)
                                    <tr data-id="{{ $type->id }}">
                                        <td>
                                            <input type="checkbox" name="type_ids[]" value="{{ $type->id }}" class="form-check-input type-checkbox">
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ $type->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $type->name }}</strong>
                                                    @if($type->description)
                                                        <div class="text-muted small mt-1">
                                                            {{ Str::limit($type->description, 60) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       {{ $type->enable ? 'checked' : '' }}
                                                       onchange="toggleStatus({{ $type->id }}, this.checked)">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="badge bg-info me-2">{{ $type->sort_order ?? 0 }}</span>
                                                <i class="fe fe-move text-muted" style="cursor: move; font-size: 16px;" title="드래그하여 순서 변경"></i>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark">{{ $type->contacts_count ?? 0 }}건</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                <button type="button" class="btn btn-outline-primary btn-sm" title="수정"
                                                        onclick="editType({{ $type->id }}, '{{ $type->name }}', '{{ $type->description }}', {{ $type->sort_order ?? 0 }}, {{ $type->enable ? 'true' : 'false' }})">
                                                    <i class="fe fe-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                        onclick="deleteType({{ $type->id }})">
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
                        @if(isset($types) && method_exists($types, 'links'))
                        <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                            <div class="text-muted">
                                총 {{ number_format($types->total()) }}개 중
                                {{ number_format($types->firstItem()) }} - {{ number_format($types->lastItem()) }}개 표시
                            </div>
                            <div>
                                {{ $types->appends(request()->query())->links() }}
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5 px-3">
                            <i class="fe fe-search fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">상담 유형을 찾을 수 없습니다</h5>
                            <p class="text-muted mb-3">검색 조건을 변경하거나 새로운 유형을 추가해보세요.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="fe fe-plus me-2"></i>새 유형 추가
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 유형 생성 모달 -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">새 상담 유형 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createForm">
                    <div class="mb-3">
                        <label class="form-label">유형명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="createName" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">설명</label>
                        <textarea class="form-control" id="createDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">표시 순서</label>
                        <input type="number" class="form-control" id="createSortOrder" value="0" min="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="createType()">추가</button>
            </div>
        </div>
    </div>
</div>

<!-- 유형 수정 모달 -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">상담 유형 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label class="form-label">유형명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editName" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">설명</label>
                        <textarea class="form-control" id="editDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">표시 순서</label>
                        <input type="number" class="form-control" id="editSortOrder" value="0" min="0">
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="editEnable">
                            <label class="form-check-label" for="editEnable">활성화</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="updateType()">수정</button>
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

/* 드래그 중인 행 스타일 */
.sortable-ghost {
    opacity: 0.5;
    background-color: #f8f9fa;
}
.sortable-chosen {
    background-color: #e3f2fd;
}
.fe-move {
    cursor: move;
}
.fe-move:hover {
    color: #495057;
    transform: scale(1.2);
}

/* 정렬 가능한 헤더 스타일 */
.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
}
.sortable:hover {
    background-color: #f8f9fa;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.type-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 정렬 기능
const sortable = Sortable.create(document.getElementById('sortable'), {
    handle: '.fe-move',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onEnd: function(evt) {
        if (evt.oldIndex !== evt.newIndex) {
            updateTypeOrder();
        }
    }
});

// 유형 순서 업데이트
function updateTypeOrder() {
    const tbody = document.getElementById('sortable');
    const rows = tbody.querySelectorAll('tr[data-id]');
    const orderData = [];

    rows.forEach((row, index) => {
        const id = row.getAttribute('data-id');
        orderData.push({
            id: parseInt(id),
            sort_order: index + 1
        });
    });

    fetch('/admin/cms/contact/types/update-order', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ orders: orderData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', '유형 순서가 업데이트되었습니다.');
            updateOrderColumn(orderData);
        } else {
            showAlert('error', '유형 순서 업데이트에 실패했습니다.');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', '유형 순서 업데이트 중 오류가 발생했습니다.');
        location.reload();
    });
}

// 순서 컬럼 값 업데이트
function updateOrderColumn(orderData) {
    orderData.forEach(item => {
        const row = document.querySelector(`tr[data-id="${item.id}"]`);
        if (row) {
            const orderCell = row.querySelector('td:nth-child(5) .badge');
            if (orderCell) {
                orderCell.textContent = item.sort_order;
            }
        }
    });
}

// 활성화/비활성화 토글
function toggleStatus(id, enabled) {
    fetch(`/admin/cms/contact/types/${id}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ enable: enabled })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 유형 생성
function createType() {
    const name = document.getElementById('createName').value;
    const description = document.getElementById('createDescription').value;
    const sortOrder = document.getElementById('createSortOrder').value;

    if (!name.trim()) {
        alert('유형명을 입력해주세요.');
        return;
    }

    fetch('/admin/cms/contact/types', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: name,
            description: description,
            sort_order: parseInt(sortOrder) || 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
            location.reload();
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 유형 수정 모달 표시
function editType(id, name, description, sortOrder, enable) {
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editSortOrder').value = sortOrder;
    document.getElementById('editEnable').checked = enable;

    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

// 유형 수정
function updateType() {
    const id = document.getElementById('editId').value;
    const name = document.getElementById('editName').value;
    const description = document.getElementById('editDescription').value;
    const sortOrder = document.getElementById('editSortOrder').value;
    const enable = document.getElementById('editEnable').checked;

    if (!name.trim()) {
        alert('유형명을 입력해주세요.');
        return;
    }

    fetch(`/admin/cms/contact/types/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            name: name,
            description: description,
            sort_order: parseInt(sortOrder) || 0,
            enable: enable
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            location.reload();
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 유형 삭제
function deleteType(id) {
    if (confirm('정말 삭제하시겠습니까?\n\n이 유형을 사용하는 상담이 있는 경우 삭제할 수 없습니다.')) {
        fetch(`/admin/cms/contact/types/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
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

// 일괄 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.type-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedIds.length}개 항목을 삭제하시겠습니까?`)) {
        return;
    }

    fetch('/admin/cms/contact/types/bulk-action', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            action: action,
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

function bulkEnable() {
    bulkAction('enable');
}

function bulkDisable() {
    bulkAction('disable');
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
