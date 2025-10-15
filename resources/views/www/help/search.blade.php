@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<div class="py-8 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- breadcrumb  -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/help') }}">도움말 센터</a></li>
                        <li class="breadcrumb-item active" aria-current="page">검색</li>
                    </ol>
                </nav>
                <!-- caption-->
                <h1 class="fw-bold mb-3 display-5">도움말 검색</h1>
            </div>
        </div>
    </div>
</div>

<section class="py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <!-- 검색 폼 -->
                <div class="card mb-6">
                    <div class="card-body">
                        <form action="{{ url('/help/search') }}" method="GET">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="searchQuery" class="form-label">검색어</label>
                                        <div class="position-relative">
                                            <span class="position-absolute top-50 start-0 translate-middle-y ps-3">
                                                <i class="fe fe-search"></i>
                                            </span>
                                            <input type="text" id="searchQuery" name="q" class="form-control ps-6" value="{{ $query }}" placeholder="검색할 내용을 입력하세요">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="searchCategory" class="form-label">카테고리</label>
                                        <select id="searchCategory" name="category" class="form-select">
                                            <option value="">전체 카테고리</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->code }}" {{ $selectedCategory === $category->code ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-search me-2"></i>
                                검색
                            </button>
                        </form>
                    </div>
                </div>

                <!-- 검색 결과 -->
                @if($query)
                <div class="mb-4">
                    <h3>
                        "{{ $query }}" 검색 결과
                        @if($selectedCategory)
                        - {{ $categories->where('code', $selectedCategory)->first()->title ?? $selectedCategory }}
                        @endif
                    </h3>
                    @if($helps && $helps->count() > 0)
                    <p class="text-muted">{{ $helps->total() }}개의 결과를 찾았습니다.</p>
                    @else
                    <p class="text-muted">검색 결과가 없습니다.</p>
                    @endif
                </div>

                @if($helps && $helps->count() > 0)
                <!-- 검색 결과 목록 -->
                <div class="list-group mb-6">
                    @foreach($helps as $help)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                <a href="{{ url('/help/' . $help->id) }}" class="text-inherit">{{ $help->title }}</a>
                            </h5>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($help->created_at)->format('Y.m.d') }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit(strip_tags($help->content), 200) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($help->cate)
                                <span class="badge bg-secondary">{{ $help->cate }}</span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="fe fe-thumbs-up me-1"></i>
                                {{ $help->like }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- 페이지네이션 -->
                {{ $helps->links() }}
                @else
                @if($query)
                <!-- 검색 결과가 없을 때 -->
                <div class="text-center py-8">
                    <i class="fe fe-search display-1 text-muted mb-3"></i>
                    <h3>검색 결과가 없습니다</h3>
                    <p class="text-muted">다른 검색어로 시도해보거나 카테고리를 변경해보세요.</p>
                    <div class="mt-4">
                        <a href="{{ url('/help') }}" class="btn btn-primary me-2">도움말 센터 홈</a>
                        <a href="{{ url('/help/faq') }}" class="btn btn-outline-primary">자주 묻는 질문</a>
                    </div>
                </div>
                @endif
                @endif
                @else
                <!-- 검색 안내 -->
                <div class="text-center py-8">
                    <i class="fe fe-search display-1 text-muted mb-3"></i>
                    <h3>도움말 검색</h3>
                    <p class="text-muted">궁금한 내용을 검색어로 입력하여 관련 도움말을 찾아보세요.</p>
                </div>
                @endif
            </div>

            <!-- 사이드바 -->
            <div class="col-lg-4 col-12">
                <!-- 인기 검색어 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">인기 검색어</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ url('/help/search?q=로그인') }}" class="badge bg-light text-dark text-decoration-none">로그인</a>
                            <a href="{{ url('/help/search?q=회원가입') }}" class="badge bg-light text-dark text-decoration-none">회원가입</a>
                            <a href="{{ url('/help/search?q=비밀번호') }}" class="badge bg-light text-dark text-decoration-none">비밀번호</a>
                            <a href="{{ url('/help/search?q=결제') }}" class="badge bg-light text-dark text-decoration-none">결제</a>
                            <a href="{{ url('/help/search?q=환불') }}" class="badge bg-light text-dark text-decoration-none">환불</a>
                        </div>
                    </div>
                </div>

                <!-- 카테고리 바로가기 -->
                @if($categories && $categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">카테고리별 도움말</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($categories as $category)
                            <a href="{{ url('/help/category/' . $category->code) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center">
                                <span>
                                    @if($category->icon)
                                    <i class="{{ $category->icon }} me-2"></i>
                                    @endif
                                    {{ $category->title }}
                                </span>
                                <i class="fe fe-chevron-right"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- 문의하기 -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">도움이 더 필요하신가요?</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">원하는 답변을 찾지 못하셨나요? 직접 문의해주세요.</p>
                        <div class="d-grid">
                            <a href="{{ url('/help/support') }}" class="btn btn-primary">
                                <i class="fe fe-life-buoy me-2"></i>
                                고객지원 문의
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
