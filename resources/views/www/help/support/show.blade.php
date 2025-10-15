@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

@includeIf("jiny-site::www.help.partials.hero")
@includeIf("jiny-site::www.help.partials.menu")

<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="col-12">
                <!-- 뒤로가기 버튼 -->
                <div class="mb-4">
                    <a href="{{ route('help.support.my') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-1"></i>목록으로 돌아가기
                    </a>
                </div>

                <!-- 지원 요청 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="card-title mb-2">#{{ $support->id }} {{ $support->subject }}</h3>
                                <div class="d-flex gap-2 mb-2">
                                    <span id="statusBadge" class="badge {{ $support->status_class }}">{{ $support->status_label }}</span>
                                    <span class="badge {{ $support->priority_class }}">{{ $support->priority_label }}</span>
                                    <span class="badge bg-light text-dark">{{ $support->type_label }}</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="d-flex flex-column gap-2">
                                    @if($support->isEditable())
                                    <a href="{{ url('/help/support/' . $support->id . '/edit') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fe fe-edit-2 me-1"></i>수정
                                    </a>
                                    @endif

                                    @if($support->isDeletable())
                                    <form method="POST" action="{{ url('/help/support/' . $support->id . '/delete') }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('정말 삭제하시겠습니까?')">
                                            <i class="fe fe-trash-2 me-1"></i>삭제
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- 요청 내용 -->
                        <div class="mb-4">
                            <h5>문의 내용</h5>
                            <div class="content-area">
                                {!! nl2br(e($support->content)) !!}
                            </div>
                        </div>

                        <!-- 첨부파일 -->
                        @if($support->attachments && count(json_decode($support->attachments, true) ?? []) > 0)
                        <div class="mb-4">
                            <h5>첨부파일</h5>
                            <div class="list-group">
                                @foreach(json_decode($support->attachments, true) ?? [] as $attachment)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fe fe-paperclip me-2"></i>
                                        {{ $attachment['name'] ?? 'Unknown file' }}
                                        <small class="text-muted ms-2">
                                            ({{ isset($attachment['size']) ? number_format($attachment['size'] / 1024, 1) . ' KB' : 'Unknown size' }})
                                        </small>
                                    </div>
                                    @if(isset($attachment['path']))
                                    <a href="{{ Storage::url($attachment['path']) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                        <i class="fe fe-download me-1"></i>다운로드
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- 기본 정보 -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-muted">요청일:</strong>
                                    <span>{{ $support->created_at->format('Y-m-d H:i:s') }}</span>
                                </div>
                                @if($support->started_at)
                                <div class="mb-3">
                                    <strong class="text-muted">처리 시작:</strong>
                                    <span>{{ $support->started_at->format('Y-m-d H:i:s') }}</span>
                                </div>
                                @endif
                                @if($support->resolved_at)
                                <div class="mb-3">
                                    <strong class="text-muted">해결 완료:</strong>
                                    <span>{{ $support->resolved_at->format('Y-m-d H:i:s') }}</span>
                                    {{-- resolved_by 컬럼이 없어서 주석 처리
                                    @if($support->resolvedBy)
                                    <small class="text-muted">(처리자: {{ $support->resolvedBy->name }})</small>
                                    @endif
                                    --}}
                                </div>
                                @endif
                                @if($support->closed_at)
                                <div class="mb-3">
                                    <strong class="text-muted">종료일:</strong>
                                    <span>{{ $support->closed_at->format('Y-m-d H:i:s') }}</span>
                                    {{-- closed_by 컬럼이 없어서 주석 처리
                                    @if($support->closedBy)
                                    <small class="text-muted">(처리자: {{ $support->closedBy->name }})</small>
                                    @endif
                                    --}}
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($support->assignedTo)
                                <div class="mb-3">
                                    <strong class="text-muted">담당자:</strong>
                                    <span>{{ $support->assignedTo->name }}</span>
                                </div>
                                @endif
                                @if($support->activeAssignments && $support->activeAssignments->count() > 0)
                                <div class="mb-3">
                                    <strong class="text-muted">담당 관리자:</strong>
                                    <div>
                                        @foreach($support->activeAssignments as $assignment)
                                        <span class="badge {{ $assignment->role === 'primary' ? 'bg-primary' : 'bg-secondary' }} me-1">
                                            {{ $assignment->assignee->name }} ({{ $assignment->role_label }})
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @if($support->created_at && $support->resolved_at)
                                <div class="mb-3">
                                    <strong class="text-muted">처리 시간:</strong>
                                    <span>{{ $support->created_at->diffInHours($support->resolved_at) }}시간</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 답변 히스토리 -->
                @if($replies->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">답변 히스토리</h4>
                        <small class="text-muted">관리자와의 대화 내역입니다.</small>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($replies as $reply)
                            <div class="timeline-item {{ $reply->sender_type === 'admin' ? 'timeline-admin' : 'timeline-customer' }}">
                                <div class="timeline-marker">
                                    @if($reply->sender_type === 'admin')
                                    <span class="badge bg-success">관리자</span>
                                    @else
                                    <span class="badge bg-info">고객</span>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <strong>{{ $reply->user->name ?? '알 수 없음' }}</strong>
                                        <small class="text-muted ms-2">{{ $reply->created_at->format('Y-m-d H:i:s') }}</small>
                                    </div>
                                    <div class="timeline-body">
                                        {!! nl2br(e($reply->content)) !!}
                                    </div>
                                    @if($reply->attachments && count($reply->attachments) > 0)
                                    <div class="timeline-attachments mt-2">
                                        <small class="text-muted">첨부파일:</small>
                                        @foreach($reply->attachments as $attachment)
                                        <div class="mt-1">
                                            <i class="fe fe-paperclip me-1"></i>
                                            <a href="{{ Storage::url($attachment['path']) }}" target="_blank">
                                                {{ $attachment['name'] }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- 지원 종료 안내 메시지 -->
                @if(in_array($support->status, ['resolved', 'closed']))
                <div class="card mb-4 border-info">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fe fe-check-circle-o text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title text-success mb-2">
                            @if($support->status === 'resolved')
                            문의가 해결되었습니다
                            @else
                            문의가 종료되었습니다
                            @endif
                        </h5>
                        <p class="text-muted mb-3">
                            @if($support->status === 'resolved')
                            관리자가 문의를 해결 완료로 처리했습니다.
                            @else
                            {{ $support->closed_at ? '지원 요청이 성공적으로 종료되었습니다.' : '문의가 종료되었습니다.' }}
                            @endif
                        </p>
                        @if($support->status === 'resolved' && $support->resolved_at)
                        <small class="text-muted">
                            <i class="fe fe-calendar me-1"></i>해결 완료: {{ $support->resolved_at->format('Y년 m월 d일 H:i') }}
                        </small>
                        @elseif($support->status === 'closed' && $support->closed_at)
                        <small class="text-muted">
                            <i class="fe fe-calendar me-1"></i>종료일: {{ $support->closed_at->format('Y년 m월 d일 H:i') }}
                        </small>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 추가 문의 작성 -->
                @if(in_array($support->status, ['pending', 'in_progress']))
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">추가 문의</h4>
                        <small class="text-muted">더 궁금한 점이 있으시면 언제든지 문의해주세요.</small>
                    </div>
                    <div class="card-body">
                        <form id="customerReplyForm" action="{{ url('/help/support/' . $support->id . '/reply') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_content" class="form-label">문의 내용</label>
                                <textarea id="customer_content" name="content" class="form-control" rows="4" required
                                          placeholder="추가로 궁금한 점이나 문제에 대해 자세히 설명해주세요..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="customer_attachments" class="form-label">첨부파일 (선택사항)</label>
                                <input type="file" id="customer_attachments" name="attachments[]" class="form-control" multiple
                                       accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip">
                                <div class="form-text">
                                    <i class="fe fe-info me-1"></i>
                                    이미지, 문서 파일을 첨부할 수 있습니다. (최대 10MB, 여러 파일 선택 가능)
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-send me-1"></i>문의 전송
                                </button>
                                <small class="text-muted">
                                    <i class="fe fe-clock me-1"></i>관리자가 확인 후 최대한 빠르게 답변드리겠습니다.
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 문제 해결됨 버튼 (답변 확인 후) -->
                <div id="closeButtonSection" class="text-center mb-4">
                    <p class="text-muted mb-3">
                        <i class="fe fe-help-circle me-2"></i>
                        위의 답변으로 문제가 해결되셨나요?
                    </p>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#closeModal">
                        <i class="fe fe-check-circle me-2"></i>네, 문제가 해결되었습니다
                    </button>
                </div>
                @endif

                <!-- 종료 완료 메시지 (AJAX 성공 시 표시) -->
                <div id="closedSection" class="text-center mb-4" style="display: none;">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fe fe-check-circle me-2"></i>지원 요청이 종료되었습니다
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-success mb-2">
                                <strong>문제가 성공적으로 해결되었습니다!</strong>
                            </p>
                            <p class="text-muted mb-0">소중한 시간을 내어 평가해 주셔서 감사합니다.</p>
                        </div>
                    </div>
                </div>

                <!-- 종료된 요청 정보 -->
                @if($support->status === 'closed')
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-check-circle me-2"></i>지원 요청이 종료되었습니다
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-muted">종료일:</strong>
                                    <span>{{ $support->closed_at->format('Y-m-d H:i:s') }}</span>
                                </div>
                                {{-- closed_by 컬럼이 없어서 주석 처리
                                @if($support->closedBy)
                                <div class="mb-3">
                                    <strong class="text-muted">종료자:</strong>
                                    <span>{{ $support->closedBy->name }}</span>
                                </div>
                                @endif
                                --}}
                            </div>
                            <div class="col-md-6">
                                @if($support->created_at && $support->closed_at)
                                <div class="mb-3">
                                    <strong class="text-muted">총 처리 시간:</strong>
                                    <span>{{ $support->created_at->diffInHours($support->closed_at) }}시간</span>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <strong class="text-muted">최종 상태:</strong>
                                    <span class="badge {{ $support->status_class }}">{{ $support->status_label }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- 종료 후 안내 메시지 -->
                        @if(!$existingEvaluation)
                        <div class="alert alert-info mt-3">
                            <i class="fe fe-star me-2"></i>
                            <strong>서비스 평가를 남겨주세요!</strong><br>
                            받으신 서비스에 대한 평가를 통해 더 나은 지원을 제공할 수 있습니다.
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- 평가하기 -->
                @if($canEvaluate && !$existingEvaluation && $evaluableAdmins->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">서비스 평가</h4>
                        <small class="text-muted">받으신 서비스에 대해 평가해주세요.</small>
                    </div>
                    <div class="card-body">
                        <form id="evaluationForm" action="{{ url('/help/support/' . $support->id . '/evaluate') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="evaluated_admin_id" class="form-label">평가할 관리자</label>
                                        <select id="evaluated_admin_id" name="evaluated_admin_id" class="form-select" required>
                                            <option value="">관리자를 선택하세요</option>
                                            @foreach($evaluableAdmins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">전체 만족도</label>
                                        <div class="rating-container">
                                            <div class="rating-stars">
                                                <i class="rating-star far fa-star" data-rating="1"></i>
                                                <i class="rating-star far fa-star" data-rating="2"></i>
                                                <i class="rating-star far fa-star" data-rating="3"></i>
                                                <i class="rating-star far fa-star" data-rating="4"></i>
                                                <i class="rating-star far fa-star" data-rating="5"></i>
                                            </div>
                                            <input type="hidden" id="rating" name="rating" required>
                                            <div id="ratingLabel" class="text-muted mt-1">평점을 선택하세요</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">추가 의견 (선택)</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="서비스에 대한 추가 의견을 입력해주세요..."></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="1">
                                    <label class="form-check-label" for="is_anonymous">
                                        익명으로 평가하기
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-star me-1"></i>평가 제출
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                <!-- 기존 평가 표시 -->
                @if($existingEvaluation)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">내 평가</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <strong class="me-2">{{ $existingEvaluation->evaluatedAdmin->name }}</strong>
                            <span class="badge {{ $existingEvaluation->rating_class }}">{{ $existingEvaluation->rating_label }}</span>
                        </div>
                        <div class="stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= $existingEvaluation->rating ? 's' : 'r' }} fa-star text-warning"></i>
                            @endfor
                        </div>
                        @if($existingEvaluation->comment)
                        <p class="text-muted mb-0">"{{ $existingEvaluation->comment }}"</p>
                        @endif
                        <small class="text-muted">{{ $existingEvaluation->created_at->format('Y-m-d H:i:s') }}에 평가함</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- 지원 요청 종료 모달 -->
@if(in_array($support->status, ['pending', 'in_progress']))
<div class="modal fade" id="closeModal" tabindex="-1" aria-labelledby="closeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeModalLabel">지원 요청 종료</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="closeForm" method="POST" action="{{ url('/help/support/' . $support->id . '/close') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fe fe-info me-2"></i>
                        문제가 해결되어 지원 요청을 종료하시겠습니까?<br>
                        종료 후에는 서비스에 대한 평가를 남겨주실 수 있습니다.
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">종료 사유 (선택사항)</label>
                        <textarea id="reason" name="reason" class="form-control" rows="3"
                                  placeholder="예: 문제가 해결되었습니다. 도움 주셔서 감사합니다."></textarea>
                        <div class="form-text">종료 사유를 입력하시면 관리자에게 전달됩니다.</div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">서비스 만족도 (선택사항)</label>
                        <div class="rating-container">
                            <div class="rating-stars-close d-flex gap-1">
                                <span class="rating-star-close" data-rating="1" style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                                <span class="rating-star-close" data-rating="2" style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                                <span class="rating-star-close" data-rating="3" style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                                <span class="rating-star-close" data-rating="4" style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                                <span class="rating-star-close" data-rating="5" style="font-size: 1.5rem; cursor: pointer; color: #ddd;">★</span>
                            </div>
                            <input type="hidden" id="close_rating" name="rating">
                            <div id="closeRatingLabel" class="text-muted mt-1 small">별점을 선택해주세요 (선택사항)</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="close_comment" class="form-label">추가 의견 (선택사항)</label>
                        <textarea id="close_comment" name="comment" class="form-control" rows="2"
                                  placeholder="서비스에 대한 의견을 남겨주세요..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fe fe-check-circle me-1"></i>요청 종료
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// CSRF 토큰 설정
window.csrfToken = '{{ csrf_token() }}';

document.addEventListener('DOMContentLoaded', function() {
    // 별점 시스템 초기화
    initRatingSystem();
    initCloseRatingSystem();

    // 종료 완료 후 UI 업데이트 확인
    @if(session('support_closed'))
    handleSupportClosed();
    @endif

    // 성공 메시지 표시
    @if(session('success'))
    showSuccessMessage('{{ session("success") }}');
    @endif

    // 오류 메시지 표시
    @if(session('error'))
    showErrorMessage('{{ session("error") }}');
    @endif
});

function initRatingSystem() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingLabel = document.getElementById('ratingLabel');

    if (!stars.length) return;

    stars.forEach(star => {
        star.style.cursor = 'pointer';
        star.style.fontSize = '1.5rem';
        star.style.color = '#ddd';

        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            setRating(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            highlightStars(rating);
        });
    });

    // 별점 영역에서 마우스가 벗어났을 때
    document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        highlightStars(currentRating);
    });

    function setRating(rating) {
        const labels = {
            1: '매우 불만족',
            2: '불만족',
            3: '보통',
            4: '만족',
            5: '매우 만족'
        };

        ratingInput.value = rating;
        ratingLabel.textContent = `${rating}점 - ${labels[rating]}`;
        highlightStars(rating);
    }

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.className = 'rating-star fas fa-star';
                star.style.color = '#ffc107';
            } else {
                star.className = 'rating-star far fa-star';
                star.style.color = '#ddd';
            }
        });
    }
}

