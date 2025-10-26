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
                                    <i class="fe fe-menu me-2"></i>
                                    메뉴 관리
                                </h1>
                                <p class="page-header-subtitle">JSON 기반 트리 구조 메뉴 시스템</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#uploadJsonModal">
                                    <i class="fe fe-upload me-2"></i>JSON 파일 업로드
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createMenuModal">
                                    <i class="fe fe-plus me-2"></i>새 메뉴 생성
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 페이지 본문 -->
        <div class="page-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <i class="ti ti-check alert-icon"></i>
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
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mb-1">전체 메뉴</h4>
                                    <h2 class="text-primary mb-0">{{ number_format($totalMenus) }}</h2>
                                </div>
                                <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                                    <i class="fe fe-menu"></i>
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
                                    <h4 class="card-title mb-1">활성 메뉴</h4>
                                    <h2 class="text-success mb-0">
                                        {{ number_format($activeMenus) }}</h2>
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
                                    <h4 class="card-title mb-1">비활성 메뉴</h4>
                                    <h2 class="text-warning mb-0">
                                        {{ number_format($inactiveMenus) }}</h2>
                                </div>
                                <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                                    <i class="fe fe-pause-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 메뉴 목록 -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card">
                        <!-- 필터 및 검색 -->
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">검색</label>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="메뉴 코드, 설명 검색..." value="{{ request('search') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">상태</label>
                                            <select name="enable" class="form-select">
                                                <option value="all">모든 상태</option>
                                                <option value="1"
                                                    {{ request('enable') == '1' ? 'selected' : '' }}>활성</option>
                                                <option value="0"
                                                    {{ request('enable') == '0' ? 'selected' : '' }}>비활성</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">정렬</label>
                                            <select name="sort_by" class="form-select">
                                                <option value="created_at"
                                                    {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일
                                                </option>
                                                <option value="menu_code"
                                                    {{ request('sort_by') == 'menu_code' ? 'selected' : '' }}>메뉴 코드
                                                </option>
                                                <option value="enable"
                                                    {{ request('sort_by') == 'enable' ? 'selected' : '' }}>상태</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">순서</label>
                                            <select name="sort_order" class="form-select">
                                                <option value="desc"
                                                    {{ request('sort_order') == 'desc' ? 'selected' : '' }}>내림차순
                                                </option>
                                                <option value="asc"
                                                    {{ request('sort_order') == 'asc' ? 'selected' : '' }}>오름차순
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label d-block">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary me-2">검색</button>
                                            <a href="{{ route('admin.cms.menu.index') }}"
                                                class="btn btn-outline-secondary">초기화</a>
                                        </div>
                                    </form>
                                </div>

                                <!-- 메뉴 목록 -->
                                <div class="card-body p-0 border-top">
                                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                        <div>
                                            <h4 class="card-header-title mb-0">메뉴 목록</h4>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="text-muted me-3">선택된 항목에 대해 일괄 작업을 수행할 수 있습니다.</span>
                                            <form id="bulkActionForm" method="POST" action="#" class="d-flex">
                                                @csrf
                                                <div class="input-group input-group-sm">
                                                    <select name="action" class="form-select" required>
                                                        <option value="">일괄 작업 선택</option>
                                                        <option value="enable">활성화</option>
                                                        <option value="disable">비활성화</option>
                                                        <option value="delete">삭제</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-outline-primary">실행</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    @if ($menus->count() > 0)
                                        <!-- 메뉴 목록 테이블 -->
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="40">
                                                            <input type="checkbox" id="selectAllTable"
                                                                class="form-check-input">
                                                        </th>
                                                        <th>메뉴 코드</th>
                                                        <th width="120">상태</th>
                                                        <th width="120">관리자</th>
                                                        <th width="140">생성일</th>
                                                        <th width="160">작업</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($menus as $menu)
                                                        @php
                                                            $stats = $menu->getMenuStats();
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="ids[]"
                                                                    value="{{ $menu->id }}"
                                                                    class="form-check-input bulk-checkbox">
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <a href="{{ route('admin.cms.menu.tree', $menu->id) }}"
                                                                        class="text-decoration-none fw-medium">
                                                                        {{ $menu->menu_code }}
                                                                    </a>
                                                                    <div class="text-muted small">
                                                                        {{ $menu->description ?: '설명이 없습니다.' }}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        {{ $menu->enable ? 'checked' : '' }}
                                                                        onchange="toggleMenu({{ $menu->id }}, this.checked)">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-muted">{{ $menu->manager ?: '-' }}</span>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="text-muted">{{ $menu->created_at->format('Y-m-d H:i') }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('admin.cms.menu.tree', $menu->id) }}"
                                                                        class="btn btn-outline-primary"
                                                                        title="트리 관리">
                                                                        <i class="fe fe-git-branch"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-outline-info"
                                                                        onclick="editMenu({{ $menu->id }})"
                                                                        title="수정">
                                                                        <i class="fe fe-edit"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger"
                                                                        onclick="deleteMenu({{ $menu->id }})"
                                                                        title="삭제">
                                                                        <i class="fe fe-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- 페이지네이션 -->
                                        @if ($menus->hasPages())
                                            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                                <div class="text-muted">
                                                    @if ($menus->total() > 0)
                                                        {{ number_format($menus->firstItem()) }} - {{ number_format($menus->lastItem()) }} / {{ number_format($menus->total()) }}개 항목 표시
                                                    @else
                                                        0개 항목 표시
                                                    @endif
                                                </div>
                                                <div>
                                                    {{ $menus->appends(request()->query())->links() }}
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fe fe-menu text-muted" style="font-size: 3rem;"></i>
                                            <h5 class="mt-3 text-muted">메뉴가 없습니다</h5>
                                            <p class="text-muted">새 메뉴를 생성하거나 JSON 파일을 업로드해보세요.</p>
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-outline-primary me-2"
                                                    data-bs-toggle="modal" data-bs-target="#uploadJsonModal">
                                                    <i class="fe fe-upload me-2"></i>JSON 파일 업로드
                                                </button>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#createMenuModal">
                                                    <i class="fe fe-plus me-2"></i>메뉴 생성
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- 메뉴 생성 모달 -->
    <div class="modal modal-blur fade" id="createMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">새 메뉴 생성</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createMenuForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="menu_code" class="form-label">메뉴 코드 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="menu_code" name="menu_code" required
                                placeholder="예: main, footer, sidebar">
                            <div class="form-hint">영문, 숫자, 언더스코어만 사용 가능하며, JSON 파일명으로 사용됩니다.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">설명</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="메뉴에 대한 설명을 입력하세요">
                        </div>
                        <div class="mb-3">
                            <label for="manager" class="form-label">관리자</label>
                            <input type="text" class="form-control" id="manager" name="manager"
                                placeholder="관리자명을 입력하세요">
                        </div>
                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable" checked>
                                <span class="form-check-label">메뉴 활성화</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn btn-primary">생성</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JSON 파일 업로드 모달 -->
    <div class="modal modal-blur fade" id="uploadJsonModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-upload me-2"></i>JSON 파일 업로드
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="uploadJsonForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-4">
                            <label for="json_files" class="form-label">JSON 파일 선택 <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="json_files" name="json_files[]" multiple
                                accept=".json" required>
                            <div class="form-hint">
                                <i class="ti ti-info-circle me-1"></i>
                                하나 또는 여러 개의 JSON 파일을 선택할 수 있습니다. 파일명이 메뉴 코드로 사용됩니다.
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <div class="d-flex">
                                <div>
                                    <i class="ti ti-info-circle alert-icon"></i>
                                </div>
                                <div>
                                    <h4 class="alert-title">업로드 안내</h4>
                                    <div class="text-muted">
                                        • 선택한 JSON 파일들이 <code>/resources/menu</code> 폴더에 업로드됩니다.<br>
                                        • 파일명(확장자 제외)이 메뉴 코드로 등록됩니다.<br>
                                        • 이미 존재하는 메뉴 코드는 건너뛰어집니다.<br>
                                        • JSON 형식이 올바르지 않은 파일은 업로드되지 않습니다.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="upload_description" class="form-label">설명 (선택사항)</label>
                            <input type="text" class="form-control" id="upload_description" name="description"
                                placeholder="업로드할 메뉴들에 대한 설명을 입력하세요">
                        </div>

                        <div class="mb-3">
                            <label for="upload_manager" class="form-label">관리자 (선택사항)</label>
                            <input type="text" class="form-control" id="upload_manager" name="manager"
                                placeholder="관리자명을 입력하세요">
                        </div>

                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable" checked>
                                <span class="form-check-label">업로드된 메뉴 활성화</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload me-1"></i>업로드
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 메뉴 수정 모달 -->
    <div class="modal modal-blur fade" id="editMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">메뉴 수정</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMenuForm">
                    <input type="hidden" id="edit_menu_id" name="menu_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_menu_code" class="form-label">메뉴 코드 <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_menu_code" name="menu_code" required>
                            <div class="form-hint">메뉴 코드를 변경하면 JSON 파일명도 함께 변경됩니다.</div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">설명</label>
                            <input type="text" class="form-control" id="edit_description" name="description">
                        </div>
                        <div class="mb-3">
                            <label for="edit_manager" class="form-label">관리자</label>
                            <input type="text" class="form-control" id="edit_manager" name="manager">
                        </div>
                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_enable" name="enable">
                                <span class="form-check-label">메뉴 활성화</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn btn-primary">수정</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // 페이지 초기화
        document.addEventListener('DOMContentLoaded', function() {
            // 페이지가 로드되면 필요한 초기화 작업 수행
        });

        // 전체 선택 - 테이블 헤더
        document.getElementById('selectAllTable')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.bulk-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // 개별 체크박스 변경 시 전체 선택 상태 업데이트
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('bulk-checkbox')) {
                const allCheckboxes = document.querySelectorAll('.bulk-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.bulk-checkbox:checked');
                const allChecked = allCheckboxes.length === checkedCheckboxes.length;

                const selectAllCheckbox = document.getElementById('selectAllTable');
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
            }
        });

        // 일괄 작업
        document.getElementById('bulkActionForm')?.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.bulk-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('하나 이상의 항목을 선택해주세요.');
                return;
            }

            const action = this.querySelector('select[name="action"]').value;
            if (action === 'delete') {
                if (!confirm('선택한 메뉴들을 정말로 삭제하시겠습니까?')) {
                    e.preventDefault();
                    return;
                }
            }
        });


        // 메뉴 생성
        document.getElementById('createMenuForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            data.enable = formData.has('enable');

            fetch('{{ route('admin.cms.menu.store') }}', {
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
                        location.reload();
                    } else {
                        alert('오류: ' + (data.message || '메뉴 생성에 실패했습니다.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('서버 오류가 발생했습니다.');
                });
        });

        // 메뉴 수정
        function editMenu(id) {
            // 메뉴 데이터 로드 및 모달 표시 로직
            const menu = @json($menus).find(m => m.id === id);
            if (menu) {
                document.getElementById('edit_menu_id').value = menu.id;
                document.getElementById('edit_menu_code').value = menu.menu_code;
                document.getElementById('edit_description').value = menu.description || '';
                document.getElementById('edit_manager').value = menu.manager || '';
                document.getElementById('edit_enable').checked = menu.enable;

                new bootstrap.Modal(document.getElementById('editMenuModal')).show();
            }
        }

        // 메뉴 수정 폼 제출
        document.getElementById('editMenuForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            const menuId = data.menu_id;
            data.enable = formData.has('enable');
            delete data.menu_id;

            fetch(`{{ route('admin.cms.menu.update', ':id') }}`.replace(':id', menuId), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('오류: ' + (data.message || '메뉴 수정에 실패했습니다.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('서버 오류가 발생했습니다.');
                });
        });

        // 메뉴 삭제
        function deleteMenu(id) {
            if (confirm('정말로 이 메뉴를 삭제하시겠습니까? JSON 파일은 백업 폴더로 이동됩니다.')) {
                fetch(`{{ route('admin.cms.menu.destroy', ':id') }}`.replace(':id', id), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('오류: ' + (data.message || '메뉴 삭제에 실패했습니다.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('서버 오류가 발생했습니다.');
                    });
            }
        }

        // 메뉴 활성화/비활성화
        function toggleMenu(id, enable) {
            fetch(`{{ route('admin.cms.menu.toggle', ':id') }}`.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        enable: enable
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('오류: ' + (data.message || '상태 변경에 실패했습니다.'));
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('서버 오류가 발생했습니다.');
                    location.reload();
                });
        }

        // JSON 파일 업로드
        document.getElementById('uploadJsonForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // 버튼 상태 변경
            submitButton.innerHTML = '<i class="ti ti-loader me-1"></i>업로드 중...';
            submitButton.disabled = true;

            fetch('{{ route('admin.cms.menu.upload-json') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const results = data.results;
                        let message = 'JSON 파일 업로드가 완료되었습니다!\n\n';

                        if (results.uploaded.length > 0) {
                            message += `✅ 업로드된 파일 (${results.uploaded.length}개):\n`;
                            message += results.uploaded.join(', ') + '\n\n';
                        }

                        if (results.skipped.length > 0) {
                            message += `ℹ️ 건너뛴 파일 (${results.skipped.length}개):\n`;
                            message += results.skipped.join(', ') + '\n\n';
                        }

                        if (results.errors.length > 0) {
                            message += `❌ 오류 발생 (${results.errors.length}개):\n`;
                            message += results.errors.join(', ');
                        }

                        alert(message);

                        // 모달 닫기 및 페이지 새로고침
                        new bootstrap.Modal(document.getElementById('uploadJsonModal')).hide();
                        location.reload();
                    } else {
                        alert('오류: ' + (data.message || 'JSON 파일 업로드에 실패했습니다.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('서버 오류가 발생했습니다.');
                })
                .finally(() => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
        });

        // 파일 선택 시 파일명 표시
        document.getElementById('json_files').addEventListener('change', function(e) {
            const files = e.target.files;
            const fileCount = files.length;

            if (fileCount > 0) {
                let fileNames = [];
                for (let i = 0; i < Math.min(fileCount, 3); i++) {
                    fileNames.push(files[i].name);
                }

                let displayText = fileNames.join(', ');
                if (fileCount > 3) {
                    displayText += ` 외 ${fileCount - 3}개 파일`;
                }

                // 파일 힌트 업데이트
                const hint = this.parentNode.querySelector('.form-hint');
                hint.innerHTML = `<i class="ti ti-check me-1 text-success"></i>선택된 파일: ${displayText}`;
            }
        });
    </script>
@endpush
