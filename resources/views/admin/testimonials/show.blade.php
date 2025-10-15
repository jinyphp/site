@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.site.testimonials.index') }}">Testimonials</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">상세보기</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">Testimonial 상세 정보를 확인하고 관리할 수 있습니다.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.site.testimonials.edit', $testimonial->id) }}" class="btn btn-primary">
                        <i class="fe fe-edit me-2"></i>수정
                    </a>
                    <a href="{{ route('admin.site.testimonials.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 메인 정보 -->
        <div class="col-lg-8">
            <!-- 기본 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">기본 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3">{{ $testimonial->headline }}</h4>

                            <!-- 평점 -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-warning me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <span class="h6 mb-0">{{ $testimonial->rating }}/5</span>
                            </div>

                            <!-- 상태 정보 -->
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted">활성 상태:</span>
                                    @if($testimonial->enable)
                                        <span class="badge bg-success ms-1">활성</span>
                                    @else
                                        <span class="badge bg-secondary ms-1">비활성</span>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted">추천 여부:</span>
                                    @if($testimonial->featured)
                                        <span class="badge bg-warning text-dark ms-1">추천</span>
                                    @else
                                        <span class="badge bg-light text-dark ms-1">일반</span>
                                    @endif
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted">인증 여부:</span>
                                    @if($testimonial->verified)
                                        <span class="badge bg-success ms-1">인증됨</span>
                                    @else
                                        <span class="badge bg-light text-dark ms-1">미인증</span>
                                    @endif
                                </div>
                                @if($testimonial->user_id)
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted">연결된 사용자:</span>
                                    <span class="text-primary ms-1">
                                        @if($testimonial->user_name)
                                            {{ $testimonial->user_name }}
                                        @else
                                            사용자 #{{ $testimonial->user_id }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 80px;">대상:</td>
                                    <td>
                                        @if($testimonial->type === 'product')
                                            <span class="badge bg-primary">상품</span>
                                            <span class="text-muted">#{{ $testimonial->item_id }}</span>
                                            <br><small>{{ $testimonial->product_title ?: '제목 없음' }}</small>
                                        @else
                                            <span class="badge bg-info">서비스</span>
                                            <span class="text-muted">#{{ $testimonial->item_id }}</span>
                                            <br><small>{{ $testimonial->service_title ?: '제목 없음' }}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">좋아요:</td>
                                    <td>
                                        <i class="fe fe-heart text-danger"></i>
                                        {{ number_format($testimonial->likes_count) }}개
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">등록일:</td>
                                    <td>{{ \Carbon\Carbon::parse($testimonial->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- 리뷰 내용 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">리뷰 내용</h5>
                </div>
                <div class="card-body">
                    <div class="content">
                        {!! nl2br(e($testimonial->content)) !!}
                    </div>
                </div>
            </div>

            <!-- 좋아요 목록 -->
            @if($likes->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">좋아요 목록 ({{ $likes->count() }}개)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($likes->take(10) as $like)
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fe fe-heart text-danger me-2"></i>
                                <div>
                                    @if($like->user_name)
                                        <strong>{{ $like->user_name }}</strong>
                                    @else
                                        <span class="text-muted">익명 사용자</span>
                                        <small class="text-muted">({{ $like->ip_address }})</small>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($like->created_at)->format('Y-m-d H:i') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($likes->count() > 10)
                    <div class="text-center mt-3">
                        <small class="text-muted">외 {{ $likes->count() - 10 }}명이 더 좋아요를 눌렀습니다.</small>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 작성자 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">작성자 정보</h6>
                </div>
                <div class="card-body text-center">
                    @if($testimonial->avatar)
                        <img src="{{ $testimonial->avatar }}"
                             alt="{{ $testimonial->name }}"
                             class="rounded-circle mb-3"
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="fe fe-user text-muted" style="font-size: 2rem;"></i>
                        </div>
                    @endif

                    <h6 class="mb-3">{{ $testimonial->name }}</h6>

                    <table class="table table-borderless table-sm text-start">
                        @if($testimonial->email)
                        <tr>
                            <td class="text-muted" style="width: 60px;">이메일:</td>
                            <td>{{ $testimonial->email }}</td>
                        </tr>
                        @endif
                        @if($testimonial->title)
                        <tr>
                            <td class="text-muted">직책:</td>
                            <td>{{ $testimonial->title }}</td>
                        </tr>
                        @endif
                        @if($testimonial->company)
                        <tr>
                            <td class="text-muted">회사:</td>
                            <td>{{ $testimonial->company }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- 관리 도구 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">관리 도구</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.site.testimonials.edit', $testimonial->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>수정하기
                        </a>

                        <button type="button" class="btn btn-outline-danger" onclick="deleteTestimonial({{ $testimonial->id }})">
                            <i class="fe fe-trash-2 me-2"></i>삭제하기
                        </button>

                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <i class="fe fe-more-horizontal me-2"></i>상태 변경
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li>
                                    <button class="dropdown-item" onclick="toggleStatus({{ $testimonial->id }}, 'enable')">
                                        @if($testimonial->enable)
                                            <i class="fe fe-eye-off me-2"></i>비활성화
                                        @else
                                            <i class="fe fe-eye me-2"></i>활성화
                                        @endif
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" onclick="toggleStatus({{ $testimonial->id }}, 'featured')">
                                        @if($testimonial->featured)
                                            <i class="fe fe-star me-2"></i>추천 해제
                                        @else
                                            <i class="fe fe-star me-2"></i>추천 설정
                                        @endif
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" onclick="toggleStatus({{ $testimonial->id }}, 'verified')">
                                        @if($testimonial->verified)
                                            <i class="fe fe-shield-off me-2"></i>인증 해제
                                        @else
                                            <i class="fe fe-shield me-2"></i>인증 설정
                                        @endif
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Testimonial 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 Testimonial을 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    삭제된 데이터는 복구할 수 있습니다.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content {
    line-height: 1.6;
    word-wrap: break-word;
    white-space: pre-wrap;
}

.table-borderless td {
    padding: 0.25rem 0.5rem;
    border: none;
}

.badge {
    font-size: 0.75em;
}
</style>
@endpush

@push('scripts')
<script>
// 삭제 확인
function deleteTestimonial(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/site/testimonials/${id}`;
    modal.show();
}

// 상태 토글
function toggleStatus(id, field) {
    if (!confirm(`이 설정을 변경하시겠습니까?`)) {
        return;
    }

    fetch(`/admin/site/testimonials/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            toggle_field: field
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('오류가 발생했습니다.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('오류가 발생했습니다.');
    });
}
</script>
@endpush
