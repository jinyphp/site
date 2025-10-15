@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

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
                    <a href="{{ route('admin.cms.help.docs.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 Help 문서
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-file-text text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 문서</h6>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">게시된 문서</h6>
                            <h4 class="mb-0">{{ $stats['published'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-edit text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">초안</h6>
                            <h4 class="mb-0">{{ $stats['draft'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-eye text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">총 조회수</h6>
                            <h4 class="mb-0">{{ number_format($stats['total_views']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cms.help.docs.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">검색</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="제목, 내용으로 검색..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">카테고리</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">전체 카테고리</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->code }}"
                                            {{ request('category') === $category->code ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="enable">상태</label>
                            <select id="enable" name="enable" class="form-control">
                                <option value="">전체</option>
                                <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>게시됨</option>
                                <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비공개</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                        <a href="{{ route('admin.cms.help.docs.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-refresh-cw me-1"></i>초기화
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Help 문서 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Help 문서 목록</h5>
        </div>
        <div class="card-body p-0">
            @if($guides->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>제목</th>
                                <th>카테고리</th>
                                <th width="100">조회수</th>
                                <th width="100">상태</th>
                                <th width="150">생성일</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guides as $guide)
                            <tr>
                                <td>{{ $guide->id }}</td>
                                <td>
                                    <a href="{{ route('admin.cms.help.docs.show', $guide->id) }}"
                                       class="text-decoration-none">
                                        <strong>{{ $guide->title }}</strong>
                                    </a>
                                    @if($guide->content)
                                        <br><small class="text-muted">{{ Str::limit(strip_tags($guide->content), 80) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($guide->category_title)
                                        <span class="badge bg-light text-dark">{{ $guide->category_title }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ number_format($guide->views) }}</span>
                                </td>
                                <td>
                                    @if($guide->enable)
                                        <span class="badge bg-success">게시됨</span>
                                    @else
                                        <span class="badge bg-secondary">비공개</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($guide->created_at)->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.cms.help.docs.show', $guide->id) }}"
                                           class="btn btn-outline-info"
                                           title="보기">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        @php
                                            $editParams = request()->only(['page', 'search', 'category', 'enable']);
                                            $editUrl = route('admin.cms.help.docs.edit', $guide->id);
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
                                                onclick="deleteGuide({{ $guide->id }})">
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
                            전체 {{ $guides->total() }}개 중
                            {{ $guides->firstItem() }}~{{ $guides->lastItem() }}개 표시
                        </div>
                        <div>
                            {{ $guides->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-file-text fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 Help 문서가 없습니다</h5>
                    <p class="text-muted">새 Help 문서를 생성해보세요.</p>
                    <a href="{{ route('admin.cms.help.docs.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 Help 문서 생성
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
                <h5 class="modal-title">Help 문서 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 Help 문서를 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
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
/* 통계 카드 원형 아이콘 스타일 */
.stat-circle {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px;
    min-height: 48px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.stat-circle i {
    font-size: 20px;
}
</style>
@endpush

@push('scripts')
<script>
// 삭제 확인
function deleteGuide(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/cms/help/docs/${id}`;
    modal.show();
}
</script>
@endpush
