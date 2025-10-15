@extends('jiny-site::layouts.app')

@section('title', $event->title . ' - 이벤트')

@section('content')
<div class="container my-5">
    <!-- 브레드크럼 -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">홈</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('event.index') }}" class="text-decoration-none">이벤트</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ Str::limit($event->title, 30) }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- 메인 콘텐츠 -->
        <div class="col-lg-8">
            <!-- 이벤트 헤더 -->
            <div class="mb-4">
                @php
                $statusClasses = [
                    'active' => 'bg-success',
                    'inactive' => 'bg-secondary',
                    'planned' => 'bg-warning text-dark',
                    'completed' => 'bg-info'
                ];
                $statusTexts = [
                    'active' => '진행 중',
                    'inactive' => '중단',
                    'planned' => '예정',
                    'completed' => '완료'
                ];
                @endphp

                <div class="d-flex align-items-center mb-3">
                    <span class="badge {{ $statusClasses[$event->status] ?? 'bg-secondary' }} me-3">
                        {{ $statusTexts[$event->status] ?? $event->status }}
                    </span>

                    @if($event->manager)
                    <span class="text-muted">
                        <i class="bi bi-person me-1"></i>{{ $event->manager }}
                    </span>
                    @endif

                    <span class="text-muted ms-auto">
                        <i class="bi bi-calendar me-1"></i>
                        {{ $event->created_at->format('Y년 m월 d일') }}
                    </span>
                </div>

                <h1 class="display-5 fw-bold mb-3">{{ $event->title }}</h1>

                @if($event->code)
                <p class="text-muted">
                    <i class="bi bi-tag me-1"></i>
                    <code>{{ $event->code }}</code>
                </p>
                @endif
            </div>

            <!-- 이벤트 이미지 -->
            @if($event->image)
            <div class="mb-4">
                <img src="{{ $event->image }}"
                     alt="{{ $event->title }}"
                     class="img-fluid rounded shadow">
            </div>
            @endif

            <!-- 이벤트 내용 -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-file-text me-2"></i>이벤트 안내
                    </h5>

                    @if($event->description)
                    <div class="event-content">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                    @else
                    <p class="text-muted">이벤트 상세 내용이 준비 중입니다.</p>
                    @endif
                </div>
            </div>


            <!-- 참여 신청 버튼 -->
            @if($event->allow_participation)
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-person-plus me-2"></i>이벤트 참여하기
                        </h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge bg-success text-white">승인 {{ number_format($event->approved_participants) }}명</span>
                            <span class="badge bg-warning text-dark">대기 {{ number_format($event->pending_participants) }}명</span>
                            @if($event->max_participants)
                                <span class="badge bg-info text-white">{{ number_format($event->getParticipationRate(), 1) }}%</span>
                            @else
                                <span class="badge bg-primary text-white">총 {{ number_format($event->total_participants) }}명</span>
                            @endif
                        </div>
                    </div>

                    @if($event->participation_description)
                    <div class="mb-3">
                        <div class="text-muted">{{ $event->participation_description }}</div>
                    </div>
                    @endif

                    @php
                    $userEmail = auth()->user()->email ?? session('guest_email') ?? null;
                    $hasParticipated = $userEmail && $event->hasParticipated($userEmail);
                    $userParticipation = $hasParticipated ? $event->getParticipation($userEmail) : null;
                    @endphp

                    @if($hasParticipated)
                        <!-- 이미 참여 신청한 경우 -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <strong>참여 신청 완료</strong>
                                    <div class="small">
                                        신청일: {{ $userParticipation->applied_at->format('Y년 m월 d일 H:i') }}
                                        <span class="badge bg-{{ $userParticipation->status_class }} ms-2">{{ $userParticipation->status_text }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($userParticipation->isPending() || $userParticipation->isApproved())
                        <div class="d-flex gap-2">
                            <button type="button"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="cancelParticipation('{{ $event->id }}')">
                                <i class="bi bi-x-circle me-1"></i>참여 취소
                            </button>
                        </div>
                        @endif
                    @elseif($event->canParticipate())
                        <!-- 참여 신청 가능한 경우 -->
                        @if($event->pending_participants > 0)
                        <!-- 대기 중 알림 -->
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-clock me-2"></i>
                            <strong>{{ number_format($event->pending_participants) }}명</strong>이 승인을 기다리고 있습니다.
                        </div>
                        @endif

                        @if($event->participation_end_date)
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>신청 마감: {{ $event->participation_end_date->format('Y년 m월 d일 H:i') }}
                            </small>
                        </div>
                        @endif

                        <div class="d-grid">
                            <a href="{{ route('event.participate', $event->id) }}"
                               class="btn btn-primary">
                                <i class="bi bi-person-plus me-2"></i>참여 신청하기
                            </a>
                        </div>
                    @else
                        <!-- 참여 신청 불가능한 경우 -->
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            @if($event->isParticipationClosed())
                                참여 신청이 마감되었습니다.
                            @elseif($event->participation_start_date && now()->lt($event->participation_start_date))
                                참여 신청이 {{ $event->participation_start_date->format('Y년 m월 d일 H:i') }}부터 시작됩니다.
                            @else
                                현재 참여 신청을 받고 있지 않습니다.
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- 공유 버튼 -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-share me-2"></i>이벤트 공유하기
                    </h6>
                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-primary btn-sm"
                                onclick="copyToClipboard('{{ request()->url() }}')">
                            <i class="bi bi-link-45deg me-1"></i>링크 복사
                        </button>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($event->title) }}"
                           target="_blank"
                           class="btn btn-outline-info btn-sm">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </a>
                    </div>
                </div>
            </div>

            <!-- 이전/다음 이벤트 링크 -->
            @if($prevEvent || $nextEvent)
            <div class="mt-3 d-flex justify-content-between">
                @if($prevEvent)
                <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($prevEvent) }}"
                   class="text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>이전 이벤트
                </a>
                @else
                <span></span>
                @endif

                @if($nextEvent)
                <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($nextEvent) }}"
                   class="text-decoration-none">
                    다음 이벤트<i class="bi bi-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 이벤트 정보 카드 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>이벤트 정보
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">상태</span>
                                <span class="badge {{ $statusClasses[$event->status] ?? 'bg-secondary' }}">
                                    {{ $statusTexts[$event->status] ?? $event->status }}
                                </span>
                            </div>
                        </div>

                        @if($event->manager)
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">담당자</span>
                                <span>{{ $event->manager }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">조회수</span>
                                <span class="fw-bold text-primary">
                                    <i class="bi bi-eye me-1"></i>{{ $event->formatted_view_count }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">등록일</span>
                                <span>{{ $event->created_at->format('Y.m.d') }}</span>
                            </div>
                        </div>

                        @if($event->updated_at && $event->updated_at != $event->created_at)
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">수정일</span>
                                <span>{{ $event->updated_at->format('Y.m.d') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 참여 통계 카드 -->
            @if($event->allow_participation)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up me-2"></i>참여 통계
                    </h6>
                </div>
                <div class="card-body participation-stats">
                    <div class="row g-3">
                        <!-- 총 지원자 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">총 지원자</span>
                                <span class="fw-bold text-primary">{{ number_format($event->total_participants) }}명</span>
                            </div>
                        </div>

                        <!-- 승인된 참여자 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">승인됨</span>
                                <span class="fw-bold text-success">{{ number_format($event->approved_participants) }}명</span>
                            </div>
                        </div>

                        <!-- 대기 중 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">대기 중</span>
                                <span class="fw-bold text-warning">{{ number_format($event->pending_participants) }}명</span>
                            </div>
                        </div>

                        @if($event->rejected_participants > 0)
                        <!-- 거부됨 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">거부됨</span>
                                <span class="fw-bold text-danger">{{ number_format($event->rejected_participants) }}명</span>
                            </div>
                        </div>
                        @endif

                        @if($event->max_participants)
                        <!-- 참여율 -->
                        <div class="col-12 border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">참여율</span>
                                <div class="text-end">
                                    <div class="fw-bold text-info">{{ number_format($event->getParticipationRate(), 1) }}%</div>
                                    <small class="text-muted">{{ number_format($event->approved_participants) }}/{{ number_format($event->max_participants) }}</small>
                                </div>
                            </div>
                            <!-- 진행률 바 -->
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info"
                                     role="progressbar"
                                     style="width: {{ min($event->getParticipationRate(), 100) }}%"
                                     aria-valuenow="{{ $event->getParticipationRate() }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <!-- 남은 자리 -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">남은 자리</span>
                                <span class="fw-bold {{ $event->getRemainingSpots() > 0 ? 'text-primary' : 'text-secondary' }}">
                                    {{ $event->getRemainingSpots() > 0 ? number_format($event->getRemainingSpots()) . '명' : '마감' }}
                                </span>
                            </div>
                        </div>
                        @endif

                        <!-- 참여 설정 정보 -->
                        <div class="col-12 border-top pt-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">승인 방식</span>
                                <span class="badge bg-{{ $event->approval_type === 'auto' ? 'success' : 'warning' }}">
                                    {{ $event->approval_type === 'auto' ? '자동 승인' : '수동 승인' }}
                                </span>
                            </div>
                        </div>

                        @if($event->participation_end_date)
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">신청 마감</span>
                                <span class="text-{{ now()->gt($event->participation_end_date) ? 'danger' : 'info' }}">
                                    {{ $event->participation_end_date->format('m/d H:i') }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- 관련 이벤트 -->
            @if($relatedEvents->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-collection me-2"></i>관련 이벤트
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($relatedEvents as $relatedEvent)
                    <div class="mb-3 {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                        <div class="d-flex">
                            @if($relatedEvent->image)
                            <img src="{{ $relatedEvent->image }}"
                                 alt="{{ $relatedEvent->title }}"
                                 class="rounded me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-event text-muted"></i>
                            </div>
                            @endif

                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ \Jiny\Site\Http\Controllers\Site\Event\ShowController::getEventUrl($relatedEvent) }}"
                                       class="text-decoration-none">
                                        {{ Str::limit($relatedEvent->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $relatedEvent->created_at->format('Y.m.d') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="text-center mt-3">
                        <a href="{{ route('event.index', ['status' => $event->status]) }}"
                           class="btn btn-outline-primary btn-sm">
                            더 많은 {{ $statusTexts[$event->status] ?? '' }} 이벤트 보기
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- 목록으로 돌아가기 -->
            <div class="d-grid mt-4">
                <a href="{{ route('event.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>이벤트 목록으로 돌아가기
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // 성공 알림
        const toast = document.createElement('div');
        toast.className = 'toast position-fixed top-0 end-0 m-3';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="toast-header">
                <i class="bi bi-check-circle text-success me-2"></i>
                <strong class="me-auto">복사 완료</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                링크가 클립보드에 복사되었습니다.
            </div>
        `;
        document.body.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // 3초 후 제거
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }).catch(function(err) {
        alert('링크 복사에 실패했습니다.');
    });
}

function cancelParticipation(eventId) {
    if (confirm('정말로 참여를 취소하시겠습니까?')) {
        // CSRF 토큰 가져오기
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(`/event/${eventId}/cancel-participation`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 성공 시 페이지 새로고침
                location.reload();
            } else {
                alert(data.message || '참여 취소에 실패했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('참여 취소 중 오류가 발생했습니다.');
        });
    }
}
</script>
@endpush

@push('styles')
<style>
.event-content {
    font-size: 1.1rem;
    line-height: 1.7;
}

.event-content p {
    margin-bottom: 1rem;
}

/* 참여 통계 배지 스타일 */
.badge {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
    border-radius: 0.5rem;
}

/* 참여 통계 섹션 구분선 */
.participation-stats .border-top {
    border-top: 2px solid rgba(0,0,0,0.1) !important;
}

/* 뱃지 스타일 개선 */
.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.badge.bg-info {
    background-color: #0dcaf0 !important;
}

.badge.bg-primary {
    background-color: #0d6efd !important;
}
</style>
@endpush
@endsection