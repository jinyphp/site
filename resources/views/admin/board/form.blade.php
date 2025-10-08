@extends('jiny-site::layouts.admin.sidebar')

@section('title', isset($item) ? '게시판 수정' : '게시판 등록')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>{{ isset($item) ? '게시판 수정' : '게시판 등록' }}</h3>
            <p class="text-muted mb-0">{{ $config['subtitle'] ?? '' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.board.list') }}" class="btn btn-secondary">
                <i class="bi bi-list me-1"></i> 목록
            </a>
        </div>
    </div>

    <hr>

    <form action="{{ isset($item) ? route('admin.cms.board.list.update', $item->id) : route('admin.cms.board.list.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($item))
            @method('PUT')
        @endif

        <ul class="nav nav-tabs mb-3" id="boardTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                        data-bs-target="#basic" type="button" role="tab">
                    기본정보
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="list-tab" data-bs-toggle="tab"
                        data-bs-target="#list" type="button" role="tab">
                    게시물목록
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="display-tab" data-bs-toggle="tab"
                        data-bs-target="#display" type="button" role="tab">
                    화면
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manage-tab" data-bs-toggle="tab"
                        data-bs-target="#manage" type="button" role="tab">
                    관리
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="memo-tab" data-bs-toggle="tab"
                        data-bs-target="#memo" type="button" role="tab">
                    메모
                </button>
            </li>
        </ul>

        <div class="tab-content" id="boardTabContent">
            <!-- 기본정보 탭 -->
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">활성화</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enable"
                                           value="1" {{ (isset($item) && $item->enable) ? 'checked' : '' }}>
                                    <label class="form-check-label">게시판 활성화</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="slug"
                                       value="{{ $item->slug ?? '' }}" placeholder="URL 주소">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">제목 <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" required
                                       value="{{ $item->title ?? '' }}" placeholder="게시판 제목">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">이미지</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="image" accept="image/*">
                                @if(isset($item->image))
                                    <div class="mt-2">
                                        <small class="text-muted">현재 이미지: {{ $item->image }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">부제목</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="subtitle" rows="3">{{ $item->subtitle ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 게시물목록 탭 -->
            <div class="tab-pane fade" id="list" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">페이지당 게시물 수</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="per_page">
                                    <option value="5" {{ (isset($item) && $item->per_page == 5) ? 'selected' : '' }}>5개씩 보기</option>
                                    <option value="10" {{ (!isset($item) || $item->per_page == 10) ? 'selected' : '' }}>10개씩 보기 (기본값)</option>
                                    <option value="20" {{ (isset($item) && $item->per_page == 20) ? 'selected' : '' }}>20개씩 보기</option>
                                    <option value="50" {{ (isset($item) && $item->per_page == 50) ? 'selected' : '' }}>50개씩 보기</option>
                                    <option value="100" {{ (isset($item) && $item->per_page == 100) ? 'selected' : '' }}>100개씩 보기</option>
                                </select>
                                <small class="text-muted">게시판 목록에서 페이지당 표시할 기본 게시물 수를 설정합니다.</small>
                            </div>
                        </div>

                        <h5 class="mb-3">권한 설정</h5>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글보기 권한</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="permit_read">
                                    <option value="public" {{ (!isset($item) || $item->permit_read == 'public') ? 'selected' : '' }}>모든 사용자</option>
                                    <option value="member" {{ (isset($item) && $item->permit_read == 'member') ? 'selected' : '' }}>로그인 사용자만</option>
                                    <option value="grade" {{ (isset($item) && $item->permit_read == 'grade') ? 'selected' : '' }}>특정 회원 등급</option>
                                </select>
                                <small class="text-muted">게시글을 볼 수 있는 권한을 설정합니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글쓰기 권한</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="permit_create">
                                    <option value="public" {{ (isset($item) && $item->permit_create == 'public') ? 'selected' : '' }}>모든 사용자</option>
                                    <option value="member" {{ (!isset($item) || $item->permit_create == 'member') ? 'selected' : '' }}>로그인 사용자만</option>
                                    <option value="grade" {{ (isset($item) && $item->permit_create == 'grade') ? 'selected' : '' }}>특정 회원 등급</option>
                                    <option value="none" {{ (isset($item) && $item->permit_create == 'none') ? 'selected' : '' }}>허용안함</option>
                                </select>
                                <small class="text-muted">새 글을 작성할 수 있는 권한을 설정합니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글수정 권한</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="permit_edit">
                                    <option value="owner" {{ (!isset($item) || $item->permit_edit == 'owner') ? 'selected' : '' }}>작성자만</option>
                                    <option value="member" {{ (isset($item) && $item->permit_edit == 'member') ? 'selected' : '' }}>로그인 사용자</option>
                                    <option value="grade" {{ (isset($item) && $item->permit_edit == 'grade') ? 'selected' : '' }}>특정 회원 등급</option>
                                    <option value="admin" {{ (isset($item) && $item->permit_edit == 'admin') ? 'selected' : '' }}>관리자만</option>
                                </select>
                                <small class="text-muted">게시글을 수정할 수 있는 권한을 설정합니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글삭제 권한</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="permit_delete">
                                    <option value="owner" {{ (!isset($item) || $item->permit_delete == 'owner') ? 'selected' : '' }}>작성자만</option>
                                    <option value="member" {{ (isset($item) && $item->permit_delete == 'member') ? 'selected' : '' }}>로그인 사용자</option>
                                    <option value="grade" {{ (isset($item) && $item->permit_delete == 'grade') ? 'selected' : '' }}>특정 회원 등급</option>
                                    <option value="admin" {{ (isset($item) && $item->permit_delete == 'admin') ? 'selected' : '' }}>관리자만</option>
                                </select>
                                <small class="text-muted">게시글을 삭제할 수 있는 권한을 설정합니다. Admin/Super 회원은 항상 삭제 가능합니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">테이블 Blade</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_table"
                                       value="{{ $item->view_table ?? '' }}" placeholder="예: jiny-site::board.table">
                                <small class="text-muted">계시물의 테이블 목록을 수정합니다.</small>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">리스트 Blade</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_list"
                                       value="{{ $item->view_list ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">필터 Blade</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_filter"
                                       value="{{ $item->view_filter ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 화면 탭 -->
            <div class="tab-pane fade" id="display" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">레이아웃</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_layout"
                                       value="{{ $item->view_layout ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글작성</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_create"
                                       value="{{ $item->view_create ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">글보기</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_detail"
                                       value="{{ $item->view_detail ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">수정</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_edit"
                                       value="{{ $item->view_edit ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">폼양식</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="view_form"
                                       value="{{ $item->view_form ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Header</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="header" rows="3">{{ $item->header ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Footer</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="footer" rows="3">{{ $item->footer ?? '' }}</textarea>
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
                            <label class="col-sm-2 col-form-label">담당자</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="manager"
                                       value="{{ $item->manager ?? '' }}" placeholder="담당자 이름">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 메모 탭 -->
            <div class="tab-pane fade" id="memo" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">설명</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="5">{{ $item->description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.cms.board.list') }}" class="btn btn-secondary">취소</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> {{ isset($item) ? '수정' : '등록' }}
            </button>
        </div>
    </form>
</div>
@endsection
