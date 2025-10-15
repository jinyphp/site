@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '주문 상세보기')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
                <div>
                    <h1 class="mb-0 h2 fw-bold">주문 상세보기</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.dashboard') }}">Ecommerce</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.orders.index') }}">Orders</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fe fe-printer me-2"></i>인쇄
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fe fe-file-text me-2"></i>주문서</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fe fe-truck me-2"></i>배송라벨</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fe fe-credit-card me-2"></i>영수증</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 주문 정보 -->
        <div class="col-lg-8 col-md-12 col-12">
            <!-- 주문 기본 정보 -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">주문 정보</h5>
                    <div class="d-flex gap-2">
                        <span class="badge {{ $order->status_badge }}">
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
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">주문번호</h6>
                            <p class="text-muted mb-3">{{ $order->order_number }}</p>

                            <h6 class="fw-bold mb-2">주문일시</h6>
                            <p class="text-muted mb-3">{{ $order->created_at->format('Y년 m월 d일 H:i') }}</p>

                            @if($order->shipped_at)
                            <h6 class="fw-bold mb-2">배송일시</h6>
                            <p class="text-muted mb-3">{{ $order->shipped_at->format('Y년 m월 d일 H:i') }}</p>
                            @endif

                            @if($order->delivered_at)
                            <h6 class="fw-bold mb-2">배송완료일시</h6>
                            <p class="text-muted mb-3">{{ $order->delivered_at->format('Y년 m월 d일 H:i') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">결제방법</h6>
                            <p class="text-muted mb-3">{{ $order->payment_method ?? '-' }}</p>

                            @if($order->payment_id)
                            <h6 class="fw-bold mb-2">결제ID</h6>
                            <p class="text-muted mb-3">{{ $order->payment_id }}</p>
                            @endif

                            @if($order->notes)
                            <h6 class="fw-bold mb-2">주문 메모</h6>
                            <p class="text-muted mb-3">{{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 고객 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">고객 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">고객명</h6>
                            <p class="text-muted mb-3">{{ $order->customer_name }}</p>

                            <h6 class="fw-bold mb-2">이메일</h6>
                            <p class="text-muted mb-3">{{ $order->customer_email }}</p>

                            @if($order->customer_phone)
                            <h6 class="fw-bold mb-2">전화번호</h6>
                            <p class="text-muted mb-3">{{ $order->customer_phone }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($order->user)
                            <h6 class="fw-bold mb-2">회원 정보</h6>
                            <p class="text-muted mb-3">
                                <a href="#" class="text-decoration-none">{{ $order->user->name }}</a>
                                <br><small class="text-muted">{{ $order->user->email }}</small>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 주문 상품 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">주문 상품</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>상품명</th>
                                    <th>수량</th>
                                    <th>단가</th>
                                    <th>합계</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_items as $item)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $item['name'] }}</h6>
                                            @if(isset($item['sku']))
                                            <small class="text-muted">SKU: {{ $item['sku'] }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ number_format($item['price']) }} {{ $order->currency }}</td>
                                    <td>{{ number_format($item['price'] * $item['quantity']) }} {{ $order->currency }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4 col-md-12 col-12">
            <!-- 상태 변경 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">주문 상태 변경</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">현재 상태</label>
                        <div id="current-status">
                            <span class="badge {{ $order->status_badge }}">
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
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">상태 변경</label>
                        <select class="form-select" id="status-select">
                            <option value="">상태 선택</option>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>결제대기</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>처리중</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>배송중</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>배송완료</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>취소됨</option>
                            <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>환불됨</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="update-status-btn">
                        <i class="fe fe-check me-2"></i>상태 변경
                    </button>
                </div>
            </div>

            <!-- 배송 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">배송 정보</h5>
                </div>
                <div class="card-body">
                    @if($order->shipping_address)
                        <h6 class="fw-bold mb-2">배송 주소</h6>
                        <address class="text-muted mb-3">
                            {{ $order->shipping_address['street'] ?? '' }}<br>
                            {{ $order->shipping_address['city'] ?? '' }}
                            {{ $order->shipping_address['state'] ?? '' }}
                            {{ $order->shipping_address['postal_code'] ?? '' }}<br>
                            {{ $order->shipping_address['country'] ?? '' }}
                        </address>
                    @endif

                    @if($order->billing_address)
                        <h6 class="fw-bold mb-2">청구 주소</h6>
                        <address class="text-muted mb-3">
                            {{ $order->billing_address['street'] ?? '' }}<br>
                            {{ $order->billing_address['city'] ?? '' }}
                            {{ $order->billing_address['state'] ?? '' }}
                            {{ $order->billing_address['postal_code'] ?? '' }}<br>
                            {{ $order->billing_address['country'] ?? '' }}
                        </address>
                    @endif
                </div>
            </div>

            <!-- 결제 정보 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">결제 정보</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>소계</span>
                        <span>{{ number_format($order->subtotal) }} {{ $order->currency }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>세금</span>
                        <span>{{ number_format($order->tax_amount) }} {{ $order->currency }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>배송비</span>
                        <span>{{ number_format($order->shipping_cost) }} {{ $order->currency }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>할인</span>
                        <span>-{{ number_format($order->discount_amount) }} {{ $order->currency }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold h5">
                        <span>총 금액</span>
                        <span>{{ number_format($order->total_amount) }} {{ $order->currency }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 알림 모달 -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">상태 변경</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="status-update-message"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">확인</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateBtn = document.getElementById('update-status-btn');
    const statusSelect = document.getElementById('status-select');
    const currentStatusEl = document.getElementById('current-status');
    const modal = new bootstrap.Modal(document.getElementById('statusUpdateModal'));

    updateBtn?.addEventListener('click', function() {
        const newStatus = statusSelect.value;

        if (!newStatus) {
            alert('변경할 상태를 선택해주세요.');
            return;
        }

        if (newStatus === '{{ $order->status }}') {
            alert('현재 상태와 동일합니다.');
            return;
        }

        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>변경중...';

        fetch(window.location.href, {
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
                // 성공 메시지 표시
                document.getElementById('status-update-message').innerHTML =
                    '<div class="alert alert-success mb-0">' + data.message + '</div>';
                modal.show();

                // 현재 상태 업데이트
                const statusLabels = {
                    'pending': '결제대기',
                    'processing': '처리중',
                    'shipped': '배송중',
                    'delivered': '배송완료',
                    'cancelled': '취소됨',
                    'refunded': '환불됨'
                };

                currentStatusEl.innerHTML = `<span class="${data.status_badge}">${statusLabels[newStatus] || newStatus}</span>`;

                // 페이지 새로고침 (업데이트된 정보 반영)
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                document.getElementById('status-update-message').innerHTML =
                    '<div class="alert alert-danger mb-0">' + (data.error || '상태 변경에 실패했습니다.') + '</div>';
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('status-update-message').innerHTML =
                '<div class="alert alert-danger mb-0">오류가 발생했습니다.</div>';
            modal.show();
        })
        .finally(() => {
            updateBtn.disabled = false;
            updateBtn.innerHTML = '<i class="fe fe-check me-2"></i>상태 변경';
        });
    });
});
</script>
@endpush
