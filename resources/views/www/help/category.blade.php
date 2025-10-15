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
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                    </ol>
                </nav>
                <!-- caption-->
                <div class="d-flex align-items-start gap-3 mb-3">
                    @if($category->icon)
                    <div class="flex-shrink-0">
                        <i class="{{ $category->icon }} display-6 text-primary"></i>
                    </div>
                    @endif
                    <div>
                        <h1 class="fw-bold mb-2 display-5">{{ $category->title }}</h1>
                        @if($category->content)
                        <p class="lead text-muted">{{ $category->content }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-8">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                @if($helps && $helps->count() > 0)
                <div class="mb-4">
                    <h3>{{ $category->title }} 도움말 ({{ $helps->total() }}개)</h3>
                </div>

                <!-- 도움말 목록 -->
                <div class="row">
                    @foreach($helps as $help)
                    <div class="col-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title">
                                        <a href="{{ url('/help/' . $help->id) }}" class="text-inherit">{{ $help->title }}</a>
                                    </h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($help->created_at)->format('Y.m.d') }}</small>
                                </div>
                                <p class="card-text text-muted">
                                    {{ Str::limit(strip_tags($help->content), 150) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ url('/help/' . $help->id) }}" class="btn btn-outline-primary btn-sm">
                                        자세히 보기
                                        <i class="fe fe-arrow-right ms-1"></i>
                                    </a>
                                    <div class="d-flex align-items-center gap-3">
                                        <small class="text-muted">
                                            <i class="fe fe-thumbs-up me-1"></i>
                                            {{ $help->like }}
                                        </small>
                                        @if($help->manager)
                                        <small class="text-muted">
                                            <i class="fe fe-user me-1"></i>
                                            {{ $help->manager }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- 페이지네이션 -->
                {{ $helps->links() }}
                @else
                <!-- 도움말이 없을 때 -->
                <div class="text-center py-8">
                    <div class="mb-4">
                        @if($category->icon)
                        <i class="{{ $category->icon }} display-1 text-muted"></i>
                        @else
                        <i class="fe fe-help-circle display-1 text-muted"></i>
                        @endif
                    </div>
                    <h3>아직 등록된 도움말이 없습니다</h3>
                    <p class="text-muted">{{ $category->title }} 카테고리에 등록된 도움말이 없습니다.</p>
                    <div class="mt-4">
                        <a href="{{ url('/help') }}" class="btn btn-primary me-2">도움말 센터 홈</a>
                        <a href="{{ url('/help/search') }}" class="btn btn-outline-primary">도움말 검색</a>
                    </div>
                </div>
                @endif
            </div>

            <!-- 사이드바 -->
            <div class="col-lg-4 col-12">
                <!-- 다른 카테고리 -->
                @if($categories && $categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">다른 카테고리</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($categories as $cat)
                            @if($cat->code !== $category->code)
                            <a href="{{ url('/help/category/' . $cat->code) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center">
                                <span>
                                    @if($cat->icon)
                                    <i class="{{ $cat->icon }} me-2"></i>
                                    @endif
                                    {{ $cat->title }}
                                </span>
                                <i class="fe fe-chevron-right"></i>
                            </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- 빠른 링크 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">빠른 링크</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ url('/help') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fe fe-home me-2"></i>
                                도움말 센터 홈
                            </a>
                            <a href="{{ url('/help/faq') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fe fe-help-circle me-2"></i>
                                자주 묻는 질문
                            </a>
                            <a href="{{ url('/help/search') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fe fe-search me-2"></i>
                                도움말 검색
                            </a>
                        </div>
                    </div>
                </div>

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
