@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
                <div>
                    <h1 class="mb-0 h2 fw-bold">{{ $config['title'] }}</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.dashboard') }}">Ecommerce</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Shipping</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body">
                        <i class="fe fe-download me-2"></i>Export
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShippingModal">
                        <i class="fe fe-plus me-2"></i>배송비 추가
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 배송 통계 카드 -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_rates']) }}</h4>
                            <p class="text-muted mb-0">배송비 설정</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="fe fe-truck"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['countries_covered']) }}</h4>
                            <p class="text-muted mb-0">배송 가능 국가</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                            <i class="fe fe-globe"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['avg_delivery_days'] }}</h4>
                            <p class="text-muted mb-0">평균 배송일</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="fe fe-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['shipping_revenue']) }}원</h4>
                            <p class="text-muted mb-0">배송비 수익</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="fe fe-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 배송비 설정 목록 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">배송비 설정 목록</h4>
                </div>

                <!-- 필터 -->
                <div class="card-body border-bottom">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">국가</label>
                            <select class="form-select" name="country" onchange="this.form.submit()">
                                <option value="all">모든 국가</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->code }}" {{ request('country') === $country->code ? 'selected' : '' }}>
                                        {{ $country->name }} ({{ $country->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">배송 방법</label>
                            <select class="form-select" name="method" onchange="this.form.submit()">
                                <option value="all">모든 방법</option>
                                @foreach($shippingMethods as $key => $method)
                                    <option value="{{ $key }}" {{ request('method') === $key ? 'selected' : '' }}>
                                        {{ $method['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">상태</label>
                            <select class="form-select" name="enable" onchange="this.form.submit()">
                                <option value="all">모든 상태</option>
                                <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>활성화</option>
                                <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비활성화</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">검색</label>
                            <input type="search" class="form-control" name="search" value="{{ request('search') }}" placeholder="이름 또는 국가명">
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>배송비명</th>
                                <th>국가</th>
                                <th>배송 방법</th>
                                <th>기본 요금</th>
                                <th>kg당 요금</th>
                                <th>무료배송 임계값</th>
                                <th>예상 배송일</th>
                                <th>상태</th>
                                <th>액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shippingRates as $rate)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $rate['name'] }}</h6>
                                        <span class="text-muted small">{{ $rate['currency'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">{{ $rate['country_code'] }}</span>
                                        <span class="text-muted">{{ $rate['country_name'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $method = $shippingMethods[$rate['method']] ?? ['label' => $rate['method'], 'color' => 'secondary', 'icon' => 'circle'];
                                    @endphp
                                    <span class="badge bg-light-{{ $method['color'] }} text-{{ $method['color'] }}">
                                        <i class="fe fe-{{ $method['icon'] }} me-1"></i>
                                        {{ $method['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($rate['base_rate']) }}</span>
                                    <span class="text-muted">{{ $rate['currency'] }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($rate['per_kg_rate']) }}</span>
                                    <span class="text-muted">{{ $rate['currency'] }}/kg</span>
                                </td>
                                <td>
                                    @if($rate['free_shipping_threshold'])
                                        <span class="text-success fw-bold">
                                            {{ number_format($rate['free_shipping_threshold']) }} {{ $rate['currency'] }}
                                        </span>
                                    @else
                                        <span class="text-muted">무료배송 없음</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light-info text-info">
                                        {{ $rate['estimated_days'] }}일
                                    </span>
                                </td>
                                <td>
                                    @if($rate['enable'])
                                        <span class="badge bg-light-success text-success">활성화</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">비활성화</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            액션
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>복사</a></li>
                                            <li>
                                                @if($rate['enable'])
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye-off me-2"></i>비활성화</a>
                                                @else
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i>활성화</a>
                                                @endif
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fe fe-truck fs-1 mb-3"></i>
                                        <p>배송비 설정이 없습니다.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShippingModal">
                                            첫 번째 배송비 추가하기
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @if($shippingRates->total() > 0)
                                <p class="text-muted mb-0">
                                    <i class="fe fe-info me-1"></i>
                                    총 <strong>{{ number_format($shippingRates->total()) }}</strong>개 중
                                    <strong>{{ number_format($shippingRates->firstItem()) }}</strong>-<strong>{{ number_format($shippingRates->lastItem()) }}</strong>번째 표시
                                </p>
                                <small class="text-muted">
                                    <i class="fe fe-layers me-1"></i>
                                    페이지 {{ $shippingRates->currentPage() }} / {{ $shippingRates->lastPage() }}
                                </small>
                            @else
                                <p class="text-muted mb-0">
                                    <i class="fe fe-info me-1"></i>
                                    배송 설정이 없습니다
                                </p>
                            @endif
                        </div>
                        @if($shippingRates->hasPages())
                        <div>
                            <nav aria-label="페이지네이션">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- 이전 페이지 --}}
                                    @if($shippingRates->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fe fe-chevron-left"></i>
                                                이전
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $shippingRates->previousPageUrl() }}">
                                                <i class="fe fe-chevron-left"></i>
                                                이전
                                            </a>
                                        </li>
                                    @endif

                                    {{-- 페이지 번호 --}}
                                    @php
                                        $start = max(1, $shippingRates->currentPage() - 2);
                                        $end = min($shippingRates->lastPage(), $shippingRates->currentPage() + 2);
                                    @endphp

                                    {{-- 첫 페이지 --}}
                                    @if($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $shippingRates->url(1) }}">1</a>
                                        </li>
                                        @if($start > 2)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- 중간 페이지들 --}}
                                    @for($page = $start; $page <= $end; $page++)
                                        @if($page == $shippingRates->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $shippingRates->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    {{-- 마지막 페이지 --}}
                                    @if($end < $shippingRates->lastPage())
                                        @if($end < $shippingRates->lastPage() - 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $shippingRates->url($shippingRates->lastPage()) }}">{{ $shippingRates->lastPage() }}</a>
                                        </li>
                                    @endif

                                    {{-- 다음 페이지 --}}
                                    @if($shippingRates->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $shippingRates->nextPageUrl() }}">
                                                다음
                                                <i class="fe fe-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                다음
                                                <i class="fe fe-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 배송비 추가 모달 -->
<div class="modal fade" id="addShippingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">배송비 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">배송비명 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: 국내 표준 배송">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">국가 <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option value="">국가 선택</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">배송 방법 <span class="text-danger">*</span></label>
                            <select class="form-select">
                                @foreach($shippingMethods as $key => $method)
                                    <option value="{{ $key }}">{{ $method['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">통화 <span class="text-danger">*</span></label>
                            <select class="form-select">
                                <option value="KRW">KRW - 원</option>
                                <option value="USD">USD - 달러</option>
                                <option value="EUR">EUR - 유로</option>
                                <option value="GBP">GBP - 파운드</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">기본 배송비</label>
                            <input type="number" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">kg당 추가 요금</label>
                            <input type="number" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">무료배송 임계값</label>
                            <input type="number" class="form-control" step="0.01" placeholder="50000">
                            <div class="form-text">이 금액 이상 주문 시 무료배송</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">예상 배송일</label>
                            <input type="text" class="form-control" placeholder="예: 2-3">
                            <div class="form-text">예: "2-3", "1", "5-7"</div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableShipping" checked>
                                <label class="form-check-label" for="enableShipping">
                                    배송비 활성화
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">추가</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 모달 폼 제출 처리
    const form = document.querySelector('#addShippingModal form');
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        // 여기에 AJAX 요청 또는 폼 제출 로직 추가
        alert('배송비가 추가되었습니다. (데모)');
        bootstrap.Modal.getInstance(document.getElementById('addShippingModal')).hide();
    });
});
</script>
@endpush
