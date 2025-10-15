@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '상담 요청')

@section('content')

<!-- container  -->
<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="offset-lg-2 col-lg-8 col-12">
                <div class="mb-8">
                    <!-- heading  -->
                    <h2 class="mb-4 h1 fw-semibold">상담 요청</h2>
                    <p class="lead">궁금한 사항이나 도움이 필요한 내용을 언제든지 문의해 주세요. 빠르게 답변드리겠습니다.</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>입력 정보를 확인해주세요:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Contact Form -->
                <form method="POST" action="{{ route('contact.store') }}" id="contactForm">
                    @csrf

                    <div class="row">
                        <!-- 상담 유형 -->
                        <div class="col-md-6 mb-3">
                            <label for="contact_type_id" class="form-label">상담 유형 <span class="text-danger">*</span></label>
                            <select class="form-select @error('contact_type_id') is-invalid @enderror"
                                    id="contact_type_id" name="contact_type_id" required>
                                <option value="">상담 유형을 선택하세요</option>
                                @foreach($contactTypes as $type)
                                <option value="{{ $type->id }}" {{ old('contact_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('contact_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 우선순위 -->
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">우선순위</label>
                            <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>보통</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>높음</option>
                                <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>긴급</option>
                            </select>
                            @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- 이름 -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 이메일 -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- 전화번호 -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">전화번호</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">선택사항입니다. 긴급 연락 시 사용됩니다.</div>
                    </div>

                    <!-- 제목 -->
                    <div class="mb-3">
                        <label for="subject" class="form-label">제목 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                               id="subject" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 내용 -->
                    <div class="mb-3">
                        <label for="message" class="form-label">내용 <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror"
                                  id="message" name="message" rows="6" required
                                  placeholder="문의하실 내용을 자세히 적어주세요. 구체적으로 작성해주시면 더 정확한 답변을 받으실 수 있습니다.">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" id="messageHelp">최대 5,000자까지 입력 가능합니다.</div>
                    </div>

                    <!-- 공개 설정 -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">
                                이 상담을 공개로 설정 (다른 사용자도 볼 수 있습니다)
                            </label>
                        </div>
                        <div class="form-text text-muted">
                            공개 설정 시 동일한 문의를 하는 다른 고객들에게도 도움이 될 수 있습니다.
                        </div>
                    </div>

                    <!-- 개인정보 동의 -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacy_agree" required>
                            <label class="form-check-label" for="privacy_agree">
                                개인정보 수집 및 이용에 동의합니다 <span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="form-text text-muted">
                            상담 처리 목적으로만 개인정보를 사용하며, 처리 완료 후 안전하게 폐기됩니다.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-arrow-left me-2"></i>목록으로
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-send me-2"></i>상담 요청 제출
                        </button>
                    </div>
                </form>

                @auth
                <hr class="my-5">
                <div class="text-center">
                    <h5 class="mb-3">내 상담 요청 확인</h5>
                    <p class="text-muted mb-3">이전에 제출한 상담 요청의 진행 상황을 확인하실 수 있습니다.</p>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fe fe-list me-2"></i>내 상담 요청 보기
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 메시지 길이 체크
    const messageTextarea = document.getElementById('message');
    const messageHelp = document.getElementById('messageHelp');
    const maxLength = 5000;

    messageTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;

        if (remaining < 100) {
            messageHelp.textContent = `남은 글자: ${remaining}자`;
            messageHelp.className = remaining < 0 ? 'form-text text-danger' : 'form-text text-warning';
        } else {
            messageHelp.textContent = '최대 5,000자까지 입력 가능합니다.';
            messageHelp.className = 'form-text';
        }
    });

    // 폼 제출 시 중복 제출 방지
    const form = document.getElementById('contactForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>처리 중...';

        // 10초 후 재활성화 (네트워크 오류 대비)
        setTimeout(function() {
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fe fe-send me-2"></i>상담 요청 제출';
        }, 10000);
    });
});
</script>
@endsection
