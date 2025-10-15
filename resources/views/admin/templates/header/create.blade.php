@extends('jiny-site::layouts.admin.sidebar')

@section('title', '헤더 생성')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">새 헤더 생성</h1>
                    <p class="mb-0 text-muted">새로운 헤더 템플릿을 생성하여 사이트에 적용할 수 있습니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.header.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 헤더 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.header.index') }}" class="btn btn-secondary">
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
                    <h5 class="card-title mb-0">새 헤더 생성</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.header.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="header_key" class="form-label">헤더 키 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('header_key') is-invalid @enderror"
                                           id="header_key" name="header_key" value="{{ old('header_key') }}"
                                           placeholder="예: jiny-site::components.header.custom" required>
                                    <div class="form-text">
                                        고유한 키 형식을 사용하세요. 예: 'jiny-site::components.header.사용자정의명'
                                    </div>
                                    @error('header_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">헤더 이름 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}"
                                           placeholder="예: 사용자 정의 헤더" required>
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
                                           placeholder="예: jiny-site::components.header.custom">
                                    <div class="form-text">
                                        헤더 Blade 컴포넌트 경로
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
                                              placeholder="헤더의 목적에 대한 간단한 설명">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">헤더 옵션</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="navbar" name="navbar"
                                               {{ old('navbar') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="navbar">
                                            네비게이션 바 포함
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="logo" name="logo"
                                               {{ old('logo') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="logo">
                                            로고 표시
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="search" name="search"
                                               {{ old('search') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="search">
                                            검색 기능 포함
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>팁:</strong>
                            <ul class="mb-0 mt-2">
                                <li>헤더 키는 <code>package::components.header.name</code> 패턴을 따라야 합니다</li>
                                <li>템플릿 경로는 기존 Blade 컴포넌트를 참조해야 합니다</li>
                                <li>필요하지 않은 옵션은 체크하지 않으셔도 됩니다</li>
                                <li>모든 헤더는 설정 파일이나 이 인터페이스에서 관리할 수 있습니다</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.header.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 헤더 생성
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
    const keyInput = document.getElementById('header_key');

    nameInput.addEventListener('input', function() {
        if (!keyInput.value || keyInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                keyInput.value = `jiny-site::components.header.${slug}`;
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
            alert('헤더 키는 필수입니다');
            keyInput.focus();
            return;
        }

        if (!name) {
            e.preventDefault();
            alert('헤더 이름은 필수입니다');
            nameInput.focus();
            return;
        }

        // Validate key format
        if (!key.includes('::') || !key.includes('components.header.')) {
            e.preventDefault();
            alert('헤더 키는 package::components.header.name 형식이어야 합니다');
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