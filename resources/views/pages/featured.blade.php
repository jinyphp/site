@extends('jiny-site::layouts.app')

@section('title', '추천 페이지')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- 페이지 헤더 -->
            <div class="page-header mb-5">
                <div class="text-center">
                    <h1 class="page-title mb-3">
                        <i class="fe fe-star text-warning me-2"></i>
                        추천 페이지
                    </h1>
                    <p class="page-excerpt text-muted lead">엄선된 추천 페이지를 확인해보세요.</p>
                </div>
            </div>

            <!-- 추천 페이지 목록 -->
            @if($pages->count() > 0)
            <div class="row">
                @foreach($pages as $page)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">
                                    <a href="{{ $page->url }}" class="text-decoration-none">
                                        {{ $page->title }}
                                    </a>
                                </h5>
                                <span class="badge bg-warning text-dark">
                                    <i class="fe fe-star"></i> 추천
                                </span>
                            </div>

                            @if($page->excerpt)
                            <p class="card-text text-muted">{{ $page->excerpt }}</p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($page->published_at)
                                        {{ $page->published_at->format('Y년 m월 d일') }}
                                    @endif
                                </small>
                                <small class="text-muted">
                                    <i class="fe fe-eye"></i> {{ number_format($page->view_count) }}
                                </small>
                            </div>

                            <div class="mt-3">
                                <a href="{{ $page->url }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fe fe-arrow-right"></i> 자세히 보기
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fe fe-star text-warning" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">추천 페이지가 없습니다</h5>
                <p class="text-muted">아직 추천으로 설정된 페이지가 없습니다.</p>
                <a href="{{ route('pages.index') }}" class="btn btn-outline-primary">
                    <i class="fe fe-list"></i> 전체 페이지 보기
                </a>
            </div>
            @endif

            <!-- 전체 페이지 보기 링크 -->
            @if($pages->count() > 0)
            <div class="text-center mt-5">
                <a href="{{ route('pages.index') }}" class="btn btn-outline-primary">
                    <i class="fe fe-list"></i> 전체 페이지 보기
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection