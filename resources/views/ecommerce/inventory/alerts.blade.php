@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>재고 목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 알림 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-alert-triangle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">부족 재고</h6>
                            <h4 class="mb-0">{{ $stats['low_stock_count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-x-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">품절 상품</h6>
                            <h4 class="mb-0">{{ $stats['out_of_stock_count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-trending-up text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">과다 재고</h6>
                            <h4 class="mb-0">{{ $stats['over_stock_count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-package text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 상품</h6>
                            <h4 class="mb-0">{{ $stats['total_items'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-dollar-sign text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">총 재고 가치</h6>
                            <h4 class="mb-0">₩{{ number_format($stats['total_value']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 재고 부족 알림 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-warning">
                        <i class="fe fe-alert-triangle me-2"></i>재고 부족 상품
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($lowStockItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>상품</th>
                                        <th width="80">현재고</th>
                                        <th width="80">임계값</th>
                                        <th width="100">위치</th>
                                        <th width="80">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockItems as $item)
                                    <tr class="table-warning">
                                        <td>
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product_sku)
                                                    <br><small class="text-muted">{{ $item->product_sku }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ number_format($item->quantity) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ number_format($item->low_stock_threshold) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->location }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.ecommerce.inventory.stock-in') }}"
                                               class="btn btn-sm btn-outline-success"
                                               title="입고">
                                                <i class="fe fe-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-check-circle fe-2x text-success mb-2"></i>
                            <p class="text-muted">재고 부족 상품이 없습니다</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 품절 상품 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-danger">
                        <i class="fe fe-x-circle me-2"></i>품절 상품
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($outOfStockItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>상품</th>
                                        <th width="100">위치</th>
                                        <th width="120">마지막 업데이트</th>
                                        <th width="80">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outOfStockItems as $item)
                                    <tr class="table-danger">
                                        <td>
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product_sku)
                                                    <br><small class="text-muted">{{ $item->product_sku }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->location }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->format('m/d H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.ecommerce.inventory.stock-in') }}"
                                               class="btn btn-sm btn-outline-success"
                                               title="입고">
                                                <i class="fe fe-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-check-circle fe-2x text-success mb-2"></i>
                            <p class="text-muted">품절 상품이 없습니다</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 과다 재고 및 최근 변동 내역 -->
    <div class="row mt-4">
        <!-- 과다 재고 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-info">
                        <i class="fe fe-trending-up me-2"></i>과다 재고 상품
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($overStockItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>상품</th>
                                        <th width="80">현재고</th>
                                        <th width="80">임계값</th>
                                        <th width="100">위치</th>
                                        <th width="80">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($overStockItems as $item)
                                    <tr class="table-info">
                                        <td>
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product_sku)
                                                    <br><small class="text-muted">{{ $item->product_sku }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ number_format($item->quantity) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ number_format($item->low_stock_threshold * 3) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->location }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.ecommerce.inventory.stock-out') }}"
                                               class="btn btn-sm btn-outline-danger"
                                               title="출고">
                                                <i class="fe fe-minus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-check-circle fe-2x text-success mb-2"></i>
                            <p class="text-muted">과다 재고 상품이 없습니다</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 최근 재고 변동 내역 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fe fe-activity me-2"></i>최근 재고 변동
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>상품</th>
                                        <th width="80">유형</th>
                                        <th width="80">수량</th>
                                        <th width="100">처리자</th>
                                        <th width="120">일시</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $transaction->product_name }}</strong>
                                                @if($transaction->product_sku)
                                                    <br><small class="text-muted">{{ $transaction->product_sku }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($transaction->type === 'inbound')
                                                <span class="badge bg-success">입고</span>
                                            @else
                                                <span class="badge bg-danger">출고</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->type === 'inbound')
                                                <span class="text-success">+{{ number_format($transaction->quantity) }}</span>
                                            @else
                                                <span class="text-danger">-{{ number_format($transaction->quantity) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $transaction->created_by_name ?? 'System' }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('m/d H:i') }}
                                            </small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fe fe-inbox fe-2x text-muted mb-2"></i>
                            <p class="text-muted">최근 재고 변동이 없습니다</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* 통계 카드 원형 아이콘 스타일 */
.stat-circle {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px;
    min-height: 48px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.stat-circle i {
    font-size: 20px;
}

/* 알림 행 스타일 */
.table-warning td {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.table-danger td {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.table-info td {
    background-color: rgba(13, 202, 240, 0.1) !important;
}
</style>
@endpush

@push('scripts')
<script>
// 자동 새로고침 (5분마다)
setInterval(function() {
    location.reload();
}, 300000);

// 알림 설정 변경 시 저장
function updateAlertSettings() {
    // 알림 설정 업데이트 로직 추가 예정
    console.log('알림 설정 업데이트');
}
</script>
@endpush
