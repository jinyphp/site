@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '메뉴 아이템 관리')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-2">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.dashboard') }}">CMS</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.menu.index') }}">메뉴 관리</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $menu->code }}</li>
                                </ol>
                            </nav>
                            <h1 class="page-header-title">
                                <i class="fe fe-menu me-2"></i>
                                {{ $menu->code }} 메뉴 아이템 관리
                            </h1>
                            <p class="page-header-subtitle">{{ $menu->description ?: '메뉴 아이템의 구조를 드래그 앤 드롭으로 관리하세요' }}</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="demoMenuDrag()" title="드래그 앤 드롭 사용법 데모">
                                <i class="fe fe-play me-1"></i>데모
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm me-2" onclick="forceSortableInit()" title="드래그 앤 드롭 재초기화">
                                <i class="fe fe-refresh-cw me-1"></i>초기화
                            </button>
                            <a href="{{ route('admin.cms.menu.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fe fe-arrow-left me-2"></i>메뉴 목록으로
                            </a>
                            <button type="button" class="btn btn-success" onclick="saveMenuStructure()" id="saveBtn">
                                <i class="fe fe-save me-2"></i>변경사항 저장
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
                            <h4 class="card-title mb-1">전체 아이템</h4>
                            <h2 class="text-primary mb-0" id="totalItemsCount">{{ $menuItems->count() }}</h2>
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
                            <h4 class="card-title mb-1">활성 아이템</h4>
                            <h2 class="text-success mb-0" id="activeItemsCount">{{ $menuItems->where('enable', true)->count() }}</h2>
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
                            <h4 class="card-title mb-1">하위 아이템</h4>
                            <h2 class="text-info mb-0">{{ $menuItems->where('ref', '!=', 0)->count() }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-git-branch"></i>
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
                            <h4 class="card-title mb-1">최대 레벨</h4>
                            <h2 class="text-warning mb-0">{{ $menuItems->max('level') + 1 }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-layers"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 메뉴 정보 및 아이템 관리 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="form-check me-3">
                            <input type="checkbox" id="selectAllItems" class="form-check-input">
                            <label class="form-check-label" for="selectAllItems">
                                <span class="visually-hidden">전체 선택</span>
                            </label>
                        </div>
                        <div>
                            <h4 class="card-title mb-0">메뉴 구조</h4>
                            <small class="text-muted">드래그 앤 드롭으로 아이템의 순서와 계층을 변경할 수 있습니다</small>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-info btn-sm me-2" onclick="expandAll()">
                            <i class="fe fe-maximize-2 me-1"></i>모두 펼치기
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="collapseAll()">
                            <i class="fe fe-minimize-2 me-1"></i>모두 접기
                        </button>
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
                <div class="card-body">
                    <!-- 알림 메시지 영역 -->
                    <div id="alertContainer" class="mb-3" style="display: none;"></div>

                    @if($menuItems->isEmpty())
                        <div class="text-center py-5">
                            <i class="fe fe-list fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">메뉴 아이템이 없습니다</h5>
                            <p class="text-muted mb-3">새 아이템을 추가하여 메뉴 구조를 만들어보세요.</p>
                            <button type="button" class="btn btn-primary" onclick="createMenuItem()">
                                <i class="fe fe-plus me-2"></i>새 아이템 추가
                            </button>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <div class="alert alert-info border-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fe fe-info text-info me-2"></i>
                                            <div>
                                                <strong>사용 방법:</strong>
                                                <span class="me-3">🖱️ 드래그하여 순서 변경</span>
                                                <span class="me-3">📂 다른 폴더로 이동</span>
                                                <span>💾 변경 후 저장 필수</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="menuTree" class="menu-tree">
                                    @include('jiny-site::admin.menu.partials.tree-item', ['items' => $menuItems])
                                </div>

                                <!-- 루트 메뉴 추가 버튼 -->
                                <div class="mt-3 text-center">
                                    <button type="button" class="btn btn-primary" onclick="createMenuItem()">
                                        <i class="fe fe-plus me-2"></i>새 루트 아이템 추가
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fe fe-info me-2"></i>메뉴 정보
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label text-muted">메뉴 코드</label>
                                                <div class="fw-bold">{{ $menu->code }}</div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted">설명</label>
                                                <div>{{ $menu->description ?: '-' }}</div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted">블레이드 템플릿</label>
                                                <div><code class="text-info">{{ $menu->blade ?: '-' }}</code></div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label text-muted">상태</label>
                                                <div>
                                                    @if($menu->enable)
                                                        <span class="badge bg-success">
                                                            <i class="fe fe-check-circle me-1"></i>활성
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="fe fe-x-circle me-1"></i>비활성
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($menu->manager)
                                            <div class="col-12">
                                                <label class="form-label text-muted">관리자</label>
                                                <div>{{ $menu->manager }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fe fe-bar-chart-2 me-2"></i>통계 상세
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3 text-center">
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h4 class="mb-1 text-primary" id="totalItems">{{ $menuItems->count() }}</h4>
                                                    <p class="text-muted mb-0 small">총 아이템</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="mb-1 text-success" id="activeItems">
                                                    {{ $menuItems->where('enable', true)->count() }}
                                                </h4>
                                                <p class="text-muted mb-0 small">활성 아이템</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="border-end">
                                                    <h4 class="mb-1 text-info">{{ $menuItems->where('ref', 0)->count() }}</h4>
                                                    <p class="text-muted mb-0 small">루트 아이템</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <h4 class="mb-1 text-warning">{{ $menuItems->whereNotNull('href')->count() }}</h4>
                                                <p class="text-muted mb-0 small">링크 있음</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fe fe-zap me-2"></i>빠른 액션
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center text-muted">
                                            <i class="fe fe-info me-2"></i>
                                            트리 상단의 버튼들을 사용하여<br>
                                            메뉴를 관리하세요
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- 메뉴 아이템 생성/수정 모달 -->
<div class="modal fade" id="menuItemModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuItemModalTitle">메뉴 아이템 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="menuItemForm">
                @csrf
                <input type="hidden" id="itemId">
                <input type="hidden" id="menuId" value="{{ $menu->id }}">
                <input type="hidden" id="parentId" value="0">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemTitle" class="form-label">제목 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="itemTitle" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemName" class="form-label">이름</label>
                                <input type="text" class="form-control" id="itemName" name="name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemHref" class="form-label">링크 URL</label>
                                <input type="text" class="form-control" id="itemHref" name="href"
                                       placeholder="예: /about, https://example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemTarget" class="form-label">링크 타겟</label>
                                <select class="form-select" id="itemTarget" name="target">
                                    <option value="">기본 (_self)</option>
                                    <option value="_blank">새 창 (_blank)</option>
                                    <option value="_parent">부모 프레임 (_parent)</option>
                                    <option value="_top">최상위 프레임 (_top)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemIcon" class="form-label">아이콘</label>
                                <input type="text" class="form-control" id="itemIcon" name="icon"
                                       placeholder="예: fe fe-home, fe fe-star">
                                <div class="form-text">Feather Icons 클래스</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="itemCode" class="form-label">코드</label>
                                <input type="text" class="form-control" id="itemCode" name="code"
                                       placeholder="식별용 코드 (선택사항)">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="itemDescription" class="form-label">설명</label>
                        <textarea class="form-control" id="itemDescription" name="description" rows="2"
                                  placeholder="메뉴 아이템에 대한 설명"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="itemEnable" name="enable" checked>
                                <label class="form-check-label" for="itemEnable">
                                    아이템 활성화
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="itemSubmenu" name="submenu">
                                <label class="form-check-label" for="itemSubmenu">
                                    서브메뉴 포함
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">저장</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.menu-tree {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    background-color: #f8f9fa;
}

.menu-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    margin: 0.5rem 0;
    padding: 0.75rem;
    cursor: move;
    transition: all 0.2s ease;
}

.menu-item:hover {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.menu-item.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.menu-item .item-header {
    display: flex;
    justify-content: between;
    align-items: center;
}

.menu-item .item-info {
    flex: 1;
}

.menu-item .item-actions {
    display: flex;
    gap: 0.25rem;
}

.menu-children {
    margin-left: 2rem;
    border-left: 2px solid #dee2e6;
    padding-left: 1rem;
    margin-top: 0.5rem;
}

.drag-handle {
    cursor: grab;
    color: #6c757d;
    margin-right: 0.5rem;
}

.drag-handle:hover {
    color: #007bff;
}

.drop-zone {
    min-height: 2rem;
    border: 2px dashed #007bff;
    border-radius: 0.375rem;
    background-color: rgba(0, 123, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 0.875rem;
    margin: 0.25rem 0;
}

.drop-zone.drag-over {
    background-color: rgba(0, 123, 255, 0.2);
    border-color: #0056b3;
}
</style>
@endpush

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

.menu-tree {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    background-color: #f8f9fa;
    min-height: 200px;
}

.menu-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    margin: 0.5rem 0;
    padding: 0.75rem;
    cursor: move;
    transition: all 0.2s ease;
    position: relative;
    z-index: 2;
}

.menu-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-color: #007bff;
    transform: translateY(-1px);
}

.menu-item.dragging {
    opacity: 0.5;
    transform: rotate(3deg);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

/* 새로운 간단한 드래그 시스템 스타일 */

/* 드래그 중인 아이템 - 원본 위치에 그대로 있음 */
.being-dragged {
    opacity: 0.8;
    outline: 3px solid #2196f3;
    outline-offset: 2px;
    background-color: rgba(33, 150, 243, 0.1);
    z-index: 1000;
}

/* 드래그 고스트 */
.drag-ghost {
    opacity: 0.4;
    background: #e3f2fd;
    border: 2px dashed #2196f3;
}

/* 드래그 선택된 아이템 */
.drag-chosen {
    outline: 2px solid #2196f3;
    outline-offset: 2px;
}

/* 들여쓰기 미리보기 애니메이션 */
.indent-preview {
    transform: translateX(20px);
    transition: transform 0.3s ease;
    background-color: rgba(33, 150, 243, 0.1);
    border-left: 4px solid #2196f3;
}

/* 하위 드롭 존 녹색 활성화 */
.child-drop-active {
    background-color: rgba(76, 175, 80, 0.15) !important;
    border: 3px dashed #4caf50 !important;
    border-radius: 8px !important;
    animation: childDropPulse 1.5s infinite;
    position: relative;
}

.child-drop-active::before {
    content: '↓ 여기에 하위 아이템으로 드롭';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #4caf50;
    font-weight: 600;
    font-size: 0.9rem;
    background: rgba(255, 255, 255, 0.9);
    padding: 0.5rem 1rem;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    pointer-events: none;
    z-index: 10;
}

@keyframes childDropPulse {
    0%, 100% {
        background-color: rgba(76, 175, 80, 0.15);
        transform: scale(1);
    }
    50% {
        background-color: rgba(76, 175, 80, 0.25);
        transform: scale(1.02);
    }
}

.menu-item .item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    min-height: 50px;
}

.menu-item .item-left {
    flex: 1;
    display: flex;
    align-items: center;
}

.menu-item .item-content {
    flex: 1;
}

.menu-item .item-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
}

.menu-children {
    margin-left: 2rem;
    border-left: 3px solid #e3f2fd;
    padding-left: 1rem;
    margin-top: 0.5rem;
    position: relative;
    min-height: 10px;
    transition: all 0.2s ease;
    z-index: 4;
}

.menu-children::before {
    content: '';
    position: absolute;
    left: -3px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #007bff, #e3f2fd);
}

/* 드래그 중 하위 컨테이너 표시 */
body.dragging .menu-children {
    border-left-color: #4caf50;
    background-color: rgba(76, 175, 80, 0.05);
}

body.dragging .menu-children::before {
    background: linear-gradient(to bottom, #4caf50, #e8f5e8);
}

/* 빈 드롭 존 - 단순화 */
.empty-drop-zone {
    padding: 1rem;
    text-align: center;
    color: #6c757d;
    font-size: 0.875rem;
    border: 2px dashed #dee2e6;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
    margin: 0.5rem 0;
    transition: all 0.3s ease;
}

/* 드래그 중 빈 드롭 존 활성화 */
body.dragging .empty-drop-zone {
    border-color: #4caf50;
    background-color: rgba(76, 175, 80, 0.1);
    color: #4caf50;
    transform: scale(1.02);
}

.drag-handle {
    cursor: grab !important;
    color: #6c757d;
    padding: 0.5rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    width: 30px;
    height: 30px;
}

.drag-handle:hover {
    color: #007bff !important;
    background-color: #e3f2fd !important;
    border-color: #007bff !important;
    transform: scale(1.05);
}

.drag-handle:active {
    cursor: grabbing !important;
    background-color: #bbdefb !important;
}

.menu-item.dragging {
    opacity: 0.8;
    transform: rotate(2deg);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    z-index: 9999;
}

/* 드래그 핸들 호버 효과 */
.menu-item:hover .drag-handle {
    opacity: 1;
    transform: scale(1.1);
}

.drop-zone {
    min-height: 3rem;
    border: 2px dashed #007bff;
    border-radius: 0.375rem;
    background-color: rgba(0, 123, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #007bff;
    font-size: 0.875rem;
    margin: 0.25rem 0;
    transition: all 0.2s ease;
}

.drop-zone.drag-over {
    background-color: rgba(0, 123, 255, 0.2);
    border-color: #0056b3;
    border-style: solid;
}

.menu-item-checkbox {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.collapsed .menu-children {
    display: none;
}

.expand-toggle {
    cursor: pointer;
    margin-left: 0.5rem;
    color: #6c757d;
    transition: transform 0.2s ease;
}

.expand-toggle:hover {
    color: #007bff;
}

.collapsed .expand-toggle {
    transform: rotate(-90deg);
}

/* 통계 카드 애니메이션 */
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* 간단한 테스트 도구 */
.test-mode::before {
    content: '🧪 테스트 모드';
    position: fixed;
    top: 10px;
    right: 10px;
    background: #ffc107;
    color: #000;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: 600;
    z-index: 9999;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

/* 반응형 개선 */
@media (max-width: 768px) {
    .menu-children {
        margin-left: 1rem;
    }

    .page-header-title {
        font-size: 1.5rem;
    }

    .col-lg-8, .col-lg-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let sortableInstances = [];
let menuStructureChanged = false;

// 페이지 로드 시 초기화
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing sortable...');
    setTimeout(() => {
        initializeSortable();
        initializeExpandCollapse();
        initializeCheckboxes();
    }, 100);
});

// 윈도우 로드 시에도 초기화 (백업)
window.addEventListener('load', function() {
    console.log('Window loaded, ensuring sortable is initialized...');
    setTimeout(() => {
        if (sortableInstances.length === 0) {
            console.log('No sortable instances found, re-initializing...');
            initializeSortable();
        }
    }, 200);
});

// 강제 초기화 함수 (디버깅용)
function forceSortableInit() {
    console.log('Force initializing sortable...');
    initializeSortable();
}

// 간단한 테스트 도구
function toggleTestMode() {
    const isActive = document.body.classList.toggle('test-mode');
    const status = isActive ? '활성화' : '비활성화';
    console.log(`🧪 테스트 모드 ${status}`);
    showAlert('info', `🧪 테스트 모드가 ${status}되었습니다`);
}

// 메뉴 구조 분석
function analyzeMenuStructure() {
    console.log('📊 메뉴 구조 분석...');
    const items = document.querySelectorAll('.menu-item');
    const containers = document.querySelectorAll('.menu-tree, .menu-children');

    console.log(`📈 메뉴 아이템: ${items.length}개, 컨테이너: ${containers.length}개`);

    items.forEach((item, index) => {
        const itemId = item.dataset.itemId;
        const isRoot = item.parentElement.classList.contains('menu-tree');
        const hasChildren = item.querySelector('.menu-children .menu-item') ? 'Yes' : 'No';
        console.log(`${index + 1}. ID:${itemId}, Root:${isRoot}, Children:${hasChildren}`);
    });

    return { items: items.length, containers: containers.length };
}

// 드래그 데모 시연
function demoMenuDrag() {
    console.log('🎬 새로운 미리보기 드래그 데모 시작...');

    const items = document.querySelectorAll('.menu-item');
    if (items.length < 2) {
        showAlert('warning', '데모를 위해 최소 2개의 메뉴 아이템이 필요합니다');
        return;
    }

    let step = 0;
    const steps = [
        '🖱️ 드래그 핸들(왼쪽 아이콘)을 클릭하여 아이템을 드래그하세요',
        '📄 다른 아이템 위로 올리면 파란색 들여쓰기 미리보기가 나타납니다',
        '🟢 아이템 하단 30% 영역으로 이동하면 녹색 하위 드롭 존이 활성화됩니다',
        '✨ 이제 원본 요소는 그대로 있으면서 미리보기만 표시됩니다!',
        '📍 원하는 위치에 드롭하면 그때 실제 이동이 일어납니다',
        '💾 변경사항 저장 버튼을 클릭하여 서버에 저장하세요'
    ];

    function showNextStep() {
        if (step < steps.length) {
            showAlert('info', steps[step]);
            step++;
            setTimeout(showNextStep, 3500);
        } else {
            showAlert('success', '🎉 새로운 미리보기 시스템으로 정확한 하위 이동이 가능합니다!');
        }
    }

    showNextStep();
}

// 미리보기 전용 드래그 시스템 (실제 이동 없음)
let draggedElement = null;
let dragTargetInfo = null;

function initializeSortable() {
    console.log('🚀 미리보기 전용 드래그 시스템 초기화...');

    // 기존 인스턴스 제거
    sortableInstances.forEach(instance => {
        if (instance && typeof instance.destroy === 'function') {
            instance.destroy();
        }
    });
    sortableInstances = [];

    // SortableJS 확인
    if (typeof Sortable === 'undefined') {
        console.error('SortableJS not loaded!');
        return;
    }

    // 컨테이너 찾기
    const containers = document.querySelectorAll('.menu-tree, .menu-children');
    console.log(`발견된 컨테이너: ${containers.length}개`);

    containers.forEach((container, index) => {
        try {
            const sortable = new Sortable(container, {
                group: 'menu-items',
                animation: 200,
                handle: '.drag-handle',
                ghostClass: 'drag-ghost',
                chosenClass: 'drag-chosen',
                sort: false, // 자동 정렬 비활성화 - 중요!

                onStart: function(evt) {
                    console.log('✨ 드래그 시작 (미리보기 모드)');
                    menuStructureChanged = true;
                    showSaveIndicator();

                    // 드래그된 요소 저장
                    draggedElement = evt.item;
                    dragTargetInfo = null;

                    // 드래그 상태 표시
                    document.body.classList.add('dragging');
                    evt.item.classList.add('being-dragged');
                },

                onEnd: function(evt) {
                    console.log('✨ 드래그 종료 - 실제 이동 처리');

                    // 상태 정리
                    document.body.classList.remove('dragging');
                    evt.item.classList.remove('being-dragged');

                    // 모든 시각적 효과 정리
                    document.querySelectorAll('.indent-preview, .child-drop-active').forEach(el => {
                        el.classList.remove('indent-preview', 'child-drop-active');
                    });

                    // 실제 이동 처리
                    if (dragTargetInfo && draggedElement) {
                        performActualMove(draggedElement, dragTargetInfo);
                    }

                    // 변수 정리
                    draggedElement = null;
                    dragTargetInfo = null;

                    // 구조 업데이트
                    setTimeout(() => updateMenuStructure(), 100);
                },

                onMove: function(evt, originalEvent) {
                    // 시각적 피드백만 처리하고 실제 이동은 막음
                    handleDragPreview(evt, originalEvent);
                    return false; // 실제 이동 방지
                }
            });

            sortableInstances.push(sortable);
            console.log(`✅ 컨테이너 ${index + 1} 초기화 완료`);

        } catch (error) {
            console.error(`❌ 컨테이너 ${index + 1} 초기화 실패:`, error);
        }
    });

    console.log(`🎉 총 ${sortableInstances.length}개 컨테이너 초기화 완료`);
}

// 드래그 미리보기 처리 (실제 이동 없음)
function handleDragPreview(evt, originalEvent) {
    const dragged = evt.dragged;
    const related = evt.related;
    const mouseY = originalEvent.clientY;

    // 모든 시각적 효과 초기화
    document.querySelectorAll('.indent-preview, .child-drop-active').forEach(el => {
        el.classList.remove('indent-preview', 'child-drop-active');
    });

    // 자기 자신이나 자식에게는 이동 불가
    if (related === dragged || (related && dragged.contains(related))) {
        dragTargetInfo = null;
        return;
    }

    // 메뉴 아이템에 대한 처리
    if (related && related.classList.contains('menu-item')) {
        const rect = related.getBoundingClientRect();
        const itemHeight = rect.height;
        const relativeY = mouseY - rect.top;

        // 하단 30% 영역: 하위로 이동
        if (relativeY > itemHeight * 0.7) {
            console.log('👶 하위 영역 미리보기');

            // 서브 영역 녹색 활성화
            const childContainer = related.querySelector('.menu-children');
            if (childContainer) {
                childContainer.classList.add('child-drop-active');

                // 드롭 대상 정보 저장
                dragTargetInfo = {
                    type: 'child',
                    targetElement: related,
                    targetContainer: childContainer
                };
            }
        }
        // 상단/중단 70% 영역: 형제로 이동 (들여쓰기 미리보기)
        else {
            console.log('👥 형제 영역 미리보기');

            // 들여쓰기 미리보기
            related.classList.add('indent-preview');

            // 드롭 대상 정보 저장
            dragTargetInfo = {
                type: 'sibling',
                targetElement: related,
                targetContainer: related.parentElement,
                insertBefore: true
            };
        }
    }
    // 빈 컨테이너나 드롭 존 처리
    else if (related && (related.classList.contains('menu-children') || related.classList.contains('empty-drop-zone'))) {
        const container = related.classList.contains('menu-children') ? related : related.parentElement;

        dragTargetInfo = {
            type: 'container',
            targetContainer: container
        };
    }
    else {
        dragTargetInfo = null;
    }
}

// 실제 DOM 이동 처리
function performActualMove(draggedElement, targetInfo) {
    console.log('🔄 실제 이동 실행:', targetInfo);

    if (!targetInfo) {
        console.log('❌ 이동 대상이 없습니다');
        return;
    }

    try {
        switch (targetInfo.type) {
            case 'child':
                // 하위로 이동
                console.log('👶 하위로 이동');
                targetInfo.targetContainer.appendChild(draggedElement);
                showAlert('success', '하위 메뉴로 이동했습니다');
                break;

            case 'sibling':
                // 형제로 이동
                console.log('👥 형제로 이동');
                if (targetInfo.insertBefore) {
                    targetInfo.targetContainer.insertBefore(draggedElement, targetInfo.targetElement);
                } else {
                    targetInfo.targetContainer.insertBefore(draggedElement, targetInfo.targetElement.nextSibling);
                }
                showAlert('success', '순서를 변경했습니다');
                break;

            case 'container':
                // 컨테이너로 이동
                console.log('📦 컨테이너로 이동');
                targetInfo.targetContainer.appendChild(draggedElement);
                showAlert('success', '컨테이너로 이동했습니다');
                break;

            default:
                console.log('❓ 알 수 없는 이동 유형');
        }
    } catch (error) {
        console.error('❌ 이동 실행 오류:', error);
        showAlert('error', '이동 중 오류가 발생했습니다');
    }
}

// 펼치기/접기 초기화
function initializeExpandCollapse() {
    document.querySelectorAll('.expand-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const menuItem = this.closest('.menu-item');
            menuItem.classList.toggle('collapsed');
        });
    });
}

