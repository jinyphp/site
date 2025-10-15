@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '상담 요청 - ' . $contact->contact_number)

@section('content')
<section class="py-8">
    <div class="container my-lg-8">
        @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- 상담 요청 제목 -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <!-- 왼쪽: 제목과 정보 -->
                    <div class="flex-grow-1 me-4">
                        <h2 class="mb-2 h1 fw-semibold">{{ $contact->subject }}</h2>
                        <p class="text-muted mb-0">{{ $contact->contact_number }} · {{ $contact->created_at->format('Y년 m월 d일 H:i') }} 접수</p>
                    </div>

                    <!-- 오른쪽: 액션 버튼들 및 배지 -->
                    <div class="flex-shrink-0 text-end">
                        <!-- 액션 버튼들 -->
                        <div class="d-flex gap-2 flex-wrap justify-content-end mb-3">
                            <!-- 뒤로가기 버튼 -->
                            <a href="{{ route('contact.create') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-1"></i>상담 요청으로 돌아가기
                            </a>

                            @if($contact->isActive() && (auth()->check() && $contact->user_id === auth()->id()))
                            <!-- 수정/취소 버튼 -->
                            <a href="{{ route('contact.edit', $contact->contact_number) }}" class="btn btn-outline-primary">
                                <i class="fe fe-edit-2 me-1"></i>수정
                            </a>
                            <button type="button" class="btn btn-outline-danger" onclick="cancelContact('{{ $contact->contact_number }}')">
                                <i class="fe fe-x-circle me-1"></i>취소
                            </button>
                            @endif
                        </div>

                        <!-- 배지들 -->
                        <div class="d-flex gap-2 justify-content-end flex-wrap">
                            <span class="badge bg-{{ $contact->status_class }}">{{ $contact->status_text }}</span>
                            <span class="badge bg-{{ $contact->priority_class }}">{{ $contact->priority_text }}</span>
                            <span class="badge bg-light text-dark">{{ $contact->contactType->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 메인 콘텐츠 -->
        <div class="row">
            <!-- 왼쪽 컬럼: 상담 내역 -->
            <div class="col-lg-8 col-12">
                <!-- 문의자 정보 -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-user me-2"></i>문의자 정보
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <strong>이름:</strong> {{ $contact->name }}
                            </div>
                            <div class="col-md-4 mb-2">
                                <strong>이메일:</strong> {{ $contact->email }}
                            </div>
                            @if($contact->phone)
                            <div class="col-md-4 mb-2">
                                <strong>전화번호:</strong> {{ $contact->phone }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 문의 내용 -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-file-text me-2"></i>문의 내용
                        </h6>
                        <div class="contact-message">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>
                </div>

                <!-- 답변 및 댓글 -->
                @if($contact->publicComments->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-message-square me-2"></i>관리자 답변
                        </h6>
                        @foreach($contact->publicComments as $comment)
                        <div class="comment-item {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                            <div class="d-flex align-items-start mb-2">
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fe fe-user"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->format('Y년 m월 d일 H:i') }}</small>
                                    </div>
                                    <div class="comment-content">
                                        {!! nl2br(e($comment->comment)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($contact->is_public)
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fe fe-eye me-2"></i>
                        <div>
                            <strong>공개 상담</strong>
                            <div class="small">이 상담 내용은 다른 사용자도 볼 수 있습니다.</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- 오른쪽 컬럼: 상태 및 액션 -->
            <div class="col-lg-4 col-12">
                <!-- 진행 상황 -->
                <div class="card mb-4 status-card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-clock me-2"></i>처리 진행 상황
                        </h6>
                        <div class="progress-timeline">
                            <div class="timeline-item {{ in_array($contact->status, ['pending', 'processing', 'completed']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fe fe-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">접수 완료</div>
                                    <div class="timeline-time">{{ $contact->created_at->format('m/d H:i') }}</div>
                                </div>
                            </div>

                            <div class="timeline-item {{ in_array($contact->status, ['processing', 'completed']) ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fe fe-settings"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">처리 중</div>
                                    @if($contact->status === 'processing')
                                    <div class="timeline-time">진행 중</div>
                                    @endif
                                </div>
                            </div>

                            <div class="timeline-item {{ $contact->status === 'completed' ? 'completed' : '' }}">
                                <div class="timeline-marker">
                                    <i class="fe fe-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">처리 완료</div>
                                    @if($contact->processed_at)
                                    <div class="timeline-time">{{ $contact->processed_at->format('m/d H:i') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 상담 정보 요약 -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-info me-2"></i>상담 정보
                        </h6>
                        <div class="info-item mb-2">
                            <small class="text-muted d-block">상담 번호</small>
                            <strong>{{ $contact->contact_number }}</strong>
                        </div>
                        <div class="info-item mb-2">
                            <small class="text-muted d-block">접수일</small>
                            <strong>{{ $contact->created_at->format('Y년 m월 d일') }}</strong>
                        </div>
                        @if($contact->processed_at)
                        <div class="info-item mb-2">
                            <small class="text-muted d-block">처리일</small>
                            <strong>{{ $contact->processed_at->format('Y년 m월 d일') }}</strong>
                        </div>
                        @endif
                        <div class="info-item">
                            <small class="text-muted d-block">상담 유형</small>
                            <strong>{{ $contact->contactType->name }}</strong>
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fe fe-settings me-2"></i>빠른 실행
                        </h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('contact.create') }}" class="btn btn-primary">
                                <i class="fe fe-plus me-2"></i>새 상담 요청
                            </a>
                            <a href="{{ route('contact.search') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-search me-2"></i>다른 상담 조회
                            </a>
                            @auth
                            <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-list me-2"></i>내 상담 목록
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 취소 확인 모달 -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">상담 요청 취소</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                정말로 이 상담 요청을 취소하시겠습니까?<br>
                취소된 상담은 되돌릴 수 없습니다.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">아니오</button>
                <form method="POST" action="{{ route('contact.cancel', $contact->contact_number) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">예, 취소합니다</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function cancelContact(contactNumber) {
    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}
</script>
@endsection

@push('styles')
<style>
.contact-message {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #333;
    white-space: pre-wrap;
}

.comment-content {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #495057;
    white-space: pre-wrap;
}

.avatar {
    width: 32px;
    height: 32px;
    font-size: 0.75rem;
}

.progress-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 30px;
    width: 2px;
    height: calc(100% - 15px);
    background-color: #dee2e6;
}

.timeline-item.completed:not(:last-child)::before {
    background-color: #198754;
}

.timeline-marker {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 0.875rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.timeline-item.completed .timeline-marker {
    background-color: #198754;
    color: white;
}

.timeline-content {
    padding-top: 2px;
}

.timeline-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 2px;
}

.timeline-item.completed .timeline-title {
    color: #198754;
}

.timeline-time {
    font-size: 0.875rem;
    color: #6c757d;
}

.card {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

/* 오른쪽 사이드바 스타일 */
.status-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid #dee2e6;
}

.info-item {
    padding: 0.5rem 0;
}

.info-item:not(:last-child) {
    border-bottom: 1px solid #f1f3f4;
}

.info-item small {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item strong {
    font-size: 0.875rem;
    color: #495057;
}

/* 버튼 그룹 스타일 */
.d-grid .btn {
    text-align: left;
    display: flex;
    align-items: center;
}

.d-grid .btn i {
    width: 16px;
}

/* 타임라인 컴팩트 스타일 */
.progress-timeline .timeline-item {
    padding-bottom: 1rem;
}

.progress-timeline .timeline-item:last-child {
    padding-bottom: 0;
}

.progress-timeline .timeline-marker {
    width: 24px;
    height: 24px;
    font-size: 0.75rem;
}

.progress-timeline .timeline-item:not(:last-child)::before {
    left: 11px;
    top: 24px;
    height: calc(100% - 8px);
}

.progress-timeline .timeline-title {
    font-size: 0.875rem;
    margin-bottom: 1px;
}

.progress-timeline .timeline-time {
    font-size: 0.75rem;
}

/* 헤더 반응형 */
@media (max-width: 767.98px) {
    .d-flex.justify-content-between.align-items-start {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .flex-grow-1.me-4 {
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }

    .flex-shrink-0.text-end {
        width: 100%;
        text-align: left !important;
    }

    .flex-shrink-0 .d-flex.flex-wrap {
        width: 100%;
        justify-content: flex-start !important;
    }

    .flex-shrink-0 .btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        white-space: nowrap;
    }

    /* 뒤로가기 버튼을 전체 너비로 */
    .flex-shrink-0 .btn.btn-outline-secondary {
        width: 100%;
        margin-bottom: 0.5rem;
        order: -1;
    }

    /* 배지들도 왼쪽 정렬 */
    .flex-shrink-0 .d-flex.justify-content-end {
        justify-content: flex-start !important;
        margin-top: 0.5rem;
    }
}

/* 모바일 반응형 */
@media (max-width: 991.98px) {
    .col-lg-4 {
        margin-top: 2rem;
    }

    .status-card {
        background: white;
    }
}
</style>
@endpush
