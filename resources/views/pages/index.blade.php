@extends('jiny-site::layouts.app')

@section('title', '페이지 목록')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- 페이지 헤더 -->
            <div class="page-header mb-5">
                <div class="text-center">
                    <h1 class="page-title mb-3">페이지 목록</h1>
                    <p class="page-excerpt text-muted lead">사이트의 모든 페이지를 확인하실 수 있습니다.</p>
                </div>
            </div>

            <!-- 페이지 목록 -->
            @if($pages->count() > 0)
            <div class="row">
                @foreach($pages as $page)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title">
                                    <a href="{{ $page->url }}" class="text-decoration-none">
                                        {{ $page->title }}
                                    </a>
                                </h5>
                                @if($page->is_featured)
                                <span class="badge bg-warning text-dark">
                                    <i class="fe fe-star"></i>
                                </span>
                                @endif
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
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- 페이지네이션 -->
            @if($pages->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $pages->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5">
                <i class="fe fe-file-text text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">표시할 페이지가 없습니다</h5>
                <p class="text-muted">아직 발행된 페이지가 없습니다.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection