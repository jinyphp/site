@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '회사 연혁 관리')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- 페이지 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">회사 연혁 관리</h1>
                    <p class="text-muted">회사의 주요 연혁을 관리합니다.</p>
                </div>
                <a href="{{ route('admin.cms.about.history.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>새 연혁 추가
                </a>
            </div>

            <!-- 검색 및 필터 -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.cms.about.history.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">검색</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request('search') }}" placeholder="제목 또는 내용 검색">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">상태</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">전체</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>활성화</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>비활성화</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-primary">검색</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <a href="{{ route('admin.cms.about.history.index') }}" class="btn btn-outline-secondary">초기화</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 연혁 목록 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">연혁 목록 ({{ $histories->total() }}건)</h5>
                </div>
                <div class="card-body p-0">
                    @if($histories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 100px;">번호</th>
                                        <th style="width: 90px;">상태</th>
                                        <th style="width: 100px;">날짜</th>
                                        <th style="min-width: 300px;">제목</th>
                                        <th style="width: 100px;">순서</th>
                                        <th style="width: 100px;">등록일</th>
                                        <th style="width: 100px;">관리</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($histories as $history)
                                    <tr>
                                        <td>{{ $history->id }}</td>
                                        <td>
                                            <button type="button"
                                                    class="btn btn-sm toggle-status {{ $history->enable ? 'btn-success' : 'btn-secondary' }}"
                                                    data-id="{{ $history->id }}"
                                                    data-status="{{ $history->enable ? 1 : 0 }}"
                                                    style="width: 70px;">
                                                {{ $history->enable ? '활성' : '비활성' }}
                                            </button>
                                        </td>
                                        <td>{{ date('Y.m.d', strtotime($history->event_date)) }}</td>
                                        <td style="max-width: 300px;">
                                            <div>
                                                <strong class="d-block text-truncate">{{ $history->title }}</strong>
                                                @if($history->subtitle)
                                                <div class="text-muted small text-truncate">{{ Str::limit($history->subtitle, 50) }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $history->sort_order }}</td>
                                        <td>{{ date('Y.m.d', strtotime($history->created_at)) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.cms.about.history.show', $history->id) }}"
                                                   class="btn btn-outline-info" title="보기">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.cms.about.history.edit', $history->id) }}"
                                                   class="btn btn-outline-primary" title="수정">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-outline-danger delete-btn"
                                                        data-id="{{ $history->id }}"
                                                        data-title="{{ $history->title }}"
                                                        title="삭제">
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
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-3">등록된 연혁이 없습니다.</p>
                            <a href="{{ route('admin.cms.about.history.create') }}" class="btn btn-primary">
                                첫 번째 연혁 추가하기
                            </a>
                        </div>
                    @endif
                </div>
                @if($histories->hasPages())
                <div class="card-footer">
                    {{ $histories->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">연혁 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>정말로 이 연혁을 삭제하시겠습니까?</p>
                <p class="text-danger"><strong id="deleteTitle"></strong></p>
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

    // 상태 토글
    document.querySelectorAll('.toggle-status').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);

            // FormData 사용으로 변경
            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'POST');

            fetch(`/admin/cms/about/history/${id}/toggle`, {
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

                    // 성공 메시지
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
            const title = this.dataset.title;

            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('deleteForm').action = `/admin/cms/about/history/${id}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
});
</script>
@endpush
