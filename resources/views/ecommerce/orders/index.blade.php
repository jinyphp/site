@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
                <div>
                    <h1 class="mb-0 h2 fw-bold">Orders Management</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.dashboard') }}">Ecommerce</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body">
                        <i class="fe fe-download me-2"></i>Export
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.orders.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>수동 주문 생성
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 주문 통계 카드 -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0">{{ number_format($stats['total_orders']) }}</h4>
                    <p class="text-muted mb-0 small">전체 주문</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0 text-warning">{{ number_format($stats['pending_orders']) }}</h4>
                    <p class="text-muted mb-0 small">결제 대기</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0 text-info">{{ number_format($stats['processing_orders']) }}</h4>
                    <p class="text-muted mb-0 small">처리중</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0 text-primary">{{ number_format($stats['shipped_orders']) }}</h4>
                    <p class="text-muted mb-0 small">배송중</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0 text-success">{{ number_format($stats['delivered_orders']) }}</h4>
                    <p class="text-muted mb-0 small">배송완료</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body py-3">
                    <h4 class="mb-0 text-danger">{{ number_format($stats['cancelled_orders']) }}</h4>
                    <p class="text-muted mb-0 small">취소됨</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Card -->
            <div class="card rounded-3">
                <!-- Card Header -->
                <div class="card-header border-bottom-0 p-0">
                    <!-- nav -->
                    <ul class="nav nav-lb-tab" id="tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="all-orders-tab" data-bs-toggle="pill" href="#all-orders" role="tab">
                                전체 주문
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pending-tab" data-bs-toggle="pill" href="#pending" role="tab">결제 대기</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="processing-tab" data-bs-toggle="pill" href="#processing" role="tab">처리중</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shipped-tab" data-bs-toggle="pill" href="#shipped" role="tab">배송중</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="delivered-tab" data-bs-toggle="pill" href="#delivered" role="tab">배송완료</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cancelled-tab" data-bs-toggle="pill" href="#cancelled" role="tab">취소됨</a>
                        </li>
                    </ul>
                </div>

                <!-- 필터 및 검색 -->
                <div class="p-4 row g-3">
                    <div class="col-12 col-lg-6">
                        <form class="d-flex align-items-center" method="GET">
                            <span class="position-absolute ps-3 search-icon">
                                <i class="fe fe-search"></i>
                            </span>
                            <input type="search"
                                   class="form-control ps-6"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="주문번호, 고객명, 이메일로 검색...">
                        </form>
                    </div>
                    <div class="col-6 col-lg-3">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="" {{ request('status') === '' ? 'selected' : '' }}>모든 상태</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>결제 대기</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>처리중</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>배송중</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>배송완료</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>취소됨</option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>환불됨</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-3">
                        <select class="form-select" name="payment_status" onchange="this.form.submit()">
                            <option value="all" {{ request('payment_status') === 'all' ? 'selected' : '' }}>모든 결제상태</option>
                            <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>결제 대기</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>결제 완료</option>
                            <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>결제 실패</option>
                            <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>환불됨</option>
                        </select>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="tabContent">
                    <div class="tab-pane fade show active" id="all-orders" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        <th scope="col">주문번호</th>
                                        <th scope="col">고객정보</th>
                                        <th scope="col">상품수</th>
                                        <th scope="col">주문금액</th>
                                        <th scope="col">결제상태</th>
                                        <th scope="col">주문상태</th>
                                        <th scope="col">배송방법</th>
                                        <th scope="col">주문일시</th>
                                        <th scope="col">액션</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input" value="{{ $order->id }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cms.ecommerce.orders.show', $order->id) }}" class="fw-bold text-decoration-none">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $order->customer_name }}</h6>
                                                <p class="text-muted mb-0 small">{{ $order->customer_email }}</p>
                                                <p class="text-muted mb-0 small">{{ $order->customer_phone }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-secondary text-secondary">
                                                {{ count($order->order_items) }}개
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ number_format($order->total_amount) }} {{ $order->currency }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $order->payment_status_badge }}">
                                                @if($order->payment_status === 'paid')
                                                    결제완료
                                                @elseif($order->payment_status === 'pending')
                                                    결제대기
                                                @elseif($order->payment_status === 'failed')
                                                    결제실패
                                                @elseif($order->payment_status === 'refunded')
                                                    환불됨
                                                @else
                                                    {{ $order->payment_status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <span class="badge {{ $order->status_badge }} dropdown-toggle"
                                                      data-bs-toggle="dropdown" style="cursor: pointer;">
                                                    @if($order->status === 'pending')
                                                        결제대기
                                                    @elseif($order->status === 'processing')
                                                        처리중
                                                    @elseif($order->status === 'shipped')
                                                        배송중
                                                    @elseif($order->status === 'delivered')
                                                        배송완료
                                                    @elseif($order->status === 'cancelled')
                                                        취소됨
                                                    @elseif($order->status === 'refunded')
                                                        환불됨
                                                    @else
                                                        {{ $order->status }}
                                                    @endif
                                                </span>
                                                <ul class="dropdown-menu">
                                                    @if($order->status !== 'pending')
                                                        <li><a class="dropdown-item status-change-btn" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="pending">결제대기</a></li>
                                                    @endif
                                                    @if($order->status !== 'processing')
                                                        <li><a class="dropdown-item status-change-btn" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="processing">처리중</a></li>
                                                    @endif
                                                    @if($order->status !== 'shipped')
                                                        <li><a class="dropdown-item status-change-btn" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="shipped">배송중</a></li>
                                                    @endif
                                                    @if($order->status !== 'delivered')
                                                        <li><a class="dropdown-item status-change-btn" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="delivered">배송완료</a></li>
                                                    @endif
                                                    @if($order->status !== 'cancelled')
                                                        <li><a class="dropdown-item status-change-btn text-warning" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="cancelled">취소됨</a></li>
                                                    @endif
                                                    @if($order->status !== 'refunded')
                                                        <li><a class="dropdown-item status-change-btn text-danger" href="#"
                                                               data-order-id="{{ $order->id }}" data-status="refunded">환불됨</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->payment_method === 'standard')
                                                <span class="text-muted">표준배송</span>
                                            @elseif($order->payment_method === 'express')
                                                <span class="text-primary">특급배송</span>
                                            @else
                                                <span class="text-muted">{{ $order->payment_method ?? '-' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <p class="mb-0">{{ $order->created_at->format('Y.m.d') }}</p>
                                                <p class="text-muted mb-0 small">{{ $order->created_at->format('H:i') }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    액션
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('admin.cms.ecommerce.orders.show', $order->id) }}"><i class="fe fe-eye me-2"></i>상세보기</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fe fe-edit me-2"></i>수정</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fe fe-printer me-2"></i>인쇄</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fe fe-shopping-cart fs-1 mb-3"></i>
                                                <p>주문이 없습니다.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                        <div class="card-footer border-top-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-0">
                                        {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }} results
                                    </p>
                                </div>
                                <div>
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 전체 선택 체크박스
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');

    checkAll?.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // 개별 체크박스 상태에 따라 전체 선택 체크박스 상태 업데이트
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (checkAll) {
                checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            }
        });
    });

    // 탭 클릭 시 필터 적용
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('click', function() {
            const status = this.id.replace('-tab', '');
            const url = new URL(window.location);

            // 전체 주문 탭인 경우 status 파라미터 제거
            if (status === 'all-orders') {
                url.searchParams.delete('status');
            } else {
                url.searchParams.set('status', status);
            }

            window.location.href = url.toString();
        });
    });

    // 상태 변경 버튼 클릭 이벤트
    document.querySelectorAll('.status-change-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const orderId = this.dataset.orderId;
            const newStatus = this.dataset.status;
            const statusLabels = {
                'pending': '결제대기',
                'processing': '처리중',
                'shipped': '배송중',
                'delivered': '배송완료',
                'cancelled': '취소됨',
                'refunded': '환불됨'
            };

            if (!confirm(`주문 상태를 '${statusLabels[newStatus]}'로 변경하시겠습니까?`)) {
                return;
            }

            // 버튼 비활성화
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';

            fetch(`/admin/cms/ecommerce/orders/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action: 'update_status',
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 성공 시 페이지 새로고침
                    window.location.reload();
                } else {
                    alert('상태 변경에 실패했습니다: ' + (data.error || '알 수 없는 오류'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('오류가 발생했습니다.');
            })
            .finally(() => {
                // 버튼 다시 활성화
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            });
        });
    });
});
</script>
@endpush
