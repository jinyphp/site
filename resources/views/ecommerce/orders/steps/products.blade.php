@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">새 주문 생성 - 2단계: 상품 선택</h1>
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
                <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <small class="text-success">✓ 1. 고객 정보</small>
                <small class="text-primary fw-bold">2. 상품 선택</small>
                <small class="text-muted">3. 배송/청구</small>
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">주문 상품</h5>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addProduct()">
                        <i class="fas fa-plus me-1"></i>상품 추가
                    </button>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.ecommerce.orders.step', 2) }}" id="productsForm">
                        @csrf

                        <div id="productList">
                            @if(isset($stepData['products']['items']) && count($stepData['products']['items']) > 0)
                                @foreach($stepData['products']['items'] as $index => $item)
                                    <div class="product-item border rounded p-3 mb-3" data-index="{{ $index }}">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="mb-0">상품 {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProduct(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">상품명 <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="items[{{ $index }}][name]"
                                                       value="{{ old('items.'.$index.'.name', $item['name']) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SKU</label>
                                                <input type="text" class="form-control" name="items[{{ $index }}][sku]"
                                                       value="{{ old('items.'.$index.'.sku', $item['sku'] ?? '') }}" placeholder="상품 코드">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">수량 <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control quantity-input" name="items[{{ $index }}][quantity]"
                                                       value="{{ old('items.'.$index.'.quantity', $item['quantity']) }}" min="1" required onchange="calculateSubtotal()">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">단가 <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control price-input" name="items[{{ $index }}][price]"
                                                       value="{{ old('items.'.$index.'.price', $item['price']) }}" min="0" step="0.01" required onchange="calculateSubtotal()">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">소계</label>
                                                <input type="text" class="form-control item-total" readonly value="₩{{ number_format($item['price'] * $item['quantity']) }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="product-item border rounded p-3 mb-3" data-index="0">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6 class="mb-0">상품 1</h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProduct(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">상품명 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="items[0][name]" value="{{ old('items.0.name') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">SKU</label>
                                            <input type="text" class="form-control" name="items[0][sku]" value="{{ old('items.0.sku') }}" placeholder="상품 코드">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">수량 <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control quantity-input" name="items[0][quantity]"
                                                   value="{{ old('items.0.quantity', 1) }}" min="1" required onchange="calculateSubtotal()">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">단가 <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control price-input" name="items[0][price]"
                                                   value="{{ old('items.0.price', 0) }}" min="0" step="0.01" required onchange="calculateSubtotal()">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">소계</label>
                                            <input type="text" class="form-control item-total" readonly value="₩0">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="border-top pt-3">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>총 소계:</strong>
                                        <strong id="grandTotal" class="text-primary fs-5">₩{{ number_format($stepData['products']['subtotal'] ?? 0) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.cms.ecommerce.orders.step', 1) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>이전 단계
                            </a>
                            <button type="submit" class="btn btn-primary">
                                다음 단계: 배송/청구 <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-box fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-primary">2. 상품 선택</div>
                            <small class="text-muted">진행 중</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 opacity-50">
                        <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-truck fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold">3. 배송/청구</div>
                            <small class="text-muted">대기 중</small>
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

            @if(isset($stepData['customer']))
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">고객 정보</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $stepData['customer']['customer_name'] }}</strong></p>
                    <p class="mb-1 text-muted">{{ $stepData['customer']['customer_email'] }}</p>
                    @if($stepData['customer']['customer_phone'])
                        <p class="mb-0 text-muted">{{ $stepData['customer']['customer_phone'] }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
let productIndex = {{ isset($stepData['products']['items']) ? count($stepData['products']['items']) : 1 }};

function addProduct() {
    const productList = document.getElementById('productList');
    const newProduct = `
        <div class="product-item border rounded p-3 mb-3" data-index="${productIndex}">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="mb-0">상품 ${productIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProduct(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">상품명 <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="items[${productIndex}][name]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" class="form-control" name="items[${productIndex}][sku]" placeholder="상품 코드">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">수량 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control quantity-input" name="items[${productIndex}][quantity]"
                           value="1" min="1" required onchange="calculateSubtotal()">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">단가 <span class="text-danger">*</span></label>
                    <input type="number" class="form-control price-input" name="items[${productIndex}][price]"
                           value="0" min="0" step="0.01" required onchange="calculateSubtotal()">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">소계</label>
                    <input type="text" class="form-control item-total" readonly value="₩0">
                </div>
            </div>
        </div>
    `;

    productList.insertAdjacentHTML('beforeend', newProduct);
    productIndex++;
    calculateSubtotal();
}

function removeProduct(button) {
    const productItems = document.querySelectorAll('.product-item');
    if (productItems.length > 1) {
        button.closest('.product-item').remove();
        calculateSubtotal();
        updateProductNumbers();
    } else {
        alert('최소 1개의 상품이 필요합니다.');
    }
}

function updateProductNumbers() {
    const productItems = document.querySelectorAll('.product-item');
    productItems.forEach((item, index) => {
        const header = item.querySelector('h6');
        header.textContent = `상품 ${index + 1}`;
    });
}

function calculateSubtotal() {
    let total = 0;
    const productItems = document.querySelectorAll('.product-item');

    productItems.forEach(item => {
        const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(item.querySelector('.price-input').value) || 0;
        const itemTotal = quantity * price;

        item.querySelector('.item-total').value = `₩${itemTotal.toLocaleString()}`;
        total += itemTotal;
    });

    document.getElementById('grandTotal').textContent = `₩${total.toLocaleString()}`;
}

// Initial calculation
document.addEventListener('DOMContentLoaded', function() {
    calculateSubtotal();
});
</script>
@endsection
