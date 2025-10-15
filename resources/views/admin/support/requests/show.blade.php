@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 상세')

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
                                <i class="fe fe-eye me-2"></i>
                                지원 요청 상세
                            </h1>
                            <p class="page-header-subtitle">지원 요청의 상세 정보를 확인합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                            <a href="{{ route('admin.cms.support.requests.edit', $support->id) }}" class="btn btn-primary">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 지원 요청 정보 -->
    <div class="row mt-4">
        <!-- 메인 콘텐츠 영역 -->
        <div class="col-xl-8">
            <!-- 요청 내용 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">요청 내용</h4>
                </div>
                <div class="card-body">
                    @if($support->content)
                        {!! nl2br(e($support->content)) !!}
                    @else
                        <div class="text-muted">
                            요청 내용이 입력되지 않았습니다.
                        </div>
                    @endif
                </div>
            </div>

            <!-- 문의/답변 이력 -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">문의/답변 이력</h4>
                    <span class="badge bg-primary">총 {{ isset($support->replies) ? $support->replies->count() : 0 }}개</span>
                </div>
                <div class="card-body">
                    <div id="replies-container">
                        @if(isset($support->replies) && $support->replies->count() > 0)
                            @foreach($support->replies as $reply)
                        <div class="reply-item border-bottom pb-3 mb-3" data-reply-id="{{ $reply->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    @if($reply->sender_type === 'admin')
                                        <span class="badge bg-success me-2">관리자</span>
                                    @else
                                        <span class="badge bg-info me-2">고객</span>
                                    @endif

                                    @if($reply->is_private)
                                        <span class="badge bg-warning me-2">
                                            <i class="fe fe-lock me-1"></i>내부메모
                                        </span>
                                    @endif

                                    <strong>{{ $reply->user->name ?? '알 수 없음' }}</strong>
                                    <small class="text-muted ms-2">
                                        {{ $reply->created_at->format('Y-m-d H:i') }}
                                    </small>
                                </div>

                                @if($reply->user_id === auth()->id())
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                        <i class="fe fe-more-horizontal"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="editReply({{ $reply->id }})">수정</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteReply({{ $reply->id }})">삭제</a></li>
                                    </ul>
                                </div>
                                @endif
                            </div>

                            <div class="reply-content content-area">
                                {!! nl2br(e($reply->content)) !!}
                            </div>

                            @if($reply->attachments && count($reply->attachments) > 0)
                            <div class="reply-attachments mt-2">
                                <small class="text-muted">첨부파일:</small>
                                @foreach($reply->attachments as $index => $attachment)
                                <div class="d-inline-block me-2">
                                    <a href="{{ route('admin.cms.support.requests.reply.download', [$support->id, $reply->id, $index]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fe fe-paperclip me-1"></i>{{ $attachment['name'] }}
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                            @endforeach
                        @else
                        <div class="text-center text-muted py-4">
                            <i class="fe fe-message-circle fs-3 mb-2"></i>
                            <p>아직 답변이 없습니다.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 답변 작성 폼 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">답변 작성</h4>
                </div>
                <div class="card-body">
                    <form id="reply-form" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">답변 내용 <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="6" required
                                      placeholder="내부 메모를 작성해주세요... (고객에게 공개하려면 아래 체크박스를 선택하세요)"></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <!-- 실제 전송될 값 (기본값: 내부메모) -->
                                    <input type="hidden" name="is_private" id="is_private_hidden" value="1">
                                    <!-- UI 체크박스 (기본값: 체크되지 않음 = 내부메모) -->
                                    <input class="form-check-input" type="checkbox" id="is_public" onchange="togglePrivacy()">
                                    <label class="form-check-label" for="is_public">
                                        <i class="fe fe-eye me-1"></i>고객에게 공개
                                    </label>
                                    <small class="form-text text-muted d-block">체크하지 않으면 내부 메모로 저장됩니다.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="attachments" class="form-label">첨부파일</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple
                                       accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.zip">
                                <small class="form-text text-muted">최대 10MB, 여러 파일 선택 가능</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="auto_resolve" name="auto_resolve" value="1">
                                <label class="form-check-label" for="auto_resolve">
                                    답변 후 자동으로 해결완료 처리
                                </label>
                            </div>

                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2" onclick="previewReply()">
                                    <i class="fe fe-eye me-1"></i>미리보기
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-send me-1"></i>답변 보내기
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 첨부파일 -->
            @if($support->attachments && count(json_decode($support->attachments, true) ?? []) > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">첨부파일</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(json_decode($support->attachments, true) ?? [] as $attachment)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
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
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-xl-4">
            <!-- 기본 정보 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">기본 정보</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">제목</strong>
                        <div>{{ $support->subject }}</div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">유형</strong>
                        <div>
                            @if($support->type === 'technical')
                                <span class="badge bg-info">기술 지원</span>
                            @elseif($support->type === 'billing')
                                <span class="badge bg-warning">결제 문의</span>
                            @elseif($support->type === 'general')
                                <span class="badge bg-secondary">일반 문의</span>
                            @elseif($support->type === 'bug_report')
                                <span class="badge bg-danger">버그 리포트</span>
                            @else
                                <span class="badge bg-light text-dark">{{ $support->type }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">우선순위</strong>
                        <div>
                            @if($support->priority === 'urgent')
                                <span class="badge bg-danger">긴급</span>
                            @elseif($support->priority === 'high')
                                <span class="badge bg-warning">높음</span>
                            @elseif($support->priority === 'medium')
                                <span class="badge bg-info">보통</span>
                            @elseif($support->priority === 'low')
                                <span class="badge bg-secondary">낮음</span>
                            @else
                                <span class="badge bg-light text-dark">{{ $support->priority }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">상태</strong>
                        <div>
                            @if($support->status === 'pending')
                                <span class="badge bg-warning">대기중</span>
                            @elseif($support->status === 'in_progress')
                                <span class="badge bg-info">처리중</span>
                            @elseif($support->status === 'resolved')
                                <span class="badge bg-success">해결완료</span>
                            @elseif($support->status === 'closed')
                                <span class="badge bg-secondary">종료</span>
                            @else
                                <span class="badge bg-light text-dark">{{ $support->status }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">요청자</strong>
                        <div>
                            @if($support->user)
                                {{ $support->user->name }}
                                <br>
                                <small class="text-muted">{{ $support->user->email }}</small>
                            @else
                                {{ $support->name ?? '익명' }}
                                @if($support->email)
                                    <br>
                                    <small class="text-muted">{{ $support->email }}</small>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">담당자</strong>
                        <div>
                            @if($support->assignedTo)
                                {{ $support->assignedTo->name }}
                                <br>
                                <small class="text-muted">{{ $support->assignedTo->email }}</small>
                            @else
                                <span class="text-muted">미배정</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted d-block mb-1">등록일</strong>
                        <div>{{ $support->created_at ? \Carbon\Carbon::parse($support->created_at)->format('Y-m-d H:i:s') : '' }}</div>
                    </div>

                    @if($support->updated_at && $support->updated_at != $support->created_at)
                    <div class="mb-0">
                        <strong class="text-muted d-block mb-1">수정일</strong>
                        <div>{{ \Carbon\Carbon::parse($support->updated_at)->format('Y-m-d H:i:s') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 빠른 액션 -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">빠른 액션</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.cms.support.requests.edit', $support->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>수정
                        </a>

                        @if($support->status === 'pending')
                        <button type="button" class="btn btn-info" onclick="changeStatus('in_progress')">
                            <i class="fe fe-play me-2"></i>처리 시작
                        </button>
                        @endif

                        @if($support->status === 'in_progress')
                        <button type="button" class="btn btn-success" onclick="changeStatus('resolved')">
                            <i class="fe fe-check me-2"></i>해결 완료
                        </button>
                        @endif

                        @if(in_array($support->status, ['pending', 'in_progress']))
                        <button type="button" class="btn btn-secondary" onclick="showStatusChangeModal('closed')">
                            <i class="fe fe-x me-2"></i>종료
                        </button>
                        @endif

                        @if($support->status === 'resolved')
                        <button type="button" class="btn btn-dark" onclick="showStatusChangeModal('closed')">
                            <i class="fe fe-archive me-2"></i>완전 종료
                        </button>
                        @endif

                        @if(in_array($support->status, ['resolved', 'closed']))
                        <button type="button" class="btn btn-warning" onclick="showStatusChangeModal('reopened')">
                            <i class="fe fe-refresh-cw me-2"></i>재오픈
                        </button>
                        @endif

                        <hr>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteSupport()">
                            <i class="fe fe-trash-2 me-2"></i>삭제
                        </button>
                    </div>
                </div>
            </div>

            <!-- 다중 관리자 할당 -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">담당 관리자</h4>
                    <button type="button" class="btn btn-sm btn-primary" onclick="showAssignAdminModal()">
                        <i class="fe fe-plus me-1"></i>할당
                    </button>
                </div>
                <div class="card-body">
                    <div id="assignedAdminsContainer">
                        <!-- 할당된 관리자 목록이 동적으로 로드됩니다 -->
                        <div class="text-center text-muted py-3">
                            <div class="spinner-border spinner-border-sm me-2"></div>
                            로딩 중...
                        </div>
                    </div>
                </div>
            </div>

            <!-- 고객 평가 -->
            @if($support->status === 'resolved' || $support->status === 'closed')
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">고객 평가</h4>
                    @if($support->user_id === auth()->id())
                    <button type="button" class="btn btn-sm btn-primary" onclick="showEvaluationModal()">
                        <i class="fe fe-star me-1"></i>평가하기
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    <div id="evaluationsContainer">
                        <!-- 평가 목록이 동적으로 로드됩니다 -->
                        <div class="text-center text-muted py-3">
                            <div class="spinner-border spinner-border-sm me-2"></div>
                            로딩 중...
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- 통계 정보 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">통계 정보</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>티켓 ID:</span>
                        <strong>#{{ $support->id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>조회수:</span>
                        <strong>{{ $support->views ?? 0 }}</strong>
                    </div>
                    @if($support->resolved_at)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>해결일:</span>
                        <strong>{{ \Carbon\Carbon::parse($support->resolved_at)->format('Y-m-d') }}</strong>
                    </div>
                    @endif
                    @if($support->created_at && $support->resolved_at)
                    <div class="d-flex justify-content-between align-items-center">
                        <span>처리 시간:</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($support->created_at)->diffInHours(\Carbon\Carbon::parse($support->resolved_at)) }}시간
                        </strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 관련 정보 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">관련 정보</h4>
                </div>
                <div class="card-body">
                    @if($support->user)
                    <div class="mb-3">
                        <strong>사용자 정보:</strong>
                        <div class="mt-2">
                            <div>이름: {{ $support->user->name }}</div>
                            <div>이메일: {{ $support->user->email }}</div>
                            @if($support->user->phone)
                            <div>전화번호: {{ $support->user->phone }}</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($support->user_agent)
                    <div class="mb-3">
                        <strong>브라우저 정보:</strong>
                        <div class="mt-2">
                            <small class="text-muted">{{ $support->user_agent }}</small>
                        </div>
                    </div>
                    @endif

                    @if($support->ip_address)
                    <div class="mb-3">
                        <strong>IP 주소:</strong>
                        <div class="mt-2">
                            <code>{{ $support->ip_address }}</code>
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
                <h5 class="modal-title" id="deleteModalLabel">삭제 확인</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                이 지원 요청을 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form method="POST" action="{{ route('admin.cms.support.requests.delete', $support->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 답변 수정 모달 -->
<div class="modal fade" id="editReplyModal" tabindex="-1" aria-labelledby="editReplyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReplyModalLabel">답변 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editReplyForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editReplyContent" class="form-label">답변 내용 <span class="text-danger">*</span></label>
                        <textarea id="editReplyContent" name="content" class="form-control" rows="8" required></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <!-- 실제 전송될 값 -->
                            <input type="hidden" id="editIsPrivateHidden" name="is_private" value="1">
                            <!-- UI 체크박스 -->
                            <input class="form-check-input" type="checkbox" id="editIsPublic" onchange="toggleEditPrivacy()">
                            <label class="form-check-label" for="editIsPublic">
                                <i class="fe fe-eye me-1"></i>고객에게 공개
                            </label>
                            <small class="form-text text-muted d-block">체크하지 않으면 내부 메모로 저장됩니다.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i>저장
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 관리자 할당 모달 -->
<div class="modal fade" id="assignAdminModal" tabindex="-1" aria-labelledby="assignAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignAdminModalLabel">관리자 할당</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignAdminForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assigneeSelect" class="form-label">관리자 선택 <span class="text-danger">*</span></label>
                        <select id="assigneeSelect" name="assignee_id" class="form-select" required>
                            <option value="">관리자를 선택하세요</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="roleSelect" class="form-label">역할 <span class="text-danger">*</span></label>
                        <select id="roleSelect" name="role" class="form-select" required>
                            <option value="primary">주담당자</option>
                            <option value="secondary" selected>부담당자</option>
                        </select>
                        <small class="form-text text-muted">주담당자는 1명만 지정할 수 있습니다.</small>
                    </div>

                    <div class="mb-3">
                        <label for="assignmentNote" class="form-label">메모</label>
                        <textarea id="assignmentNote" name="note" class="form-control" rows="3" placeholder="할당 사유나 특별한 지시사항을 입력하세요..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-user-plus me-1"></i>할당
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 상태 변경 모달 -->
<div class="modal fade" id="statusChangeModal" tabindex="-1" aria-labelledby="statusChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusChangeModalLabel">상태 변경</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusChangeForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">변경할 상태</label>
                        <div id="statusChangeInfo" class="alert alert-info">
                            <!-- 상태 변경 정보가 동적으로 설정됩니다 -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="statusChangeNote" class="form-label">메모</label>
                        <textarea id="statusChangeNote" name="note" class="form-control" rows="4" placeholder="상태 변경 사유나 추가 정보를 입력하세요..."></textarea>
                        <small class="form-text text-muted">이 메모는 시스템 로그에 기록됩니다.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary" id="statusChangeSubmitBtn">
                        <i class="fe fe-check me-1"></i>상태 변경
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 평가 작성 모달 -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluationModalLabel">지원 서비스 평가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="evaluationForm">
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="evaluatedAdminSelect" class="form-label">평가할 관리자 <span class="text-danger">*</span></label>
                        <select id="evaluatedAdminSelect" name="evaluated_admin_id" class="form-select" required>
                            <option value="">관리자를 선택하세요</option>
                        </select>
                        <small class="form-text text-muted">답변을 작성한 관리자만 평가할 수 있습니다.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">전체 만족도 <span class="text-danger">*</span></label>
                        <div class="rating-container mb-2">
                            <div class="d-flex align-items-center">
                                <div class="rating-stars me-3">
                                    <i class="rating-star far fa-star" data-rating="1"></i>
                                    <i class="rating-star far fa-star" data-rating="2"></i>
                                    <i class="rating-star far fa-star" data-rating="3"></i>
                                    <i class="rating-star far fa-star" data-rating="4"></i>
                                    <i class="rating-star far fa-star" data-rating="5"></i>
                                </div>
                                <span id="ratingLabel" class="text-muted">평점을 선택하세요</span>
                            </div>
                        </div>
                        <input type="hidden" id="ratingInput" name="rating" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">세부 평가 (선택)</label>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">응답 속도</label>
                                <select name="criteria_scores[response_speed]" class="form-select form-select-sm">
                                    <option value="">평가 안함</option>
                                    <option value="1">매우 느림</option>
                                    <option value="2">느림</option>
                                    <option value="3">보통</option>
                                    <option value="4">빠름</option>
                                    <option value="5">매우 빠름</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">해결 능력</label>
                                <select name="criteria_scores[problem_solving]" class="form-select form-select-sm">
                                    <option value="">평가 안함</option>
                                    <option value="1">매우 부족</option>
                                    <option value="2">부족</option>
                                    <option value="3">보통</option>
                                    <option value="4">좋음</option>
                                    <option value="5">매우 좋음</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">친절도</label>
                                <select name="criteria_scores[kindness]" class="form-select form-select-sm">
                                    <option value="">평가 안함</option>
                                    <option value="1">매우 불친절</option>
                                    <option value="2">불친절</option>
                                    <option value="3">보통</option>
                                    <option value="4">친절</option>
                                    <option value="5">매우 친절</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small">전문성</label>
                                <select name="criteria_scores[expertise]" class="form-select form-select-sm">
                                    <option value="">평가 안함</option>
                                    <option value="1">매우 부족</option>
                                    <option value="2">부족</option>
                                    <option value="3">보통</option>
                                    <option value="4">전문적</option>
                                    <option value="5">매우 전문적</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="evaluationComment" class="form-label">추가 의견</label>
                        <textarea id="evaluationComment" name="comment" class="form-control" rows="4" placeholder="서비스에 대한 추가 의견이나 개선사항을 입력해주세요..."></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isAnonymous" name="is_anonymous" value="1">
                            <label class="form-check-label" for="isAnonymous">
                                익명으로 평가하기
                            </label>
                            <small class="form-text text-muted d-block">체크하면 관리자에게 평가자 이름이 표시되지 않습니다.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-star me-1"></i>평가 제출
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF 토큰 설정
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function updateStatus(status) {
    if (confirm('상태를 변경하시겠습니까?')) {
        // 상태 변경 버튼 비활성화
        const buttons = document.querySelectorAll('button[onclick^="updateStatus"]');
        buttons.forEach(btn => btn.disabled = true);

        fetch(`{{ route('admin.cms.support.requests.updateStatus', $support->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 성공 메시지 표시
                alert(data.message);
                // 페이지 새로고침하여 변경된 상태 반영
                window.location.reload();
            } else {
                alert('오류: ' + data.message);
                // 버튼 다시 활성화
                buttons.forEach(btn => btn.disabled = false);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('상태 변경 중 오류가 발생했습니다.');
            // 버튼 다시 활성화
            buttons.forEach(btn => btn.disabled = false);
        });
    }
}

function deleteSupport() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// 답변 기능
document.addEventListener('DOMContentLoaded', function() {
    const replyForm = document.getElementById('reply-form');
    if (replyForm) {
        replyForm.addEventListener('submit', handleReplySubmit);
    }
});

function handleReplySubmit(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    // 버튼 비활성화 및 로딩 표시
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>전송 중...';

    fetch(`{{ route('admin.cms.support.requests.reply.store', $support->id) }}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시
            showAlert('답변이 저장되었습니다.', 'success');

            // 폼 초기화
            form.reset();

            // 답변 목록 새로고침
            refreshReplies();

            // 자동 해결완료 처리가 체크되어 있으면 상태 변경
            if (formData.get('auto_resolve')) {
                updateStatus('resolved');
            } else {
                // 페이지 새로고침
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('답변 저장 중 오류가 발생했습니다.', 'error');
    })
    .finally(() => {
        // 버튼 복원
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function refreshReplies() {
    fetch(`{{ route('admin.cms.support.requests.reply.list', $support->id) }}`, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateRepliesContainer(data.replies);
        }
    })
    .catch(error => {
        console.error('Error refreshing replies:', error);
    });
}

function updateRepliesContainer(replies) {
    const container = document.getElementById('replies-container');
    if (!container) return;

    if (replies.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fe fe-message-circle fs-3 mb-2"></i>
                <p>아직 답변이 없습니다.</p>
            </div>
        `;
        return;
    }

    let html = '';
    replies.forEach(reply => {
        const isAdmin = reply.sender_type === 'admin';
        const isOwner = reply.user_id === {{ auth()->id() ?? 'null' }};
        const createdAt = new Date(reply.created_at).toLocaleString('ko-KR');

        html += `
            <div class="reply-item border-bottom pb-3 mb-3" data-reply-id="${reply.id}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center">
                        <span class="badge ${isAdmin ? 'bg-success' : 'bg-info'} me-2">
                            ${isAdmin ? '관리자' : '고객'}
                        </span>
                        ${reply.is_private ? '<span class="badge bg-warning me-2"><i class="fe fe-lock me-1"></i>내부메모</span>' : ''}
                        <strong>${reply.user ? reply.user.name : '알 수 없음'}</strong>
                        <small class="text-muted ms-2">${createdAt}</small>
                    </div>
                    ${isOwner ? `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                <i class="fe fe-more-horizontal"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editReply(${reply.id})">수정</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteReply(${reply.id})">삭제</a></li>
                            </ul>
                        </div>
                    ` : ''}
                </div>
                <div class="reply-content content-area">
                    ${reply.content.replace(/\n/g, '<br>')}
                </div>
                ${reply.attachments && reply.attachments.length > 0 ? `
                    <div class="reply-attachments mt-2">
                        <small class="text-muted">첨부파일:</small>
                        ${reply.attachments.map((attachment, index) => `
                            <div class="d-inline-block me-2">
                                <a href="/admin/cms/support/requests/${reply.support_id}/replies/${reply.id}/download/${index}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fe fe-paperclip me-1"></i>${attachment.name}
                                </a>
                            </div>
                        `).join('')}
                    </div>
                ` : ''}
            </div>
        `;
    });

    container.innerHTML = html;
}

function editReply(replyId) {
    // 답변 수정 기능 (추후 구현)
    showAlert('답변 수정 기능은 준비 중입니다.', 'info');
}

function deleteReply(replyId) {
    if (!confirm('이 답변을 삭제하시겠습니까?')) {
        return;
    }

    fetch(`{{ route('admin.cms.support.requests.show', $support->id) }}/replies/${replyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('답변이 삭제되었습니다.', 'success');

            // 해당 답변 요소 제거
            const replyElement = document.querySelector(`[data-reply-id="${replyId}"]`);
            if (replyElement) {
                replyElement.remove();
            }
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('답변 삭제 중 오류가 발생했습니다.', 'error');
    });
}

function previewReply() {
    const content = document.getElementById('content').value;
    if (!content.trim()) {
        showAlert('답변 내용을 입력해주세요.', 'warning');
        return;
    }

    // 미리보기 모달 표시
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">답변 미리보기</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="content-area">
                        ${content.replace(/\n/g, '<br>')}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();

    // 모달 닫힌 후 DOM에서 제거
    modal.addEventListener('hidden.bs.modal', () => {
        document.body.removeChild(modal);
    });
}

function showAlert(message, type = 'info') {
    // Bootstrap Alert 생성
    const alertClass = {
        success: 'alert-success',
        error: 'alert-danger',
        warning: 'alert-warning',
        info: 'alert-info'
    }[type] || 'alert-info';

    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // 기존 알림 제거
    const existingAlerts = document.querySelectorAll('.alert.position-fixed');
    existingAlerts.forEach(alert => alert.remove());

    // 새 알림 추가
    document.body.insertAdjacentHTML('beforeend', alertHtml);

    // 3초 후 자동 제거
    setTimeout(() => {
        const alert = document.querySelector('.alert.position-fixed');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}

// 답변 수정 모달 열기
function editReply(replyId) {
    // 해당 답변 데이터 찾기
    const replyElement = document.querySelector(`[data-reply-id="${replyId}"]`);
    if (!replyElement) {
        showAlert('답변을 찾을 수 없습니다.', 'error');
        return;
    }

    // 답변 내용과 비공개 여부 가져오기
    const contentElement = replyElement.querySelector('.reply-content');
    const isPrivate = replyElement.querySelector('.badge.bg-warning') !== null;

    if (!contentElement) {
        showAlert('답변 내용을 찾을 수 없습니다.', 'error');
        return;
    }

    // 모달 폼에 데이터 설정
    document.getElementById('editReplyContent').value = contentElement.textContent.trim();
    document.getElementById('editIsPublic').checked = !isPrivate;
    document.getElementById('editIsPrivateHidden').value = isPrivate ? '1' : '0';

    // 모달에 답변 ID 저장
    document.getElementById('editReplyForm').dataset.replyId = replyId;

    // 플레이스홀더 업데이트
    toggleEditPrivacy();

    // 모달 열기
    const modal = new bootstrap.Modal(document.getElementById('editReplyModal'));
    modal.show();
}

// 수정 모달 공개/비공개 토글 함수
function toggleEditPrivacy() {
    const publicCheckbox = document.getElementById('editIsPublic');
    const privateHidden = document.getElementById('editIsPrivateHidden');
    const contentTextarea = document.getElementById('editReplyContent');

    if (publicCheckbox.checked) {
        // 고객에게 공개
        privateHidden.value = '0';
        contentTextarea.placeholder = '고객에게 전달할 답변을 작성해주세요...';
    } else {
        // 내부 메모 (기본값)
        privateHidden.value = '1';
        contentTextarea.placeholder = '내부 메모를 작성해주세요... (고객에게 공개하려면 아래 체크박스를 선택하세요)';
    }
}

// 답변 수정 폼 제출
document.addEventListener('DOMContentLoaded', function() {
    const editReplyForm = document.getElementById('editReplyForm');
    if (editReplyForm) {
        editReplyForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const replyId = this.dataset.replyId;
            if (!replyId) {
                showAlert('답변 ID를 찾을 수 없습니다.', 'error');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = '수정 중...';

            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            fetch(`/admin/cms/support/requests/{{ $support->id }}/replies/${replyId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');

                    // 모달 닫기
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editReplyModal'));
                    modal.hide();

                    // 페이지 새로고침하여 업데이트된 내용 반영
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || '답변 수정에 실패했습니다.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('답변 수정 중 오류가 발생했습니다.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});

// 공개/비공개 토글 함수
function togglePrivacy() {
    const publicCheckbox = document.getElementById('is_public');
    const privateHidden = document.getElementById('is_private_hidden');
    const contentTextarea = document.getElementById('content');

    if (publicCheckbox.checked) {
        // 고객에게 공개
        privateHidden.value = '0';
        contentTextarea.placeholder = '고객에게 전달할 답변을 작성해주세요...';
    } else {
        // 내부 메모 (기본값)
        privateHidden.value = '1';
        contentTextarea.placeholder = '내부 메모를 작성해주세요... (고객에게 공개하려면 아래 체크박스를 선택하세요)';
    }
}

// ========== 다중 관리자 할당 기능 ==========

// 페이지 로드 시 할당된 관리자 목록 로드
document.addEventListener('DOMContentLoaded', function() {
    loadAssignedAdmins();
});

// 할당된 관리자 목록 로드
function loadAssignedAdmins() {
    const container = document.getElementById('assignedAdminsContainer');

    fetch(`/admin/cms/support/requests/{{ $support->id }}/multiple-assignments`, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayAssignedAdmins(data.assignments);
        } else {
            container.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="fe fe-alert-circle"></i>
                    <p class="mb-0">${data.message}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading assignments:', error);
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="fe fe-alert-circle"></i>
                <p class="mb-0">할당 목록을 불러오는 중 오류가 발생했습니다.</p>
            </div>
        `;
    });
}

// 할당된 관리자 목록 표시
function displayAssignedAdmins(assignments) {
    const container = document.getElementById('assignedAdminsContainer');

    if (assignments.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="fe fe-user-x"></i>
                <p class="mb-0">할당된 관리자가 없습니다.</p>
            </div>
        `;
        return;
    }

    let html = '';
    assignments.forEach(assignment => {
        const isPrimary = assignment.role === 'primary';
        const badgeClass = isPrimary ? 'bg-primary' : 'bg-secondary';

        html += `
            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                <div>
                    <div class="d-flex align-items-center">
                        <span class="badge ${badgeClass} me-2">${assignment.role_label}</span>
                        <strong>${assignment.assignee.name}</strong>
                    </div>
                    <small class="text-muted">${assignment.assignee.email}</small>
                    ${assignment.note ? `<br><small class="text-muted">메모: ${assignment.note}</small>` : ''}
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                        <i class="fe fe-more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="changeAdminRole(${assignment.id}, '${assignment.role === 'primary' ? 'secondary' : 'primary'}')">
                            ${assignment.role === 'primary' ? '부담당자로 변경' : '주담당자로 승격'}
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="removeAdminAssignment(${assignment.id})">할당 해제</a></li>
                    </ul>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

// 관리자 할당 모달 표시
function showAssignAdminModal() {
    // 사용 가능한 관리자 목록 로드
    loadAvailableAdmins();

    const modal = new bootstrap.Modal(document.getElementById('assignAdminModal'));
    modal.show();
}

// 사용 가능한 관리자 목록 로드
function loadAvailableAdmins() {
    const select = document.getElementById('assigneeSelect');

    // 로딩 상태 표시
    select.innerHTML = '<option value="">로딩 중...</option>';

    fetch(`/admin/cms/support/requests/{{ $support->id }}/multiple-assignments/available-admins`, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            select.innerHTML = '<option value="">관리자를 선택하세요</option>';
            data.admins.forEach(admin => {
                select.innerHTML += `<option value="${admin.id}">${admin.name} (${admin.email})</option>`;
            });
        } else {
            select.innerHTML = '<option value="">사용 가능한 관리자가 없습니다</option>';
        }
    })
    .catch(error => {
        console.error('Error loading available admins:', error);
        select.innerHTML = '<option value="">관리자 목록 로드 실패</option>';
    });
}

// 관리자 할당 폼 제출
document.addEventListener('DOMContentLoaded', function() {
    const assignAdminForm = document.getElementById('assignAdminForm');
    if (assignAdminForm) {
        assignAdminForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>할당 중...';

            const formData = new FormData(this);

            fetch(`/admin/cms/support/requests/{{ $support->id }}/multiple-assignments`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');

                    // 모달 닫기
                    const modal = bootstrap.Modal.getInstance(document.getElementById('assignAdminModal'));
                    modal.hide();

                    // 폼 초기화
                    this.reset();

                    // 할당 목록 새로고침
                    loadAssignedAdmins();
                } else {
                    showAlert(data.message || '할당에 실패했습니다.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('할당 중 오류가 발생했습니다.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});

// 관리자 역할 변경
function changeAdminRole(assignmentId, newRole) {
    if (!confirm(`정말로 역할을 ${newRole === 'primary' ? '주담당자' : '부담당자'}로 변경하시겠습니까?`)) {
        return;
    }

    fetch(`/admin/cms/support/requests/{{ $support->id }}/multiple-assignments/${assignmentId}/role`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ role: newRole })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            loadAssignedAdmins();
        } else {
            showAlert(data.message || '역할 변경에 실패했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('역할 변경 중 오류가 발생했습니다.', 'error');
    });
}

// 관리자 할당 해제
function removeAdminAssignment(assignmentId) {
    if (!confirm('정말로 이 관리자의 할당을 해제하시겠습니까?')) {
        return;
    }

    fetch(`/admin/cms/support/requests/{{ $support->id }}/multiple-assignments/${assignmentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            loadAssignedAdmins();
        } else {
            showAlert(data.message || '할당 해제에 실패했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('할당 해제 중 오류가 발생했습니다.', 'error');
    });
}

// ========== 상태 변경 기능 ==========

// 간단한 상태 변경 (메모 불필요)
function changeStatus(status) {
    if (!confirm(`정말로 상태를 변경하시겠습니까?`)) {
        return;
    }

    fetch(`/admin/cms/support/requests/{{ $support->id }}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showAlert(data.message || '상태 변경에 실패했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('상태 변경 중 오류가 발생했습니다.', 'error');
    });
}

// 상태 변경 모달 표시 (메모 필요)
function showStatusChangeModal(status) {
    const statusInfo = document.getElementById('statusChangeInfo');
    const submitBtn = document.getElementById('statusChangeSubmitBtn');
    const form = document.getElementById('statusChangeForm');

    // 상태별 정보 설정
    const statusConfig = {
        'closed': {
            title: '종료',
            message: '이 지원 요청을 종료합니다. 종료된 요청은 재오픈할 수 있습니다.',
            class: 'alert-warning',
            btnText: '종료',
            btnClass: 'btn-secondary'
        },
        'reopened': {
            title: '재오픈',
            message: '이 지원 요청을 재오픈하여 진행중 상태로 변경합니다.',
            class: 'alert-success',
            btnText: '재오픈',
            btnClass: 'btn-warning'
        }
    };

    const config = statusConfig[status];
    if (!config) return;

    // 모달 제목 설정
    document.getElementById('statusChangeModalLabel').textContent = `${config.title} 확인`;

    // 상태 정보 표시
    statusInfo.className = `alert ${config.class}`;
    statusInfo.textContent = config.message;

    // 버튼 설정
    submitBtn.className = `btn ${config.btnClass}`;
    submitBtn.innerHTML = `<i class="fe fe-check me-1"></i>${config.btnText}`;

    // 폼에 상태 저장
    form.dataset.status = status;

    // 메모 초기화
    document.getElementById('statusChangeNote').value = '';

    // 모달 표시
    const modal = new bootstrap.Modal(document.getElementById('statusChangeModal'));
    modal.show();
}

// 상태 변경 폼 제출
document.addEventListener('DOMContentLoaded', function() {
    const statusChangeForm = document.getElementById('statusChangeForm');
    if (statusChangeForm) {
        statusChangeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const status = this.dataset.status;
            if (!status) return;

            const submitBtn = document.getElementById('statusChangeSubmitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>처리 중...';

            const formData = new FormData(this);
            formData.append('status', status);

            fetch(`/admin/cms/support/requests/{{ $support->id }}/update-status`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');

                    // 모달 닫기
                    const modal = bootstrap.Modal.getInstance(document.getElementById('statusChangeModal'));
                    modal.hide();

                    // 페이지 새로고침
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || '상태 변경에 실패했습니다.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('상태 변경 중 오류가 발생했습니다.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});

// 기존 updateStatus 함수 (호환성 유지)
function updateStatus(status) {
    changeStatus(status);
}

// ========== 평가 시스템 ==========

// 페이지 로드 시 평가 목록 로드 (완료/종료된 지원만)
document.addEventListener('DOMContentLoaded', function() {
    @if(in_array($support->status, ['resolved', 'closed']))
    loadEvaluations();
    @endif
});

// 평가 목록 로드
function loadEvaluations() {
    const container = document.getElementById('evaluationsContainer');
    if (!container) return;

    fetch(`/admin/cms/support/requests/{{ $support->id }}/evaluations`, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayEvaluations(data.evaluations);
        } else {
            container.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="fe fe-alert-circle"></i>
                    <p class="mb-0">${data.message}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading evaluations:', error);
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="fe fe-alert-circle"></i>
                <p class="mb-0">평가 목록을 불러오는 중 오류가 발생했습니다.</p>
            </div>
        `;
    });
}

// 평가 목록 표시
function displayEvaluations(evaluations) {
    const container = document.getElementById('evaluationsContainer');

    if (evaluations.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-3">
                <i class="fe fe-star"></i>
                <p class="mb-0">아직 평가가 없습니다.</p>
            </div>
        `;
        return;
    }

    let html = '';
    evaluations.forEach(evaluation => {
        html += `
            <div class="evaluation-item border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="d-flex align-items-center mb-1">
                            <strong class="me-2">${evaluation.evaluated_admin.name}</strong>
                            <span class="badge ${evaluation.rating_class}">${evaluation.rating_label}</span>
                        </div>
                        <div class="stars mb-1">${evaluation.stars_html}</div>
                        <small class="text-muted">
                            평가자: ${typeof evaluation.evaluator === 'string' ? evaluation.evaluator : evaluation.evaluator.name} |
                            ${evaluation.created_at}
                        </small>
                    </div>
                </div>
                ${evaluation.comment ? `
                    <div class="evaluation-comment mt-2">
                        <small class="text-muted">"${evaluation.comment}"</small>
                    </div>
                ` : ''}
                ${evaluation.criteria_scores ? `
                    <div class="criteria-scores mt-2">
                        <small class="text-muted">세부 평가: </small>
                        ${Object.entries(evaluation.criteria_scores).map(([key, score]) => {
                            const labels = {
                                'response_speed': '응답속도',
                                'problem_solving': '해결능력',
                                'kindness': '친절도',
                                'expertise': '전문성'
                            };
                            return `<span class="badge bg-light text-dark me-1">${labels[key] || key}: ${score}점</span>`;
                        }).join('')}
                    </div>
                ` : ''}
            </div>
        `;
    });

    container.innerHTML = html;
}

// 평가 모달 표시
function showEvaluationModal() {
    // 평가할 관리자 목록 로드
    loadEvaluationAdmins();

    // 별점 초기화
    resetRatingStars();

    // 폼 초기화
    document.getElementById('evaluationForm').reset();

    const modal = new bootstrap.Modal(document.getElementById('evaluationModal'));
    modal.show();
}

// 평가할 관리자 목록 로드
function loadEvaluationAdmins() {
    const select = document.getElementById('evaluatedAdminSelect');
    select.innerHTML = '<option value="">로딩 중...</option>';

    // 답변을 작성한 관리자들 조회 (replies에서 admin 유형만)
    const adminReplies = Array.from(document.querySelectorAll('[data-reply-id]'))
        .filter(el => el.querySelector('.badge.bg-success')) // 관리자 뱃지가 있는 답변
        .map(el => {
            const adminName = el.querySelector('strong').textContent.trim();
            // 실제로는 서버에서 관리자 정보를 가져와야 하지만, 여기서는 간단히 처리
            return { name: adminName };
        });

    // 중복 제거
    const uniqueAdmins = adminReplies.filter((admin, index, self) =>
        index === self.findIndex(a => a.name === admin.name)
    );

    if (uniqueAdmins.length === 0) {
        select.innerHTML = '<option value="">평가할 수 있는 관리자가 없습니다</option>';
        return;
    }

    select.innerHTML = '<option value="">관리자를 선택하세요</option>';
    uniqueAdmins.forEach((admin, index) => {
        // 실제로는 admin.id를 사용해야 하지만, 데모를 위해 index 사용
        select.innerHTML += `<option value="${index + 1}">${admin.name}</option>`;
    });
}

// 별점 시스템 초기화
function resetRatingStars() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('ratingInput');
    const ratingLabel = document.getElementById('ratingLabel');

    stars.forEach(star => {
        star.className = 'rating-star far fa-star';
        star.style.color = '#ddd';
        star.style.cursor = 'pointer';
    });

    ratingInput.value = '';
    ratingLabel.textContent = '평점을 선택하세요';

    // 별점 클릭 이벤트
    stars.forEach(star => {
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
}

// 별점 설정
function setRating(rating) {
    const ratingInput = document.getElementById('ratingInput');
    const ratingLabel = document.getElementById('ratingLabel');

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

// 별 하이라이트
function highlightStars(rating) {
    const stars = document.querySelectorAll('.rating-star');
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

// 평가 폼 제출
document.addEventListener('DOMContentLoaded', function() {
    const evaluationForm = document.getElementById('evaluationForm');
    if (evaluationForm) {
        evaluationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>제출 중...';

            const formData = new FormData(this);

            fetch(`/admin/cms/support/requests/{{ $support->id }}/evaluations`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');

                    // 모달 닫기
                    const modal = bootstrap.Modal.getInstance(document.getElementById('evaluationModal'));
                    modal.hide();

                    // 평가 목록 새로고침
                    loadEvaluations();

                    // 평가 버튼 숨기기 (이미 평가했으므로)
                    const evaluateBtn = document.querySelector('[onclick="showEvaluationModal()"]');
                    if (evaluateBtn) {
                        evaluateBtn.style.display = 'none';
                    }
                } else {
                    showAlert(data.message || '평가 제출에 실패했습니다.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('평가 제출 중 오류가 발생했습니다.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});
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

/* 평가 시스템 스타일 */
.rating-stars {
    font-size: 1.5rem;
}

.rating-star {
    margin-right: 0.25rem;
    transition: color 0.2s ease;
}

.rating-star:hover {
    color: #ffc107 !important;
}

.evaluation-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

.stars {
    font-size: 1rem;
}

.stars i {
    margin-right: 0.1rem;
}
</style>
@endpush
