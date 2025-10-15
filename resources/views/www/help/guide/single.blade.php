@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

    <!-- Guide Single Hero -->
    <section class="py-4 bg-light">
        <div class="container my-lg-8">
            <div class="row align-items-center justify-content-center gy-2">
                <div class="col-md-8 col-12">
                    <!-- caption-->
                    <div class="d-flex flex-column gap-5">
                        <div class="d-flex flex-column gap-1">
                            <!-- Breadcrumb -->
                            <nav aria-label="breadcrumb" class="mb-3">

                            </nav>

                            @if ($guide->category_title)
                                <span class="badge bg-primary mb-2 align-self-start">{{ $guide->category_title }}</span>
                            @endif

                            <h1 class="fw-bold mb-0 display-4">{{ $guide->title }}</h1>
                            <!-- para -->
                            @if ($guide->summary)
                                <p class="mb-0 text-dark fs-5">{{ $guide->summary }}</p>
                            @endif
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <!-- Guide Meta -->
                            <div class="d-flex align-items-center gap-4 text-muted small">
                                <span>조회 {{ number_format($guide->views ?? 0) }}회</span>
                                @if ($guide->created_at)
                                    <span>{{ \Carbon\Carbon::parse($guide->created_at)->format('Y년 m월 d일') }} 작성</span>
                                @endif
                                @if ($guide->updated_at && $guide->updated_at !== $guide->created_at)
                                    <span>{{ \Carbon\Carbon::parse($guide->updated_at)->format('Y년 m월 d일') }} 수정</span>
                                @endif
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-3">
                                <a href="{{ url('/help/guide') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-arrow-left me-2"></i>
                                    가이드 목록
                                </a>
                                <a href="{{ url('/help') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-help-circle me-2"></i>
                                    도움말 센터
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="d-flex align-items-center justify-content-end">
                        <!-- Single guide illustration -->
                        <div class="position-relative">
                            <svg width="250" height="200" viewBox="0 0 250 200" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="img-fluid">
                                <!-- Background -->
                                <circle cx="200" cy="50" r="30" fill="#e3f2fd" />
                                <circle cx="50" cy="150" r="20" fill="#f3e5f5" />

                                <!-- Open book -->
                                <rect x="75" y="80" width="100" height="70" rx="8" fill="#1976d2" />
                                <rect x="125" y="80" width="100" height="70" rx="8" fill="#2196f3" />
                                <line x1="125" y1="80" x2="125" y2="150" stroke="#0d47a1"
                                    stroke-width="2" />

                                <!-- Book content lines -->
                                <rect x="85" y="95" width="30" height="2" rx="1"
                                    fill="rgba(255,255,255,0.7)" />
                                <rect x="85" y="105" width="25" height="2" rx="1"
                                    fill="rgba(255,255,255,0.5)" />
                                <rect x="85" y="115" width="28" height="2" rx="1"
                                    fill="rgba(255,255,255,0.5)" />

                                <rect x="135" y="95" width="30" height="2" rx="1"
                                    fill="rgba(255,255,255,0.7)" />
                                <rect x="135" y="105" width="25" height="2" rx="1"
                                    fill="rgba(255,255,255,0.5)" />
                                <rect x="135" y="115" width="28" height="2" rx="1"
                                    fill="rgba(255,255,255,0.5)" />

                                <!-- Reading icon -->
                                <circle cx="200" cy="40" r="8" fill="#4caf50" />
                                <text x="200" y="45" text-anchor="middle" fill="white" font-size="8"
                                    font-weight="bold">📖</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Breadcrumb -->
    <div class="pt-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/help') }}" class="text-decoration-none">Help
                                    Center</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/help/guide') }}" class="text-decoration-none">가이드
                                    & 자료</a></li>
                            @if ($guide->category_title)
                                <li class="breadcrumb-item"><a href="{{ url('/help/guide/category/' . $guide->category) }}"
                                        class="text-decoration-none">{{ $guide->category_title }}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ $guide->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-8">
                        <!-- Guide Content -->
                        <div class="guide-content">
                            @if ($guide->content)
                                {!! $guide->content !!}
                            @else
                                <div class="text-muted text-center py-8">
                                    <p>가이드 내용이 없습니다.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Guide Footer -->
                        <div class="d-md-flex justify-content-between align-items-center mt-8 pt-4 border-top">
                            <div class="mb-2 mb-md-0">
                                @if ($guide->updated_at)
                                    <p class="mb-0 fs-6">마지막 업데이트:
                                        {{ \Carbon\Carbon::parse($guide->updated_at)->format('Y년 m월 d일') }}</p>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-3">이 가이드가 도움이 되었나요?</h5>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button"
                                            class="btn btn-outline-success btn-sm like-btn {{ $userLike && $userLike->type === 'like' ? 'active' : '' }}"
                                            data-guide-id="{{ $guide->id }}"
                                            data-type="like">
                                        <i class="fe fe-thumbs-up me-1"></i>
                                        도움됨 <span class="like-count">{{ number_format($guide->likes ?? 0) }}</span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm like-btn {{ $userLike && $userLike->type === 'dislike' ? 'active' : '' }}"
                                            data-guide-id="{{ $guide->id }}"
                                            data-type="dislike">
                                        <i class="fe fe-thumbs-down me-1"></i>
                                        도움안됨 <span class="dislike-count">{{ number_format($guide->dislikes ?? 0) }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    @if ($previousGuide || $nextGuide)
                        <div class="mb-8 py-4 border-top border-bottom">
                            <div class="row align-items-center">
                                <!-- Previous Guide -->
                                <div class="col-md-5 col-12 mb-3 mb-md-0">
                                    @if ($previousGuide)
                                        <a href="{{ url('/help/guide/' . $previousGuide->id) }}"
                                           class="text-decoration-none d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="fe fe-chevron-left fs-4 text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small mb-1">이전 가이드</div>
                                                <div class="fw-semibold text-dark">{{ Str::limit($previousGuide->title, 35) }}</div>
                                            </div>
                                        </a>
                                    @endif
                                </div>

                                <!-- Center Guide List Button -->
                                <div class="col-md-2 col-12 text-center mb-3 mb-md-0">
                                    <a href="{{ url('/help/guide') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fe fe-list me-1"></i>
                                        목록
                                    </a>
                                </div>

                                <!-- Next Guide -->
                                <div class="col-md-5 col-12">
                                    @if ($nextGuide)
                                        <a href="{{ url('/help/guide/' . $nextGuide->id) }}"
                                           class="text-decoration-none d-flex align-items-center justify-content-md-end">
                                            <div class="text-md-end">
                                                <div class="text-muted small mb-1">다음 가이드</div>
                                                <div class="fw-semibold text-dark">{{ Str::limit($nextGuide->title, 35) }}</div>
                                            </div>
                                            <div class="ms-3">
                                                <i class="fe fe-chevron-right fs-4 text-primary"></i>
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Guides -->
    @if ($relatedGuides && $relatedGuides->count() > 0)
        <section class="py-8 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                            <h3 class="mb-1">관련 가이드</h3>
                            @if ($guide->category_title)
                                <p class="text-muted mb-0">{{ $guide->category_title }} 카테고리의 다른 가이드들</p>
                            @endif
                        </div>
                        <div class="row gy-3">
                            @foreach ($relatedGuides as $relatedGuide)
                                <div class="col-lg-6 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="{{ url('/help/guide/' . $relatedGuide->id) }}"
                                                    class="text-decoration-none">
                                                    {{ $relatedGuide->title }}
                                                </a>
                                            </h6>
                                            @if ($relatedGuide->summary)
                                                <p class="card-text text-muted small">
                                                    {{ Str::limit($relatedGuide->summary, 100) }}
                                                </p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    조회 {{ number_format($relatedGuide->views ?? 0) }}회
                                                </small>
                                                <a href="{{ url('/help/guide/' . $relatedGuide->id) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    읽기
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Back to Guides -->
                        <div class="text-center mt-6">
                            <a href="{{ url('/help/guide') }}" class="btn btn-primary">
                                <i class="fe fe-arrow-left me-2"></i>
                                가이드 목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <a href="{{ url('/help/guide') }}" class="btn btn-primary">
                                <i class="fe fe-arrow-left me-2"></i>
                                가이드 목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <style>
        .guide-content h1,
        .guide-content h2,
        .guide-content h3,
        .guide-content h4,
        .guide-content h5,
        .guide-content h6 {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .guide-content h1 {
            font-size: 2rem;
        }

        .guide-content h2 {
            font-size: 1.75rem;
        }

        .guide-content h3 {
            font-size: 1.5rem;
        }

        .guide-content h4 {
            font-size: 1.25rem;
        }

        .guide-content h5 {
            font-size: 1.1rem;
        }

        .guide-content h6 {
            font-size: 1rem;
        }

        .guide-content p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .guide-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem;
            margin: 1rem 0;
        }

        .guide-content blockquote {
            margin: 1.5rem 0;
            padding: 1rem 1.5rem;
            border-left: 4px solid #0d6efd;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
        }

        .guide-content ul,
        .guide-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .guide-content li {
            margin-bottom: 0.5rem;
        }

        .guide-content pre {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .guide-content code {
            background-color: #f8f9fa;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }

        /* Like buttons styles */
        .like-btn.active {
            font-weight: bold;
        }

        .like-btn.active.btn-outline-success {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }

        .like-btn.active.btn-outline-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .like-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing like functionality');

            // CSRF 토큰 가져오기
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF Token:', csrfToken);

            // 좋아요 버튼들 찾기
            const likeButtons = document.querySelectorAll('.like-btn');
            console.log('Found like buttons:', likeButtons.length);

            likeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const guideId = this.getAttribute('data-guide-id');
                    const type = this.getAttribute('data-type');

                    console.log('Button clicked:', { guideId, type, csrfToken });

                    if (!csrfToken) {
                        console.error('CSRF token not found');
                        alert('CSRF 토큰을 찾을 수 없습니다. 페이지를 새로고침해주세요.');
                        return;
                    }

                    // 버튼 비활성화
                    likeButtons.forEach(btn => btn.disabled = true);

                    // FormData 사용 (더 호환성이 좋음)
                    const formData = new FormData();
                    formData.append('type', type);
                    formData.append('_token', csrfToken);

                    console.log('Sending request to:', `/help/guide/${guideId}/like`);

                    fetch(`/help/guide/${guideId}/like`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Response received:', response.status, response.statusText);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        if (data.success) {
                            // 카운트 업데이트
                            const likeCountEl = document.querySelector('.like-count');
                            const dislikeCountEl = document.querySelector('.dislike-count');

                            if (likeCountEl) likeCountEl.textContent = data.likes || 0;
                            if (dislikeCountEl) dislikeCountEl.textContent = data.dislikes || 0;

                            // 버튼 상태 업데이트
                            likeButtons.forEach(btn => btn.classList.remove('active'));

                            // 사용자가 선택한 타입이 있으면 해당 버튼 활성화
                            if (data.userLike) {
                                const activeBtn = document.querySelector(`[data-type="${data.userLike}"]`);
                                if (activeBtn) {
                                    activeBtn.classList.add('active');
                                }
                            }

                            // 성공 메시지
                            let message = '';
                            if (data.action === 'added') {
                                message = type === 'like' ? '도움이 된다고 표시했습니다.' : '도움이 안 된다고 표시했습니다.';
                            } else if (data.action === 'removed') {
                                message = '평가를 취소했습니다.';
                            } else if (data.action === 'changed') {
                                message = type === 'like' ? '도움이 된다고 변경했습니다.' : '도움이 안 된다고 변경했습니다.';
                            }

                            if (message) {
                                console.log(message);
                                // 간단한 알림 (필요시 Toast로 변경 가능)
                                // alert(message);
                            }
                        } else {
                            console.error('Server error:', data);
                            alert('오류가 발생했습니다: ' + (data.error || '알 수 없는 오류'));
                        }
                    })
                    .catch(error => {
                        console.error('Request failed:', error);
                        alert('요청 처리 중 오류가 발생했습니다: ' + error.message);
                    })
                    .finally(() => {
                        // 버튼 다시 활성화
                        likeButtons.forEach(btn => btn.disabled = false);
                    });
                });
            });
        });
    </script>
@endsection
