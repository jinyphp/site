{{-- 배송 방식 관리 --}}
@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page Header -->
            <div class="border-bottom pb-3 mb-3 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
                <div>
                    <h1 class="mb-0 h2 fw-bold">{{ $config['title'] }}</h1>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.dashboard') }}">대시보드</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.shipping.index') }}">배송 관리</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">배송 방식</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body">
                        <i class="fe fe-download me-2"></i>내보내기
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.shipping.index') }}" class="me-2 btn btn-outline-secondary">
                        <i class="fe fe-home me-2"></i>배송 대시보드
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMethodModal">
                        <i class="fe fe-plus me-2"></i>방식 추가
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1">{{ $stats['total'] }}</h4>
                    <p class="text-muted mb-0 small">총 방식</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-success">{{ $stats['active'] }}</h4>
                    <p class="text-muted mb-0 small">활성</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-danger">{{ $stats['inactive'] }}</h4>
                    <p class="text-muted mb-0 small">비활성</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-info">{{ $stats['trackable'] }}</h4>
                    <p class="text-muted mb-0 small">추적 가능</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-warning">{{ $stats['signature_required'] }}</h4>
                    <p class="text-muted mb-0 small">서명 필요</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 배송 방식 목록 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">배송 방식 목록</h4>
                </div>

                <!-- 검색 및 필터 -->
                <div class="card-body border-bottom">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">검색</label>
                            <input type="search" class="form-control" name="search" value="{{ $search }}" placeholder="방식명 또는 코드 검색">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">상태</label>
                            <select class="form-select" name="status">
                                <option value="">전체 상태</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>활성</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>비활성</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">추적 가능</label>
                            <select class="form-select" name="trackable">
                                <option value="">전체</option>
                                <option value="1" {{ $trackable === '1' ? 'selected' : '' }}>가능</option>
                                <option value="0" {{ $trackable === '0' ? 'selected' : '' }}>불가능</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">서명 필요</label>
                            <select class="form-select" name="signature">
                                <option value="">전체</option>
                                <option value="1" {{ $signature === '1' ? 'selected' : '' }}>필요</option>
                                <option value="0" {{ $signature === '0' ? 'selected' : '' }}>불필요</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">보험 가능</label>
                            <select class="form-select" name="insurance">
                                <option value="">전체</option>
                                <option value="1" {{ $insurance === '1' ? 'selected' : '' }}>가능</option>
                                <option value="0" {{ $insurance === '0' ? 'selected' : '' }}>불가능</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">검색</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>순서</th>
                                <th>방식명</th>
                                <th>코드</th>
                                <th>배송 기간</th>
                                <th>제한사항</th>
                                <th class="text-center">특성</th>
                                <th class="text-center">요금 수</th>
                                <th class="text-center">가격 범위</th>
                                <th class="text-center">상태</th>
                                <th class="text-center">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($methods as $method)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $method->order }}</span>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $method->name_ko ?: $method->name }}</h6>
                                        @if($method->name_ko && $method->name !== $method->name_ko)
                                            <small class="text-muted">{{ $method->name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light-secondary text-secondary">{{ $method->code }}</span>
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">
                                        {{ $method->delivery_time }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        @if($method->weight_limit)
                                            <small class="text-muted d-block">무게: {{ $method->weight_limit }}kg 이하</small>
                                        @endif
                                        @if($method->size_limit)
                                            <small class="text-muted d-block">크기: {{ $method->size_limit }}</small>
                                        @endif
                                        @if(!$method->weight_limit && !$method->size_limit)
                                            <span class="text-muted">제한 없음</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        @if($method->is_trackable)
                                            <span class="badge bg-light-info text-info">추적 가능</span>
                                        @endif
                                        @if($method->is_signature_required)
                                            <span class="badge bg-light-warning text-warning">서명필요</span>
                                        @endif
                                        @if($method->is_insurance_available)
                                            <span class="badge bg-light-success text-success">보험 가능</span>
                                        @endif
                                        @if(!$method->is_trackable && !$method->is_signature_required && !$method->is_insurance_available)
                                            <span class="text-muted">기본</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light-primary text-primary">{{ $method->rate_count }}개</span>
                                </td>
                                <td class="text-center">
                                    @if($method->rate_count > 0)
                                        <div>
                                            <small class="text-muted">₩{{ number_format($method->min_cost) }}</small>
                                            <br>
                                            <small class="text-muted">~ ₩{{ number_format($method->max_cost) }}</small>
                                        </div>
                                        <small class="text-info">(평균: ₩{{ number_format($method->avg_cost) }})</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($method->enable)
                                        <span class="badge bg-light-success text-success">활성</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">비활성</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            관리
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i>상세보기</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-dollar-sign me-2"></i>요금 관리</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>복사</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                @if($method->enable)
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye-off me-2"></i>비활성화</a>
                                                @else
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i>활성화</a>
                                                @endif
                                            </li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fe fe-truck fs-1 mb-3"></i>
                                        <p>배송 방식이 없습니다.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMethodModal">
                                            첫 번째 방식 추가하기
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($methods->hasPages())
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-0">
                                {{ $methods->firstItem() }}-{{ $methods->lastItem() }} / {{ $methods->total() }} 개
                            </p>
                        </div>
                        <div>
                            {{ $methods->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 방식 추가 모달 -->
<div class="modal fade" id="addMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">배송 방식 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">방식명 (한국어) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: 일반 배송">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">방식명 (영어) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: Standard Shipping">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">코드 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: STANDARD">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">순서</label>
                            <input type="number" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">상태</label>
                            <select class="form-select">
                                <option value="1">활성</option>
                                <option value="0">비활성</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">배송 기간 (한국어)</label>
                            <input type="text" class="form-control" placeholder="예: 2-3일">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">배송 기간 (영어)</label>
                            <input type="text" class="form-control" placeholder="예: 2-3 days">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">무게 제한 (kg)</label>
                            <input type="number" class="form-control" step="0.1" placeholder="예: 30">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">크기 제한</label>
                            <input type="text" class="form-control" placeholder="예: 100cm x 100cm x 100cm">
                        </div>
                        <div class="col-12">
                            <label class="form-label">설명</label>
                            <textarea class="form-control" rows="3" placeholder="배송 방식에 대한 설명을 입력하세요"></textarea>
                        </div>
                        <div class="col-12">
                            <h6 class="mb-3">추가 옵션</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isTrackable">
                                        <label class="form-check-label" for="isTrackable">
                                            추적 가능
                                        </label>
                                        <div class="form-text">배송 상태를 추적할 수 있는 방식입니다</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isSignatureRequired">
                                        <label class="form-check-label" for="isSignatureRequired">
                                            서명 필요
                                        </label>
                                        <div class="form-text">수령 시 서명이 필요합니다</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="isInsuranceAvailable">
                                        <label class="form-check-label" for="isInsuranceAvailable">
                                            보험 가능
                                        </label>
                                        <div class="form-text">배송 보험이 가능한 방식입니다</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">추가</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 방식 추가 폼 처리
    const form = document.querySelector('#addMethodModal form');
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('배송 방식이 추가됩니다. (임시)');
        bootstrap.Modal.getInstance(document.getElementById('addMethodModal')).hide();
    });
});
</script>
@endpush