// 체크박스 초기화
function initializeCheckboxes() {
    // 전체 선택 체크박스 이벤트
    const selectAllCheckbox = document.getElementById('selectAllItems');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const itemCheckboxes = document.querySelectorAll('.menu-item-checkbox');
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButtons();
        });
    }

    // 개별 체크박스 이벤트
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('menu-item-checkbox')) {
            updateSelectAllState();
            updateBulkActionButtons();
        }
    });
}

// 전체 선택 상태 업데이트
function updateSelectAllState() {
    const selectAllCheckbox = document.getElementById('selectAllItems');
    const itemCheckboxes = document.querySelectorAll('.menu-item-checkbox');
    const checkedItems = document.querySelectorAll('.menu-item-checkbox:checked');

    if (selectAllCheckbox) {
        if (checkedItems.length === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedItems.length === itemCheckboxes.length) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        }
    }
}

// 일괄 작업 버튼 상태 업데이트
function updateBulkActionButtons() {
    const checkedItems = document.querySelectorAll('.menu-item-checkbox:checked');
    const bulkButtons = document.querySelectorAll('[onclick^="bulk"]');

    bulkButtons.forEach(button => {
        if (checkedItems.length > 0) {
            button.disabled = false;
            button.classList.remove('disabled');
        } else {
            button.disabled = true;
            button.classList.add('disabled');
        }
    });
}

