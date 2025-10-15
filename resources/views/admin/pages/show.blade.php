@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $page->title)

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
                                {{ $page->title }}
                            </h1>
                            <p class="page-header-subtitle">
                                <span class="badge {{ $page->getStatusBadgeClass() }} me-2">
                                    {{ $page->getStatusLabel() }}
                                </span>
                                @if($page->is_featured)
                                    <span class="badge badge-warning me-2">
                                        <i class="fe fe-star"></i> 추천
                                    </span>
                                @endif
                                <span class="text-muted">
                                    조회수: {{ number_format($page->view_count) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ $page->url }}" class="btn btn-outline-info" target="_blank">
                                <i class="fe fe-eye me-2"></i>미리보기
                            </a>
                            <a href="{{ route('admin.cms.pages.edit', $page->id) }}" class="btn btn-primary">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 메인 콘텐츠 -->
        <div class="col-lg-8">
            <!-- 기본 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">페이지 내용</h4>
                </div>
                <div class="card-body">
                    @if($page->excerpt)
                    <div class="alert alert-light">
                        <h6 class="alert-heading">요약</h6>
                        <p class="mb-0">{{ $page->excerpt }}</p>
                    </div>
                    @endif

                    <div class="content">
                        {!! nl2br(e($page->content)) !!}
                    </div>
                </div>
            </div>

            <!-- SEO 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SEO 정보</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>메타 정보</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="120">메타 제목:</th>
                                    <td>{{ $page->meta_title ?: $page->title }}</td>
                                </tr>
                                <tr>
                                    <th>메타 설명:</th>
                                    <td>{{ $page->meta_description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>메타 키워드:</th>
                                    <td>{{ $page->meta_keywords ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Open Graph 정보</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="120">OG 제목:</th>
                                    <td>{{ $page->og_title ?: $page->meta_title ?: $page->title }}</td>
                                </tr>
                                <tr>
                                    <th>OG 설명:</th>
                                    <td>{{ $page->og_description ?: $page->meta_description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>OG 이미지:</th>
                                    <td>
                                        @if($page->og_image)
                                            <a href="{{ $page->og_image }}" target="_blank">{{ $page->og_image }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 콘텐츠 블럭 관리 -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fe fe-layout me-2"></i>콘텐츠 블럭 관리
                        </h4>
                        <button type="button" class="btn btn-primary btn-sm" id="addBlockBtn">
                            <i class="fe fe-plus me-2"></i>블럭 추가
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="content-blocks-container">
                        <!-- 블럭들이 여기에 동적으로 로드됩니다 -->
                    </div>

                    <div id="no-blocks-message" class="text-center py-4" style="display: none;">
                        <i class="fe fe-layout fa-2x text-muted mb-3"></i>
                        <h6 class="text-muted">아직 블럭이 없습니다</h6>
                        <p class="text-muted">첫 번째 콘텐츠 블럭을 추가해보세요.</p>
                        <button type="button" class="btn btn-primary" id="addFirstBlockBtn">
                            <i class="fe fe-plus me-2"></i>블럭 추가
                        </button>
                    </div>
                </div>
            </div>

            <!-- 커스텀 필드 -->
            @if($page->custom_fields && count($page->custom_fields) > 0)
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">커스텀 필드</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        @foreach($page->custom_fields as $key => $value)
                        <tr>
                            <th width="200">{{ $key }}:</th>
                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 페이지 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">페이지 정보</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th width="80">URL:</th>
                            <td>
                                <code>/{{ $page->slug }}</code>
                                <a href="{{ $page->url }}" target="_blank" class="ms-2">
                                    <i class="fe fe-external-link"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>상태:</th>
                            <td>
                                <span class="badge {{ $page->getStatusBadgeClass() }}">
                                    {{ $page->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>템플릿:</th>
                            <td>{{ $page->template ?: '기본' }}</td>
                        </tr>
                        <tr>
                            <th>조회수:</th>
                            <td>{{ number_format($page->view_count) }}</td>
                        </tr>
                        <tr>
                            <th>정렬 순서:</th>
                            <td>{{ $page->sort_order }}</td>
                        </tr>
                        <tr>
                            <th>추천:</th>
                            <td>
                                @if($page->is_featured)
                                    <i class="fe fe-star text-warning"></i> 예
                                @else
                                    아니오
                                @endif
                            </td>
                        </tr>
                        @if($page->published_at)
                        <tr>
                            <th>발행일:</th>
                            <td>{{ $page->published_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- 작성자 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">작성자 정보</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th width="80">작성자:</th>
                            <td>{{ $page->creator->name ?? '알 수 없음' }}</td>
                        </tr>
                        <tr>
                            <th>작성일:</th>
                            <td>{{ $page->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @if($page->updated_at->ne($page->created_at))
                        <tr>
                            <th>수정자:</th>
                            <td>{{ $page->updater->name ?? '알 수 없음' }}</td>
                        </tr>
                        <tr>
                            <th>수정일:</th>
                            <td>{{ $page->updated_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- 작업 -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.pages.edit', $page->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>수정
                        </a>
                        <a href="{{ $page->url }}" class="btn btn-outline-info" target="_blank">
                            <i class="fe fe-eye me-2"></i>미리보기
                        </a>
                        @if($page->status === 'draft')
                        <form method="POST" action="{{ route('admin.cms.pages.update', $page->id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <input type="hidden" name="title" value="{{ $page->title }}">
                            <input type="hidden" name="slug" value="{{ $page->slug }}">
                            <input type="hidden" name="content" value="{{ $page->content }}">
                            <button type="submit" class="btn btn-success w-100"
                                    onclick="return confirm('이 페이지를 발행하시겠습니까?')">
                                <i class="fe fe-check me-2"></i>발행
                            </button>
                        </form>
                        @endif
                        <button type="button" class="btn btn-outline-danger"
                                onclick="deletePage({{ $page->id }})">
                            <i class="fe fe-trash me-2"></i>삭제
                        </button>
                    </div>
                </div>
            </div>

            <!-- 통계 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">통계</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="text-primary">{{ number_format($page->view_count) }}</h4>
                                <small class="text-muted">총 조회수</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info">{{ $page->getReadingTime() }}분</h4>
                                <small class="text-muted">예상 읽기 시간</small>
                            </div>
                        </div>
                    </div>
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
function deletePage(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('deleteForm').action = `/admin/cms/pages/${id}`;
    modal.show();
}

// 콘텐츠 블럭 관리
class ContentBlockManager {
    constructor(pageId) {
        this.pageId = pageId;
        this.container = document.getElementById('content-blocks-container');
        this.noBlocksMessage = document.getElementById('no-blocks-message');
        this.init();
    }

    init() {
        this.loadBlocks();
        this.bindEvents();
        this.initSortable();
    }

    bindEvents() {
        document.getElementById('addBlockBtn').addEventListener('click', () => this.goToCreatePage());
        document.getElementById('addFirstBlockBtn').addEventListener('click', () => this.goToCreatePage());

        // 블럭 삭제 이벤트는 동적으로 바인딩
        this.container.addEventListener('click', (e) => {
            if (e.target.closest('.delete-block-btn')) {
                const blockId = e.target.closest('.delete-block-btn').dataset.blockId;
                this.deleteBlock(blockId);
            }
        });
    }

    async loadBlocks() {
        try {
            const response = await fetch(`/admin/cms/pages/${this.pageId}/content`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.renderBlocks(data.data);
            }
        } catch (error) {
            console.error('블럭 로드 실패:', error);
        }
    }

    renderBlocks(blocks) {
        if (blocks.length === 0) {
            this.container.style.display = 'none';
            this.noBlocksMessage.style.display = 'block';
            return;
        }

        this.container.style.display = 'block';
        this.noBlocksMessage.style.display = 'none';

        this.container.innerHTML = blocks.map(block => this.renderBlock(block)).join('');
    }

    renderBlock(block) {
        return `
            <div class="content-block-item mb-3" data-block-id="${block.id}">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="drag-handle me-2" style="cursor: move;">
                                <i class="fe fe-move text-muted"></i>
                            </span>
                            <i class="${block.block_type_icon} me-2"></i>
                            <strong>${block.title || '제목 없음'}</strong>
                            <span class="badge bg-info ms-2">${block.block_type_name}</span>
                            ${!block.is_active ? '<span class="badge bg-danger ms-2">비활성</span>' : ''}
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="/admin/cms/pages/${this.pageId}/content/${block.id}/edit" class="btn btn-outline-primary">
                                <i class="fe fe-edit"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger delete-block-btn" data-block-id="${block.id}">
                                <i class="fe fe-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content-preview text-muted small" style="max-height: 60px; overflow: hidden;">
                            ${block.content_preview || '내용 없음'}
                        </div>
                        ${block.css_class ? `<div class="mt-2"><small class="text-muted">CSS 클래스: <code>${block.css_class}</code></small></div>` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    initSortable() {
        if (typeof Sortable !== 'undefined' && this.container) {
            new Sortable(this.container, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: (evt) => {
                    const blockIds = Array.from(this.container.children).map(item =>
                        item.getAttribute('data-block-id')
                    );
                    this.updateOrder(blockIds);
                }
            });
        }
    }

    async updateOrder(blockIds) {
        try {
            const response = await fetch(`/admin/cms/pages/${this.pageId}/content/update-order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content_ids: blockIds })
            });

            const data = await response.json();
            if (data.success) {
                this.showToast('순서가 변경되었습니다.', 'success');
            }
        } catch (error) {
            console.error('순서 변경 실패:', error);
            this.showToast('순서 변경에 실패했습니다.', 'danger');
        }
    }

    goToCreatePage() {
        // 새 블럭 생성 페이지로 이동
        window.location.href = `/admin/cms/pages/${this.pageId}/content/create`;
    }

    async addBlock(blockData) {
        try {
            const response = await fetch(`/admin/cms/pages/${this.pageId}/content`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(blockData)
            });

            const data = await response.json();
            if (data.success) {
                this.showToast('블럭이 추가되었습니다.', 'success');
                this.loadBlocks(); // 블럭 목록 새로고침
            } else {
                this.showToast('블럭 추가에 실패했습니다.', 'danger');
            }
        } catch (error) {
            console.error('블럭 추가 실패:', error);
            this.showToast('블럭 추가에 실패했습니다.', 'danger');
        }
    }


    async deleteBlock(blockId) {
        if (confirm('이 블럭을 삭제하시겠습니까?')) {
            try {
                const response = await fetch(`/admin/cms/pages/${this.pageId}/content/${blockId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    this.showToast('블럭이 삭제되었습니다.', 'success');
                    this.loadBlocks();
                }
            } catch (error) {
                console.error('블럭 삭제 실패:', error);
                this.showToast('블럭 삭제에 실패했습니다.', 'danger');
            }
        }
    }


    showToast(message, type = 'info') {
        // 간단한 토스트 메시지
        const alertClass = type === 'success' ? 'alert-success' :
                          type === 'danger' ? 'alert-danger' : 'alert-info';

        const toast = document.createElement('div');
        toast.className = `alert ${alertClass} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
}

// DOM 로드 완료 시 콘텐츠 블럭 매니저 초기화
document.addEventListener('DOMContentLoaded', function() {
    window.blockManager = new ContentBlockManager({{ $page->id }});
});
</script>

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
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
@endpush
