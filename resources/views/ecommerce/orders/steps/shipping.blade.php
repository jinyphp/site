@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">새 주문 생성 - 3단계: 배송/청구 정보</h1>
                <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>주문 목록으로
                </a>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <small class="text-success">✓ 1. 고객 정보</small>
                <small class="text-success">✓ 2. 상품 선택</small>
                <small class="text-primary fw-bold">3. 배송/청구</small>
                <small class="text-muted">4. 결제/완료</small>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('admin.cms.ecommerce.orders.step', 3) }}" id="shippingForm">
                @csrf

                <!-- 배송 주소 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">배송 주소</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="shipping_street" class="form-label">주소 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="shipping_street" name="shipping_street"
                                       value="{{ old('shipping_street', $stepData['shipping']['shipping_address']['street'] ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_city" class="form-label">도시 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="shipping_city" name="shipping_city"
                                       value="{{ old('shipping_city', $stepData['shipping']['shipping_address']['city'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_state" class="form-label">시/도</label>
                                <input type="text" class="form-control" id="shipping_state" name="shipping_state"
                                       value="{{ old('shipping_state', $stepData['shipping']['shipping_address']['state'] ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_postal_code" class="form-label">우편번호</label>
                                <input type="text" class="form-control" id="shipping_postal_code" name="shipping_postal_code"
                                       value="{{ old('shipping_postal_code', $stepData['shipping']['shipping_address']['postal_code'] ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_country" class="form-label">국가 <span class="text-danger">*</span></label>
                                <select class="form-select" id="shipping_country" name="shipping_country" required>
                                    <option value="">국가 선택</option>
                                    <option value="대한민국" {{ old('shipping_country', $stepData['shipping']['shipping_address']['country'] ?? '') == '대한민국' ? 'selected' : '' }}>대한민국</option>
                                    <option value="미국" {{ old('shipping_country', $stepData['shipping']['shipping_address']['country'] ?? '') == '미국' ? 'selected' : '' }}>미국</option>
                                    <option value="일본" {{ old('shipping_country', $stepData['shipping']['shipping_address']['country'] ?? '') == '일본' ? 'selected' : '' }}>일본</option>
                                    <option value="중국" {{ old('shipping_country', $stepData['shipping']['shipping_address']['country'] ?? '') == '중국' ? 'selected' : '' }}>중국</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 청구 주소 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">청구 주소</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="billing_same_as_shipping" name="billing_same_as_shipping"
                                   value="1" {{ old('billing_same_as_shipping') ? 'checked' : '' }} onchange="toggleBillingAddress()">
                            <label class="form-check-label" for="billing_same_as_shipping">
                                배송 주소와 동일
                            </label>
                        </div>

                        <div id="billingAddressFields" style="{{ old('billing_same_as_shipping') ? 'display: none;' : '' }}">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="billing_street" class="form-label">주소</label>
                                    <input type="text" class="form-control" id="billing_street" name="billing_street"
                                           value="{{ old('billing_street', $stepData['shipping']['billing_address']['street'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_city" class="form-label">도시</label>
                                    <input type="text" class="form-control" id="billing_city" name="billing_city"
                                           value="{{ old('billing_city', $stepData['shipping']['billing_address']['city'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_state" class="form-label">시/도</label>
                                    <input type="text" class="form-control" id="billing_state" name="billing_state"
                                           value="{{ old('billing_state', $stepData['shipping']['billing_address']['state'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_postal_code" class="form-label">우편번호</label>
                                    <input type="text" class="form-control" id="billing_postal_code" name="billing_postal_code"
                                           value="{{ old('billing_postal_code', $stepData['shipping']['billing_address']['postal_code'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_country" class="form-label">국가</label>
                                    <select class="form-select" id="billing_country" name="billing_country">
                                        <option value="">국가 선택</option>
                                        <option value="대한민국" {{ old('billing_country', $stepData['shipping']['billing_address']['country'] ?? '') == '대한민국' ? 'selected' : '' }}>대한민국</option>
                                        <option value="미국" {{ old('billing_country', $stepData['shipping']['billing_address']['country'] ?? '') == '미국' ? 'selected' : '' }}>미국</option>
                                        <option value="일본" {{ old('billing_country', $stepData['shipping']['billing_address']['country'] ?? '') == '일본' ? 'selected' : '' }}>일본</option>
                                        <option value="중국" {{ old('billing_country', $stepData['shipping']['billing_address']['country'] ?? '') == '중국' ? 'selected' : '' }}>중국</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 가격 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">가격 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_amount" class="form-label">세금</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₩</span>
                                        <input type="number" class="form-control" id="tax_amount" name="tax_amount"
                                               value="{{ old('tax_amount', $stepData['shipping']['tax_amount'] ?? 0) }}" min="0" step="0.01" onchange="calculateTotal()">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="shipping_cost" class="form-label">배송비</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₩</span>
                                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost"
                                               value="{{ old('shipping_cost', $stepData['shipping']['shipping_cost'] ?? 0) }}" min="0" step="0.01" onchange="calculateTotal()">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="discount_amount" class="form-label">할인</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₩</span>
                                        <input type="number" class="form-control" id="discount_amount" name="discount_amount"
                                               value="{{ old('discount_amount', $stepData['shipping']['discount_amount'] ?? 0) }}" min="0" step="0.01" onchange="calculateTotal()">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>상품 소계:</span>
                                        <span id="subtotalDisplay">₩{{ number_format($stepData['products']['subtotal'] ?? 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>세금:</span>
                                        <span id="taxDisplay">₩{{ number_format($stepData['shipping']['tax_amount'] ?? 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>배송비:</span>
                                        <span id="shippingDisplay">₩{{ number_format($stepData['shipping']['shipping_cost'] ?? 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>할인:</span>
                                        <span id="discountDisplay">-₩{{ number_format($stepData['shipping']['discount_amount'] ?? 0) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <strong>총 금액:</strong>
                                        <strong id="totalDisplay" class="text-primary fs-5">₩{{ number_format($stepData['shipping']['total_amount'] ?? $stepData['products']['subtotal'] ?? 0) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.cms.ecommerce.orders.step', 2) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>이전 단계
                    </a>
                    <button type="submit" class="btn btn-primary">
                        다음 단계: 결제/완료 <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">진행 단계</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success">1. 고객 정보</div>
                            <small class="text-muted">완료</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success">2. 상품 선택</div>
                            <small class="text-muted">완료</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-truck fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-primary">3. 배송/청구</div>
                            <small class="text-muted">진행 중</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center opacity-50">
                        <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-credit-card fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold">4. 결제/완료</div>
                            <small class="text-muted">대기 중</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 주문 요약 -->
            @if(isset($stepData['customer']) && isset($stepData['products']))
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">주문 요약</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>고객:</strong> {{ $stepData['customer']['customer_name'] }}</p>
                    <p class="mb-3"><small class="text-muted">{{ $stepData['customer']['customer_email'] }}</small></p>

                    <p class="mb-2"><strong>상품 {{ count($stepData['products']['items']) }}개</strong></p>
                    @foreach($stepData['products']['items'] as $item)
                        <p class="mb-1 small">{{ $item['name'] }} × {{ $item['quantity'] }}</p>
                    @endforeach

                    <hr>
                    <p class="mb-0"><strong>소계: ₩{{ number_format($stepData['products']['subtotal']) }}</strong></p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
const subtotal = {{ $stepData['products']['subtotal'] ?? 0 }};

function toggleBillingAddress() {
    const checkbox = document.getElementById('billing_same_as_shipping');
    const fields = document.getElementById('billingAddressFields');

    if (checkbox.checked) {
        fields.style.display = 'none';
    } else {
        fields.style.display = 'block';
    }
}

function calculateTotal() {
    const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    const shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
    const discount = parseFloat(document.getElementById('discount_amount').value) || 0;

    const total = Math.max(0, subtotal + tax + shipping - discount);

    document.getElementById('taxDisplay').textContent = `₩${tax.toLocaleString()}`;
    document.getElementById('shippingDisplay').textContent = `₩${shipping.toLocaleString()}`;
    document.getElementById('discountDisplay').textContent = `-₩${discount.toLocaleString()}`;
    document.getElementById('totalDisplay').textContent = `₩${total.toLocaleString()}`;
}

// Initial calculation
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection
