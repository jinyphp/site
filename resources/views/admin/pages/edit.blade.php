@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '페이지 수정: ' . $page->title)

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
                                <i class="fe fe-edit me-2"></i>
                                페이지 수정
                            </h1>
                            <p class="page-header-subtitle">{{ $page->title }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.pages.show', $page->id) }}" class="btn btn-outline-info">
                                <i class="fe fe-eye me-2"></i>보기
                            </a>
                            <a href="{{ route('admin.cms.pages.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.cms.pages.update', $page->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- 메인 콘텐츠 -->
            <div class="col-lg-8">
                <!-- 탭 네비게이션 -->
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="pageEditTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
                                    <i class="fe fe-edit-2 me-2"></i>기본 정보
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab">
                                    <i class="fe fe-search me-2"></i>SEO 설정
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="pageEditTabsContent">
                            <!-- 기본 정보 탭 -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <!-- 제목 -->
                        <div class="mb-3">
                            <label for="title" class="form-label">제목 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
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
                                       id="slug" name="slug" value="{{ old('slug', $page->slug) }}">
                            </div>
                            <div class="form-text">URL에 사용될 슬러그입니다.</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 요약 -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">요약</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt" name="excerpt" rows="3"
                                      placeholder="페이지에 대한 간단한 설명을 입력하세요">{{ old('excerpt', $page->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 내용 -->
                        <div class="mb-3">
                            <label for="content" class="form-label">내용</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="15"
                                      placeholder="페이지 내용을 입력하세요">{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                            </div>


                            <!-- SEO 설정 탭 -->
                            <div class="tab-pane fade" id="seo" role="tabpanel">
                        <!-- 메타 제목 -->
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">메타 제목</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                   id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
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
                                      placeholder="검색엔진에 표시될 설명">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 메타 키워드 -->
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">메타 키워드</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}"
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
                                   id="og_title" name="og_title" value="{{ old('og_title', $page->og_title) }}"
                                   placeholder="소셜 미디어에 표시될 제목">
                            @error('og_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_description" class="form-label">OG 설명</label>
                            <textarea class="form-control @error('og_description') is-invalid @enderror"
                                      id="og_description" name="og_description" rows="3"
                                      placeholder="소셜 미디어에 표시될 설명">{{ old('og_description', $page->og_description) }}</textarea>
                            @error('og_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="og_image" class="form-label">OG 이미지</label>
                            <input type="url" class="form-control @error('og_image') is-invalid @enderror"
                                   id="og_image" name="og_image" value="{{ old('og_image', $page->og_image) }}"
                                   placeholder="https://example.com/image.jpg">
                            @error('og_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                                </div>
                            </div>
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
                                <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>임시저장</option>
                                <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>발행</option>
                                <option value="private" {{ old('status', $page->status) === 'private' ? 'selected' : '' }}>비공개</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 발행일 -->
                        <div class="mb-3">
                            <label for="published_at" class="form-label">발행일</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                   id="published_at" name="published_at"
                                   value="{{ old('published_at', $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="form-text">비워두면 현재 시간으로 설정됩니다.</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 추천 페이지 -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured"
                                       value="1" {{ old('is_featured', $page->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    추천 페이지로 설정
                                </label>
                            </div>
                        </div>

                        <!-- 정렬 순서 -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">정렬 순서</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0">
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
                                <option value="" {{ old('template', $page->template) === '' ? 'selected' : '' }}>기본 템플릿</option>
                                @foreach($templates as $key => $name)
                                    <option value="{{ $key }}" {{ old('template', $page->template) === $key ? 'selected' : '' }}>
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

                <!-- 페이지 정보 -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">페이지 정보</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-3">
                            <tr>
                                <th width="80">조회수:</th>
                                <td>{{ number_format($page->view_count) }}</td>
                            </tr>
                            <tr>
                                <th>작성일:</th>
                                <td>{{ $page->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @if($page->updated_at->ne($page->created_at))
                            <tr>
                                <th>수정일:</th>
                                <td>{{ $page->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- 작업 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>수정 저장
                            </button>
                            <a href="{{ $page->url }}" class="btn btn-outline-info" target="_blank">
                                <i class="fe fe-eye me-2"></i>미리보기
                            </a>
                            <a href="{{ route('admin.cms.pages.show', $page->id) }}" class="btn btn-outline-secondary">
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

// 제목에서 슬러그 자동 생성 (기존 슬러그가 비어있을 때만)
document.getElementById('title').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    const currentSlug = slugField.dataset.original || '{{ $page->slug }}';

    if (slugField.value === currentSlug || slugField.value === '') {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugField.value = slug;
    }
});

// 슬러그 필드에 원본 값 저장
document.getElementById('slug').dataset.original = '{{ $page->slug }}';
</script>

@endpush
