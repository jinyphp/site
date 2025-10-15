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
                                <i class="bi bi-bullhorn me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.banner.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 베너 추가
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
                            <h4 class="card-title mb-1">전체 베너</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-bullhorn"></i>
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
                            <h4 class="card-title mb-1">만료됨</h4>
                            <h2 class="text-danger mb-0">{{ number_format($stats['expired']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-danger text-white rounded-circle">
                            <i class="fe fe-clock"></i>
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
                                   placeholder="제목, 메시지" value="{{ request('search') }}">
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
                            <label class="form-label">베너 타입</label>
                            <select name="type" class="form-select">
                                <option value="all">전체</option>
                                <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>정보</option>
                                <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>경고</option>
                                <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>성공</option>
                                <option value="danger" {{ request('type') == 'danger' ? 'selected' : '' }}>위험</option>
                                <option value="primary" {{ request('type') == 'primary' ? 'selected' : '' }}>주요</option>
                                <option value="secondary" {{ request('type') == 'secondary' ? 'selected' : '' }}>보조</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="display_order" {{ request('sort_by') == 'display_order' ? 'selected' : '' }}>순서</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>제목</option>
                                <option value="type" {{ request('sort_by') == 'type' ? 'selected' : '' }}>타입</option>
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
                            <a href="{{ route('admin.site.banner.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 베너 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">베너 목록</h4>
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

                    @if($banners->count() > 0)
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
                                        <th width="80">타입</th>
                                        <th class="sortable" data-sort="title">
                                            베너 정보 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="120">유효기간</th>
                                        <th width="100" class="sortable" data-sort="enable">
                                            상태 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="120" class="sortable" data-sort="display_order">
                                            순서 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="200">관리</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach($banners as $banner)
                                    <tr data-id="{{ $banner->id }}">
                                        <td>
                                            <input type="checkbox" name="banner_ids[]" value="{{ $banner->id }}" class="form-check-input banner-checkbox">
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ $banner->id }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $banner->type }}">{{ ucfirst($banner->type) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $banner->title }}</strong>
                                                    <div class="text-muted small mt-1">
                                                        {{ Str::limit($banner->message, 80) }}
                                                    </div>
                                                    @if($banner->link_url)
                                                        <div class="mt-1">
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fe fe-link me-1"></i>
                                                                {{ $banner->link_text ?: '링크' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($banner->start_date || $banner->end_date)
                                                <div class="small">
                                                    @if($banner->start_date)
                                                        <div>시작: {{ $banner->start_date->format('Y-m-d') }}</div>
                                                    @endif
                                                    @if($banner->end_date)
                                                        <div>종료: {{ $banner->end_date->format('Y-m-d') }}</div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">무제한</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       {{ $banner->enable ? 'checked' : '' }}
                                                       onchange="toggleStatus({{ $banner->id }}, this.checked)">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <span class="badge bg-info me-2">{{ $banner->display_order }}</span>
                                                <i class="fe fe-move text-muted" style="cursor: move; font-size: 16px;" title="드래그하여 순서 변경"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                <a href="{{ route('admin.site.banner.show', $banner->id) }}"
                                                   class="btn btn-outline-info btn-sm" title="보기">
                                                    <i class="fe fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.site.banner.edit', $banner->id) }}"
                                                   class="btn btn-outline-primary btn-sm" title="수정">
                                                    <i class="fe fe-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                        onclick="deleteBanner({{ $banner->id }})">
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
                                총 {{ number_format($banners->total()) }}개 중
                                {{ number_format($banners->firstItem()) }} - {{ number_format($banners->lastItem()) }}개 표시
                            </div>
                            <div>
                                {{ $banners->appends(request()->query())->links('pagination.custom') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 px-3">
                            <i class="fe fe-search fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">베너를 찾을 수 없습니다</h5>
                            <p class="text-muted mb-3">검색 조건을 변경하거나 새로운 베너를 추가해보세요.</p>
                            <a href="{{ route('admin.site.banner.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 베너 추가
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
    const checkboxes = document.querySelectorAll('.banner-checkbox');
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
            const currentSortBy = getUrlParameter('sort_by') || 'display_order';
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
    const currentSortBy = getUrlParameter('sort_by') || 'display_order';
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
            updateBannerOrder();
        }
    }
});

// 베너 순서 업데이트
function updateBannerOrder() {
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
    fetch('/admin/site/banner/update-order', {
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
            showAlert('success', '베너 순서가 업데이트되었습니다.');
            // 순서 컬럼의 값도 업데이트
            updateOrderColumn(orderData);
        } else {
            showAlert('error', '베너 순서 업데이트에 실패했습니다.');
            // 실패 시 페이지 새로고침으로 원상복구
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', '베너 순서 업데이트 중 오류가 발생했습니다.');
        location.reload();
    });
}

// 순서 컬럼 값 업데이트
function updateOrderColumn(orderData) {
    orderData.forEach(item => {
        const row = document.querySelector(`tr[data-id="${item.id}"]`);
        if (row) {
            const orderCell = row.querySelector('td:nth-child(7) .badge'); // 순서 컬럼 (7번째)
            if (orderCell) {
                orderCell.textContent = item.order;
            }
        }
    });
}

// 활성화/비활성화 토글
function toggleStatus(id, enabled) {
    fetch(`/admin/site/banner/${id}/toggle`, {
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

// 베너 삭제
function deleteBanner(id) {
    if (confirm('정말 삭제하시겠습니까?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/site/banner/${id}`;

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
    const selectedIds = Array.from(document.querySelectorAll('.banner-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedIds.length}개 항목을 삭제하시겠습니까?`)) {
        return;
    }

    // 일괄 작업 구현
    fetch('/admin/site/banner/bulk-action', {
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
