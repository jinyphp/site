@extends($layout ?? 'jiny-site::layouts.app')

@section('title', 'Products')
@section('description', '다양한 상품을 둘러보세요')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3">Products</h1>
            <p class="lead text-muted">고품질의 다양한 상품을 만나보세요</p>
        </div>
    </div>

    <!-- Categories Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3">
                                <label for="search" class="form-label">검색</label>
                                <input type="text" id="search" name="search" class="form-control"
                                       placeholder="상품명으로 검색..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="category" class="form-label">카테고리</label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">전체 카테고리</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="sort" class="form-label">정렬</label>
                                <select id="sort" name="sort" class="form-select">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>최신순</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>인기순</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>가격 낮은순</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>가격 높은순</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fe fe-search me-1"></i>검색
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 product-card">
                        <!-- Product Image -->
                        <div class="position-relative">
                            @if($product->image)
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                     style="height: 250px;">
                                    <i class="fe fe-package text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif

                            <!-- Badges -->
                            @if($product->featured)
                                <span class="position-absolute top-0 start-0 badge bg-warning m-2">추천</span>
                            @endif
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2">할인</span>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="card-body d-flex flex-column">
                            <!-- Category -->
                            @if($product->category_name)
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark">{{ $product->category_name }}</span>
                                </div>
                            @endif

                            <!-- Title -->
                            <h5 class="card-title">
                                <a href="@if($product->category_slug)/product/{{ $product->category_slug }}/{{ $product->slug ?: $product->id }}@else/product/{{ $product->slug ?: $product->id }}@endif"
                                   class="text-decoration-none text-dark">
                                    {{ $product->title }}
                                </a>
                            </h5>

                            <!-- Description -->
                            @if($product->description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                            @endif

                            <!-- Price -->
                            <div class="mb-3">
                                @if($product->price)
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <div class="text-muted text-decoration-line-through small">
                                            ₩{{ number_format($product->price) }}
                                        </div>
                                        <div class="h5 text-danger mb-0">
                                            ₩{{ number_format($product->sale_price) }}
                                        </div>
                                    @else
                                        <div class="h5 text-primary mb-0">
                                            ₩{{ number_format($product->price) }}
                                        </div>
                                    @endif
                                @else
                                    <div class="h6 text-muted">가격 문의</div>
                                @endif
                            </div>

                            <!-- Stats -->
                            <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                <span><i class="fe fe-eye"></i> {{ number_format($product->view_count) }}</span>
                                <span>{{ \Carbon\Carbon::parse($product->created_at)->format('Y.m.d') }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-auto">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="@if($product->category_slug)/product/{{ $product->category_slug }}/{{ $product->slug ?: $product->id }}@else/product/{{ $product->slug ?: $product->id }}@endif"
                                       class="btn btn-outline-primary">
                                        자세히 보기
                                    </a>
                                    <a href="/contact/create?product={{ $product->id }}"
                                       class="btn btn-primary">
                                        문의하기
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        전체 {{ $products->total() }}개 중 {{ $products->firstItem() }}~{{ $products->lastItem() }}개 표시
                    </div>
                    <div>
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fe fe-package text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">상품이 없습니다</h4>
                    <p class="text-muted">검색 조건을 변경해보세요.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">전체 상품 보기</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid #dee2e6;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 25px rgba(0,0,0,0.1);
}

.product-card .card-img-top {
    transition: transform 0.3s;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

.product-card .card-title a:hover {
    color: #0d6efd !important;
}

@media (max-width: 768px) {
    .product-card {
        margin-bottom: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on sort change
    const sortSelect = document.getElementById('sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Auto-submit form on category change
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
@endpush