// 저장 표시기
function showSaveIndicator() {
    const saveBtn = document.getElementById('saveBtn');
    if (saveBtn) {
        saveBtn.classList.remove('btn-success');
        saveBtn.classList.add('btn-warning');
        saveBtn.innerHTML = '<i class="fe fe-save me-2"></i>변경사항 저장 *';
    }
}

// 메뉴 구조 업데이트
function updateMenuStructure() {
    // 변경사항이 있음을 시각적으로 표시
    showSaveIndicator();

    // 통계 업데이트
    updateStatistics();
}

// 통계 업데이트
function updateStatistics() {
    const totalItems = document.querySelectorAll('.menu-item').length;
    const activeItems = document.querySelectorAll('.menu-item').length; // 실제로는 활성화된 아이템만 계산해야 함

    document.getElementById('totalItemsCount').textContent = totalItems;
    document.getElementById('activeItemsCount').textContent = activeItems;
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('activeItems').textContent = activeItems;
}

// 메뉴 구조 저장
async function saveMenuStructure() {
    if (!menuStructureChanged) {
        showAlert('info', '변경사항이 없습니다.');
        return;
    }

    const items = [];

    function processItems(container, parentId = 0, level = 0) {
        // 직접 자식 메뉴 아이템만 선택 (중첩된 자식은 제외)
        const itemElements = container.querySelectorAll(':scope > .menu-item');

        console.log(`Processing container with parent ID: ${parentId}, level: ${level}, found ${itemElements.length} items`);

        itemElements.forEach((item, index) => {
            const itemId = parseInt(item.dataset.itemId);

            const itemData = {
                id: itemId,
                ref: parentId,
                pos: index + 1, // 위치는 1부터 시작
                level: level
            };

            items.push(itemData);
            console.log(`Added item:`, itemData);

            // 자식 아이템 처리 - 해당 아이템의 .menu-children 컨테이너 찾기
            const childrenContainer = item.querySelector(':scope > .menu-children');
            if (childrenContainer) {
                const hasChildItems = childrenContainer.querySelectorAll(':scope > .menu-item').length > 0;
                if (hasChildItems) {
                    console.log(`Processing children of item ${itemId}`);
                    processItems(childrenContainer, itemId, level + 1);
                }
            }
        });
    }

    const mainTree = document.getElementById('menuTree');
    console.log('Starting to process menu structure...');
    processItems(mainTree, 0, 0);

    console.log('Final items structure:', items);

    try {
        const response = await fetch('{{ route("admin.cms.menu.structure.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items })
        });

        const result = await response.json();

        if (result.success) {
            menuStructureChanged = false;
            const saveBtn = document.getElementById('saveBtn');
            saveBtn.classList.remove('btn-warning');
            saveBtn.classList.add('btn-success');
            saveBtn.innerHTML = '<i class="fe fe-check me-2"></i>저장 완료';

            showAlert('success', '메뉴 구조가 성공적으로 저장되었습니다.');

            setTimeout(() => {
                saveBtn.classList.remove('btn-success');
                saveBtn.innerHTML = '<i class="fe fe-save me-2"></i>변경사항 저장';
            }, 3000);
        } else {
            showAlert('error', '메뉴 구조 저장 중 오류가 발생했습니다.');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', '메뉴 구조 저장 중 오류가 발생했습니다.');
    }
}

