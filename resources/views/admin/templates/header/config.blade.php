@extends('jiny-site::layouts.admin.sidebar')

@section('title', '헤더 설정')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">헤더 설정</h1>
                    <p class="mb-0 text-muted">헤더에 표시될 정보를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.header.index') }}" class="btn btn-outline-secondary">
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
            <ul class="nav nav-tabs nav-fill" id="headerConfigTabs" role="tablist">
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
    <div class="tab-content" id="headerConfigTabContent">
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
                            <form action="{{ route('admin.cms.templates.header.config.basic') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="logo" class="form-label">로고 경로</label>
                                    <input type="text" class="form-control @error('logo') is-invalid @enderror"
                                           id="logo" name="logo"
                                           value="{{ old('logo', $headerConfig['logo']) }}"
                                           placeholder="예: /assets/images/logo.svg">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="brand" class="form-label">브랜드명</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror"
                                           id="brand" name="brand"
                                           value="{{ old('brand', $headerConfig['brand']) }}"
                                           placeholder="예: JinyPHP 채용플랫폼">
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="search" class="form-label">검색 설정</label>
                                    <input type="text" class="form-control @error('search') is-invalid @enderror"
                                           id="search" name="search"
                                           value="{{ old('search', $headerConfig['search']) }}"
                                           placeholder="예: 검색 플레이스홀더 텍스트">
                                    @error('search')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="brand_tagline" class="form-label">브랜드 태그라인</label>
                                    <textarea class="form-control @error('brand_tagline') is-invalid @enderror"
                                              id="brand_tagline" name="brand_tagline" rows="3"
                                              placeholder="예: 개발자들을 위한 최고의 채용 플랫폼">{{ old('brand_tagline', $headerConfig['brand_tagline']) }}</textarea>
                                    @error('brand_tagline')
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

                <!-- 헤더 설정 -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-toggles me-2"></i>헤더 설정
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cms.templates.header.config.settings') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[search_enabled]"
                                               id="search_enabled" value="1"
                                               {{ old('settings.search_enabled', $headerConfig['settings']['search_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="search_enabled">
                                            검색 기능 활성화
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[notifications_enabled]"
                                               id="notifications_enabled" value="1"
                                               {{ old('settings.notifications_enabled', $headerConfig['settings']['notifications_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="notifications_enabled">
                                            알림 기능 활성화
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[user_menu_enabled]"
                                               id="user_menu_enabled" value="1"
                                               {{ old('settings.user_menu_enabled', $headerConfig['settings']['user_menu_enabled'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user_menu_enabled">
                                            사용자 메뉴 활성화
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[dark_mode_toggle]"
                                               id="dark_mode_toggle" value="1"
                                               {{ old('settings.dark_mode_toggle', $headerConfig['settings']['dark_mode_toggle'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dark_mode_toggle">
                                            다크모드 토글
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="settings[sticky_header]"
                                               id="sticky_header" value="1"
                                               {{ old('settings.sticky_header', $headerConfig['settings']['sticky_header'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sticky_header">
                                            고정 헤더
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile_menu_style" class="form-label">모바일 메뉴 스타일</label>
                                    <select class="form-select" id="mobile_menu_style" name="settings[mobile_menu_style]">
                                        <option value="sidebar" {{ old('settings.mobile_menu_style', $headerConfig['settings']['mobile_menu_style'] ?? 'sidebar') == 'sidebar' ? 'selected' : '' }}>사이드바</option>
                                        <option value="dropdown" {{ old('settings.mobile_menu_style', $headerConfig['settings']['mobile_menu_style'] ?? 'sidebar') == 'dropdown' ? 'selected' : '' }}>드롭다운</option>
                                        <option value="fullscreen" {{ old('settings.mobile_menu_style', $headerConfig['settings']['mobile_menu_style'] ?? 'sidebar') == 'fullscreen' ? 'selected' : '' }}>전체화면</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check me-1"></i>저장
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 내비게이션 -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-list me-2"></i>내비게이션
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cms.templates.header.config.navigation') }}" method="POST">
                                @csrf

                                <!-- Primary Navigation -->
                                <h6 class="mb-3">주 메뉴</h6>
                                <div id="primary-navigation" class="mb-4">
                                    @forelse(old('navigation.primary', $headerConfig['navigation']['primary'] ?? []) as $index => $nav)
                                        <div class="primary-nav-item mb-3 border p-3 rounded" data-index="{{ $index }}">
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">메뉴 제목</label>
                                                    <input type="text" class="form-control"
                                                           name="navigation[primary][{{ $index }}][title]"
                                                           value="{{ $nav['title'] ?? '' }}"
                                                           placeholder="예: 홈">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">링크 URL</label>
                                                    <input type="text" class="form-control"
                                                           name="navigation[primary][{{ $index }}][href]"
                                                           value="{{ $nav['href'] ?? '' }}"
                                                           placeholder="예: /">
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="navigation[primary][{{ $index }}][active]"
                                                               value="1" {{ ($nav['active'] ?? false) ? 'checked' : '' }}>
                                                        <label class="form-check-label">활성화</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger remove-primary-nav">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="primary-nav-item mb-3 border p-3 rounded" data-index="0">
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">메뉴 제목</label>
                                                    <input type="text" class="form-control" name="navigation[primary][0][title]" placeholder="예: 홈">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">링크 URL</label>
                                                    <input type="text" class="form-control" name="navigation[primary][0][href]" placeholder="예: /">
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="navigation[primary][0][active]" value="1" checked>
                                                        <label class="form-check-label">활성화</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger remove-primary-nav">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-outline-primary me-2" id="add-primary-nav">
                                    <i class="bi bi-plus me-1"></i>주 메뉴 추가
                                </button>

                                <hr class="my-4">

                                <!-- Secondary Navigation -->
                                <h6 class="mb-3">보조 메뉴</h6>
                                <div id="secondary-navigation" class="mb-4">
                                    @forelse(old('navigation.secondary', $headerConfig['navigation']['secondary'] ?? []) as $index => $nav)
                                        <div class="secondary-nav-item mb-3 border p-3 rounded" data-index="{{ $index }}">
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">메뉴 제목</label>
                                                    <input type="text" class="form-control"
                                                           name="navigation[secondary][{{ $index }}][title]"
                                                           value="{{ $nav['title'] ?? '' }}"
                                                           placeholder="예: 로그인">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">링크 URL</label>
                                                    <input type="text" class="form-control"
                                                           name="navigation[secondary][{{ $index }}][href]"
                                                           value="{{ $nav['href'] ?? '' }}"
                                                           placeholder="예: /login">
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="navigation[secondary][{{ $index }}][active]"
                                                               value="1" {{ ($nav['active'] ?? false) ? 'checked' : '' }}>
                                                        <label class="form-check-label">활성화</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger remove-secondary-nav">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="secondary-nav-item mb-3 border p-3 rounded" data-index="0">
                                            <div class="row align-items-end">
                                                <div class="col-md-4">
                                                    <label class="form-label">메뉴 제목</label>
                                                    <input type="text" class="form-control" name="navigation[secondary][0][title]" placeholder="예: 로그인">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">링크 URL</label>
                                                    <input type="text" class="form-control" name="navigation[secondary][0][href]" placeholder="예: /login">
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="navigation[secondary][0][active]" value="1" checked>
                                                        <label class="form-check-label">활성화</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger remove-secondary-nav">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-outline-primary me-2" id="add-secondary-nav">
                                    <i class="bi bi-plus me-1"></i>보조 메뉴 추가
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check me-1"></i>저장
                                </button>
                            </form>
                        </div>
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

                            <form action="{{ route('admin.cms.templates.header.config.update-json') }}" method="POST" id="json-form">
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
// 주 메뉴 관리
document.getElementById('add-primary-nav').addEventListener('click', function() {
    const container = document.getElementById('primary-navigation');
    const index = container.children.length;

    const html = `
        <div class="primary-nav-item mb-3 border p-3 rounded" data-index="${index}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">메뉴 제목</label>
                    <input type="text" class="form-control" name="navigation[primary][${index}][title]" placeholder="예: 홈">
                </div>
                <div class="col-md-4">
                    <label class="form-label">링크 URL</label>
                    <input type="text" class="form-control" name="navigation[primary][${index}][href]" placeholder="예: /">
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="navigation[primary][${index}][active]" value="1" checked>
                        <label class="form-check-label">활성화</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-primary-nav">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});

// 주 메뉴 삭제
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-primary-nav')) {
        e.target.closest('.primary-nav-item').remove();
    }
});

// 보조 메뉴 추가
document.getElementById('add-secondary-nav').addEventListener('click', function() {
    const container = document.getElementById('secondary-navigation');
    const index = container.children.length;

    const html = `
        <div class="secondary-nav-item mb-3 border p-3 rounded" data-index="${index}">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">메뉴 제목</label>
                    <input type="text" class="form-control" name="navigation[secondary][${index}][title]" placeholder="예: 로그인">
                </div>
                <div class="col-md-4">
                    <label class="form-label">링크 URL</label>
                    <input type="text" class="form-control" name="navigation[secondary][${index}][href]" placeholder="예: /login">
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="navigation[secondary][${index}][active]" value="1" checked>
                        <label class="form-check-label">활성화</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-secondary-nav">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});

// 보조 메뉴 삭제
document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-secondary-nav')) {
        e.target.closest('.secondary-nav-item').remove();
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
    fetch('{{ route("admin.cms.templates.header.config.validate-json") }}', {
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
    fetch('{{ route("admin.cms.templates.header.config.current-json") }}')
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
</style>
@endpush