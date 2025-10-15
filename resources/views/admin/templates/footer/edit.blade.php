@extends('jiny-site::layouts.admin.sidebar')

@section('title', '푸터 수정')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">푸터 수정: <code>{{ $footer['footer_key'] }}</code></h5>
                    <div>
                        <a href="{{ route('admin.cms.templates.footer.show', $footer['id']) }}" class="btn btn-outline-info">
                            <i class="bi bi-eye"></i> 보기
                        </a>
                        <a href="{{ route('admin.cms.templates.footer.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> 목록으로
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.footer.update', $footer['id']) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="footer_key" class="form-label">푸터 키 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('footer_key') is-invalid @enderror"
                                           id="footer_key" name="footer_key" value="{{ old('footer_key', $footer['footer_key'] ?? '') }}"
                                           placeholder="예: jiny-site::components.footer.custom" required>
                                    <div class="form-text">
                                        고유한 키 형식을 사용하세요. 예: 'jiny-site::components.footer.사용자정의명'
                                    </div>
                                    @error('footer_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">푸터 이름 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $footer['name'] ?? '') }}"
                                           placeholder="예: 사용자 정의 푸터" required>
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
                                    <label class="form-label">푸터 옵션</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="copyright" name="copyright"
                                               {{ old('copyright', $footer['copyright'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="copyright">
                                            저작권 정보 포함
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="links" name="links"
                                               {{ old('links', $footer['links'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="links">
                                            링크 메뉴 표시
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="social" name="social"
                                               {{ old('social', $footer['social'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="social">
                                            소셜 미디어 아이콘 포함
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
    // Auto-generate key from name
    const nameInput = document.getElementById('name');
    const keyInput = document.getElementById('footer_key');

    nameInput.addEventListener('input', function() {
        if (!keyInput.value || keyInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                keyInput.value = `jiny-site::components.footer.${slug}`;
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

        if (!key) {
            e.preventDefault();
            alert('푸터 키는 필수입니다');
            keyInput.focus();
            return;
        }

        if (!name) {
            e.preventDefault();
            alert('푸터 이름은 필수입니다');
            nameInput.focus();
            return;
        }

        // Validate key format
        if (!key.includes('::') || !key.includes('components.footer.')) {
            e.preventDefault();
            alert('푸터 키는 package::components.footer.name 형식이어야 합니다');
            keyInput.focus();
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
