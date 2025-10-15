@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '조직 관리')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- 헤딩 영역 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-building me-2"></i>조직 관리
            </h2>
            <p class="text-muted mb-0">회사의 조직 구조와 팀을 관리합니다.</p>
        </div>
        <a href="{{ route('admin.cms.about.organization.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>새 조직 추가
        </a>
    </div>

    <!-- 통계 카드 -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-building text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">전체 조직</p>
                            <h3 class="mb-0 text-primary">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">활성화됨</p>
                            <h3 class="mb-0 text-success">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-house text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">최상위 조직</p>
                            <h3 class="mb-0 text-warning">{{ $stats['roots'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">팀원 보유</p>
                            <h3 class="mb-0 text-info">{{ $stats['with_members'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 검색 영역 -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.cms.about.organization.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label small text-muted">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search }}" placeholder="조직명, 코드 검색...">
                </div>
                <div class="col-md-2">
                    <label for="parent_id" class="form-label small text-muted">상태</label>
                    <select class="form-select" id="parent_id" name="parent_id">
                        <option value="">모든 상태</option>
                        <option value="null" {{ $parent_id === 'null' ? 'selected' : '' }}>최상위 조직</option>
                        @foreach($parentOptions as $option)
                            <option value="{{ $option['id'] }}"
                                    {{ $parent_id == $option['id'] ? 'selected' : '' }}>
                                {{ $option['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="level" class="form-label small text-muted">추천</label>
                    <select class="form-select" id="level" name="level">
                        <option value="">모든 조직</option>
                        @for($i = 0; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $level == $i ? 'selected' : '' }}>
                                Level {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">정렬</label>
                    <select class="form-select" name="sort_by">
                        <option value="created_at">생성일</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>이름</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label small text-muted">순서</label>
                    <select class="form-select" name="sort_direction">
                        <option value="desc">내림차순</option>
                        <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>오름차순</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">검색</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.cms.about.organization.index') }}" class="btn btn-outline-secondary w-100">초기화</a>
                </div>
            </form>
        </div>
    </div>

    <!-- 조직 목록 -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">조직 목록</h5>
                    <small class="text-muted">선택한 항목에 대해 일괄 작업을 수행할 수 있습니다.</small>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            일괄 작업 선택
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">선택 항목 활성화</a></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">선택 항목 비활성화</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">선택 항목 삭제</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm">실행</button>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm active" id="tableViewBtn">
                            <i class="bi bi-table me-1"></i>테이블 보기
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="treeViewBtn">
                            <i class="bi bi-diagram-3 me-1"></i>트리 보기
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

                    <!-- 트리 뷰 (기본 숨김) -->
                    <div id="tree-view" style="display: none;">
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>트리 뷰:</strong> 조직 구조를 계층적으로 표시합니다. 드래그 앤 드롭으로 정렬 순서를 변경할 수 있습니다.
                        </div>
                        <div class="tree-container" id="sortable-tree">
                            @include('jiny-site::admin.about.organization.partials.tree-node', ['organizations' => $rootOrganizations, 'level' => 0])
                        </div>
                    </div>

            <!-- 테이블 뷰 -->
            <div id="table-view">
                @if($organizations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>제목</th>
                                    <th style="width: 100px;">상태</th>
                                    <th style="width: 80px;">조회수</th>
                                    <th style="width: 80px;">북마크수</th>
                                    <th style="width: 80px;">추천</th>
                                    <th style="width: 120px;">작성자</th>
                                    <th style="width: 120px;">생성일</th>
                                    <th style="width: 100px;">작업</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($organizations as $organization)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input row-check" type="checkbox" value="{{ $organization->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($organization->level > 0)
                                                <span class="text-muted me-2">
                                                    {{ str_repeat('└ ', $organization->level) }}
                                                </span>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.cms.about.organization.edit', $organization->id) }}" class="text-decoration-none fw-medium">
                                                    {{ $organization->name }}
                                                </a>
                                                <div class="text-muted small">
                                                    <i class="bi bi-link-45deg"></i> /about
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($organization->is_active)
                                            <span class="badge bg-success">발행됨</span>
                                        @else
                                            <span class="badge bg-secondary">비활성</span>
                                        @endif
                                    </td>
                                    <td>{{ $organization->sort_order ?? 2 }}</td>
                                    <td>{{ $organization->level ?? 2 }}</td>
                                    <td>
                                        @if($organization->team_members_count > 0)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">-</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $organization->created_at ? $organization->created_at->format('Y-m-d H:i') : '2025-10-14 14:41' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-success btn-sm" title="팀원 관리">
                                                <i class="bi bi-people"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.about.organization.edit', $organization->id) }}" class="btn btn-outline-primary btn-sm" title="수정">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.about.organization.create', ['parent_id' => $organization->id]) }}"
                                               class="btn btn-outline-info btn-sm" title="하위 조직 추가">
                                                <i class="bi bi-plus"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                                    data-id="{{ $organization->id }}"
                                                    data-title="{{ $organization->name }}" title="삭제">
                                                <i class="bi bi-trash"></i>
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
                        <i class="bi bi-building fs-1 text-muted"></i>
                        <p class="text-muted mt-3">등록된 조직이 없습니다.</p>
                        <a href="{{ route('admin.cms.about.organization.create') }}" class="btn btn-primary">
                            첫 번째 조직 추가하기
                        </a>
                    </div>
                @endif
            </div>
                @if($organizations->hasPages())
                <div class="card-footer">
                    {{ $organizations->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">조직 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 조직을 삭제하시겠습니까?</p>
                <p class="text-danger"><strong id="deleteTitle"></strong></p>
                <p class="text-muted small">삭제된 데이터는 복구할 수 없습니다.</p>
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
document.addEventListener('DOMContentLoaded', function() {
    // CSRF 토큰 가져오기
    function getCSRFToken() {
        let token = document.querySelector('meta[name="csrf-token"]');
        if (!token) {
            token = document.querySelector('input[name="_token"]');
            return token ? token.value : '';
        }
        return token.content;
    }

    // 체크박스 전체 선택/해제
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-check');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.row-check:checked').length;
            const totalCount = rowCheckboxes.length;

            selectAllCheckbox.checked = checkedCount === totalCount;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        });
    });

    // 보기 모드 전환
    const tableViewBtn = document.getElementById('tableViewBtn');
    const treeViewBtn = document.getElementById('treeViewBtn');
    const tableView = document.getElementById('table-view');
    const treeView = document.getElementById('tree-view');

    if (tableViewBtn) {
        tableViewBtn.addEventListener('click', function() {
            tableView.style.display = 'block';
            treeView.style.display = 'none';
            tableViewBtn.classList.add('active');
            treeViewBtn.classList.remove('active');
        });
    }

    if (treeViewBtn) {
        treeViewBtn.addEventListener('click', function() {
            tableView.style.display = 'none';
            treeView.style.display = 'block';
            treeViewBtn.classList.add('active');
            tableViewBtn.classList.remove('active');
        });
    }

    // 성공 메시지 표시
    function showSuccessMessage(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alert, container.firstChild);
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 3000);
        }
    }

    // 오류 메시지 표시
    function showErrorMessage(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alert, container.firstChild);
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }
    }

    // 삭제 버튼
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const title = this.dataset.title;

            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('deleteForm').action = `/admin/cms/about/organization/${id}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

// 일괄 작업 함수
function bulkAction(action) {
    const checkedItems = document.querySelectorAll('.row-check:checked');

    if (checkedItems.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    let message = '';
    switch(action) {
        case 'activate':
            message = '선택한 항목들을 활성화하시겠습니까?';
            break;
        case 'deactivate':
            message = '선택한 항목들을 비활성화하시겠습니까?';
            break;
        case 'delete':
            message = '선택한 항목들을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.';
            break;
    }

    if (confirm(message)) {
        const ids = Array.from(checkedItems).map(item => item.value);
        console.log(`${action} action for items:`, ids);
        // 여기에 실제 일괄 작업 로직을 구현하세요
    }
}
</script>
@endpush
