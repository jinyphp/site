@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'Edit Layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Edit Layout: <code>{{ $layout['layout_key'] }}</code></h5>
                    <div>
                        <a href="{{ route('admin.cms.templates.layout.show', $layout['id']) }}" class="btn btn-outline-info">
                            <i class="bi bi-eye"></i> 보기
                        </a>
                        <a href="{{ route('admin.cms.templates.layout.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> 목록으로
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.layout.update', $layout['id']) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="layout_key" class="form-label">Layout Key <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('layout_key') is-invalid @enderror"
                                           id="layout_key" name="layout_key" value="{{ old('layout_key', $layout['layout_key'] ?? '') }}"
                                           placeholder="e.g., jiny-site::layouts.custom" required>
                                    <div class="form-text">
                                        Use a unique key format like 'jiny-site::layouts.custom-name'
                                    </div>
                                    @error('layout_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Layout Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $layout['name'] ?? '') }}"
                                           placeholder="e.g., Custom Layout" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3"
                                      placeholder="Brief description of the layout purpose">{{ old('description', $layout['description'] ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="header" class="form-label">Header Component</label>
                                    <input type="text" class="form-control @error('header') is-invalid @enderror"
                                           id="header" name="header" value="{{ old('header', $layout['header'] ?? '') }}"
                                           placeholder="e.g., jiny-site::components.header.custom">
                                    <div class="form-text">
                                        Blade component path for header
                                    </div>
                                    @error('header')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="footer" class="form-label">Footer Component</label>
                                    <input type="text" class="form-control @error('footer') is-invalid @enderror"
                                           id="footer" name="footer" value="{{ old('footer', $layout['footer'] ?? '') }}"
                                           placeholder="e.g., jiny-site::components.footer.custom">
                                    <div class="form-text">
                                        Blade component path for footer
                                    </div>
                                    @error('footer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sidebar" class="form-label">Sidebar Component</label>
                                    <input type="text" class="form-control @error('sidebar') is-invalid @enderror"
                                           id="sidebar" name="sidebar" value="{{ old('sidebar', $layout['sidebar'] ?? '') }}"
                                           placeholder="e.g., jiny-site::components.sidebar.custom">
                                    <div class="form-text">
                                        Blade component path for sidebar (optional)
                                    </div>
                                    @error('sidebar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Current Layout Configuration:</strong>
                            <pre class="mt-2 mb-0"><code>{{ json_encode($layout, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.layout.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Layout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');

    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();

        if (!name) {
            e.preventDefault();
            alert('Layout name is required');
            nameInput.focus();
            return;
        }
    });

    // Auto-save functionality (optional)
    let autoSaveTimeout;
    const formInputs = form.querySelectorAll('input[type="text"], textarea');

    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Show auto-save indicator
                showAutoSaveIndicator();
            }, 2000);
        });
    });

    function showAutoSaveIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'alert alert-success position-fixed';
        indicator.style.cssText = 'top: 20px; right: 20px; z-index: 9999; opacity: 0.9; min-width: 200px;';
        indicator.innerHTML = '<i class="fas fa-check"></i> Changes detected (remember to save)';

        document.body.appendChild(indicator);

        setTimeout(() => {
            indicator.remove();
        }, 3000);
    }
});
</script>
@endpush

@push('styles')
<style>
.form-label {
    font-weight: 600;
    color: #495057;
}

.form-text {
    font-size: 0.875em;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}

.alert-info pre {
    background-color: rgba(23, 162, 184, 0.1);
    border: 1px solid rgba(23, 162, 184, 0.2);
    border-radius: 0.25rem;
    padding: 0.75rem;
    font-size: 0.875em;
}

.card-title {
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.invalid-feedback {
    font-size: 0.875em;
}

input[readonly] {
    background-color: #f8f9fa;
    opacity: 1;
}
</style>
@endpush