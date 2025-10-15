@extends($layout ?? 'jiny-site::layouts.app')

@section('title', '상담 조회')

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
            <li class="breadcrumb-item active" aria-current="page">상담 조회</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- 페이지 헤더 -->
            <div class="mb-4 text-center">
                <h1 class="display-6 fw-bold mb-3">
                    <i class="bi bi-search me-2"></i>상담 조회
                </h1>
                <p class="lead text-muted">
                    상담번호와 이메일로 상담 요청 내역을 확인하세요.
                </p>
            </div>

            <!-- 상담 조회 폼 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-file-text me-2"></i>상담 조회
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <strong>조회 정보를 확인해주세요:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.search') }}" method="POST" id="searchForm">
                        @csrf

                        <!-- 상담번호 -->
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">
                                상담번호 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('contact_number') is-invalid @enderror"
                                   id="contact_number"
                                   name="contact_number"
                                   value="{{ old('contact_number') }}"
                                   placeholder="예: CT202501010001"
                                   required>
                            @error('contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">상담 요청 시 발급받은 상담번호를 입력하세요.</div>
                        </div>

                        <!-- 이메일 -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                이메일 <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="상담 요청 시 사용한 이메일"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">상담 요청 시 사용한 이메일 주소를 입력하세요.</div>
                        </div>

                        <!-- 제출 버튼 -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="searchBtn">
                                <i class="bi bi-search me-2"></i>상담 조회하기
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 안내 정보 -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-lightbulb me-2"></i>조회 안내
                            </h6>
                            <ul class="mb-0 small">
                                <li><strong>상담번호</strong>는 상담 요청 완료 시 발급되며, 이메일로도 안내됩니다.</li>
                                <li><strong>이메일</strong>은 상담 요청 시 입력한 이메일과 정확히 일치해야 합니다.</li>
                                <li>회원인 경우 로그인 후 <a href="{{ route('contact.index') }}">내 상담 목록</a>에서 확인 가능합니다.</li>
                                <li>상담번호를 분실한 경우 등록된 이메일로 문의해 주세요.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 추가 링크 -->
            <div class="text-center mt-4">
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('contact.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>새 상담 요청
                    </a>
                    @auth
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list me-2"></i>내 상담 목록
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>로그인
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('searchForm');
    const searchBtn = document.getElementById('searchBtn');
    const contactNumberInput = document.getElementById('contact_number');

    // 상담번호 입력 시 자동 대문자 변환
    contactNumberInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // 폼 제출 시 중복 방지
    form.addEventListener('submit', function(e) {
        if (searchBtn.disabled) {
            e.preventDefault();
            return;
        }

        searchBtn.disabled = true;
        searchBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>조회 중...';

        // 5초 후 다시 활성화 (오류 발생 시를 대비)
        setTimeout(() => {
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<i class="bi bi-search me-2"></i>상담 조회하기';
        }, 5000);
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

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.bg-light {
    background-color: #f8f9fa !important;
}

#contact_number {
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}
</style>
@endpush
