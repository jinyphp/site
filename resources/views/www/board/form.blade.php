@extends($layout ?? 'jiny-site::layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
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

            <!-- 글 작성 폼 제목 -->
            <div class="mb-4">
                <h4>
                    @if(isset($parent))
                        댓글 작성
                    @elseif(isset($post))
                        글 수정
                    @else
                        글 작성
                    @endif
                </h4>
                @if(isset($parent))
                    <p class="text-muted small mb-0 mt-2">
                        원글: {{ $parent->title }}
                    </p>
                @endif
            </div>

            <!-- 글 작성 폼 -->
                    @if(isset($post))
                        <form action="{{ route('board.update', [$code, $post->id]) }}" method="POST">
                            @method('PUT')
                    @else
                        <form action="{{ route('board.store', $code) }}" method="POST">
                    @endif
                        @csrf

                        @if(isset($parent))
                            <input type="hidden" name="parent_id" value="{{ $parent->id }}">
                        @endif

                        <!-- 제목 -->
                        @if(!isset($parent))
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    제목 <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title"
                                       value="{{ old('title', $post->title ?? '') }}"
                                       placeholder="제목을 입력하세요" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <input type="hidden" name="title" value="Re: {{ $parent->title }}">
                        @endif

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
                                      placeholder="내용을 입력하세요" required>{{ old('content', $post->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i>
                                HTML 태그는 사용할 수 없습니다.
                            </div>
                        </div>

                        <!-- 버튼 -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ isset($post) ? route('board.show', [$code, $post->id]) : route('board.index', $code) }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> 취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                {{ isset($post) ? '수정' : '등록' }}
                            </button>
                        </div>
                    </form>

            <!-- 작성 안내 -->
            <div class="alert alert-info mt-3">
                <h6><i class="bi bi-info-circle"></i> 작성 안내</h6>
                <ul class="mb-0 small">
                    <li>욕설, 비방, 광고성 글은 삭제될 수 있습니다.</li>
                    <li>타인의 권리를 침해하는 내용은 게시할 수 없습니다.</li>
                    <li>작성한 글은 본인만 수정 및 삭제할 수 있습니다.</li>
                    @if(isset($parent))
                        <li>하위글은 원글에 종속되며, 원글이 삭제되면 함께 삭제될 수 있습니다.</li>
                    @endif
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

        if (title && !title.value.trim()) {
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
