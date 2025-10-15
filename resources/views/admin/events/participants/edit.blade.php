@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $event->title . ' - 참여자 수정')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.site.event.index') }}">이벤트 관리</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.site.event.show', $event->id) }}">{{ $event->title }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.site.event.participants.index', $event->id) }}">참여자 관리</a>
                                    </li>
                                    <li class="breadcrumb-item active">참여자 수정</li>
                                </ol>
                            </nav>
                            <h1 class="page-header-title">
                                <i class="bi bi-person-gear me-2"></i>
                                참여자 정보 수정
                            </h1>
                            <p class="page-header-subtitle">{{ $participant->name }}님의 참여 정보를 수정합니다</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.site.event.participants.index', $event->id) }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>참여자 목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 알림 메시지 -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fe fe-alert-circle me-2"></i>입력 정보를 확인해주세요:
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- 이벤트 정보 카드 -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="text-muted mb-2">{{ $event->description }}</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-{{ $event->enable ? 'success' : 'secondary' }}">
                            {{ $event->enable ? '활성화' : '비활성화' }}
                        </span>
                        <span class="badge bg-info">{{ $event->status }}</span>
                        @if($event->allow_participation)
                        <span class="badge bg-success">참여신청 가능</span>
                        @if($event->approval_type === 'manual')
                        <span class="badge bg-warning text-dark">수동승인</span>
                        @endif
                        @else
                        <span class="badge bg-secondary">참여신청 불가</span>
                        @endif
                    </div>
                    @if($event->max_participants)
                    <div class="mt-2">
                        <small class="text-muted">
                            최대 참여 인원: {{ number_format($event->max_participants) }}명
                            (현재 승인됨: {{ number_format($event->approved_participants) }}명)
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 참여자 정보 수정 폼 -->
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">
                <i class="bi bi-person-gear me-2"></i>참여자 정보 수정
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.site.event.participants.update', [$event->id, $participant->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-4">기본 정보</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                이름 <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $participant->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                이메일 <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $participant->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                중복되지 않은 고유한 이메일이어야 합니다.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">전화번호</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $participant->phone) }}"
                                   placeholder="010-1234-5678">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($participant->user)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>회원 정보:</strong>
                            이 참여자는 회원입니다. (ID: {{ $participant->user_id }})
                        </div>
                        @else
                        <div class="alert alert-secondary">
                            <i class="bi bi-person me-2"></i>
                            <strong>비회원:</strong>
                            회원가입 없이 참여한 사용자입니다.
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-4">참여 설정</h6>

                        <div class="mb-3">
                            <label for="status" class="form-label">
                                참여 상태 <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status" name="status" required>
                                <option value="">선택하세요</option>
                                <option value="pending" {{ old('status', $participant->status) === 'pending' ? 'selected' : '' }}>
                                    대기중
                                </option>
                                <option value="approved" {{ old('status', $participant->status) === 'approved' ? 'selected' : '' }}>
                                    승인됨
                                </option>
                                <option value="rejected" {{ old('status', $participant->status) === 'rejected' ? 'selected' : '' }}>
                                    거부됨
                                </option>
                                <option value="cancelled" {{ old('status', $participant->status) === 'cancelled' ? 'selected' : '' }}>
                                    취소됨
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">신청 메시지</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message" name="message" rows="4"
                                      placeholder="참여 관련 메시지...">{{ old('message', $participant->message) }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 참여 이력 정보 -->
                        <div class="bg-light p-3 rounded">
                            <h6 class="mb-3">참여 이력</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">신청일:</small>
                                    <div>{{ $participant->applied_at ? $participant->applied_at->format('Y-m-d H:i') : '-' }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">승인일:</small>
                                    <div>{{ $participant->approved_at ? $participant->approved_at->format('Y-m-d H:i') : '-' }}</div>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted">승인자:</small>
                                    <div>{{ $participant->approved_by ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 알림 -->
                @if($event->max_participants && $event->approved_participants >= $event->max_participants && $participant->status !== 'approved')
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>주의:</strong> 현재 참여 인원이 제한({{ $event->max_participants }}명)에 도달했습니다.
                    '승인됨'으로 변경할 수 없습니다.
                </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.site.event.participants.index', $event->id) }}" class="btn btn-outline-secondary">
                        <i class="fe fe-x me-2"></i>취소
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>수정 완료
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const maxParticipants = {{ $event->max_participants ?: 'null' }};
    const currentApproved = {{ $event->approved_participants }};
    const originalStatus = '{{ $participant->status }}';

    statusSelect.addEventListener('change', function() {
        const approvedOption = this.querySelector('option[value="approved"]');

        if (maxParticipants && currentApproved >= maxParticipants && originalStatus !== 'approved') {
            if (this.value === 'approved') {
                alert('참여 인원이 제한을 초과하여 승인할 수 없습니다. 다른 상태를 선택해주세요.');
                this.value = originalStatus; // 원래 상태로 되돌림
            }
            approvedOption.disabled = true;
            approvedOption.textContent = '승인됨 (인원 초과로 불가)';
        } else {
            approvedOption.disabled = false;
            approvedOption.textContent = '승인됨';
        }
    });

    // 초기 로드 시에도 체크
    statusSelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
