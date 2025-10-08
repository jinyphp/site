@extends('jiny-site::layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- 대시보드 헤더 -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary">게시판 센터</h1>
                <p class="lead text-muted">인기 게시글과 최신 소식을 한눈에 확인하세요</p>
            </div>

            <!-- 인기 게시글 섹션 -->
            <div class="row mb-5">
                <div class="col-lg-8">
                    <!-- 가장 인기있는 게시글 (큰 카드) -->
                    @if($popularPosts->isNotEmpty())
                        <div class="card border-0 shadow-lg mb-4 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="card-body text-white p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        <i class="bi bi-fire"></i> 최고 인기글
                                    </span>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        {{ $popularPosts->first()->board_title }}
                                    </span>
                                </div>
                                <h3 class="card-title fw-bold mb-3">
                                    <a href="{{ route('board.show', [$popularPosts->first()->board_code, $popularPosts->first()->id]) }}"
                                       class="text-white text-decoration-none">
                                        {{ $popularPosts->first()->title }}
                                    </a>
                                </h3>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <span><i class="bi bi-person-circle"></i> {{ $popularPosts->first()->name ?? '익명' }}</span>
                                        <span><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($popularPosts->first()->created_at)->format('Y-m-d') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-eye-fill"></i> {{ number_format($popularPosts->first()->click) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 인기 게시글 목록 -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="fw-bold d-flex align-items-center mb-0">
                                <i class="bi bi-fire text-danger me-2"></i>
                                인기 게시글
                            </h5>
                        </div>
                        <div class="card-body">
                            @forelse($popularPosts->skip(1) as $index => $post)
                                <div class="d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="me-3">
                                        <span class="badge bg-danger rounded-pill fs-6 px-3 py-2">{{ $index + 2 }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('board.show', [$post->board_code, $post->id]) }}"
                                               class="text-decoration-none text-dark fw-bold">
                                                {{ Str::limit($post->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <span class="badge bg-light text-dark me-2">{{ $post->board_title }}</span>
                                            {{ $post->name ?? '익명' }} • {{ \Carbon\Carbon::parse($post->created_at)->format('m/d') }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-eye-fill"></i> {{ number_format($post->click) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    인기 게시글이 없습니다.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 사이드바 -->
                <div class="col-lg-4">
                    <!-- 최신 게시글 -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="fw-bold d-flex align-items-center mb-0">
                                <i class="bi bi-clock text-success me-2"></i>
                                최신 게시글
                            </h5>
                        </div>
                        <div class="card-body">
                            @forelse($latestPosts->take(8) as $post)
                                <div class="d-flex align-items-start py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 small">
                                            <a href="{{ route('board.show', [$post->board_code, $post->id]) }}"
                                               class="text-decoration-none text-dark">
                                                {{ Str::limit($post->title, 35) }}
                                            </a>
                                        </h6>
                                        <div class="small text-muted">
                                            <span class="badge bg-light text-dark">{{ $post->board_title }}</span>
                                            {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted small">
                                    최신 게시글이 없습니다.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- 높은 평가 게시글 -->
                    @if($topRatedPosts->isNotEmpty())
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="fw-bold d-flex align-items-center mb-0">
                                    <i class="bi bi-star-fill text-warning me-2"></i>
                                    베스트 평가글
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach($topRatedPosts->take(5) as $post)
                                    <div class="d-flex align-items-start py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 small">
                                                <a href="{{ route('board.show', [$post->board_code, $post->id]) }}"
                                                   class="text-decoration-none text-dark">
                                                    {{ Str::limit($post->title, 35) }}
                                                </a>
                                            </h6>
                                            <div class="small text-muted d-flex justify-content-between align-items-center">
                                                <span class="badge bg-light text-dark">{{ $post->board_title }}</span>
                                                <div>
                                                    @if($post->like_count > 0)
                                                        <span class="text-danger me-1">
                                                            <i class="bi bi-heart-fill"></i> {{ $post->like_count }}
                                                        </span>
                                                    @endif
                                                    @if($post->rating_average > 0)
                                                        <span class="text-warning">
                                                            <i class="bi bi-star-fill"></i> {{ $post->rating_average }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 게시판 바로가기 -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold d-flex align-items-center mb-0">
                        <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>
                        게시판 바로가기
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($boards as $boardData)
                            @php
                                $board = $boardData['board'];
                                $canCreate = $boardData['canCreate'];
                                $totalPosts = $boardData['totalPosts'];
                            @endphp
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card border h-100 hover-card">
                                    <div class="card-body text-center p-4">
                                        <i class="bi bi-collection fs-1 text-primary mb-3"></i>
                                        <h6 class="card-title fw-bold">{{ $board->title }}</h6>
                                        @if($board->subtitle)
                                            <p class="card-text text-muted small mb-3">{{ $board->subtitle }}</p>
                                        @endif
                                        <div class="mb-3">
                                            <span class="badge bg-light text-dark">{{ number_format($totalPosts) }}개 게시글</span>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('board.index', $board->code) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-arrow-right"></i> 게시판 보기
                                            </a>
                                            @if($canCreate)
                                                <a href="{{ route('board.create', $board->code) }}"
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> 글쓰기
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <h4 class="text-muted">활성화된 게시판이 없습니다</h4>
                                    <p class="text-muted">관리자에게 문의하여 게시판을 활성화하세요.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 도움말 섹션 -->
            <div class="mt-5">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="bi bi-info-circle text-primary"></i> 게시판 이용 안내</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check2 text-success"></i> 누구나 게시글을 읽을 수 있습니다</li>
                                    <li class="mb-2"><i class="bi bi-check2 text-success"></i> 글 작성은 회원만 가능합니다</li>
                                    <li class="mb-2"><i class="bi bi-check2 text-success"></i> 본인이 작성한 글만 수정/삭제할 수 있습니다</li>
                                    <li class="mb-2"><i class="bi bi-check2 text-success"></i> 좋아요와 별점으로 글을 평가할 수 있습니다</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="bi bi-lightbulb text-warning"></i> 기능 안내</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-heart text-danger"></i> 좋아요: 마음에 드는 글에 좋아요를 눌러보세요</li>
                                    <li class="mb-2"><i class="bi bi-star text-warning"></i> 별점: 1-5점으로 글을 평가하세요</li>
                                    <li class="mb-2"><i class="bi bi-reply text-info"></i> 답글: 원글에 대한 답변을 작성하세요</li>
                                    <li class="mb-2"><i class="bi bi-chat-dots text-success"></i> 코멘트: 간단한 의견을 남겨보세요</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.badge {
    font-size: 0.75em;
}

.border-end {
    border-color: #e9ecef !important;
}
</style>
@endsection