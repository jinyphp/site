@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '국가 상세정보')

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
                                <i class="bi bi-globe2 me-2"></i>국가 상세정보
                            </h1>
                            <p class="page-header-subtitle">{{ $country->name }}의 상세 정보를 확인합니다.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.cms.country.edit', $country->id) }}" class="btn btn-warning me-2">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.cms.country.index') }}" class="btn btn-outline-secondary">
                                <i class="fe fe-arrow-left me-2"></i>목록으로 돌아가기
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['total_countrys'] }}</h4>
                            <p class="text-muted mb-0">전체 국가</p>
                        </div>
                        <div class="icon-shape icon-md bg-primary text-white rounded-3">
                            <i class="bi bi-globe"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $stats['active_countrys'] }}</h4>
                            <p class="text-muted mb-0">활성 국가</p>
                        </div>
                        <div class="icon-shape icon-md bg-success text-white rounded-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">{{ $country->order ?? 0 }}</h4>
                            <p class="text-muted mb-0">표시 순서</p>
                        </div>
                        <div class="icon-shape icon-md bg-info text-white rounded-3">
                            <i class="bi bi-sort-numeric-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold">
                                @if($country->is_default)
                                    <span class="badge bg-warning">기본</span>
                                @elseif($country->enable)
                                    <span class="badge bg-success">활성</span>
                                @else
                                    <span class="badge bg-secondary">비활성</span>
                                @endif
                            </h4>
                            <p class="text-muted mb-0">상태</p>
                        </div>
                        <div class="icon-shape icon-md bg-warning text-white rounded-3">
                            <i class="bi bi-flag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 국가 정보 -->
    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">국가 정보</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">국가 코드</label>
                                <div class="p-3 bg-light rounded">
                                    <span class="badge bg-primary fs-6">{{ $country->code }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">국가명</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->name ?: '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">원어명</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->native_name ?: '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">수도</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->capital ?: '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">국기</label>
                                <div class="p-3 bg-light rounded">
                                    @if($country->flag)
                                        <span style="font-size: 2rem;">{{ $country->flag }}</span>
                                        <span class="ms-2">{{ $country->flag }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">통화</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->currency ?: '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">전화번호 코드</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->phone_code ?: '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">지역</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->region ?: '-' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">관리자</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->manager ?: 'System' }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">표시 순서</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->order ?? 0 }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">상태</label>
                                <div class="p-3 bg-light rounded">
                                    @if($country->is_default)
                                        <span class="badge bg-warning me-2">기본 국가</span>
                                    @endif
                                    @if($country->enable)
                                        <span class="badge bg-success">활성화</span>
                                    @else
                                        <span class="badge bg-secondary">비활성화</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">설명</label>
                                <div class="p-3 bg-light rounded">
                                    @if($country->description)
                                        {!! nl2br(e($country->description)) !!}
                                    @else
                                        <em class="text-muted">설명이 없습니다.</em>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">생성일</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->created_at ? $country->created_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">최종 수정일</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $country->updated_at ? $country->updated_at->format('Y-m-d H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 액션 버튼 -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('admin.cms.country.edit', $country->id) }}" class="btn btn-warning me-2">
                                <i class="fe fe-edit me-2"></i>수정
                            </a>
                            <a href="{{ route('admin.cms.country.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fe fe-list me-2"></i>목록
                            </a>
                        </div>
                        <div>
                            @if($stats['can_delete'])
                                <form action="{{ route('admin.cms.country.destroy', $country->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('정말로 {{ $country->name }} 국가를 삭제하시겠습니까?\n\n이 작업은 되돌릴 수 없습니다.')">
                                        <i class="fe fe-trash me-2"></i>삭제
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-danger" disabled title="{{ $stats['delete_warning'] }}">
                                    <i class="fe fe-trash me-2"></i>삭제
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 도움말 및 경고 -->
        <div class="col-xl-4 col-lg-12">
            @if($stats['delete_warning'])
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning bg-opacity-10">
                    <h5 class="card-title mb-0 text-warning">
                        <i class="fe fe-alert-triangle me-2"></i>경고
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $stats['delete_warning'] }}</p>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-info me-2"></i>정보
                    </h5>
                </div>
                <div class="card-body">
                    <h6>국가 코드</h6>
                    <p class="text-muted small mb-3">ISO 639-1 표준을 따르는 2글자 국가 코드입니다.</p>

                    <h6>기본 국가</h6>
                    <p class="text-muted small mb-3">시스템의 기본 국가는 삭제하거나 비활성화할 수 없습니다.</p>

                    <h6>표시 순서</h6>
                    <p class="text-muted small mb-3">숫자가 작을수록 앞에 표시됩니다.</p>

                    <h6>상태 정보</h6>
                    <ul class="text-muted small mb-0">
                        <li><strong>기본</strong>: 시스템 기본 국가</li>
                        <li><strong>활성</strong>: 사용 가능한 국가</li>
                        <li><strong>비활성</strong>: 사용 불가능한 국가</li>
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

.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-md {
    width: 48px;
    height: 48px;
}
</style>
@endsection
