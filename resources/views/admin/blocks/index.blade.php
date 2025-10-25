@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Block 관리')

@push('styles')
<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.folder-card {
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.folder-card:hover {
    border-color: #ffc107;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.folder-card:hover .fa-folder {
    color: #ffc107 !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- 페이지 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-cubes text-primary me-2"></i>
                        Block 관리
                    </h1>

                    <!-- 브레드크럼 -->
                    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2">
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if($breadcrumb['active'])
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <i class="fas fa-folder me-1"></i>
                                            {{ $breadcrumb['name'] }}
                                        </li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none">
                                                <i class="fas fa-folder me-1"></i>
                                                {{ $breadcrumb['name'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @endif

                    <p class="text-muted mb-0">
                        @if($currentFolder)
                            {{ $currentFolder }} 폴더의 블록 템플릿 파일들을 관리합니다
                        @else
                            웹사이트 블록 템플릿 파일들을 관리합니다
                        @endif
                    </p>
                </div>
                <div>
                    @if($currentFolder)
                        <a href="{{ route('admin.cms.blocks.create.folder', str_replace('/', '.', $currentFolder)) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            새 블록 생성
                        </a>
                    @else
                        <a href="{{ route('admin.cms.blocks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            새 블록 생성
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_blocks'] }}</h4>
                            <p class="mb-0 small">전체 블록</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-cubes fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['hero_blocks'] }}</h4>
                            <p class="mb-0 small">Hero 블록</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-star fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['about_blocks'] }}</h4>
                            <p class="mb-0 small">About 블록</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-info-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['other_blocks'] }}</h4>
                            <p class="mb-0 small">기타 블록</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-th fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cms.blocks.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $currentFilters['search'] }}" placeholder="블록명으로 검색...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">카테고리</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">전체 카테고리</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $currentFilters['category'] === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="per_page" class="form-label">페이지당 표시</label>
                    <select class="form-select" id="per_page" name="per_page">
                        <option value="15" {{ $currentFilters['per_page'] == 15 ? 'selected' : '' }}>15개</option>
                        <option value="30" {{ $currentFilters['per_page'] == 30 ? 'selected' : '' }}>30개</option>
                        <option value="50" {{ $currentFilters['per_page'] == 50 ? 'selected' : '' }}>50개</option>
                        <option value="100" {{ $currentFilters['per_page'] == 100 ? 'selected' : '' }}>100개</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>
                        검색
                    </button>
                    <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i>
                        초기화
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- 폴더 목록 -->
    @if(isset($folders) && count($folders) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-folder me-2"></i>
                    폴더 ({{ count($folders) }}개)
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($folders as $folder)
                        <div class="col-md-3 mb-3">
                            <div class="card folder-card h-100" style="cursor: pointer;" onclick="window.location.href='{{ $folder['url'] }}'">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-folder fa-3x text-warning"></i>
                                    </div>
                                    <h6 class="card-title mb-2">{{ $folder['name'] }}</h6>
                                    <small class="text-muted">{{ $folder['file_count'] }}개 파일</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- 블록 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                블록 목록 ({{ $pagination['total'] }}개)
            </h5>
        </div>
        <div class="card-body p-0">
            @if(count($blocks) > 0 || (isset($folders) && count($folders) > 0))
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30%">블록명</th>
                                <th style="width: 15%">카테고리</th>
                                <th style="width: 25%">설명</th>
                                <th style="width: 10%">크기</th>
                                <th style="width: 15%">수정일</th>
                                <th style="width: 15%">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blocks as $block)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cube text-muted me-2"></i>
                                            <div>
                                                <strong>{{ $block['filename'] }}</strong>
                                                <div class="small text-muted">
                                                    @if($block['folder'])
                                                        <i class="fas fa-folder-open me-1"></i>
                                                        {{ $block['folder'] }}/{{ $block['filename'] }}.blade.php
                                                    @else
                                                        {{ $block['filename'] }}.blade.php
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $block['category'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $block['description'] ?: '설명 없음' }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ number_format($block['size']) }} bytes</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ date('Y-m-d H:i', $block['modified']) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">

                                            <a href="{{ route('admin.cms.blocks.show', $block['path_param']) }}"
                                               class="btn btn-outline-info btn-sm"
                                               title="미리보기">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ $block['preview_url'] }}"
                                               class="btn btn-outline-primary btn-sm"
                                               title="상세보기"
                                               target="_blank">
                                               <i class="fas fa-info-circle"></i>

                                            </a>



                                            <a href="{{ $block['edit_url'] }}"
                                               class="btn btn-outline-success btn-sm"
                                               title="편집">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="삭제"
                                                    onclick="confirmDelete('{{ $block['path_param'] }}', '{{ $block['full_path'] }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 페이지네이션 -->
                @if($pagination['last_page'] > 1)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                총 {{ $pagination['total'] }}개 중 {{ (($pagination['current_page'] - 1) * $currentFilters['per_page']) + 1 }}~{{ min($pagination['current_page'] * $currentFilters['per_page'], $pagination['total']) }}개 표시
                            </div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    @if($pagination['current_page'] > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}">이전</a>
                                        </li>
                                    @endif

                                    @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                        <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    @if($pagination['current_page'] < $pagination['last_page'])
                                        <li class="page-item">
                                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}">다음</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">블록이 없습니다</h5>
                    <p class="text-muted">새로운 블록을 생성해보세요.</p>
                    <a href="{{ route('admin.cms.blocks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        새 블록 생성
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
                <h5 class="modal-title">블록 삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 블록을 삭제하시겠습니까?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>주의:</strong> 삭제된 블록은 백업 폴더에 저장되지만, 현재 사용 중인 페이지에서 오류가 발생할 수 있습니다.
                </div>
                <p class="mb-0"><strong>블록명:</strong> <span id="deleteBlockName"></span></p>
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
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmDelete(pathParam, fullPath) {
    document.getElementById('deleteBlockName').textContent = fullPath;
    document.getElementById('deleteForm').action = '/admin/cms/blocks/' + pathParam;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// 성공/에러 메시지 자동 숨김
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        if (alert.querySelector('.btn-close')) {
            alert.querySelector('.btn-close').click();
        }
    });
}, 5000);
</script>
@endpush
