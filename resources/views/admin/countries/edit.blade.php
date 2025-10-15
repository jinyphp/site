@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '국가 수정')

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
                                <i class="bi bi-globe2 me-2"></i>국가 수정
                            </h1>
                            <p class="page-header-subtitle">국가 정보를 수정합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.country.index') }}" class="btn btn-outline-secondary">
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
                    <h4 class="card-title mb-0">국가 정보</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cms.country.update', $country->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">국가 코드 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="code"
                                           name="code"
                                           value="{{ old('code', $country->code) }}"
                                           placeholder="예: KR, US, JP"
                                           maxlength="3"
                                           required>
                                    <div class="form-text">ISO 3166-1 alpha-2/3 국가 코드를 입력하세요</div>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capital" class="form-label">수도</label>
                                    <input type="text"
                                           class="form-control @error('capital') is-invalid @enderror"
                                           id="capital"
                                           name="capital"
                                           value="{{ old('capital', $country->capital) }}"
                                           placeholder="예: 서울, 워싱턴 D.C.">
                                    <div class="form-text">국가의 수도를 입력하세요</div>
                                    @error('capital')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">국가명 <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $country->name) }}"
                                           placeholder="예: 대한민국, 미국"
                                           required>
                                    <div class="form-text">사용자에게 표시될 국가명</div>
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
                                           value="{{ old('native_name', $country->native_name) }}"
                                           placeholder="예: South Korea, United States">
                                    <div class="form-text">해당 국가로 표기된 국가명</div>
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
                                              placeholder="국가에 대한 설명을 입력하세요">{{ old('description', $country->description) }}</textarea>
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
                                           value="{{ old('flag', $country->flag) }}"
                                           placeholder="예: 🇰🇷, 🇺🇸">
                                    <div class="form-text">국기 이모지를 입력하세요</div>
                                    @error('flag')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">통화</label>
                                    <input type="text"
                                           class="form-control @error('currency') is-invalid @enderror"
                                           id="currency"
                                           name="currency"
                                           value="{{ old('currency', $country->currency) }}"
                                           placeholder="예: KRW, USD">
                                    <div class="form-text">통화 코드를 입력하세요</div>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="phone_code" class="form-label">전화번호 코드</label>
                                    <input type="text"
                                           class="form-control @error('phone_code') is-invalid @enderror"
                                           id="phone_code"
                                           name="phone_code"
                                           value="{{ old('phone_code', $country->phone_code) }}"
                                           placeholder="예: +82, +1">
                                    <div class="form-text">국제 전화번호 코드</div>
                                    @error('phone_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="region" class="form-label">지역</label>
                                    <input type="text"
                                           class="form-control @error('region') is-invalid @enderror"
                                           id="region"
                                           name="region"
                                           value="{{ old('region', $country->region) }}"
                                           placeholder="예: Asia, Europe">
                                    <div class="form-text">국가가 속한 지역</div>
                                    @error('region')
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
                                           value="{{ old('manager', $country->manager ?? 'System') }}"
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
                                           value="{{ old('order', $country->order ?? 0) }}"
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
                                                   {{ old('enable', $country->enable) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enable">
                                                <strong>활성화</strong>
                                                <div class="text-muted small">이 국가를 사용할 수 있도록 설정</div>
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
                                                   {{ old('is_default', $country->is_default) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_default">
                                                <strong>기본 국가</strong>
                                                <div class="text-muted small">시스템의 기본 국가로 설정</div>
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
                                    <i class="fe fe-save me-2"></i>수정
                                </button>
                                <a href="{{ route('admin.cms.country.show', $country->id) }}" class="btn btn-info me-2">
                                    <i class="fe fe-eye me-2"></i>상세보기
                                </a>
                                <a href="{{ route('admin.cms.country.index') }}" class="btn btn-outline-secondary">
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
                    <h6>국가 코드</h6>
                    <p class="text-muted small">ISO 3166-1 alpha-2/3 표준을 따르는 국가 코드를 입력하세요. 예: KR(한국), US(미국), JP(일본)</p>

                    <h6>수도</h6>
                    <p class="text-muted small">해당 국가의 수도를 입력합니다. 예: 서울, 워싱턴 D.C., 도쿄</p>

                    <h6>통화 및 전화번호</h6>
                    <p class="text-muted small">통화는 ISO 4217 코드를, 전화번호는 국제 코드를 입력하세요.</p>

                    <h6>기본 국가</h6>
                    <p class="text-muted small">시스템의 기본 국가는 하나만 설정할 수 있습니다. 새로 설정하면 기존 기본 국가는 자동으로 해제됩니다.</p>

                    <h6>일반적인 국가 정보</h6>
                    <ul class="list-unstyled text-muted small">
                        <li>🇰🇷 KR - 대한민국 (KRW, +82)</li>
                        <li>🇺🇸 US - 미국 (USD, +1)</li>
                        <li>🇯🇵 JP - 일본 (JPY, +81)</li>
                        <li>🇨🇳 CN - 중국 (CNY, +86)</li>
                        <li>🇬🇧 GB - 영국 (GBP, +44)</li>
                        <li>🇫🇷 FR - 프랑스 (EUR, +33)</li>
                        <li>🇩🇪 DE - 독일 (EUR, +49)</li>
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