// 종료 모달용 별점 시스템
function initCloseRatingSystem() {
    const stars = document.querySelectorAll('.rating-star-close');
    const ratingInput = document.getElementById('close_rating');
    const ratingLabel = document.getElementById('closeRatingLabel');

    if (!stars.length) return;

    stars.forEach(star => {
        star.style.cursor = 'pointer';
        star.style.fontSize = '1.5rem';
        star.style.color = '#ddd';
        star.style.userSelect = 'none';

        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            setCloseRating(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            highlightCloseStars(rating);
        });
    });

    // 별점 영역에서 마우스가 벗어났을 때
    const starsContainer = document.querySelector('.rating-stars-close');
    if (starsContainer) {
        starsContainer.addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value) || 0;
            highlightCloseStars(currentRating);
        });
    }

    function setCloseRating(rating) {
        const labels = {
            1: '매우 불만족',
            2: '불만족',
            3: '보통',
            4: '만족',
            5: '매우 만족'
        };

        ratingInput.value = rating;
        ratingLabel.textContent = `${rating}점 - ${labels[rating]}`;
        highlightCloseStars(rating);
    }

    function highlightCloseStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.style.color = '#ffc107';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
}

// 종료 확인 함수
function confirmClose() {
    const reason = document.getElementById('reason').value.trim();
    const rating = document.getElementById('close_rating').value;

    if (!reason && !rating) {
        return confirm('종료 사유나 평점을 입력하지 않으셨습니다. 그대로 종료하시겠습니까?');
    }

    return true;
}


