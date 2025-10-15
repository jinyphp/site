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
                    <p class="text-muted mb-0">{{ $product->title }} - {{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.pricing.index', $product->id) }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 가격 옵션 등록 폼 -->
    <form method="POST" action="{{ route('admin.site.products.pricing.store', $product->id) }}">
        @csrf

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">옵션명 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="예: 기본, 프리미엄, 엔터프라이즈"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="code" class="form-label">옵션 코드</label>
                                <input type="text"
                                       class="form-control @error('code') is-invalid @enderror"
                                       id="code"
                                       name="code"
                                       value="{{ old('code') }}"
                                       placeholder="예: basic, premium">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">옵션 설명</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 상세 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">상세 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="features" class="form-label">포함된 기능</label>
                                <textarea class="form-control @error('features') is-invalid @enderror"
                                          id="features"
                                          name="features"
                                          rows="4"
                                          placeholder='JSON 형식으로 입력하세요. 예: ["기능1", "기능2", "기능3"]'>{{ old('features') }}</textarea>
                                @error('features')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="limitations" class="form-label">제한사항</label>
                                <textarea class="form-control @error('limitations') is-invalid @enderror"
                                          id="limitations"
                                          name="limitations"
                                          rows="3"
                                          placeholder='JSON 형식으로 입력하세요. 예: ["제한사항1", "제한사항2"]'>{{ old('limitations') }}</textarea>
                                @error('limitations')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 정보 -->
            <div class="col-lg-4">
                <!-- 가격 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">가격 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="price" class="form-label">기본 가격 <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price"
                                   name="price"
                                   value="{{ old('price') }}"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">할인 가격</label>
                            <input type="number"
                                   class="form-control @error('sale_price') is-invalid @enderror"
                                   id="sale_price"
                                   name="sale_price"
                                   value="{{ old('sale_price') }}"
                                   step="0.01"
                                   min="0">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="form-label">통화 <span class="text-danger">*</span></label>
                            <select class="form-control @error('currency') is-invalid @enderror"
                                    id="currency"
                                    name="currency"
                                    required>
                                <option value="KRW" {{ old('currency') === 'KRW' ? 'selected' : '' }}>KRW (원)</option>
                                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD (달러)</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR (유로)</option>
                                <option value="JPY" {{ old('currency') === 'JPY' ? 'selected' : '' }}>JPY (엔)</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="billing_period" class="form-label">결제 주기</label>
                            <select class="form-control @error('billing_period') is-invalid @enderror"
                                    id="billing_period"
                                    name="billing_period">
                                <option value="">일회성</option>
                                <option value="monthly" {{ old('billing_period') === 'monthly' ? 'selected' : '' }}>월간</option>
                                <option value="yearly" {{ old('billing_period') === 'yearly' ? 'selected' : '' }}>연간</option>
                                <option value="weekly" {{ old('billing_period') === 'weekly' ? 'selected' : '' }}>주간</option>
                            </select>
                            @error('billing_period')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 수량 및 정렬 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">수량 및 정렬</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="min_quantity" class="form-label">최소 수량 <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('min_quantity') is-invalid @enderror"
                                   id="min_quantity"
                                   name="min_quantity"
                                   value="{{ old('min_quantity', 1) }}"
                                   min="1"
                                   required>
                            @error('min_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="max_quantity" class="form-label">최대 수량</label>
                            <input type="number"
                                   class="form-control @error('max_quantity') is-invalid @enderror"
                                   id="max_quantity"
                                   name="max_quantity"
                                   value="{{ old('max_quantity') }}"
                                   min="1">
                            @error('max_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">비워두면 무제한</div>
                        </div>

                        <div class="mb-3">
                            <label for="pos" class="form-label">정렬 순서 <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('pos') is-invalid @enderror"
                                   id="pos"
                                   name="pos"
                                   value="{{ old('pos', 0) }}"
                                   min="0"
                                   required>
                            @error('pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">작은 숫자일수록 먼저 표시됩니다</div>
                        </div>
                    </div>
                </div>

                <!-- 상태 설정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">상태 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="enable"
                                   name="enable"
                                   value="1"
                                   {{ old('enable', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable">
                                옵션 활성화
                            </label>
                        </div>
                        <div class="form-text">체크하면 고객에게 노출됩니다.</div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>옵션 등록
                            </button>
                            <a href="{{ route('admin.site.products.pricing.index', $product->id) }}" class="btn btn-outline-secondary">
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
// 폼 제출 전 JSON 유효성 검사
document.querySelector('form').addEventListener('submit', function(e) {
    const features = document.getElementById('features').value;
    const limitations = document.getElementById('limitations').value;

    // JSON 필드들 검증
    const jsonFields = [
        { value: features, name: '포함된 기능' },
        { value: limitations, name: '제한사항' }
    ];

    for (let field of jsonFields) {
        if (field.value && field.value.trim()) {
            try {
                JSON.parse(field.value);
            } catch (error) {
                alert(`${field.name} 필드의 JSON 형식이 올바르지 않습니다.`);
                e.preventDefault();
                return;
            }
        }
    }
});
</script>
@endpush
