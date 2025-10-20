@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '페이지 생성')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="fe fe-plus me-2"></i>
                                새 페이지 생성
                            </h1>
                            <p class="page-header-subtitle">새로운 정적 페이지를 생성합니다</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.cms.pages.store') }}">
        @csrf
        <div class="row">
            <!-- 메인 콘텐츠 -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">기본 정보</h4>
                    </div>
                    <div class="card-body">
                        <!-- 제목 -->
                        <div class="mb-3">
                            <label for="title" class="form-label">제목 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 슬러그 -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">URL 슬러그</label>
                            <div class="input-group">
                                <span class="input-group-text">/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug') }}"
                                       placeholder="자동으로 생성됩니다">
                            </div>
                            <div class="form-text">URL에 사용될 슬러그입니다. 비워두면 제목에서 자동 생성됩니다.</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 요약 -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">요약</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt" name="excerpt" rows="3"
                                      placeholder="페이지에 대한 간단한 설명을 입력하세요">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 내용 -->
                        <div class="mb-3">
                            <label for="content" class="form-label">내용</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15"
                                      placeholder="페이지 내용을 입력하세요">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO 설정 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SEO 설정</h4>
                    </div>
                    <div class="card-body">
                        <!-- 메타 제목 -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">메타 제목</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                   placeholder="검색엔진에 표시될 제목">
                            <div class="form-text">비워두면 페이지 제목이 사용됩니다.</div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 메타 설명 -->
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">메타 설명</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                      id="meta_description" name="meta_description" rows="3"
                                      placeholder="검색엔진에 표시될 설명">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 메타 키워드 -->
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">메타 키워드</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                                   placeholder="키워드1, 키워드2, 키워드3">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Open Graph 설정 -->
                        <h5 class="mt-4 mb-3">Open Graph 설정</h5>

                        <div class="mb-3">
                            <label for="og_title" class="form-label">OG 제목</label>
                            <input type="text" class="form-control @error('og_title') is-invalid @enderror"
                                   id="og_title" name="og_title" value="{{ old('og_title') }}"
                                   placeholder="소셜 미디어에 표시될 제목">
                            @error('og_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_description" class="form-label">OG 설명</label>
                            <textarea class="form-control @error('og_description') is-invalid @enderror"
                                      id="og_description" name="og_description" rows="3"
                                      placeholder="소셜 미디어에 표시될 설명">{{ old('og_description') }}</textarea>
                            @error('og_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label">OG 이미지</label>
                            <input type="url" class="form-control @error('og_image') is-invalid @enderror"
                                   id="og_image" name="og_image" value="{{ old('og_image') }}"
                                   placeholder="https://example.com/image.jpg">
                            @error('og_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 -->
            <div class="col-lg-4">
                <!-- 발행 설정 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">발행 설정</h4>
                    </div>
                    <div class="card-body">
                        <!-- 상태 -->
                        <div class="mb-3">
                            <label for="status" class="form-label">상태 <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>임시저장</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>발행</option>
                                <option value="private" {{ old('status') === 'private' ? 'selected' : '' }}>비공개</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 발행일 -->
                        <div class="mb-3">
                            <label for="published_at" class="form-label">발행일</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            <div class="form-text">비워두면 현재 시간으로 설정됩니다.</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 추천 페이지 -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured"
                                       value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    추천 페이지로 설정
                                </label>
                            </div>
                        </div>

                        <!-- 정렬 순서 -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">정렬 순서</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-text">숫자가 작을수록 먼저 표시됩니다.</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 템플릿 설정 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">템플릿 설정</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="template" class="form-label">템플릿</label>
                            <select class="form-select @error('template') is-invalid @enderror" id="template" name="template">
                                <option value="">기본 템플릿</option>
                                @foreach($templates as $key => $name)
                                    <option value="{{ $key }}" {{ old('template') === $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 작업 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>페이지 생성
                            </button>
                            <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-secondary">
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
// 슬러그 필드 수동 편집 추적
const slugField = document.getElementById('slug');
slugField.dataset.manuallyEdited = 'false';

// 슬러그 필드 수동 편집 감지
slugField.addEventListener('input', function() {
    this.dataset.manuallyEdited = 'true';
});

// 제목에서 슬러그 자동 생성 (수동으로 편집되지 않았을 때만)
document.getElementById('title').addEventListener('input', function() {
    const isManuallyEdited = slugField.dataset.manuallyEdited === 'true';

    // 슬러그가 비어있고, 수동으로 편집되지 않았을 때만 자동 생성
    if (!isManuallyEdited && slugField.value === '') {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9\s\/-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    }
});

// 메타 제목 자동 복사
document.getElementById('title').addEventListener('input', function() {
    if (document.getElementById('meta_title').value === '') {
        document.getElementById('meta_title').value = this.value;
    }
});

// OG 제목 자동 복사
document.getElementById('meta_title').addEventListener('input', function() {
    if (document.getElementById('og_title').value === '') {
        document.getElementById('og_title').value = this.value;
    }
});

// 메타 설명에서 OG 설명 자동 복사
document.getElementById('meta_description').addEventListener('input', function() {
    if (document.getElementById('og_description').value === '') {
        document.getElementById('og_description').value = this.value;
    }
});

// 발행 상태 변경 시 발행일 설정
document.getElementById('status').addEventListener('change', function() {
    const publishedAtField = document.getElementById('published_at');
    if (this.value === 'published' && publishedAtField.value === '') {
        const now = new Date();
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
            .toISOString()
            .slice(0, 16);
        publishedAtField.value = localDateTime;
    }
});
</script>
@endpush
