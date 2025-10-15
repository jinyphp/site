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
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.services.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>카테고리 목록
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 카테고리 등록 폼 -->
    <form method="POST" action="{{ route('admin.site.services.categories.store') }}">
        @csrf

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">카테고리 코드 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('code') is-invalid @enderror"
                                       id="code"
                                       name="code"
                                       value="{{ old('code') }}"
                                       required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">영문, 숫자, 하이픈만 사용 가능합니다.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">카테고리명 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">설명</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">카테고리 이미지 URL</label>
                                <input type="url"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       value="{{ old('image') }}">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="color" class="form-label">카테고리 색상</label>
                                <input type="color"
                                       class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color"
                                       name="color"
                                       value="{{ old('color', '#6c757d') }}">
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="icon" class="form-label">아이콘 클래스</label>
                                <input type="text"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       id="icon"
                                       name="icon"
                                       value="{{ old('icon') }}"
                                       placeholder="예: fe fe-briefcase">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="meta_title" class="form-label">메타 제목</label>
                                <input type="text"
                                       class="form-control @error('meta_title') is-invalid @enderror"
                                       id="meta_title"
                                       name="meta_title"
                                       value="{{ old('meta_title') }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="meta_description" class="form-label">메타 설명</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                          id="meta_description"
                                          name="meta_description"
                                          rows="3">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 사이드바 정보 -->
            <div class="col-lg-4">
                <!-- 계층 구조 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">계층 구조</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">부모 카테고리</label>
                            <select id="parent_id" name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                <option value="">최상위 카테고리</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pos" class="form-label">정렬 순서</label>
                            <input type="number"
                                   class="form-control @error('pos') is-invalid @enderror"
                                   id="pos"
                                   name="pos"
                                   value="{{ old('pos', 0) }}"
                                   min="0">
                            @error('pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">숫자가 작을수록 먼저 표시됩니다.</div>
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
                                       {{ old('enable', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable">
                                    카테고리 활성화
                                </label>
                            </div>
                            <div class="form-text">체크하면 고객에게 노출됩니다.</div>
                        </div>
                    </div>
                </div>

                <!-- 액션 버튼 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>카테고리 등록
                            </button>
                            <a href="{{ route('admin.site.services.categories.index') }}" class="btn btn-outline-secondary">
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
