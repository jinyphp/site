@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $mode === 'create' ? 'Help 카테고리 생성' : 'Help 카테고리 수정')

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $mode === 'create' ? 'Help 카테고리 생성' : 'Help 카테고리 수정' }}</h2>
                    <p class="text-muted mb-0">카테고리 정보를 입력하세요.</p>
                </div>
                <div>
                    @php
                        $indexUrl = route('admin.cms.help.categories.index');
                        if (isset($returnParams) && !empty(array_filter($returnParams))) {
                            $indexUrl .= '?' . http_build_query($returnParams);
                        }
                    @endphp
                    <a href="{{ $indexUrl }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ $mode === 'create' ? route('admin.cms.help.categories.store') : route('admin.cms.help.categories.update', $category->id ?? '') }}">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif

        {{-- 페이지네이션 정보 보존을 위한 hidden fields --}}
        @if(isset($returnParams))
            @foreach($returnParams as $key => $value)
                @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        @endif

        <div class="row">
            <!-- 기본 정보 -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">기본 정보</h5>
                    </div>
                    <div class="card-body">
                        <!-- 카테고리 코드 -->
                        <div class="mb-3">
                            <label for="code" class="form-label">카테고리 코드 <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="code"
                                   name="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code', $category->code ?? '') }}"
                                   placeholder="영문, 숫자, 하이픈(-), 언더스코어(_)만 사용"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL에 사용되므로 영문, 숫자, 하이픈, 언더스코어만 사용하세요.</div>
                        </div>

                        <!-- 카테고리명 -->
                        <div class="mb-3">
                            <label for="title" class="form-label">카테고리명 <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $category->title ?? '') }}"
                                   placeholder="카테고리명을 입력하세요"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 설명 -->
                        <div class="mb-3">
                            <label for="content" class="form-label">설명</label>
                            <textarea id="content"
                                      name="content"
                                      class="form-control @error('content') is-invalid @enderror"
                                      rows="4"
                                      placeholder="카테고리에 대한 설명을 입력하세요">{{ old('content', $category->content ?? '') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 아이콘 -->
                        <div class="mb-3">
                            <label for="icon" class="form-label">아이콘</label>
                            <div class="input-group">
                                <input type="text"
                                       id="icon"
                                       name="icon"
                                       class="form-control @error('icon') is-invalid @enderror"
                                       value="{{ old('icon', $category->icon ?? '') }}"
                                       placeholder="예: fas fa-question-circle">
                                <button type="button" class="btn btn-outline-secondary" onclick="showIconPreview()">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                FontAwesome 아이콘 클래스를 입력하세요.
                                <a href="https://fontawesome.com/icons" target="_blank">아이콘 찾기</a>
                            </div>
                            <div id="icon-preview" class="mt-2"></div>
                        </div>

                        <!-- 이미지 -->
                        <div class="mb-3">
                            <label for="image" class="form-label">이미지</label>
                            <input type="text"
                                   id="image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   value="{{ old('image', $category->image ?? '') }}"
                                   placeholder="이미지 URL 또는 경로">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 설정 -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">설정</h5>
                    </div>
                    <div class="card-body">
                        <!-- 순서 -->
                        <div class="mb-3">
                            <label for="pos" class="form-label">표시 순서</label>
                            <input type="number"
                                   id="pos"
                                   name="pos"
                                   class="form-control @error('pos') is-invalid @enderror"
                                   value="{{ old('pos', $category->pos ?? '') }}"
                                   min="0"
                                   placeholder="숫자가 작을수록 먼저 표시">
                            @error('pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">비워두면 자동으로 마지막 순서로 설정됩니다.</div>
                        </div>

                        <!-- 상태 -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="enable" value="0">
                                <input type="checkbox"
                                       id="enable"
                                       name="enable"
                                       class="form-check-input"
                                       value="1"
                                       {{ old('enable', $category->enable ?? true) ? 'checked' : '' }}>
                                <label for="enable" class="form-check-label">
                                    활성 상태
                                </label>
                            </div>
                            <div class="form-text">비활성화하면 사용자에게 표시되지 않습니다.</div>
                        </div>
                    </div>
                </div>

                @if($mode === 'edit' && isset($category))
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">생성일</small><br>
                            <span>{{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d H:i:s') }}</span>
                        </div>
                        @if($category->updated_at)
                        <div class="mb-2">
                            <small class="text-muted">수정일</small><br>
                            <span>{{ \Carbon\Carbon::parse($category->updated_at)->format('Y-m-d H:i:s') }}</span>
                        </div>
                        @endif
                        @if($category->manager)
                        <div class="mb-2">
                            <small class="text-muted">관리자</small><br>
                            <span>{{ $category->manager }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- 저장 버튼 -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.cms.help.categories.index') }}" class="btn btn-secondary">
                        취소
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ $mode === 'create' ? '생성' : '수정' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// 아이콘 미리보기
function showIconPreview() {
    const iconClass = document.getElementById('icon').value;
    const preview = document.getElementById('icon-preview');

    if (iconClass.trim()) {
        preview.innerHTML = `<i class="${iconClass}" style="font-size: 24px;"></i> ${iconClass}`;
    } else {
        preview.innerHTML = '';
    }
}

// 실시간 아이콘 미리보기
document.getElementById('icon').addEventListener('input', showIconPreview);

// 페이지 로드시 아이콘 미리보기
document.addEventListener('DOMContentLoaded', showIconPreview);

// 코드 입력시 자동으로 소문자로 변환하고 공백을 하이픈으로 치환
document.getElementById('code').addEventListener('input', function() {
    this.value = this.value.toLowerCase().replace(/[^a-z0-9\-_]/g, '');
});

// 제목 입력시 코드 자동 생성 (생성 모드에서만)
@if($mode === 'create')
document.getElementById('title').addEventListener('input', function() {
    const codeField = document.getElementById('code');
    if (!codeField.value) {
        const code = this.value
            .toLowerCase()
            .replace(/[^a-z0-9ㄱ-ㅎㅏ-ㅣ가-힣\s]/g, '')
            .replace(/\s+/g, '-')
            .replace(/[ㄱ-ㅎㅏ-ㅣ가-힣]/g, '');
        codeField.value = code;
    }
});
@endif
</script>
@endpush
