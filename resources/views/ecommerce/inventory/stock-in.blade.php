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

    <!-- 입고 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-arrow-down text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">오늘 입고 건수</h6>
                            <h4 class="mb-0">{{ $stats['today_count'] }}</h4>
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
                            <div class="bg-info bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-package text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">오늘 입고 수량</h6>
                            <h4 class="mb-0">{{ number_format($stats['today_quantity']) }}</h4>
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
                                <i class="fe fe-calendar text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">이번달 입고 건수</h6>
                            <h4 class="mb-0">{{ $stats['month_count'] }}</h4>
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
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-trending-up text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">이번달 입고 수량</h6>
                            <h4 class="mb-0">{{ number_format($stats['month_quantity']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 재고 입고 폼 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">재고 입고</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fe fe-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fe fe-alert-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.cms.ecommerce.inventory.stock-in.process') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="product_id" class="form-label">상품 선택 <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">상품을 선택해주세요</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} @if($product->sku)({{ $product->sku }})@endif
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label">입고 수량 <span class="text-danger">*</span></label>
                            <input type="number"
                                   name="quantity"
                                   id="quantity"
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity') }}"
                                   min="1"
                                   required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="unit_cost" class="form-label">단가</label>
                            <input type="number"
                                   name="unit_cost"
                                   id="unit_cost"
                                   class="form-control @error('unit_cost') is-invalid @enderror"
                                   value="{{ old('unit_cost') }}"
                                   min="0"
                                   step="0.01">
                            @error('unit_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="location" class="form-label">입고 위치</label>
                            <input type="text"
                                   name="location"
                                   id="location"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', 'main_warehouse') }}"
                                   placeholder="main_warehouse">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">입고 메모</label>
                            <textarea name="notes"
                                      id="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="3"
                                      placeholder="입고 사유나 특이사항을 입력해주세요">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fe fe-plus me-2"></i>재고 입고 처리
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 최근 입고 내역 -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">최근 입고 내역</h5>
                </div>
                <div class="card-body p-0">
                    @if($stockInHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>상품</th>
                                        <th width="80">수량</th>
                                        <th width="100">위치</th>
                                        <th width="100">처리자</th>
                                        <th width="120">입고일시</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockInHistory as $history)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $history->product_name }}</strong>
                                                @if($history->product_sku)
                                                    <br><small class="text-muted">{{ $history->product_sku }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">+{{ number_format($history->quantity) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $history->location ?? 'main' }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $history->created_by_name ?? 'System' }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('m/d H:i') }}
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
                            <p class="text-muted">최근 입고 내역이 없습니다</p>
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
</style>
@endpush

@push('scripts')
<script>
// 폼 validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');

    form.addEventListener('submit', function(e) {
        if (!productSelect.value) {
            e.preventDefault();
            alert('상품을 선택해주세요.');
            productSelect.focus();
            return false;
        }

        if (!quantityInput.value || quantityInput.value <= 0) {
            e.preventDefault();
            alert('입고 수량을 올바르게 입력해주세요.');
            quantityInput.focus();
            return false;
        }
    });
});
</script>
@endpush
