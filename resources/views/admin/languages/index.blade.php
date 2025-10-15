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
                                <i class="bi bi-translate me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.language.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 언어 추가
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

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 언어</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-translate"></i>
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
                            <h2 class="text-success mb-0">{{ number_format($stats['active']) }}</h2>
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
                            <h2 class="text-warning mb-0">{{ number_format($stats['inactive']) }}</h2>
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
                            <h4 class="card-title mb-1">기본 언어</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['default']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-star"></i>
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
                                   placeholder="언어명, 코드, 설명" value="{{ request('search') }}">
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
                            <label class="form-label">기본 언어</label>
                            <select name="is_default" class="form-select">
                                <option value="all">전체</option>
                                <option value="1" {{ request('is_default') == '1' ? 'selected' : '' }}>기본 언어</option>
                                <option value="0" {{ request('is_default') == '0' ? 'selected' : '' }}>일반 언어</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="order" {{ request('sort_by') == 'order' ? 'selected' : '' }}>순서</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>언어명</option>
                                <option value="lang" {{ request('sort_by') == 'lang' ? 'selected' : '' }}>언어 코드</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">순서</label>
                            <select name="order" class="form-select">
                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>오름차순</option>
                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>내림차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.language.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 언어 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">언어 목록</h4>
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

                    @if($languages->count() > 0)
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
                                        <th width="80">국기</th>
                                        <th class="sortable" data-sort="name">
                                            언어 정보 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="100" class="sortable" data-sort="enable">
                                            상태 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="150" class="sortable" data-sort="is_default">
                                            기본 언어 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="120" class="sortable" data-sort="order">
                                            순서 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="200">관리</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach($languages as $language)
                                    <tr data-id="{{ $language->id }}">
                                        <td>
                                            <input type="checkbox" name="language_ids[]" value="{{ $language->id }}" class="form-check-input language-checkbox">
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ $language->id }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($language->flag)
                                                <span style="font-size: 24px;">{{ $language->flag }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $language->name }}</strong>
                                                    @if($language->native_name && $language->native_name !== $language->name)
                                                        <span class="text-muted">({{ $language->native_name }})</span>
                                                    @endif
                                                    <div>
                                                        <span class="badge bg-secondary">{{ strtoupper($language->lang) }}</span>
                                                        @if($language->locale)
                                                            <span class="badge bg-light text-dark">{{ $language->locale }}</span>
                                                        @endif
                                                    </div>
                                                    @if($language->description)
                                                        <div class="text-muted small mt-1">
                                                            {{ Str::limit($language->description, 60) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       {{ $language->enable ? 'checked' : '' }}
                                                       onchange="toggleStatus({{ $language->id }}, this.checked)">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($language->is_default)
                                                <span class="badge bg-warning">
                                                    <i class="fe fe-star me-1"></i>기본
                                                </span>
                                            @else
                                                <button type="button" class="btn btn-outline-warning btn-sm"
                                                        onclick="setDefault({{ $language->id }})" title="기본 언어로 설정">
                                                    <i class="fe fe-star"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="badge bg-info me-2">{{ $language->order }}</span>
                                                <i class="fe fe-move text-muted" style="cursor: move; font-size: 16px;" title="드래그하여 순서 변경"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                <a href="{{ route('admin.cms.language.show', $language->id) }}"
                                                   class="btn btn-outline-info btn-sm" title="보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.cms.language.edit', $language->id) }}"
                                                   class="btn btn-outline-primary btn-sm" title="수정">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                        onclick="deleteLanguage({{ $language->id }})">
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
                        <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                            <div class="text-muted">
                                총 {{ number_format($languages->total()) }}개 중
                                {{ number_format($languages->firstItem()) }} - {{ number_format($languages->lastItem()) }}개 표시
                            </div>
                            <div>
                                {{ $languages->appends(request()->query())->links('pagination.custom') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 px-3">
                            <i class="fe fe-search fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">언어를 찾을 수 없습니다</h5>
                            <p class="text-muted mb-3">검색 조건을 변경하거나 새로운 언어를 추가해보세요.</p>
                            <a href="{{ route('admin.cms.language.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 언어 추가
                            </a>
                        </div>
                    @endif
                </div>
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
.sortable.sort-asc .fe-chevrons-up-down {
    display: none;
}
.sortable.sort-desc .fe-chevrons-up-down {
    display: none;
}
.sortable.sort-asc::after {
    content: "\f282"; /* fe-chevron-up */
    font-family: "Feather";
    font-size: 12px;
    color: #007bff;
    margin-left: 5px;
}
.sortable.sort-desc::after {
    content: "\f283"; /* fe-chevron-down */
    font-family: "Feather";
    font-size: 12px;
    color: #007bff;
    margin-left: 5px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.language-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 컬럼 정렬 기능
document.addEventListener('DOMContentLoaded', function() {
    // 현재 정렬 상태 표시
    updateSortIndicators();

    // 정렬 가능한 헤더에 클릭 이벤트 추가
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.getAttribute('data-sort');
            const currentSortBy = getUrlParameter('sort_by') || 'order';
            const currentOrder = getUrlParameter('order') || 'asc';

            let newOrder = 'asc';
            if (sortBy === currentSortBy) {
                // 같은 컬럼을 클릭한 경우 정렬 순서 토글
                newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
            }

            // URL 업데이트하여 페이지 이동
            updateUrlWithSort(sortBy, newOrder);
        });
    });
});

// URL 파라미터 가져오기
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// 정렬 파라미터로 URL 업데이트
function updateUrlWithSort(sortBy, order) {
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('sort_by', sortBy);
    urlParams.set('order', order);

    // 페이지를 첫 번째로 리셋 (정렬이 변경되면 페이지네이션 초기화)
    urlParams.delete('page');

    window.location.href = window.location.pathname + '?' + urlParams.toString();
}

// 정렬 지시자 업데이트
function updateSortIndicators() {
    const currentSortBy = getUrlParameter('sort_by') || 'order';
    const currentOrder = getUrlParameter('order') || 'asc';

    // 모든 정렬 클래스 제거
    document.querySelectorAll('.sortable').forEach(header => {
        header.classList.remove('sort-asc', 'sort-desc');
    });

    // 현재 정렬된 컬럼에 클래스 추가
    const activeHeader = document.querySelector(`[data-sort="${currentSortBy}"]`);
    if (activeHeader) {
        activeHeader.classList.add(currentOrder === 'asc' ? 'sort-asc' : 'sort-desc');
    }
}

// 정렬 기능
const sortable = Sortable.create(document.getElementById('sortable'), {
    handle: '.fe-move',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onStart: function(evt) {
        // 드래그 시작 시 피드백
        evt.item.style.cursor = 'grabbing';
    },
    onEnd: function(evt) {
        // 드래그 종료 시 커서 복원
        evt.item.style.cursor = '';

        // 순서가 변경되었는지 확인
        if (evt.oldIndex !== evt.newIndex) {
            updateLanguageOrder();
        }
    }
});

// 언어 순서 업데이트
function updateLanguageOrder() {
    const tbody = document.getElementById('sortable');
    const rows = tbody.querySelectorAll('tr[data-id]');
    const orderData = [];

    rows.forEach((row, index) => {
        const id = row.getAttribute('data-id');
        orderData.push({
            id: parseInt(id),
            order: index + 1
        });
    });

    // 서버에 순서 업데이트 요청
    fetch('/admin/cms/language/update-order', {
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
            showAlert('success', '언어 순서가 업데이트되었습니다.');
            // 순서 컬럼의 값도 업데이트
            updateOrderColumn(orderData);
        } else {
            showAlert('error', '언어 순서 업데이트에 실패했습니다.');
            // 실패 시 페이지 새로고침으로 원상복구
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', '언어 순서 업데이트 중 오류가 발생했습니다.');
        location.reload();
    });
}

// 순서 컬럼 값 업데이트
function updateOrderColumn(orderData) {
    orderData.forEach(item => {
        const row = document.querySelector(`tr[data-id="${item.id}"]`);
        if (row) {
            const orderCell = row.querySelector('td:nth-child(6) .badge'); // 순서 컬럼 (6번째)
            if (orderCell) {
                orderCell.textContent = item.order;
            }
        }
    });
}

// 활성화/비활성화 토글
function toggleStatus(id, enabled) {
    fetch(`/admin/cms/language/${id}/toggle`, {
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
            location.reload();
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 기본 언어 설정
function setDefault(id) {
    if (confirm('이 언어를 기본 언어로 설정하시겠습니까?')) {
        fetch(`/admin/cms/language/${id}/set-default`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
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

// 언어 삭제
function deleteLanguage(id) {
    if (confirm('정말 삭제하시겠습니까?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/cms/language/${id}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// 일괄 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.language-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedIds.length}개 항목을 삭제하시겠습니까?`)) {
        return;
    }

    // 일괄 작업 구현
    fetch('/admin/cms/language/bulk-action', {
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
