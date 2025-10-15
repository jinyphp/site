@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '콘텐츠 블럭 수정: ' . ($content->title ?: '제목 없음'))

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="fe fe-edit me-2"></i>
                                콘텐츠 블럭 수정
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.cms.pages.index') }}">페이지 관리</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.cms.pages.show', $page->id) }}">{{ $page->title }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">블럭 수정</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.pages.show', $page->id) }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>블럭 목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.cms.pages.content.update', [$page->id, $content->id]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- 메인 콘텐츠 -->
            <div class="col-lg-8">
                <!-- 기본 정보 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="{{ $content->block_type_icon }} me-2"></i>
                            {{ $content->block_type_name }} 블럭 편집
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- 블럭 타입 -->
                        <div class="mb-3">
                            <label for="block_type" class="form-label">블럭 타입 <span class="text-danger">*</span></label>
                            <select class="form-select @error('block_type') is-invalid @enderror"
                                    id="block_type" name="block_type" required>
                                @foreach($blockTypes as $type => $info)
                                    <option value="{{ $type }}"
                                            {{ old('block_type', $content->block_type) === $type ? 'selected' : '' }}
                                            data-icon="{{ $info['icon'] }}"
                                            data-description="{{ $info['description'] }}">
                                        {{ $info['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('block_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="block-type-description">
                                {{ $blockTypes[$content->block_type]['description'] ?? '' }}
                            </div>
                        </div>

                        <!-- 제목 -->
                        <div class="mb-3">
                            <label for="title" class="form-label">제목</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $content->title) }}"
                                   placeholder="블럭 제목 (선택사항)">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 제목 숨기기 -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="hide_title" name="hide_title"
                                       value="1" {{ old('hide_title', $content->hide_title) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hide_title">
                                    출력 렌더링시 제목 숨기기
                                </label>
                            </div>
                            <div class="form-text">체크하면 실제 페이지에서 블럭 제목이 표시되지 않습니다.</div>
                        </div>

                        <!-- 내용 -->
                        <div class="mb-3">
                            <label for="content" class="form-label">내용</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15"
                                      placeholder="블럭 내용을 입력하세요">{{ old('content', $content->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="content-help">
                                <!-- 블럭 타입별 도움말이 여기에 표시됩니다 -->
                            </div>
                        </div>

                        <!-- CSS 클래스 -->
                        <div class="mb-3">
                            <label for="css_class" class="form-label">CSS 클래스</label>
                            <input type="text" class="form-control @error('css_class') is-invalid @enderror"
                                   id="css_class" name="css_class" value="{{ old('css_class', $content->css_class) }}"
                                   placeholder="예: text-center, bg-primary, mb-4">
                            @error('css_class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">블럭에 적용할 CSS 클래스를 공백으로 구분하여 입력하세요.</div>
                        </div>
                    </div>
                </div>

                <!-- 고급 설정 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">고급 설정</h4>
                    </div>
                    <div class="card-body">
                        <!-- 설정 JSON -->
                        <div class="mb-3">
                            <label for="settings" class="form-label">설정 (JSON)</label>
                            <textarea class="form-control @error('settings') is-invalid @enderror"
                                      id="settings" name="settings" rows="6"
                                      placeholder='{"key": "value"}'>{{ old('settings', json_encode($content->settings ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
                            @error('settings')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">블럭 타입별 추가 설정을 JSON 형식으로 입력하세요.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 -->
            <div class="col-lg-4">
                <!-- 블럭 정보 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">블럭 정보</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-3">
                            <tr>
                                <th width="80">ID:</th>
                                <td>{{ $content->id }}</td>
                            </tr>
                            <tr>
                                <th>타입:</th>
                                <td>
                                    <i class="{{ $content->block_type_icon }} me-1"></i>
                                    {{ $content->block_type_name }}
                                </td>
                            </tr>
                            <tr>
                                <th>순서:</th>
                                <td>{{ $content->sort_order }}</td>
                            </tr>
                            <tr>
                                <th>생성일:</th>
                                <td>{{ $content->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @if($content->updated_at->ne($content->created_at))
                            <tr>
                                <th>수정일:</th>
                                <td>{{ $content->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- 설정 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">설정</h4>
                    </div>
                    <div class="card-body">
                        <!-- 정렬 순서 -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">정렬 순서</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $content->sort_order) }}" min="0">
                            <div class="form-text">숫자가 작을수록 먼저 표시됩니다.</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 활성화 상태 -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                       value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    블럭 활성화
                                </label>
                            </div>
                            <div class="form-text">비활성화된 블럭은 표시되지 않습니다.</div>
                        </div>
                    </div>
                </div>

                <!-- 작업 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>수정 저장
                            </button>
                            <a href="{{ route('admin.cms.pages.show', $page->id) }}" class="btn btn-outline-secondary">
                                <i class="fe fe-x me-2"></i>취소
                            </a>
                            <hr>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteContent()">
                                <i class="fe fe-trash me-2"></i>블럭 삭제
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 미리보기 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">미리보기</h4>
                    </div>
                    <div class="card-body">
                        <div id="content-preview" class="border rounded p-3" style="min-height: 100px; background: #f8f9fa;">
                            <div class="text-muted text-center">
                                <i class="fe fe-eye"></i>
                                내용을 입력하면 미리보기가 표시됩니다
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">블럭 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 블럭을 삭제하시겠습니까?</p>
                <p class="text-danger small">삭제된 블럭은 복구할 수 없습니다.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// 블럭 타입별 도움말
const blockTypeHelp = {
    'text': '일반 텍스트를 입력하세요. 줄바꿈은 자동으로 처리됩니다.',
    'html': 'HTML 코드를 직접 입력하세요. 스크립트 태그는 보안상 제한될 수 있습니다.',
    'markdown': 'Markdown 형식으로 작성하세요. **굵게**, *기울임*, [링크](url) 등을 사용할 수 있습니다.',
    'blade': 'Blade 템플릿 이름을 입력하세요. package::view.name 또는 folder.subfolder.viewname 형식으로 입력합니다 (예: jiny-site::admin.layouts.main)',
    'image': '이미지 URL을 입력하거나 alt 텍스트와 함께 설정하세요.',
    'video': '비디오 URL을 입력하세요. YouTube, Vimeo 등의 임베드 코드도 지원합니다.',
    'code': '프로그래밍 코드를 입력하세요. 설정에서 언어를 지정할 수 있습니다.',
    'divider': '구분선이 표시됩니다. 내용은 무시되며 CSS 클래스로 스타일을 조정할 수 있습니다.',
    'button': '버튼 텍스트를 입력하고, 설정에서 링크 URL과 스타일을 지정하세요.',
    'alert': '알림 메시지를 입력하세요. 설정에서 알림 타입을 지정할 수 있습니다.'
};

// 블럭 타입별 placeholder
const blockTypePlaceholders = {
    'text': '텍스트 내용을 입력하세요',
    'html': '<div>HTML 코드를 입력하세요</div>',
    'markdown': '## 마크다운 제목\n\n내용을 **마크다운** 형식으로 작성하세요.',
    'blade': 'jiny-site::admin.layouts.main',
    'image': 'https://example.com/image.jpg',
    'video': 'https://example.com/video.mp4',
    'code': 'function example() {\n    return "Hello World";\n}',
    'divider': '',
    'button': '클릭하세요',
    'alert': '중요한 알림 메시지입니다.'
};

// 블럭 타입 변경 시 도움말 업데이트
document.getElementById('block_type').addEventListener('change', function() {
    const helpDiv = document.getElementById('content-help');
    const contentTextarea = document.getElementById('content');
    const selectedType = this.value;

    // 도움말 업데이트
    if (selectedType && blockTypeHelp[selectedType]) {
        helpDiv.innerHTML = `<i class="fe fe-info-circle me-1"></i>${blockTypeHelp[selectedType]}`;
        helpDiv.className = 'form-text text-info';
    } else {
        helpDiv.textContent = '';
        helpDiv.className = 'form-text';
    }

    // placeholder 업데이트
    if (selectedType && blockTypePlaceholders[selectedType]) {
        contentTextarea.placeholder = blockTypePlaceholders[selectedType];
    } else {
        contentTextarea.placeholder = '블럭 내용을 입력하세요';
    }

    // 블럭 타입 설명 업데이트
    const option = this.options[this.selectedIndex];
    const description = option.getAttribute('data-description');
    const descDiv = document.getElementById('block-type-description');
    if (description) {
        descDiv.textContent = description;
    }

    // 미리보기 업데이트
    updatePreview();
});

// 내용 변경 시 미리보기 업데이트
document.getElementById('content').addEventListener('input', updatePreview);

function updatePreview() {
    const content = document.getElementById('content').value;
    const blockType = document.getElementById('block_type').value;
    const previewDiv = document.getElementById('content-preview');

    if (!content.trim()) {
        previewDiv.innerHTML = '<div class="text-muted text-center"><i class="fe fe-eye"></i> 내용을 입력하면 미리보기가 표시됩니다</div>';
        return;
    }

    // 간단한 미리보기 (실제 렌더링과는 다를 수 있음)
    let preview = '';
    switch (blockType) {
        case 'text':
            preview = content.replace(/\n/g, '<br>');
            break;
        case 'html':
            preview = content;
            break;
        case 'markdown':
            // 간단한 마크다운 처리
            preview = content
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\n/g, '<br>');
            break;
        case 'code':
            preview = `<pre><code>${escapeHtml(content)}</code></pre>`;
            break;
        case 'divider':
            preview = '<hr class="my-3">';
            break;
        default:
            preview = escapeHtml(content);
    }

    previewDiv.innerHTML = preview;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// 삭제 함수
function deleteContent() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('deleteForm').action = `{{ route('admin.cms.pages.content.destroy', [$page->id, $content->id]) }}`;
    modal.show();
}

// JSON 형식 검증
document.getElementById('settings').addEventListener('blur', function() {
    const value = this.value.trim();
    if (value && value !== '{}' && value !== '') {
        try {
            JSON.parse(value);
            this.classList.remove('is-invalid');
        } catch (e) {
            this.classList.add('is-invalid');
            if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'JSON 형식이 올바르지 않습니다.';
                this.parentNode.appendChild(feedback);
            }
        }
    } else {
        this.classList.remove('is-invalid');
    }
});

// 초기 로드 시 미리보기 및 placeholder 업데이트
document.addEventListener('DOMContentLoaded', function() {
    updatePreview();

    // 초기 placeholder 설정
    const blockTypeSelect = document.getElementById('block_type');
    const contentTextarea = document.getElementById('content');
    const selectedType = blockTypeSelect.value;

    if (selectedType && blockTypePlaceholders[selectedType]) {
        contentTextarea.placeholder = blockTypePlaceholders[selectedType];
    }
});
</script>
@endpush
