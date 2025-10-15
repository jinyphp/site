@extends('jiny-admin::layouts.admin')

@section('title', $page->title . ' - 블럭 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">페이지 블럭 관리</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.pages.index') }}">페이지 관리</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.pages.edit', $page->id) }}">{{ $page->title }}</a></li>
                    <li class="breadcrumb-item active">블럭 관리</li>
                </ol>
            </nav>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlockModal">
                <i class="fas fa-plus"></i> 블럭 추가
            </button>
            <a href="{{ route('admin.cms.pages.edit', $page->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> 돌아가기
            </a>
        </div>
    </div>

    <!-- Page Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="card-title">{{ $page->title }}</h5>
                    <p class="card-text text-muted">{{ $page->excerpt ?: '설명이 없습니다.' }}</p>
                    <small class="text-muted">
                        URL: <code>{{ $page->url }}</code> |
                        상태: <span class="badge {{ $page->getStatusBadgeClass() }}">{{ $page->getStatusLabel() }}</span>
                    </small>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ url($page->url) }}" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-external-link-alt"></i> 미리보기
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Blocks -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-th-list"></i> 콘텐츠 블럭
                <span class="badge bg-secondary ms-2">{{ $contents->count() }}개</span>
            </h5>
        </div>
        <div class="card-body">
            @if($contents->count() > 0)
                <div id="content-blocks-container" class="sortable">
                    @foreach($contents as $content)
                        <div class="content-block-item mb-3" data-content-id="{{ $content->id }}">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="drag-handle me-2" style="cursor: move;">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </span>
                                        <i class="{{ $content->block_type_icon }} me-2"></i>
                                        <strong>{{ $content->title ?: '제목 없음' }}</strong>
                                        <span class="badge bg-info ms-2">{{ $content->block_type_name }}</span>
                                        @if(!$content->is_active)
                                            <span class="badge bg-danger ms-2">비활성</span>
                                        @endif
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-block-btn"
                                                data-content-id="{{ $content->id }}"
                                                data-bs-toggle="modal" data-bs-target="#editBlockModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-block-btn"
                                                data-content-id="{{ $content->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="content-preview" style="max-height: 150px; overflow: hidden;">
                                        {!! Str::limit(strip_tags($content->rendered_content), 200) !!}
                                    </div>
                                    @if($content->css_class)
                                        <small class="text-muted">CSS 클래스: <code>{{ $content->css_class }}</code></small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-th-large fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">아직 블럭이 없습니다</h5>
                    <p class="text-muted">첫 번째 콘텐츠 블럭을 추가해보세요.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlockModal">
                        <i class="fas fa-plus"></i> 블럭 추가
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Block Modal -->
<div class="modal fade" id="addBlockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">새 블럭 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addBlockForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">블럭 타입 *</label>
                                <select class="form-select" name="block_type" id="block_type" required>
                                    <option value="">블럭 타입을 선택하세요</option>
                                    @foreach(\Jiny\Site\Models\SitePageContent::getAvailableTypes() as $type => $name)
                                        <option value="{{ $type }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">제목</label>
                                <input type="text" class="form-control" name="title" placeholder="블럭 제목 (선택사항)">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">내용</label>
                        <textarea class="form-control" name="content" rows="8" placeholder="블럭 내용을 입력하세요"></textarea>
                        <div class="form-text" id="content-help">
                            <!-- 타입별 도움말이 여기에 표시됩니다 -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CSS 클래스</label>
                                <input type="text" class="form-control" name="css_class" placeholder="예: text-center, bg-primary">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">상태</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">활성화</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">블럭 추가</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Block Modal -->
<div class="modal fade" id="editBlockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">블럭 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBlockForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="content_id" id="edit_content_id">
                <!-- 편집 폼 내용은 addBlockForm과 동일 -->
                <div class="modal-body">
                    <!-- 수정 폼 내용 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">블럭 수정</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content-block-item {
    transition: all 0.3s ease;
}

.content-block-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.drag-handle:hover {
    color: #007bff !important;
}

.sortable-ghost {
    opacity: 0.4;
}

.content-preview {
    font-size: 0.9rem;
    line-height: 1.4;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pageId = {{ $page->id }};

    // Sortable 초기화
    const container = document.getElementById('content-blocks-container');
    if (container) {
        new Sortable(container, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                const contentIds = Array.from(container.children).map(item =>
                    item.getAttribute('data-content-id')
                );

                updateOrder(contentIds);
            }
        });
    }

    // 순서 업데이트
    function updateOrder(contentIds) {
        fetch(`/admin/cms/pages/${pageId}/content/update-order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                content_ids: contentIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('순서가 변경되었습니다.', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('순서 변경 중 오류가 발생했습니다.', 'error');
        });
    }

    // 블럭 타입별 도움말
    const blockTypeHelp = {
        'text': '일반 텍스트를 입력하세요. 줄바꿈은 자동으로 <br> 태그로 변환됩니다.',
        'html': 'HTML 코드를 직접 입력하세요.',
        'markdown': 'Markdown 형식으로 작성하세요.',
        'blade': 'Blade 템플릿 경로를 입력하세요. (예: components.my-component)',
        'image': '이미지 URL을 입력하세요.',
        'video': '비디오 파일 URL을 입력하세요.',
        'code': '코드를 입력하세요. 언어는 설정에서 지정할 수 있습니다.',
        'component': '컴포넌트 경로를 입력하세요.',
        'divider': '내용은 무시되고 구분선이 표시됩니다.'
    };

    // 블럭 타입 변경 시 도움말 업데이트
    document.getElementById('block_type').addEventListener('change', function() {
        const helpDiv = document.getElementById('content-help');
        const selectedType = this.value;

        if (selectedType && blockTypeHelp[selectedType]) {
            helpDiv.textContent = blockTypeHelp[selectedType];
            helpDiv.className = 'form-text text-info';
        } else {
            helpDiv.textContent = '';
        }
    });

    // 토스트 메시지
    function showToast(message, type = 'info') {
        // 간단한 토스트 구현
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush