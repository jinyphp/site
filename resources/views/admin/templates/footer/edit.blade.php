@extends('jiny-site::layouts.admin.sidebar')

@section('title', '푸터 수정')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">푸터 수정</h1>
                    <p class="mb-0 text-muted">
                        <strong>{{ $footer['title'] ?? $footer['name'] ?? '이름 없음' }}</strong> 푸터의 설정을 수정할 수 있습니다
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.footer.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 푸터 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.footer.show', $footer['id']) }}" class="btn btn-outline-info me-2">
                        <i class="bi bi-eye me-1"></i> 상세보기
                    </a>
                    <a href="{{ route('admin.cms.templates.footer.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> 목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">푸터 수정: <code>{{ $footer['path'] ?? $footer['footer_key'] ?? 'N/A' }}</code></h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.footer.update', $footer['id']) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="path" class="form-label">푸터 경로 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('path') is-invalid @enderror"
                                           id="path" name="path" value="{{ old('path', $footer['path'] ?? $footer['footer_key'] ?? '') }}"
                                           placeholder="예: jiny-site::partials.footers.footer-custom" required>
                                    <div class="form-text">
                                        고유한 경로 형식을 사용하세요. 예: 'jiny-site::partials.footers.footer-사용자정의명'
                                    </div>
                                    @error('path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">푸터 제목 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $footer['title'] ?? $footer['name'] ?? '') }}"
                                           placeholder="예: 사용자 정의 푸터" required>
                                    @error('title')
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
                                           id="template" name="template" value="{{ old('template', $footer['template'] ?? '') }}"
                                           placeholder="예: jiny-site::components.footer.custom">
                                    <div class="form-text">
                                        푸터 Blade 컴포넌트 경로
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
                                              placeholder="푸터의 목적에 대한 간단한 설명">{{ old('description', $footer['description'] ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">푸터 상태</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable" name="enable"
                                               {{ old('enable', $footer['enable'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable">
                                            활성화 (사용 가능)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="active" name="active"
                                               {{ old('active', $footer['active'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            사용중 (현재 적용)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="default" name="default"
                                               {{ old('default', $footer['default'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="default">
                                            기본 푸터로 설정
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>현재 푸터 설정:</strong>
                            <pre class="mt-2 mb-0"><code>{{ json_encode($footer, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.footer.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 푸터 수정
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
    // Auto-generate path from title
    const titleInput = document.getElementById('title');
    const pathInput = document.getElementById('path');

    titleInput.addEventListener('input', function() {
        if (!pathInput.value || pathInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                pathInput.value = `jiny-site::partials.footers.footer-${slug}`;
                pathInput.dataset.autoGenerated = 'true';
            }
        }
    });

    pathInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });

    // Enable/Active dependency
    const enableInput = document.getElementById('enable');
    const activeInput = document.getElementById('active');
    const defaultInput = document.getElementById('default');

    enableInput.addEventListener('change', function() {
        if (!this.checked) {
            activeInput.checked = false;
            defaultInput.checked = false;
            activeInput.disabled = true;
        } else {
            activeInput.disabled = false;
        }
    });

    defaultInput.addEventListener('change', function() {
        if (this.checked) {
            enableInput.checked = true;
            activeInput.checked = true;
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const path = pathInput.value.trim();
        const title = titleInput.value.trim();

        if (!path) {
            e.preventDefault();
            alert('푸터 경로는 필수입니다');
            pathInput.focus();
            return;
        }

        if (!title) {
            e.preventDefault();
            alert('푸터 제목은 필수입니다');
            titleInput.focus();
            return;
        }

        // Validate path format
        if (!path.includes('::') || !path.includes('partials.footers.')) {
            e.preventDefault();
            alert('푸터 경로는 package::partials.footers.footer-name 형식이어야 합니다');
            pathInput.focus();
            return;
        }
    });

    // Auto-save indicator (optional)
    let autoSaveTimeout;
    const formInputs = form.querySelectorAll('input[type="text"], textarea, input[type="checkbox"]');

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