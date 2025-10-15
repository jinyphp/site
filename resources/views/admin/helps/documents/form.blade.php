@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $mode === 'create' ? 'Help 문서 생성' : 'Help 문서 수정')

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $mode === 'create' ? 'Help 문서 생성' : 'Help 문서 수정' }}</h2>
                    <p class="text-muted mb-0">
                        {{ $mode === 'create' ? '새로운 Help 문서를 생성합니다.' : 'Help 문서 정보를 수정합니다.' }}
                    </p>
                </div>
                <div>
                    @php
                        $indexUrl = route('admin.cms.help.docs.index');
                        if (isset($returnParams) && !empty(array_filter($returnParams))) {
                            $indexUrl .= '?' . http_build_query($returnParams);
                        }
                    @endphp
                    <a href="{{ $indexUrl }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>목록으로
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 폼 -->
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Help 문서 정보</h5>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ $mode === 'create' ? route('admin.cms.help.docs.store') : route('admin.cms.help.docs.update', $help->id ?? '') }}">
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
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">제목 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="Help 문서 제목을 입력하세요"
                                           value="{{ old('title', $help->title ?? '') }}"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">카테고리</label>
                                    <select id="category"
                                            name="category"
                                            class="form-control @error('category') is-invalid @enderror">
                                        <option value="">카테고리 선택</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->code }}"
                                                    {{ old('category', $help->category ?? '') === $category->code ? 'selected' : '' }}>
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
                                <div class="form-group mb-3">
                                    <label for="order" class="form-label">정렬 순서</label>
                                    <input type="number"
                                           id="order"
                                           name="order"
                                           class="form-control @error('order') is-invalid @enderror"
                                           placeholder="정렬 순서 (숫자)"
                                           value="{{ old('order', $help->order ?? '') }}"
                                           min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">빈 칸으로 두면 자동으로 마지막 순서로 설정됩니다.</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="content" class="form-label">내용 <span class="text-danger">*</span></label>
                                    <textarea id="content"
                                              name="content"
                                              class="form-control @error('content') is-invalid @enderror"
                                              rows="15"
                                              placeholder="Help 문서 내용을 입력하세요"
                                              required>{{ old('content', $help->content ?? '') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">마크다운 문법을 사용할 수 있습니다.</small>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox"
                                           id="enable"
                                           name="enable"
                                           class="form-check-input"
                                           value="1"
                                           {{ old('enable', $help->enable ?? true) ? 'checked' : '' }}>
                                    <label for="enable" class="form-check-label">
                                        게시 상태
                                    </label>
                                    <small class="form-text text-muted d-block">체크하면 사용자에게 공개됩니다.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.cms.help.docs.index') }}" class="btn btn-outline-secondary">
                                취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>
                                {{ $mode === 'create' ? '생성' : '수정' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 도움말 사이드바 -->
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">도움말</h5>
                </div>
                <div class="card-body">
                    <h6>마크다운 문법 예시</h6>
                    <ul class="small text-muted">
                        <li><code># 제목</code> - 대제목</li>
                        <li><code>## 소제목</code> - 소제목</li>
                        <li><code>**굵은글씨**</code> - 굵은 글씨</li>
                        <li><code>*기울임*</code> - 기울임 글씨</li>
                        <li><code>`코드`</code> - 인라인 코드</li>
                        <li><code>- 목록</code> - 순서 없는 목록</li>
                        <li><code>1. 번호목록</code> - 순서 있는 목록</li>
                    </ul>

                    <hr>

                    <h6>작성 팁</h6>
                    <ul class="small text-muted">
                        <li>명확하고 구체적인 제목을 사용하세요</li>
                        <li>단계별로 설명하면 이해하기 쉽습니다</li>
                        <li>스크린샷을 활용하면 도움이 됩니다</li>
                        <li>관련 문서 링크를 포함하세요</li>
                    </ul>
                </div>
            </div>

            @if($mode === 'edit' && isset($help))
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">문서 정보</h5>
                </div>
                <div class="card-body">
                    <dl class="row small">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $help->id }}</dd>

                        <dt class="col-sm-4">조회수</dt>
                        <dd class="col-sm-8">{{ number_format($help->views) }}회</dd>

                        <dt class="col-sm-4">생성일</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($help->created_at)->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-4">수정일</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($help->updated_at)->format('Y-m-d H:i') }}</dd>
                    </dl>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 자동 저장 기능 (선택사항)
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');

    // 폼 변경 감지
    let hasChanges = false;
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            hasChanges = true;
        });
    });

    // 페이지 이탈 시 경고
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // 폼 제출 시 변경사항 플래그 해제
    form.addEventListener('submit', () => {
        hasChanges = false;
    });
});
</script>
@endpush
