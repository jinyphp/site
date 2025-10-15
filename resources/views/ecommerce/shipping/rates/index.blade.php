{{-- 배송 요금 관리 --}}
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
                            <li class="breadcrumb-item active" aria-current="page">배송 요금</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body">
                        <i class="fe fe-download me-2"></i>내보내기
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.shipping.calculator.index') }}" class="me-2 btn btn-outline-primary">
                        <i class="fe fe-calculator me-2"></i>계산기
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.shipping.index') }}" class="me-2 btn btn-outline-secondary">
                        <i class="fe fe-home me-2"></i>배송 대시보드
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRateModal">
                        <i class="fe fe-plus me-2"></i>요금 추가
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
                    <p class="text-muted mb-0 small">총 요금</p>
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
                    <h4 class="mb-1 text-info">{{ $stats['free_shipping'] }}</h4>
                    <p class="text-muted mb-0 small">무료배송</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-warning">₩{{ number_format($stats['avg_base_cost']) }}</h4>
                    <p class="text-muted mb-0 small">평균비용</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="mb-1 text-primary">{{ $stats['currencies'] }}</h4>
                    <p class="text-muted mb-0 small">통화종류</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 배송 요금 목록 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">배송 요금 목록</h4>
                </div>

                <!-- 검색 및 필터 -->
                <div class="card-body border-bottom">
                    <form method="GET" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">검색</label>
                            <input type="search" class="form-control" name="search" value="{{ $search }}" placeholder="지역 또는 방식명">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">배송 지역</label>
                            <select class="form-select" name="zone_id">
                                <option value="">전체 지역</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ $zone_id == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name_ko ?: $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">배송 방식</label>
                            <select class="form-select" name="method_id">
                                <option value="">전체 방식</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}" {{ $method_id == $method->id ? 'selected' : '' }}>
                                        {{ $method->name_ko ?: $method->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">통화</label>
                            <select class="form-select" name="currency">
                                <option value="">전체</option>
                                @foreach($currencies as $curr)
                                    <option value="{{ $curr }}" {{ $currency === $curr ? 'selected' : '' }}>{{ $curr }}</option>
                                @endforeach
                            </select>
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
                            <label class="form-label">무료배송</label>
                            <select class="form-select" name="free_shipping">
                                <option value="">전체</option>
                                <option value="yes" {{ $free_shipping === 'yes' ? 'selected' : '' }}>있음</option>
                                <option value="no" {{ $free_shipping === 'no' ? 'selected' : '' }}>없음</option>
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
                                <th>지역/방식</th>
                                <th class="text-center">기본 요금</th>
                                <th class="text-center">kg당 요금</th>
                                <th class="text-center">무료배송 기준</th>
                                <th class="text-center">주문 금액 범위</th>
                                <th class="text-center">통화</th>
                                <th class="text-center">상태</th>
                                <th class="text-center">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rates as $rate)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $rate->zone_name_ko ?: $rate->zone_name }}</h6>
                                        <small class="text-muted">{{ $rate->method_name_ko ?: $rate->method_name }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-primary">{{ number_format($rate->base_cost) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($rate->per_kg_cost > 0)
                                        <span class="fw-bold text-success">{{ number_format($rate->per_kg_cost) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($rate->free_shipping_threshold > 0)
                                        <span class="badge bg-light-success text-success">
                                            {{ number_format($rate->free_shipping_threshold) }}
                                        </span>
                                    @else
                                        <span class="text-muted">없음</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div>
                                        @if($rate->min_order_amount > 0)
                                            <small class="text-muted">최소: {{ number_format($rate->min_order_amount) }}</small>
                                        @endif
                                        @if($rate->max_order_amount > 0)
                                            <br><small class="text-muted">최대: {{ number_format($rate->max_order_amount) }}</small>
                                        @endif
                                        @if($rate->min_order_amount <= 0 && $rate->max_order_amount <= 0)
                                            <span class="text-muted">제한없음</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light-info text-info">{{ $rate->currency }}</span>
                                </td>
                                <td class="text-center">
                                    @if($rate->enable)
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
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-calculator me-2"></i>계산해보기</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>복사</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                @if($rate->enable)
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
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fe fe-dollar-sign fs-1 mb-3"></i>
                                        <p>배송 요금이 없습니다.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRateModal">
                                            첫 번째 요금 추가하기
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($rates->hasPages())
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-0">
                                {{ $rates->firstItem() }}-{{ $rates->lastItem() }} / {{ $rates->total() }} 개
                            </p>
                        </div>
                        <div>
                            {{ $rates->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 요금 추가 모달 -->
<div class="modal fade" id="addRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">배송 요금 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">배송 지역 <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">지역 선택</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->name_ko ?: $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">배송 방식 <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="">방식 선택</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name_ko ?: $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">기본 배송비 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" step="0.01" placeholder="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">kg당 추가 요금</label>
                            <input type="number" class="form-control" step="0.01" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">무료배송 기준</label>
                            <input type="number" class="form-control" step="0.01" placeholder="50000">
                            <div class="form-text">해당 금액 이상 주문 시 무료배송</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">통화 <span class="text-danger">*</span></label>
                            <select class="form-select" required>
                                <option value="KRW" selected>KRW - 원</option>
                                <option value="USD">USD - 달러</option>
                                <option value="EUR">EUR - 유로</option>
                                <option value="GBP">GBP - 파운드</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">최소 주문 금액</label>
                            <input type="number" class="form-control" step="0.01" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">최대 주문 금액</label>
                            <input type="number" class="form-control" step="0.01" placeholder="제한없음">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableRate" checked>
                                <label class="form-check-label" for="enableRate">
                                    요금 활성화
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fe fe-info me-2"></i>
                                <strong>요금 계산 방식:</strong> 기본 배송비 + (무게 × kg당 요금)
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
    // 요금 추가 폼 처리
    const form = document.querySelector('#addRateModal form');
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('배송 요금이 추가됩니다. (임시)');
        bootstrap.Modal.getInstance(document.getElementById('addRateModal')).hide();
    });
});
</script>
@endpush
