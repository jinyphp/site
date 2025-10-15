@extends('jiny-site::layouts.app')

@section('title', $event->title . ' - 참여 신청')

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
            <li class="breadcrumb-item">
                <a href="{{ route('event.show', $event->id) }}" class="text-decoration-none">
                    {{ Str::limit($event->title, 30) }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">참여 신청</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- 이벤트 정보 카드 -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        @if($event->image)
                        <img src="{{ $event->image }}"
                             alt="{{ $event->title }}"
                             class="rounded me-3"
                             style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                             style="width: 100px; height: 100px;">
                            <i class="bi bi-calendar-event text-muted" style="font-size: 2rem;"></i>
                        </div>
                        @endif

                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ $event->title }}</h4>
                            @if($event->description)
                            <p class="text-muted mb-2">{{ Str::limit($event->description, 150) }}</p>
                            @endif
                            <div class="small text-muted">
                                <i class="bi bi-calendar me-1"></i>{{ $event->created_at->format('Y년 m월 d일') }}
                                @if($event->manager)
                                <span class="mx-2">|</span>
                                <i class="bi bi-person me-1"></i>{{ $event->manager }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 참여 신청 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>이벤트 참여 신청
                    </h5>
                </div>
                <div class="card-body">
                    @if($event->participation_description)
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>{{ $event->participation_description }}
                    </div>
                    @endif

                    <!-- 참여 현황 정보 -->
                    <div class="row mb-4">
                        @if($event->max_participants)
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-0">{{ $event->approvedParticipants()->count() }}/{{ $event->max_participants }}</div>
                                <small class="text-muted">참여자 수</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-0 text-primary">{{ $event->getRemainingSpots() }}</div>
                                <small class="text-muted">남은 자리</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-0 text-success">{{ number_format($event->getParticipationRate(), 1) }}%</div>
                                <small class="text-muted">참여율</small>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-0">{{ $event->approvedParticipants()->count() }}</div>
                                <small class="text-muted">현재 참여자 수 (무제한)</small>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($event->participation_end_date)
                    <div class="alert alert-warning">
                        <i class="bi bi-clock me-2"></i>
                        <strong>신청 마감:</strong> {{ $event->participation_end_date->format('Y년 m월 d일 H:i') }}
                    </div>
                    @endif

                    <form action="{{ route('event.participate.store', $event->id) }}" method="POST" id="participationForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', auth()->user()->name ?? '') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', auth()->user()->email ?? '') }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">참여 관련 안내를 받을 이메일 주소입니다.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">전화번호</label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="예: 010-1234-5678">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">선택사항입니다. 긴급 연락용으로 사용됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">참여 메시지</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message"
                                      name="message"
                                      rows="4"
                                      placeholder="이벤트 참여에 대한 메시지나 질문이 있으시면 적어주세요.">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">최대 1000자까지 입력 가능합니다.</div>
                        </div>

                        <!-- 약관 동의 -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input custom-checkbox @error('agree_terms') is-invalid @enderror"
                                       type="checkbox"
                                       id="agree_terms"
                                       name="agree_terms"
                                       value="1"
                                       {{ old('agree_terms') ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label" for="agree_terms">
                                    개인정보 수집 및 이용에 동의합니다. <span class="text-danger">*</span>
                                </label>
                                @error('agree_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text mt-2">
                                <small class="text-muted">
                                    • 수집 목적: 이벤트 참여 관리 및 안내<br>
                                    • 수집 항목: 이름, 이메일, 전화번호(선택), 참여 메시지<br>
                                    • 보관 기간: 이벤트 종료 후 1년
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('event.show', $event->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-person-plus me-2"></i>참여 신청하기
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 참여 안내 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>참여 안내
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>승인 방식</h6>
                        <p class="small text-muted mb-3">
                            @if($event->approval_type === 'auto')
                            <span class="badge bg-success">자동 승인</span><br>
                            신청과 동시에 참여가 확정됩니다.
                            @else
                            <span class="badge bg-warning">수동 승인</span><br>
                            관리자 승인 후 참여가 확정됩니다.
                            @endif
                        </p>
                    </div>

                    @if($event->participation_start_date || $event->participation_end_date)
                    <div class="mb-3">
                        <h6>신청 기간</h6>
                        <div class="small text-muted">
                            @if($event->participation_start_date)
                            <div><strong>시작:</strong> {{ $event->participation_start_date->format('Y년 m월 d일 H:i') }}</div>
                            @endif
                            @if($event->participation_end_date)
                            <div><strong>마감:</strong> {{ $event->participation_end_date->format('Y년 m월 d일 H:i') }}</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <h6>주의사항</h6>
                        <ul class="small text-muted mb-0">
                            <li>한 번 신청한 이메일로는 중복 신청이 불가능합니다.</li>
                            <li>잘못된 정보로 신청 시 참여가 제한될 수 있습니다.</li>
                            @if($event->max_participants)
                            <li>선착순으로 마감되며, 대기자 명단은 운영하지 않습니다.</li>
                            @endif
                        </ul>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>이벤트 상세보기
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('participationForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // 중복 제출 방지
        if (submitBtn.disabled) {
            e.preventDefault();
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>신청 중...';

        // 3초 후 다시 활성화 (오류 발생 시를 대비)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i>참여 신청하기';
        }, 3000);
    });

    // 실시간 글자 수 카운터
    const messageTextarea = document.getElementById('message');
    if (messageTextarea) {
        const charCounter = document.createElement('div');
        charCounter.className = 'form-text text-end';
        charCounter.innerHTML = '<span id="charCount">0</span>/1000';
        messageTextarea.parentElement.appendChild(charCounter);

        messageTextarea.addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('charCount').textContent = count;

            if (count > 1000) {
                charCounter.classList.add('text-danger');
            } else {
                charCounter.classList.remove('text-danger');
            }
        });

        // 초기 글자 수 표시
        messageTextarea.dispatchEvent(new Event('input'));
    }
});
</script>
@endpush

@push('styles')
<style>
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

/* Bootstrap 스타일 체크박스 커스텀 */
.custom-checkbox {
    width: 1em;
    height: 1em;
    margin-top: 0.25em;
    vertical-align: top;
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 1px solid #dee2e6;
    border-radius: 0.25em;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.custom-checkbox:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
}

.custom-checkbox:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.custom-checkbox:checked:focus {
    border-color: #0a58ca;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.custom-checkbox:indeterminate {
    background-color: #0d6efd;
    border-color: #0d6efd;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10h8'/%3e%3c/svg%3e");
}

.custom-checkbox:disabled {
    pointer-events: none;
    filter: none;
    opacity: 0.5;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
@endpush