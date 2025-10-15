<div class="row">
    <div class="col-md-6">
        <h6 class="mb-3">기본 정보</h6>
        <table class="table table-borderless">
            <tr>
                <td width="30%" class="text-muted">이름:</td>
                <td><strong>{{ $participant->name }}</strong></td>
            </tr>
            <tr>
                <td class="text-muted">이메일:</td>
                <td>{{ $participant->email }}</td>
            </tr>
            <tr>
                <td class="text-muted">전화번호:</td>
                <td>{{ $participant->phone ?: '-' }}</td>
            </tr>
            <tr>
                <td class="text-muted">회원 여부:</td>
                <td>
                    @if($participant->user)
                        <span class="badge bg-info">회원 (ID: {{ $participant->user_id }})</span>
                    @else
                        <span class="badge bg-secondary">비회원</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-6">
        <h6 class="mb-3">참여 정보</h6>
        <table class="table table-borderless">
            <tr>
                <td width="30%" class="text-muted">상태:</td>
                <td>
                    <span class="badge bg-{{ $participant->status_class }}">
                        {{ $participant->status_text }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="text-muted">신청일:</td>
                <td>{{ $participant->applied_at ? $participant->applied_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <td class="text-muted">승인일:</td>
                <td>{{ $participant->approved_at ? $participant->approved_at->format('Y-m-d H:i:s') : '-' }}</td>
            </tr>
            <tr>
                <td class="text-muted">승인자:</td>
                <td>{{ $participant->approved_by ?: '-' }}</td>
            </tr>
        </table>
    </div>
</div>

@if($participant->message)
<div class="row">
    <div class="col-12">
        <h6 class="mb-3">신청 메시지</h6>
        <div class="bg-light p-3 rounded">
            <p class="mb-0">{{ $participant->message }}</p>
        </div>
    </div>
</div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <h6 class="mb-3">작업</h6>
        <div class="btn-group" role="group">
            @if($participant->status !== 'approved')
            <button type="button" class="btn btn-success"
                    onclick="approveParticipant({{ $participant->id }})">
                <i class="bi bi-check-circle me-1"></i>승인
            </button>
            @endif

            @if($participant->status !== 'rejected')
            <button type="button" class="btn btn-danger"
                    onclick="rejectParticipant({{ $participant->id }})">
                <i class="bi bi-x-circle me-1"></i>거부
            </button>
            @endif

            @if($participant->status !== 'cancelled')
            <button type="button" class="btn btn-warning"
                    onclick="cancelParticipant({{ $participant->id }})">
                <i class="bi bi-slash-circle me-1"></i>취소
            </button>
            @endif

            <button type="button" class="btn btn-outline-danger"
                    onclick="deleteParticipant({{ $participant->id }}, '{{ $participant->name }}')">
                <i class="fe fe-trash-2 me-1"></i>삭제
            </button>
        </div>
    </div>
</div>