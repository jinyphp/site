@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Help 문서 - ' . $help->title)

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $help->title }}</h2>
                    <p class="text-muted mb-0">
                        Help 문서 상세 정보
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.help.docs.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                    <a href="{{ route('admin.cms.help.docs.edit', $help->id) }}" class="btn btn-primary">
                        <i class="fe fe-edit me-2"></i>수정
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 문서 내용 -->
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">문서 내용</h5>
                        <div>
                            @if($help->enable)
                                <span class="badge bg-success">게시됨</span>
                            @else
                                <span class="badge bg-secondary">비공개</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- 문서 내용 -->
                    <div class="help-content">
                        {!! nl2br($help->content) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- 사이드바 정보 -->
        <div class="col-xl-4 col-lg-12">
            <!-- 문서 정보 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">문서 정보</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $help->id }}</dd>

                        <dt class="col-sm-4">카테고리</dt>
                        <dd class="col-sm-8">
                            @if($help->category_title)
                                <span class="badge bg-light text-dark">{{ $help->category_title }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">조회수</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-info">{{ number_format($help->views) }}</span>
                        </dd>

                        <dt class="col-sm-4">상태</dt>
                        <dd class="col-sm-8">
                            @if($help->enable)
                                <span class="badge bg-success">게시됨</span>
                            @else
                                <span class="badge bg-secondary">비공개</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">생성일</dt>
                        <dd class="col-sm-8">
                            {{ $help->created_at ? \Carbon\Carbon::parse($help->created_at)->format('Y-m-d H:i') : '-' }}
                        </dd>

                        <dt class="col-sm-4">수정일</dt>
                        <dd class="col-sm-8">
                            {{ $help->updated_at ? \Carbon\Carbon::parse($help->updated_at)->format('Y-m-d H:i') : '-' }}
                        </dd>

                        @if(isset($help->order))
                        <dt class="col-sm-4">순서</dt>
                        <dd class="col-sm-8">{{ $help->order }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- 관리 작업 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">관리 작업</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.help.docs.edit', $help->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>문서 수정
                        </a>

                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="deleteHelp({{ $help->id }})">
                            <i class="fe fe-trash-2 me-2"></i>문서 삭제
                        </button>

                        <hr>

                        <a href="{{ route('admin.cms.help.docs.create') }}" class="btn btn-outline-primary">
                            <i class="fe fe-plus me-2"></i>새 문서 작성
                        </a>

                        <a href="{{ route('admin.cms.help.docs.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-list me-2"></i>문서 목록
                        </a>
                    </div>
                </div>
            </div>

            <!-- 관련 정보 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">도움말</h5>
                </div>
                <div class="card-body">
                    <h6>문서 관리 팁</h6>
                    <ul class="small text-muted">
                        <li>정기적으로 문서 내용을 업데이트하세요</li>
                        <li>사용자 피드백을 반영하여 개선하세요</li>
                        <li>관련 문서들을 연결해보세요</li>
                        <li>조회수가 높은 문서는 더 자세히 작성하세요</li>
                    </ul>

                    <hr>

                    <h6>문서 상태 안내</h6>
                    <ul class="small text-muted">
                        <li><span class="badge bg-success">게시됨</span> - 사용자에게 공개됨</li>
                        <li><span class="badge bg-secondary">비공개</span> - 관리자만 볼 수 있음</li>
                    </ul>
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
                <h5 class="modal-title">Help 문서 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 Help 문서를 삭제하시겠습니까?</p>
                <p class="text-warning small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    <strong>{{ $help->title }}</strong>
                </p>
                <p class="text-danger small">
                    <i class="fe fe-info me-1"></i>
                    삭제된 데이터는 복구할 수 있습니다.
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
.help-content {
    line-height: 1.8;
    font-size: 1rem;
}

.help-content h1,
.help-content h2,
.help-content h3,
.help-content h4,
.help-content h5,
.help-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.help-content h1 {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.help-content h2 {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 0.3rem;
}

.help-content p {
    margin-bottom: 1rem;
}

.help-content ul,
.help-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.help-content li {
    margin-bottom: 0.5rem;
}

.help-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.help-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin-bottom: 1rem;
}

.help-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
    color: #6c757d;
}

.help-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.help-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.help-content table th,
.help-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.help-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endpush

@push('scripts')
<script>
// 삭제 확인
function deleteHelp(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/cms/help/helps/${id}`;
    modal.show();
}

// 목차 자동 생성 (선택사항)
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.help-content');
    const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');

    if (headings.length > 3) {
        // 목차가 필요한 경우 자동 생성
        const toc = document.createElement('div');
        toc.className = 'card mb-4';
        toc.innerHTML = `
            <div class="card-header">
                <h6 class="mb-0">목차</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 toc-list"></ul>
            </div>
        `;

        const tocList = toc.querySelector('.toc-list');

        headings.forEach((heading, index) => {
            const id = `heading-${index}`;
            heading.id = id;

            const li = document.createElement('li');
            li.innerHTML = `
                <a href="#${id}" class="text-decoration-none text-muted small">
                    ${'&nbsp;'.repeat((parseInt(heading.tagName.charAt(1)) - 1) * 4)}
                    ${heading.textContent}
                </a>
            `;
            tocList.appendChild(li);
        });

        content.parentNode.insertBefore(toc, content);
    }
});
</script>
@endpush
