@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '메뉴 관리')

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
                                <i class="bi bi-menu-button-wide me-2"></i>
                                메뉴 관리
                            </h1>
                            <p class="page-header-subtitle">사이트 내비게이션 메뉴를 생성하고 관리합니다</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                                <i class="fe fe-plus me-2"></i>새 메뉴 생성
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
                            <h4 class="card-title mb-1">전체 메뉴</h4>
                            <h2 class="text-primary mb-0">{{ number_format($menus->count()) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-menu-button-wide"></i>
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
                            <h4 class="card-title mb-1">활성 메뉴</h4>
                            <h2 class="text-success mb-0">{{ number_format($menus->where('enable', true)->count()) }}</h2>
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
                            <h4 class="card-title mb-1">비활성 메뉴</h4>
                            <h2 class="text-warning mb-0">{{ number_format($menus->where('enable', false)->count()) }}</h2>
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
                            <h4 class="card-title mb-1">템플릿 연결</h4>
                            <h2 class="text-info mb-0">{{ number_format($menus->whereNotNull('blade')->count()) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-code"></i>
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
                                   placeholder="메뉴 코드, 설명, 템플릿" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">활성화 상태</label>
                            <select name="enable" class="form-select">
                                <option value="all">전체</option>
                                <option value="1" {{ request('enable') == '1' ? 'selected' : '' }}>활성화됨</option>
                                <option value="0" {{ request('enable') == '0' ? 'selected' : '' }}>비활성화됨</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                                <option value="code" {{ request('sort_by') == 'code' ? 'selected' : '' }}>메뉴 코드</option>
                                <option value="enable" {{ request('sort_by') == 'enable' ? 'selected' : '' }}>활성화 상태</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.menu.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 메뉴 목록 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">메뉴 목록</h4>
                    <div>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="bulkAction('delete')">
                            <i class="fe fe-trash-2 me-1"></i>선택 삭제
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

                    @if($menus->count() > 0)
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
                                        <th class="sortable" data-sort="code">
                                            메뉴 정보 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="150">블레이드 템플릿</th>
                                        <th width="100" class="sortable" data-sort="enable">
                                            상태 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="120" class="sortable" data-sort="created_at">
                                            생성일 <i class="fe fe-chevrons-up-down text-muted ms-1"></i>
                                        </th>
                                        <th width="200">관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menus as $menu)
                                    <tr data-id="{{ $menu->id }}">
                                        <td>
                                            <input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}" class="form-check-input menu-checkbox">
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-primary">{{ $menu->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $menu->code }}</strong>
                                                    @if($menu->description)
                                                        <div class="text-muted small mt-1">
                                                            {{ Str::limit($menu->description, 60) }}
                                                        </div>
                                                    @endif
                                                    @if($menu->manager)
                                                        <div>
                                                            <span class="badge bg-light text-dark">관리자: {{ $menu->manager }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($menu->blade)
                                                <code class="text-info">{{ $menu->blade }}</code>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       {{ $menu->enable ? 'checked' : '' }}
                                                       onchange="toggleStatus({{ $menu->id }}, this.checked)">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-muted">{{ $menu->created_at->format('Y-m-d') }}</span>
                                            <div class="text-muted small">{{ $menu->created_at->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex justify-content-center">
                                                <a href="{{ route('admin.cms.menu.show', $menu->id) }}"
                                                   class="btn btn-outline-info btn-sm" title="아이템 관리">
                                                    <i class="fe fe-list"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-primary btn-sm" title="수정"
                                                        onclick="editMenu({{ $menu->id }}, '{{ $menu->code }}', '{{ $menu->description }}', '{{ $menu->blade }}', '{{ $menu->manager }}', {{ $menu->enable ? 'true' : 'false' }})">
                                                    <i class="fe fe-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" title="삭제"
                                                        onclick="deleteMenu({{ $menu->id }})">
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
                        <div class="text-center py-5 px-3">
                            <i class="fe fe-menu fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">메뉴를 찾을 수 없습니다</h5>
                            <p class="text-muted mb-3">검색 조건을 변경하거나 새로운 메뉴를 추가해보세요.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                                <i class="fe fe-plus me-2"></i>새 메뉴 생성
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 메뉴 생성 모달 -->
<div class="modal fade" id="createMenuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">새 메뉴 생성</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createMenuForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menuCode" class="form-label">메뉴 코드 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="menuCode" name="code" required
                               placeholder="예: main_menu, footer_menu">
                        <div class="form-text">영문, 숫자, 언더스코어만 사용 가능합니다.</div>
                    </div>
                    <div class="mb-3">
                        <label for="menuDescription" class="form-label">설명</label>
                        <input type="text" class="form-control" id="menuDescription" name="description"
                               placeholder="메뉴에 대한 설명을 입력하세요">
                    </div>
                    <div class="mb-3">
                        <label for="menuBlade" class="form-label">블레이드 템플릿</label>
                        <input type="text" class="form-control" id="menuBlade" name="blade"
                               placeholder="예: layouts.navigation">
                        <div class="form-text">메뉴를 렌더링할 블레이드 템플릿 경로입니다.</div>
                    </div>
                    <div class="mb-3">
                        <label for="menuManager" class="form-label">관리자</label>
                        <input type="text" class="form-control" id="menuManager" name="manager"
                               placeholder="관리자 정보">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="menuEnable" name="enable" checked>
                        <label class="form-check-label" for="menuEnable">
                            메뉴 활성화
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">생성</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 메뉴 수정 모달 -->
<div class="modal fade" id="editMenuModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">메뉴 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editMenuForm">
                <input type="hidden" id="editMenuId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editMenuCode" class="form-label">메뉴 코드 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editMenuCode" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="editMenuDescription" class="form-label">설명</label>
                        <input type="text" class="form-control" id="editMenuDescription" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="editMenuBlade" class="form-label">블레이드 템플릿</label>
                        <input type="text" class="form-control" id="editMenuBlade" name="blade">
                    </div>
                    <div class="mb-3">
                        <label for="editMenuManager" class="form-label">관리자</label>
                        <input type="text" class="form-control" id="editMenuManager" name="manager">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editMenuEnable" name="enable">
                        <label class="form-check-label" for="editMenuEnable">
                            메뉴 활성화
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">수정</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
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
@endpush

@push('scripts')
<script>
// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    // 현재 정렬 상태 표시
    updateSortIndicators();

    // 정렬 가능한 헤더에 클릭 이벤트 추가
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.getAttribute('data-sort');
            const currentSortBy = getUrlParameter('sort_by') || 'created_at';
            const currentOrder = getUrlParameter('order') || 'desc';

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

// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.menu-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
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
    const currentSortBy = getUrlParameter('sort_by') || 'created_at';
    const currentOrder = getUrlParameter('order') || 'desc';

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

// 활성화/비활성화 토글
function toggleStatus(id, enabled) {
    fetch(`{{ route("admin.cms.menu.update", ":id") }}`.replace(':id', id), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ enable: enabled })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', '메뉴 상태가 업데이트되었습니다.');
        } else {
            showAlert('error', '상태 업데이트에 실패했습니다.');
        }
    })
    .catch(error => {
        showAlert('error', '오류가 발생했습니다.');
    });
}

// 메뉴 생성
document.getElementById('createMenuForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.enable = document.getElementById('menuEnable').checked;

    try {
        const response = await fetch('{{ route("admin.cms.menu.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showAlert('success', '메뉴가 성공적으로 생성되었습니다.');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', '메뉴 생성 중 오류가 발생했습니다.');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', '메뉴 생성 중 오류가 발생했습니다.');
    }
});

// 메뉴 수정
function editMenu(menuId, code, description, blade, manager, enable) {
    document.getElementById('editMenuId').value = menuId;
    document.getElementById('editMenuCode').value = code;
    document.getElementById('editMenuDescription').value = description || '';
    document.getElementById('editMenuBlade').value = blade || '';
    document.getElementById('editMenuManager').value = manager || '';
    document.getElementById('editMenuEnable').checked = enable;

    const editModal = new bootstrap.Modal(document.getElementById('editMenuModal'));
    editModal.show();
}

// 메뉴 수정 폼 제출
document.getElementById('editMenuForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const menuId = document.getElementById('editMenuId').value;
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.enable = document.getElementById('editMenuEnable').checked;

    try {
        const response = await fetch(`{{ route("admin.cms.menu.update", ":id") }}`.replace(':id', menuId), {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showAlert('success', '메뉴가 성공적으로 수정되었습니다.');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', '메뉴 수정 중 오류가 발생했습니다.');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', '메뉴 수정 중 오류가 발생했습니다.');
    }
});

// 메뉴 삭제
function deleteMenu(menuId) {
    if (!confirm('정말로 이 메뉴를 삭제하시겠습니까? 메뉴에 속한 모든 아이템도 함께 삭제됩니다.')) {
        return;
    }

    fetch(`{{ route("admin.cms.menu.delete", ":id") }}`.replace(':id', menuId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', '메뉴가 성공적으로 삭제되었습니다.');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', '메뉴 삭제 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', '메뉴 삭제 중 오류가 발생했습니다.');
    });
}

// 일괄 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.menu-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedIds.length}개 메뉴를 삭제하시겠습니까?`)) {
        return;
    }

    // 일괄 작업 API 호출 (실제로는 컨트롤러에 bulk 기능을 추가해야 함)
    const promises = selectedIds.map(id => {
        if (action === 'delete') {
            return fetch(`{{ route("admin.cms.menu.delete", ":id") }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } else if (action === 'enable' || action === 'disable') {
            return fetch(`{{ route("admin.cms.menu.update", ":id") }}`.replace(':id', id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ enable: action === 'enable' })
            });
        }
    });

    Promise.all(promises)
        .then(() => {
            showAlert('success', `선택된 ${selectedIds.length}개 메뉴에 대한 작업이 완료되었습니다.`);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showAlert('error', '일괄 작업 중 오류가 발생했습니다.');
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

    // 3초 후 자동 닫기
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
}
</script>
@endpush
