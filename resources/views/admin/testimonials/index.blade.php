@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                    @if($type && $itemId)
                        <p class="text-info small mb-0">
                            @if($type === 'product')
                                상품 전용 Testimonials
                            @else
                                서비스 전용 Testimonials
                            @endif
                        </p>
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.site.testimonials.create', $type && $itemId ? ['type' => $type, 'itemId' => $itemId] : []) }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 Testimonial 등록
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-message-square text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 후기</h6>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">활성화</h6>
                            <h4 class="mb-0">{{ $stats['enabled'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-star text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">추천 후기</h6>
                            <h4 class="mb-0">{{ $stats['featured'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-shield text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">인증 후기</h6>
                            <h4 class="mb-0">{{ $stats['verified'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-heart text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">총 좋아요</h6>
                            <h4 class="mb-0">{{ number_format($stats['total_likes']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-secondary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-star text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">평균 평점</h6>
                            <h4 class="mb-0">{{ $stats['average_rating'] ?? '0' }}/5</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.site.testimonials.index', $type && $itemId ? ['type' => $type, 'itemId' => $itemId] : []) }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">검색</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="제목, 내용, 작성자..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    @if(!$type)
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type">타입</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="">전체</option>
                                    <option value="product" {{ request('type') === 'product' ? 'selected' : '' }}>상품</option>
                                    <option value="service" {{ request('type') === 'service' ? 'selected' : '' }}>서비스</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="rating">평점</label>
                            <select id="rating" name="rating" class="form-control">
                                <option value="">전체</option>
                                <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                                <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                                <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                                <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                                <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>⭐ (1)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="featured">추천여부</label>
                            <select id="featured" name="featured" class="form-control">
                                <option value="">전체</option>
                                <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>추천</option>
                                <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>일반</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="enable">활성상태</label>
                            <select id="enable" name="enable" class="form-control">
                                <option value="">전체</option>
                                <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>활성</option>
                                <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비활성</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Testimonials 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Testimonials 목록</h5>
        </div>
        <div class="card-body p-0">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>후기 정보</th>
                                <th width="120">대상</th>
                                <th width="100">좋아요</th>
                                <th width="100">상태</th>
                                <th width="150">등록일</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                            <tr>
                                <td>{{ $testimonial->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->avatar)
                                            <img src="{{ $testimonial->avatar }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="me-3 rounded-circle"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="me-3 rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fe fe-user text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.site.testimonials.show', $testimonial->id) }}"
                                               class="text-decoration-none">
                                                <strong>{{ $testimonial->headline }}</strong>
                                            </a>
                                            @if($testimonial->featured)
                                                <span class="badge bg-warning text-dark ms-1">추천</span>
                                            @endif
                                            @if($testimonial->verified)
                                                <span class="badge bg-success ms-1">인증</span>
                                            @endif
                                            <br>
                                            <div class="d-flex align-items-center mt-1">
                                                <div class="text-warning me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $testimonial->rating)
                                                            ⭐
                                                        @else
                                                            ☆
                                                        @endif
                                                    @endfor
                                                </div>
                                                <small class="text-muted">{{ $testimonial->rating }}/5</small>
                                            </div>
                                            <small class="text-muted">{{ $testimonial->name }}</small>
                                            @if($testimonial->company)
                                                <small class="text-muted"> - {{ $testimonial->company }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($testimonial->type === 'product')
                                        <span class="badge bg-primary">상품</span><br>
                                        <small class="text-muted">#{{ $testimonial->item_id }}</small><br>
                                        <small>{{ $testimonial->product_title ?: '제목 없음' }}</small>
                                    @else
                                        <span class="badge bg-info">서비스</span><br>
                                        <small class="text-muted">#{{ $testimonial->item_id }}</small><br>
                                        <small>{{ $testimonial->service_title ?: '제목 없음' }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <i class="fe fe-heart text-danger"></i>
                                        <span class="ms-1">{{ number_format($testimonial->likes_count) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($testimonial->enable)
                                        <span class="badge bg-success">활성</span>
                                    @else
                                        <span class="badge bg-secondary">비활성</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($testimonial->created_at)->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.site.testimonials.show', $testimonial->id) }}"
                                           class="btn btn-outline-info"
                                           title="상세보기">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.site.testimonials.edit', $testimonial->id) }}"
                                           class="btn btn-outline-primary"
                                           title="수정">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                title="삭제"
                                                onclick="deleteTestimonial({{ $testimonial->id }})">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 페이지네이션 -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            전체 {{ $testimonials->total() }}개 중
                            {{ $testimonials->firstItem() }}~{{ $testimonials->lastItem() }}개 표시
                        </div>
                        <div>
                            {{ $testimonials->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-message-square fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 Testimonial이 없습니다</h5>
                    <p class="text-muted">새로운 고객 후기를 등록해보세요.</p>
                    <a href="{{ route('admin.site.testimonials.create', $type && $itemId ? ['type' => $type, 'itemId' => $itemId] : []) }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 Testimonial 등록
                    </a>
                </div>
            @endif
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
/* 통계 카드 원형 아이콘 스타일 */
.stat-circle {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px;
    min-height: 48px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.stat-circle i {
    font-size: 20px;
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
</script>
@endpush
