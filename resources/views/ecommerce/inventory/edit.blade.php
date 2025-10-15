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
                    <a href="{{ route('admin.site.ecommerce.inventory.show', $inventory->id) }}" class="btn btn-outline-info me-2">
                        <i class="fe fe-eye me-2"></i>상세 보기
                    </a>
                    <a href="{{ route('admin.site.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>재고 목록
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 재고 수정 폼 -->
    <form method="POST" action="{{ route('admin.site.ecommerce.inventory.update', $inventory->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">상품 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">상품 선택 <span class="text-danger">*</span></label>
                                <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                    <option value="">상품을 선택하세요</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ (old('product_id') ?? $inventory->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ $product->sku ?? 'SKU 없음' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="variant_id" class="form-label">상품 변형 (선택사항)</label>
                                <select id="variant_id" name="variant_id" class="form-control @error('variant_id') is-invalid @enderror">
                                    <option value="">기본 상품 (변형 없음)</option>
                                    @foreach($variants as $variant)
                                        <option value="{{ $variant->id }}"
                                                data-product-id="{{ $variant->product_id }}"
                                                {{ (old('variant_id') ?? $inventory->variant_id) == $variant->id ? 'selected' : '' }}>
                                            {{ $variant->product_name }} - {{ $variant->name }} ({{ $variant->sku ?? 'SKU 없음' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('variant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 재고 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">재고 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">보유 수량 <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity') ?? $inventory->quantity }}"
                                       min="0"
                                       required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">현재: {{ number_format($inventory->quantity) }}개</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="reserved_quantity" class="form-label">예약 수량</label>
                                <input type="number"
                                       class="form-control @error('reserved_quantity') is-invalid @enderror"
                                       id="reserved_quantity"
                                       name="reserved_quantity"
                                       value="{{ old('reserved_quantity') ?? $inventory->reserved_quantity ?? 0 }}"
                                       min="0">
                                @error('reserved_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">주문 처리 중인 수량</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="low_stock_threshold" class="form-label">부족 재고 기준</label>
                                <input type="number"
                                       class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                       id="low_stock_threshold"
                                       name="low_stock_threshold"
                                       value="{{ old('low_stock_threshold') ?? $inventory->low_stock_threshold ?? 10 }}"
                                       min="0">
                                @error('low_stock_threshold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">이 수량 이하가 되면 경고</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit_cost" class="form-label">단위 원가</label>
                                <div class="input-group">
                                    <span class="input-group-text">₩</span>
                                    <input type="number"
                                           class="form-control @error('unit_cost') is-invalid @enderror"
                                           id="unit_cost"
                                           name="unit_cost"
                                           value="{{ old('unit_cost') ?? $inventory->unit_cost ?? 0 }}"
                                           min="0"
                                           step="0.01">
                                    @error('unit_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 위치 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">위치 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="location" class="form-label">위치</label>
                                <input type="text"
                                       class="form-control @error('location') is-invalid @enderror"
                                       id="location"
                                       name="location"
                                       value="{{ old('location') ?? $inventory->location }}"
                                       placeholder="예: A구역"
                                       list="locationsList">
                                <datalist id="locationsList">
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">
                                    @endforeach
                                </datalist>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="warehouse" class="form-label">창고</label>
                                <input type="text"
                                       class="form-control @error('warehouse') is-invalid @enderror"
                                       id="warehouse"
                                       name="warehouse"
                                       value="{{ old('warehouse') ?? $inventory->warehouse }}"
                                       placeholder="예: 메인창고">
                                @error('warehouse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bin_location" class="form-label">세부 위치</label>
                                <input type="text"
                                       class="form-control @error('bin_location') is-invalid @enderror"
                                       id="bin_location"
                                       name="bin_location"
                                       value="{{ old('bin_location') ?? $inventory->bin_location }}"
                                       placeholder="예: A-1-B">
                                @error('bin_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">메모</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                          id="notes"
                                          name="notes"
                                          rows="3"
                                          placeholder="재고에 대한 추가 정보나 메모를 입력하세요">{{ old('notes') ?? $inventory->notes }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 정보 -->
            <div class="col-lg-4">
                <!-- 상태 설정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">상태 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="enable"
                                       name="enable"
                                       value="1"
                                       {{ (old('enable') ?? $inventory->enable) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    재고 활성화
                                </label>
                            </div>
                            <div class="form-text">체크하면 주문 처리에 포함됩니다.</div>
                        </div>
                    </div>
                </div>

                <!-- 재고 요약 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">재고 요약</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between">
                            <span>보유 수량:</span>
                            <span id="summary-quantity" class="fw-bold">{{ number_format($inventory->quantity) }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>예약 수량:</span>
                            <span id="summary-reserved" class="text-muted">{{ number_format($inventory->reserved_quantity ?? 0) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="mb-2 d-flex justify-content-between">
                            <span>사용 가능:</span>
                            <span id="summary-available" class="fw-bold text-primary">{{ number_format($inventory->available_quantity ?? $inventory->quantity) }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>총 가치:</span>
                            <span id="summary-value" class="fw-bold text-success">₩{{ number_format(($inventory->quantity ?? 0) * ($inventory->unit_cost ?? 0)) }}</span>
                        </div>
                    </div>
                </div>

                <!-- 등록 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">등록 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between">
                            <span>등록일:</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($inventory->created_at)->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span>수정일:</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($inventory->updated_at)->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>재고 수정
                            </button>
                            <a href="{{ route('admin.site.ecommerce.inventory.show', $inventory->id) }}" class="btn btn-outline-info">
                                <i class="fe fe-eye me-2"></i>상세 보기
                            </a>
                            <a href="{{ route('admin.site.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-x me-2"></i>취소
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// 상품 변형 필터링
document.getElementById('product_id').addEventListener('change', function() {
    const productId = this.value;
    const variantSelect = document.getElementById('variant_id');
    const options = variantSelect.querySelectorAll('option[data-product-id]');

    // 모든 변형 옵션 숨기기
    options.forEach(option => {
        if (option.dataset.productId === productId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });

    // 현재 선택된 변형이 다른 상품의 것이면 초기화
    const currentVariant = variantSelect.value;
    if (currentVariant) {
        const currentOption = variantSelect.querySelector(`option[value="${currentVariant}"]`);
        if (currentOption && currentOption.dataset.productId !== productId) {
            variantSelect.value = '';
        }
    }
});

// 재고 요약 업데이트
function updateSummary() {
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    const reserved = parseInt(document.getElementById('reserved_quantity').value) || 0;
    const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;

    const available = quantity - reserved;
    const totalValue = quantity * unitCost;

    document.getElementById('summary-quantity').textContent = quantity.toLocaleString();
    document.getElementById('summary-reserved').textContent = reserved.toLocaleString();
    document.getElementById('summary-available').textContent = available.toLocaleString();
    document.getElementById('summary-value').textContent = '₩' + totalValue.toLocaleString();
}

// 입력 필드 변경 시 요약 업데이트
document.getElementById('quantity').addEventListener('input', updateSummary);
document.getElementById('reserved_quantity').addEventListener('input', updateSummary);
document.getElementById('unit_cost').addEventListener('input', updateSummary);

// 페이지 로드 시 상품 변형 필터링 및 요약 업데이트
document.addEventListener('DOMContentLoaded', function() {
    // 현재 선택된 상품에 따라 변형 필터링
    const productSelect = document.getElementById('product_id');
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }

    updateSummary();
});
</script>
@endpush