// 새 메뉴 아이템 생성
function createMenuItem(parentId = 0) {
    document.getElementById('menuItemModalTitle').textContent = '메뉴 아이템 추가';
    document.getElementById('itemId').value = '';
    document.getElementById('parentId').value = parentId;
    document.getElementById('menuItemForm').reset();
    document.getElementById('itemEnable').checked = true;

    const modal = new bootstrap.Modal(document.getElementById('menuItemModal'));
    modal.show();
}

// 메뉴 아이템 수정
function editMenuItem(itemId) {
    // 실제로는 AJAX로 아이템 정보를 가져와야 함
    document.getElementById('menuItemModalTitle').textContent = '메뉴 아이템 수정';
    document.getElementById('itemId').value = itemId;

    const modal = new bootstrap.Modal(document.getElementById('menuItemModal'));
    modal.show();
}

// 메뉴 아이템 삭제
async function deleteMenuItem(itemId) {
    if (!confirm('이 메뉴 아이템을 삭제하시겠습니까? 하위 아이템도 함께 삭제됩니다.')) {
        return;
    }

    try {
        const response = await fetch(`{{ route("admin.cms.menu.item.delete", ":id") }}`.replace(':id', itemId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const result = await response.json();

        if (result.success) {
            showAlert('success', '메뉴 아이템이 삭제되었습니다.');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('error', '메뉴 아이템 삭제 중 오류가 발생했습니다.');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', '메뉴 아이템 삭제 중 오류가 발생했습니다.');
    }
}

// 서브 아이템 추가
function addSubItem(parentId) {
    createMenuItem(parentId);
}

// 모두 펼치기
function expandAll() {
    document.querySelectorAll('.menu-item.collapsed').forEach(item => {
        item.classList.remove('collapsed');
    });
    showAlert('success', '모든 메뉴가 펼쳐졌습니다.');
}

// 모두 접기
function collapseAll() {
    document.querySelectorAll('.menu-item').forEach(item => {
        const hasChildren = item.querySelector('.menu-children');
        if (hasChildren) {
            item.classList.add('collapsed');
        }
    });
    showAlert('success', '모든 메뉴가 접혔습니다.');
}

// 일괄 작업
function bulkAction(action) {
    const selectedItems = document.querySelectorAll('.menu-item-checkbox:checked');

    if (selectedItems.length === 0) {
        showAlert('warning', '선택된 아이템이 없습니다.');
        return;
    }

    if (action === 'delete' && !confirm(`선택된 ${selectedItems.length}개 아이템을 삭제하시겠습니까?`)) {
        return;
    }

    // 실제 구현은 컨트롤러에 bulk API를 추가해야 함
    showAlert('info', `${selectedItems.length}개 아이템에 대한 ${action} 작업을 진행합니다.`);
}

function bulkEnable() {
    bulkAction('enable');
}

function bulkDisable() {
    bulkAction('disable');
}

// 메뉴 아이템 폼 제출
document.getElementById('menuItemForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const itemId = document.getElementById('itemId').value;
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    data.menu_id = document.getElementById('menuId').value;
    data.ref = document.getElementById('parentId').value;
    data.enable = document.getElementById('itemEnable').checked;
    data.submenu = document.getElementById('itemSubmenu').checked;

    const isEdit = itemId !== '';
    const url = isEdit
        ? `{{ route("admin.cms.menu.item.update", ":id") }}`.replace(':id', itemId)
        : '{{ route("admin.cms.menu.item.create") }}';
    const method = isEdit ? 'PUT' : 'POST';

    try {
        // CSRF 토큰을 폼에서 가져오기
        const csrfToken = document.querySelector('input[name="_token"]').value;

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showAlert('success', isEdit ? '메뉴 아이템이 수정되었습니다.' : '메뉴 아이템이 생성되었습니다.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('menuItemModal'));
            modal.hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            let errorMessage = result.message || '메뉴 아이템 저장 중 오류가 발생했습니다.';

            // 세부 에러 메시지가 있는 경우 추가
            if (result.errors) {
                const errorDetails = Object.values(result.errors).flat().join(', ');
                errorMessage += ' (' + errorDetails + ')';
            }

            showAlert('error', errorMessage);
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', '메뉴 아이템 저장 중 오류가 발생했습니다.');
    }
});

// 알림 표시
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'alert-success' :
                     type === 'error' ? 'alert-danger' :
                     type === 'warning' ? 'alert-warning' : 'alert-info';
    const iconClass = type === 'success' ? 'fe-check-circle' :
                     type === 'error' ? 'fe-alert-circle' :
                     type === 'warning' ? 'fe-alert-triangle' : 'fe-info';

    alertContainer.style.display = 'block';
    alertContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fe ${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // 자동 닫기
    setTimeout(() => {
        const alert = alertContainer.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, type === 'success' ? 3000 : 5000);
}
</script>
@endpush
