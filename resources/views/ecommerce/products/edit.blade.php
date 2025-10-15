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
                    <p class="text-muted mb-0">상품 정보를 수정합니다.</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 상품 수정 폼 -->
    <form method="POST" action="{{ route('admin.site.products.update', $product->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="title" class="form-label">상품명 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $product->title) }}"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">간단 설명</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="content" class="form-label">상세 설명</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          name="content"
                                          rows="10">{{ old('content', $product->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 이미지 및 추가 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">이미지 및 추가 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">대표 이미지 URL</label>
                                <input type="url"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       value="{{ old('image', $product->image) }}">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($product->image)
                                    <div class="mt-2">
                                        <img src="{{ $product->image }}" alt="미리보기" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 mb-3">
                                <label for="features" class="form-label">주요 특징</label>
                                <textarea class="form-control @error('features') is-invalid @enderror"
                                          id="features"
                                          name="features"
                                          rows="4"
                                          placeholder="JSON 형식으로 입력하세요. 예: [&quot;특징1&quot;, &quot;특징2&quot;, &quot;특징3&quot;]">{{ old('features', $product->features) }}</textarea>
                                @error('features')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="specifications" class="form-label">제품 사양</label>
                                <textarea class="form-control @error('specifications') is-invalid @enderror"
                                          id="specifications"
                                          name="specifications"
                                          rows="4"
                                          placeholder="JSON 형식으로 입력하세요. 예: {&quot;크기&quot;: &quot;100x50cm&quot;, &quot;무게&quot;: &quot;2kg&quot;}">{{ old('specifications', $product->specifications) }}</textarea>
                                @error('specifications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="tags" class="form-label">태그</label>
                                <input type="text"
                                       class="form-control @error('tags') is-invalid @enderror"
                                       id="tags"
                                       name="tags"
                                       value="{{ old('tags', $product->tags) }}"
                                       placeholder="쉼표로 구분하여 입력하세요. 예: IT, 소프트웨어, 솔루션">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 정보 -->
            <div class="col-lg-4">
                <!-- 판매 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">판매 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">카테고리</label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
                                    id="category_id"
                                    name="category_id">
                                <option value="">카테고리 선택</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->display_title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">기본 정가 (원)</label>
                            <input type="number"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price"
                                   name="price"
                                   value="{{ old('price', $product->price) }}"
                                   step="0.01"
                                   min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">기본 가격입니다. 상세한 가격 옵션은 별도로 관리됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">기본 할인가 (원)</label>
                            <input type="number"
                                   class="form-control @error('sale_price') is-invalid @enderror"
                                   id="sale_price"
                                   name="sale_price"
                                   value="{{ old('sale_price', $product->sale_price) }}"
                                   step="0.01"
                                   min="0">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">기본 할인가입니다. 상세한 할인 옵션은 별도로 관리됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('admin.site.products.pricing.index', $product->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fe fe-tag me-2"></i>가격 옵션 관리
                            </a>
                            <div class="form-text mt-2">다양한 가격 옵션을 설정하고 관리하세요.</div>
                        </div>
                    </div>
                </div>

                <!-- 상태 설정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">상태 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="enable"
                                       name="enable"
                                       value="1"
                                       {{ old('enable', $product->enable) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    판매 활성화
                                </label>
                            </div>
                            <div class="form-text">체크하면 고객에게 노출됩니다.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="featured"
                                       name="featured"
                                       value="1"
                                       {{ old('featured', $product->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    추천 상품
                                </label>
                            </div>
                            <div class="form-text">추천 상품으로 표시됩니다.</div>
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 설정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">액션 버튼 설정</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">상품 상세 페이지에서 표시할 액션 버튼을 선택하세요.</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="enable_purchase"
                                           name="enable_purchase"
                                           value="1"
                                           {{ old('enable_purchase', $product->enable_purchase ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_purchase">
                                        <strong>구매 버튼</strong>
                                    </label>
                                    <div class="form-text">고객이 직접 구매를 요청할 수 있습니다.</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="enable_cart"
                                           name="enable_cart"
                                           value="1"
                                           {{ old('enable_cart', $product->enable_cart ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_cart">
                                        <strong>장바구니 버튼</strong>
                                    </label>
                                    <div class="form-text">상품을 장바구니에 담을 수 있습니다.</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="enable_quote"
                                           name="enable_quote"
                                           value="1"
                                           {{ old('enable_quote', $product->enable_quote ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_quote">
                                        <strong>견적 버튼</strong>
                                    </label>
                                    <div class="form-text">고객이 견적을 요청할 수 있습니다.</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="enable_contact"
                                           name="enable_contact"
                                           value="1"
                                           {{ old('enable_contact', $product->enable_contact ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_contact">
                                        <strong>문의하기 버튼</strong>
                                    </label>
                                    <div class="form-text">상품에 대한 문의를 받을 수 있습니다.</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="enable_social_share"
                                           name="enable_social_share"
                                           value="1"
                                           {{ old('enable_social_share', $product->enable_social_share ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_social_share">
                                        <strong>소셜 공유</strong>
                                    </label>
                                    <div class="form-text">SNS 공유 버튼을 표시합니다.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO 설정 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">SEO 설정</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">메타 제목</label>
                            <input type="text"
                                   class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title"
                                   name="meta_title"
                                   value="{{ old('meta_title', $product->meta_title) }}">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">메타 설명</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description"
                                      name="meta_description"
                                      rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 메타 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">메타 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">슬러그:</small> <code>{{ $product->slug }}</code>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">등록일:</small> {{ \Carbon\Carbon::parse($product->created_at)->format('Y-m-d H:i:s') }}
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">수정일:</small> {{ \Carbon\Carbon::parse($product->updated_at)->format('Y-m-d H:i:s') }}
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>변경사항 저장
                            </button>
                            <a href="{{ route('admin.site.products.show', $product->id) }}" class="btn btn-outline-info">
                                <i class="fe fe-eye me-2"></i>상품 보기
                            </a>
                            <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-x me-2"></i>취소
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// 폼 제출 전 JSON 유효성 검사
document.querySelector('form').addEventListener('submit', function(e) {
    const features = document.getElementById('features').value;
    const specifications = document.getElementById('specifications').value;

    if (features && features.trim()) {
        try {
            JSON.parse(features);
        } catch (error) {
            alert('주요 특징 필드의 JSON 형식이 올바르지 않습니다.');
            e.preventDefault();
            return;
        }
    }

    if (specifications && specifications.trim()) {
        try {
            JSON.parse(specifications);
        } catch (error) {
            alert('제품 사양 필드의 JSON 형식이 올바르지 않습니다.');
            e.preventDefault();
            return;
        }
    }
});
</script>
@endpush
