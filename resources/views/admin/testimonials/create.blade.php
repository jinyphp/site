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
                    <p class="text-muted mb-0">새로운 고객 후기를 등록합니다.</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.testimonials.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial 생성 폼 -->
    <form method="POST" action="{{ route('admin.site.testimonials.store') }}">
        @csrf
        @if($selectedType && $selectedItemId)
            <input type="hidden" name="return_to" value="item">
        @endif

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">타입 <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        {{ $selectedType ? 'disabled' : '' }}
                                        onchange="updateItemOptions()">
                                    <option value="">타입을 선택하세요</option>
                                    <option value="product" {{ old('type', $selectedType) === 'product' ? 'selected' : '' }}>상품</option>
                                    <option value="service" {{ old('type', $selectedType) === 'service' ? 'selected' : '' }}>서비스</option>
                                </select>
                                @if($selectedType)
                                    <input type="hidden" name="type" value="{{ $selectedType }}">
                                @endif
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="item_id" class="form-label">대상 선택 <span class="text-danger">*</span></label>
                                <select class="form-control @error('item_id') is-invalid @enderror"
                                        id="item_id"
                                        name="item_id"
                                        {{ $selectedItemId ? 'disabled' : '' }}>
                                    <option value="">먼저 타입을 선택하세요</option>
                                    @if($selectedType === 'product')
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('item_id', $selectedItemId) == $product->id ? 'selected' : '' }}>
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    @elseif($selectedType === 'service')
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('item_id', $selectedItemId) == $service->id ? 'selected' : '' }}>
                                                {{ $service->title }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($selectedItemId)
                                    <input type="hidden" name="item_id" value="{{ $selectedItemId }}">
                                @endif
                                @error('item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="headline" class="form-label">후기 제목 <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('headline') is-invalid @enderror"
                                   id="headline"
                                   name="headline"
                                   value="{{ old('headline') }}"
                                   placeholder="ex: Transformative Learning Experience!">
                            @error('headline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">후기 내용 <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      rows="5"
                                      placeholder="고객의 상세한 후기를 작성해주세요...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">평점 <span class="text-danger">*</span></label>
                            <select class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating">
                                <option value="">평점을 선택하세요</option>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5점)</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4점)</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3점)</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2점)</option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1점)</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">고객명 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="ex: Jitu Chauhan">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">이메일</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="ex: customer@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">직책/지위</label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       placeholder="ex: Technical Co-Founder, CTO">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="company" class="form-label">회사/기관</label>
                                <input type="text"
                                       class="form-control @error('company') is-invalid @enderror"
                                       id="company"
                                       name="company"
                                       value="{{ old('company') }}"
                                       placeholder="ex: Block">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">프로필 이미지 URL</label>
                            <input type="url"
                                   class="form-control @error('avatar') is-invalid @enderror"
                                   id="avatar"
                                   name="avatar"
                                   value="{{ old('avatar') }}"
                                   placeholder="https://example.com/profile-image.jpg">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 설정 -->
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
                                       {{ old('enable', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    활성화
                                </label>
                            </div>
                            <div class="form-text">체크하면 고객에게 노출됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="featured"
                                       name="featured"
                                       value="1"
                                       {{ old('featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    추천 후기
                                </label>
                            </div>
                            <div class="form-text">추천 후기로 우선 표시됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="verified"
                                       name="verified"
                                       value="1"
                                       {{ old('verified') ? 'checked' : '' }}>
                                <label class="form-check-label" for="verified">
                                    인증된 후기
                                </label>
                            </div>
                            <div class="form-text">인증 배지가 표시됩니다.</div>
                        </div>
                    </div>
                </div>

                <!-- 등록 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>Testimonial 등록
                            </button>
                            <a href="{{ route('admin.site.testimonials.index') }}" class="btn btn-outline-secondary">
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
// 상품/서비스 데이터
const products = @json($products);
const services = @json($services);

function updateItemOptions() {
    const typeSelect = document.getElementById('type');
    const itemSelect = document.getElementById('item_id');
    const selectedType = typeSelect.value;

    // Clear current options
    itemSelect.innerHTML = '<option value="">항목을 선택하세요</option>';

    if (selectedType === 'product') {
        products.forEach(product => {
            const option = document.createElement('option');
            option.value = product.id;
            option.textContent = product.title;
            itemSelect.appendChild(option);
        });
    } else if (selectedType === 'service') {
        services.forEach(service => {
            const option = document.createElement('option');
            option.value = service.id;
            option.textContent = service.title;
            itemSelect.appendChild(option);
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateItemOptions();
});
</script>
@endpush
