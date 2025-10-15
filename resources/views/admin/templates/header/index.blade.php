@extends('jiny-site::layouts.admin.sidebar')

@section('title', '헤더 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">헤더 관리</h1>
                    <p class="mb-0 text-muted">사이트 템플릿 헤더를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.header.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 헤더 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.header.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i> 새 헤더 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">총 템플릿</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_templates'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-layout-navbar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">브랜드 설정</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($stats['has_brand_name'])
                                    <span class="text-success">설정됨</span>
                                @else
                                    <span class="text-warning">미설정</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-badge-tm fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">주 메뉴</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['primary_nav_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">보조 메뉴</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['secondary_nav_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-menu-button-wide fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">헤더 목록</h5>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($headers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>헤더 키</th>
                                        <th>이름</th>
                                        <th>설명</th>
                                        <th>네비바</th>
                                        <th>로고</th>
                                        <th>검색</th>
                                        <th width="150">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($headers as $header)
                                        <tr>
                                            <td>{{ $header['id'] }}</td>
                                            <td>
                                                <code class="text-primary">{{ $header['header_key'] }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $header['name'] }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($header['description'] ?? '', 50) }}</small>
                                            </td>
                                            <td>
                                                @if($header['navbar'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($header['logo'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($header['search'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cms.templates.header.show', $header['id']) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.header.edit', $header['id']) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $header['id'] }})" title="삭제">
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
                            <small class="text-muted">총 {{ count($headers) }}개의 헤더</small>
                        </div>
                    @else
                        <div class="text-center py-5 m-3">
                            <i class="bi bi-layout-navbar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">헤더가 없습니다</h5>
                            <p class="text-muted">첫 번째 헤더를 생성해보세요</p>
                            <a href="{{ route('admin.cms.templates.header.create') }}" class="btn btn-primary">
                                헤더 생성
                            </a>
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
                <p>정말로 이 헤더를 삭제하시겠습니까?</p>
                <p><strong>헤더 키:</strong> <span id="delete-header-key"></span></p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>주의:</strong> 이 작업은 되돌릴 수 없습니다. 이 헤더를 사용하는 템플릿이 있다면 오류가 발생할 수 있습니다.
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
function confirmDelete(headerId) {
    // 해당 행에서 헤더 키 가져오기 - 더 안전한 방법
    const buttons = document.querySelectorAll('.btn-outline-danger');
    let headerKey = '';

    buttons.forEach(btn => {
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(headerId)) {
            const row = btn.closest('tr');
            headerKey = row.querySelector('code').textContent;
        }
    });

    document.getElementById('delete-header-key').textContent = headerKey;
    document.getElementById('delete-form').action = `/admin/cms/templates/header/${headerId}`;

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