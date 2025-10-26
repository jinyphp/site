@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '메뉴 트리 관리')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title mb-1">
                                <i class="fe fe-git-branch me-2"></i>
                                {{ $menu->menu_code }} 트리 관리
                            </h1>
                            <p class="page-header-subtitle">{{ $menu->description ?: '드래그 앤 드롭으로 메뉴 구조를 관리하세요' }}</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editMenuInfoModal">
                                <i class="fe fe-settings me-1"></i>메뉴 정보 수정
                            </button>
                            <a href="{{ route('admin.cms.menu.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-1"></i>목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <i class="fe fe-check alert-icon"></i>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">총 아이템</h4>
                            <h2 class="text-primary mb-0">{{ $menuStats['total_items'] }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-list"></i>
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
                            <h4 class="card-title mb-1">최대 깊이</h4>
                            <h2 class="text-success mb-0">{{ $menuStats['max_depth'] + 1 }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-layers"></i>
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
                            <h4 class="card-title mb-1">최상위 메뉴</h4>
                            <h2 class="text-info mb-0">{{ $menuStats['top_level_items'] }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-folder"></i>
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
                            <h4 class="card-title mb-1">하위 보유</h4>
                            <h2 class="text-warning mb-0">{{ $menuStats['items_with_children'] }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-git-branch"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 메뉴 트리 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-header-title">
                                <i class="fe fe-git-branch me-2"></i>메뉴 트리 구조
                            </h4>
                            <p class="text-muted mb-0 small">드래그 앤 드롭으로 메뉴 순서와 계층을 변경할 수 있습니다.</p>
                        </div>
                        <div class="btn-list">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="expandAll()">
                                <i class="fe fe-chevrons-down me-1"></i>모두 펼치기
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="collapseAll()">
                                <i class="fe fe-chevrons-up me-1"></i>모두 접기
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($menuData) > 0)
                        <div id="menuTree" class="menu-tree">
                            <!-- 메뉴 트리가 JavaScript로 동적 생성됩니다 -->
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-git-branch text-muted" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-muted">메뉴 아이템이 없습니다</h5>
                            <p class="text-muted">첫 번째 메뉴 아이템을 추가하여 트리 구조를 만들어보세요.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                <i class="fe fe-plus me-2"></i>첫 번째 아이템 추가
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-footer border-top">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            <i class="fe fe-plus me-2"></i>아이템 추가
                        </button>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="refreshTree()">
                                <i class="fe fe-refresh-cw me-2"></i>새로고침
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="saveStructure()">
                                <i class="fe fe-save me-2"></i>구조 저장
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 아이템 추가 모달 -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-plus me-2"></i>메뉴 아이템 추가
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addItemForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_title" class="form-label">제목 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="item_title" name="title" required
                               placeholder="메뉴 제목을 입력하세요">
                    </div>
                    <div class="mb-3">
                        <label for="item_href" class="form-label">링크</label>
                        <input type="text" class="form-control" id="item_href" name="href"
                               placeholder="예: /about, https://example.com">
                    </div>
                    <div class="mb-3">
                        <label for="item_icon" class="form-label">아이콘</label>
                        <input type="text" class="form-control" id="item_icon" name="icon"
                               placeholder="예: fe fe-home, ti ti-home">
                        <div class="form-hint">Feather Icons 또는 Tabler Icons 클래스명</div>
                    </div>
                    <div class="mb-3">
                        <label for="item_target" class="form-label">타겟</label>
                        <select class="form-select" id="item_target" name="target">
                            <option value="_self">현재 창 (_self)</option>
                            <option value="_blank">새 창 (_blank)</option>
                            <option value="_parent">부모 창 (_parent)</option>
                            <option value="_top">최상위 창 (_top)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="item_parent" class="form-label">부모 메뉴</label>
                        <select class="form-select" id="item_parent" name="parent_id">
                            <option value="">최상위 메뉴</option>
                            <!-- 부모 옵션들이 JavaScript로 동적 생성됩니다 -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-plus me-1"></i>추가
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 아이템 수정 모달 -->
<div class="modal fade" id="editItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-edit me-2"></i>메뉴 아이템 수정
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editItemForm">
                <input type="hidden" id="edit_item_id" name="item_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_item_title" class="form-label">제목 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_item_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_item_href" class="form-label">링크</label>
                        <input type="text" class="form-control" id="edit_item_href" name="href">
                    </div>
                    <div class="mb-3">
                        <label for="edit_item_icon" class="form-label">아이콘</label>
                        <input type="text" class="form-control" id="edit_item_icon" name="icon">
                        <div class="form-hint">Feather Icons 또는 Tabler Icons 클래스명</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_item_target" class="form-label">타겟</label>
                        <select class="form-select" id="edit_item_target" name="target">
                            <option value="_self">현재 창 (_self)</option>
                            <option value="_blank">새 창 (_blank)</option>
                            <option value="_parent">부모 창 (_parent)</option>
                            <option value="_top">최상위 창 (_top)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i>수정
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-trash-2 me-2 text-danger"></i>메뉴 아이템 삭제
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex">
                        <div>
                            <i class="fe fe-alert-triangle alert-icon"></i>
                        </div>
                        <div>
                            <h4 class="alert-title">정말로 삭제하시겠습니까?</h4>
                            <div class="text-muted">
                                <span id="deleteItemTitle"></span>을(를) 삭제합니다.<br>
                                하위 메뉴가 있다면 함께 삭제됩니다. 이 작업은 되돌릴 수 없습니다.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fe fe-trash-2 me-1"></i>삭제
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 메뉴 정보 수정 모달 -->
<div class="modal fade" id="editMenuInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-settings me-2"></i>메뉴 정보 수정
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editMenuInfoForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menu_code" class="form-label">메뉴 코드 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="menu_code" name="menu_code" value="{{ $menu->menu_code }}" required>
                        <div class="form-text">메뉴를 식별하는 고유 코드입니다.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">설명</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="메뉴에 대한 설명을 입력하세요">{{ $menu->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="blade" class="form-label">블레이드 템플릿</label>
                        <input type="text" class="form-control" id="blade" name="blade" value="{{ $menu->blade }}" placeholder="예: menu.navigation">
                        <div class="form-text">메뉴 렌더링에 사용할 블레이드 템플릿을 지정합니다.</div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="enable" name="enable" {{ $menu->enable ? 'checked' : '' }}>
                        <label class="form-check-label" for="enable">
                            활성화
                        </label>
                        <div class="form-text">비활성화하면 메뉴가 표시되지 않습니다.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i>저장
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.menu-tree {
    min-height: 400px;
    position: relative;
}

.menu-item {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin: 0.5rem 0;
    position: relative;
    cursor: move;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.menu-item:hover {
    border-color: #6366f1;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
    transform: translateY(-1px);
}

.menu-item.dragging {
    opacity: 0.7;
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
}

.menu-item-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.menu-item-title-original {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
}

.menu-item-icon {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    color: #6366f1;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.menu-item-href {
    font-size: 0.8rem;
    color: #6b7280;
    margin-left: 28px;
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    background: #f3f4f6;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    display: inline-block;
    border: 1px solid #e5e7eb;
}

.menu-item-actions {
    display: flex;
    gap: 4px;
    opacity: 0.6;
    transition: opacity 0.2s ease;
}

.menu-item:hover .menu-item-actions {
    opacity: 1;
}

.menu-item-children {
    margin-left: 24px;
    margin-top: 0.75rem;
    border-left: 2px solid #e5e7eb;
    padding-left: 1rem;
    position: relative;
}

.menu-item-children::before {
    content: '';
    position: absolute;
    left: -2px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, #6366f1 0%, #e5e7eb 100%);
}

.sortable-placeholder {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
    border: 2px dashed #6366f1;
    border-radius: 8px;
    height: 60px;
    margin: 0.5rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6366f1;
    font-weight: 500;
    font-size: 0.875rem;
}

.sortable-placeholder::before {
    content: '여기에 드롭하세요';
}

.btn-action {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 4px;
    min-width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e5e7eb;
}

.btn-action i {
    font-size: 12px;
}

.btn-action:hover {
    border-color: currentColor;
}

/* 트리 레벨별 들여쓰기 스타일 */
.menu-items-container[data-level="0"] .menu-item {
    border-left: 4px solid #6366f1;
}

.menu-items-container[data-level="1"] .menu-item {
    border-left: 4px solid #10b981;
}

.menu-items-container[data-level="2"] .menu-item {
    border-left: 4px solid #f59e0b;
}

.menu-items-container[data-level="3"] .menu-item {
    border-left: 4px solid #ef4444;
}

/* 빈 상태 스타일 */
.empty-tree {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
}

.empty-tree i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* 드롭다운 토글 버튼 스타일 */
.toggle-children {
    background: transparent;
    border: none;
    color: #6b7280;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 12px;
    margin-right: 8px;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.toggle-children:hover {
    background: #f3f4f6;
    color: #374151;
}

.toggle-children.collapsed {
    transform: rotate(-90deg);
}

.menu-item-children.collapsed {
    display: none !important;
}

.menu-item-title {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
    flex: 1;
}

/* 토스트 메시지 스타일 */
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 9999;
}

.toast {
    border: none;
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

.toast-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.toast-error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const menuId = {{ $menu->id }};
let menuData = @json($menuData);
let sortableInstances = [];

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    renderMenuTree();
    updateParentOptions();
});

// 메뉴 트리 렌더링
function renderMenuTree() {
    const container = document.getElementById('menuTree');
    if (!container) return;

    container.innerHTML = '';

    if (menuData.length === 0) {
        container.innerHTML = `
            <div class="empty-tree">
                <i class="fe fe-git-branch"></i>
                <h6 class="mt-3 text-muted">메뉴 아이템이 없습니다</h6>
                <p class="text-muted mb-3">첫 번째 아이템을 추가해보세요.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <i class="fe fe-plus me-2"></i>아이템 추가
                </button>
            </div>
        `;
        return;
    }

    // Sortable 인스턴스 정리
    sortableInstances.forEach(instance => instance.destroy());
    sortableInstances = [];

    const treeHtml = renderMenuItems(menuData);
    container.innerHTML = treeHtml;

    // Sortable 초기화
    initializeSortable(container);
}

// 메뉴 아이템들 렌더링 (재귀)
function renderMenuItems(items, level = 0) {
    let html = `<div class="menu-items-container" data-level="${level}">`;

    items.forEach(item => {
        html += `
            <div class="menu-item" data-id="${item.id}">
                <div class="menu-item-header">
                    <div class="menu-item-title">
                        ${item.children && item.children.length > 0 ? `<button class="toggle-children collapsed" onclick="toggleChildren('${item.id}')"><i class="fe fe-chevron-down"></i></button>` : ''}
                        ${item.icon ? `<i class="${item.icon} menu-item-icon"></i>` : '<i class="fe fe-menu menu-item-icon"></i>'}
                        <span>${item.title}</span>
                        ${item.target === '_blank' ? '<i class="fe fe-external-link ms-2 text-muted"></i>' : ''}
                    </div>
                    <div class="menu-item-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary btn-action" onclick="addSubItem('${item.id}')" title="하위 메뉴 추가">
                            <i class="fe fe-plus"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-action" onclick="editItem('${item.id}')" title="수정">
                            <i class="fe fe-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-action" onclick="confirmDeleteItem('${item.id}', '${item.title.replace(/'/g, "\\'")}')" title="삭제">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </div>
                </div>
                ${item.href && item.href !== '#' ? `<div class="menu-item-href">${item.href}</div>` : ''}
                ${item.children && item.children.length > 0 ? `
                    <div class="menu-item-children collapsed" data-parent-id="${item.id}">
                        ${renderMenuItems(item.children, level + 1)}
                    </div>
                ` : ''}
            </div>
        `;
    });

    html += '</div>';
    return html;
}

// Sortable 초기화
function initializeSortable(container) {
    const containers = container.querySelectorAll('.menu-items-container');

    containers.forEach(container => {
        const sortable = Sortable.create(container, {
            group: 'menu-items',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            dragClass: 'dragging',
            ghostClass: 'sortable-placeholder',
            onEnd: function(evt) {
                updateMenuDataFromDOM();
            }
        });
        sortableInstances.push(sortable);
    });
}

// DOM에서 메뉴 데이터 업데이트
function updateMenuDataFromDOM() {
    const treeContainer = document.getElementById('menuTree');
    menuData = extractMenuData(treeContainer.querySelector('.menu-items-container'));
}

// DOM에서 메뉴 데이터 추출 (재귀)
function extractMenuData(container) {
    const items = [];
    const menuItems = container.children;

    for (let i = 0; i < menuItems.length; i++) {
        const menuItem = menuItems[i];
        const itemId = menuItem.dataset.id;
        const originalItem = findItemById(menuData, itemId);

        if (originalItem) {
            const newItem = { ...originalItem };
            const childrenContainer = menuItem.querySelector('.menu-item-children .menu-items-container');

            if (childrenContainer) {
                newItem.children = extractMenuData(childrenContainer);
            } else {
                newItem.children = [];
            }

            items.push(newItem);
        }
    }

    return items;
}

// ID로 아이템 찾기 (재귀)
function findItemById(items, id) {
    for (const item of items) {
        if (item.id === id) {
            return item;
        }
        if (item.children) {
            const found = findItemById(item.children, id);
            if (found) return found;
        }
    }
    return null;
}

// 부모 옵션 업데이트
function updateParentOptions() {
    const select = document.getElementById('item_parent');
    select.innerHTML = '<option value="">최상위 메뉴</option>';

    function addOptions(items, prefix = '') {
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = prefix + item.title;
            select.appendChild(option);

            if (item.children && item.children.length > 0) {
                addOptions(item.children, prefix + '  ');
            }
        });
    }

    addOptions(menuData);
}

// 하위 아이템 추가
function addSubItem(parentId) {
    document.getElementById('item_parent').value = parentId;
    new bootstrap.Modal(document.getElementById('addItemModal')).show();
}

// 아이템 수정
function editItem(itemId) {
    const item = findItemById(menuData, itemId);
    if (!item) return;

    document.getElementById('edit_item_id').value = itemId;
    document.getElementById('edit_item_title').value = item.title;
    document.getElementById('edit_item_href').value = item.href || '';
    document.getElementById('edit_item_icon').value = item.icon || '';
    document.getElementById('edit_item_target').value = item.target || '_self';

    new bootstrap.Modal(document.getElementById('editItemModal')).show();
}

// 삭제 확인 모달 표시
function confirmDeleteItem(itemId, itemTitle) {
    document.getElementById('deleteItemTitle').textContent = itemTitle;
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deleteItem(itemId);
    };
    new bootstrap.Modal(document.getElementById('deleteItemModal')).show();
}

// 아이템 삭제
function deleteItem(itemId) {
    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteItemModal'));
    modal.hide();

    showToast('삭제 중...', 'info');

    fetch(`{{ route("admin.cms.menu.tree.items.destroy", [":menuId", ":itemId"]) }}`.replace(':menuId', menuId).replace(':itemId', itemId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('메뉴 아이템이 삭제되었습니다.', 'success');
            refreshTree();
        } else {
            showToast('삭제 실패: ' + (data.message || '아이템 삭제에 실패했습니다.'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('서버 오류가 발생했습니다.', 'error');
    });
}

// 구조 저장
function saveStructure() {
    showToast('구조 저장 중...', 'info');

    fetch(`{{ route("admin.cms.menu.tree.structure.update", ":id") }}`.replace(':id', menuId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ menu_data: menuData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('메뉴 구조가 저장되었습니다.', 'success');
        } else {
            showToast('저장 실패: ' + (data.message || '구조 저장에 실패했습니다.'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('서버 오류가 발생했습니다.', 'error');
    });
}

// 트리 새로고침
// 펼쳐진 메뉴 상태 저장
function saveExpandedState() {
    const expandedItems = [];
    document.querySelectorAll('.menu-item-children:not(.collapsed)').forEach(el => {
        const parentId = el.getAttribute('data-parent-id');
        if (parentId) {
            expandedItems.push(parentId);
        }
    });
    return expandedItems;
}

// 펼쳐진 메뉴 상태 복원
function restoreExpandedState(expandedItems) {
    if (!expandedItems || expandedItems.length === 0) return;

    expandedItems.forEach(itemId => {
        const childrenContainer = document.querySelector(`.menu-item-children[data-parent-id="${itemId}"]`);
        const toggleButton = document.querySelector(`[onclick="toggleChildren('${itemId}')"]`);

        if (childrenContainer && toggleButton) {
            childrenContainer.classList.remove('collapsed');
            toggleButton.classList.remove('collapsed');
        }
    });
}

function refreshTree(preserveExpandedState = true) {
    // 현재 펼쳐진 상태 저장
    const expandedState = preserveExpandedState ? saveExpandedState() : [];

    fetch(`{{ route("admin.cms.menu.tree.data", ":id") }}`.replace(':id', menuId))
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            menuData = data.menu_data;
            renderMenuTree();
            updateParentOptions();

            // 펼쳐진 상태 복원
            if (preserveExpandedState) {
                setTimeout(() => {
                    restoreExpandedState(expandedState);
                }, 100); // DOM 렌더링 완료 후 실행
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// 하위메뉴 토글 함수
function toggleChildren(itemId) {
    const childrenContainer = document.querySelector(`.menu-item-children[data-parent-id="${itemId}"]`);
    const toggleButton = document.querySelector(`[onclick="toggleChildren('${itemId}')"]`);

    if (childrenContainer && toggleButton) {
        childrenContainer.classList.toggle('collapsed');
        toggleButton.classList.toggle('collapsed');
    }
}

// 모두 펼치기/접기
function expandAll() {
    document.querySelectorAll('.menu-item-children').forEach(el => {
        el.classList.remove('collapsed');
    });
    document.querySelectorAll('.toggle-children').forEach(el => {
        el.classList.remove('collapsed');
    });
}

function collapseAll() {
    document.querySelectorAll('.menu-item-children').forEach(el => {
        el.classList.add('collapsed');
    });
    document.querySelectorAll('.toggle-children').forEach(el => {
        el.classList.add('collapsed');
    });
}

// 토스트 메시지 시스템
function showToast(message, type = 'info') {
    // 토스트 컨테이너가 없으면 생성
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }

    // 토스트 요소 생성
    const toastId = 'toast_' + Date.now();
    const toastHtml = `
        <div class="toast toast-${type}" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center">
                <i class="fe fe-${getToastIcon(type)} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHtml);

    // Bootstrap 토스트 초기화 및 표시
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: type === 'error' ? 5000 : 3000
    });

    toast.show();

    // 토스트가 숨겨진 후 요소 제거
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}

function getToastIcon(type) {
    switch(type) {
        case 'success': return 'check-circle';
        case 'error': return 'alert-circle';
        case 'warning': return 'alert-triangle';
        case 'info':
        default: return 'info';
    }
}

// 폼 제출 개선
document.getElementById('addItemForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // 제출 버튼 비활성화
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fe fe-loader me-1"></i>추가 중...';
    submitBtn.disabled = true;

    fetch(`{{ route("admin.cms.menu.tree.items.store", ":id") }}`.replace(':id', menuId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('메뉴 아이템이 추가되었습니다.', 'success');

            // 부모 ID가 있는 경우 해당 부모를 펼쳐진 상태로 추가
            const parentId = formData.get('parent_id');
            const currentExpanded = saveExpandedState();
            if (parentId && !currentExpanded.includes(parentId)) {
                currentExpanded.push(parentId);
            }

            refreshTree();

            // 추가된 아이템의 부모가 펼쳐지도록 추가 상태 복원
            if (parentId) {
                setTimeout(() => {
                    const childrenContainer = document.querySelector(`.menu-item-children[data-parent-id="${parentId}"]`);
                    const toggleButton = document.querySelector(`[onclick="toggleChildren('${parentId}')"]`);

                    if (childrenContainer && toggleButton) {
                        childrenContainer.classList.remove('collapsed');
                        toggleButton.classList.remove('collapsed');
                    }
                }, 150);
            }

            bootstrap.Modal.getInstance(document.getElementById('addItemModal')).hide();
            document.getElementById('addItemForm').reset();
        } else {
            showToast('추가 실패: ' + (data.message || '아이템 추가에 실패했습니다.'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('서버 오류가 발생했습니다.', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// 수정 폼 제출 개선
document.getElementById('editItemForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    const itemId = data.item_id;
    delete data.item_id;

    console.log('Updating menu item:', {
        menuId: menuId,
        itemId: itemId,
        data: data
    });

    // 제출 버튼 비활성화
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fe fe-loader me-1"></i>수정 중...';
    submitBtn.disabled = true;

    fetch(`{{ route("admin.cms.menu.tree.items.update", [":menuId", ":itemId"]) }}`.replace(':menuId', menuId).replace(':itemId', itemId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('메뉴 아이템이 수정되었습니다.', 'success');
            refreshTree();
            bootstrap.Modal.getInstance(document.getElementById('editItemModal')).hide();
        } else {
            let errorMessage = '수정 실패: ' + (data.message || '아이템 수정에 실패했습니다.');
            if (data.debug) {
                errorMessage += ' (Debug: ' + data.debug + ')';
                console.error('Debug info:', data.debug);
            }
            if (data.errors) {
                console.error('Validation errors:', data.errors);
                errorMessage += ' 유효성 검사 오류를 확인하세요.';
            }
            showToast(errorMessage, 'error');
        }
    })
    .catch(error => {
        console.error('Menu update error:', error);
        showToast('서버 오류: ' + error.message, 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// 메뉴 정보 수정 폼 제출
document.getElementById('editMenuInfoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // 체크박스 처리
    data.enable = document.getElementById('enable').checked;

    // 제출 버튼 비활성화
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fe fe-loader me-1"></i>저장 중...';
    submitBtn.disabled = true;

    console.log('Updating menu info:', data);

    fetch(`{{ route("admin.cms.menu.update", ":id") }}`.replace(':id', menuId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('메뉴 정보가 수정되었습니다.', 'success');

            // 페이지 제목과 설명 업데이트
            if (data.menu) {
                document.querySelector('.page-header-title').innerHTML =
                    '<i class="fe fe-git-branch me-2"></i>' + data.menu.menu_code + ' 트리 관리';
                document.querySelector('.page-header-subtitle').textContent =
                    data.menu.description || '드래그 앤 드롭으로 메뉴 구조를 관리하세요';
            }

            bootstrap.Modal.getInstance(document.getElementById('editMenuInfoModal')).hide();
        } else {
            let errorMessage = '수정 실패: ' + (data.message || '메뉴 정보 수정에 실패했습니다.');
            if (data.debug) {
                errorMessage += ' (Debug: ' + data.debug + ')';
                console.error('Debug info:', data.debug);
            }
            if (data.errors) {
                console.error('Validation errors:', data.errors);
                errorMessage += ' 유효성 검사 오류를 확인하세요.';
            }
            showToast(errorMessage, 'error');
        }
    })
    .catch(error => {
        console.error('Menu info update error:', error);
        showToast('서버 오류: ' + error.message, 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endpush
