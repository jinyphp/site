@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <h1 class="page-header-title">
                        <i class="fe fe-help-circle me-2"></i>
                        {{ $config['title'] }}
                    </h1>
                    <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ 생성 폼 -->
    <div class="row">
        <div class="col-xl-10 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">FAQ 정보</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.faq.faqs.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">카테고리</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                                        <option value="">카테고리 선택</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->code }}" {{ old('category') == $category->code ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">순서</label>
                                    <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                                           value="{{ old('order') }}" min="0">
                                    <div class="form-text">비워두면 자동으로 마지막 순서로 설정</div>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">질문 <span class="text-danger">*</span></label>
                            <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
                                   value="{{ old('question') }}" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">답변 <span class="text-danger">*</span></label>
                            <textarea name="answer" class="form-control @error('answer') is-invalid @enderror"
                                      rows="10" required>{{ old('answer') }}</textarea>
                            <div class="form-text">HTML 태그 사용 가능</div>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="enable" class="form-check-input" id="enable"
                                       value="1" {{ old('enable', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    게시하기
                                </label>
                                <div class="form-text">체크 해제 시 초안으로 저장됩니다.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.faq.faqs.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>저장
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// 간단한 WYSIWYG 에디터가 필요한 경우 여기에 추가
// 예: CKEditor, TinyMCE 등
</script>
@endpush
@endsection
