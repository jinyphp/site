@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '새 Block 생성')

@push('styles')
<!-- FontAwesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <!-- 페이지 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        새 Block 생성
                    </h1>
                    <p class="text-muted mb-0">
                        @if($currentFolder)
                            {{ $currentFolder }} 폴더에 새로운 블록 템플릿을 생성합니다
                        @else
                            새로운 블록 템플릿을 생성합니다
                        @endif
                    </p>
                </div>
                <div>
                    @if($currentFolder)
                        <a href="{{ route('admin.cms.blocks.folder', str_replace('/', '.', $currentFolder)) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            {{ $currentFolder }} 폴더로
                        </a>
                    @else
                        <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            목록으로
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.cms.blocks.store') }}" method="POST" id="createForm">
        @csrf
        @if($currentFolder)
            <input type="hidden" name="folder" value="{{ $folderParam }}">
        @endif
        <div class="row">
            <div class="col-lg-8">
                <!-- 기본 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            블록 정보
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="filename" class="form-label">파일명 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text"
                                       class="form-control @error('filename') is-invalid @enderror"
                                       id="filename"
                                       name="filename"
                                       value="{{ old('filename') }}"
                                       placeholder="예: hero_main, about_team"
                                       required>
                                <span class="input-group-text">.blade.php</span>
                            </div>
                            @error('filename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                영문, 숫자, 언더스코어(_), 하이픈(-)만 사용 가능합니다.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">설명</label>
                            <input type="text"
                                   class="form-control @error('description') is-invalid @enderror"
                                   id="description"
                                   name="description"
                                   value="{{ old('description') }}"
                                   placeholder="블록에 대한 간단한 설명을 입력하세요">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">블록 내용 <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      rows="20"
                                      placeholder="Blade 템플릿 코드를 입력하세요..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 작업 버튼 -->
                <div class="d-flex justify-content-between">
                    @if($currentFolder)
                        <a href="{{ route('admin.cms.blocks.folder', str_replace('/', '.', $currentFolder)) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            취소
                        </a>
                    @else
                        <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            취소
                        </a>
                    @endif
                    <div>
                        <button type="button" class="btn btn-outline-info me-2" onclick="previewCode()">
                            <i class="fas fa-code me-1"></i>
                            코드 미리보기
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            블록 생성
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- 카테고리 가이드 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tags me-2"></i>
                            카테고리 가이드
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="mb-2">
                                <strong>Hero 블록:</strong> hero01_, hero02_, hero_, hero
                            </div>
                            <div class="mb-2">
                                <strong>About 블록:</strong> about_
                            </div>
                            <div class="mb-2">
                                <strong>Features 블록:</strong> feature_, features_
                            </div>
                            <div class="mb-2">
                                <strong>CTA 블록:</strong> cta_, call_to_action
                            </div>
                            <div class="mb-2">
                                <strong>기타:</strong> testimonial_, pricing_, course_
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 템플릿 선택 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-code me-2"></i>
                            템플릿 선택
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select class="form-select" id="templateSelect" onchange="loadTemplate()">
                                <option value="">템플릿 선택...</option>
                                @foreach($templates as $key => $template)
                                    <option value="{{ $key }}">{{ $template['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="small text-muted">
                            미리 정의된 템플릿을 선택하면 기본 코드가 자동으로 입력됩니다.
                        </div>
                    </div>
                </div>

                <!-- 도움말 -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-question-circle me-2"></i>
                            도움말
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="mb-3">
                                <strong>Blade 문법 예제:</strong>
                                <pre class="small bg-light p-2 rounded mt-1"><code>{{-- 주석 --}}
@@if($condition)
    내용
@@endif

@{{ "$variable" }}
@{!! "$html" !!}</code></pre>
                            </div>
                            <div class="mb-3">
                                <strong>Bootstrap 클래스:</strong>
                                <ul class="small mb-0">
                                    <li>container, container-fluid</li>
                                    <li>row, col-*, col-md-*</li>
                                    <li>btn, btn-primary</li>
                                    <li>card, card-body</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 코드 미리보기는 새 창에서 열립니다 -->
@endsection

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 템플릿 데이터
const templates = @json($templates);

function loadTemplate() {
    const select = document.getElementById('templateSelect');
    const content = document.getElementById('content');
    const selectedTemplate = select.value;

    if (selectedTemplate && templates[selectedTemplate]) {
        content.value = templates[selectedTemplate].content;

        // 파일명 자동 설정
        const filename = document.getElementById('filename');
        if (!filename.value) {
            filename.value = selectedTemplate === 'basic' ? 'new_section' : selectedTemplate + '_section';
        }
    }
}

function previewCode() {
    const content = document.getElementById('content').value;
    if (!content.trim()) {
        alert('미리보기할 내용을 입력해주세요.');
        return;
    }

    // 코드를 팝업 창에서 보여주기
    const previewWindow = window.open('', 'codePreview', 'width=800,height=600,scrollbars=yes,resizable=yes');
    previewWindow.document.write(`
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Code Preview</title>
    <style>
        body { font-family: monospace; margin: 20px; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .line-numbers { color: #999; margin-right: 10px; user-select: none; }
    </style>
</head>
<body>
    <h3>블록 코드 미리보기</h3>
    <pre>${content.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
    <button onclick="window.close()" style="margin-top: 10px; padding: 5px 15px;">닫기</button>
</body>
</html>
    `);
    previewWindow.document.close();
}

// 폼 검증
document.getElementById('createForm').addEventListener('submit', function(e) {
    const filename = document.getElementById('filename').value;
    const content = document.getElementById('content').value;

    if (!filename.trim()) {
        alert('파일명을 입력해주세요.');
        e.preventDefault();
        return;
    }

    if (!/^[a-zA-Z0-9_-]+$/.test(filename)) {
        alert('파일명은 영문, 숫자, 언더스코어(_), 하이픈(-)만 사용 가능합니다.');
        e.preventDefault();
        return;
    }

    if (!content.trim()) {
        alert('블록 내용을 입력해주세요.');
        e.preventDefault();
        return;
    }
});

// 파일명 입력시 실시간 검증
document.getElementById('filename').addEventListener('input', function() {
    const value = this.value;
    const isValid = /^[a-zA-Z0-9_-]*$/.test(value);

    if (!isValid) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush
