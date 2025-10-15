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
                        <i class="fe fe-edit me-2"></i>
                        {{ $config['title'] }}
                    </h1>
                    <p class="page-header-subtitle">{{ $config['subtitle'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ 카테고리 수정 폼 -->
    <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">FAQ 카테고리 정보</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.faq.categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">코드 <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                           value="{{ old('code', $category->code) }}" required>
                                    <div class="form-text">영문, 숫자, 언더스코어만 사용 가능</div>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">순서</label>
                                    <input type="number" name="pos" class="form-control @error('pos') is-invalid @enderror"
                                           value="{{ old('pos', $category->pos) }}" min="0">
                                    <div class="form-text">비워두면 자동으로 마지막 순서로 설정</div>
                                    @error('pos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">카테고리명 <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $category->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">설명</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="3">{{ old('content', $category->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">아이콘</label>
                                    <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                           value="{{ old('icon', $category->icon) }}" placeholder="예: fe fe-help-circle">
                                    <div class="form-text">Feather Icons 클래스명</div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">이미지</label>
                                    <input type="text" name="image" class="form-control @error('image') is-invalid @enderror"
                                           value="{{ old('image', $category->image) }}" placeholder="이미지 URL">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="enable" class="form-check-input" id="enable"
                                       value="1" {{ old('enable', $category->enable) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    활성화
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.cms.faq.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>수정
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
