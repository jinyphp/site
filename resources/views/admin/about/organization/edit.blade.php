@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '조직 수정')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">조직 수정: {{ $organization->name }}</h1>
                    <p class="text-muted">조직 정보를 수정합니다.</p>
                </div>
                <a href="{{ route('admin.cms.about.organization.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>목록으로
                </a>
            </div>

            <!-- 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">조직 정보</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.about.organization.update', $organization->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- 활성화 상태 -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $organization->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <strong>활성화</strong>
                                        <small class="text-muted d-block">체크하면 공개적으로 표시됩니다.</small>
                                    </label>
                                </div>
                            </div>

                            <!-- 기본 정보 -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">조직명 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $organization->name) }}" required
                                       placeholder="예: 개발팀, 마케팅팀, 영업팀">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="form-label">조직 코드 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       id="code" name="code" value="{{ old('code', $organization->code) }}" required
                                       placeholder="예: DEV, MKT, SALES">
                                <div class="form-text">영문, 숫자로 구성된 고유 코드</div>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 상위 조직 및 순서 -->
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label">상위 조직</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror"
                                        id="parent_id" name="parent_id" onchange="updateLevel()">
                                    <option value="">최상위 조직</option>
                                    @foreach($parentOptions as $option)
                                        <option value="{{ $option['id'] }}"
                                                data-level="{{ $option['level'] }}"
                                                {{ (old('parent_id', $organization->parent_id) == $option['id']) ? 'selected' : '' }}>
                                            {{ $option['name'] }} ({{ $option['code'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @if($childrenCount > 0)
                                    <div class="form-text text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        하위 조직이 {{ $childrenCount }}개 있습니다. 상위 조직 변경 시 하위 조직들의 레벨도 함께 변경됩니다.
                                    </div>
                                @endif
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sort_order" class="form-label">정렬 순서</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                       id="sort_order" name="sort_order" value="{{ old('sort_order', $organization->sort_order) }}" min="0">
                                <div class="form-text">낮은 숫자가 먼저 표시됩니다. (0이 최우선)</div>
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 조직 설명 -->
                            <div class="col-12">
                                <label for="description" class="form-label">조직 설명</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="4"
                                          placeholder="조직의 역할과 업무에 대한 설명을 입력하세요.">{{ old('description', $organization->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 연락처 정보 -->
                            <div class="col-md-4">
                                <label for="manager_title" class="form-label">관리자 직책</label>
                                <input type="text" class="form-control @error('manager_title') is-invalid @enderror"
                                       id="manager_title" name="manager_title" value="{{ old('manager_title', $organization->manager_title) }}"
                                       placeholder="예: 팀장, 본부장">
                                @error('manager_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="contact_email" class="form-label">연락처 이메일</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                       id="contact_email" name="contact_email" value="{{ old('contact_email', $organization->contact_email) }}"
                                       placeholder="team@company.com">
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="contact_phone" class="form-label">연락처 전화번호</label>
                                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                       id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $organization->contact_phone) }}"
                                       placeholder="02-1234-5678">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms.about.organization.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>수정
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
    const name = document.getElementById('name');
    const code = document.getElementById('code');

    form.addEventListener('submit', function(e) {
        let isValid = true;

        // 조직명 검증
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            isValid = false;
        } else {
            name.classList.remove('is-invalid');
        }

        // 조직 코드 검증
        if (!code.value.trim()) {
            code.classList.add('is-invalid');
            isValid = false;
        } else {
            code.classList.remove('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            alert('필수 항목을 모두 입력해주세요.');
        }
    });

    // 실시간 유효성 검사
    name.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });

    code.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });

    // 레벨 자동 업데이트
    function updateLevel() {
        const parentSelect = document.getElementById('parent_id');
        const levelInput = document.getElementById('level');

        if (parentSelect.value) {
            const selectedOption = parentSelect.options[parentSelect.selectedIndex];
            const parentLevel = parseInt(selectedOption.getAttribute('data-level'));
            levelInput.value = parentLevel + 1;
        } else {
            levelInput.value = 0;
        }
    }

    // 상위 조직 변경 시 레벨 업데이트
    document.getElementById('parent_id').addEventListener('change', updateLevel);

    // 페이지 로드 시 레벨 설정
    updateLevel();
});
</script>
@endpush
