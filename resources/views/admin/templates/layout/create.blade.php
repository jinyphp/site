@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'Create Layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Create New Layout</h5>
                    <a href="{{ route('admin.cms.templates.layout.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.templates.layout.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="layout_key" class="form-label">Layout Key <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('layout_key') is-invalid @enderror"
                                           id="layout_key" name="layout_key" value="{{ old('layout_key') }}"
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
                                           id="name" name="name" value="{{ old('name') }}"
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
                                      placeholder="Brief description of the layout purpose">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="header" class="form-label">Header Component</label>
                                    <input type="text" class="form-control @error('header') is-invalid @enderror"
                                           id="header" name="header" value="{{ old('header') }}"
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
                                           id="footer" name="footer" value="{{ old('footer') }}"
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
                                           id="sidebar" name="sidebar" value="{{ old('sidebar') }}"
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
                            <strong>Tips:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Layout key should follow the pattern: <code>package::layouts.name</code></li>
                                <li>Component paths should reference existing Blade components</li>
                                <li>Leave component fields empty if not needed for this layout</li>
                                <li>All layouts can be managed from the configuration file or this interface</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.templates.layout.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Layout
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
    // Auto-generate key from name
    const nameInput = document.getElementById('name');
    const keyInput = document.getElementById('key');

    nameInput.addEventListener('input', function() {
        if (!keyInput.value || keyInput.dataset.autoGenerated === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            if (slug) {
                keyInput.value = `jiny-site::layouts.${slug}`;
                keyInput.dataset.autoGenerated = 'true';
            }
        }
    });

    keyInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const key = keyInput.value.trim();
        const name = nameInput.value.trim();

        if (!key) {
            e.preventDefault();
            alert('Layout key is required');
            keyInput.focus();
            return;
        }

        if (!name) {
            e.preventDefault();
            alert('Layout name is required');
            nameInput.focus();
            return;
        }

        // Validate key format
        if (!key.includes('::') || !key.includes('layouts.')) {
            e.preventDefault();
            alert('Layout key should follow the format: package::layouts.name');
            keyInput.focus();
            return;
        }
    });
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

.card-title {
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.invalid-feedback {
    font-size: 0.875em;
}
</style>
@endpush