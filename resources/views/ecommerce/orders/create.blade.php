@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '수동 주문 생성')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
                <div>
                    <h1 class="mb-0 h2 fw-bold">수동 주문 생성</h1>
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
                            <li class="breadcrumb-item active" aria-current="page">새 주문</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.cms.ecommerce.orders.store') }}" method="POST" id="order-form">
        @csrf
        <div class="row">
            <!-- 왼쪽 컬럼 -->
            <div class="col-lg-8 col-md-12 col-12">
                <!-- 고객 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">고객 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">기존 회원 선택 (선택사항)</label>
                                    <select class="form-select" name="user_id" id="user-select">
                                        <option value="">새 고객</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-email="{{ $user->email }}">
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">고객명 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                           name="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">이메일 <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                           name="customer_email" value="{{ old('customer_email') }}" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">전화번호</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                           name="customer_phone" value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 주문 상품 -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">주문 상품</h5>
                        <button type="button" class="btn btn-sm btn-primary" id="add-item-btn">
                            <i class="fe fe-plus me-1"></i>상품 추가
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="order-items">
                            <div class="order-item border-bottom pb-3 mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">상품명 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="items[0][name]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">수량 <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control item-quantity"
                                                   name="items[0][quantity]" value="1" min="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">단가 <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control item-price"
                                                   name="items[0][price]" value="0" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">SKU</label>
                                            <input type="text" class="form-control" name="items[0][sku]">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">소계</label>
                                            <input type="text" class="form-control item-total" readonly value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 배송 주소 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">배송 주소</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">주소 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_street') is-invalid @enderror"
                                           name="shipping_street" value="{{ old('shipping_street') }}" required>
                                    @error('shipping_street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">도시 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_city') is-invalid @enderror"
                                           name="shipping_city" value="{{ old('shipping_city') }}" required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">주/도</label>
                                    <input type="text" class="form-control @error('shipping_state') is-invalid @enderror"
                                           name="shipping_state" value="{{ old('shipping_state') }}">
                                    @error('shipping_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">우편번호</label>
                                    <input type="text" class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                           name="shipping_postal_code" value="{{ old('shipping_postal_code') }}">
                                    @error('shipping_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">국가 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shipping_country') is-invalid @enderror"
                                           name="shipping_country" value="{{ old('shipping_country', 'Korea') }}" required>
                                    @error('shipping_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox"
                                   name="billing_same_as_shipping" value="1"
                                   id="billing-same" {{ old('billing_same_as_shipping') ? 'checked' : '' }}>
                            <label class="form-check-label" for="billing-same">
                                청구 주소와 배송 주소 동일
                            </label>
                        </div>

                        <!-- 청구 주소 (조건부 표시) -->
                        <div id="billing-address" style="{{ old('billing_same_as_shipping') ? 'display: none;' : '' }}">
                            <h6 class="mb-3">청구 주소</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">주소</label>
                                        <input type="text" class="form-control" name="billing_street" value="{{ old('billing_street') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">도시</label>
                                        <input type="text" class="form-control" name="billing_city" value="{{ old('billing_city') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">주/도</label>
                                        <input type="text" class="form-control" name="billing_state" value="{{ old('billing_state') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">우편번호</label>
                                        <input type="text" class="form-control" name="billing_postal_code" value="{{ old('billing_postal_code') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">국가</label>
                                        <input type="text" class="form-control" name="billing_country" value="{{ old('billing_country', 'Korea') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 오른쪽 컬럼 -->
            <div class="col-lg-4 col-md-12 col-12">
                <!-- 주문 상태 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">주문 상태</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">주문 상태 <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="">상태 선택</option>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>결제대기</option>
                                <option value="processing" {{ old('status') === 'processing' ? 'selected' : '' }}>처리중</option>
                                <option value="shipped" {{ old('status') === 'shipped' ? 'selected' : '' }}>배송중</option>
                                <option value="delivered" {{ old('status') === 'delivered' ? 'selected' : '' }}>배송완료</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>취소됨</option>
                                <option value="refunded" {{ old('status') === 'refunded' ? 'selected' : '' }}>환불됨</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">결제 상태 <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" name="payment_status" required>
                                <option value="">결제 상태 선택</option>
                                <option value="pending" {{ old('payment_status') === 'pending' ? 'selected' : '' }}>결제대기</option>
                                <option value="paid" {{ old('payment_status') === 'paid' ? 'selected' : '' }}>결제완료</option>
                                <option value="failed" {{ old('payment_status') === 'failed' ? 'selected' : '' }}>결제실패</option>
                                <option value="refunded" {{ old('payment_status') === 'refunded' ? 'selected' : '' }}>환불됨</option>
                                <option value="cancelled" {{ old('payment_status') === 'cancelled' ? 'selected' : '' }}>취소됨</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">결제 방법</label>
                            <select class="form-select" name="payment_method">
                                <option value="">선택</option>
                                <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>신용카드</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>계좌이체</option>
                                <option value="paypal" {{ old('payment_method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>현금</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">결제 ID</label>
                            <input type="text" class="form-control" name="payment_id" value="{{ old('payment_id') }}">
                        </div>
                    </div>
                </div>

                <!-- 가격 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">가격 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">소계 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('subtotal') is-invalid @enderror"
                                   name="subtotal" id="subtotal" value="{{ old('subtotal', 0) }}"
                                   min="0" step="0.01" readonly required>
                            @error('subtotal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">세금</label>
                            <input type="number" class="form-control @error('tax_amount') is-invalid @enderror"
                                   name="tax_amount" id="tax_amount" value="{{ old('tax_amount', 0) }}"
                                   min="0" step="0.01">
                            @error('tax_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">배송비</label>
                            <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror"
                                   name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', 0) }}"
                                   min="0" step="0.01">
                            @error('shipping_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">할인</label>
                            <input type="number" class="form-control @error('discount_amount') is-invalid @enderror"
                                   name="discount_amount" id="discount_amount" value="{{ old('discount_amount', 0) }}"
                                   min="0" step="0.01">
                            @error('discount_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label fw-bold">총 금액 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control fw-bold @error('total_amount') is-invalid @enderror"
                                   name="total_amount" id="total_amount" value="{{ old('total_amount', 0) }}"
                                   min="0" step="0.01" readonly required>
                            @error('total_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 주문 메모 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">주문 메모</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      name="notes" rows="4" placeholder="주문 관련 메모를 입력하세요">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 저장 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fe fe-save me-2"></i>주문 생성
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // 기존 회원 선택 시 고객 정보 자동 입력
    document.getElementById('user-select')?.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            document.querySelector('input[name="customer_name"]').value = option.dataset.name || '';
            document.querySelector('input[name="customer_email"]').value = option.dataset.email || '';
        }
    });

    // 청구 주소 동일 여부 토글
    document.getElementById('billing-same')?.addEventListener('change', function() {
        const billingAddress = document.getElementById('billing-address');
        billingAddress.style.display = this.checked ? 'none' : 'block';
    });

    // 상품 추가 버튼
    document.getElementById('add-item-btn')?.addEventListener('click', function() {
        const orderItems = document.getElementById('order-items');
        const newItem = document.createElement('div');
        newItem.className = 'order-item border-bottom pb-3 mb-3';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">상품명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="items[${itemIndex}][name]" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">수량 <span class="text-danger">*</span></label>
                        <input type="number" class="form-control item-quantity"
                               name="items[${itemIndex}][quantity]" value="1" min="1" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">단가 <span class="text-danger">*</span></label>
                        <input type="number" class="form-control item-price"
                               name="items[${itemIndex}][price]" value="0" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" class="form-control" name="items[${itemIndex}][sku]">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="mb-3">
                        <label class="form-label">소계</label>
                        <input type="text" class="form-control item-total" readonly value="0">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-outline-danger w-100 remove-item-btn">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        orderItems.appendChild(newItem);
        itemIndex++;

        // 새로 추가된 아이템에 이벤트 리스너 추가
        attachItemEventListeners(newItem);
    });

    // 상품 삭제 이벤트 (이벤트 위임)
    document.getElementById('order-items')?.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            e.target.closest('.order-item').remove();
            calculateTotals();
        }
    });

    // 아이템별 이벤트 리스너 추가 함수
    function attachItemEventListeners(container = document) {
        const quantityInputs = container.querySelectorAll('.item-quantity');
        const priceInputs = container.querySelectorAll('.item-price');

        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateItemTotal);
        });

        priceInputs.forEach(input => {
            input.addEventListener('input', calculateItemTotal);
        });
    }

    // 개별 아이템 총액 계산
    function calculateItemTotal(e) {
        const item = e.target.closest('.order-item');
        const quantity = parseFloat(item.querySelector('.item-quantity').value) || 0;
        const price = parseFloat(item.querySelector('.item-price').value) || 0;
        const total = quantity * price;

        item.querySelector('.item-total').value = total.toFixed(2);
        calculateTotals();
    }

    // 전체 총액 계산
    function calculateTotals() {
        const itemTotals = document.querySelectorAll('.item-total');
        let subtotal = 0;

        itemTotals.forEach(input => {
            subtotal += parseFloat(input.value) || 0;
        });

        document.getElementById('subtotal').value = subtotal.toFixed(2);

        const taxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;
        const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
        const discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;

        const totalAmount = subtotal + taxAmount + shippingCost - discountAmount;
        document.getElementById('total_amount').value = Math.max(0, totalAmount).toFixed(2);
    }

    // 세금, 배송비, 할인 변경 시 총액 재계산
    ['tax_amount', 'shipping_cost', 'discount_amount'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', calculateTotals);
    });

    // 초기 이벤트 리스너 설정
    attachItemEventListeners();
});
</script>
@endpush
