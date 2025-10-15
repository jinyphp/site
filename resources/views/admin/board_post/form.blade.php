@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', isset($item) ? '글 수정' : '새 글 작성')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ $config['title'] ?? (isset($item) ? '글 수정' : '새 글 작성') }}</h3>
            <p class="text-muted mb-0">{{ $board->title }} - {{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div class="d-flex gap-2">
            @if(isset($item))
            <a href="{{ route('admin.cms.board.posts.child.create', [$code, $item->id]) }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> 하위 글 작성
            </a>
            @endif
            <a href="{{ route('admin.cms.board.posts', $code) }}" class="btn btn-secondary">
                <i class="bi bi-list me-1"></i> 목록
            </a>
        </div>
    </div>

    <hr>

    <form action="{{ isset($item) ? route('admin.cms.board.posts.update', [$code, $item->id]) : route('admin.cms.board.posts.store', $code) }}"
          method="POST">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif
        @if(isset($parent))
            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
        @endif

        <ul class="nav nav-tabs mb-0" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab"
                        data-bs-target="#basic" type="button" role="tab">
                    기본정보
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#extra" type="button" role="tab">
                    추가정보
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#meta" type="button" role="tab">
                    메타정보
                </button>
            </li>
        </ul>

        <div class="card border-top-0 rounded-top-0 mt-0">
            <div class="tab-content">
                <!-- 기본정보 탭 -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="slug"
                                       value="{{ $item->slug ?? '' }}">
                                <small class="text-muted">URL에 사용될 고유 식별자입니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">제목 *</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title"
                                       value="{{ $item->title ?? '' }}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">내용</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="content" rows="15">{{ $item->content ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 추가정보 탭 -->
                <div class="tab-pane fade" id="extra" role="tabpanel">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">카테고리</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="categories"
                                       value="{{ $item->categories ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">작성자명</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name"
                                       value="{{ $item->name ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">작성자 이메일</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email"
                                       value="{{ $item->email ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">대표 이미지 URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="image"
                                       value="{{ $item->image ?? '' }}">
                                <small class="text-muted">이미지 URL을 입력하세요.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 메타정보 탭 -->
                <div class="tab-pane fade" id="meta" role="tabpanel">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">키워드</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keyword"
                                       value="{{ $item->keyword ?? '' }}">
                                <small class="text-muted">쉼표로 구분하여 입력하세요.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">태그</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="tags"
                                       value="{{ $item->tags ?? '' }}">
                                <small class="text-muted">쉼표로 구분하여 입력하세요.</small>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">조회수</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="click"
                                       value="{{ $item->click ?? 0 }}" min="0">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">좋아요</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="like"
                                       value="{{ $item->like ?? 0 }}" min="0">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">랭크</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="rank"
                                       value="{{ $item->rank ?? 0 }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.cms.board.posts', $code) }}" class="btn btn-secondary">취소</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> {{ isset($item) ? '수정' : '등록' }}
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
.nav-tabs {
    border-bottom: 0;
    margin-bottom: 0;
}
.nav-tabs .nav-link {
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 0.375rem 0.375rem 0 0;
    color: #6c757d;
}
.nav-tabs .nav-link:hover {
    border-color: transparent;
    background-color: #f8f9fa;
    color: #495057;
}
.nav-tabs .nav-link.active {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-bottom-color: #fff;
    color: #495057;
}
.card.border-top-0 {
    border-top: 1px solid #dee2e6;
}
</style>
@endpush
@endsection
