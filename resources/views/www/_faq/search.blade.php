@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<!-- Page Header -->
<div class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">검색 결과</li>
                    </ol>
                </nav>
                <!-- Title -->
                <h1 class="fw-bold mb-3 display-5">FAQ 검색 결과</h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <p class="mb-0 text-muted">
                        <strong>"{{ $searchQuery }}"</strong>에 대한 검색 결과:
                        <span class="badge bg-primary ms-2">{{ $stats['total_results'] }}개 결과</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<section class="py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <!-- Search Form -->
                <form class="d-flex" action="{{ route('faq.search') }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control"
                               placeholder="다시 검색하기..." value="{{ $searchQuery }}">
                        <select name="category" class="form-select" style="max-width: 200px;">
                            <option value="">전체 카테고리</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->code }}" {{ $categoryFilter === $category->code ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" type="submit">검색</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('faq.index') }}" class="btn btn-outline-secondary">
                    전체 FAQ로 돌아가기
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
@if($searchResults->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">검색 결과</h3>
                    <small class="text-muted">
                        {{ $searchResults->firstItem() }}~{{ $searchResults->lastItem() }}개 (전체 {{ $searchResults->total() }}개)
                    </small>
                </div>
                @if($categoryFilter)
                <p class="text-muted small mb-0">
                    {{ $categories->firstWhere('code', $categoryFilter)->title ?? $categoryFilter }} 카테고리에서 검색
                </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="searchResultsAccordion">
                    @foreach($searchResults as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="searchHeading{{ $faq->id }}">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#searchCollapse{{ $faq->id }}"
                                    aria-expanded="false" aria-controls="searchCollapse{{ $faq->id }}">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <div class="flex-grow-1">
                                        <span class="fw-medium">
                                            {!! str_ireplace($searchQuery, '<mark class="bg-warning">'.$searchQuery.'</mark>', e($faq->question)) !!}
                                        </span>
                                        @if($faq->category_title)
                                        <small class="d-block text-muted mt-1">
                                            {{ $faq->category_title }}
                                        </small>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">조회 {{ number_format($faq->views ?? 0) }}</small>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="searchCollapse{{ $faq->id }}" class="accordion-collapse collapse"
                             aria-labelledby="searchHeading{{ $faq->id }}" data-bs-parent="#searchResultsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    {!! str_ireplace($searchQuery, '<mark class="bg-warning">'.$searchQuery.'</mark>', nl2br(e($faq->answer))) !!}
                                </div>

                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span>
                                        등록일: {{ \Carbon\Carbon::parse($faq->created_at)->format('Y년 m월 d일') }}
                                    </span>
                                    @if($faq->category_title)
                                    <a href="{{ route('faq.category', $faq->category) }}" class="text-decoration-none">
                                        {{ $faq->category_title }} 카테고리 보기
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($searchResults->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $searchResults->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@else
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="py-5">
                    <h5 class="text-muted">검색 결과가 없습니다</h5>
                    <p class="text-muted mb-4">
                        <strong>"{{ $searchQuery }}"</strong>에 대한 FAQ를 찾을 수 없습니다.<br>
                        다른 검색어로 다시 시도하거나 전체 FAQ를 확인해보세요.
                    </p>

                    <!-- Search Suggestions -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">검색 팁:</h6>
                        <ul class="list-unstyled text-muted small">
                            <li>• 다른 검색어로 시도해보세요</li>
                            <li>• 검색어를 줄여서 더 일반적인 용어를 사용해보세요</li>
                            <li>• 맞춤법을 확인해보세요</li>
                            <li>• 카테고리별로 찾아보세요</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('faq.index') }}" class="btn btn-primary">
                            전체 FAQ 보기
                        </a>
                        <button type="button" class="btn btn-outline-primary" onclick="document.querySelector('input[name=q]').focus();">
                            다시 검색하기
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Recommended FAQs (when results are limited) -->
@if($recommendedFaqs->count() > 0 && $searchResults->total() < 5)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-1">추천 FAQ</h3>
                <p class="text-muted mb-0">인기가 높은 다른 FAQ들을 확인해보세요</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row gy-3">
                    @foreach($recommendedFaqs as $faq)
                    <div class="col-lg-6 col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($faq->question, 60) }}</h6>
                                <p class="card-text text-muted small">
                                    {{ Str::limit(strip_tags($faq->answer), 100) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        조회 {{ number_format($faq->views ?? 0) }}회
                                    </small>
                                    <button class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#faqModal{{ $faq->id }}">
                                        자세히 보기
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Modal -->
                    <div class="modal fade" id="faqModal{{ $faq->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $faq->question }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Search Categories -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-1">카테고리별 찾아보기</h3>
                <p class="text-muted mb-0">원하는 분야의 FAQ를 찾아보세요</p>
            </div>
        </div>
        <div class="row gy-3">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-4 col-6">
                <a href="{{ route('faq.category', $category->code) }}" class="text-decoration-none">
                    <div class="card text-center h-100">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1">{{ $category->title }}</h6>
                            <small class="text-muted">
                                {{ DB::table('site_faq')->where('category', $category->code)->where('enable', true)->whereNull('deleted_at')->count() }}개 FAQ
                            </small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
