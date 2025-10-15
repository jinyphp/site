@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '정적 페이지 관리')

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
                                <i class="fe fe-file-text me-2"></i>
                                정적 페이지 관리
                            </h1>
                            <p class="page-header-subtitle">사이트의 정적 페이지를 관리합니다</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.pages.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 페이지 생성
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 페이지</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-file-text"></i>
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
                            <h4 class="card-title mb-1">발행됨</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['published']) }}</h2>
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
                            <h4 class="card-title mb-1">임시저장</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['draft']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-edit"></i>
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
                            <h4 class="card-title mb-1">추천 페이지</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['featured']) }}</h2>
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
                                   placeholder="제목, 내용 검색..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">상태</label>
                            <select name="status" class="form-select">
                                <option value="">모든 상태</option>
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>발행됨</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>임시저장</option>
                                <option value="private" {{ request('status') === 'private' ? 'selected' : '' }}>비공개</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">추천</label>
                            <select name="featured" class="form-select">
                                <option value="">모든 페이지</option>
                                <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>추천 페이지</option>
                                <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>일반 페이지</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>생성일</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>제목</option>
                                <option value="order" {{ request('sort_by') == 'order' ? 'selected' : '' }}>정렬순서</option>
                                <option value="view_count" {{ request('sort_by') == 'view_count' ? 'selected' : '' }}>조회수</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">순서</label>
                            <select name="sort_order" class="form-select">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>내림차순</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>오름차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary me-2">검색</button>
                            <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-outline-secondary">초기화</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 페이지 목록 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-header-title mb-0">페이지 목록</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-3">선택된 항목에 대해 일괄 작업을 수행할 수 있습니다.</span>
                            <form id="bulkActionForm" method="POST" action="{{ route('admin.cms.pages.bulkAction') }}" class="d-flex">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="action" class="form-select" required>
                                        <option value="">일괄 작업 선택</option>
                                        <option value="publish">발행</option>
                                        <option value="draft">임시저장</option>
                                        <option value="private">비공개</option>
                                        <option value="featured">추천 설정</option>
                                        <option value="unfeatured">추천 해제</option>
                                        <option value="delete">삭제</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary">실행</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($pages->count() > 0)

                    <!-- 페이지 목록 -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="selectAllTable" class="form-check-input">
                                    </th>
                                    <th>제목</th>
                                    <th width="120">상태</th>
                                    <th width="100">조회수</th>
                                    <th width="120">블럭수</th>
                                    <th width="80">추천</th>
                                    <th width="120">작성자</th>
                                    <th width="140">생성일</th>
                                    <th width="120">작업</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $page->id }}"
                                               class="form-check-input bulk-checkbox">
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.cms.pages.show', $page->id) }}"
                                               class="text-decoration-none fw-medium">
                                                {{ $page->title }}
                                            </a>
                                            <div class="text-muted small">
                                                <i class="fe fe-link"></i> /{{ $page->slug }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $page->getStatusBadgeClass() }}">
                                            {{ $page->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ number_format($page->view_count) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ number_format($page->blocks_count) }}</span>
                                    </td>
                                    <td>
                                        @if($page->is_featured)
                                            <i class="fe fe-star text-warning"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $page->creator->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $page->created_at->format('Y-m-d H:i') }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ $page->url }}" class="btn btn-outline-info"
                                               target="_blank" title="미리보기">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.cms.pages.edit', $page->id) }}"
                                               class="btn btn-outline-primary" title="수정">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                    onclick="deletePage({{ $page->id }})" title="삭제">
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
                    @if($pages->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3 border-top pt-3">
                        <div class="text-muted">
                            총 {{ number_format($pages->total()) }}개 중
                            {{ number_format($pages->firstItem()) }} - {{ number_format($pages->lastItem()) }}개 표시
                        </div>
                        <div>
                            {{ $pages->appends(request()->query())->links('pagination.custom') }}
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="text-center py-5">
                        <i class="fe fe-file-text text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">페이지가 없습니다</h5>
                        <p class="text-muted">새 페이지를 생성해보세요.</p>
                        <a href="{{ route('admin.cms.pages.create') }}" class="btn btn-primary">
                            <i class="fe fe-plus me-2"></i>페이지 생성
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">페이지 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 페이지를 삭제하시겠습니까?</p>
                <p class="text-danger small">삭제된 페이지는 복구할 수 없습니다.</p>
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
// 전체 선택 - 테이블 헤더
document.getElementById('selectAllTable').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// 개별 체크박스 변경 시 전체 선택 상태 업데이트
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('bulk-checkbox')) {
        const allCheckboxes = document.querySelectorAll('.bulk-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.bulk-checkbox:checked');
        const allChecked = allCheckboxes.length === checkedCheckboxes.length;

        document.getElementById('selectAllTable').checked = allChecked;
    }
});

// 일괄 작업
document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
    const checkedBoxes = document.querySelectorAll('.bulk-checkbox:checked');
    if (checkedBoxes.length === 0) {
        e.preventDefault();
        alert('하나 이상의 항목을 선택해주세요.');
        return;
    }

    const action = this.querySelector('select[name="action"]').value;
    if (action === 'delete') {
        if (!confirm('선택한 페이지들을 정말로 삭제하시겠습니까?')) {
            e.preventDefault();
            return;
        }
    }
});

// 삭제 기능
function deletePage(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('deleteForm').action = `/admin/cms/pages/${id}`;
    modal.show();
}
</script>
@endpush
