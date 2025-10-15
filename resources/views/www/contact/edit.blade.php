@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '상담 요청 수정 - ' . $contact->contact_number)

@section('content')
<div class="container my-5">
    <!-- 브레드크럼 -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/" class="text-decoration-none">홈</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contact.create') }}" class="text-decoration-none">상담 요청</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('contact.show', $contact->contact_number) }}" class="text-decoration-none">{{ $contact->contact_number }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">수정</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- 페이지 헤더 -->
            <div class="mb-4">
                <h1 class="display-6 fw-bold mb-3">
                    <i class="bi bi-pencil me-2"></i>상담 요청 수정
                </h1>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">문의번호: {{ $contact->contact_number }}</span>
                    <span class="badge bg-{{ $contact->status_class }}">{{ $contact->status_text }}</span>
                    <span class="badge bg-{{ $contact->priority_class }}">{{ $contact->priority_text }}</span>
                </div>
            </div>

            <!-- 수정 알림 -->
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>수정 안내:</strong> 이미 처리가 시작된 상담의 경우 일부 내용만 수정 가능할 수 있습니다.
            </div>

            <!-- 상담 요청 수정 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots me-2"></i>상담 요청서 수정
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>입력 정보를 확인해주세요:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('contact.update', $contact->contact_number) }}" method="POST" id="contactForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- 상담 유형 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_type_id" class="form-label">
                                        상담 유형 <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('contact_type_id') is-invalid @enderror"
                                            id="contact_type_id" name="contact_type_id" required>
                                        <option value="">선택해주세요</option>
                                        @foreach($contactTypes as $type)
                                        <option value="{{ $type->id }}"
                                                {{ old('contact_type_id', $contact->contact_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('contact_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- 우선순위 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">우선순위</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="normal" {{ old('priority', $contact->priority) === 'normal' ? 'selected' : '' }}>보통</option>
                                        <option value="high" {{ old('priority', $contact->priority) === 'high' ? 'selected' : '' }}>높음</option>
                                        <option value="urgent" {{ old('priority', $contact->priority) === 'urgent' ? 'selected' : '' }}>긴급</option>
                                    </select>
                                    <div class="form-text">긴급한 문의인 경우 우선순위를 높여주세요.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- 이름 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        이름 <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $contact->name) }}"
                                           required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- 이메일 -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        이메일 <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $contact->email) }}"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">답변을 받을 이메일 주소입니다.</div>
                                </div>
                            </div>
                        </div>

                        <!-- 전화번호 -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">전화번호</label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $contact->phone) }}"
                                   placeholder="010-1234-5678">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">선택사항입니다. 긴급 연락 시 사용됩니다.</div>
                        </div>

                        <!-- 제목 -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                제목 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   id="subject"
                                   name="subject"
                                   value="{{ old('subject', $contact->subject) }}"
                                   required
                                   maxlength="255">
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 문의 내용 -->
                        <div class="mb-3">
                            <label for="message" class="form-label">
                                문의 내용 <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message"
                                      name="message"
                                      rows="8"
                                      required
                                      maxlength="5000"
                                      placeholder="문의하실 내용을 자세히 작성해 주세요.">{{ old('message', $contact->message) }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between">
                                <div class="form-text">최대 5,000자까지 입력 가능합니다.</div>
                                <div class="form-text text-end">
                                    <span id="charCount">0</span>/5,000
                                </div>
                            </div>
                        </div>

                        <!-- 공개 설정 -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_public"
                                       name="is_public"
                                       value="1"
                                       {{ old('is_public', $contact->is_public) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    상담 내용을 공개로 설정
                                </label>
                                <div class="form-text">
                                    다른 사용자들도 이 상담 내용과 답변을 볼 수 있습니다.
                                    개인정보가 포함된 경우 공개하지 마세요.
                                </div>
                            </div>
                        </div>

                        <!-- 수정 이력 안내 -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>수정 안내:</strong> 상담 내용을 수정하면 담당자에게 알림이 전송됩니다.
                            중요한 변경사항이 있을 경우 우선순위를 조정해 주세요.
                        </div>

                        <!-- 제출 버튼 -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('contact.show', $contact->contact_number) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-check-lg me-2"></i>수정 완료
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 원본 정보 참조 -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>원본 정보
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>최초 접수일:</strong> {{ $contact->created_at->format('Y년 m월 d일 H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>최근 수정일:</strong> {{ $contact->updated_at->format('Y년 m월 d일 H:i') }}
                        </div>
                    </div>
                    @if($contact->assignedUser)
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>담당자:</strong> {{ $contact->assignedUser->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>현재 상태:</strong>
                            <span class="badge bg-{{ $contact->status_class }}">{{ $contact->status_text }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');

    // 글자 수 카운터
    messageTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count;

        if (count > 5000) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    });

    // 초기 글자 수 표시
    messageTextarea.dispatchEvent(new Event('input'));

    // 폼 제출 시 중복 방지
    form.addEventListener('submit', function(e) {
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>수정 중...';

        // 5초 후 다시 활성화 (오류 발생 시를 대비)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>수정 완료';
        }, 5000);
    });

    // 페이지 이탈 경고
    let isFormDirty = false;
    const formElements = form.querySelectorAll('input, textarea, select');

    formElements.forEach(element => {
        element.addEventListener('change', () => {
            isFormDirty = true;
        });
    });

    form.addEventListener('submit', () => {
        isFormDirty = false;
    });

    window.addEventListener('beforeunload', (e) => {
        if (isFormDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.alert {
    border-left: 4px solid;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-info {
    border-left-color: #0dcaf0;
}
</style>
@endpush
