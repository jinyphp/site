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
                            <li class="breadcrumb-item active" aria-current="page">수정</li>
                        </ol>
                    </nav>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 수정 폼 -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">카테고리 수정</h5>
                </div>
                <form action="{{ route('admin.site.products.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">카테고리명 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', $category->title) }}"
                                           required
                                           maxlength="255">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="code" class="form-label">코드 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           id="code"
                                           name="code"
                                           class="form-control @error('code') is-invalid @enderror"
                                           value="{{ old('code', $category->code) }}"
                                           required
                                           maxlength="100"
                                           placeholder="영문, 숫자만 입력">
                                    <small class="form-text text-muted">
                                        영문, 숫자, 하이픈만 사용 가능
                                    </small>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="slug" class="form-label">슬러그</label>
                                    <input type="text"
                                           id="slug"
                                           name="slug"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug', $category->slug) }}"
                                           maxlength="255"
                                           placeholder="자동 생성됩니다">
                                    <small class="form-text text-muted">
                                        비워두면 카테고리명으로 자동 생성됩니다
                                    </small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="parent_id" class="form-label">상위 카테고리</label>
                                    <select id="parent_id"
                                            name="parent_id"
                                            class="form-control @error('parent_id') is-invalid @enderror">
                                        <option value="">최상위 카테고리</option>
                                        @foreach($parentCategories as $parent)
                                            <option value="{{ $parent->id }}"
                                                    {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="pos" class="form-label">정렬 순서</label>
                                    <input type="number"
                                           id="pos"
                                           name="pos"
                                           class="form-control @error('pos') is-invalid @enderror"
                                           value="{{ old('pos', $category->pos) }}"
                                           min="0">
                                    <small class="form-text text-muted">
                                        숫자가 작을수록 앞에 표시됩니다
                                    </small>
                                    @error('pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">설명</label>
                            <textarea id="description"
                                      name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="카테고리에 대한 설명을 입력하세요">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">카테고리 이미지</label>
                                    <input type="url"
                                           id="image"
                                           name="image"
                                           class="form-control @error('image') is-invalid @enderror"
                                           value="{{ old('image', $category->image) }}"
                                           placeholder="이미지 URL을 입력하세요">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="icon" class="form-label">아이콘</label>
                                    <input type="text"
                                           id="icon"
                                           name="icon"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           value="{{ old('icon', $category->icon) }}"
                                           placeholder="예: fe fe-box, bi bi-laptop">
                                    <small class="form-text text-muted">
                                        Feather Icons 또는 Bootstrap Icons 클래스명
                                    </small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="color" class="form-label">컬러</label>
                                    <input type="color"
                                           id="color"
                                           name="color"
                                           class="form-control form-control-color @error('color') is-invalid @enderror"
                                           value="{{ old('color', $category->color) }}"
                                           title="카테고리 컬러를 선택하세요">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO 메타 정보 -->
                        <div class="border-top pt-4 mt-4">
                            <h6 class="mb-3">SEO 메타 정보</h6>

                            <div class="form-group mb-3">
                                <label for="meta_title" class="form-label">메타 제목</label>
                                <input type="text"
                                       id="meta_title"
                                       name="meta_title"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       value="{{ old('meta_title', $category->meta_title) }}"
                                       maxlength="255"
                                       placeholder="검색엔진에 표시될 제목">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="meta_description" class="form-label">메타 설명</label>
                                <textarea id="meta_description"
                                          name="meta_description"
                                          class="form-control @error('meta_description') is-invalid @enderror"
                                          rows="3"
                                          maxlength="500"
                                          placeholder="검색엔진에 표시될 설명">{{ old('meta_description', $category->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox"
                                   id="enable"
                                   name="enable"
                                   class="form-check-input"
                                   value="1"
                                   {{ old('enable', $category->enable) ? 'checked' : '' }}>
                            <label for="enable" class="form-check-label">활성화</label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.site.products.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>수정 완료
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- 카테고리 정보 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">카테고리 정보</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">생성일</label>
                        <div>{{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d H:i:s') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">수정일</label>
                        <div>{{ \Carbon\Carbon::parse($category->updated_at)->format('Y-m-d H:i:s') }}</div>
                    </div>

                    @if($category->parent)
                    <div class="mb-3">
                        <label class="form-label text-muted small">현재 상위 카테고리</label>
                        <div>
                            <a href="{{ route('admin.site.products.categories.edit', $category->parent->id) }}"
                               class="text-decoration-none">
                                {{ $category->parent->title }}
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="mb-3">
                        <label class="form-label text-muted small">현재 상위 카테고리</label>
                        <div class="text-muted">최상위 카테고리</div>
                    </div>
                    @endif

                    @if($subCategories && $subCategories->count() > 0)
                    <div class="mb-3">
                        <label class="form-label text-muted small">하위 카테고리 ({{ $subCategories->count() }}개)</label>
                        <div class="small">
                            @foreach($subCategories as $sub)
                                <div class="mb-1">
                                    <a href="{{ route('admin.site.products.categories.edit', $sub->id) }}"
                                       class="text-decoration-none">
                                        {{ $sub->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label text-muted small">상태</label>
                        <div>
                            @if($category->enable)
                                <span class="badge bg-success">활성</span>
                            @else
                                <span class="badge bg-secondary">비활성</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 미리보기 -->
            @if($category->image || $category->icon)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">미리보기</h6>
                </div>
                <div class="card-body text-center">
                    @if($category->image)
                        <img src="{{ $category->image }}"
                             alt="{{ $category->name }}"
                             class="img-fluid mb-2 rounded"
                             style="max-height: 100px;">
                    @elseif($category->icon)
                        <div class="mb-2">
                            <i class="{{ $category->icon }} fa-3x text-primary"></i>
                        </div>
                    @endif
                    <div class="small text-muted">{{ $category->name }}</div>
                </div>
            </div>
            @endif

            <!-- 도움말 -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">도움말</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2">
                            <i class="fe fe-info me-1"></i>
                            카테고리명은 필수 입력 항목입니다.
                        </li>
                        <li class="mb-2">
                            <i class="fe fe-info me-1"></i>
                            슬러그는 URL에 사용되며, 비워두면 자동 생성됩니다.
                        </li>
                        <li class="mb-2">
                            <i class="fe fe-info me-1"></i>
                            상위 카테고리를 선택하여 계층 구조를 만들 수 있습니다.
                        </li>
                        <li class="mb-2">
                            <i class="fe fe-info me-1"></i>
                            정렬 순서는 같은 레벨 내에서 표시 순서를 결정합니다.
                        </li>
                        <li>
                            <i class="fe fe-info me-1"></i>
                            하위 카테고리가 있는 경우 삭제할 수 없습니다.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 카테고리명으로 슬러그 자동 생성
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .replace(/[^\w가-힣\s-]/g, '') // 특수문자 제거 (한글, 영문, 숫자, 공백, 하이픈만 허용)
        .replace(/\s+/g, '-') // 공백을 하이픈으로 변경
        .replace(/--+/g, '-') // 연속된 하이픈을 하나로
        .trim();

    // 슬러그 필드가 비어있거나 자동생성된 값인 경우에만 업데이트
    const slugField = document.getElementById('slug');
    if (!slugField.value || slugField.dataset.autoGenerated === 'true') {
        slugField.value = slug;
        slugField.dataset.autoGenerated = 'true';
    }
});

// 슬러그 직접 수정 시 자동생성 플래그 해제
document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
});

// 아이콘 미리보기
document.getElementById('icon').addEventListener('input', function() {
    const iconClass = this.value;
    // 간단한 아이콘 미리보기 (선택적)
});

// 이미지 URL 유효성 검증
document.getElementById('image').addEventListener('blur', function() {
    const url = this.value;
    if (url && !url.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
        // 이미지 URL 형식 체크 (선택적)
    }
});
</script>
@endpush
