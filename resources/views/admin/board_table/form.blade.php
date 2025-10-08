@extends('jiny-site::layouts.admin.sidebar')

@section('title', isset($item) ? '게시글 수정' : '게시글 등록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ isset($item) ? '게시글 수정' : '게시글 등록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.table') }}" class="btn btn-secondary">
                <i class="bi bi-list me-1"></i> 목록
            </a>
        </div>
    </div>

    <hr>

    <form action="{{ isset($item) ? route('admin.cms.board.table.update', $item->id) : route('admin.cms.board.table.store') }}"
          method="POST">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        <ul class="nav nav-tabs mb-3" id="tableTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                        data-bs-target="#basic" type="button" role="tab">
                    기본정보
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="author-tab" data-bs-toggle="tab"
                        data-bs-target="#author" type="button" role="tab">
                    작성자
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manage-tab" data-bs-toggle="tab"
                        data-bs-target="#manage" type="button" role="tab">
                    관리
                </button>
            </li>
        </ul>

        <div class="tab-content" id="tableTabContent">
            <!-- 기본정보 탭 -->
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">제목 <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" required
                                       value="{{ $item->title ?? '' }}" placeholder="게시글 제목">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">내용</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="content" rows="10">{{ $item->content ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 작성자 탭 -->
            <div class="tab-pane fade" id="author" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">이름</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name"
                                       value="{{ $item->name ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">이메일</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email"
                                       value="{{ $item->email ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 관리 탭 -->
            <div class="tab-pane fade" id="manage" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">조회수</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="click"
                                       value="{{ $item->click ?? 0 }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">좋아요</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="like"
                                       value="{{ $item->like ?? 0 }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.cms.board.table') }}" class="btn btn-secondary">취소</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> {{ isset($item) ? '수정' : '등록' }}
            </button>
        </div>
    </form>
</div>
@endsection
