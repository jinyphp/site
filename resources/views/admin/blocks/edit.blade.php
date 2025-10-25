@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Block 편집')

@push('styles')
<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.preview-container {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    background: #f8f9fa;
    min-height: 300px;
}

.code-editor {
    font-family: 'Courier New', Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
    font-size: 14px;
    line-height: 1.4;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.code-editor:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.nav-tabs .nav-link {
    border: 1px solid transparent;
}

.nav-tabs .nav-link.active {
    border-color: #dee2e6 #dee2e6 #fff;
}

.tab-content {
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
}

.preview-iframe {
    width: 100%;
    border: none;
    min-height: 400px;
    background: white;
}

.preview-section-collapsed {
    display: none !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- 페이지 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-edit text-primary me-2"></i>
                        Block 편집
                    </h1>
                    <p class="text-muted mb-0">
                        @if($folder ?? false)
                            <i class="fas fa-folder-open me-1"></i>
                            {{ $folder }}/{{ $filename ?? 'unknown' }}.blade.php
                        @else
                            {{ $filename ?? 'unknown' }}.blade.php
                        @endif
                    </p>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-info me-2" onclick="openStandalonePreview()">
                        <i class="fas fa-external-link-alt me-1"></i>
                        새 창 미리보기
                    </button>
                    <a href="{{ $folder ? route('admin.cms.blocks.folder', ['folder' => str_replace('/', '.', $folder)]) : route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 오류 메시지 표시 -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- 미리보기 영역 (상단) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 me-3">
                                <i class="fas fa-desktop me-2"></i>
                                미리보기 & 렌더링 결과
                            </h5>
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#preview-tab" type="button">
                                        <i class="fas fa-desktop me-1"></i>
                                        미리보기
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rendered-tab" type="button">
                                        <i class="fas fa-code me-1"></i>
                                        렌더링 HTML
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-success btn-sm" onclick="refreshPreview()">
                                <i class="fas fa-sync me-1"></i>
                                새로고침
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePreviewSection()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                                <span id="toggleText">숨기기</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" id="previewSection">
                    <div class="tab-content">
                        <!-- 미리보기 탭 -->
                        <div class="tab-pane fade show active" id="preview-tab">
                            @if($renderError)
                                <div class="alert alert-danger m-3">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>렌더링 오류</h6>
                                    <p class="mb-0">{{ $renderError }}</p>
                                </div>
                            @elseif($renderedContent)
                                <div class="preview-container p-3" style="min-height: 300px; background: #f8f9fa;">
                                    <iframe id="previewFrame"
                                            class="preview-iframe w-100"
                                            style="height: 400px; border: none; background: white;"
                                            src="{{ route('admin.cms.blocks.edit', $path_param ?? '') }}?standalone=true"></iframe>
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                    <h5>미리보기를 생성할 수 없습니다</h5>
                                    <p>블록 내용을 확인해주세요.</p>
                                </div>
                            @endif
                        </div>

                        <!-- 렌더링 HTML 탭 -->
                        <div class="tab-pane fade" id="rendered-tab">
                            <div class="position-relative">
                                <pre class="mb-0 p-3" style="max-height: 400px; overflow-y: auto; background: #f8f9fa;"><code id="renderedCode">{{ htmlspecialchars($renderedContent ?? '렌더링된 내용이 없습니다.') }}</code></pre>
                                <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2" onclick="copyRenderedContent()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        샘플 데이터로 미리보기가 생성됩니다 ($title, $subtitle, $description 등)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blade 편집 영역 (하단) -->
    <form id="editForm" action="{{ route('admin.cms.blocks.update', $path_param ?? 'unknown') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-code me-2"></i>
                                원본 Blade 편집
                            </h5>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" onclick="formatCode()">
                                    <i class="fas fa-indent me-1"></i>
                                    포맷
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    저장
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <textarea class="form-control code-editor {{ $errors && $errors->has('content') ? 'is-invalid' : '' }}"
                                  id="content"
                                  name="content"
                                  style="border: none; border-radius: 0; resize: none; min-height: 500px;"
                                  onkeydown="handleTabKey(event)"
                                  oninput="updateStats()"
                                  required>{{ old('content', $content ?? '') }}</textarea>
                        @if($errors && $errors->has('content'))
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <span id="lineCount">{{ count(explode("\n", $content ?? '')) }}</span> 줄,
                                <span id="charCount">{{ strlen($content ?? '') }}</span> 문자
                            </small>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-info" onclick="openStandalonePreview()">
                                    <i class="fas fa-external-link-alt me-1"></i>
                                    새 창 미리보기
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- 파일 정보 -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>파일 정보:</strong> {{ $filename ?? 'unknown' }}.blade.php
                        </div>
                        <div class="col-md-2">
                            <strong>크기:</strong> {{ $fileInfo['size'] ?? 0 }} bytes
                        </div>
                        <div class="col-md-3">
                            <strong>수정일:</strong> {{ $fileInfo['modified'] ?? '-' }}
                        </div>
                        <div class="col-md-2">
                            <strong>카테고리:</strong> {{ $fileInfo['category'] ?? 'Other' }}
                        </div>
                        <div class="col-md-2">
                            <strong>상태:</strong>
                            @if($renderError)
                                <span class="badge bg-danger">오류</span>
                            @elseif($renderedContent)
                                <span class="badge bg-success">정상</span>
                            @else
                                <span class="badge bg-warning">렌더링 불가</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 탭 키 처리 (들여쓰기)
function handleTabKey(event) {
    if (event.key === 'Tab') {
        event.preventDefault();
        const textarea = event.target;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;

        textarea.value = textarea.value.substring(0, start) + '    ' + textarea.value.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + 4;

        updateStats();
    }
}

// 통계 업데이트
function updateStats() {
    const content = document.getElementById('content').value;
    const lines = content.split('\n').length;
    const chars = content.length;

    document.getElementById('lineCount').textContent = lines;
    document.getElementById('charCount').textContent = chars;
}

// 미리보기 새로고침
function refreshPreview() {
    const iframe = document.getElementById('previewFrame');
    if (iframe) {
        iframe.src = iframe.src;
    }
}

// 새 창에서 미리보기
function openStandalonePreview() {
    const url = '{{ route("admin.cms.blocks.edit", $path_param ?? "") }}?standalone=true&t=' + Date.now();
    window.open(url, 'blockPreview', 'width=1200,height=800,scrollbars=yes,resizable=yes');
}

// 미리보기 섹션 토글
function togglePreviewSection() {
    const previewSection = document.getElementById('previewSection');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');

    if (previewSection.classList.contains('preview-section-collapsed')) {
        // 보이기
        previewSection.classList.remove('preview-section-collapsed');
        toggleIcon.className = 'fas fa-eye';
        toggleText.textContent = '숨기기';
    } else {
        // 숨기기
        previewSection.classList.add('preview-section-collapsed');
        toggleIcon.className = 'fas fa-eye-slash';
        toggleText.textContent = '보이기';
    }
}

// iframe 높이 자동 조절
function adjustIframeHeight() {
    const iframe = document.getElementById('previewFrame');
    if (iframe) {
        try {
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            if (iframeDoc && iframeDoc.body) {
                const height = iframeDoc.body.scrollHeight;
                iframe.style.height = Math.max(height, 400) + 'px';
            } else {
                iframe.style.height = '400px';
            }
        } catch (e) {
            // 크로스 오리진 에러나 기타 에러 처리
            iframe.style.height = '400px';
            console.log('iframe 높이 조정 실패:', e.message);
        }
    }
}

// 렌더링된 내용 복사
function copyRenderedContent() {
    const renderedContent = @json($renderedContent ?? '');

    if (renderedContent) {
        navigator.clipboard.writeText(renderedContent).then(function() {
            const btn = event.target.closest('button');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');

            setTimeout(function() {
                btn.innerHTML = originalHtml;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
            }, 2000);
        }).catch(function() {
            alert('복사에 실패했습니다.');
        });
    }
}

// 코드 포맷팅 (간단한)
function formatCode() {
    const textarea = document.getElementById('content');
    let content = textarea.value;

    // 간단한 HTML 포맷팅
    content = content.replace(/></g, '>\n<');
    content = content.replace(/^\s+/gm, '');

    const lines = content.split('\n');
    let indentLevel = 0;
    const formatted = [];

    for (let line of lines) {
        line = line.trim();
        if (!line) continue;

        if (line.startsWith('</') || line.startsWith('@end')) {
            indentLevel = Math.max(0, indentLevel - 1);
        }

        formatted.push('    '.repeat(indentLevel) + line);

        if (line.startsWith('<') && !line.startsWith('</') && !line.endsWith('/>') && !line.includes('</')) {
            indentLevel++;
        }
        if (line.startsWith('@@if') || line.startsWith('@@foreach') || line.startsWith('@@for')) {
            indentLevel++;
        }
    }

    textarea.value = formatted.join('\n');
    updateStats();
}

// 저장 단축키
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        document.getElementById('editForm').submit();
    }
});

// 페이지 로드 시 통계 업데이트
document.addEventListener('DOMContentLoaded', function() {
    updateStats();

    // 탭 전환 시 iframe 새로고침
    document.querySelector('button[data-bs-target="#preview-tab"]').addEventListener('shown.bs.tab', function() {
        setTimeout(refreshPreview, 100);
    });
});

// 창 크기 변경 시 iframe 높이 재조정
window.addEventListener('resize', function() {
    setTimeout(adjustIframeHeight, 100);
});
</script>
@endpush