@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '팀원 관리')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid">
    <!-- 헤딩 영역 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.about.organization.index') }}">조직 관리</a></li>
                    <li class="breadcrumb-item active">{{ $organization->name }} 팀원</li>
                </ol>
            </nav>
            <h2 class="mb-1">
                <i class="bi bi-people me-2"></i>{{ $organization->name }} 팀원 관리
            </h2>
            <p class="text-muted mb-0">{{ $organization->name }}에 속한 팀원들을 관리합니다.</p>
        </div>
        <a href="{{ route('admin.cms.about.organization.members.create', $organization->id) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>새 팀원 추가
        </a>
    </div>

    <!-- 통계 카드 -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">전체 팀원</p>
                            <h3 class="mb-0 text-primary">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">활성 팀원</p>
                            <h3 class="mb-0 text-success">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-pause-circle text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small">비활성 팀원</p>
                            <h3 class="mb-0 text-warning">{{ $stats['inactive'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 검색 영역 -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label small text-muted">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $search }}" placeholder="이름, 이메일, 전화번호 검색...">
                </div>
                <div class="col-md-2">
                    <label for="position" class="form-label small text-muted">직책</label>
                    <select class="form-select" id="position" name="position">
                        <option value="">모든 직책</option>
                        @foreach($positionOptions as $option)
                            <option value="{{ $option }}" {{ $position == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label small text-muted">상태</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">모든 상태</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>활성</option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>비활성</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted">정렬</label>
                    <select class="form-select" name="sort_by">
                        <option value="sort_order" {{ $sortBy == 'sort_order' ? 'selected' : '' }}>정렬순서</option>
                        <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>이름</option>
                        <option value="position" {{ $sortBy == 'position' ? 'selected' : '' }}>직책</option>
                        <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>생성일</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">검색</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.cms.about.organization.members.index', $organization->id) }}" class="btn btn-outline-secondary w-100">초기화</a>
                </div>
            </form>
        </div>
    </div>

    <!-- 팀원 목록 -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">팀원 목록</h5>
                    <small class="text-muted">선택한 항목에 대해 일괄 작업을 수행할 수 있습니다.</small>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            일괄 작업 선택
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">선택 항목 활성화</a></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">선택 항목 비활성화</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">선택 항목 삭제</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="executeBulkAction">실행</button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($members->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th style="width: 80px;">사진</th>
                                <th>이름</th>
                                <th style="width: 150px;">직책</th>
                                <th style="width: 200px;">연락처</th>
                                <th style="width: 100px;">상태</th>
                                <th style="width: 80px;">순서</th>
                                <th style="width: 120px;">생성일</th>
                                <th style="width: 120px;">작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input row-check" type="checkbox" value="{{ $member->id }}">
                                    </div>
                                </td>
                                <td>
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong class="d-block">{{ $member->name }}</strong>
                                        @if($member->email)
                                            <small class="text-muted">{{ $member->email }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $member->position }}</span>
                                </td>
                                <td>
                                    @if($member->phone)
                                        <div class="small">
                                            <i class="bi bi-telephone me-1"></i>{{ $member->phone }}
                                        </div>
                                    @endif
                                    @if($member->email)
                                        <div class="small">
                                            <i class="bi bi-envelope me-1"></i>{{ $member->email }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm toggle-status {{ $member->is_active ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $member->id }}"
                                            data-status="{{ $member->is_active ? 1 : 0 }}"
                                            style="width: 70px;">
                                        {{ $member->is_active ? '활성' : '비활성' }}
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $member->sort_order }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $member->created_at->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.cms.about.organization.members.show', [$organization->id, $member->id]) }}"
                                           class="btn btn-outline-info btn-sm" title="보기">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cms.about.organization.members.edit', [$organization->id, $member->id]) }}"
                                           class="btn btn-outline-primary btn-sm" title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                                data-id="{{ $member->id }}"
                                                data-name="{{ $member->name }}" title="삭제">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people fs-1 text-muted"></i>
                    <p class="text-muted mt-3">등록된 팀원이 없습니다.</p>
                    <a href="{{ route('admin.cms.about.organization.members.create', $organization->id) }}" class="btn btn-primary">
                        첫 번째 팀원 추가하기
                    </a>
                </div>
            @endif
        </div>
        @if($members->hasPages())
        <div class="card-footer">
            {{ $members->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">팀원 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 팀원을 삭제하시겠습니까?</p>
                <p class="text-danger"><strong id="deleteName"></strong></p>
                <p class="text-muted small">삭제된 데이터는 복구할 수 없습니다.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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
    // CSRF 토큰 가져오기
    function getCSRFToken() {
        let token = document.querySelector('meta[name="csrf-token"]');
        if (!token) {
            token = document.querySelector('input[name="_token"]');
            return token ? token.value : '';
        }
        return token.content;
    }

    // 체크박스 전체 선택/해제
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-check');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.row-check:checked').length;
            const totalCount = rowCheckboxes.length;

            selectAllCheckbox.checked = checkedCount === totalCount;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        });
    });

    // 상태 토글
    document.querySelectorAll('.toggle-status').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'POST');

            fetch(`{{ route('admin.cms.about.organization.members.index', $organization->id) }}/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.dataset.status = data.status ? '1' : '0';
                    this.textContent = data.status ? '활성' : '비활성';
                    this.className = data.status ? 'btn btn-sm toggle-status btn-success' : 'btn btn-sm toggle-status btn-secondary';

                    showSuccessMessage(data.message || '상태가 변경되었습니다.');
                } else {
                    throw new Error(data.message || '상태 변경에 실패했습니다.');
                }
            })
            .catch(error => {
                console.error('Toggle Error:', error);
                showErrorMessage('상태 변경 중 오류가 발생했습니다: ' + error.message);
            });
        });
    });

    // 성공 메시지 표시
    function showSuccessMessage(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alert, container.firstChild);
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 3000);
        }
    }

    // 오류 메시지 표시
    function showErrorMessage(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alert, container.firstChild);
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }
    }

    // 삭제 버튼
    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;

            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = `{{ route('admin.cms.about.organization.members.index', $organization->id) }}/${id}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});

// 일괄 작업 함수
let selectedBulkAction = '';

function bulkAction(action) {
    selectedBulkAction = action;
}

document.getElementById('executeBulkAction').addEventListener('click', function() {
    if (!selectedBulkAction) {
        alert('작업을 선택해주세요.');
        return;
    }

    const checkedItems = document.querySelectorAll('.row-check:checked');

    if (checkedItems.length === 0) {
        alert('선택된 항목이 없습니다.');
        return;
    }

    let message = '';
    switch(selectedBulkAction) {
        case 'activate':
            message = '선택한 팀원들을 활성화하시겠습니까?';
            break;
        case 'deactivate':
            message = '선택한 팀원들을 비활성화하시겠습니까?';
            break;
        case 'delete':
            message = '선택한 팀원들을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.';
            break;
    }

    if (confirm(message)) {
        const ids = Array.from(checkedItems).map(item => item.value);

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('action', selectedBulkAction);
        ids.forEach(id => formData.append('ids[]', id));

        fetch(`{{ route('admin.cms.about.organization.members.bulkAction', $organization->id) }}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || '작업에 실패했습니다.');
            }
        })
        .catch(error => {
            console.error('Bulk Action Error:', error);
            showErrorMessage('일괄 작업 중 오류가 발생했습니다: ' + error.message);
        });
    }
});
</script>
@endpush