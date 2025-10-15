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
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                    </ol>
                </nav>
                <!-- Title -->
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div>
                        <h1 class="fw-bold mb-1 display-5">{{ $category->title }}</h1>
                        @if($category->content)
                        <p class="mb-0 text-muted">{{ $category->content }}</p>
                        @endif
                        <small class="text-muted">총 {{ $stats['total'] }}개의 FAQ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<section class="py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <!-- Search Form -->
                <form class="d-flex" action="{{ route('faq.category', $category->code) }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control"
                               placeholder="이 카테고리에서 검색..." value="{{ $searchQuery ?? '' }}">
                        <button class="btn btn-outline-primary" type="submit">검색</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('faq.index') }}" class="btn btn-outline-secondary">
                    전체 FAQ로 돌아가기
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Category Navigation -->
@if($categories->count() > 1)
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6 class="mb-3">다른 카테고리</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                    <a href="{{ route('faq.category', $cat->code) }}"
                       class="btn {{ $cat->code === $category->code ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm">
                        {{ $cat->title }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- FAQ List -->
@if($faqs->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="categoryFAQAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="categoryHeading{{ $faq->id }}">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#categoryCollapse{{ $faq->id }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="categoryCollapse{{ $faq->id }}">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <span class="fw-medium">{{ $faq->question }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">조회 {{ number_format($faq->views ?? 0) }}</small>
                                        @if($faq->order)
                                        <span class="badge bg-light text-dark">#{{ $faq->order }}</span>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="categoryCollapse{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                             aria-labelledby="categoryHeading{{ $faq->id }}" data-bs-parent="#categoryFAQAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>

                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span>
                                        등록일: {{ \Carbon\Carbon::parse($faq->created_at)->format('Y년 m월 d일') }}
                                    </span>
                                    @if($faq->updated_at && $faq->updated_at !== $faq->created_at)
                                    <span>
                                        수정일: {{ \Carbon\Carbon::parse($faq->updated_at)->format('Y.m.d') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($faqs->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $faqs->appends(request()->query())->links() }}
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
                    @if($searchQuery)
                    <h5 class="text-muted">검색 결과가 없습니다</h5>
                    <p class="text-muted">"{{ $searchQuery }}"에 대한 FAQ를 찾을 수 없습니다.</p>
                    <a href="{{ route('faq.category', $category->code) }}" class="btn btn-primary">
                        전체 {{ $category->title }} FAQ 보기
                    </a>
                    @else
                    <h5 class="text-muted">이 카테고리에 FAQ가 없습니다</h5>
                    <p class="text-muted">곧 유용한 FAQ가 추가될 예정입니다.</p>
                    <a href="{{ route('faq.index') }}" class="btn btn-primary">
                        전체 FAQ 보기
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Related Categories -->
@if($relatedCategories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-1">다른 카테고리 확인하기</h3>
                <p class="text-muted mb-0">관련된 다른 분야의 FAQ도 확인해보세요</p>
            </div>
        </div>
        <div class="row gy-3">
            @foreach($relatedCategories as $relatedCategory)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-2">
                            <h6 class="mb-0">{{ $relatedCategory->title }}</h6>
                        </div>
                        @if($relatedCategory->content)
                        <p class="text-muted small mb-3">{{ Str::limit($relatedCategory->content, 80) }}</p>
                        @endif
                        <a href="{{ route('faq.category', $relatedCategory->code) }}" class="btn btn-outline-primary btn-sm">
                            보기
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
