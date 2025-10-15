@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-eye me-2"></i>{{ $config['title'] }}
                            </h1>
                            <p class="page-header-subtitle">{{ $config['subtitle'] }}: {{ $event->title }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            @if($event->enable && ($event->status === 'active' || $event->status === 'planned' || $event->status === 'completed'))
                            <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                               class="btn btn-success" target="_blank">
                                <i class="fe fe-external-link me-2"></i>사이트에서 보기
                            </a>
                            @endif
                            <a href="{{ route('admin.site.event.edit', $event->id) }}" class="btn btn-primary">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.site.event.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
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

    <div class="row">
        <!-- 메인 콘텐츠 -->
        <div class="col-xl-8 col-lg-8">
            <!-- 기본 정보 카드 -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">이벤트 정보</h4>
                        <div class="d-flex align-items-center gap-2">
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
                            @if($event->enable)
                            <span class="badge bg-success">활성화됨</span>
                            @else
                            <span class="badge bg-secondary">비활성화됨</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($event->image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ $event->image }}"
                                 alt="{{ $event->title }}"
                                 class="img-fluid rounded"
                                 style="max-height: 200px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                        @else
                        <div class="col-md-12">
                        @endif
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="120" class="text-muted">제목</td>
                                        <td class="fw-semibold">{{ $event->title ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">코드</td>
                                        <td><code>{{ $event->code ?: '-' }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">담당자</td>
                                        <td>{{ $event->manager ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">조회수</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <i class="bi bi-eye me-1"></i>{{ $event->formatted_view_count }}
                                            </span>
                                            @if($event->last_viewed_at)
                                            <small class="text-muted ms-2">
                                                (최근: {{ $event->last_viewed_at->diffForHumans() }})
                                            </small>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">블레이드 파일</td>
                                        <td>
                                            @if($event->blade)
                                            <code>{{ $event->blade }}</code>
                                            @else
                                            <span class="text-muted">기본 템플릿 사용</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($event->description)
                    <div class="mt-3">
                        <h6>설명</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $event->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 시스템 정보 카드 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">시스템 정보</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td width="100" class="text-muted">ID</td>
                                        <td>{{ $event->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">생성일</td>
                                        <td>{{ $event->created_at ? $event->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">수정일</td>
                                        <td>{{ $event->updated_at ? $event->updated_at->format('Y-m-d H:i:s') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <!-- 추가 시스템 정보가 필요하면 여기에 추가 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 사이드바 -->
        <div class="col-xl-4 col-lg-4">
            <!-- 빠른 액션 카드 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-zap me-2"></i>빠른 액션
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($event->enable && ($event->status === 'active' || $event->status === 'planned' || $event->status === 'completed'))
                        <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($event) }}"
                           class="btn btn-success btn-sm" target="_blank">
                            <i class="fe fe-external-link me-1"></i>사이트에서 보기
                        </a>
                        @endif

                        <a href="{{ route('admin.site.event.edit', $event->id) }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-edit me-1"></i>이벤트 수정
                        </a>

                        <button type="button"
                                class="btn btn-outline-{{ $event->enable ? 'warning' : 'success' }} btn-sm"
                                onclick="toggleEnable({{ $event->id }})">
                            <i class="fe fe-{{ $event->enable ? 'pause' : 'play' }}-circle me-1"></i>
                            {{ $event->enable ? '비활성화' : '활성화' }}
                        </button>

                        <button type="button"
                                class="btn btn-outline-danger btn-sm"
                                onclick="deleteEvent({{ $event->id }}, '{{ $event->title }}')">
                            <i class="fe fe-trash-2 me-1"></i>이벤트 삭제
                        </button>
                    </div>
                </div>
            </div>

            <!-- 관련 정보 카드 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-info me-2"></i>상태 정보
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted mb-1">현재 상태</div>
                        <span class="badge {{ $statusClasses[$event->status] ?? 'bg-secondary' }} fs-6">
                            {{ $statusTexts[$event->status] ?? $event->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted mb-1">활성화 상태</div>
                        @if($event->enable)
                        <span class="badge bg-success fs-6">활성화됨</span>
                        @else
                        <span class="badge bg-secondary fs-6">비활성화됨</span>
                        @endif
                    </div>

                    @if($event->image)
                    <div class="mb-3">
                        <div class="small text-muted mb-1">이미지</div>
                        <div class="text-success small">
                            <i class="fe fe-check me-1"></i>업로드됨
                        </div>
                    </div>
                    @endif

                    @if($event->blade)
                    <div class="mb-3">
                        <div class="small text-muted mb-1">커스텀 템플릿</div>
                        <div class="text-info small">
                            <i class="fe fe-file-text me-1"></i>{{ $event->blade }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 통계 카드 (선택사항) -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-bar-chart-2 me-2"></i>이벤트 통계
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="small text-muted">생성된 지</div>
                        <div class="h5 mb-0">
                            {{ $event->created_at ? $event->created_at->diffForHumans() : '-' }}
                        </div>
                    </div>

                    @if($event->updated_at && $event->updated_at != $event->created_at)
                    <hr>
                    <div class="text-center">
                        <div class="small text-muted">최종 수정</div>
                        <div class="h6 mb-0">
                            {{ $event->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
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
// 활성화 토글
function toggleEnable(id) {
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
            location.reload();
        } else {
            alert(data.message || '상태 변경에 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('상태 변경 중 오류가 발생했습니다.');
    });
}

// 이벤트 삭제
function deleteEvent(id, title) {
    document.getElementById('deleteEventTitle').textContent = title;
    document.getElementById('deleteForm').action = `/admin/site/event/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
