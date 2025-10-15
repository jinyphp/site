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
                </div>
                <div>
                    <a href="{{ route('admin.site.products.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 상품 등록
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
                                <i class="fe fe-package text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 상품</h6>
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
                            <h6 class="mb-0">판매중</h6>
                            <h4 class="mb-0">{{ $stats['published'] }}</h4>
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
                                <i class="fe fe-edit text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">준비중</h6>
                            <h4 class="mb-0">{{ $stats['draft'] }}</h4>
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
                                <i class="fe fe-star text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">추천 상품</h6>
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
                            <div class="bg-danger bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-trending-up text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">인기 상품</h6>
                            <h4 class="mb-0">{{ $stats['popular'] }}</h4>
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
                                <i class="fe fe-eye text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">총 조회수</h6>
                            <h4 class="mb-0">{{ number_format($stats['total_views']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.site.products.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">검색</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="상품명, 설명으로 검색..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="category">카테고리</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">전체 카테고리</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="enable">판매상태</label>
                            <select id="enable" name="enable" class="form-control">
                                <option value="">전체</option>
                                <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>판매중</option>
                                <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>준비중</option>
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
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                        <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-refresh-cw me-1"></i>초기화
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 상품 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">상품 목록</h5>
        </div>
        <div class="card-body p-0">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>상품정보</th>
                                <th width="120">가격</th>
                                <th width="100">조회수</th>
                                <th width="180">상태/등록일</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->image)
                                            <img src="{{ $product->image }}"
                                                 alt="{{ $product->title }}"
                                                 class="me-3 rounded"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px;">
                                                <i class="fe fe-package text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <a href="{{ route('admin.site.products.show', $product->id) }}"
                                                   class="text-decoration-none">
                                                    <strong>{{ $product->title }}</strong>
                                                </a>
                                                @if($product->featured)
                                                    <span class="badge bg-warning text-dark ms-1">추천</span>
                                                @endif
                                                @if($product->category_name)
                                                    <span class="badge bg-primary text-white ms-1">{{ $product->category_name }}</span>
                                                @endif
                                            </div>
                                            @if($product->description)
                                                <div class="mt-1">
                                                    <small class="text-muted">{{ Str::limit(strip_tags($product->description), 60) }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->price)
                                        <div>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <small class="text-muted text-decoration-line-through">₩{{ number_format($product->price) }}</small><br>
                                                <strong class="text-danger">₩{{ number_format($product->sale_price) }}</strong>
                                            @else
                                                <strong>₩{{ number_format($product->price) }}</strong>
                                            @endif
                                            @if($product->pricing_options_count > 0)
                                                <br><small class="text-info">옵션 {{ $product->pricing_options_count }}개</small>
                                            @endif
                                        </div>
                                    @else
                                        <div>
                                            <span class="text-muted">가격미정</span>
                                            @if($product->pricing_options_count > 0)
                                                <br><small class="text-info">옵션 {{ $product->pricing_options_count }}개</small>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ number_format($product->view_count) }}</small>
                                </td>
                                <td>
                                    <div>
                                        @if($product->enable)
                                            <span class="badge bg-success">판매중</span>
                                        @else
                                            <span class="badge bg-secondary">준비중</span>
                                        @endif
                                    </div>
                                    <div class="mt-1" style="white-space: nowrap;">
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($product->created_at)->format('Y-m-d H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.site.products.show', $product->id) }}"
                                           class="btn btn-outline-info"
                                           title="관리자에서 보기">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        <a href="@if(isset($product->category_slug) && $product->category_slug)/product/{{ $product->category_slug }}/{{ $product->slug ?: $product->id }}@elseif(isset($product->category_id) && $product->category_id)/product/{{ $product->category_id }}/{{ $product->slug ?: $product->id }}@else/product/{{ $product->slug ?: $product->id }}@endif"
                                           class="btn btn-outline-secondary"
                                           title="사이트에서 보기"
                                           target="_blank">
                                            <i class="fe fe-external-link"></i>
                                        </a>
                                        <a href="{{ route('admin.site.products.edit', $product->id) }}"
                                           class="btn btn-outline-primary"
                                           title="수정">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.site.products.images.index', $product->id) }}"
                                           class="btn btn-outline-success"
                                           title="이미지 갤러리">
                                            <i class="fe fe-image"></i>
                                        </a>
                                        <a href="{{ route('admin.site.products.pricing.index', $product->id) }}"
                                           class="btn btn-outline-warning"
                                           title="가격 옵션">
                                            <i class="fe fe-tag"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                title="삭제"
                                                onclick="deleteProduct({{ $product->id }})">
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
                            전체 {{ $products->total() }}개 중
                            {{ $products->firstItem() }}~{{ $products->lastItem() }}개 표시
                        </div>
                        <div>
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-package fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 상품이 없습니다</h5>
                    <p class="text-muted">새 상품을 등록해보세요.</p>
                    <a href="{{ route('admin.site.products.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 상품 등록
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
                <h5 class="modal-title">상품 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 상품을 삭제하시겠습니까?</p>
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
function deleteProduct(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/site/products/${id}`;
    modal.show();
}
</script>
@endpush
