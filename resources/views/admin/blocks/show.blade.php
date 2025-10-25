@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', 'Block 상세보기')

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
                        <i class="fas fa-cube text-primary me-2"></i>
                        Block 상세보기
                    </h1>
                    <p class="text-muted mb-0">{{ $filename ?? 'unknown' }}.blade.php</p>
                </div>
                <div>
                    @if($exists ?? false)
                    <a href="{{ route('admin.cms.blocks.edit', $filename ?? '') }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i>
                        편집
                    </a>
                    @endif
                    <a href="{{ route('admin.cms.blocks.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($exists ?? false)
        <div class="row">
            <div class="col-lg-9">
                <!-- 미리보기 영역 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-desktop me-2"></i>
                            블록 미리보기
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($renderError)
                            <div class="alert alert-danger m-3">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>렌더링 오류</h6>
                                <p class="mb-0">{{ $renderError }}</p>
                            </div>
                        @elseif($renderedContent)
                            <div class="border-bottom p-3" style="background-color: #f8f9fa;">
                                {!! $renderedContent !!}
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <h5>미리보기를 생성할 수 없습니다</h5>
                                <p>블록 내용을 확인해주세요.</p>
                            </div>
                        @endif

                        <div class="text-muted small p-3">
                            <i class="fas fa-info-circle me-1"></i>
                            위 미리보기는 샘플 데이터를 사용하여 표시됩니다.
                        </div>
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
                                @if($renderedContent)
                                    <div class="position-relative">
                                        <pre class="mb-0 p-3" style="max-height: 400px; overflow-y: auto;"><code>{{ htmlspecialchars($renderedContent) }}</code></pre>
                                        <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2" onclick="copyToClipboard('renderedContent')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="p-3 text-muted">렌더링된 내용이 없습니다.</div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="source-tab">
                                <div class="position-relative">
                                    <pre class="mb-0 p-3" style="max-height: 400px; overflow-y: auto;"><code>{{ $originalContent ?? '' }}</code></pre>
                                    <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2" onclick="copyToClipboard('sourceContent')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
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
                                <td class="text-muted">파일명:</td>
                                <td><strong>{{ $filename ?? 'unknown' }}.blade.php</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">상태:</td>
                                <td>
                                    @if($renderError)
                                        <span class="badge bg-danger">오류</span>
                                    @elseif($renderedContent)
                                        <span class="badge bg-success">정상</span>
                                    @else
                                        <span class="badge bg-warning">렌더링 불가</span>
                                    @endif
                                </td>
                            </tr>
                            @if($originalContent)
                            <tr>
                                <td class="text-muted">크기:</td>
                                <td>{{ strlen($originalContent) }} bytes</td>
                            </tr>
                            <tr>
                                <td class="text-muted">줄 수:</td>
                                <td>{{ count(explode("\n", $originalContent)) }} 줄</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- 작업 메뉴 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>
                            작업 메뉴
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.cms.blocks.edit', $filename ?? '') }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>
                                편집
                            </a>
                            <a href="{{ route('admin.cms.blocks.preview', $filename ?? '') }}"
                               class="btn btn-outline-info"
                               target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>
                                새 창에서 미리보기
                            </a>
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshPreview()">
                                <i class="fas fa-sync me-2"></i>
                                새로고침
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 샘플 데이터 -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-database me-2"></i>
                            샘플 데이터
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
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h3>블록을 찾을 수 없습니다</h3>
                <p class="text-muted mb-4">요청하신 블록 파일이 존재하지 않습니다.</p>
                <p class="text-muted">파일명: <strong>{{ $filename ?? 'unknown' }}.blade.php</strong></p>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 코드 복사 기능
function copyToClipboard(type) {
    let text = '';

    if (type === 'renderedContent') {
        text = @json($renderedContent ?? '');
    } else if (type === 'sourceContent') {
        text = @json($originalContent ?? '');
    }

    if (text) {
        navigator.clipboard.writeText(text).then(function() {
            // 성공 피드백
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

// 페이지 새로고침
function refreshPreview() {
    window.location.reload();
}
</script>
@endpush