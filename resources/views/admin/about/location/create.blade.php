@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '새 Location 추가')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">새 Location 추가</h1>
                    <p class="text-muted">새로운 위치 정보를 등록합니다.</p>
                </div>
                <a href="{{ route('admin.cms.about.location.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>목록으로
                </a>
            </div>

            <!-- 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Location 정보</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.about.location.store') }}">
                        @csrf

                        <div class="row g-4">
                            <!-- 활성화 상태 -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">
                                        <strong>활성화</strong>
                                        <small class="text-muted d-block">체크하면 공개적으로 표시됩니다.</small>
                                    </label>
                                </div>
                            </div>

                            <!-- 제목 -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">제목 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required
                                       placeholder="예: 서울 본사, 부산 지점 등">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 순서 -->
                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">출력 순서</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                <div class="form-text">낮은 숫자가 먼저 표시됩니다. (0이 최우선)</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 주소 -->
                            <div class="col-12">
                                <label for="address" class="form-label">주소</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       id="address" name="address" value="{{ old('address') }}"
                                       placeholder="상세 주소를 입력하세요">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 도시 -->
                            <div class="col-md-4">
                                <label for="city" class="form-label">도시</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                       id="city" name="city" value="{{ old('city') }}"
                                       placeholder="예: 서울">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 주/도 -->
                            <div class="col-md-4">
                                <label for="state" class="form-label">주/도</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                       id="state" name="state" value="{{ old('state') }}"
                                       placeholder="예: 서울특별시">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 국가 -->
                            <div class="col-md-4">
                                <label for="country" class="form-label">국가</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror"
                                       id="country" name="country" value="{{ old('country') }}"
                                       placeholder="예: 대한민국">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 우편번호 -->
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">우편번호</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                       placeholder="예: 12345">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 연락처 정보 -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">전화번호</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="예: 02-1234-5678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 이메일 -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">이메일</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="예: contact@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 위도 -->
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">위도</label>
                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror"
                                       id="latitude" name="latitude" value="{{ old('latitude') }}"
                                       placeholder="예: 37.5665" min="-90" max="90">
                                <div class="form-text">지도 표시를 위한 위도 (-90 ~ 90)</div>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 경도 -->
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">경도</label>
                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror"
                                       id="longitude" name="longitude" value="{{ old('longitude') }}"
                                       placeholder="예: 126.9780" min="-180" max="180">
                                <div class="form-text">지도 표시를 위한 경도 (-180 ~ 180)</div>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 이미지 URL -->
                            <div class="col-12">
                                <label for="image" class="form-label">이미지 URL</label>
                                <input type="url" class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" value="{{ old('image') }}"
                                       placeholder="예: https://example.com/image.jpg">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 설명 -->
                            <div class="col-12">
                                <label for="description" class="form-label">설명</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="위치에 대한 자세한 설명을 입력하세요.">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms.about.location.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>저장
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 폼 유효성 검사
    const form = document.querySelector('form');
    const title = document.getElementById('title');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // 제목 검증
        if (!title.value.trim()) {
            title.classList.add('is-invalid');
            isValid = false;
        } else {
            title.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            alert('필수 항목을 모두 입력해주세요.');
        }
    });

    // 실시간 유효성 검사
    title.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush
