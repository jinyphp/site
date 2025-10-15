@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '새 쿠폰 생성')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">새 쿠폰 생성</h2>
            <p class="text-muted">새로운 할인 쿠폰을 생성합니다.</p>
        </div>
        <a href="{{ route('admin.cms.ecommerce.coupons.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>목록으로
        </a>
    </div>

    <form action="{{ route('admin.cms.ecommerce.coupons.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">쿠폰명 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">쿠폰 코드 <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                           id="code" name="code" value="{{ old('code') }}" required>
                                    <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                        자동생성
                                    </button>
                                </div>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">설명</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Discount Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">할인 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">할인 타입 <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type" name="type" required>
                                    <option value="">선택하세요</option>
                                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>퍼센트 할인</option>
                                    <option value="fixed_amount" {{ old('type') === 'fixed_amount' ? 'selected' : '' }}>고정 금액 할인</option>
                                    <option value="free_shipping" {{ old('type') === 'free_shipping' ? 'selected' : '' }}>무료 배송</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">할인값 <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('value') is-invalid @enderror"
                                           id="value" name="value" value="{{ old('value') }}" required min="0" step="0.01">
                                    <span class="input-group-text" id="valueUnit">원</span>
                                </div>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="minimum_order_amount" class="form-label">최소 주문 금액</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('minimum_order_amount') is-invalid @enderror"
                                           id="minimum_order_amount" name="minimum_order_amount"
                                           value="{{ old('minimum_order_amount') }}" min="0">
                                    <span class="input-group-text">원</span>
                                </div>
                                @error('minimum_order_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="maximum_discount_amount" class="form-label">최대 할인 금액</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('maximum_discount_amount') is-invalid @enderror"
                                           id="maximum_discount_amount" name="maximum_discount_amount"
                                           value="{{ old('maximum_discount_amount') }}" min="0">
                                    <span class="input-group-text">원</span>
                                </div>
                                @error('maximum_discount_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Limits -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">사용 제한</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="usage_limit" class="form-label">전체 사용 한도</label>
                                <input type="number" class="form-control @error('usage_limit') is-invalid @enderror"
                                       id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" min="1">
                                <div class="form-text">비워두면 무제한</div>
                                @error('usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="usage_limit_per_customer" class="form-label">고객당 사용 한도</label>
                                <input type="number" class="form-control @error('usage_limit_per_customer') is-invalid @enderror"
                                       id="usage_limit_per_customer" name="usage_limit_per_customer"
                                       value="{{ old('usage_limit_per_customer') }}" min="1">
                                <div class="form-text">비워두면 무제한</div>
                                @error('usage_limit_per_customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">상태 <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>활성</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>비활성</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="stackable" name="stackable" value="1"
                                   {{ old('stackable') ? 'checked' : '' }}>
                            <label class="form-check-label" for="stackable">
                                다른 쿠폰과 중복 사용 가능
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="auto_apply" name="auto_apply" value="1"
                                   {{ old('auto_apply') ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_apply">
                                자동 적용
                            </label>
                            <div class="form-text">조건에 맞으면 자동으로 적용됩니다.</div>
                        </div>
                    </div>
                </div>

                <!-- Date Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">유효 기간</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="starts_at" class="form-label">시작일 <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror"
                                   id="starts_at" name="starts_at" value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">만료일</label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                   id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                            <div class="form-text">비워두면 무제한</div>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>쿠폰 생성
                            </button>
                            <a href="{{ route('admin.cms.ecommerce.coupons.index') }}" class="btn btn-outline-secondary">
                                취소
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
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const valueInput = document.getElementById('value');
    const valueUnit = document.getElementById('valueUnit');
    const generateCodeBtn = document.getElementById('generateCode');
    const codeInput = document.getElementById('code');

    // Update value unit based on discount type
    function updateValueUnit() {
        const type = typeSelect.value;
        if (type === 'percentage') {
            valueUnit.textContent = '%';
            valueInput.max = '100';
        } else if (type === 'fixed_amount') {
            valueUnit.textContent = '원';
            valueInput.removeAttribute('max');
        } else if (type === 'free_shipping') {
            valueUnit.textContent = '';
            valueInput.value = '0';
            valueInput.disabled = true;
        } else {
            valueUnit.textContent = '원';
            valueInput.disabled = false;
            valueInput.removeAttribute('max');
        }
    }

    typeSelect.addEventListener('change', updateValueUnit);

    // Generate random coupon code
    generateCodeBtn.addEventListener('click', function() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 8; i++) {
            result += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        codeInput.value = result;
    });

    // Initialize
    updateValueUnit();
});
</script>
@endpush
