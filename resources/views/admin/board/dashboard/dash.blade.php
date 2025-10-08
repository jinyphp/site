@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'Site Board Dashboard')

@section('content')
<div class="container-fluid">
    <!-- 페이지 헤더 -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <div>
            <h3>
                @if(isset($actions['title']))
                    {{$actions['title']}}
                @endif
            </h3>
            <p class="text-muted mb-0">
                @if(isset($actions['subtitle']))
                    {{$actions['subtitle']}}
                @endif
            </p>
        </div>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('admin.cms.board.list.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> 게시판 생성
            </a>
            <a href="{{ route('admin.cms.board.table.create') }}" class="btn btn-success">
                <i class="bi bi-pencil-square me-1"></i> 새 글 작성
            </a>
            <ol class="breadcrumb m-0 ms-3">
                <li class="breadcrumb-item">
                    <a href="/admin">Admin</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/cms">CMS</a>
                </li>
                <li class="breadcrumb-item active">
                    Board
                </li>
            </ol>
        </div>
    </div>

    <hr>

    <!-- 통계 카드 -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_boards'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">전체 게시판</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="bi bi-layout-text-sidebar fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.cms.board.list') }}" class="btn btn-sm btn-light">
                            관리 <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_posts'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">전체 게시글</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                            <i class="bi bi-file-text fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.cms.board.table') }}" class="btn btn-sm btn-light">
                            관리 <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['today_posts'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">오늘 작성된 글</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="bi bi-calendar-event fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-warning text-dark">Today</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_views'] ?? 0) }}</h4>
                            <p class="text-muted mb-0">전체 조회수</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="bi bi-eye fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-info">Views</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 최근 게시글 & 인기 게시글 -->
    <div class="row g-3 mb-4">
        <!-- 최근 게시글 -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history text-primary me-2"></i>
                            최근 게시글
                        </h5>
                        <a href="{{ route('admin.cms.board.table') }}" class="btn btn-sm btn-outline-primary">
                            전체보기
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($recent_posts) && $recent_posts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_posts as $post)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $post->title }}</h6>
                                            <p class="mb-1 text-muted small">
                                                {{ Str::limit($post->content ?? '', 50) }}
                                            </p>
                                            <small class="text-muted">
                                                <i class="bi bi-person"></i> {{ $post->name ?? '익명' }}
                                                <i class="bi bi-clock ms-2"></i> {{ $post->created_at }}
                                            </small>
                                        </div>
                                        <div class="ms-3">
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-eye"></i> {{ $post->click ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            최근 게시글이 없습니다.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 인기 게시글 -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-fire text-danger me-2"></i>
                            인기 게시글
                        </h5>
                        <a href="{{ route('admin.cms.board.table') }}" class="btn btn-sm btn-outline-danger">
                            전체보기
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($popular_posts) && $popular_posts->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($popular_posts as $index => $post)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-start flex-grow-1">
                                            <span class="badge bg-danger me-2">{{ $index + 1 }}</span>
                                            <div>
                                                <h6 class="mb-1">{{ $post->title }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    {{ Str::limit($post->content ?? '', 50) }}
                                                </p>
                                                <small class="text-muted">
                                                    <i class="bi bi-person"></i> {{ $post->name ?? '익명' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <span class="badge bg-danger">
                                                <i class="bi bi-eye"></i> {{ number_format($post->click ?? 0) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            인기 게시글이 없습니다.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 게시판별 통계 -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart text-success me-2"></i>
                            게시판별 통계
                        </h5>
                        <a href="{{ route('admin.cms.board.list') }}" class="btn btn-sm btn-outline-success">
                            게시판 관리
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($board_stats) && $board_stats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>게시판명</th>
                                        <th>Slug</th>
                                        <th width="150" class="text-center">게시글 수</th>
                                        <th width="100" class="text-center">상태</th>
                                        <th width="200" class="text-center">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($board_stats as $board)
                                        <tr>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.cms.board.posts', $board->code) }}" class="text-decoration-none">
                                                        <strong>{{ $board->title }}</strong>
                                                    </a>
                                                </div>
                                                <small class="text-muted">{{ $board->subtitle }}</small>
                                            </td>
                                            <td>
                                                <code>{{ $board->slug ?? '-' }}</code>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">
                                                    {{ $board->post_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($board->enable)
                                                    <span class="badge bg-success">활성</span>
                                                @else
                                                    <span class="badge bg-secondary">비활성</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.cms.board.list.edit', $board->id) }}"
                                                       class="btn btn-outline-primary" title="수정">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.board.posts', $board->code) }}"
                                                       class="btn btn-outline-success" title="게시글 관리">
                                                        <i class="bi bi-file-text"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <p class="mb-3">등록된 게시판이 없습니다.</p>
                            <a href="{{ route('admin.cms.board.list.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> 게시판 생성
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 추가 통계 카드 -->
    <div class="row g-3 mt-3">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <i class="bi bi-link-45deg fs-1 text-primary mb-2"></i>
                    <h4 class="mb-0">{{ $stats['total_related'] ?? 0 }}</h4>
                    <p class="text-muted mb-2">관련글</p>
                    <a href="{{ route('admin.cms.board.related') }}" class="btn btn-sm btn-outline-primary">
                        관리하기
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow fs-1 text-success mb-2"></i>
                    <h4 class="mb-0">{{ $stats['total_trend'] ?? 0 }}</h4>
                    <p class="text-muted mb-2">트렌드글</p>
                    <a href="{{ route('admin.cms.board.trend') }}" class="btn btn-sm btn-outline-success">
                        관리하기
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <i class="bi bi-collection fs-1 text-info mb-2"></i>
                    <h4 class="mb-0">{{ ($stats['total_boards'] ?? 0) + ($stats['total_posts'] ?? 0) }}</h4>
                    <p class="text-muted mb-2">전체 항목</p>
                    <span class="badge bg-info">Total Items</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.icon-shape {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
}
.bg-light-primary {
    background-color: rgba(13, 110, 253, 0.1);
}
.bg-light-success {
    background-color: rgba(25, 135, 84, 0.1);
}
.bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1);
}
.bg-light-info {
    background-color: rgba(13, 202, 240, 0.1);
}
</style>
@endpush
@endsection
