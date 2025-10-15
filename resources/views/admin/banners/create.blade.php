@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '베너 추가')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-bullhorn me-2"></i>베너 추가
                            </h1>
                            <p class="page-header-subtitle">새로운 베너를 시스템에 추가합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.banner.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">베너 정보</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.site.banner.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">베너 제목 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="베너 제목을 입력하세요"
                                           required>
                                    <div class="form-text">사용자에게 표시될 베너 제목</div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type" class="form-label">베너 타입 <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror"
                                            id="type"
                                            name="type"
                                            required>
                                        <option value="">타입을 선택하세요</option>
                                        <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>정보 (Info)</option>
                                        <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>경고 (Warning)</option>
                                        <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>성공 (Success)</option>
                                        <option value="danger" {{ old('type') == 'danger' ? 'selected' : '' }}>위험 (Danger)</option>
                                        <option value="primary" {{ old('type') == 'primary' ? 'selected' : '' }}>주요 (Primary)</option>
                                        <option value="secondary" {{ old('type') == 'secondary' ? 'selected' : '' }}>보조 (Secondary)</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">베너 메시지 <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message"
                                      name="message"
                                      rows="3"
                                      placeholder="베너에 표시될 메시지를 입력하세요"
                                      required>{{ old('message') }}</textarea>
                            <div class="form-text">사용자에게 표시될 베너 메시지 내용</div>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="link_url" class="form-label">링크 URL</label>
                                    <input type="url"
                                           class="form-control @error('link_url') is-invalid @enderror"
                                           id="link_url"
                                           name="link_url"
                                           value="{{ old('link_url') }}"
                                           placeholder="https://example.com">
                                    <div class="form-text">베너 클릭시 이동할 URL (선택사항)</div>
                                    @error('link_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="link_text" class="form-label">링크 텍스트</label>
                                    <input type="text"
                                           class="form-control @error('link_text') is-invalid @enderror"
                                           id="link_text"
                                           name="link_text"
                                           value="{{ old('link_text') }}"
                                           placeholder="자세히 보기">
                                    <div class="form-text">링크 버튼에 표시될 텍스트</div>
                                    @error('link_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">아이콘 클래스</label>
                                    <input type="text"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           id="icon"
                                           name="icon"
                                           value="{{ old('icon') }}"
                                           placeholder="bi bi-info-circle">
                                    <div class="form-text">Bootstrap Icons 또는 FontAwesome 클래스</div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="background_color" class="form-label">배경색</label>
                                    <input type="color"
                                           class="form-control form-control-color @error('background_color') is-invalid @enderror"
                                           id="background_color"
                                           name="background_color"
                                           value="{{ old('background_color', '#007bff') }}">
                                    <div class="form-text">베너의 배경색 (선택사항)</div>
                                    @error('background_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="text_color" class="form-label">텍스트 색상</label>
                                    <input type="color"
                                           class="form-control form-control-color @error('text_color') is-invalid @enderror"
                                           id="text_color"
                                           name="text_color"
                                           value="{{ old('text_color', '#ffffff') }}">
                                    <div class="form-text">베너의 텍스트 색상 (선택사항)</div>
                                    @error('text_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">시작일</label>
                                    <input type="datetime-local"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ old('start_date') }}">
                                    <div class="form-text">베너 표시 시작일 (선택사항)</div>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">종료일</label>
                                    <input type="datetime-local"
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ old('end_date') }}">
                                    <div class="form-text">베너 표시 종료일 (선택사항)</div>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cookie_days" class="form-label">쿠키 유지일수 <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('cookie_days') is-invalid @enderror"
                                           id="cookie_days"
                                           name="cookie_days"
                                           value="{{ old('cookie_days', 1) }}"
                                           min="1"
                                           max="365"
                                           required>
                                    <div class="form-text">사용자가 베너를 닫은 후 다시 표시하지 않을 일수</div>
                                    @error('cookie_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="enable" name="enable" value="1" {{ old('enable', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable">
                                            베너 활성화
                                        </label>
                                    </div>
                                    <div class="form-text">체크 해제시 베너가 표시되지 않습니다</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_closable" name="is_closable" value="1" {{ old('is_closable', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_closable">
                                            닫기 버튼 표시
                                        </label>
                                    </div>
                                    <div class="form-text">사용자가 베너를 닫을 수 있도록 허용</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.site.banner.index') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-arrow-left me-2"></i>취소
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-save me-2"></i>베너 생성
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 미리보기 -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">베너 미리보기</h4>
                </div>
                <div class="card-body">
                    <div id="banner-preview" class="alert alert-info" role="alert">
                        <div class="d-flex align-items-center">
                            <i id="preview-icon" class="bi bi-info-circle me-2"></i>
                            <div class="flex-grow-1">
                                <strong id="preview-title">베너 제목이 여기에 표시됩니다</strong>
                                <div id="preview-message" class="mt-1">베너 메시지가 여기에 표시됩니다.</div>
                                <div id="preview-link" class="mt-2" style="display: none;">
                                    <a href="#" class="btn btn-sm btn-outline-primary">링크 텍스트</a>
                                </div>
                            </div>
                            <button type="button" id="preview-close" class="btn-close" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 폼 요소들
    const titleInput = document.getElementById('title');
    const messageInput = document.getElementById('message');
    const typeSelect = document.getElementById('type');
    const iconInput = document.getElementById('icon');
    const linkUrlInput = document.getElementById('link_url');
    const linkTextInput = document.getElementById('link_text');
    const backgroundColorInput = document.getElementById('background_color');
    const textColorInput = document.getElementById('text_color');
    const isClosableInput = document.getElementById('is_closable');

    // 미리보기 요소들
    const bannerPreview = document.getElementById('banner-preview');
    const previewIcon = document.getElementById('preview-icon');
    const previewTitle = document.getElementById('preview-title');
    const previewMessage = document.getElementById('preview-message');
    const previewLink = document.getElementById('preview-link');
    const previewClose = document.getElementById('preview-close');

    // 타입별 기본 아이콘 맵핑
    const typeIcons = {
        'info': 'bi bi-info-circle',
        'warning': 'bi bi-exclamation-triangle',
        'success': 'bi bi-check-circle',
        'danger': 'bi bi-x-circle',
        'primary': 'bi bi-star',
        'secondary': 'bi bi-gear'
    };

    // 미리보기 업데이트 함수
    function updatePreview() {
        // 제목 업데이트
        const title = titleInput.value || '베너 제목이 여기에 표시됩니다';
        previewTitle.textContent = title;

        // 메시지 업데이트
        const message = messageInput.value || '베너 메시지가 여기에 표시됩니다.';
        previewMessage.textContent = message;

        // 타입 업데이트
        const type = typeSelect.value || 'info';
        bannerPreview.className = `alert alert-${type}`;

        // 아이콘 업데이트
        const icon = iconInput.value || typeIcons[type] || 'bi bi-info-circle';
        previewIcon.className = icon + ' me-2';

        // 링크 업데이트
        const linkUrl = linkUrlInput.value;
        const linkText = linkTextInput.value || '링크 텍스트';
        if (linkUrl) {
            previewLink.style.display = 'block';
            previewLink.querySelector('a').textContent = linkText;
        } else {
            previewLink.style.display = 'none';
        }

        // 색상 업데이트
        const bgColor = backgroundColorInput.value;
        const textColor = textColorInput.value;
        if (bgColor || textColor) {
            let style = '';
            if (bgColor) style += `background-color: ${bgColor}; border-color: ${bgColor};`;
            if (textColor) style += `color: ${textColor};`;
            bannerPreview.style = style;
        } else {
            bannerPreview.style = '';
        }

        // 닫기 버튼 표시/숨김
        previewClose.style.display = isClosableInput.checked ? 'block' : 'none';
    }

    // 타입 변경시 기본 아이콘 설정
    typeSelect.addEventListener('change', function() {
        if (!iconInput.value) {
            iconInput.value = typeIcons[this.value] || 'bi bi-info-circle';
        }
        updatePreview();
    });

    // 모든 입력 필드에 이벤트 리스너 추가
    [titleInput, messageInput, typeSelect, iconInput, linkUrlInput, linkTextInput,
     backgroundColorInput, textColorInput, isClosableInput].forEach(element => {
        element.addEventListener('input', updatePreview);
        element.addEventListener('change', updatePreview);
    });

    // 초기 미리보기 설정
    updatePreview();
});
</script>

<style>
.form-control-color {
    width: 100%;
    height: 38px;
}

#banner-preview {
    min-height: 80px;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.page-header-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endsection
