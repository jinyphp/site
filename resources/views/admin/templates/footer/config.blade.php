@extends('jiny-site::layouts.admin.sidebar')

@section('title', '푸터 설정')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">푸터 설정</h1>
                    <p class="mb-0 text-muted">푸터에 표시될 정보를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.footer.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> 목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs nav-fill" id="footerConfigTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="form-config-tab" data-bs-toggle="tab" data-bs-target="#form-config" type="button" role="tab" aria-controls="form-config" aria-selected="true">
                        <i class="bi bi-gear me-2"></i>폼 기반 설정
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="json-editor-tab" data-bs-toggle="tab" data-bs-target="#json-editor" type="button" role="tab" aria-controls="json-editor" aria-selected="false">
                        <i class="bi bi-code-slash me-2"></i>JSON 편집기
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="footerConfigTabContent">
        <!-- 폼 기반 설정 탭 -->
        <div class="tab-pane fade show active" id="form-config" role="tabpanel" aria-labelledby="form-config-tab">
            <div class="row">
        <!-- 기본 설정 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear me-2"></i>기본 설정
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.templates.footer.config.basic') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="copyright" class="form-label">저작권 텍스트</label>
                            <input type="text" class="form-control @error('copyright') is-invalid @enderror"
                                   id="copyright" name="copyright"
                                   value="{{ old('copyright', $footerConfig['copyright']) }}"
                                   placeholder="예: 2024 JinyPHP. All Rights Reserved.">
                            @error('copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">로고 경로</label>
                            <input type="text" class="form-control @error('logo') is-invalid @enderror"
                                   id="logo" name="logo"
                                   value="{{ old('logo', $footerConfig['logo']) }}"
                                   placeholder="예: /assets/images/logo.svg">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-1"></i>저장
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 회사 정보 -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building me-2"></i>회사 정보
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.templates.footer.config.company') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="company_name" class="form-label">회사명</label>
                            <input type="text" class="form-control @error('company.name') is-invalid @enderror"
                                   id="company_name" name="company[name]"
                                   value="{{ old('company.name', $footerConfig['company']['name'] ?? '') }}">
                            @error('company.name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="company_description" class="form-label">회사 설명</label>
                            <textarea class="form-control @error('company.description') is-invalid @enderror"
                                      id="company_description" name="company[description]" rows="3">{{ old('company.description', $footerConfig['company']['description'] ?? '') }}</textarea>
                            @error('company.description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company_email" class="form-label">이메일</label>
                                <input type="email" class="form-control @error('company.email') is-invalid @enderror"
                                       id="company_email" name="company[email]"
                                       value="{{ old('company.email', $footerConfig['company']['email'] ?? '') }}">
                                @error('company.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="company_phone" class="form-label">전화번호</label>
                                <input type="text" class="form-control @error('company.phone') is-invalid @enderror"
                                       id="company_phone" name="company[phone]"
                                       value="{{ old('company.phone', $footerConfig['company']['phone'] ?? '') }}">
                                @error('company.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="company_address" class="form-label">주소</label>
                            <textarea class="form-control @error('company.address') is-invalid @enderror"
                                      id="company_address" name="company[address]" rows="2">{{ old('company.address', $footerConfig['company']['address'] ?? '') }}</textarea>
                            @error('company.address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="company_hours" class="form-label">운영시간</label>
                            <input type="text" class="form-control @error('company.hours') is-invalid @enderror"
                                   id="company_hours" name="company[hours]"
                                   value="{{ old('company.hours', $footerConfig['company']['hours'] ?? '') }}"
                                   placeholder="예: 월-금 9:00-18:00">
                            @error('company.hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-1"></i>저장
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 소셜 링크 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-share me-2"></i>소셜 링크
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.templates.footer.config.social') }}" method="POST">
                        @csrf
                        <div id="social-links">
                            @forelse(old('social', $footerConfig['social']) as $index => $social)
                                <div class="social-link-item mb-3" data-index="{{ $index }}">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">플랫폼</label>
                                            <input type="text" class="form-control @error('social.'.$index.'.platform') is-invalid @enderror"
                                                   name="social[{{ $index }}][platform]"
                                                   value="{{ $social['platform'] ?? '' }}"
                                                   placeholder="예: Facebook">
                                            @error('social.'.$index.'.platform')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">URL</label>
                                            <input type="url" class="form-control @error('social.'.$index.'.url') is-invalid @enderror"
                                                   name="social[{{ $index }}][url]"
                                                   value="{{ $social['url'] ?? '' }}"
                                                   placeholder="https://facebook.com/yourpage">
                                            @error('social.'.$index.'.url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">아이콘 클래스</label>
                                            <input type="text" class="form-control @error('social.'.$index.'.icon') is-invalid @enderror"
                                                   name="social[{{ $index }}][icon]"
                                                   value="{{ $social['icon'] ?? '' }}"
                                                   placeholder="bi-facebook">
                                            @error('social.'.$index.'.icon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger remove-social-link">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="social-link-item mb-3" data-index="0">
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label">플랫폼</label>
                                            <input type="text" class="form-control" name="social[0][platform]" placeholder="예: Facebook">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">URL</label>
                                            <input type="url" class="form-control" name="social[0][url]" placeholder="https://facebook.com/yourpage">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">아이콘 클래스</label>
                                            <input type="text" class="form-control" name="social[0][icon]" placeholder="bi-facebook">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger remove-social-link">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-outline-primary me-2" id="add-social-link">
                            <i class="bi bi-plus me-1"></i>소셜 링크 추가
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-1"></i>저장
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 메뉴 섹션 -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul me-2"></i>메뉴 섹션
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.templates.footer.config.menu-sections') }}" method="POST">
                        @csrf
                        <div id="menu-sections">
                            @forelse($footerConfig['menu_sections'] as $key => $section)
                                <div class="menu-section-item mb-4 border p-3 rounded" data-key="{{ $key }}">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">{{ ucfirst($key) }} 섹션</h6>
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-menu-section">
                                            <i class="bi bi-trash"></i> 섹션 삭제
                                        </button>
                                    </div>
                                    <input type="hidden" name="menu_sections[{{ $key }}][key]" value="{{ $key }}">
                                    <div class="mb-3">
                                        <label class="form-label">섹션 제목</label>
                                        <input type="text" class="form-control" name="menu_sections[{{ $key }}][title]"
                                               value="{{ old('menu_sections.'.$key.'.title', $section['title']) }}">
                                    </div>
                                    <div class="menu-links" data-section="{{ $key }}">
                                        @forelse($section['links'] ?? [] as $linkIndex => $link)
                                            <div class="menu-link-item mb-2" data-link-index="{{ $linkIndex }}">
                                                <div class="row align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label">링크 제목</label>
                                                        <input type="text" class="form-control"
                                                               name="menu_sections[{{ $key }}][links][{{ $linkIndex }}][title]"
                                                               value="{{ $link['title'] }}"
                                                               placeholder="예: 회사소개">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">링크 URL</label>
                                                        <input type="text" class="form-control"
                                                               name="menu_sections[{{ $key }}][links][{{ $linkIndex }}][href]"
                                                               value="{{ $link['href'] }}"
                                                               placeholder="예: /about">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-danger remove-menu-link">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="menu-link-item mb-2" data-link-index="0">
                                                <div class="row align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label">링크 제목</label>
                                                        <input type="text" class="form-control"
                                                               name="menu_sections[{{ $key }}][links][0][title]"
                                                               placeholder="예: 회사소개">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">링크 URL</label>
                                                        <input type="text" class="form-control"
                                                               name="menu_sections[{{ $key }}][links][0][href]"
                                                               placeholder="예: /about">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-outline-danger remove-menu-link">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm add-menu-link" data-section="{{ $key }}">
                                        <i class="bi bi-plus me-1"></i>링크 추가
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-muted">메뉴 섹션이 없습니다.</p>
                                </div>
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-outline-primary me-2" id="add-menu-section">
                            <i class="bi bi-plus me-1"></i>메뉴 섹션 추가
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-1"></i>저장
                        </button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <!-- JSON 편집기 탭 -->
        <div class="tab-pane fade" id="json-editor" role="tabpanel" aria-labelledby="json-editor-tab">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-code-slash me-2"></i>JSON 파일 직접 편집
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>주의:</strong> JSON 파일을 직접 편집할 때는 형식에 주의하세요. 잘못된 형식은 시스템 오류를 발생시킬 수 있습니다.
                            </div>

                            <!-- JSON 편집 알림용 컨테이너 -->
                            <div id="json-alerts"></div>

                            <form action="{{ route('admin.cms.templates.footer.config.update-json') }}" method="POST" id="json-form">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="json_content" class="form-label">JSON 내용</label>
                                        <div>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" id="validate-json">
                                                <i class="bi bi-check-circle me-1"></i>검증
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-sm me-2" id="format-json">
                                                <i class="bi bi-arrows-angle-expand me-1"></i>정렬
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-sm" id="load-current">
                                                <i class="bi bi-arrow-clockwise me-1"></i>현재 값 불러오기
                                            </button>
                                        </div>
                                    </div>
                                    <textarea class="form-control @error('json_content') is-invalid @enderror font-monospace"
                                              id="json_content" name="json_content" rows="25"
                                              placeholder="JSON 내용을 입력하세요...">{{ old('json_content', '') }}</textarea>
                                    @error('json_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <span id="json-status" class="text-muted">JSON 유효성을 확인하려면 "검증" 버튼을 클릭하세요.</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary" id="reset-json">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>초기화
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" id="save-json">
                                            <i class="bi bi-save me-1"></i>JSON 저장
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 소셜 링크 관리
document.getElementById('add-social-link').addEventListener('click', function() {
    const container = document.getElementById('social-links');
    const index = container.children.length;

    const html = `
        <div class="social-link-item mb-3" data-index="${index}">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">플랫폼</label>
                    <input type="text" class="form-control" name="social[${index}][platform]" placeholder="예: Facebook">
                </div>
                <div class="col-md-4">
                    <label class="form-label">URL</label>
                    <input type="url" class="form-control" name="social[${index}][url]" placeholder="https://facebook.com/yourpage">
                </div>
                <div class="col-md-3">
                    <label class="form-label">아이콘 클래스</label>
                    <input type="text" class="form-control" name="social[${index}][icon]" placeholder="bi-facebook">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-social-link">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});

// 소셜 링크 삭제
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-social-link')) {
        e.target.closest('.social-link-item').remove();
    }
});

// 메뉴 섹션 추가
document.getElementById('add-menu-section').addEventListener('click', function() {
    const sectionKey = prompt('메뉴 섹션 키를 입력하세요 (예: company, community):');
    if (!sectionKey) return;

    const container = document.getElementById('menu-sections');
    const html = `
        <div class="menu-section-item mb-4 border p-3 rounded" data-key="${sectionKey}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">${sectionKey} 섹션</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-menu-section">
                    <i class="bi bi-trash"></i> 섹션 삭제
                </button>
            </div>
            <input type="hidden" name="menu_sections[${sectionKey}][key]" value="${sectionKey}">
            <div class="mb-3">
                <label class="form-label">섹션 제목</label>
                <input type="text" class="form-control" name="menu_sections[${sectionKey}][title]" placeholder="섹션 제목">
            </div>
            <div class="menu-links" data-section="${sectionKey}">
                <div class="menu-link-item mb-2" data-link-index="0">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">링크 제목</label>
                            <input type="text" class="form-control" name="menu_sections[${sectionKey}][links][0][title]" placeholder="예: 회사소개">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">링크 URL</label>
                            <input type="text" class="form-control" name="menu_sections[${sectionKey}][links][0][href]" placeholder="예: /about">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger remove-menu-link">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm add-menu-link" data-section="${sectionKey}">
                <i class="bi bi-plus me-1"></i>링크 추가
            </button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});

// 메뉴 섹션 삭제
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-menu-section')) {
        e.target.closest('.menu-section-item').remove();
    }
});

// 메뉴 링크 추가
document.addEventListener('click', function(e) {
    if (e.target.closest('.add-menu-link')) {
        const button = e.target.closest('.add-menu-link');
        const sectionKey = button.dataset.section;
        const linksContainer = button.parentElement.querySelector('.menu-links');
        const linkIndex = linksContainer.children.length;

        const html = `
            <div class="menu-link-item mb-2" data-link-index="${linkIndex}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">링크 제목</label>
                        <input type="text" class="form-control" name="menu_sections[${sectionKey}][links][${linkIndex}][title]" placeholder="예: 회사소개">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">링크 URL</label>
                        <input type="text" class="form-control" name="menu_sections[${sectionKey}][links][${linkIndex}][href]" placeholder="예: /about">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger remove-menu-link">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        linksContainer.insertAdjacentHTML('beforeend', html);
    }
});

// 메뉴 링크 삭제
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-menu-link')) {
        e.target.closest('.menu-link-item').remove();
    }
});

// JSON 편집기 기능들
document.getElementById('validate-json').addEventListener('click', function() {
    const jsonContent = document.getElementById('json_content').value;
    const statusElement = document.getElementById('json-status');

    if (!jsonContent.trim()) {
        statusElement.innerHTML = '<span class="text-warning">JSON 내용이 비어있습니다.</span>';
        return;
    }

    // AJAX 요청으로 서버에서 검증
    fetch('{{ route("admin.cms.templates.footer.config.validate-json") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            json_content: jsonContent
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            statusElement.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>JSON 형식이 올바릅니다!</span>';
        } else {
            statusElement.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>JSON 형식 오류: ' + data.error + '</span>';
        }
    })
    .catch(error => {
        statusElement.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i>검증 중 오류가 발생했습니다: ' + error.message + '</span>';
    });
});

document.getElementById('format-json').addEventListener('click', function() {
    const jsonContent = document.getElementById('json_content').value;
    const statusElement = document.getElementById('json-status');

    if (!jsonContent.trim()) {
        statusElement.innerHTML = '<span class="text-warning">JSON 내용이 비어있습니다.</span>';
        return;
    }

    try {
        const parsed = JSON.parse(jsonContent);
        const formatted = JSON.stringify(parsed, null, 2);
        document.getElementById('json_content').value = formatted;
        statusElement.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>JSON이 정렬되었습니다.</span>';
    } catch (error) {
        statusElement.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>JSON 형식이 올바르지 않습니다: ' + error.message + '</span>';
    }
});

document.getElementById('load-current').addEventListener('click', function() {
    loadJsonContent();
});

function loadJsonContent() {
    const statusElement = document.getElementById('json-status');
    statusElement.innerHTML = '<span class="text-info"><i class="bi bi-arrow-clockwise me-1"></i>현재 JSON 파일을 불러오는 중...</span>';

    // 현재 JSON 파일 내용을 서버에서 가져와서 textarea에 로드
    fetch('{{ route("admin.cms.templates.footer.config.current-json") }}')
        .then(response => response.json())
        .then(data => {
            if (data.content) {
                document.getElementById('json_content').value = data.content;
                statusElement.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>현재 JSON 파일 내용을 불러왔습니다.</span>';
            } else {
                statusElement.innerHTML = '<span class="text-warning"><i class="bi bi-exclamation-triangle me-1"></i>JSON 파일 내용이 비어있습니다.</span>';
            }
        })
        .catch(error => {
            statusElement.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>파일 로드 중 오류가 발생했습니다: ' + error.message + '</span>';
        });
}

// JSON 편집기 탭이 활성화될 때 자동으로 JSON 내용 로드
document.getElementById('json-editor-tab').addEventListener('shown.bs.tab', function () {
    const textarea = document.getElementById('json_content');
    if (!textarea.value.trim()) {
        loadJsonContent();
    }
});

document.getElementById('reset-json').addEventListener('click', function() {
    if (confirm('JSON 내용을 초기화하시겠습니까?')) {
        document.getElementById('json_content').value = '';
        document.getElementById('json-status').innerHTML = '<span class="text-muted">JSON 유효성을 확인하려면 "검증" 버튼을 클릭하세요.</span>';
    }
});

// JSON 저장 전 확인
document.getElementById('json-form').addEventListener('submit', function(e) {
    const jsonContent = document.getElementById('json_content').value;

    if (!jsonContent.trim()) {
        e.preventDefault();
        alert('JSON 내용이 비어있습니다.');
        return;
    }

    try {
        JSON.parse(jsonContent);
    } catch (error) {
        e.preventDefault();
        if (!confirm('JSON 형식이 올바르지 않습니다. 그래도 저장하시겠습니까?\n\n오류: ' + error.message)) {
            return;
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-xs {
    font-size: 0.7rem;
}

.menu-section-item {
    background-color: #f8f9fc;
}

.menu-link-item {
    background-color: #fff;
    border-radius: 0.25rem;
    padding: 0.5rem;
}
</style>
@endpush