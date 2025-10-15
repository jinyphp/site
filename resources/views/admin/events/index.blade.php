@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-calendar-event me-2"></i>
                                {{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.event.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 이벤트 추가
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 알림 메시지 -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fe fe-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fe fe-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- 통계 카드 -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">전체 이벤트</h4>
                            <h2 class="text-primary mb-0">{{ number_format($stats['total']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-circle">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">활성 이벤트</h4>
                            <h2 class="text-success mb-0">{{ number_format($stats['status_active']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-circle">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">계획중</h4>
                            <h2 class="text-warning mb-0">{{ number_format($stats['status_planned']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-circle">
                            <i class="fe fe-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">완료됨</h4>
                            <h2 class="text-info mb-0">{{ number_format($stats['status_completed']) }}</h2>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-circle">
                            <i class="fe fe-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 및 검색 -->
    <div class="card mb-4 mt-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.site.event.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="제목, 설명, 코드로 검색...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">상태</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">전체</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>활성</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>비활성</option>
                        <option value="planned" {{ request('status') === 'planned' ? 'selected' : '' }}>계획중</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>완료</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="enable" class="form-label">활성화</label>
                    <select class="form-select" id="enable" name="enable">
                        <option value="">전체</option>
                        <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>활성화</option>
                        <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비활성화</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 이벤트 목록 -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">이벤트 목록</h4>

                <!-- 대량 작업 -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            id="bulkActions" data-bs-toggle="dropdown" aria-expanded="false">
                        대량 작업
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="bulkActions">
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('enable')">
                            <i class="fe fe-check-circle me-2"></i>활성화
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="bulkAction('disable')">
                            <i class="fe fe-x-circle me-2"></i>비활성화
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                            <i class="fe fe-trash-2 me-2"></i>삭제
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>제목</th>
                            <th>상태</th>
                            <th>담당자</th>
                            <th width="200">참여신청</th>
                            <th>조회수/생성일</th>
                            <th>활성화</th>
                            <th width="120">작업</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $event->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($event->image)
                                    <img src="{{ $event->image }}" alt="Event Image" class="rounded me-2"
                                         style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                         style="width: 32px; height: 32px;">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h6 class="mb-0">
                                                <a href="{{ route('admin.site.event.show', $event->id) }}" class="text-decoration-none">
                                                    {{ $event->title ?: '제목 없음' }}
                                                </a>
                                            </h6>
                                            @if($event->code)
                                            <span class="badge bg-primary" style="font-size: 0.7rem;">
                                                {{ $event->code }}
                                            </span>
                                            @endif
                                        </div>
                                        @if($event->description)
                                        <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                $statusClasses = [
                                    'active' => 'bg-success',
                                    'inactive' => 'bg-secondary',
                                    'planned' => 'bg-warning',
                                    'completed' => 'bg-info'
                                ];
                                $statusTexts = [
                                    'active' => '활성',
                                    'inactive' => '비활성',
                                    'planned' => '계획중',
                                    'completed' => '완료'
                                ];
                                @endphp
                                <span class="badge {{ $statusClasses[$event->status] ?? 'bg-secondary' }}">
                                    {{ $statusTexts[$event->status] ?? $event->status }}
                                </span>
                            </td>
                            <td>{{ $event->manager ?: '-' }}</td>
                            <td>
                                @if($event->allow_participation)
                                    <div class="d-flex flex-column">
                                        <div class="d-flex gap-1 mb-1">
                                            <span class="badge bg-success text-white" style="font-size: 0.7rem;">
                                                <i class="bi bi-check-circle me-1"></i>신청가능
                                            </span>
                                            @if($event->approval_type === 'manual')
                                            <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">수동승인</span>
                                            @endif
                                        </div>

                                        <div class="text-muted small d-flex align-items-center gap-2">
                                            <span title="총 신청자">
                                                <i class="bi bi-people-fill text-primary"></i>
                                                {{ $event->total_participants }}
                                            </span>
                                            <span title="승인됨" class="text-success">
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ $event->approved_participants }}
                                            </span>
                                            @if($event->pending_participants > 0)
                                            <span title="대기중" class="text-warning">
                                                <i class="bi bi-clock-fill"></i>
                                                {{ $event->pending_participants }}
                                            </span>
                                            @endif
                                            @if($event->rejected_participants > 0)
                                            <span title="거부됨" class="text-danger">
                                                <i class="bi bi-x-circle-fill"></i>
                                                {{ $event->rejected_participants }}
                                            </span>
                                            @endif
                                        </div>

                                        @if($event->max_participants)
                                        <div class="progress mt-1" style="height: 4px;" title="참여율">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: {{ $event->getParticipationRateCached() ?? 0 }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            {{ $event->approved_participants }}/{{ $event->max_participants }}
                                            ({{ number_format($event->getParticipationRateCached() ?? 0, 1) }}%)
                                        </small>
                                        @endif
                                    </div>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-x-circle me-1"></i>신청불가
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-eye me-1"></i>{{ $event->formatted_view_count }}
                                    </span>
                                    @if($event->last_viewed_at)
                                    <small class="text-muted ms-2">
                                        최근: {{ $event->last_viewed_at->diffForHumans() }}
                                    </small>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>{{ $event->created_at ? $event->created_at->format('Y-m-d H:i') : '-' }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                           {{ $event->enable ? 'checked' : '' }}
                                           onchange="toggleEnable({{ $event->id }}, this)">
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.site.event.show', $event->id) }}"
                                       class="btn btn-outline-info" title="보기">
                                        <i class="fe fe-eye"></i>
                                    </a>
                                    @if($event->allow_participation)
                                    <a href="{{ route('admin.site.event.participants.index', $event->id) }}"
                                       class="btn btn-outline-warning" title="참여자 관리">
                                        <i class="bi bi-people"></i>
                                        @if($event->total_participants > 0)
                                        <span class="badge bg-danger rounded-pill ms-1" style="font-size: 0.6rem;">
                                            {{ $event->total_participants }}
                                        </span>
                                        @endif
                                    </a>
                                    @endif
                                    @if($event->enable && ($event->status === 'active' || $event->status === 'planned' || $event->status === 'completed'))
                                    <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                                       class="btn btn-outline-success" target="_blank" title="사이트에서 보기">
                                        <i class="fe fe-external-link"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.site.event.edit', $event->id) }}"
                                       class="btn btn-outline-primary" title="수정">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"
                                            onclick="deleteEvent({{ $event->id }}, '{{ $event->title }}')" title="삭제">
                                        <i class="fe fe-trash-2"></i>
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
                <i class="bi bi-calendar-event text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3">이벤트가 없습니다</h5>
                <p class="text-muted">새로운 이벤트를 추가해보세요.</p>
                <a href="{{ route('admin.site.event.create') }}" class="btn btn-primary">
                    <i class="fe fe-plus me-2"></i>이벤트 추가
                </a>
            </div>
            @endif
        </div>

    </div>

    <!-- 페이지네이션 섹션 -->
    @if($events->count() > 0)
    <div class="d-flex justify-content-between align-items-center mt-4">
        <small class="text-muted">
            {{ $events->firstItem() }}-{{ $events->lastItem() }} / {{ $events->total() }}개 표시
        </small>
        @if($events->hasPages())
            {{ $events->links() }}
        @else
            <small class="text-muted">페이지 1 / 1</small>
        @endif
    </div>
    @endif

    <!-- 성능 정보 섹션 -->
    <div class="mt-3 text-center">
        <small class="text-muted">
            <i class="bi bi-stopwatch me-1"></i>
            처리 시간: {{ number_format((microtime(true) - LARAVEL_START) * 1000000, 0) }}μs
            @if(defined('LARAVEL_START'))
            | 메모리: {{ number_format(memory_get_peak_usage(true) / 1024 / 1024, 2) }}MB
            @endif
        </small>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">이벤트 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>다음 이벤트를 삭제하시겠습니까?</p>
                <p class="fw-bold" id="deleteEventTitle"></p>
                <p class="text-danger small">이 작업은 되돌릴 수 없습니다.</p>
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
// 전체 선택/해제
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// 활성화 토글
function toggleEnable(id, checkbox) {
    fetch(`/admin/site/event/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시 (선택사항)
            console.log(data.message);
        } else {
            // 실패 시 체크박스 상태 되돌리기
            checkbox.checked = !checkbox.checked;
            alert(data.message || '상태 변경에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        checkbox.checked = !checkbox.checked;
        alert('상태 변경 중 오류가 발생했습니다.');
    });
}

// 이벤트 삭제
function deleteEvent(id, title) {
    document.getElementById('deleteEventTitle').textContent = title;
    document.getElementById('deleteForm').action = `/admin/site/event/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// 대량 작업
function bulkAction(action) {
    const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);

    if (selectedIds.length === 0) {
        alert('작업할 이벤트를 선택해주세요.');
        return;
    }

    if (action === 'delete' && !confirm(`선택한 ${selectedIds.length}개의 이벤트를 삭제하시겠습니까?`)) {
        return;
    }

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('action', action);
    selectedIds.forEach(id => formData.append('ids[]', id));

    fetch('/admin/site/event/bulk', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || '작업 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('작업 중 오류가 발생했습니다.');
    });
}
</script>
@endpush
