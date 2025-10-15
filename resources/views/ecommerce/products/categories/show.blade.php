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
                                <a href="{{ route('admin.site.products.categories.index') }}" class="text-decoration-none">
                                    상품 카테고리
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $category->title }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.categories.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                    </a>
                    <a href="{{ route('admin.site.products.categories.edit', $category->id) }}" class="btn btn-primary">
                        <i class="fe fe-edit me-2"></i>수정
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 기본 정보 -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">카테고리 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">카테고리명</label>
                                <div class="fw-bold">{{ $category->title }}</div>
                            </div>

                            @if($category->slug)
                            <div class="mb-4">
                                <label class="form-label text-muted small">슬러그</label>
                                <div class="font-monospace text-primary">{{ $category->slug }}</div>
                            </div>
                            @endif

                            @if($category->parent)
                            <div class="mb-4">
                                <label class="form-label text-muted small">상위 카테고리</label>
                                <div>
                                    <a href="{{ route('admin.site.products.categories.show', $category->parent->id) }}"
                                       class="text-decoration-none">
                                        {{ $category->parent->title }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label text-muted small">정렬 순서</label>
                                <div>{{ $category->pos ?? 0 }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted small">상태</label>
                                <div>
                                    @if($category->enable)
                                        <span class="badge bg-success fs-6">활성</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">비활성</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">생성일</label>
                                <div>{{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d H:i:s') }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small">수정일</label>
                                <div>{{ \Carbon\Carbon::parse($category->updated_at)->format('Y-m-d H:i:s') }}</div>
                            </div>
                        </div>
                    </div>

                    @if($category->description)
                    <div class="mb-4">
                        <label class="form-label text-muted small">설명</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($category->description)) !!}
                        </div>
                    </div>
                    @endif

                    @if($category->image || $category->icon)
                    <div class="mb-4">
                        <label class="form-label text-muted small">이미지/아이콘</label>
                        <div class="d-flex align-items-center">
                            @if($category->image)
                                <img src="{{ $category->image }}"
                                     alt="{{ $category->title }}"
                                     class="me-3 rounded"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                            @if($category->icon)
                                <div class="me-3">
                                    <i class="{{ $category->icon }} fa-2x text-primary"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- SEO 정보 -->
                    @if($category->meta_title || $category->meta_description)
                    <div class="border-top pt-4">
                        <h6 class="mb-3">SEO 메타 정보</h6>

                        @if($category->meta_title)
                        <div class="mb-3">
                            <label class="form-label text-muted small">메타 제목</label>
                            <div>{{ $category->meta_title }}</div>
                        </div>
                        @endif

                        @if($category->meta_description)
                        <div class="mb-3">
                            <label class="form-label text-muted small">메타 설명</label>
                            <div class="text-muted">{{ $category->meta_description }}</div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- 하위 카테고리 -->
            @if($subCategories && $subCategories->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">하위 카테고리 ({{ $subCategories->count() }}개)</h5>
                        <a href="{{ route('admin.site.products.categories.create') }}?parent_id={{ $category->id }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fe fe-plus me-1"></i>하위 카테고리 추가
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>이름</th>
                                    <th>슬러그</th>
                                    <th>순서</th>
                                    <th>상태</th>
                                    <th width="100">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subCategories as $sub)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($sub->icon)
                                                <i class="{{ $sub->icon }} me-2 text-primary"></i>
                                            @elseif($sub->image)
                                                <img src="{{ $sub->image }}"
                                                     alt="{{ $sub->title }}"
                                                     class="me-2 rounded"
                                                     style="width: 24px; height: 24px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.site.products.categories.show', $sub->id) }}"
                                                   class="text-decoration-none fw-bold">
                                                    {{ $sub->title }}
                                                </a>
                                                @if($sub->description)
                                                    <br><small class="text-muted">{{ Str::limit($sub->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($sub->slug)
                                            <code class="small">{{ $sub->slug }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $sub->pos ?? 0 }}</td>
                                    <td>
                                        @if($sub->enable)
                                            <span class="badge bg-success">활성</span>
                                        @else
                                            <span class="badge bg-secondary">비활성</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.site.products.categories.show', $sub->id) }}"
                                               class="btn btn-outline-info" title="보기">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.site.products.categories.edit', $sub->id) }}"
                                               class="btn btn-outline-primary" title="수정">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- 이 카테고리의 상품들 -->
            @if($products && $products->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">카테고리 상품 ({{ $products->count() }}개)</h5>
                        <a href="{{ route('admin.site.products.create') }}?category_id={{ $category->id }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fe fe-plus me-1"></i>상품 추가
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>상품</th>
                                    <th>가격</th>
                                    <th>상태</th>
                                    <th width="100">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                                <img src="{{ $product->image }}"
                                                     alt="{{ $product->title }}"
                                                     class="me-3 rounded"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fe fe-package text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.site.products.show', $product->id) }}"
                                                   class="text-decoration-none fw-bold">
                                                    {{ $product->title }}
                                                </a>
                                                @if($product->featured)
                                                    <span class="badge bg-warning text-dark ms-1">추천</span>
                                                @endif
                                                @if($product->description)
                                                    <br><small class="text-muted">{{ Str::limit(strip_tags($product->description), 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
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
                                    <td>
                                        @if($product->enable)
                                            <span class="badge bg-success">판매중</span>
                                        @else
                                            <span class="badge bg-secondary">준비중</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.site.products.show', $product->id) }}"
                                               class="btn btn-outline-info" title="보기">
                                                <i class="fe fe-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.site.products.edit', $product->id) }}"
                                               class="btn btn-outline-primary" title="수정">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- 사이드바 -->
        <div class="col-lg-4">
            <!-- 통계 정보 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">통계 정보</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="fs-4 fw-bold text-primary">{{ $subCategories ? $subCategories->count() : 0 }}</div>
                                <div class="small text-muted">하위 카테고리</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="fs-4 fw-bold text-success">{{ $products ? $products->count() : 0 }}</div>
                            <div class="small text-muted">등록 상품</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 계층 구조 -->
            @if($category->parent || $subCategories && $subCategories->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">카테고리 계층</h6>
                </div>
                <div class="card-body">
                    @if($category->parent)
                        <div class="mb-2">
                            <small class="text-muted">상위:</small>
                            <a href="{{ route('admin.site.products.categories.show', $category->parent->id) }}"
                               class="text-decoration-none">
                                {{ $category->parent->title }}
                            </a>
                        </div>
                    @endif

                    <div class="mb-2">
                        <small class="text-muted">현재:</small>
                        <strong>{{ $category->title }}</strong>
                    </div>

                    @if($subCategories && $subCategories->count() > 0)
                        <div>
                            <small class="text-muted">하위:</small>
                            <ul class="list-unstyled ms-3 mb-0">
                                @foreach($subCategories as $sub)
                                <li class="mb-1">
                                    <a href="{{ route('admin.site.products.categories.show', $sub->id) }}"
                                       class="text-decoration-none small">
                                        {{ $sub->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- 관리 메뉴 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">관리</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.site.products.categories.edit', $category->id) }}"
                           class="btn btn-outline-primary">
                            <i class="fe fe-edit me-2"></i>카테고리 수정
                        </a>

                        <a href="{{ route('admin.site.products.categories.create') }}?parent_id={{ $category->id }}"
                           class="btn btn-outline-success">
                            <i class="fe fe-plus me-2"></i>하위 카테고리 추가
                        </a>

                        <a href="{{ route('admin.site.products.create') }}?category_id={{ $category->id }}"
                           class="btn btn-outline-info">
                            <i class="fe fe-package me-2"></i>상품 추가
                        </a>

                        @if(!$subCategories || $subCategories->count() === 0)
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="deleteCategory({{ $category->id }})">
                            <i class="fe fe-trash-2 me-2"></i>카테고리 삭제
                        </button>
                        @else
                        <button type="button"
                                class="btn btn-outline-secondary"
                                disabled
                                title="하위 카테고리가 있어 삭제할 수 없습니다">
                            <i class="fe fe-trash-2 me-2"></i>삭제 불가
                        </button>
                        @endif
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
                <h5 class="modal-title">카테고리 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 카테고리를 삭제하시겠습니까?</p>
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

@push('scripts')
<script>
// 삭제 확인
function deleteCategory(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/site/products/categories/${id}`;
    modal.show();
}
</script>
@endpush
