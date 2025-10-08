@extends('jiny-site::layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- 뒤로가기 링크 -->
            <div class="mb-3">
                <a href="{{ route('board.show', [$code, $parent->id]) }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> 원글로 돌아가기
                </a>
            </div>

            <!-- 게시판 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">{{ $board->title }}</h2>
                    @if($board->subtitle)
                        <p class="text-muted mb-0">{{ $board->subtitle }}</p>
                    @endif
                </div>
                <div>
                    <a href="{{ route('board.index', $code) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list"></i> 목록
                    </a>
                </div>
            </div>

            <hr>

            <!-- 원글 정보 -->
            <div class="card mb-4 bg-light">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-file-text"></i> 원글
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{ $parent->title }}</h6>
                    <p class="card-text text-muted small">
                        <i class="bi bi-person"></i> {{ $parent->name }} |
                        <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($parent->created_at)->format('Y-m-d H:i') }}
                    </p>
                    <div class="card-text" style="max-height: 100px; overflow-y: auto;">
                        {{ Str::limit($parent->content, 200) }}
                    </div>
                </div>
            </div>

            <!-- 답글 작성 폼 제목 -->
            <div class="mb-4">
                <h4>
                    <i class="bi bi-reply"></i> 답글 작성
                </h4>
                <p class="text-muted small mb-0">원글에 대한 전문적인 연관 답변을 작성해주세요.</p>
            </div>

            <!-- 알림 메시지 -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- 답글 작성 폼 -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('board.store', $code) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $parent->id }}">

                        <!-- 제목 -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                제목 <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', 'Re: ' . $parent->title) }}"
                                   placeholder="답글 제목을 입력하세요" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 작성자 정보 -->
                        @if(isset($user) && $user)
                            <div class="mb-3">
                                <div class="alert alert-info">
                                    <i class="bi bi-person-circle"></i>
                                    <strong>작성자:</strong> {{ $user->name }} ({{ $user->email }})
                                </div>
                            </div>
                        @elseif(!$isAuthenticated)
                            <div class="mb-3">
                                <div class="alert alert-warning">
                                    <i class="bi bi-person-x"></i>
                                    <strong>익명 작성:</strong> 로그인하지 않은 상태입니다.
                                </div>
                            </div>
                        @endif

                        <!-- 내용 -->
                        <div class="mb-3">
                            <label for="content" class="form-label">
                                내용 <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15"
                                      placeholder="전문적인 답변 내용을 입력하세요" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i>
                                원글과 관련된 전문적이고 구체적인 답변을 작성해주세요.
                            </div>
                        </div>

                        <!-- 버튼 -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('board.show', [$code, $parent->id]) }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> 취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> 답글 등록
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 답글 작성 안내 -->
            <div class="alert alert-info mt-3">
                <h6><i class="bi bi-info-circle"></i> 답글 작성 안내</h6>
                <ul class="mb-0 small">
                    <li><strong>답글</strong>은 원글에 대한 전문적인 연관 답변입니다.</li>
                    <li>간단한 의견이나 댓글은 원글 페이지의 <strong>코멘트</strong>를 이용해주세요.</li>
                    <li>답글은 원글에 종속되며, 원글이 삭제되면 함께 삭제될 수 있습니다.</li>
                    <li>작성한 답글은 본인만 수정 및 삭제할 수 있습니다.</li>
                    <li>욕설, 비방, 광고성 내용은 삭제될 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // JWT 토큰 디버깅
    console.log('JWT Debug - All Cookies:', document.cookie);
    console.log('JWT Debug - Access Token:', getCookie('access_token'));
    console.log('JWT Debug - Refresh Token:', getCookie('refresh_token'));

    function getCookie(name) {
        let value = "; " + document.cookie;
        let parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
        return null;
    }

    // 폼 제출 전 확인
    const form = document.querySelector('form');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        const title = document.getElementById('title');
        const content = document.getElementById('content');

        if (!title.value.trim()) {
            e.preventDefault();
            alert('제목을 입력해주세요.');
            title.focus();
            return false;
        }

        if (!content.value.trim()) {
            e.preventDefault();
            alert('내용을 입력해주세요.');
            content.focus();
            return false;
        }

        // JWT 토큰이 있으면 헤더에 추가
        const accessToken = getCookie('access_token');
        if (accessToken) {
            console.log('JWT Debug - Adding Authorization header:', accessToken.substring(0, 50) + '...');

            // 새로운 hidden input 추가
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_jwt_token';
            tokenInput.value = accessToken;
            form.appendChild(tokenInput);
        }

        isSubmitting = true;
    });
});
</script>
@endpush