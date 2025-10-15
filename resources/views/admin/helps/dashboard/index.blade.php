@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <h1 class="page-header-title">
                        <i class="fe fe-life-buoy me-2"></i>
                        {{ $config['title'] }}
                    </h1>
                    <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 주요 통계 카드 -->
    <div class="row">
        <!-- 가이드 문서 통계 -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">가이드</h4>
                            <p class="text-muted mb-0">전체 {{ number_format($guideStats['total']) }}개</p>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="fe fe-book-open"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-success">
                                    <i class="fe fe-eye me-1"></i>
                                    {{ number_format($guideStats['total_views']) }} 조회
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-info">
                                    <i class="fe fe-heart me-1"></i>
                                    {{ number_format($guideStats['total_likes']) }} 좋아요
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ 통계 -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">FAQ</h4>
                            <p class="text-muted mb-0">전체 {{ number_format($faqStats['total']) }}개</p>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-help-circle"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-success">
                                    <i class="fe fe-eye me-1"></i>
                                    {{ number_format($faqStats['total_views']) }} 조회
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-info">
                                    <i class="fe fe-check-circle me-1"></i>
                                    {{ $faqStats['published'] }} 게시됨
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- 주간 활동 -->
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">주간 활동</h4>
                            <p class="text-muted mb-0">최근 7일</p>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-trending-up"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-4">
                                <small class="text-primary">
                                    {{ $weeklyStats['guide_created'] }} 가이드
                                </small>
                            </div>
                            <div class="col-4">
                                <small class="text-success">
                                    {{ $weeklyStats['faq_created'] }} FAQ
                                </small>
                            </div>
                            <div class="col-4">
                                <small class="text-warning">
                                    {{ $weeklyStats['support_received'] }} 지원요청
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Support 통계 섹션 (기존 support 모듈에서 통합) -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fe fe-headphones me-2"></i>
                        고객 지원 요청 통계
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- 전체 지원 요청 -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title mb-1">전체 요청</h4>
                                            <h2 class="text-primary mb-0">{{ number_format($supportStats['total']) }}</h2>
                                        </div>
                                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                                            <i class="fe fe-inbox"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 대기중 지원 요청 -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title mb-1">대기중</h4>
                                            <h2 class="text-warning mb-0">{{ number_format($supportStats['pending']) }}</h2>
                                        </div>
                                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                                            <i class="fe fe-clock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 처리중 지원 요청 -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title mb-1">처리중</h4>
                                            <h2 class="text-info mb-0">{{ number_format($supportStats['in_progress']) }}</h2>
                                        </div>
                                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                                            <i class="fe fe-activity"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 해결완료 지원 요청 -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title mb-1">해결완료</h4>
                                            <h2 class="text-success mb-0">{{ number_format($supportStats['resolved']) }}</h2>
                                        </div>
                                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                                            <i class="fe fe-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support 통계 상세 정보 -->
                    <div class="row mt-3">
                        <div class="col-xl-6">
                            <div class="card border-0">
                                <div class="card-header bg-transparent">
                                    <h5 class="card-title mb-0">상태별 분포</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge bg-warning">대기중</span></td>
                                                    <td>{{ number_format($supportStats['pending']) }}건</td>
                                                    <td>
                                                        @if($supportStats['total'] > 0)
                                                            {{ number_format(($supportStats['pending'] / $supportStats['total']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge bg-info">처리중</span></td>
                                                    <td>{{ number_format($supportStats['in_progress']) }}건</td>
                                                    <td>
                                                        @if($supportStats['total'] > 0)
                                                            {{ number_format(($supportStats['in_progress'] / $supportStats['total']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge bg-success">해결완료</span></td>
                                                    <td>{{ number_format($supportStats['resolved']) }}건</td>
                                                    <td>
                                                        @if($supportStats['total'] > 0)
                                                            {{ number_format(($supportStats['resolved'] / $supportStats['total']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge bg-secondary">종료</span></td>
                                                    <td>{{ number_format($supportStats['closed']) }}건</td>
                                                    <td>
                                                        @if($supportStats['total'] > 0)
                                                            {{ number_format(($supportStats['closed'] / $supportStats['total']) * 100, 1) }}%
                                                        @else
                                                            0%
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card border-0">
                                <div class="card-header bg-transparent">
                                    <h5 class="card-title mb-0">처리 효율성</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">전체 해결률</label>
                                        <div class="progress">
                                            @php
                                                $resolvedRate = $supportStats['total'] > 0 ? ($supportStats['resolved'] / $supportStats['total']) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $resolvedRate }}%">
                                                {{ number_format($resolvedRate, 1) }}%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">진행중 비율</label>
                                        <div class="progress">
                                            @php
                                                $progressRate = $supportStats['total'] > 0 ? ($supportStats['in_progress'] / $supportStats['total']) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progressRate }}%">
                                                {{ number_format($progressRate, 1) }}%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">대기중 비율</label>
                                        <div class="progress">
                                            @php
                                                $pendingRate = $supportStats['total'] > 0 ? ($supportStats['pending'] / $supportStats['total']) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pendingRate }}%">
                                                {{ number_format($pendingRate, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 카테고리 및 타입 통계 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">카테고리 & 타입 현황</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $categoryStats['guide_categories'] }}</h3>
                                <p class="text-muted mb-0">가이드 카테고리</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-success">{{ $categoryStats['faq_categories'] }}</h3>
                                <p class="text-muted mb-0">FAQ 카테고리</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-warning">{{ $categoryStats['support_types'] }}</h3>
                                <p class="text-muted mb-0">지원 타입</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- 최근 가이드 -->
        <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">최근 가이드</h4>
                    <a href="{{ route('admin.cms.help.docs.index') }}" class="btn btn-outline-primary btn-sm">
                        전체보기
                    </a>
                </div>
                <div class="card-body">
                    @if($recentGuides->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentGuides as $guide)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('admin.cms.help.docs.show', $guide->id) }}" class="text-decoration-none">
                                                {{ Str::limit($guide->title, 30) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fe fe-eye me-1"></i>{{ $guide->views }} 조회
                                            <span class="mx-2">•</span>
                                            {{ $guide->created_at ? \Carbon\Carbon::parse($guide->created_at)->diffForHumans() : '' }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $guide->enable ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $guide->enable ? '게시' : '비공개' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fe fe-file-text fs-3 mb-2"></i>
                            <p>등록된 가이드가 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 최근 FAQ -->
        <div class="col-xl-4 col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">최근 FAQ</h4>
                    <a href="{{ route('admin.cms.faq.faqs.index') }}" class="btn btn-outline-success btn-sm">
                        전체보기
                    </a>
                </div>
                <div class="card-body">
                    @if($recentFaqs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentFaqs as $faq)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('admin.cms.faq.faqs.show', $faq->id) }}" class="text-decoration-none">
                                                {{ Str::limit($faq->question, 30) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fe fe-eye me-1"></i>{{ $faq->views }} 조회
                                            <span class="mx-2">•</span>
                                            {{ $faq->created_at ? \Carbon\Carbon::parse($faq->created_at)->diffForHumans() : '' }}
                                        </small>
                                    </div>
                                    <span class="badge {{ $faq->enable ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $faq->enable ? '게시' : '비공개' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fe fe-help-circle fs-3 mb-2"></i>
                            <p>등록된 FAQ가 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- 인기 가이드 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">인기 가이드 (조회수 기준)</h4>
                </div>
                <div class="card-body">
                    @if($popularGuides->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>제목</th>
                                        <th class="text-center">조회수</th>
                                        <th class="text-center">등록일</th>
                                        <th class="text-center">관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($popularGuides as $guide)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.cms.help.docs.show', $guide->id) }}" class="text-decoration-none">
                                                {{ $guide->title }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ number_format($guide->views) }}</span>
                                        </td>
                                        <td class="text-center text-muted">
                                            {{ $guide->created_at ? \Carbon\Carbon::parse($guide->created_at)->format('Y-m-d') : '' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.cms.help.docs.edit', $guide->id) }}" class="btn btn-outline-primary btn-sm">
                                                수정
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fe fe-trending-up fs-3 mb-2"></i>
                            <p>인기 가이드 데이터가 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 빠른 작업 메뉴 -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">빠른 작업</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.cms.help.docs.create') }}" class="btn btn-primary w-100 mb-2">
                                <i class="fe fe-plus me-2"></i>
                                새 가이드 작성
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.cms.faq.faqs.create') }}" class="btn btn-success w-100 mb-2">
                                <i class="fe fe-plus me-2"></i>
                                새 FAQ 작성
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.cms.help.categories.index') }}" class="btn btn-info w-100 mb-2">
                                <i class="fe fe-folder me-2"></i>
                                카테고리 관리
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.cms.support.index') }}" class="btn btn-warning w-100 mb-2">
                                <i class="fe fe-headphones me-2"></i>
                                지원 요청 관리
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
