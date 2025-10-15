@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '내 상담 목록')

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
            <li class="breadcrumb-item active" aria-current="page">내 상담 목록</li>
        </ol>
    </nav>

    <!-- 페이지 헤더 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-2">
                <i class="bi bi-list-check me-2"></i>내 상담 목록
            </h1>
            <p class="text-muted mb-0">총 {{ $contacts->total() }}건의 상담 요청이 있습니다.</p>
        </div>
        <a href="{{ route('contact.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>새 상담 요청
        </a>
    </div>

    <div class="row">
        <!-- 메인 콘텐츠 -->
        <div class="col-lg-8">
            <!-- 필터 -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="status" class="form-label">상태</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">전체</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>대기 중</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>처리 중</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>완료</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>취소</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">상담 유형</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">전체</option>
                                @foreach($contactTypes as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-funnel me-1"></i>필터
                                </button>
                                <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-1"></i>초기화
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 상담 목록 -->
            @if($contacts->count() > 0)
            <div class="row">
                @foreach($contacts as $contact)
                <div class="col-12 mb-3">
                    <div class="card contact-item">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="contact-icon">
                                            <i class="bi bi-chat-dots text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('contact.show', $contact->contact_number) }}"
                                                   class="text-decoration-none">
                                                    {{ $contact->subject }}
                                                </a>
                                            </h6>
                                            <div class="small text-muted mb-2">
                                                <span class="me-3">
                                                    <i class="bi bi-tag me-1"></i>{{ $contact->contactType->name }}
                                                </span>
                                                <span class="me-3">
                                                    <i class="bi bi-hash me-1"></i>{{ $contact->contact_number }}
                                                </span>
                                                <span>
                                                    <i class="bi bi-clock me-1"></i>{{ $contact->created_at->format('Y.m.d H:i') }}
                                                </span>
                                            </div>
                                            <p class="mb-2 text-muted small">
                                                {{ Str::limit($contact->message, 120) }}
                                            </p>
                                            @if($contact->assignedUser)
                                            <div class="small text-info">
                                                <i class="bi bi-person me-1"></i>담당자: {{ $contact->assignedUser->name }}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-end gap-2">
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-{{ $contact->status_class }}">{{ $contact->status_text }}</span>
                                            <span class="badge bg-{{ $contact->priority_class }}">{{ $contact->priority_text }}</span>
                                        </div>
                                        @if($contact->publicComments->count() > 0)
                                        <div class="small text-success">
                                            <i class="bi bi-chat-left-text me-1"></i>{{ $contact->publicComments->count() }}개의 답변
                                        </div>
                                        @endif
                                        @if($contact->isActive())
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('contact.edit', $contact->contact_number) }}"
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    onclick="cancelContact('{{ $contact->contact_number }}')">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- 페이지네이션 -->
            <div class="d-flex justify-content-center">
                {{ $contacts->withQueryString()->links() }}
            </div>
            @else
            <!-- 빈 상태 -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-chat-dots text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 mb-2">상담 요청 내역이 없습니다</h5>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['status', 'type']))
                        선택한 조건에 해당하는 상담 요청이 없습니다.<br>
                        다른 조건으로 검색해 보세요.
                        @else
                        아직 상담 요청을 하지 않으셨습니다.<br>
                        궁금한 사항이 있으시면 언제든지 문의해 주세요.
                        @endif
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('contact.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>상담 요청하기
                        </a>
                        @if(request()->hasAny(['status', 'type']))
                        <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>전체 보기
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 상담 현황 요약 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-pie-chart me-2"></i>상담 현황
                    </h6>
                </div>
                <div class="card-body">
                    @php
                    $statusCounts = [
                        'pending' => $contacts->where('status', 'pending')->count(),
                        'processing' => $contacts->where('status', 'processing')->count(),
                        'completed' => $contacts->where('status', 'completed')->count(),
                        'cancelled' => $contacts->where('status', 'cancelled')->count(),
                    ];
                    @endphp

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-warning bg-opacity-10 rounded">
                                <div class="h5 mb-0 text-warning">{{ $statusCounts['pending'] }}</div>
                                <small class="text-muted">대기 중</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-info bg-opacity-10 rounded">
                                <div class="h5 mb-0 text-info">{{ $statusCounts['processing'] }}</div>
                                <small class="text-muted">처리 중</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-success bg-opacity-10 rounded">
                                <div class="h5 mb-0 text-success">{{ $statusCounts['completed'] }}</div>
                                <small class="text-muted">완료</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-secondary bg-opacity-10 rounded">
                                <div class="h5 mb-0 text-secondary">{{ $statusCounts['cancelled'] }}</div>
                                <small class="text-muted">취소</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 안내 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>이용 안내
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>상담 수정</h6>
                        <p class="small text-muted mb-0">
                            대기 중이거나 처리 중인 상담은 수정하거나 취소할 수 있습니다.
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6>답변 알림</h6>
                        <p class="small text-muted mb-0">
                            상담에 대한 답변이 등록되면 이메일로 알림을 받을 수 있습니다.
                        </p>
                    </div>

                    <div>
                        <h6>추가 문의</h6>
                        <p class="small text-muted mb-0">
                            동일한 내용에 대한 추가 문의 시 기존 상담번호를 참조해 주세요.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <form method="POST" id="cancelForm" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">예, 취소합니다</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelContact(contactNumber) {
    const form = document.getElementById('cancelForm');
    form.action = `/contact/${contactNumber}/cancel`;

    const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.contact-item {
    transition: all 0.2s ease;
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.contact-item:hover {
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.contact-icon {
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

.btn-group-sm .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush
