@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Help 카테고리 관리')

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.help.categories.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 카테고리
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3">
                                <i class="fe fe-folder text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 카테고리</h6>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3">
                                <i class="fe fe-check text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">활성 카테고리</h6>
                            <h4 class="mb-0">{{ $stats['enabled'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3">
                                <i class="fe fe-pause text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">비활성 카테고리</h6>
                            <h4 class="mb-0">{{ $stats['disabled'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cms.help.categories.index') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search">검색</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="카테고리명, 코드로 검색..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                        <a href="{{ route('admin.cms.help.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-refresh-cw me-1"></i>초기화
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 카테고리 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">카테고리 목록</h5>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>코드</th>
                                <th>카테고리명</th>
                                <th>아이콘</th>
                                <th width="100">상태</th>
                                <th width="150">생성일</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories">
                            @foreach($categories as $category)
                            <tr data-id="{{ $category->id }}">
                                <td>
                                    {{ $category->id }}
                                </td>
                                <td>
                                    <code>{{ $category->code }}</code>
                                </td>
                                <td>
                                    <strong>{{ $category->title }}</strong>
                                    @if($category->content)
                                        <br><small class="text-muted">{{ Str::limit($category->content, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($category->enable)
                                        <span class="badge bg-success">활성</span>
                                    @else
                                        <span class="badge bg-secondary">비활성</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @php
                                            $editParams = request()->only(['page', 'search']);
                                            $editUrl = route('admin.cms.help.categories.edit', $category->id);
                                            if (!empty(array_filter($editParams))) {
                                                $editUrl .= '?' . http_build_query($editParams);
                                            }
                                        @endphp
                                        <a href="{{ $editUrl }}"
                                           class="btn btn-outline-primary"
                                           title="수정">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                title="삭제"
                                                onclick="deleteCategory({{ $category->id }})">
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
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            전체 {{ $categories->total() }}개 중
                            {{ $categories->firstItem() }}~{{ $categories->lastItem() }}개 표시
                        </div>
                        <div>
                            {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-folder-minus fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 카테고리가 없습니다</h5>
                    <p class="text-muted">새 카테고리를 생성해보세요.</p>
                    <a href="{{ route('admin.cms.help.categories.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 카테고리 생성
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">카테고리 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 카테고리를 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    삭제된 데이터는 복구할 수 없습니다.
                </p>
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

@push('styles')
<style>
.cursor-move {
    cursor: move;
}
.sortable-placeholder {
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// 순서 변경
document.addEventListener('DOMContentLoaded', function() {
    const sortable = Sortable.create(document.getElementById('sortable-categories'), {
        handle: '.fe-move',
        animation: 150,
        onEnd: function(evt) {
            const items = Array.from(evt.to.children).map(el => el.dataset.id);

            fetch('{{ route("admin.cms.help.categories.updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ items: items })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 순서 번호 업데이트
                    evt.to.querySelectorAll('tr').forEach((row, index) => {
                        row.querySelector('.badge').textContent = index + 1;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});

// 삭제 확인
function deleteCategory(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/cms/help/categories/${id}`;
    modal.show();
}
</script>
@endpush
