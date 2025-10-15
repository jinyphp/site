@extends('jiny-site::layouts.admin.sidebar')

@section('title', '사이드바 상세')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">사이드바 상세: <code>{{ $sidebar['sidebar_key'] }}</code></h5>
                    <div>
                        <a href="{{ route('admin.cms.templates.sidebar.edit', $sidebar['id']) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> 수정
                        </a>
                        <a href="{{ route('admin.cms.templates.sidebar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> 목록으로
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted mb-3">기본 정보</h6>

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" style="width: 150px;">사이드바 키:</td>
                                            <td><code class="fs-6">{{ $sidebar['sidebar_key'] }}</code></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">이름:</td>
                                            <td>{{ $sidebar['name'] ?? '이름 없음' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">설명:</td>
                                            <td>{{ $sidebar['description'] ?? '설명 없음' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">템플릿 경로:</td>
                                            <td>
                                                @if(!empty($sidebar['template']))
                                                    <code>{{ $sidebar['template'] }}</code>
                                                @else
                                                    <span class="text-muted">설정되지 않음</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="text-muted mb-3 mt-4">사이드바 옵션</h6>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-arrows-alt-h"></i> 위치</h6>
                                        </div>
                                        <div class="card-body py-3 text-center">
                                            @if($sidebar['position'] === 'left')
                                                <span class="badge bg-primary fs-6">왼쪽</span>
                                            @else
                                                <span class="badge bg-info fs-6">오른쪽</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-secondary">
                                        <div class="card-header bg-secondary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-compress"></i> 접을 수 있음</h6>
                                        </div>
                                        <div class="card-body py-3 text-center">
                                            @if(!empty($sidebar['collapsible']))
                                                <span class="badge bg-success fs-6">Yes</span>
                                            @else
                                                <span class="badge bg-secondary fs-6">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-thumbtack"></i> 고정</h6>
                                        </div>
                                        <div class="card-body py-3 text-center">
                                            @if(!empty($sidebar['fixed']))
                                                <span class="badge bg-success fs-6">Yes</span>
                                            @else
                                                <span class="badge bg-secondary fs-6">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h6 class="text-muted mb-3">원본 설정</h6>

                            <div class="card bg-light">
                                <div class="card-header py-2">
                                    <h6 class="mb-0">JSON 설정</h6>
                                </div>
                                <div class="card-body">
                                    <pre><code class="language-json">{{ json_encode($sidebar, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            </div>

                            <div class="card bg-light mt-3">
                                <div class="card-header py-2">
                                    <h6 class="mb-0">PHP 배열</h6>
                                </div>
                                <div class="card-body">
                                    <pre><code class="language-php">{{ json_encode($sidebar, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                </div>
                            </div>

                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning py-2">
                                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> 작업</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.cms.templates.sidebar.edit', $sidebar['id']) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> 사이드바 수정
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="confirmDelete({{ $sidebar['id'] }})">
                                            <i class="bi bi-trash"></i> 사이드바 삭제
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                onclick="copyToClipboard('{{ $sidebar['sidebar_key'] }}')">
                                            <i class="bi bi-copy"></i> 키 복사
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">사용 예제</h6>

                            <div class="alert alert-info">
                                <h6><i class="fas fa-code"></i> Blade 템플릿에서 사용</h6>
                                <p class="mb-2">Blade 템플릿에서 이 사이드바를 다음과 같이 사용할 수 있습니다:</p>
                                <pre><code class="language-blade">@<!-- -->component('{{ $sidebar['sidebar_key'] }}')
@<!-- -->endcomponent</code></pre>
                                <p class="mb-2 mt-3">또는 짧은 문법으로:</p>
                                <pre><code class="language-blade">&lt;x-dynamic-component :component="'{{ $sidebar['sidebar_key'] }}'" /&gt;</code></pre>
                            </div>

                            <div class="alert alert-secondary">
                                <h6><i class="fas fa-cog"></i> 설정 파일 접근</h6>
                                <p class="mb-2">프로그래밍 방식으로 사이드바 설정에 접근:</p>
                                <pre><code class="language-php">// JSON 파일에서 모든 사이드바 가져오기
$sidebars = json_decode(file_get_contents(base_path('vendor/jiny/site/config/sidebars.json')), true);
// 키로 사이드바 찾기
$sidebar = collect($sidebars)->firstWhere('sidebar_key', '{{ addslashes($sidebar['sidebar_key']) }}');</code></pre>
                            </div>

                            @if(!empty($sidebar['template']))
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-info-circle"></i> 템플릿 의존성</h6>
                                <p class="mb-2">이 사이드바는 다음 템플릿을 사용합니다:</p>
                                <ul class="mb-0">
                                    <li><strong>템플릿:</strong> <code>{{ $sidebar['template'] }}</code></li>
                                </ul>
                                <p class="mt-2 mb-0"><small>해당 컴포넌트가 views 디렉토리에 존재하는지 확인하세요.</small></p>
                            </div>
                            @endif

                            <div class="alert alert-success">
                                <h6><i class="fas fa-lightbulb"></i> 레이아웃에서 사용</h6>
                                <p class="mb-2">레이아웃 설정에서 이 사이드바를 참조할 수 있습니다:</p>
                                <pre><code class="language-json">{
  "layout_key": "jiny-site::layouts.custom",
  "sidebar": "{{ $sidebar['sidebar_key'] }}",
  "position": "{{ $sidebar['position'] }}"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 사이드바를 삭제하시겠습니까?</p>
                <p><strong>사이드바 키:</strong> <span id="delete-sidebar-key"></span></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>경고:</strong> 이 작업은 되돌릴 수 없습니다. 이 사이드바를 사용하는 레이아웃이 손상될 수 있습니다.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="delete-form" method="POST" style="display: inline;">
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
function confirmDelete(sidebarId) {
    // 사이드바 키 표시
    const sidebarKey = '{{ $sidebar['sidebar_key'] }}';
    document.getElementById('delete-sidebar-key').textContent = sidebarKey;
    document.getElementById('delete-form').action = `/admin/cms/templates/sidebar/${sidebarId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.9; min-width: 200px;';
        alert.innerHTML = '<i class="fas fa-check"></i> 사이드바 키가 클립보드에 복사되었습니다';

        document.body.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 3000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('클립보드 복사에 실패했습니다');
    });
}

// Syntax highlighting (if Prism.js is available)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Prism !== 'undefined') {
        Prism.highlightAll();
    }
});
</script>
@endpush

@push('styles')
<style>
.card-title {
    color: #495057;
}

.table-borderless td {
    border: none;
    padding: 0.5rem 0;
}

.fw-bold {
    font-weight: 600 !important;
}

pre {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 0.25rem;
    padding: 0.75rem;
    font-size: 0.875em;
    margin-bottom: 0;
    overflow-x: auto;
}

.card.bg-light {
    background-color: #f8f9fa !important;
}

.card.bg-light .card-header {
    background-color: #e9ecef !important;
    border-bottom: 1px solid #dee2e6;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}

.alert-secondary {
    border-left: 4px solid #6c757d;
}

.alert-warning {
    border-left: 4px solid #ffc107;
}

.alert-success {
    border-left: 4px solid #28a745;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

code.language-json,
code.language-php,
code.language-blade {
    font-size: 0.875em;
}

.border-primary {
    border-color: #0d6efd !important;
}

.border-secondary {
    border-color: #6c757d !important;
}

.border-info {
    border-color: #0dcaf0 !important;
}

.text-primary {
    color: #0d6efd !important;
}

.text-secondary {
    color: #6c757d !important;
}

.text-info {
    color: #0dcaf0 !important;
}
</style>
@endpush
