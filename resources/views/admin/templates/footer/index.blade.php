@extends('jiny-site::layouts.admin.sidebar')

@section('title', '푸터 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">푸터 관리</h1>
                    <p class="mb-0 text-muted">사이트 템플릿 푸터를 관리합니다</p>
                </div>
                <div>
                    <a href="{{ route('admin.cms.templates.footer.config') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-gear me-1"></i> 푸터 설정
                    </a>
                    <a href="{{ route('admin.cms.templates.footer.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i> 새 푸터 추가
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
                            <i class="bi bi-layout-text-window-reverse fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">소셜 링크</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['social_links_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-share fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">메뉴 섹션</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['menu_sections_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-list-ul fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">회사 정보</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($stats['has_company_info'])
                                    <span class="text-success">설정됨</span>
                                @else
                                    <span class="text-warning">미설정</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-building fa-2x text-gray-300"></i>
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
                    <h5 class="card-title mb-0">푸터 목록</h5>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(count($footers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>푸터 키</th>
                                        <th>이름</th>
                                        <th>설명</th>
                                        <th>저작권</th>
                                        <th>링크</th>
                                        <th>소셜</th>
                                        <th width="150">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($footers as $footer)
                                        <tr>
                                            <td>{{ $footer['id'] }}</td>
                                            <td>
                                                <code class="text-primary">{{ $footer['footer_key'] }}</code>
                                            </td>
                                            <td>
                                                <strong>{{ $footer['name'] }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($footer['description'] ?? '', 50) }}</small>
                                            </td>
                                            <td>
                                                @if($footer['copyright'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($footer['links'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($footer['social'])
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.cms.templates.footer.show', $footer['id']) }}"
                                                       class="btn btn-outline-info btn-sm" title="보기">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cms.templates.footer.edit', $footer['id']) }}"
                                                       class="btn btn-outline-primary btn-sm" title="수정">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="confirmDelete({{ $footer['id'] }})" title="삭제">
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
                            <small class="text-muted">총 {{ count($footers) }}개의 푸터</small>
                        </div>
                    @else
                        <div class="text-center py-5 m-3">
                            <i class="bi bi-layout-text-window-reverse fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">푸터가 없습니다</h5>
                            <p class="text-muted">첫 번째 푸터를 생성해보세요</p>
                            <a href="{{ route('admin.cms.templates.footer.create') }}" class="btn btn-primary">
                                푸터 생성
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
                <p>정말로 이 푸터를 삭제하시겠습니까?</p>
                <p><strong>푸터 키:</strong> <span id="delete-footer-key"></span></p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>주의:</strong> 이 작업은 되돌릴 수 없습니다. 이 푸터를 사용하는 템플릿이 있다면 오류가 발생할 수 있습니다.
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
function confirmDelete(footerId) {
    // 해당 행에서 푸터 키 가져오기 - 더 안전한 방법
    const buttons = document.querySelectorAll('.btn-outline-danger');
    let footerKey = '';

    buttons.forEach(btn => {
        if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(footerId)) {
            const row = btn.closest('tr');
            footerKey = row.querySelector('code').textContent;
        }
    });

    document.getElementById('delete-footer-key').textContent = footerKey;
    document.getElementById('delete-form').action = `/admin/cms/templates/footer/${footerId}`;

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
