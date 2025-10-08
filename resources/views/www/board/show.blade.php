@extends('jiny-site::layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12" style="padding-left: 0; padding-right: 0;">
            <!-- 게시판 헤더 -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a href="{{ route('board.index', $code) }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-arrow-left"></i> {{ $board->title }}
                    </a>
                </div>
                <div>
                    <a href="{{ route('board.index', $code) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list"></i> 목록으로
                    </a>
                </div>
            </div>

            <!-- 부모 글 정보 (답글인 경우) -->
            @if($parentPost)
                <div class="mb-3 p-3 border rounded bg-light">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-arrow-return-right text-muted me-2"></i>
                        <span class="text-muted me-2">원글:</span>
                        <a href="{{ route('board.show', [$code, $parentPost->id]) }}"
                           class="text-decoration-none flex-grow-1">
                            <strong>{{ $parentPost->title }}</strong>
                        </a>
                        <small class="text-muted ms-2">
                            {{ $parentPost->name }} | {{ \Carbon\Carbon::parse($parentPost->created_at)->format('Y-m-d') }}
                        </small>
                    </div>
                </div>
            @endif

            <!-- 게시글 헤더 -->
            <div class="mb-4">
                <h2 class="mb-2">
                    @if($parentPost)
                        <i class="bi bi-reply text-primary me-2"></i>
                    @endif
                    {{ $post->title }}
                </h2>
                <div class="d-flex justify-content-between align-items-center text-muted">
                    <div class="small">
                        <span class="me-3">
                            <i class="bi bi-person"></i> {{ $post->name }}
                        </span>
                        <span class="me-3">
                            <i class="bi bi-calendar"></i>
                            {{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d H:i') }}
                        </span>
                        <span>
                            <i class="bi bi-eye"></i> {{ $post->click ?? 0 }}
                        </span>
                        @if($parentPost)
                            <span class="badge bg-primary ms-2">답글</span>
                        @endif
                    </div>
                    @if($canEdit || $canDelete)
                        <div>
                            @if($canEdit)
                                <a href="{{ route('board.edit', [$code, $post->id]) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> 수정
                                </a>
                            @endif
                            @if($canDelete)
                                <form action="{{ route('board.destroy', [$code, $post->id]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> 삭제
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <hr>

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

            <!-- 게시글 내용 -->
            <div class="mb-4">
                <div style="line-height: 1.6; margin: 0; padding: 0;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- 좋아요/별점 평가 섹션 -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <!-- 좋아요 섹션 -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn {{ $ratingData['user_like'] ? 'btn-danger' : 'btn-outline-danger' }} me-3"
                                        onclick="toggleLike()" id="like-button">
                                    <i class="bi bi-heart{{ $ratingData['user_like'] ? '-fill' : '' }}"></i>
                                    <span id="like-text">{{ $ratingData['user_like'] ? '좋아요 취소' : '좋아요' }}</span>
                                </button>
                                <span class="text-muted">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span id="like-count">{{ $ratingData['like_count'] }}</span>명이 좋아합니다
                                </span>
                            </div>
                        </div>

                        <!-- 별점 섹션 -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">별점 주기:</span>
                                        <div class="star-rating" id="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $ratingData['user_rating'] && $ratingData['user_rating'] >= $i ? 'bi-star-fill text-warning' : 'bi-star text-muted' }} star-icon"
                                                   data-rating="{{ $i }}" onclick="setRating({{ $i }})"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="small text-muted">
                                        @if($ratingData['user_rating'])
                                            내 평점: {{ $ratingData['user_rating'] }}점
                                        @else
                                            별점을 매겨주세요
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="h5 mb-0">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span id="rating-average">{{ $ratingData['rating_average'] }}</span>
                                    </div>
                                    <small class="text-muted">
                                        (<span id="rating-count">{{ $ratingData['rating_count'] }}</span>명 평가)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 하위글(답글) 목록 -->
            @if($children->count() > 0)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-reply"></i> 답글
                            <span class="badge bg-primary">{{ $children->count() }}</span>
                            <small class="text-muted ms-2">(전문적인 연관 답변글)</small>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($children as $child)
                            <div class="border-bottom p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <a href="{{ route('board.show', [$code, $child->id]) }}"
                                           class="text-decoration-none">
                                            <strong class="text-primary">{{ $child->title }}</strong>
                                        </a>
                                        <div class="small text-muted">
                                            <i class="bi bi-person"></i> {{ $child->name }}
                                            <span class="ms-2">
                                                <i class="bi bi-calendar"></i>
                                                {{ \Carbon\Carbon::parse($child->created_at)->format('Y-m-d H:i') }}
                                            </span>
                                            <span class="ms-2">
                                                <i class="bi bi-eye"></i> {{ $child->click ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($isAuthenticated)
                                        @if($child->user_id == $authUserId || $child->email == $authUserEmail)
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('board.edit', [$code, $child->id]) }}"
                                                   class="btn btn-outline-secondary" title="수정">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('board.destroy', [$code, $child->id]) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="삭제">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <!-- 답글 내용 (들여쓰기 제거) -->
                                <div style="line-height: 1.6;">
                                    {!! nl2br(e($child->content)) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 구분선 -->
            <hr class="my-4">

            <!-- 코멘트 목록 -->
            @if(count($comments) > 0)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-dots"></i> 코멘트
                            <span class="badge bg-success">{{ count($comments) }}</span>
                            <small class="text-muted ms-2">(짧은 댓글)</small>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($comments as $comment)
                            <div class="border-bottom p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>{{ $comment->name }}</strong>
                                        <span class="text-muted small ms-2">
                                            <i class="bi bi-clock"></i>
                                            {{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') }}
                                        </span>
                                    </div>
                                    @if($isAuthenticated)
                                        @if($comment->user_id == $authUserId || $comment->email == $authUserEmail)
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        onclick="editComment({{ $comment->id }}, '{{ addslashes($comment->content) }}')" title="수정">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-danger"
                                                        onclick="deleteComment({{ $comment->id }})" title="삭제">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div id="comment-content-{{ $comment->id }}" class="ms-3" style="word-break: break-word;">
                                    {{ $comment->content }}
                                </div>
                                <!-- 수정 폼 (기본 숨김) -->
                                <div id="comment-edit-form-{{ $comment->id }}" class="ms-3 mt-2" style="display: none;">
                                    <textarea class="form-control" rows="3" maxlength="1000" id="comment-edit-textarea-{{ $comment->id }}">{{ $comment->content }}</textarea>
                                    <div class="form-text">
                                        <span id="comment-edit-counter-{{ $comment->id }}">{{ strlen($comment->content) }}</span>/1000자
                                    </div>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-success" onclick="saveComment({{ $comment->id }})">
                                            <i class="bi bi-check"></i> 저장
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-1" onclick="cancelEditComment({{ $comment->id }})">
                                            <i class="bi bi-x"></i> 취소
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 작성 버튼들 -->
            @if($canCreate)
                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('board.reply', [$code, $post->id]) }}" class="btn btn-primary">
                        <i class="bi bi-reply"></i> 답글 작성
                    </a>
                    <button type="button" class="btn btn-success" onclick="toggleCommentForm()">
                        <i class="bi bi-chat-dots"></i> 코멘트 작성
                    </button>
                </div>

                <!-- 코멘트 작성 (기본 숨김) -->
                <div id="comment-form" class="card mb-3" style="display: none;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-dots"></i> 코멘트 작성
                            <small class="text-muted ms-2">(짧은 댓글, 최대 1000자)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('board.comment.store', [$code, $post->id]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="content" class="form-control" rows="3" maxlength="1000"
                                          placeholder="간단한 코멘트를 작성해주세요 (최대 1000자)" required></textarea>
                                <div class="form-text">
                                    <span id="comment-counter">0</span>/1000자
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleCommentForm()">
                                    <i class="bi bi-x"></i> 취소
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-chat"></i> 코멘트 작성
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif(!$isAuthenticated)
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    답글이나 코멘트를 작성하려면 <a href="{{ route('login') }}">로그인</a>이 필요합니다.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    답글이나 코멘트를 작성할 권한이 없습니다.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 코멘트 글자수 카운터
    const commentTextarea = document.querySelector('textarea[name="content"][maxlength="1000"]');
    const commentCounter = document.getElementById('comment-counter');

    if (commentTextarea && commentCounter) {
        commentTextarea.addEventListener('input', function() {
            const length = this.value.length;
            commentCounter.textContent = length;

            // 글자수에 따른 색상 변경
            if (length > 900) {
                commentCounter.style.color = '#dc3545'; // 빨간색
            } else if (length > 700) {
                commentCounter.style.color = '#fd7e14'; // 주황색
            } else {
                commentCounter.style.color = '#6c757d'; // 회색
            }
        });
    }
});

// 코멘트 폼 토글 함수
function toggleCommentForm() {
    const commentForm = document.getElementById('comment-form');
    const commentButton = document.querySelector('button[onclick="toggleCommentForm()"]');

    if (commentForm.style.display === 'none' || commentForm.style.display === '') {
        commentForm.style.display = 'block';
        commentButton.innerHTML = '<i class="bi bi-chevron-up"></i> 코멘트 닫기';

        // 텍스트 영역에 포커스
        const textarea = commentForm.querySelector('textarea');
        if (textarea) {
            setTimeout(() => textarea.focus(), 100);
        }
    } else {
        commentForm.style.display = 'none';
        commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> 코멘트 작성';

        // 폼 초기화
        const form = commentForm.querySelector('form');
        if (form) {
            form.reset();
            document.getElementById('comment-counter').textContent = '0';
        }
    }
}

// 코멘트 수정 함수
function editComment(commentId, currentContent) {
    // 현재 댓글 내용 숨기기
    document.getElementById(`comment-content-${commentId}`).style.display = 'none';

    // 수정 폼 표시
    const editForm = document.getElementById(`comment-edit-form-${commentId}`);
    editForm.style.display = 'block';

    // 텍스트 영역에 현재 내용 설정 및 포커스
    const textarea = document.getElementById(`comment-edit-textarea-${commentId}`);
    textarea.value = currentContent;
    textarea.focus();

    // 글자수 카운터 업데이트
    const counter = document.getElementById(`comment-edit-counter-${commentId}`);
    counter.textContent = currentContent.length;

    // 글자수 실시간 카운터 설정
    textarea.addEventListener('input', function() {
        const length = this.value.length;
        counter.textContent = length;

        // 글자수에 따른 색상 변경
        if (length > 900) {
            counter.style.color = '#dc3545'; // 빨간색
        } else if (length > 700) {
            counter.style.color = '#fd7e14'; // 주황색
        } else {
            counter.style.color = '#6c757d'; // 회색
        }
    });
}

// 코멘트 수정 취소 함수
function cancelEditComment(commentId) {
    // 수정 폼 숨기기
    document.getElementById(`comment-edit-form-${commentId}`).style.display = 'none';

    // 원본 댓글 내용 다시 표시
    document.getElementById(`comment-content-${commentId}`).style.display = 'block';
}

// 코멘트 저장 함수
function saveComment(commentId) {
    const textarea = document.getElementById(`comment-edit-textarea-${commentId}`);
    const newContent = textarea.value.trim();

    if (!newContent) {
        alert('코멘트 내용을 입력해주세요.');
        textarea.focus();
        return;
    }

    if (newContent.length > 1000) {
        alert('코멘트는 1000자를 초과할 수 없습니다.');
        textarea.focus();
        return;
    }

    // CSRF 토큰 가져오기
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                  document.querySelector('input[name="_token"]')?.value;

    if (!token) {
        alert('CSRF 토큰을 찾을 수 없습니다. 페이지를 새로고침해주세요.');
        return;
    }

    // AJAX 요청으로 코멘트 수정
    fetch(`/board/{{ $code }}/{{ $post->id }}/comment/${commentId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            content: newContent
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 시 댓글 내용 업데이트 및 폼 숨기기
            document.getElementById(`comment-content-${commentId}`).textContent = newContent;
            cancelEditComment(commentId);

            // 성공 메시지 표시 (선택사항)
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show';
            alertDiv.innerHTML = `
                ${data.success}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // 알림을 코멘트 섹션 위에 삽입
            const commentSection = document.querySelector('.card:has(.bi-chat-dots)');
            if (commentSection) {
                commentSection.parentNode.insertBefore(alertDiv, commentSection);

                // 3초 후 자동 제거
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 3000);
            }
        } else {
            alert(data.error || '코멘트 수정 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('코멘트 수정 중 오류가 발생했습니다.');
    });
}

// 코멘트 삭제 함수
function deleteComment(commentId) {
    if (!confirm('정말로 이 코멘트를 삭제하시겠습니까?')) {
        return;
    }

    // CSRF 토큰 가져오기
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                  document.querySelector('input[name="_token"]')?.value;

    if (!token) {
        alert('CSRF 토큰을 찾을 수 없습니다. 페이지를 새로고침해주세요.');
        return;
    }

    // AJAX 요청으로 코멘트 삭제
    fetch(`/board/{{ $code }}/{{ $post->id }}/comment/${commentId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            // 성공 시 페이지 새로고침
            location.reload();
        } else {
            throw new Error('삭제 요청이 실패했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('코멘트 삭제 중 오류가 발생했습니다.');
    });
}

// 좋아요 토글 함수
function toggleLike() {
    const likeButton = document.getElementById('like-button');
    const currentLiked = likeButton.classList.contains('btn-danger');

    // CSRF 토큰 가져오기
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                  document.querySelector('input[name="_token"]')?.value;

    if (!token) {
        alert('CSRF 토큰을 찾을 수 없습니다. 페이지를 새로고침해주세요.');
        return;
    }

    // 버튼 비활성화 (중복 클릭 방지)
    likeButton.disabled = true;

    // AJAX 요청으로 좋아요 상태 변경
    fetch(`/board/{{ $code }}/{{ $post->id }}/rating`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            type: 'like',
            is_like: !currentLiked
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // UI 업데이트
            updateLikeUI(data.result === 'liked', data.stats.like_count);
        } else {
            alert(data.error || '좋아요 처리 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('좋아요 처리 중 오류가 발생했습니다.');
    })
    .finally(() => {
        // 버튼 다시 활성화
        likeButton.disabled = false;
    });
}

// 좋아요 UI 업데이트 함수
function updateLikeUI(isLiked, likeCount) {
    const likeButton = document.getElementById('like-button');
    const likeText = document.getElementById('like-text');
    const likeCountElement = document.getElementById('like-count');
    const heartIcon = likeButton.querySelector('i');

    if (isLiked) {
        likeButton.className = 'btn btn-danger me-3';
        heartIcon.className = 'bi bi-heart-fill';
        likeText.textContent = '좋아요 취소';
    } else {
        likeButton.className = 'btn btn-outline-danger me-3';
        heartIcon.className = 'bi bi-heart';
        likeText.textContent = '좋아요';
    }

    likeCountElement.textContent = likeCount;
}

// 별점 설정 함수
function setRating(rating) {
    // CSRF 토큰 가져오기
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                  document.querySelector('input[name="_token"]')?.value;

    if (!token) {
        alert('CSRF 토큰을 찾을 수 없습니다. 페이지를 새로고침해주세요.');
        return;
    }

    // 별점 시각적 미리보기
    updateStarDisplay(rating);

    // AJAX 요청으로 별점 저장
    fetch(`/board/{{ $code }}/{{ $post->id }}/rating`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            type: 'rating',
            rating: rating
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 통계 업데이트
            updateRatingStats(data.stats.rating_average, data.stats.rating_count);

            // 사용자 평점 표시 업데이트
            const userRatingText = document.querySelector('.col-md-6:nth-child(2) .small.text-muted');
            userRatingText.textContent = `내 평점: ${rating}점`;

            // 성공 메시지 표시 (선택사항)
            showRatingMessage(data.message);
        } else {
            alert(data.error || '별점 저장 중 오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('별점 저장 중 오류가 발생했습니다.');
    });
}

// 별점 시각적 업데이트 함수
function updateStarDisplay(rating) {
    const stars = document.querySelectorAll('#star-rating .star-icon');
    stars.forEach((star, index) => {
        const starRating = index + 1;
        if (starRating <= rating) {
            star.className = 'bi bi-star-fill text-warning star-icon';
        } else {
            star.className = 'bi bi-star text-muted star-icon';
        }
    });
}

// 별점 통계 업데이트 함수
function updateRatingStats(average, count) {
    document.getElementById('rating-average').textContent = average;
    document.getElementById('rating-count').textContent = count;
}

// 별점 메시지 표시 함수
function showRatingMessage(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // 평가 섹션 위에 메시지 삽입
    const ratingSection = document.querySelector('.card:has(.star-rating)');
    if (ratingSection) {
        ratingSection.parentNode.insertBefore(alertDiv, ratingSection);

        // 3초 후 자동 제거
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
}

// 별점 호버 효과 추가
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#star-rating .star-icon');
    const currentRating = {{ $ratingData['user_rating'] ?? 0 }};

    stars.forEach((star, index) => {
        const starRating = index + 1;

        // 마우스 오버 시 미리보기
        star.addEventListener('mouseenter', function() {
            updateStarDisplay(starRating);
        });

        // 마우스 아웃 시 원래 상태로 복원
        star.addEventListener('mouseleave', function() {
            updateStarDisplay(currentRating);
        });

        // 클릭 가능하게 커서 변경
        star.style.cursor = 'pointer';
    });
});
</script>
@endpush
