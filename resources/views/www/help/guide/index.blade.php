@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

    @includeIf("jiny-site::www.help.partials.hero_guide")

<!-- Breadcrumb -->
<div class="pt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/help') }}" class="text-decoration-none">Help Center</a></li>
                        <li class="breadcrumb-item active" aria-current="page">가이드 & 자료</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section id="guides" class="py-8">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($categories && $categories->count() > 0)
                <div class="row gy-4">
                    @foreach($categories as $category)
                    <div class="col-lg-6 col-12">
                        <!-- Guide Category Card -->
                        <div class="card border h-100">
                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column gap-5 p-5">
                                <div class="d-flex flex-column gap-2">
                                    <h2 class="fw-semibold mb-0">{{ $category->title }}</h2>
                                    @if($category->content)
                                    <p class="mb-0">{{ $category->content }}</p>
                                    @endif
                                </div>

                                <!-- Guide List -->
                                @if($category->guides && $category->guides->count() > 0)
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                                    @foreach($category->guides as $guide)
                                    <li>
                                        <a href="{{ url('/help/guide/' . $guide->id) }}" class="text-body d-flex flex-row gap-2 text-decoration-none">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                                </svg>
                                            </span>
                                            <span>{{ $guide->title }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <div class="text-muted">
                                    <small>아직 가이드가 없습니다.</small>
                                </div>
                                @endif
                            </div>
                            <!-- Card Footer -->
                            <div class="card-footer">
                                <a href="{{ url('/help/guide/category/' . $category->code) }}" class="link-primary text-decoration-none">
                                    {{ $category->guide_count ?? 0 }}개 가이드
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <h3>가이드 카테고리가 없습니다</h3>
                    <p class="text-muted">아직 등록된 가이드 카테고리가 없습니다.</p>
                    <a href="{{ url('/help') }}" class="btn btn-primary">도움말 센터로 돌아가기</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Popular Guides Section -->
@if(isset($popularGuides) && $popularGuides->count() > 0)
<section class="py-8 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    <h3 class="mb-1">인기 가이드</h3>
                    <p class="text-muted mb-0">가장 많이 조회된 가이드들을 확인해보세요</p>
                </div>
                <div class="row gy-3">
                    @foreach($popularGuides as $guide)
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ url('/help/guide/' . $guide->id) }}" class="text-decoration-none">
                                        {{ $guide->title }}
                                    </a>
                                </h6>
                                @if($guide->summary)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($guide->summary, 100) }}
                                </p>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        조회 {{ number_format($guide->views ?? 0) }}회
                                    </small>
                                    <a href="{{ url('/help/guide/' . $guide->id) }}" class="btn btn-outline-primary btn-sm">
                                        읽기
                                    </a>
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
@endsection
