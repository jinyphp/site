@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '언어 추가')

@section('content')
<div class="container-fluid p-6">
    <!-- Page Header -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-header-title">
                                <i class="bi bi-translate me-2"></i>언어 추가
                            </h1>
                            <p class="page-header-subtitle">새로운 언어를 시스템에 추가합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.language.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">언어 정보</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.language.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lang" class="form-label">언어 코드 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('lang') is-invalid @enderror"
                                           id="lang"
                                           name="lang"
                                           value="{{ old('lang') }}"
                                           placeholder="예: ko, en, ja"
                                           required>
                                    <div class="form-text">ISO 639-1 언어 코드를 입력하세요</div>
                                    @error('lang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="locale" class="form-label">로케일</label>
                                    <input type="text"
                                           class="form-control @error('locale') is-invalid @enderror"
                                           id="locale"
                                           name="locale"
                                           value="{{ old('locale') }}"
                                           placeholder="예: ko_KR, en_US">
                                    <div class="form-text">언어와 지역을 조합한 로케일</div>
                                    @error('locale')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">언어명 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="예: 한국어, English"
                                           required>
                                    <div class="form-text">사용자에게 표시될 언어명</div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="native_name" class="form-label">원어명</label>
                                    <input type="text"
                                           class="form-control @error('native_name') is-invalid @enderror"
                                           id="native_name"
                                           name="native_name"
                                           value="{{ old('native_name') }}"
                                           placeholder="예: 한국어, English, 日本語">
                                    <div class="form-text">해당 언어로 표기된 언어명</div>
                                    @error('native_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="description" class="form-label">설명</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="3"
                                              placeholder="언어에 대한 설명을 입력하세요">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="flag" class="form-label">국기 이모지</label>
                                    <input type="text"
                                           class="form-control @error('flag') is-invalid @enderror"
                                           id="flag"
                                           name="flag"
                                           value="{{ old('flag') }}"
                                           placeholder="예: 🇰🇷, 🇺🇸">
                                    <div class="form-text">국기 이모지를 입력하세요</div>
                                    @error('flag')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manager" class="form-label">관리자</label>
                                    <input type="text"
                                           class="form-control @error('manager') is-invalid @enderror"
                                           id="manager"
                                           name="manager"
                                           value="{{ old('manager', 'System') }}"
                                           placeholder="관리자명">
                                    @error('manager')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">순서</label>
                                    <input type="number"
                                           class="form-control @error('order') is-invalid @enderror"
                                           id="order"
                                           name="order"
                                           value="{{ old('order', 0) }}"
                                           min="0">
                                    <div class="form-text">숫자가 작을수록 앞에 표시됩니다</div>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 설정 옵션 -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">설정 옵션</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   id="enable"
                                                   name="enable"
                                                   value="1"
                                                   {{ old('enable', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enable">
                                                <strong>활성화</strong>
                                                <div class="text-muted small">이 언어를 사용할 수 있도록 설정</div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   id="is_default"
                                                   name="is_default"
                                                   value="1"
                                                   {{ old('is_default') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_default">
                                                <strong>기본 언어</strong>
                                                <div class="text-muted small">시스템의 기본 언어로 설정</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 버튼 그룹 -->
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fe fe-save me-2"></i>저장
                                </button>
                                <a href="{{ route('admin.cms.language.index') }}" class="btn btn-outline-secondary">
                                    <i class="fe fe-x me-2"></i>취소
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 도움말 패널 -->
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-help-circle me-2"></i>도움말
                    </h5>
                </div>
                <div class="card-body">
                    <h6>언어 코드</h6>
                    <p class="text-muted small">ISO 639-1 표준을 따르는 2글자 언어 코드를 입력하세요. 예: ko(한국어), en(영어), ja(일본어)</p>

                    <h6>로케일</h6>
                    <p class="text-muted small">언어_지역 형태로 입력합니다. 예: ko_KR(한국), en_US(미국), ja_JP(일본)</p>

                    <h6>기본 언어</h6>
                    <p class="text-muted small">시스템의 기본 언어는 하나만 설정할 수 있습니다. 새로 설정하면 기존 기본 언어는 자동으로 해제됩니다.</p>

                    <h6>일반적인 언어 코드</h6>
                    <ul class="list-unstyled text-muted small">
                        <li>🇰🇷 ko - 한국어</li>
                        <li>🇺🇸 en - English</li>
                        <li>🇯🇵 ja - 日本語</li>
                        <li>🇨🇳 zh - 中文</li>
                        <li>🇪🇸 es - Español</li>
                        <li>🇫🇷 fr - Français</li>
                        <li>🇩🇪 de - Deutsch</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.page-header-subtitle {
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endsection
