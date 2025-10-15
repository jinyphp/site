@extends('jiny-site::layouts.admin.sidebar')

@section('title', '사이드바 수정')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">사이드바 수정: <code>{{ $sidebar['sidebar_key'] }}</code></h5>
                    <div>
                        <a href="{{ route('admin.cms.templates.sidebar.show', $sidebar['id']) }}" class="btn btn-outline-info">
                            <i class="bi bi-eye"></i> 보기
                        </a>
                        <a href="{{ route('admin.cms.templates.sidebar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> 목록으로
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.sidebar.update', $sidebar['id']) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sidebar_key" class="form-label">사이드바 키 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('sidebar_key') is-invalid @enderror"
                                           id="sidebar_key" name="sidebar_key" value="{{ old('sidebar_key', $sidebar['sidebar_key'] ?? '') }}"
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
                                           id="name" name="name" value="{{ old('name', $sidebar['name'] ?? '') }}"
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
                                           id="template" name="template" value="{{ old('template', $sidebar['template'] ?? '') }}"
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
                                              placeholder="사이드바의 목적에 대한 간단한 설명">{{ old('description', $sidebar['description'] ?? '') }}</textarea>
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
                                        <option value="left" {{ old('position', $sidebar['position'] ?? '') === 'left' ? 'selected' : '' }}>왼쪽</option>
                                        <option value="right" {{ old('position', $sidebar['position'] ?? '') === 'right' ? 'selected' : '' }}>오른쪽</option>
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
                                               {{ old('collapsible', $sidebar['collapsible'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="collapsible">
                                            접을 수 있음
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="fixed" name="fixed"
                                               {{ old('fixed', $sidebar['fixed'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fixed">
                                            고정
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>현재 사이드바 설정:</strong>
                            <pre class="mt-2 mb-0"><code>{{ json_encode($sidebar, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.sidebar.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 사이드바 수정
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

    // Auto-save indicator (optional)
    let autoSaveTimeout;
    const formInputs = form.querySelectorAll('input[type="text"], textarea, input[type="checkbox"], select');

    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Show auto-save indicator
                showChangeIndicator();
            }, 2000);
        });
    });

    function showChangeIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'alert alert-success position-fixed';
        indicator.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.9; min-width: 200px;';
        indicator.innerHTML = '<i class="fas fa-check"></i> 변경 사항 감지됨 (저장 버튼을 눌러주세요)';

        document.body.appendChild(indicator);

        setTimeout(() => {
            indicator.remove();
        }, 3000);
    }
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

.alert-info pre {
    background-color: rgba(23, 162, 184, 0.1);
    border: 1px solid rgba(23, 162, 184, 0.2);
    border-radius: 0.25rem;
    padding: 0.75rem;
    font-size: 0.875em;
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

input[readonly] {
    background-color: #f8f9fa;
    opacity: 1;
}
</style>
@endpush
