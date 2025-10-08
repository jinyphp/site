@extends('jiny-site::layouts.admin.sidebar')

@section('title', isset($item) ? '관련글 수정' : '관련글 등록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ isset($item) ? '관련글 수정' : '관련글 등록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.related') }}" class="btn btn-secondary">
                <i class="bi bi-list me-1"></i> 목록
            </a>
        </div>
    </div>

    <hr>

    <form action="{{ isset($item) ? route('admin.cms.board.related.update', $item->id) : route('admin.cms.board.related.store') }}"
          method="POST">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab"
                        data-bs-target="#basic" type="button" role="tab">
                    기본정보
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#manage" type="button" role="tab">
                    관리
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">활성화</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enable"
                                           value="1" {{ (isset($item) && $item->enable) ? 'checked' : '' }}>
                                    <label class="form-check-label">활성화</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">코드</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code"
                                       value="{{ $item->code ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Post ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="post_id"
                                       value="{{ $item->post_id ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Related</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="related"
                                       value="{{ $item->related ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Related ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="related_id"
                                       value="{{ $item->related_id ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="manage" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">담당자</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="manager"
                                       value="{{ $item->manager ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.cms.board.related') }}" class="btn btn-secondary">취소</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> {{ isset($item) ? '수정' : '등록' }}
            </button>
        </div>
    </form>
</div>
@endsection
