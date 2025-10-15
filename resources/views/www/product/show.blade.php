@extends($layout ?? 'jiny-site::layouts.app')

@section('title', $product->meta_title ?: $product->title)
@section('description', $product->meta_description ?: $product->description)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">홈</a></li>
            <li class="breadcrumb-item"><a href="/products">상품</a></li>
            @if($category)
                <li class="breadcrumb-item"><a href="/product/{{ $category->slug ?: $category->id }}">{{ $category->title }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image mb-3">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->title }}"
                             class="img-fluid rounded shadow" id="mainImage">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                            <i class="fe fe-package text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                </div>

                <!-- Image Gallery -->
                @if($images->count() > 0)
                    <div class="image-thumbnails">
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-3 mb-2">
                                    <img src="{{ $image->thumbnail_url ?: $image->image_url }}"
                                         alt="{{ $image->alt_text ?: $product->title }}"
                                         class="img-fluid rounded cursor-pointer thumbnail"
                                         onclick="changeMainImage('{{ $image->image_url }}')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Category -->
                @if($category)
                    <div class="mb-2">
                        <span class="badge bg-light text-dark">{{ $category->title }}</span>
                    </div>
                @endif

                <!-- Title -->
                <h1 class="h2 mb-3">{{ $product->title }}</h1>

                <!-- Description -->
                @if($product->description)
                    <p class="text-muted mb-4">{{ $product->description }}</p>
                @endif

                <!-- Pricing -->
                <div class="pricing mb-4">
                    @if($pricingOptions->count() > 0)
                        <!-- Multiple Pricing Options -->
                        <div class="pricing-options">
                            <h5 class="mb-3">가격 옵션 <span class="text-danger">*</span></h5>
                            <div id="pricingError" class="alert alert-danger" style="display: none;"></div>
                            @foreach($pricingOptions as $index => $pricing)
                                <div class="card mb-3 pricing-option-card" data-pricing-id="{{ $pricing->id }}">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pricing_option"
                                                           value="{{ $pricing->id }}" id="pricing_{{ $pricing->id }}"
                                                           {{ $index === 0 ? '' : '' }}>
                                                    <label class="form-check-label w-100" for="pricing_{{ $pricing->id }}">
                                                        <div class="d-flex justify-content-between align-items-start w-100">
                                                            <div>
                                                                <h6 class="card-title mb-1">{{ $pricing->name }}</h6>
                                                                @if($pricing->description)
                                                                    <p class="text-muted small mb-2">{{ $pricing->description }}</p>
                                                                @endif
                                                                @if($pricing->billing_period)
                                                                    <span class="badge bg-info">{{ $pricing->billing_period }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-end">
                                                                @if($pricing->sale_price && $pricing->sale_price < $pricing->price)
                                                                    <div class="text-muted text-decoration-line-through small">
                                                                        {{ $pricing->currency }} {{ number_format($pricing->price) }}
                                                                    </div>
                                                                    <div class="h5 text-danger mb-0">
                                                                        {{ $pricing->currency }} {{ number_format($pricing->sale_price) }}
                                                                    </div>
                                                                @else
                                                                    <div class="h5 mb-0">
                                                                        {{ $pricing->currency }} {{ number_format($pricing->price) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Single Price -->
                        <div class="single-price">
                            @if($product->price)
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div class="text-muted text-decoration-line-through h5">
                                        ₩{{ number_format($product->price) }}
                                    </div>
                                    <div class="h3 text-danger mb-0">
                                        ₩{{ number_format($product->sale_price) }}
                                    </div>
                                @else
                                    <div class="h3 text-primary mb-0">
                                        ₩{{ number_format($product->price) }}
                                    </div>
                                @endif
                            @else
                                <div class="h5 text-muted">가격 문의</div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Quantity Selection -->
                <div class="quantity-selection mb-4">
                    <h6>수량</h6>
                    <div class="input-group" style="max-width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                        <input type="number" class="form-control text-center" id="quantity" name="quantity"
                               value="1" min="1" max="99">
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <!-- Features -->
                @if($product->features)
                    <div class="features mb-4">
                        <h6>주요 특징</h6>
                        <div class="bg-light p-3 rounded">
                            <pre class="mb-0">{{ $product->features }}</pre>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="actions mb-4">
                    <div class="row g-2">
                        @if($product->enable_purchase ?? true)
                            <div class="col-6">
                                <button type="button" class="btn btn-primary w-100" onclick="purchaseProduct()">
                                    <i class="fe fe-shopping-bag me-1"></i>구매
                                </button>
                            </div>
                        @endif

                        @if($product->enable_cart ?? true)
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="addToCart()">
                                    <i class="fe fe-shopping-cart me-1"></i>장바구니
                                </button>
                            </div>
                        @endif

                        @if($product->enable_quote ?? true)
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="requestQuote()">
                                    <i class="fe fe-file-text me-1"></i>견적
                                </button>
                            </div>
                        @endif

                        @if($product->enable_contact ?? true)
                            <div class="col-6">
                                <a href="/contact/create?product={{ $product->id }}" class="btn btn-outline-info w-100">
                                    <i class="fe fe-phone me-1"></i>문의하기
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Social Share -->
                @if($product->enable_social_share ?? true)
                    <div class="social-share mb-4">
                        <h6 class="mb-3">공유하기</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="shareKakao()">
                                <i class="fe fe-message-circle me-1"></i>카카오톡
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="shareFacebook()">
                                <i class="fe fe-facebook me-1"></i>페이스북
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="shareTwitter()">
                                <i class="fe fe-twitter me-1"></i>트위터
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyLink()">
                                <i class="fe fe-link me-1"></i>링크복사
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Product Stats -->
                <div class="product-stats">
                    <small class="text-muted">
                        조회수: {{ number_format($product->view_count) }} |
                        등록일: {{ \Carbon\Carbon::parse($product->created_at)->format('Y.m.d') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="product-details mt-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            @if($product->content)
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                        상세설명
                    </button>
                </li>
            @endif
            @if($product->specifications)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ !$product->content ? 'active' : '' }}" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                        제품사양
                    </button>
                </li>
            @endif
            @if($images->count() > 0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab">
                        이미지갤러리 ({{ $images->count() }})
                    </button>
                </li>
            @endif
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ !$product->content && !$product->specifications && $images->count() == 0 ? 'active' : '' }}" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                    리뷰 ({{ $testimonials->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productTabsContent">
            @if($product->content)
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="p-4">
                        <div class="content">
                            {!! nl2br(e($product->content)) !!}
                        </div>
                    </div>
                </div>
            @endif

            @if($product->specifications)
                <div class="tab-pane fade {{ !$product->content ? 'show active' : '' }}" id="specs" role="tabpanel">
                    <div class="p-4">
                        <pre class="specs">{{ $product->specifications }}</pre>
                    </div>
                </div>
            @endif

            @if($images->count() > 0)
                <div class="tab-pane fade" id="gallery" role="tabpanel">
                    <div class="p-4">
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ $image->image_url }}" class="card-img-top" alt="{{ $image->alt_text ?: $product->title }}">
                                        @if($image->description)
                                            <div class="card-body">
                                                <p class="card-text small">{{ $image->description }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reviews Tab -->
            <div class="tab-pane fade {{ !$product->content && !$product->specifications && $images->count() == 0 ? 'show active' : '' }}" id="reviews" role="tabpanel">
                <div class="p-4">
                    <!-- Reviews Header -->
                    <div class="reviews-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">고객 리뷰</h4>
                                @if($testimonials->count() > 0)
                                    @php
                                        $averageRating = $testimonials->avg('rating');
                                        $totalReviews = $testimonials->count();
                                    @endphp
                                    <div class="rating-summary mt-2">
                                        <div class="d-flex align-items-center">
                                            <div class="stars me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($averageRating))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="h6 mb-0 me-2">{{ number_format($averageRating, 1) }}/5</span>
                                            <span class="text-muted">({{ $totalReviews }}개 리뷰)</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button class="btn btn-primary" onclick="toggleReviewForm()">
                                    <i class="fe fe-edit me-2"></i>리뷰 작성하기
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <div class="review-form mb-4" id="reviewForm" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">새 리뷰 작성</h5>
                            </div>
                            <div class="card-body">
                                <form id="testimonialForm">
                                    @csrf
                                    <input type="hidden" name="type" value="product">
                                    <input type="hidden" name="item_id" value="{{ $product->id }}">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="review_name" class="form-label">이름 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="review_name" name="name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="review_email" class="form-label">이메일</label>
                                            <input type="email" class="form-control" id="review_email" name="email">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="review_title" class="form-label">직책/지위</label>
                                            <input type="text" class="form-control" id="review_title" name="title" placeholder="예: 개발자, 마케터">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="review_company" class="form-label">회사/기관</label>
                                            <input type="text" class="form-control" id="review_company" name="company">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="review_rating" class="form-label">평점 <span class="text-danger">*</span></label>
                                        <div class="star-rating">
                                            <input type="hidden" name="rating" id="ratingValue" value="" required>
                                            <div class="stars-container">
                                                <span class="star" data-rating="1">★</span>
                                                <span class="star" data-rating="2">★</span>
                                                <span class="star" data-rating="3">★</span>
                                                <span class="star" data-rating="4">★</span>
                                                <span class="star" data-rating="5">★</span>
                                            </div>
                                            <span class="rating-text ms-2 text-muted">별점을 선택해 주세요</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="review_headline" class="form-label">리뷰 제목 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="review_headline" name="headline" required placeholder="간단한 리뷰 제목을 입력하세요">
                                    </div>

                                    <div class="mb-3">
                                        <label for="review_content" class="form-label">리뷰 내용 <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="review_content" name="content" rows="4" required placeholder="상품에 대한 솔직한 후기를 남겨주세요"></textarea>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2" onclick="toggleReviewForm()">취소</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fe fe-send me-2"></i>리뷰 등록
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="reviews-list" id="reviewsList">
                        @if($testimonials->count() > 0)
                            @foreach($testimonials as $index => $testimonial)
                                <div class="review-item py-4 {{ $index > 0 ? 'border-top' : '' }}">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <!-- Avatar -->
                                            @if($testimonial->avatar)
                                                <img src="{{ $testimonial->avatar }}" alt="{{ $testimonial->name }}"
                                                     class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-2 mx-auto"
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fe fe-user text-muted"></i>
                                                </div>
                                            @endif
                                            <!-- Author Info -->
                                            <h6 class="mb-0">{{ $testimonial->name }}</h6>
                                            @if($testimonial->title || $testimonial->company)
                                                <small class="text-muted">
                                                    @if($testimonial->title){{ $testimonial->title }}@endif
                                                    @if($testimonial->title && $testimonial->company)<br>@endif
                                                    @if($testimonial->company){{ $testimonial->company }}@endif
                                                </small>
                                            @endif
                                            @if($testimonial->verified)
                                                <div class="mt-1">
                                                    <span class="badge bg-success badge-sm">인증됨</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <!-- Rating -->
                                            <div class="rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $testimonial->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 small text-muted">{{ $testimonial->rating }}/5</span>
                                                @if($testimonial->featured)
                                                    <span class="badge bg-warning text-dark ms-2">추천 리뷰</span>
                                                @endif
                                            </div>

                                            <!-- Review Content -->
                                            <h5 class="review-title">{{ $testimonial->headline }}</h5>
                                            <p class="review-text mb-3">{{ $testimonial->content }}</p>

                                            <!-- Review Footer -->
                                            <div class="review-footer d-flex justify-content-between align-items-center">
                                                <div class="review-meta text-muted small">
                                                    {{ \Carbon\Carbon::parse($testimonial->created_at)->format('Y년 m월 d일') }}
                                                </div>
                                                <div class="review-actions">
                                                    <button type="button" class="btn btn-link btn-sm p-0 like-btn"
                                                            data-testimonial-id="{{ $testimonial->id }}">
                                                        <i class="fe fe-heart me-1"></i>
                                                        <span class="likes-count">{{ number_format($testimonial->likes_count) }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fe fe-message-square text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-muted">아직 리뷰가 없습니다</h5>
                                <p class="text-muted">이 상품의 첫 번째 리뷰를 작성해보세요!</p>
                                <button class="btn btn-primary" onclick="toggleReviewForm()">
                                    <i class="fe fe-edit me-2"></i>리뷰 작성하기
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="related-products mt-5">
            <h4 class="mb-4">관련 상품</h4>
            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            @if($related->image)
                                <img src="{{ $related->image }}" class="card-img-top" alt="{{ $related->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fe fe-package text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $related->title }}</h6>
                                @if($related->description)
                                    <p class="card-text small text-muted flex-grow-1">{{ Str::limit($related->description, 60) }}</p>
                                @endif
                                <div class="mt-auto">
                                    @if($related->price)
                                        <div class="mb-2">
                                            @if($related->sale_price && $related->sale_price < $related->price)
                                                <small class="text-muted text-decoration-line-through">₩{{ number_format($related->price) }}</small><br>
                                                <strong class="text-danger">₩{{ number_format($related->sale_price) }}</strong>
                                            @else
                                                <strong>₩{{ number_format($related->price) }}</strong>
                                            @endif
                                        </div>
                                    @endif
                                    <a href="/product/{{ $related->slug ?: $related->id }}" class="btn btn-outline-primary btn-sm">
                                        자세히 보기
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.thumbnail {
    cursor: pointer;
    transition: opacity 0.3s;
}

.thumbnail:hover {
    opacity: 0.8;
}

.pricing-options .card {
    border: 1px solid #dee2e6;
    transition: border-color 0.3s, box-shadow 0.3s;
    cursor: pointer;
}

.pricing-options .card:hover {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.pricing-options .card.selected {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.pricing-option-card .form-check-input:checked + .form-check-label {
    color: #0d6efd;
}

.quantity-selection .input-group {
    border-radius: 0.375rem;
    overflow: hidden;
}

.quantity-selection .btn {
    border-radius: 0;
    min-width: 40px;
}

.quantity-selection .form-control {
    border-left: 0;
    border-right: 0;
}

.content, .specs {
    white-space: pre-wrap;
    word-wrap: break-word;
}

.product-stats {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}

/* Reviews Tab Styles */
.review-item {
    transition: background-color 0.2s ease;
}

.review-item:hover {
    background-color: #f8f9fa;
}

.review-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.review-text {
    line-height: 1.6;
    color: #555;
}

/* Star Rating Styles */
.star-rating {
    display: flex;
    align-items: center;
}

.stars-container {
    display: flex;
    gap: 5px;
}

.star {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s ease;
}

.star:hover,
.star.active {
    color: #ffc107;
}

.star:hover ~ .star {
    color: #ddd;
}

.rating-text {
    font-size: 0.9rem;
}

.rating-input .btn-group {
    flex-wrap: wrap;
    gap: 0.25rem;
}

.rating-input .btn {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

.like-btn {
    color: #6c757d;
    transition: color 0.3s ease;
    text-decoration: none !important;
}

.like-btn:hover {
    color: #dc3545;
}

.like-btn.liked {
    color: #dc3545;
}

.like-btn.liked .fe-heart:before {
    content: '\e92e'; /* filled heart */
}

.review-form {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.rating-summary .stars i {
    font-size: 1.1em;
}

.review-item .rating i {
    font-size: 0.9em;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .product-images .main-image {
        text-align: center;
    }

    .image-thumbnails .col-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .review-item .col-md-2 {
        text-align: left !important;
        margin-bottom: 1rem;
    }

    .review-item .row {
        flex-direction: column;
    }

    .rating-input .btn-group {
        justify-content: center;
    }

    .reviews-header .col-md-6 {
        text-align: center !important;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Change main product image
function changeMainImage(imageUrl) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.src = imageUrl;
    }
}

// Product Actions
function purchaseProduct() {
    // Direct purchase logic
    window.location.href = '/contact/create?product={{ $product->id }}&type=purchase';
}

function addToCart() {
    // 가격 옵션이 여러 개 있는지 확인
    const pricingOptions = document.querySelectorAll('input[name="pricing_option"]');
    const hasPricingOptions = pricingOptions.length > 0;

    // 선택된 가격 옵션 확인
    let pricingOptionId = null;
    const pricingForm = document.querySelector('input[name="pricing_option"]:checked');

    // 가격 옵션이 있는데 선택하지 않은 경우 에러 표시
    if (hasPricingOptions && !pricingForm) {
        showPricingError('가격 옵션을 선택해 주세요.');
        return;
    }

    if (pricingForm) {
        pricingOptionId = pricingForm.value;
    }

    // 수량 선택 (기본값 1)
    let quantity = 1;
    const quantityInput = document.querySelector('#quantity');
    if (quantityInput) {
        quantity = parseInt(quantityInput.value) || 1;
        if (quantity < 1 || quantity > 99) {
            showCartMessage('수량은 1개에서 99개 사이로 선택해 주세요.', 'error');
            return;
        }
    }

    // 에러 메시지 숨기기
    hidePricingError();

    // AJAX 요청으로 장바구니에 추가
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            item_type: 'product',
            item_id: {{ $product->id }},
            pricing_option_id: pricingOptionId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 성공 메시지 표시
            showCartMessage(data.message, 'success');

            // 장바구니 개수 업데이트 (전역 함수 사용)
            if (typeof window.updateCartCount === 'function') {
                window.updateCartCount();
            }
        } else {
            showCartMessage(data.message || '장바구니 추가 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showCartMessage('장바구니 추가 중 오류가 발생했습니다.', 'error');
    });
}

// 장바구니 메시지 표시
function showCartMessage(message, type = 'info') {
    // 기존 메시지 제거
    const existingMessage = document.querySelector('.cart-message');
    if (existingMessage) {
        existingMessage.remove();
    }

    // 새 메시지 생성
    const messageDiv = document.createElement('div');
    messageDiv.className = `cart-message alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    messageDiv.style.position = 'fixed';
    messageDiv.style.top = '20px';
    messageDiv.style.right = '20px';
    messageDiv.style.zIndex = '9999';
    messageDiv.style.minWidth = '300px';
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // 페이지에 추가
    document.body.appendChild(messageDiv);

    // 5초 후 자동 제거
    setTimeout(() => {
        if (messageDiv && messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
}

// 장바구니 개수 업데이트
function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'inline' : 'none';
    });
}

// 가격 옵션 에러 메시지 표시
function showPricingError(message) {
    const errorDiv = document.getElementById('pricingError');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// 가격 옵션 에러 메시지 숨기기
function hidePricingError() {
    const errorDiv = document.getElementById('pricingError');
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
}

// 수량 증가
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue < 99) {
            quantityInput.value = currentValue + 1;
        }
    }
}

// 수량 감소
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        let currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
}

function requestQuote() {
    // Request quote logic
    window.location.href = '/contact/create?product={{ $product->id }}&type=quote';
}

// Review Functions
function toggleReviewForm() {
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm.style.display === 'none') {
        reviewForm.style.display = 'block';
        reviewForm.scrollIntoView({ behavior: 'smooth' });
    } else {
        reviewForm.style.display = 'none';
    }
}

// Star Rating Functions
function initStarRating() {
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('ratingValue');
    const ratingText = document.querySelector('.rating-text');

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingValue.value = rating;

            // Update visual state
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });

            // Update text
            const ratingTexts = ['', '매우 나쁨', '나쁨', '보통', '좋음', '매우 좋음'];
            ratingText.textContent = ratingTexts[rating];
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });

    // Reset hover effect on mouse leave
    document.querySelector('.stars-container').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingValue.value) || 0;
        stars.forEach((s, i) => {
            if (i < currentRating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#ddd';
            }
        });
    });
}

// Handle testimonial form submission
document.addEventListener('DOMContentLoaded', function() {
    const testimonialForm = document.getElementById('testimonialForm');
    if (testimonialForm) {
        testimonialForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fe fe-loader me-2"></i>등록 중...';

            fetch('/testimonials', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert(data.message);

                    // Reset form
                    this.reset();

                    // Hide form
                    toggleReviewForm();

                    // Optionally reload the page to show the new review
                    // window.location.reload();
                } else {
                    alert('리뷰 등록 중 오류가 발생했습니다.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('리뷰 등록 중 오류가 발생했습니다.');
            })
            .finally(() => {
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });
    }

    // Handle like buttons in reviews tab
    document.querySelectorAll('#reviews .like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const testimonialId = this.dataset.testimonialId;
            const likesCountElement = this.querySelector('.likes-count');
            const heartIcon = this.querySelector('.fe-heart');

            fetch(`/testimonials/${testimonialId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.liked) {
                    this.classList.add('liked');
                } else {
                    this.classList.remove('liked');
                }

                likesCountElement.textContent = data.likes_count.toLocaleString();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    // Initialize star rating functionality
    initStarRating();
});

// Social Share Functions
function shareKakao() {
    if (typeof Kakao !== 'undefined') {
        Kakao.Share.sendDefault({
            objectType: 'commerce',
            content: {
                title: '{{ $product->title }}',
                description: '{{ $product->description }}',
                imageUrl: '{{ $product->image }}',
                link: {
                    mobileWebUrl: window.location.href,
                    webUrl: window.location.href
                }
            },
            commerce: {
                productName: '{{ $product->title }}',
                regularPrice: {{ $product->price ?: 0 }},
                discountPrice: {{ $product->sale_price ?: 0 }}
            }
        });
    } else {
        alert('카카오톡 공유 기능을 사용할 수 없습니다.');
    }
}

function shareFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareTwitter() {
    const text = encodeURIComponent('{{ $product->title }} - {{ $product->description }}');
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('상품 링크가 클립보드에 복사되었습니다.');
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('상품 링크가 클립보드에 복사되었습니다.');
    });
}

// Initialize Bootstrap tabs
document.addEventListener('DOMContentLoaded', function() {
    var triggerTabList = [].slice.call(document.querySelectorAll('#productTabs button'));
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
    });

    // 가격 옵션 선택 이벤트 처리
    const pricingOptions = document.querySelectorAll('input[name="pricing_option"]');
    pricingOptions.forEach(option => {
        option.addEventListener('change', function() {
            // 모든 카드에서 selected 클래스 제거
            document.querySelectorAll('.pricing-option-card').forEach(card => {
                card.classList.remove('selected');
            });

            // 선택된 옵션의 카드에 selected 클래스 추가
            if (this.checked) {
                const selectedCard = this.closest('.pricing-option-card');
                if (selectedCard) {
                    selectedCard.classList.add('selected');
                }
                hidePricingError();
            }
        });
    });

    // 가격 옵션 카드 클릭 시 라디오 버튼 선택
    document.querySelectorAll('.pricing-option-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // 라벨이나 input을 클릭한 경우는 자동으로 처리되므로 제외
            if (e.target.closest('.form-check')) {
                return;
            }

            const radio = this.querySelector('input[name="pricing_option"]');
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // 수량 입력 필드 검증
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > 99) {
                this.value = 99;
            }
        });

        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            if (!isNaN(value)) {
                if (value < 1) {
                    this.value = 1;
                } else if (value > 99) {
                    this.value = 99;
                }
            }
        });
    }
});
</script>
@endpush
