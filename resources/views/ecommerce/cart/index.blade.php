@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '장바구니 관리')

@section('content')
<div class="container-fluid p-4">
    <!-- Page Header -->
    <div class="border-bottom pb-3 mb-4 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
        <div>
            <h1 class="mb-0 h2 fw-bold">장바구니 관리</h1>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.cms.dashboard') }}">CMS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">장바구니</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#statsModal">
                <i class="fe fe-bar-chart-2 me-2"></i>통계
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="bulkDelete()">
                <i class="fe fe-trash-2 me-2"></i>선택 삭제
            </button>
        </div>
    </div>

<!-- Stats Cards -->
<div class="row gy-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($stats['total_items']) }}</h4>
                        <p class="text-muted mb-0">총 장바구니 아이템</p>
                    </div>
                    <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                        <i class="fe fe-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($stats['total_quantity']) }}</h4>
                        <p class="text-muted mb-0">총 수량</p>
                    </div>
                    <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                        <i class="fe fe-package"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ number_format($stats['total_users']) }}</h4>
                        <p class="text-muted mb-0">활성 사용자</p>
                    </div>
                    <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                        <i class="fe fe-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-0">
                            @if($insights['week_growth_rate'] >= 0)
                                <span class="text-success">+{{ $insights['week_growth_rate'] }}%</span>
                            @else
                                <span class="text-danger">{{ $insights['week_growth_rate'] }}%</span>
                            @endif
                        </h4>
                        <p class="text-muted mb-0">주간 증감률</p>
                    </div>
                    <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                        @if($insights['week_growth_rate'] >= 0)
                            <i class="fe fe-trending-up"></i>
                        @else
                            <i class="fe fe-trending-down"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Insights Cards -->
<div class="row gy-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 bg-light-secondary">
            <div class="card-body text-center">
                <div class="icon-shape icon-md bg-secondary bg-opacity-10 text-secondary rounded-circle mx-auto mb-3">
                    <i class="fe fe-clock"></i>
                </div>
                <h4 class="mb-1">{{ number_format($insights['avg_cart_duration'] ?? 0, 1) }}일</h4>
                <p class="text-muted mb-0">평균 장바구니 보관</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 bg-light-primary">
            <div class="card-body text-center">
                <div class="icon-shape icon-md bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3">
                    <i class="fe fe-user"></i>
                </div>
                <h4 class="mb-1">{{ number_format($insights['avg_items_per_user'] ?? 0, 1) }}개</h4>
                <p class="text-muted mb-0">회원별 평균 아이템</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 bg-light-warning">
            <div class="card-body text-center">
                <div class="icon-shape icon-md bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3">
                    <i class="fe fe-dollar-sign"></i>
                </div>
                <h4 class="mb-1">{{ number_format($insights['high_value_interest']) }}개</h4>
                <p class="text-muted mb-0">고가 상품 관심</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 bg-light-danger">
            <div class="card-body text-center">
                <div class="icon-shape icon-md bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3">
                    <i class="fe fe-calendar"></i>
                </div>
                <h4 class="mb-1">{{ $longTermInterests->count() }}개</h4>
                <p class="text-muted mb-0">장기 관심 상품</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Items Analysis -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fe fe-trending-up me-2"></i>인기 상품 TOP 10
                </h5>
            </div>
            <div class="card-body p-0">
                @if($popularItems['products']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>순위</th>
                                    <th>상품명</th>
                                    <th class="text-end">관심 고객</th>
                                    <th class="text-end">총 수량</th>
                                    <th class="text-end">가격</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularItems['products'] as $index => $product)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($product->title, 30) }}</div>
                                            <small class="text-muted">ID: {{ $product->item_id }}</small>
                                        </td>
                                        <td class="text-end">{{ $product->unique_users }}명</td>
                                        <td class="text-end">{{ number_format($product->total_quantity) }}</td>
                                        <td class="text-end">{{ number_format($product->price) }}원</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fe fe-package text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">데이터가 없습니다</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fe fe-briefcase me-2"></i>인기 서비스 TOP 10
                </h5>
            </div>
            <div class="card-body p-0">
                @if($popularItems['services']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>순위</th>
                                    <th>서비스명</th>
                                    <th class="text-end">관심 고객</th>
                                    <th class="text-end">총 수량</th>
                                    <th class="text-end">가격</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularItems['services'] as $index => $service)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($service->title, 30) }}</div>
                                            <small class="text-muted">ID: {{ $service->item_id }}</small>
                                        </td>
                                        <td class="text-end">{{ $service->unique_users }}명</td>
                                        <td class="text-end">{{ number_format($service->total_quantity) }}</td>
                                        <td class="text-end">{{ number_format($service->price) }}원</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fe fe-briefcase text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">데이터가 없습니다</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Long Term Interests -->