// 종료 완료 후 UI 처리
function handleSupportClosed() {
    // 1. 종료 버튼 섹션 숨기기
    const closeButtonSection = document.getElementById('closeButtonSection');
    if (closeButtonSection) {
        closeButtonSection.style.display = 'none';
    }

    // 2. 종료 완료 메시지 표시
    const closedSection = document.getElementById('closedSection');
    if (closedSection) {
        closedSection.style.display = 'block';
    }

    // 3. 상태 배지 업데이트
    const statusBadge = document.getElementById('statusBadge');
    if (statusBadge) {
        statusBadge.className = 'badge bg-secondary text-white';
        statusBadge.textContent = '종료';
    }
}

// 성공 메시지 표시
function showSuccessMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fe fe-check-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);

    // 5초 후 자동 제거
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// 오류 메시지 표시
function showErrorMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fe fe-alert-circle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);

    // 8초 후 자동 제거 (오류는 좀 더 오래)
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 8000);
}

// 디버깅용 로그
console.log('지원 요청 종료 모달 스크립트 로드됨');
</script>
@endpush

@push('styles')
<style>
.content-area {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border: 1px solid #dee2e6;
    min-height: 100px;
}

/* 타임라인 스타일 */
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-marker {
    position: absolute;
    left: -2rem;
    top: 0;
    width: 2rem;
    text-align: center;
}

.timeline-content {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-left: 1rem;
}

.timeline-admin .timeline-content {
    border-left: 4px solid #198754;
}

.timeline-customer .timeline-content {
    border-left: 4px solid #0d6efd;
}

.timeline-header {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.timeline-body {
    line-height: 1.6;
}

.timeline-attachments {
    border-top: 1px solid #dee2e6;
    padding-top: 0.5rem;
}

/* 평가 시스템 스타일 */
.rating-stars {
    display: inline-block;
}

.rating-star {
    margin-right: 0.25rem;
    transition: color 0.2s ease;
}

.rating-star:hover {
    color: #ffc107 !important;
}

.stars i {
    margin-right: 0.1rem;
}
</style>
@endpush
