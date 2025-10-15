@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '장바구니')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- 장바구니 아이템 목록 -->
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">장바구니</h2>
                @if($cartItems->count() > 0)
                    <span class="text-muted">{{ $summary['item_count'] }}개 상품</span>
                @endif
            </div>

            @if($cartItems->count() > 0)
                <div class="cart-items">
                    @foreach($cartItems as $index => $item)
                        <div class="cart-item py-4 {{ $index > 0 ? 'border-top' : '' }}" data-cart-id="{{ $item->id }}">
                            <div class="row align-items-center">
                                <!-- 상품 이미지 -->
                                <div class="col-md-2">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                             class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 100px; height: 100px;">
                                            <i class="fe fe-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- 상품 정보 -->
                                <div class="col-md-4">
                                    <h5 class="mb-1">
                                        <a href="/{{ $item->item_type }}/{{ $item->item_id }}" class="text-decoration-none">
                                            {{ $item->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-1">
                                        {{ $item->item_type === 'product' ? '상품' : '서비스' }}
                                    </p>
                                    @if($item->pricing_name)
                                        <p class="text-primary small mb-0">
                                            <i class="fe fe-tag me-1"></i>{{ $item->pricing_name }}
                                        </p>
                                    @endif
                                </div>

                                <!-- 수량 조절 -->
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-sm quantity-btn"
                                                type="button"
                                                onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="fe fe-minus"></i>
                                        </button>
                                        <input type="number"
                                               class="form-control form-control-sm text-center quantity-input"
                                               value="{{ $item->quantity }}"
                                               min="1"
                                               max="99"
                                               onchange="updateQuantity({{ $item->id }}, this.value)">
                                        <button class="btn btn-outline-secondary btn-sm quantity-btn"
                                                type="button"
                                                onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                {{ $item->quantity >= 99 ? 'disabled' : '' }}>
                                            <i class="fe fe-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- 가격 -->
                                <div class="col-md-2 text-center">
                                    <p class="mb-0 fw-bold">{{ $item->final_price_formatted ?? '0원' }}</p>
                                    @if($item->quantity > 1)
                                        <small class="text-muted">단가: {{ $item->final_price_formatted ?? '0원' }}</small>
                                    @endif
                                </div>

                                <!-- 소계 및 삭제 -->
                                <div class="col-md-2 text-end">
                                    <p class="mb-1 fw-bold h6">{{ $item->total_price_formatted ?? '0원' }}</p>
                                    <button type="button"
                                            class="btn btn-link btn-sm text-danger p-0"
                                            onclick="removeFromCart({{ $item->id }})"
                                            title="삭제">
                                        <i class="fe fe-trash-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 계속 쇼핑 버튼 -->
                <div class="mt-4">
                    <a href="/" class="btn btn-outline-primary">
                        <i class="fe fe-arrow-left me-2"></i>계속 쇼핑하기
                    </a>
                </div>
            @else
                <!-- 빈 장바구니 -->
                <div class="text-center py-5">
                    <i class="fe fe-shopping-cart text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">장바구니가 비어있습니다</h4>
                    <p class="text-muted">원하는 상품을 장바구니에 담아보세요!</p>
                    <a href="/" class="btn btn-primary mt-3">
                        <i class="fe fe-shopping-bag me-2"></i>쇼핑 시작하기
                    </a>
                </div>
            @endif
        </div>

        <!-- 주문 요약 -->
        @if($cartItems->count() > 0)
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 2rem;">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">주문 요약</h5>
                            <div class="text-muted">
                                <small>{{ $currency['currency_symbol'] ?? '₩' }} {{ $currency['user_currency'] ?? 'KRW' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>상품 {{ $summary['item_count'] }}개</span>
                            <span>{{ $summary['subtotal_formatted'] ?? '0원' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>배송비</span>
                            <span class="text-success">무료</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span>{{ $summary['tax_name'] ?? 'VAT' }} ({{ number_format($summary['tax_rate_percent'] ?? 0, 1) }}%)</span>
                                <br>
                                <small class="text-muted">{{ $summary['country_name'] ?? 'Unknown' }} 적용</small>
                            </div>
                            <span>{{ $summary['tax_amount_formatted'] ?? '0원' }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>총 결제금액</strong>
                            <strong class="text-primary h5">{{ $summary['total_formatted'] ?? '0원' }}</strong>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary btn-lg" onclick="proceedToCheckout()">
                                <i class="fe fe-credit-card me-2"></i>주문하기
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="requestQuoteAll()">
                                <i class="fe fe-file-text me-2"></i>견적 요청
                            </button>
                        </div>

                        <!-- 보안 및 신뢰 표시 -->
                        <div class="mt-4 text-center">
                            <small class="text-muted">
                                <i class="fe fe-shield me-1"></i>
                                안전한 결제 시스템
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.cart-item {
    transition: background-color 0.2s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.quantity-input {
    width: 60px;
}

.quantity-btn {
    width: 35px;
    height: 35px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cart-message {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .cart-item .row {
        text-align: center;
    }

    .cart-item .col-md-2,
    .cart-item .col-md-4 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// 수량 업데이트
function updateQuantity(cartId, newQuantity) {
    newQuantity = parseInt(newQuantity);

    if (newQuantity < 1 || newQuantity > 99) {
        return;
    }

    fetch(`/cart/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 페이지 새로고침으로 업데이트된 내용 반영
            window.location.reload();
        } else {
            showCartMessage(data.message || '수량 업데이트 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showCartMessage('수량 업데이트 중 오류가 발생했습니다.', 'error');
    });
}

// 장바구니에서 제거
function removeFromCart(cartId) {
    if (!confirm('이 상품을 장바구니에서 제거하시겠습니까?')) {
        return;
    }

    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 페이지 새로고침으로 업데이트된 내용 반영
            window.location.reload();
        } else {
            showCartMessage(data.message || '상품 제거 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showCartMessage('상품 제거 중 오류가 발생했습니다.', 'error');
    });
}

// 주문 진행
function proceedToCheckout() {
    // 여기에서 실제 주문 시스템으로 연결
    alert('주문 시스템은 준비 중입니다. 견적 요청을 이용해주세요.');
}

// 전체 견적 요청
function requestQuoteAll() {
    // 장바구니의 모든 아이템을 포함한 견적 요청
    window.location.href = '/contact/create?cart=all&type=quote';
}

// 메시지 표시 함수 (제품 페이지와 동일)
function showCartMessage(message, type = 'info') {
    const existingMessage = document.querySelector('.cart-message');
    if (existingMessage) {
        existingMessage.remove();
    }

    const messageDiv = document.createElement('div');
    messageDiv.className = `cart-message alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    messageDiv.style.position = 'fixed';
    messageDiv.style.top = '20px';
    messageDiv.style.right = '20px';
    messageDiv.style.zIndex = '9999';
    messageDiv.style.minWidth = '300px';
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        if (messageDiv && messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
}
</script>
@endpush
