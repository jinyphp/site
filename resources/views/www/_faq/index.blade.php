@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">자주 묻는 질문2</h1>
                <p class="lead text-muted">궁금한 사항에 대한 FAQ를 확인하세요</p>

                <!-- Search Form -->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-6">
                        <form action="{{ route('faq.search') }}" method="GET">
                            <div class="input-group">
                                <input type="search" name="q" class="form-control" placeholder="검색어를 입력하세요" value="{{ $searchQuery ?? '' }}">
                                <button class="btn btn-primary" type="submit">검색</button>
                            </div>
                        </form>
                    </div>
                </div>

                <p class="text-muted mt-3">총 {{ $stats['total'] }}개의 FAQ가 있습니다</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $stats['total'] }}</h3>
                        <p class="mb-0">전체 FAQ</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $stats['categories'] }}</h3>
                        <p class="mb-0">카테고리</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">FAQ 카테고리</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->title }}</h5>
                        @if($category->content)
                        <p class="card-text text-muted">{{ Str::limit($category->content, 100) }}</p>
                        @endif
                        <a href="{{ route('faq.category', $category->code) }}" class="btn btn-outline-primary">카테고리 보기</a>
                        <small class="text-muted d-block mt-2">
                            {{ DB::table('site_faq')->where('category', $category->code)->where('enable', true)->whereNull('deleted_at')->count() }}개 FAQ
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Popular FAQs -->
@if($popularFaqs->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">인기 FAQ</h2>
        <div class="accordion" id="popularFAQAccordion">
            @foreach($popularFaqs as $index => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $faq->id }}">
                        {{ $faq->question }}
                        <small class="text-muted ms-auto">조회 {{ number_format($faq->views ?? 0) }}</small>
                    </button>
                </h2>
                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                     aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#popularFAQAccordion">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All FAQs -->
@if($faqs->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>전체 FAQ</h2>
            <!-- Category Filter -->
            <form method="GET" action="{{ route('faq.index') }}">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">전체 카테고리</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->code }}" {{ $currentCategory === $category->code ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                    @endforeach
                </select>
                @if($searchQuery)
                <input type="hidden" name="search" value="{{ $searchQuery }}">
                @endif
            </form>
        </div>

        <div class="accordion" id="faqAccordion">
            @foreach($faqs as $index => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading{{ $faq->id }}">
                    <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}"
                            aria-expanded="false" aria-controls="faqCollapse{{ $faq->id }}">
                        {{ $faq->question }}
                        <div class="ms-auto">
                            @if($faq->category_title)
                            <small class="badge bg-secondary me-2">{{ $faq->category_title }}</small>
                            @endif
                            <small class="text-muted">{{ number_format($faq->views ?? 0) }}회</small>
                        </div>
                    </button>
                </h2>
                <div id="faqCollapse{{ $faq->id }}" class="accordion-collapse collapse"
                     aria-labelledby="faqHeading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->answer)) !!}
                        <div class="text-muted small mt-3">
                            등록일: {{ \Carbon\Carbon::parse($faq->created_at)->format('Y.m.d') }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($faqs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $faqs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</section>
@else
<section class="py-5">
    <div class="container text-center">
        <h5 class="text-muted">등록된 FAQ가 없습니다</h5>
        <p class="text-muted">곧 유용한 FAQ가 추가될 예정입니다.</p>
    </div>
</section>
@endif
@endsection
