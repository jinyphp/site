@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title')
Block 미리보기 - {{ $filename }}
@endsection

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
                        <i class="fas fa-eye text-primary me-2"></i>
                        Block 미리보기
                    </h1>
                    <p class="text-muted mb-0">{{ $filename }}.blade.php</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.blocks.preview', $filename) }}?standalone=true"
                       class="btn btn-outline-info me-2"
                       target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>
                        새 창에서 보기
                    </a>
                    <a href="{{ route('admin.cms.blocks.edit', $filename) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i>
                        편집
                    </a>
                    <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <!-- 미리보기 영역 -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-desktop me-2"></i>
                            렌더링 결과
                        </h5>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshPreview()">
                                <i class="fas fa-sync me-1"></i>
                                새로고침
                            </button>
                            <button type="button" class="btn btn-outline-info" onclick="toggleViewMode()">
                                <i class="fas fa-mobile-alt me-1"></i>
                                <span id="viewModeText">모바일 뷰</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($render_error))
                        <div class="alert alert-danger m-3">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>렌더링 오류</h6>
                            <p class="mb-0">{{ $render_error }}</p>
                        </div>
                        <div class="p-3">
                            <h6>원본 소스코드:</h6>
                            <pre class="bg-light p-3 rounded"><code>{{ $original_content }}</code></pre>
                        </div>
                    @elseif($rendered_content)
                        <div id="previewContainer" class="preview-desktop">
                            <iframe id="previewFrame"
                                    src="{{ route('admin.cms.blocks.preview', $filename) }}?standalone=true"
                                    style="width: 100%; border: none; min-height: 500px;"
                                    onload="adjustIframeHeight()"></iframe>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                            <h5>미리보기를 생성할 수 없습니다</h5>
                            <p>블록 내용을 확인해주세요.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 소스코드 탭 -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#rendered-tab">
                                <i class="fas fa-code me-1"></i>
                                렌더링된 HTML
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#source-tab">
                                <i class="fas fa-file-code me-1"></i>
                                원본 Blade
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="rendered-tab">
                            @if($rendered_content)
                                <pre class="mb-0 p-3" style="max-height: 400px; overflow-y: auto;"><code>{{ $rendered_content }}</code></pre>
                            @else
                                <div class="p-3 text-muted">렌더링된 내용이 없습니다.</div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="source-tab">
                            <pre class="mb-0 p-3" style="max-height: 400px; overflow-y: auto;"><code>{{ $original_content }}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <!-- 파일 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        파일 정보
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">카테고리:</td>
                            <td><span class="badge bg-secondary">{{ $file_info['category'] }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">크기:</td>
                            <td>{{ number_format($file_info['size']) }} bytes</td>
                        </tr>
                        <tr>
                            <td class="text-muted">수정일:</td>
                            <td>{{ $file_info['modified'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- 미리보기 옵션 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        미리보기 옵션
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small">화면 크기</label>
                        <div class="btn-group-vertical w-100" role="group">
                            <input type="radio" class="btn-check" name="screenSize" id="desktop" value="desktop" checked>
                            <label class="btn btn-outline-primary btn-sm" for="desktop">
                                <i class="fas fa-desktop me-1"></i> 데스크톱
                            </label>

                            <input type="radio" class="btn-check" name="screenSize" id="tablet" value="tablet">
                            <label class="btn btn-outline-primary btn-sm" for="tablet">
                                <i class="fas fa-tablet-alt me-1"></i> 태블릿
                            </label>

                            <input type="radio" class="btn-check" name="screenSize" id="mobile" value="mobile">
                            <label class="btn btn-outline-primary btn-sm" for="mobile">
                                <i class="fas fa-mobile-alt me-1"></i> 모바일
                            </label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="openFullScreen()">
                            <i class="fas fa-expand me-1"></i>
                            전체화면으로 보기
                        </button>
                    </div>
                </div>
            </div>

            <!-- 테스트 데이터 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-database me-2"></i>
                        테스트 데이터
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small text-muted">
                        <p>미리보기에서 사용되는 샘플 데이터:</p>
                        <ul class="small mb-0">
                            <li><code>$title</code>: "Sample Title"</li>
                            <li><code>$subtitle</code>: "Sample Subtitle"</li>
                            <li><code>$description</code>: "Sample description..."</li>
                            <li><code>$image</code>: Placeholder 이미지</li>
                            <li><code>$items</code>: 샘플 배열 데이터</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.preview-desktop iframe {
    width: 100%;
}

.preview-tablet iframe {
    width: 768px;
    max-width: 100%;
    margin: 0 auto;
    display: block;
}

.preview-mobile iframe {
    width: 375px;
    max-width: 100%;
    margin: 0 auto;
    display: block;
}

#previewContainer {
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 화면 크기 변경
document.querySelectorAll('input[name="screenSize"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const container = document.getElementById('previewContainer');
        container.className = 'preview-' + this.value;
    });
});

// 미리보기 새로고침
function refreshPreview() {
    const iframe = document.getElementById('previewFrame');
    iframe.src = iframe.src;
}

// 뷰 모드 토글 (간단한 버전)
function toggleViewMode() {
    const container = document.getElementById('previewContainer');
    const text = document.getElementById('viewModeText');

    if (container.classList.contains('preview-mobile')) {
        container.className = 'preview-desktop';
        text.textContent = '모바일 뷰';
        document.getElementById('desktop').checked = true;
    } else {
        container.className = 'preview-mobile';
        text.textContent = '데스크톱 뷰';
        document.getElementById('mobile').checked = true;
    }
}

// 전체화면으로 보기
function openFullScreen() {
    const url = '{{ route("admin.cms.blocks.preview", $filename) }}?standalone=true';
    window.open(url, '_blank', 'width=1200,height=800');
}

// iframe 높이 자동 조절
function adjustIframeHeight() {
    const iframe = document.getElementById('previewFrame');
    try {
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        const height = iframeDoc.body.scrollHeight;
        iframe.style.height = Math.max(height, 500) + 'px';
    } catch (e) {
        // 크로스 도메인 이슈로 인해 접근 불가한 경우 기본 높이 유지
        iframe.style.height = '500px';
    }
}
</script>
@endpush
