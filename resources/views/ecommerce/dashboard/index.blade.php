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
                            <li class="breadcrumb-item active" aria-current="page">Ecommerce</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body" data-bs-toggle="tooltip" title="데이터 새로고침">
                        <i class="fe fe-refresh-cw me-2"></i>새로고침
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.settings.index') }}" class="btn btn-primary">
                        <i class="fe fe-settings me-2"></i>설정
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 주요 통계 카드 -->
    <div class="row mb-4">
        <!-- 매출 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['revenue']['this_month']) }}원</h4>
                            <p class="text-muted mb-0">이번 달 매출</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="fe fe-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="badge bg-light-success text-success">
                            <i class="fe fe-trending-up me-1"></i>+{{ $stats['revenue']['growth_rate'] }}%
                        </span>
                        <span class="text-muted ms-1">지난달 대비</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 주문 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['orders']['total']) }}</h4>
                            <p class="text-muted mb-0">전체 주문</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="fe fe-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted">오늘: </span>
                        <span class="fw-bold">{{ $stats['orders']['today'] }}건</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 고객 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['customers']['total']) }}</h4>
                            <p class="text-muted mb-0">전체 고객</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="fe fe-users"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted">활성: </span>
                        <span class="fw-bold">{{ $stats['customers']['active'] }}명</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 상품 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['products']['total']) }}</h4>
                            <p class="text-muted mb-0">전체 상품</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                            <i class="fe fe-package"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-muted">활성: </span>
                        <span class="fw-bold">{{ $stats['products']['active'] }}개</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 주문 현황 차트 -->
        <div class="col-lg-8 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">주문 현황</h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            최근 30일
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">최근 7일</a></li>
                            <li><a class="dropdown-item" href="#">최근 30일</a></li>
                            <li><a class="dropdown-item" href="#">최근 90일</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="ordersChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- 주문 상태 분포 -->
        <div class="col-lg-4 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">주문 상태</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted">처리중</span>
                            <span class="fw-bold">{{ $stats['orders']['processing'] }}건</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted">배송중</span>
                            <span class="fw-bold">{{ $stats['orders']['shipped'] }}건</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted">배송완료</span>
                            <span class="fw-bold">{{ $stats['orders']['delivered'] }}건</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 80%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted">취소됨</span>
                            <span class="fw-bold">{{ $stats['orders']['cancelled'] }}건</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 최근 주문 -->
        <div class="col-lg-8 col-md-12 col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">최근 주문</h4>
                    <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                        전체 보기
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>주문번호</th>
                                    <th>고객</th>
                                    <th>금액</th>
                                    <th>상태</th>
                                    <th>시간</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $order['id'] }}</span>
                                    </td>
                                    <td>{{ $order['customer_name'] }}</td>
                                    <td>{{ number_format($order['amount']) }} {{ $order['currency'] }}</td>
                                    <td>
                                        @if($order['status'] === 'processing')
                                            <span class="badge bg-warning">처리중</span>
                                        @elseif($order['status'] === 'shipped')
                                            <span class="badge bg-primary">배송중</span>
                                        @elseif($order['status'] === 'delivered')
                                            <span class="badge bg-success">배송완료</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order['created_at']->format('M j, H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        최근 주문이 없습니다.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 퀵 액션 & 알림 -->
        <div class="col-lg-4 col-md-12 col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">퀵 액션</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-primary">
                            <i class="fe fe-shopping-cart me-2"></i>주문 관리
                        </a>
                        <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-success">
                            <i class="fe fe-package me-2"></i>상품 관리
                        </a>
                        <a href="{{ route('admin.cms.ecommerce.shipping.index') }}" class="btn btn-outline-info">
                            <i class="fe fe-truck me-2"></i>배송 설정
                        </a>
                        <a href="{{ route('admin.cms.currencies.index') }}" class="btn btn-outline-warning">
                            <i class="fe fe-dollar-sign me-2"></i>통화 관리
                        </a>
                    </div>

                    <hr class="my-4">

                    <!-- 알림 -->
                    <h6 class="mb-3">알림</h6>
                    <div class="list-group list-group-flush">
                        @if($stats['products']['out_of_stock'] > 0)
                        <div class="list-group-item px-0 py-2 border-0">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="icon-shape icon-sm bg-light-danger text-danger rounded-circle">
                                        <i class="fe fe-alert-triangle"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 text-body">{{ $stats['products']['out_of_stock'] }}개 상품이 품절입니다</p>
                                    <span class="text-muted small">재고를 확인해주세요</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($stats['products']['low_stock'] > 0)
                        <div class="list-group-item px-0 py-2 border-0">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="icon-shape icon-sm bg-light-warning text-warning rounded-circle">
                                        <i class="fe fe-alert-circle"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 text-body">{{ $stats['products']['low_stock'] }}개 상품의 재고가 부족합니다</p>
                                    <span class="text-muted small">보충이 필요합니다</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="list-group-item px-0 py-2 border-0">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="icon-shape icon-sm bg-light-success text-success rounded-circle">
                                        <i class="fe fe-dollar-sign"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 text-body">환율이 {{ $stats['currency']['last_exchange_update'] ? '업데이트되었습니다' : '업데이트가 필요합니다' }}</p>
                                    <span class="text-muted small">{{ $stats['currency']['active_currencies'] }}개 통화 활성화됨</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 차트 초기화 (Chart.js 사용 예시)
document.addEventListener('DOMContentLoaded', function() {
    // 주문 현황 차트 데이터
    const chartData = {!! json_encode($chartData['daily_stats']) !!};

    // Chart.js가 로드되어 있다면 차트 그리기
    if (typeof Chart !== 'undefined') {
        const ctx = document.getElementById('ordersChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(item => item.date_label),
                    datasets: [{
                        label: '주문 수',
                        data: chartData.map(item => item.orders),
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    } else {
        // Chart.js가 없는 경우 간단한 텍스트 표시
        document.getElementById('ordersChart').innerHTML = '<div class="text-center text-muted py-5">차트 라이브러리를 로드해주세요</div>';
    }
});
</script>
@endpush
