@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'View Layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Layout Details: <code>{{ $layout['layout_key'] }}</code></h5>
                    <div>
                        <a href="{{ route('admin.cms.templates.layout.edit', $layout['id']) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i> 수정
                        </a>
                        <a href="{{ route('admin.cms.templates.layout.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> 목록으로
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-muted mb-3">Basic Information</h6>

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" style="width: 150px;">Layout Key:</td>
                                            <td><code class="fs-6">{{ $layout['layout_key'] }}</code></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Name:</td>
                                            <td>{{ $layout['name'] ?? 'Unnamed Layout' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Description:</td>
                                            <td>{{ $layout['description'] ?? 'No description provided' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="text-muted mb-3 mt-4">Components Configuration</h6>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-header"></i> Header</h6>
                                        </div>
                                        <div class="card-body py-3">
                                            @if(!empty($layout['header']))
                                                <code class="text-primary">{{ $layout['header'] }}</code>
                                            @else
                                                <span class="text-muted">Not configured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-secondary">
                                        <div class="card-header bg-secondary text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-th-large"></i> Footer</h6>
                                        </div>
                                        <div class="card-body py-3">
                                            @if(!empty($layout['footer']))
                                                <code class="text-secondary">{{ $layout['footer'] }}</code>
                                            @else
                                                <span class="text-muted">Not configured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white py-2">
                                            <h6 class="mb-0"><i class="fas fa-sidebar"></i> Sidebar</h6>
                                        </div>
                                        <div class="card-body py-3">
                                            @if(!empty($layout['sidebar']))
                                                <code class="text-info">{{ $layout['sidebar'] }}</code>
                                            @else
                                                <span class="text-muted">Not configured</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h6 class="text-muted mb-3">Raw Configuration</h6>

                            <div class="card bg-light">
                                <div class="card-header py-2">
                                    <h6 class="mb-0">JSON Configuration</h6>
                                </div>
                                <div class="card-body">
                                    <pre><code class="language-json">{{ json_encode($layout, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                            </div>

                            <div class="card bg-light mt-3">
                                <div class="card-header py-2">
                                    <h6 class="mb-0">PHP Array</h6>
                                </div>
                                <div class="card-body">
                                    <pre><code class="language-php">{{ json_encode($layout, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                                </div>
                            </div>

                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning py-2">
                                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.cms.templates.layout.edit', $layout['id']) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> 레이아웃 수정
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="confirmDelete({{ $layout['id'] }})">
                                            <i class="bi bi-trash"></i> 레이아웃 삭제
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                                onclick="copyToClipboard('{{ $layout['layout_key'] }}')">
                                            <i class="bi bi-copy"></i> 키 복사
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Usage Examples</h6>

                            <div class="alert alert-info">
                                <h6><i class="fas fa-code"></i> Blade Template Usage</h6>
                                <p class="mb-2">In your Blade templates, you can use this layout like:</p>
                                <pre><code class="language-blade">@<!-- -->extends('{{ $layout['layout_key'] }}')</code></pre>
                            </div>

                            <div class="alert alert-secondary">
                                <h6><i class="fas fa-cog"></i> Configuration Access</h6>
                                <p class="mb-2">Access this layout configuration programmatically:</p>
                                <pre><code class="language-php">// Get all layouts from JSON file
$layouts = json_decode(file_get_contents(base_path('vendor/jiny/site/config/layouts.json')), true);
// Find layout by key
$layout = collect($layouts)->firstWhere('layout_key', '{{ addslashes($layout['layout_key']) }}');</code></pre>
                            </div>

                            @if(!empty($layout['header']) || !empty($layout['footer']) || !empty($layout['sidebar']))
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-info-circle"></i> Component Dependencies</h6>
                                <p class="mb-2">This layout depends on the following components:</p>
                                <ul class="mb-0">
                                    @if(!empty($layout['header']))
                                        <li><strong>Header:</strong> <code>{{ $layout['header'] }}</code></li>
                                    @endif
                                    @if(!empty($layout['footer']))
                                        <li><strong>Footer:</strong> <code>{{ $layout['footer'] }}</code></li>
                                    @endif
                                    @if(!empty($layout['sidebar']))
                                        <li><strong>Sidebar:</strong> <code>{{ $layout['sidebar'] }}</code></li>
                                    @endif
                                </ul>
                                <p class="mt-2 mb-0"><small>Make sure these components exist in your views directory.</small></p>
                            </div>
                            @endif
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
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this layout?</p>
                <p><strong>Layout Key:</strong> <span id="delete-layout-key"></span></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> This action cannot be undone. Any templates using this layout may break.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(layoutId) {
    // 레이아웃 키 표시
    const layoutKey = '{{ $layout['layout_key'] }}';
    document.getElementById('delete-layout-key').textContent = layoutKey;
    document.getElementById('delete-form').action = `/admin/cms/templates/layout/${layoutId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.9; min-width: 200px;';
        alert.innerHTML = '<i class="fas fa-check"></i> Layout key copied to clipboard';

        document.body.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 3000);
    }, function(err) {
        console.error('Could not copy text: ', err);
        alert('Failed to copy to clipboard');
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