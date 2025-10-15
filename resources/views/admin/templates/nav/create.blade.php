@extends('jiny-site::layouts.admin.sidebar')

@section('title', '네비게이션 생성')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">새 네비게이션 생성</h5>
                    <a href="{{ route('admin.cms.templates.nav.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 목록으로
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.nav.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nav_key" class="form-label">네비게이션 키 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nav_key') is-invalid @enderror"
                                           id="nav_key" name="nav_key" value="{{ old('nav_key') }}"
                                           placeholder="예: jiny-site::components.nav.custom" required>
                                    <div class="form-text">
                                        고유한 키 형식을 사용하세요. 예: 'jiny-site::components.nav.사용자정의명'
                                    </div>
                                    @error('nav_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">네비게이션 이름 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           placeholder="예: 사용자 정의 네비게이션" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="template" class="form-label">템플릿 경로</label>
                                    <input type="text" class="form-control @error('template') is-invalid @enderror"
                                           id="template" name="template" value="{{ old('template') }}"
                                           placeholder="예: jiny-site::components.nav.custom">
                                    <div class="form-text">
                                        네비게이션 Blade 컴포넌트 경로
                                    </div>
                                    @error('template')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">설명</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="3"
                                              placeholder="네비게이션의 목적에 대한 간단한 설명">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type" class="form-label">타입 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">타입 선택...</option>
                                        <option value="horizontal" {{ old('type') === 'horizontal' ? 'selected' : '' }}>수평</option>
                                        <option value="vertical" {{ old('type') === 'vertical' ? 'selected' : '' }}>수직</option>
                                    </select>
                                    <div class="form-text">
                                        네비게이션 표시 방향
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">네비게이션 옵션</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="dropdown" name="dropdown"
                                               {{ old('dropdown') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dropdown">
                                            드롭다운 메뉴 지원
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="mobile_responsive" name="mobile_responsive"
                                               {{ old('mobile_responsive') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mobile_responsive">
                                            모바일 반응형
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>팁:</strong>
                            <ul class="mb-0 mt-2">
                                <li>네비게이션 키는 <code>package::components.nav.name</code> 패턴을 따라야 합니다</li>
                                <li>템플릿 경로는 기존 Blade 컴포넌트를 참조해야 합니다</li>
                                <li>타입은 수평(horizontal) 또는 수직(vertical)을 선택하세요</li>
                                <li>드롭다운 옵션은 다단계 메뉴 구조를 지원합니다</li>
                                <li>모바일 반응형 옵션은 작은 화면에서 네비게이션을 최적화합니다</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.nav.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 네비게이션 생성
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
    // Auto-generate key from name
    const nameInput = document.getElementById('name');
    const keyInput = document.getElementById('nav_key');

    nameInput.addEventListener('input', function() {
        if (!keyInput.value || keyInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                keyInput.value = `jiny-site::components.nav.${slug}`;
                keyInput.dataset.autoGenerated = 'true';
            }
        }
    });

    keyInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const key = keyInput.value.trim();
        const name = nameInput.value.trim();
        const type = document.getElementById('type').value;

        if (!key) {
            e.preventDefault();
            alert('네비게이션 키는 필수입니다');
            keyInput.focus();
            return;
        }

        if (!name) {
            e.preventDefault();
            alert('네비게이션 이름은 필수입니다');
            nameInput.focus();
            return;
        }

        if (!type) {
            e.preventDefault();
            alert('타입은 필수입니다');
            document.getElementById('type').focus();
            return;
        }

        // Validate key format
        if (!key.includes('::') || !key.includes('components.nav.')) {
            e.preventDefault();
            alert('네비게이션 키는 package::components.nav.name 형식이어야 합니다');
            keyInput.focus();
            return;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.form-text {
    font-size: 0.875em;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}

.card-title {
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.invalid-feedback {
    font-size: 0.875em;
}

.form-check {
    margin-bottom: 0.5rem;
}

.form-check-label {
    font-weight: 500;
}
</style>
@endpush
