@extends('jiny-site::layouts.app')

@section('title', '이벤트')

@section('content')
<div class="container my-5">
    <!-- 페이지 헤더 -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="bi bi-calendar-event text-primary me-3"></i>이벤트
            </h1>
            <p class="lead text-muted">진행 중인 다양한 이벤트를 확인해보세요!</p>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-event fs-2 mb-2"></i>
                            <h3 class="card-title">{{ number_format($stats['total']) }}</h3>
                            <p class="card-text">전체 이벤트</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-play-circle fs-2 mb-2"></i>
                            <h3 class="card-title">{{ number_format($stats['active']) }}</h3>
                            <p class="card-text">진행 중</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-clock fs-2 mb-2"></i>
                            <h3 class="card-title">{{ number_format($stats['planned']) }}</h3>
                            <p class="card-text">예정</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle fs-2 mb-2"></i>
                            <h3 class="card-title">{{ number_format($stats['completed']) }}</h3>
                            <p class="card-text">완료</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('event.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">
                                <i class="bi bi-search me-1"></i>검색
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ $searchQuery }}"
                                   placeholder="이벤트 제목이나 내용으로 검색...">
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-funnel me-1"></i>상태
                            </label>
                            <select class="form-select" id="status" name="status">
                                <option value="">전체</option>
                                <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>진행 중</option>
                                <option value="planned" {{ $currentStatus === 'planned' ? 'selected' : '' }}>예정</option>
                                <option value="completed" {{ $currentStatus === 'completed' ? 'selected' : '' }}>완료</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>검색
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 이벤트 목록 -->
    <div class="row">
        <div class="col-lg-10 mx-auto">
            @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm hover-lift">
                        @if($event->image)
                        <img src="{{ $event->image }}"
                             class="card-img-top"
                             alt="{{ $event->title }}"
                             style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                             style="height: 200px;">
                            <i class="bi bi-calendar-event text-muted" style="font-size: 3rem;"></i>
                        </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <!-- 상태 배지 -->
                            <div class="mb-2">
                                @php
                                $statusClasses = [
                                    'active' => 'bg-success',
                                    'inactive' => 'bg-secondary',
                                    'planned' => 'bg-warning text-dark',
                                    'completed' => 'bg-info'
                                ];
                                $statusTexts = [
                                    'active' => '진행 중',
                                    'inactive' => '중단',
                                    'planned' => '예정',
                                    'completed' => '완료'
                                ];
                                @endphp
                                <span class="badge {{ $statusClasses[$event->status] ?? 'bg-secondary' }}">
                                    {{ $statusTexts[$event->status] ?? $event->status }}
                                </span>

                                @if($event->manager)
                                <small class="text-muted ms-2">
                                    <i class="bi bi-person me-1"></i>{{ $event->manager }}
                                </small>
                                @endif
                            </div>

                            <!-- 제목 -->
                            <h5 class="card-title mb-3">
                                <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $event->title }}
                                </a>
                            </h5>

                            <!-- 설명 -->
                            @if($event->description)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                            @endif

                            <!-- 하단 정보 -->
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $event->created_at->format('Y.m.d') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-eye me-1"></i>
                                        {{ $event->formatted_view_count }}
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        자세히 보기
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- 페이지네이션 -->
            @if($events->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="이벤트 페이지네이션">
                        {{ $events->links() }}
                    </nav>
                </div>
            </div>
            @endif

            @else
            <!-- 이벤트 없음 -->
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 5rem;"></i>
                <h3 class="mt-4 mb-3">진행 중인 이벤트가 없습니다</h3>
                <p class="text-muted mb-4">현재 진행 중인 이벤트가 없습니다.<br>새로운 이벤트 소식을 기다려주세요!</p>
                @if($searchQuery || $currentStatus)
                <a href="{{ route('event.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i>전체 이벤트 보기
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.hover-lift {
    transition: transform 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-5px);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.card {
    overflow: hidden;
}
</style>
@endpush
@endsection