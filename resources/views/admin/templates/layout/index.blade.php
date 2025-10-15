@extends('jiny-site::layouts.admin.sidebar')

@section('title', 'Layout Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">레이아웃 관리</h1>
                    <p class="mb-0 text-muted">사이트 템플릿 레이아웃을 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.layout.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> 새 레이아웃 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">레이아웃 목록</h5>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(empty($layouts))
                        <div class="text-center py-5 m-3">
                            <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">레이아웃이 없습니다</h5>
                            <p class="text-muted">첫 번째 레이아웃을 생성해보세요</p>
                            <a href="{{ route('admin.cms.templates.layout.create') }}" class="btn btn-primary">
                                레이아웃 생성
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="layouts-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>레이아웃 키</th>
                                        <th>이름</th>
                                        <th>설명</th>
                                        <th>구성요소</th>
                                        <th width="150">작업</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-layouts">
                                    @foreach($layouts as $index => $layout)
                                        @php
                                            $id = $index + 1; // 순차배열 인덱스를 1부터 시작하는 ID로 변환
                                        @endphp
                                        <tr data-layout-id="{{ $id }}">
                                            <td>
                                                <code class="text-primary">{{ $layout['layout_key'] }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $layout['name'] }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $layout['description'] ?? 'No description' }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @if(!empty($layout['header']))
                                                        <span class="badge bg-primary">헤더: {{ $layout['header'] }}</span>
                                                    @endif
                                                    @if(!empty($layout['footer']))
                                                        <span class="badge bg-secondary">푸터: {{ $layout['footer'] }}</span>
                                                    @endif
                                                    @if(!empty($layout['sidebar']))
                                                        <span class="badge bg-info">사이드바: {{ $layout['sidebar'] }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cms.templates.layout.show', $id) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.layout.edit', $id) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $id }})" title="삭제">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end align-items-center p-3 border-top bg-light">
                                <small class="text-muted">총 {{ count($layouts) }}개의 레이아웃</small>
                            </div>
                    @endif
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
                <p>정말로 이 레이아웃을 삭제하시겠습니까?</p>
                <p><strong>레이아웃 키:</strong> <span id="delete-layout-key"></span></p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>주의:</strong> 이 작업은 되돌릴 수 없습니다. 이 레이아웃을 사용하는 템플릿이 있다면 오류가 발생할 수 있습니다.
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
document.addEventListener('DOMContentLoaded', function() {

    // Sortable functionality for reordering
    @if(!empty($layouts))
    const tbody = document.getElementById('sortable-layouts');
    if (tbody && typeof Sortable !== 'undefined') {
        Sortable.create(tbody, {
            animation: 150,
            handle: 'tr',
            onEnd: function(evt) {
                const order = Array.from(tbody.children).map(tr => tr.dataset.layoutKey);

                fetch('{{ route("admin.cms.templates.layout.updateOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show';
                        alert.innerHTML = `
                            <i class="bi bi-check-circle me-1"></i>레이아웃 순서가 업데이트되었습니다.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.querySelector('.card-body').insertBefore(alert, document.querySelector('.table-responsive'));

                        setTimeout(() => alert.remove(), 3000);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
    @endif
});

function confirmDelete(layoutId) {
    // 해당 행에서 레이아웃 키 가져오기
    const row = document.querySelector(`tr[data-layout-id="${layoutId}"]`);
    const layoutKey = row.querySelector('code').textContent;

    document.getElementById('delete-layout-key').textContent = layoutKey;
    document.getElementById('delete-form').action = `/admin/cms/templates/layout/${layoutId}`;

    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.badge {
    font-size: 0.75em;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.sortable-ghost {
    opacity: 0.4;
}

.card-title {
    color: #495057;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush