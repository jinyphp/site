@extends('jiny-site::layouts.admin.sidebar')

@section('title', $config['title'] ?? '게시글 목록')

@section('content')
<section class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column gap-1">
                    <h1 class="mb-0 h2 fw-bold">
                        {{ $board->title }}
                        <span class="fs-5">(총 {{ $rows->total() }}개)</span>
                    </h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin/cms">CMS</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.board.list') }}">게시판</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $board->title }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.cms.board.list') }}" class="btn btn-secondary">
                        <i class="fe fe-list me-2"></i>
                        게시판 목록
                    </a>
                    <a href="{{ route('admin.cms.board.posts.create', $code) }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>
                        새 글 작성
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 게시판 정보 카드 -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card bg-white">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fe fe-message-square text-primary fs-4"></i>
                                <div>
                                    <h5 class="mb-0">{{ $board->subtitle }}</h5>
                                    <small class="text-muted">코드: <code>{{ $code }}</code></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($board->enable)
                                <span class="badge bg-success-soft text-success">활성</span>
                            @else
                                <span class="badge bg-secondary-soft text-secondary">비활성</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card">
                <!-- Card Header -->
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.cms.board.posts', $code) }}">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="search"
                                       name="search"
                                       class="form-control"
                                       placeholder="제목 또는 내용 검색..."
                                       value="{{ request('search') }}" />
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fe fe-search"></i> 검색
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table mb-0 text-nowrap table-hover table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>제목</th>
                                <th>작성자</th>
                                <th class="text-center">조회수</th>
                                <th class="text-center">좋아요</th>
                                <th>작성일</th>
                                <th>작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.cms.board.posts.edit', [$code, $item->id]) }}" class="text-decoration-none text-dark">
                                            @if(isset($item->level) && $item->level > 0)
                                                <span style="margin-left: {{ $item->level * 20 }}px;">
                                                    <i class="fe fe-corner-down-right text-muted"></i>
                                                </span>
                                            @endif
                                            <h5 class="mb-0 d-inline">{{ $item->title ?? '-' }}</h5>
                                            @if(isset($item->level) && $item->level > 0)
                                                <span class="badge bg-success-soft text-success ms-2">하위글 Lv.{{ $item->level }}</span>
                                            @endif
                                            @if(isset($childCounts[$item->id]) && $childCounts[$item->id] > 0)
                                                <span class="badge bg-primary-soft text-primary ms-2">
                                                    <i class="fe fe-message-circle"></i> {{ $childCounts[$item->id] }}
                                                </span>
                                            @endif
                                        </a>
                                        @if(isset($item->categories) && $item->categories)
                                            <span class="badge bg-info-soft text-info">{{ $item->categories }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $item->name ?? '-' }}</div>
                                        @if(isset($item->email) && $item->email)
                                            <small class="text-muted">{{ $item->email }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ $item->click ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            {{ $item->like ?? 0 }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="hstack gap-2">
                                            <a href="{{ route('admin.cms.board.posts.edit', [$code, $item->id]) }}"
                                               class="btn btn-sm btn-light"
                                               data-bs-toggle="tooltip"
                                               title="편집">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.cms.board.posts.destroy', [$code, $item->id]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-light text-danger"
                                                        data-bs-toggle="tooltip"
                                                        title="삭제">
                                                    <i class="fe fe-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <p class="mb-0">등록된 게시글이 없습니다.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($rows->hasPages())
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="text-muted">
                                총 {{ $rows->total() }}개 중
                                {{ $rows->firstItem() }}-{{ $rows->lastItem() }}개 표시
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                {{ $rows->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endpush