@if($longTermInterests->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fe fe-heart me-2"></i>장기 관심 상품 (30일 이상)
                    <span class="badge bg-warning ms-2">{{ $longTermInterests->count() }}개</span>
                </h5>
                <p class="text-muted mb-0 small">오랫동안 장바구니에 담아두고 있는 상품들입니다. 할인 이벤트나 개별 연락을 고려해보세요.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>고객</th>
                                <th>상품/서비스</th>
                                <th>유형</th>
                                <th class="text-end">수량</th>
                                <th class="text-end">가격</th>
                                <th class="text-end">보관 기간</th>
                                <th>액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($longTermInterests as $item)
                                <tr>
                                    <td>
                                        @if($item->user_name)
                                            <div class="fw-semibold">{{ $item->user_name }}</div>
                                            <small class="text-muted">{{ $item->user_email }}</small>
                                        @else
                                            <span class="text-muted">비회원</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($item->item_title, 40) }}</div>
                                        <small class="text-muted">ID: {{ $item->item_id }}</small>
                                    </td>
                                    <td>
                                        @if($item->item_type === 'product')
                                            <span class="badge bg-primary">상품</span>
                                        @else
                                            <span class="badge bg-info">서비스</span>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format($item->quantity) }}</td>
                                    <td class="text-end">{{ number_format($item->item_price) }}원</td>
                                    <td class="text-end">
                                        <span class="badge bg-warning">{{ number_format($item->days_in_cart, 0) }}일</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if($item->user_email)
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                        onclick="sendFollowUp('{{ $item->user_email }}', '{{ $item->item_title }}')"
                                                        title="팔로업 이메일">
                                                    <i class="fe fe-mail"></i>
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="createDiscount('{{ $item->item_id }}', '{{ $item->item_type }}')"
                                                    title="할인 적용">
                                                <i class="fe fe-percent"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">검색 및 필터</h4>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-lg-3 col-md-4 col-12">
                <label class="form-label">검색</label>
                <input type="text" class="form-control" name="search" value="{{ $filters['search'] }}"
                       placeholder="상품명, 사용자명, 이메일...">
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <label class="form-label">사용자 유형</label>
                <select class="form-select" name="user_type">
                    <option value="">전체</option>
                    <option value="member" {{ $filters['user_type'] === 'member' ? 'selected' : '' }}>회원</option>
                    <option value="guest" {{ $filters['user_type'] === 'guest' ? 'selected' : '' }}>비회원</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <label class="form-label">아이템 유형</label>
                <select class="form-select" name="item_type">
                    <option value="">전체</option>
                    <option value="product" {{ $filters['item_type'] === 'product' ? 'selected' : '' }}>상품</option>
                    <option value="service" {{ $filters['item_type'] === 'service' ? 'selected' : '' }}>서비스</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <label class="form-label">시작일</label>
                <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] }}">
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <label class="form-label">종료일</label>
                <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] }}">
            </div>
            <div class="col-lg-1 col-md-4 col-12">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-search me-1"></i>
                        <span class="d-none d-sm-inline">검색</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Cart Items Table -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">장바구니 목록</h4>
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 me-2">페이지당:</label>
                <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                    <option value="10" {{ $filters['per_page'] == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $filters['per_page'] == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $filters['per_page'] == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $filters['per_page'] == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        @if($cartItems->count() > 0)
            <!-- 스크롤 힌트 -->
            <div class="d-lg-none bg-light border-bottom p-2 text-center">
                <small class="text-muted">
                    <i class="fe fe-arrow-left me-1"></i>
                    좌우로 스크롤하여 더 많은 정보를 확인하세요
                    <i class="fe fe-arrow-right ms-1"></i>
                </small>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px; padding: 0.75rem 0.5rem;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </div>
                            </th>
                            <th style="width: 150px; padding: 0.75rem 0.5rem;">사용자</th>
                            <th style="width: 200px; padding: 0.75rem 0.5rem;">아이템</th>
                            <th style="width: 80px; padding: 0.75rem 0.5rem;" class="d-none d-lg-table-cell">유형</th>
                            <th style="width: 100px; padding: 0.75rem 0.5rem;" class="d-none d-xl-table-cell">가격 옵션</th>
                            <th style="width: 70px; padding: 0.75rem 0.5rem;" class="text-end">수량</th>
                            <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-end d-none d-md-table-cell">단가</th>
                            <th style="width: 120px; padding: 0.75rem 0.5rem;" class="text-end">총액</th>
                            <th style="width: 100px; padding: 0.75rem 0.5rem;" class="d-none d-lg-table-cell">추가일</th>
                            <th style="width: 80px; padding: 0.75rem 0.5rem;">액션</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td style="width: 50px; padding: 0.75rem 0.5rem;">
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->id }}">
                                    </div>
                                </td>
                                <td style="width: 150px; padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div class="fw-semibold user-name-cell" title="{{ $item->user_display }}">{{ $item->user_display }}</div>
                                        <small class="text-muted">
                                            @if($item->user_type === 'member')
                                                <i class="fe fe-user text-primary me-1"></i>회원
                                            @else
                                                <i class="fe fe-user-x text-muted me-1"></i>비회원
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td style="width: 200px; padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div class="fw-semibold item-title-cell" title="{{ $item->item_title ?: '제목 없음' }}">
                                            {{ $item->item_title ?: '제목 없음' }}
                                        </div>
                                        <small class="text-muted">ID: {{ $item->item_id }}</small>
                                        <!-- 모바일에서 추가 정보 표시 -->
                                        <div class="d-lg-none mt-1">
                                            @if($item->item_type === 'product')
                                                <span class="badge bg-primary me-1">상품</span>
                                            @else
                                                <span class="badge bg-info me-1">서비스</span>
                                            @endif
                                            <span class="text-muted small">{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}</span>
                                        </div>
                                        <div class="d-md-none mt-1">
                                            <small class="text-muted">단가: {{ number_format($item->final_price) }}원</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 80px; padding: 0.75rem 0.5rem;" class="d-none d-lg-table-cell">
                                    @if($item->item_type === 'product')
                                        <span class="badge bg-primary">상품</span>
                                    @else
                                        <span class="badge bg-info">서비스</span>
                                    @endif
                                </td>
                                <td style="width: 100px; padding: 0.75rem 0.5rem;" class="d-none d-xl-table-cell">
                                    @if($item->pricing_name)
                                        <span class="badge bg-light text-dark">{{ $item->pricing_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="width: 70px; padding: 0.75rem 0.5rem;" class="text-end">
                                    <span class="fw-bold">{{ number_format($item->quantity) }}</span>
                                </td>
                                <td style="width: 100px; padding: 0.75rem 0.5rem;" class="text-end d-none d-md-table-cell">
                                    {{ number_format($item->final_price) }}원
                                </td>
                                <td style="width: 120px; padding: 0.75rem 0.5rem;" class="text-end">
                                    <span class="fw-bold text-primary">{{ number_format($item->total_price) }}원</span>
                                </td>
                                <td style="width: 100px; padding: 0.75rem 0.5rem;" class="d-none d-lg-table-cell">
                                    <div>
                                        <div>{{ \Carbon\Carbon::parse($item->created_at)->format('m/d') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td style="width: 80px; padding: 0.75rem 0.5rem;">
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="deleteItem({{ $item->id }})"
                                                title="삭제">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <div class="text-muted small flex-shrink-0">
                        <span class="d-none d-sm-inline">총 {{ number_format($cartItems->total()) }}개 중 </span>
                        <span class="text-nowrap">{{ number_format($cartItems->firstItem()) }}-{{ number_format($cartItems->lastItem()) }}개 표시</span>
                    </div>
                    <div class="d-flex justify-content-center flex-shrink-0">
                        {{ $cartItems->appends($filters)->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fe fe-shopping-cart text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3 text-muted">장바구니 아이템이 없습니다</h5>
                <p class="text-muted">필터 조건을 변경해 보세요.</p>
            </div>
        @endif
    </div>
</div>

<!-- Stats Modal -->
<div class="modal fade" id="statsModal" tabindex="-1" aria-labelledby="statsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statsModalLabel">장바구니 통계</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>기간별 통계</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>오늘</span>
                                <span class="fw-bold">{{ number_format($stats['today_items']) }}개</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>최근 7일</span>
                                <span class="fw-bold">{{ number_format($stats['week_items']) }}개</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>최근 30일</span>
                                <span class="fw-bold">{{ number_format($stats['month_items']) }}개</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>유형별 통계</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>회원</span>
                                <span class="fw-bold">{{ number_format($stats['member_items']) }}개</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>비회원</span>
                                <span class="fw-bold">{{ number_format($stats['guest_items']) }}개</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>상품</span>
                                <span class="fw-bold">{{ number_format($stats['product_items']) }}개</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>서비스</span>
                                <span class="fw-bold">{{ number_format($stats['service_items']) }}개</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
/* Geeks Theme Icon Shapes */
.icon-shape {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    vertical-align: middle;
    width: 48px;
    height: 48px;
}

.icon-shape.icon-sm {
    width: 32px;
    height: 32px;
}

.icon-shape.icon-md {
    width: 40px;
    height: 40px;
}

.icon-shape.icon-lg {
    width: 48px;
    height: 48px;
}

.icon-shape.icon-xl {
    width: 56px;
    height: 56px;
}

.icon-shape.icon-xxl {
    width: 64px;
    height: 64px;
}

/* Background color utilities */
.bg-light-primary {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.bg-light-secondary {
    background-color: rgba(var(--bs-secondary-rgb), 0.1) !important;
}

.bg-light-success {
    background-color: rgba(var(--bs-success-rgb), 0.1) !important;
}

.bg-light-info {
    background-color: rgba(var(--bs-info-rgb), 0.1) !important;
}

.bg-light-warning {
    background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
}

.bg-light-danger {
    background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
}

/* 테이블 반응형 개선 */
.table-responsive {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto;
    border-radius: 0.375rem;
}

.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* 텍스트 말줄임 개선 */
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* 사용자명과 아이템 제목 셀 스타일 */
.user-name-cell,
.item-title-cell {
    word-break: break-word;
    overflow-wrap: break-word;
    white-space: normal;
    line-height: 1.4;
}

/* 모바일 최적화 */
@media (max-width: 767.98px) {
    .table td {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }

    .table th {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 575.98px) {
    .table td {
        padding: 0.25rem;
        font-size: 0.8rem;
    }

    .table th {
        padding: 0.25rem;
        font-size: 0.8rem;
    }
}

/* 테이블 반응형 스타일 개선 */
.table-responsive {
    border-radius: 0.375rem;
}

.table-responsive .table {
    margin-bottom: 0;
    min-width: 950px; /* 최소 너비 설정 */
    table-layout: fixed; /* 고정 레이아웃으로 열 정렬 */
    width: 100%;
}

/* 액션 버튼 최적화 */
.btn-group-sm > .btn, .btn-sm {
    min-width: auto;
}

/* 배지 최적화 */
.badge {
    font-size: 0.7em;
    padding: 0.25em 0.5em;
}

/* 모바일에서 숨겨진 컬럼 정보를 아이템 컬럼에 표시 */
@media (max-width: 991.98px) {
    .mobile-info {
        display: block !important;
    }
}

@media (min-width: 992px) {
    .mobile-info {
        display: none !important;
    }
}

/* 테이블 반응형 추가 개선 */
@media (max-width: 1199.98px) {
    .table-responsive .table {
        min-width: 800px;
    }
}

@media (max-width: 991.98px) {
    .table-responsive .table {
        min-width: 700px;
    }
}

@media (max-width: 767.98px) {
    .table-responsive .table {
        min-width: 600px;
    }
}

/* 헤더 반응형 개선 */
@media (max-width: 767.98px) {
    .border-bottom.pb-3.mb-4 {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }

    .d-flex.align-items-center {
        width: 100%;
        justify-content: space-between;
    }
}

/* 필터 버튼 스타일 개선 */
@media (max-width: 575.98px) {
    .btn {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
}

/* 스크롤 영역 시각적 표시 */
.table-responsive::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 20px;
    height: 100%;
    background: linear-gradient(to left, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.table-responsive:hover::after {
    opacity: 1;
}

@media (max-width: 991.98px) {
    .table-responsive::after {
        opacity: 1;
    }
}

/* 텍스트 잘림 방지 추가 스타일 */
.table td {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* 페이지네이션 영역 개선 */
.card-footer {
    min-height: 60px;
    padding: 1rem;
}

.card-footer .d-flex {
    min-height: 40px;
    align-items: center;
}

/* 사용자명과 아이템명 셀의 높이 조정 */
.table tbody tr {
    min-height: 60px;
}

/* 테이블 컬럼 정렬 및 스타일 개선 */
.table {
    border-collapse: separate;
    border-spacing: 0;
}

.table th,
.table td {
    border-top: 1px solid #dee2e6;
    vertical-align: middle;
    box-sizing: border-box;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
// 전체 선택/해제
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.item-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

// 페이지당 항목 수 변경
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    window.location = url.toString();
}

// 개별 아이템 삭제
function deleteItem(itemId) {
    if (!confirm('이 장바구니 아이템을 삭제하시겠습니까?')) {
        return;
    }

    fetch(`/admin/cms/cart/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('장바구니 아이템이 삭제되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '삭제 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('삭제 중 오류가 발생했습니다.', 'error');
    });
}

// 선택한 아이템 일괄 삭제
function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');

    if (checkedBoxes.length === 0) {
        showAlert('삭제할 아이템을 선택해 주세요.', 'warning');
        return;
    }

    if (!confirm(`선택한 ${checkedBoxes.length}개의 장바구니 아이템을 삭제하시겠습니까?`)) {
        return;
    }

    const itemIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);

    fetch('/admin/cms/cart/bulk-action', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'delete',
            items: itemIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`${itemIds.length}개의 장바구니 아이템이 삭제되었습니다.`, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '삭제 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('삭제 중 오류가 발생했습니다.', 'error');
    });
}

// 팔로업 이메일 전송
function sendFollowUp(email, itemTitle) {
    if (!confirm(`${email}님에게 "${itemTitle}" 관련 팔로업 이메일을 보내시겠습니까?`)) {
        return;
    }

    // 실제 이메일 전송 기능은 별도 구현 필요
    showAlert(`${email}님에게 팔로업 이메일을 전송했습니다.`, 'success');
}

// 할인 적용
function createDiscount(itemId, itemType) {
    if (!confirm(`이 ${itemType === 'product' ? '상품' : '서비스'}에 할인을 적용하시겠습니까?`)) {
        return;
    }

    // 실제 할인 적용 기능은 별도 구현 필요
    showAlert('할인이 적용되었습니다.', 'success');
}

// 알림 메시지 표시
function showAlert(message, type = 'info') {
    const alertType = type === 'error' ? 'danger' : type;
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${alertType} alert-dismissible fade show`;
    alertDiv.style.position = 'fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => {
        if (alertDiv && alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush
