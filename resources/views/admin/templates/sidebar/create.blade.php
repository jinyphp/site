@extends('jiny-site::layouts.admin.sidebar')

@section('title', '사이드바 생성')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">새 사이드바 생성</h5>
                    <a href="{{ route('admin.cms.templates.sidebar.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 목록으로
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.sidebar.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sidebar_key" class="form-label">사이드바 키 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('sidebar_key') is-invalid @enderror"
                                           id="sidebar_key" name="sidebar_key" value="{{ old('sidebar_key') }}"
                                           placeholder="예: jiny-site::components.sidebar.custom" required>
                                    <div class="form-text">
                                        고유한 키 형식을 사용하세요. 예: 'jiny-site::components.sidebar.사용자정의명'
                                    </div>
                                    @error('sidebar_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">사이드바 이름 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           placeholder="예: 사용자 정의 사이드바" required>
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
                                           placeholder="예: jiny-site::components.sidebar.custom">
                                    <div class="form-text">
                                        사이드바 Blade 컴포넌트 경로
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
                                              placeholder="사이드바의 목적에 대한 간단한 설명">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="position" class="form-label">위치 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position') is-invalid @enderror"
                                            id="position" name="position" required>
                                        <option value="">위치 선택</option>
                                        <option value="left" {{ old('position') === 'left' ? 'selected' : '' }}>왼쪽</option>
                                        <option value="right" {{ old('position') === 'right' ? 'selected' : '' }}>오른쪽</option>
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">사이드바 옵션</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="collapsible" name="collapsible"
                                               {{ old('collapsible') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="collapsible">
                                            접을 수 있음
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="fixed" name="fixed"
                                               {{ old('fixed') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fixed">
                                            고정
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>팁:</strong>
                            <ul class="mb-0 mt-2">
                                <li>사이드바 키는 <code>package::components.sidebar.name</code> 패턴을 따라야 합니다</li>
                                <li>템플릿 경로는 기존 Blade 컴포넌트를 참조해야 합니다</li>
                                <li>위치는 왼쪽 또는 오른쪽을 선택할 수 있습니다</li>
                                <li>접을 수 있음 옵션은 사용자가 사이드바를 숨기거나 표시할 수 있게 합니다</li>
                                <li>고정 옵션은 스크롤 시 사이드바를 고정합니다</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.sidebar.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 사이드바 생성
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
    const keyInput = document.getElementById('sidebar_key');

    nameInput.addEventListener('input', function() {
        if (!keyInput.value || keyInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                keyInput.value = `jiny-site::components.sidebar.${slug}`;
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
        const position = document.getElementById('position').value;

        if (!key) {
            e.preventDefault();
            alert('사이드바 키는 필수입니다');
            keyInput.focus();
            return;
        }

        if (!name) {
            e.preventDefault();
            alert('사이드바 이름은 필수입니다');
            nameInput.focus();
            return;
        }

        if (!position) {
            e.preventDefault();
            alert('위치는 필수입니다');
            document.getElementById('position').focus();
            return;
        }

        // Validate key format
        if (!key.includes('::') || !key.includes('components.sidebar.')) {
            e.preventDefault();
            alert('사이드바 키는 package::components.sidebar.name 형식이어야 합니다');
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
