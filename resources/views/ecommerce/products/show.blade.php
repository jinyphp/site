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
                    <p class="text-muted mb-0">상품의 상세 정보를 확인합니다.</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                    <a href="@if(isset($product->category_slug) && $product->category_slug)/product/{{ $product->category_slug }}/{{ $product->slug ?: $product->id }}@elseif(isset($product->category_id) && $product->category_id)/product/{{ $product->category_id }}/{{ $product->slug ?: $product->id }}@else/product/{{ $product->slug ?: $product->id }}@endif" class="btn btn-outline-info me-2" target="_blank">
                        <i class="fe fe-external-link me-2"></i>사이트에서 보기
                    </a>
                    <a href="{{ route('admin.site.products.edit', $product->id) }}" class="btn btn-primary">
                        <i class="fe fe-edit me-2"></i>수정
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 메인 컨텐츠 -->
        <div class="col-lg-8">
            <!-- 기본 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">기본 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($product->image)
                            <div class="col-md-3 mb-3">
                                <img src="{{ $product->image }}" alt="{{ $product->title }}"
                                     class="img-fluid rounded">
                            </div>
                        @endif
                        <div class="col-md-{{ $product->image ? '9' : '12' }}">
                            <h3 class="mb-3">{{ $product->title }}</h3>

                            @if($product->description)
                                <div class="mb-3">
                                    <h6>간단 설명</h6>
                                    <p class="text-muted">{{ $product->description }}</p>
                                </div>
                            @endif

                            @if($product->content)
                                <div class="mb-3">
                                    <h6>상세 설명</h6>
                                    <div class="border p-3 bg-light rounded">
                                        {!! nl2br(e($product->content)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 가격 옵션 -->
            @if($pricingOptions->count() > 0)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">가격 옵션 ({{ $pricingOptions->count() }}개)</h5>
                        <a href="{{ route('admin.site.products.pricing.index', $product->id) }}"
                           class="btn btn-outline-warning btn-sm">
                            <i class="fe fe-tag me-1"></i>관리
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>옵션명</th>
                                        <th width="120">가격</th>
                                        <th width="120">할인가</th>
                                        <th width="100">결제주기</th>
                                        <th width="80">상태</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pricingOptions as $pricing)
                                    <tr>
                                        <td>
                                            <strong>{{ $pricing->name }}</strong>
                                            @if($pricing->description)
                                                <br><small class="text-muted">{{ Str::limit($pricing->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $pricing->currency }} {{ number_format($pricing->price) }}</strong>
                                        </td>
                                        <td>
                                            @if($pricing->sale_price && $pricing->sale_price < $pricing->price)
                                                <strong class="text-danger">{{ $pricing->currency }} {{ number_format($pricing->sale_price) }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pricing->billing_period)
                                                <span class="badge bg-info">{{ $pricing->billing_period }}</span>
                                            @else
                                                <span class="text-muted">일회성</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pricing->enable)
                                                <span class="badge bg-success">활성</span>
                                            @else
                                                <span class="badge bg-secondary">비활성</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 이미지 갤러리 -->
            @if($images->count() > 0)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">이미지 갤러리 ({{ $images->count() }}개)</h5>
                        <a href="{{ route('admin.site.products.images.index', $product->id) }}"
                           class="btn btn-outline-success btn-sm">
                            <i class="fe fe-image me-1"></i>관리
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?: $product->title }}"
                                             class="img-fluid rounded">
                                        @if($image->is_featured)
                                            <span class="position-absolute top-0 start-0 badge bg-warning m-2">대표</span>
                                        @endif
                                    </div>
                                    @if($image->description)
                                        <small class="text-muted d-block mt-1">{{ $image->description }}</small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- 제품 상세 정보 -->
            @if($product->features || $product->specifications || $product->tags)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">제품 상세 정보</h5>
                    </div>
                    <div class="card-body">
                        @if($product->features)
                            <div class="mb-3">
                                <h6>주요 특징</h6>
                                <div class="border p-3 bg-light rounded">
                                    <pre class="mb-0">{{ $product->features }}</pre>
                                </div>
                            </div>
                        @endif

                        @if($product->specifications)
                            <div class="mb-3">
                                <h6>제품 사양</h6>
                                <div class="border p-3 bg-light rounded">
                                    <pre class="mb-0">{{ $product->specifications }}</pre>
                                </div>
                            </div>
                        @endif

                        @if($product->tags)
                            <div class="mb-3">
                                <h6>태그</h6>
                                <p class="mb-0">{{ $product->tags }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 상품 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">상품 정보</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="80">ID</th>
                            <td>{{ $product->id }}</td>
                        </tr>
                        <tr>
                            <th>카테고리</th>
                            <td>
                                @if($product->category_name)
                                    <span class="badge bg-light text-dark">{{ $product->category_name }}</span>
                                @else
                                    <span class="text-muted">미분류</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>기본 가격</th>
                            <td>
                                @if($product->price)
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <small class="text-muted text-decoration-line-through">₩{{ number_format($product->price) }}</small><br>
                                        <strong class="text-danger">₩{{ number_format($product->sale_price) }}</strong>
                                    @else
                                        <strong>₩{{ number_format($product->price) }}</strong>
                                    @endif
                                @else
                                    <span class="text-muted">가격미정</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>판매 상태</th>
                            <td>
                                @if($product->enable)
                                    <span class="badge bg-success">판매중</span>
                                @else
                                    <span class="badge bg-secondary">준비중</span>
                                @endif
                            </td>
                        </tr>
                        @if($product->featured)
                            <tr>
                                <th>추천 상품</th>
                                <td><span class="badge bg-warning text-dark">추천</span></td>
                            </tr>
                        @endif
                        <tr>
                            <th>등록일</th>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($product->created_at)->format('Y-m-d H:i') }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>조회수</th>
                            <td>
                                <span class="badge bg-info">{{ number_format($product->view_count) }}회</span>
                            </td>
                        </tr>
                        <tr>
                            <th>수정일</th>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($product->updated_at)->format('Y-m-d H:i') }}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- SEO 정보 -->
            @if($product->meta_title || $product->meta_description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO 정보</h5>
                    </div>
                    <div class="card-body">
                        @if($product->meta_title)
                            <div class="mb-3">
                                <h6>메타 제목</h6>
                                <p class="mb-0">{{ $product->meta_title }}</p>
                            </div>
                        @endif

                        @if($product->meta_description)
                            <div class="mb-3">
                                <h6>메타 설명</h6>
                                <p class="mb-0">{{ $product->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 관리 액션 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">관리</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="@if(isset($product->category_slug) && $product->category_slug)/product/{{ $product->category_slug }}/{{ $product->slug ?: $product->id }}@elseif(isset($product->category_id) && $product->category_id)/product/{{ $product->category_id }}/{{ $product->slug ?: $product->id }}@else/product/{{ $product->slug ?: $product->id }}@endif" class="btn btn-outline-info" target="_blank">
                            <i class="fe fe-external-link me-2"></i>사이트에서 보기
                        </a>
                        <hr>
                        <a href="{{ route('admin.site.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>수정
                        </a>
                        <a href="{{ route('admin.site.products.images.index', $product->id) }}" class="btn btn-outline-success">
                            <i class="fe fe-image me-2"></i>이미지 갤러리 관리
                        </a>
                        <a href="{{ route('admin.site.products.pricing.index', $product->id) }}" class="btn btn-outline-warning">
                            <i class="fe fe-tag me-2"></i>가격 옵션 관리
                        </a>
                        <a href="{{ route('admin.site.testimonials.item', ['type' => 'product', 'itemId' => $product->id]) }}" class="btn btn-outline-purple">
                            <i class="fe fe-message-square me-2"></i>고객 후기 관리
                        </a>
                        <hr>
                        <button type="button" class="btn btn-outline-danger" onclick="deleteProduct()">
                            <i class="fe fe-trash-2 me-2"></i>삭제
                        </button>
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
                <form id="deleteForm" method="POST" action="{{ route('admin.site.products.destroy', $product->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 삭제 확인
function deleteProduct() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
