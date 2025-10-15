@extends('jiny-admin::layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="{{ $supportType->icon }} me-2" style="color: {{ $supportType->color }};"></i>
                {{ $supportType->name }}
            </h1>
            <p class="text-muted">지원 요청 유형 상세 정보</p>
        </div>
        <div>
            <a href="{{ route('admin.cms.support.types.index') }}" class="btn btn-secondary me-2">
                <i class="fa fa-arrow-left me-1"></i> 목록으로
            </a>
            <a href="{{ route('admin.cms.support.types.edit', $supportType->id) }}" class="btn btn-primary">
                <i class="fa fa-edit me-1"></i> 수정
            </a>
        </div>
    </div>

    {{-- Status Alert --}}
    @if(!$supportType->enable)
        <div class="alert alert-warning mb-4">
            <i class="fa fa-exclamation-triangle me-2"></i>
            이 지원 요청 유형은 현재 비활성화 상태입니다. 고객이 선택할 수 없습니다.
        </div>
    @endif

    <div class="row">
        {{-- Main Information --}}
        <div class="col-lg-8">
            {{-- Basic Information --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">기본 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">유형명</label>
                                <div class="fw-bold">{{ $supportType->name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">코드</label>
                                <div>
                                    <code>{{ $supportType->code }}</code>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">색상</label>
                                <div>
                                    <span class="badge px-3 py-2" style="background-color: {{ $supportType->color }};">
                                        {{ $supportType->color }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">아이콘</label>
                                <div>
                                    <i class="{{ $supportType->icon }} fa-2x me-2" style="color: {{ $supportType->color }};"></i>
                                    <code>{{ $supportType->icon }}</code>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">정렬 순서</label>
                                <div class="fw-bold">{{ $supportType->sort_order }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">상태</label>
                                <div>
                                    @if($supportType->enable)
                                        <span class="badge bg-success">활성</span>
                                    @else
                                        <span class="badge bg-secondary">비활성</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($supportType->description)
                        <div class="mb-3">
                            <label class="form-label text-muted">설명</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $supportType->description }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Support Configuration --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">지원 설정</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">기본 우선순위</label>
                                <div>
                                    @php
                                        $priorityColors = [
                                            'low' => 'secondary',
                                            'normal' => 'primary',
                                            'high' => 'warning',
                                            'urgent' => 'danger'
                                        ];
                                        $priorityTexts = [
                                            'low' => '낮음',
                                            'normal' => '보통',
                                            'high' => '높음',
                                            'urgent' => '긴급'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityColors[$supportType->default_priority] ?? 'primary' }}">
                                        {{ $priorityTexts[$supportType->default_priority] ?? $supportType->default_priority }}
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">예상 해결 시간</label>
                                <div class="fw-bold">{{ $supportType->expected_resolution_hours }}시간</div>
                                <small class="text-muted">
                                    (약 {{ number_format($supportType->expected_resolution_hours / 24, 1) }}일)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">기본 담당자</label>
                                <div>
                                    @if($supportType->default_assignee_id && $supportType->defaultAssignee)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                <img src="{{ $supportType->defaultAssignee->avatar ?? '/images/default-avatar.png' }}"
                                                     alt="{{ $supportType->defaultAssignee->name }}"
                                                     class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $supportType->defaultAssignee->name }}</div>
                                                <small class="text-muted">{{ $supportType->defaultAssignee->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">지정되지 않음</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($supportType->required_fields && count($supportType->required_fields) > 0)
                        <div class="mb-3">
                            <label class="form-label text-muted">필수 입력 필드</label>
                            <div>
                                @php
                                    $fieldLabels = [
                                        'phone' => '전화번호',
                                        'company' => '회사명',
                                        'department' => '부서',
                                        'urgency' => '긴급도',
                                        'attachment' => '첨부파일',
                                        'environment' => '사용 환경'
                                    ];
                                @endphp
                                @foreach($supportType->required_fields as $field)
                                    <span class="badge bg-light text-dark me-1">
                                        {{ $fieldLabels[$field] ?? $field }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($supportType->customer_instructions)
                        <div class="mb-3">
                            <label class="form-label text-muted">고객 안내 메시지</label>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($supportType->customer_instructions)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Usage Statistics --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">사용 통계</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshStats()">
                        <i class="fa fa-refresh me-1"></i> 새로고침
                    </button>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-6">
                            <div class="border rounded p-3 mb-3">
                                <div class="h4 mb-1 text-primary">{{ number_format($statistics['total_requests'] ?? $supportType->total_requests) }}</div>
                                <small class="text-muted">총 요청</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border rounded p-3 mb-3">
                                <div class="h4 mb-1 text-warning">{{ number_format($statistics['pending_requests'] ?? $supportType->pending_requests) }}</div>
                                <small class="text-muted">대기 중</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border rounded p-3 mb-3">
                                <div class="h4 mb-1 text-info">{{ number_format($statistics['in_progress_requests'] ?? $supportType->in_progress_requests) }}</div>
                                <small class="text-muted">진행 중</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="border rounded p-3 mb-3">
                                <div class="h4 mb-1 text-success">{{ number_format($statistics['resolved_requests'] ?? $supportType->resolved_requests) }}</div>
                                <small class="text-muted">해결됨</small>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-secondary">{{ number_format($statistics['closed_requests'] ?? $supportType->closed_requests) }}</div>
                                <small class="text-muted">종료됨</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-info">
                                    @if(($statistics['total_requests'] ?? $supportType->total_requests) > 0)
                                        {{ number_format($avgResolutionTime ?? $supportType->avg_resolution_hours, 1) }}h
                                    @else
                                        -
                                    @endif
                                </div>
                                <small class="text-muted">평균 해결시간</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-success">
                                    @if(($statistics['total_requests'] ?? $supportType->total_requests) > 0)
                                        {{ number_format($resolutionRate ?? (($supportType->resolved_requests / $supportType->total_requests) * 100), 1) }}%
                                    @else
                                        -
                                    @endif
                                </div>
                                <small class="text-muted">해결률</small>
                            </div>
                        </div>
                    </div>

                    @if(isset($supportType->last_stats_updated_at) && $supportType->last_stats_updated_at)
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                마지막 업데이트: {{ $supportType->last_stats_updated_at->format('Y-m-d H:i:s') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Requests --}}
            @if($recentRequests && $recentRequests->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">최근 요청</h5>
                        <a href="{{ route('admin.cms.support.requests.index', ['type' => $supportType->code]) }}" class="btn btn-sm btn-outline-primary">
                            전체 보기
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>제목</th>
                                        <th>요청자</th>
                                        <th>우선순위</th>
                                        <th>상태</th>
                                        <th>등록일</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRequests as $request)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $request->title }}</div>
                                                @if($request->urgency)
                                                    <small class="text-muted">긴급도: {{ $request->urgency }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $request->name }}</div>
                                                <small class="text-muted">{{ $request->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $priorityColors[$request->priority] ?? 'primary' }}">
                                                    {{ $priorityTexts[$request->priority] ?? $request->priority }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'in_progress' => 'info',
                                                        'resolved' => 'success',
                                                        'closed' => 'secondary'
                                                    ];
                                                    $statusTexts = [
                                                        'pending' => '대기',
                                                        'in_progress' => '진행중',
                                                        'resolved' => '해결',
                                                        'closed' => '종료'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$request->status] ?? 'secondary' }}">
                                                    {{ $statusTexts[$request->status] ?? $request->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>{{ $request->created_at->format('Y-m-d') }}</div>
                                                <small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.cms.support.requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary">
                                                    보기
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Quick Actions --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">빠른 작업</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.support.types.edit', $supportType->id) }}" class="btn btn-primary">
                            <i class="fa fa-edit me-1"></i> 수정
                        </a>

                        @if($supportType->enable)
                            <form action="{{ route('admin.cms.support.types.bulk-action') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="disable">
                                <input type="hidden" name="selected_ids" value="{{ $supportType->id }}">
                                <button type="submit" class="btn btn-outline-warning w-100" onclick="return confirm('이 유형을 비활성화하시겠습니까?')">
                                    <i class="fa fa-pause me-1"></i> 비활성화
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.cms.support.types.bulk-action') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="enable">
                                <input type="hidden" name="selected_ids" value="{{ $supportType->id }}">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fa fa-play me-1"></i> 활성화
                                </button>
                            </form>
                        @endif

                        @if($supportType->total_requests == 0)
                            <form action="{{ route('admin.cms.support.types.destroy', $supportType->id) }}" method="POST" onsubmit="return confirm('이 지원 요청 유형을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fa fa-trash me-1"></i> 삭제
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- System Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">시스템 정보</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">생성일</label>
                        <div>{{ $supportType->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">최종 수정</label>
                        <div>{{ $supportType->updated_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                    @if($supportType->last_stats_updated_at)
                        <div class="mb-3">
                            <label class="form-label text-muted">통계 업데이트</label>
                            <div>{{ $supportType->last_stats_updated_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label text-muted">ID</label>
                        <div><code>{{ $supportType->id }}</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshStats() {
    const btn = event.target.closest('button');
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> 새로고침 중...';
    btn.disabled = true;

    fetch(`{{ route('admin.cms.support.types.show', $supportType->id) }}?refresh_stats=1`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('통계 새로고침에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('통계 새로고침 중 오류가 발생했습니다.');
    })
    .finally(() => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}
</script>
@endsection