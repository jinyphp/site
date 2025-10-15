@extends('jiny-site::layouts.app')

@section('title', $page->meta_title ?: $page->title)


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- 페이지 헤더 -->
            <div class="page-header mb-5">
                <div class="text-center">
                    <h1 class="page-title mb-3">{{ $page->title }}</h1>

                    @if($page->excerpt)
                    <p class="page-excerpt text-muted lead">{{ $page->excerpt }}</p>
                    @endif

                    <!-- 페이지 메타 정보 -->
                    <div class="page-meta text-muted small mb-4">
                        @if($page->published_at)
                        <span class="me-3">
                            <i class="fe fe-calendar"></i>
                            {{ $page->published_at->format('Y년 m월 d일') }}
                        </span>
                        @endif

                        @if($page->view_count > 0)
                        <span class="me-3">
                            <i class="fe fe-eye"></i>
                            조회 {{ number_format($page->view_count) }}
                        </span>
                        @endif

                        @if($page->getReadingTime() > 0)
                        <span>
                            <i class="fe fe-clock"></i>
                            {{ $page->getReadingTime() }}분 소요
                        </span>
                        @endif
                    </div>

                    @if($page->is_featured)
                    <div class="mb-4">
                        <span class="badge bg-warning text-dark">
                            <i class="fe fe-star"></i>
                            추천 페이지
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 페이지 콘텐츠 -->
            <div class="page-content">
                <div class="content-body">
                    {!! $page->content !!}
                </div>
            </div>

            <!-- 커스텀 필드 -->
            @if($page->custom_fields && count($page->custom_fields) > 0)
            <div class="page-custom-fields mt-5">
                <hr>
                <h5>추가 정보</h5>
                <div class="row">
                    @foreach($page->custom_fields as $key => $value)
                    <div class="col-md-6 mb-3">
                        <strong>{{ $key }}:</strong>
                        <span class="text-muted">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 페이지 푸터 -->
            <div class="page-footer mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-dates text-muted small">
                            @if($page->published_at)
                            <div>발행일: {{ $page->published_at->format('Y년 m월 d일 H:i') }}</div>
                            @endif
                            @if($page->updated_at->ne($page->created_at))
                            <div>수정일: {{ $page->updated_at->format('Y년 m월 d일 H:i') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <!-- 소셜 공유 버튼 -->
                        <div class="page-share">
                            <span class="text-muted small me-2">공유:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($page->url)) }}"
                               target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($page->url)) }}&text={{ urlencode($page->title) }}"
                               target="_blank" class="btn btn-sm btn-outline-info me-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url($page->url)) }}"
                               target="_blank" class="btn btn-sm btn-outline-dark me-1">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="copyToClipboard('{{ url($page->url) }}')">
                                <i class="fe fe-link"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 내비게이션 (이전/다음 페이지) -->
            @php
                $prevPage = \Jiny\Site\Models\SitePage::published()
                    ->where('sort_order', '<', $page->sort_order)
                    ->orderBy('sort_order', 'desc')
                    ->first();

                $nextPage = \Jiny\Site\Models\SitePage::published()
                    ->where('sort_order', '>', $page->sort_order)
                    ->orderBy('sort_order', 'asc')
                    ->first();
            @endphp

            @if($prevPage || $nextPage)
            <div class="page-navigation mt-5 pt-4 border-top">
                <div class="row">
                    @if($prevPage)
                    <div class="col-md-6">
                        <a href="{{ $prevPage->url }}" class="page-nav-link text-decoration-none">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-chevron-left me-2"></i>
                                <div>
                                    <div class="text-muted small">이전 페이지</div>
                                    <div class="fw-medium">{{ $prevPage->title }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif

                    @if($nextPage)
                    <div class="col-md-6 text-md-end">
                        <a href="{{ $nextPage->url }}" class="page-nav-link text-decoration-none">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="text-md-end">
                                    <div class="text-muted small">다음 페이지</div>
                                    <div class="fw-medium">{{ $nextPage->title }}</div>
                                </div>
                                <i class="fe fe-chevron-right ms-2"></i>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // 성공적으로 복사됨을 알리는 토스트 메시지 등을 표시할 수 있음
        alert('링크가 복사되었습니다.');
    }, function(err) {
        console.error('링크 복사 실패: ', err);
    });
}
</script>
@endpush

@push('styles')
<style>
.page-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.page-content h1,
.page-content h2,
.page-content h3,
.page-content h4,
.page-content h5,
.page-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.page-content p {
    margin-bottom: 1.5rem;
}

.page-nav-link:hover {
    color: var(--bs-primary) !important;
}

.page-share .btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush