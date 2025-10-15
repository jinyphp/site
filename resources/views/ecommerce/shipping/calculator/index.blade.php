{{-- 배송비 계산기 --}}
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
                            <li class="breadcrumb-item active" aria-current="page">배송비 계산기</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.cms.ecommerce.shipping.rates.index') }}" class="me-2 btn btn-outline-primary">
                        <i class="fe fe-dollar-sign me-2"></i>요금 관리
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.shipping.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-home me-2"></i>배송 대시보드
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 계산기 입력 폼 -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-calculator me-2"></i>배송비 계산
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.ecommerce.shipping.calculator.calculate') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">배송 국가 <span class="text-danger">*</span></label>
                            <select class="form-select" name="country_code" required>
                                <option value="">국가 선택</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}"
                                        {{ ($input['country_code'] ?? '') === $country->country_code ? 'selected' : '' }}>
                                        {{ $country->country_name }} ({{ $country->country_code }})
                                        @if($country->zone_name_ko)
                                            - {{ $country->zone_name_ko }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">무게 (kg)</label>
                            <input type="number" class="form-control" name="weight" step="0.1"
                                value="{{ $input['weight'] ?? '1' }}" placeholder="1.0">
                            <div class="form-text">소수점 두자리까지 입력 가능</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">주문 금액 (원)</label>
                            <input type="number" class="form-control" name="order_amount"
                                value="{{ $input['order_amount'] ?? '50000' }}" placeholder="50000">
                            <div class="form-text">무료배송 기준 확인용</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">배송 지역 (선택)</label>
                            <select class="form-select" name="zone_id">
                                <option value="">지역 선택</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}"
                                        {{ ($input['zone_id'] ?? '') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name_ko ?: $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">국가 선택시 자동 설정됨</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">배송 방식 (선택)</label>
                            <select class="form-select" name="method_id">
                                <option value="">전체 방식</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->id }}"
                                        {{ ($input['method_id'] ?? '') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name_ko ?: $method->name }}
                                        @if($method->delivery_time)
                                            ({{ $method->delivery_time }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fe fe-calculator me-2"></i>배송비 계산하기
                        </button>
                    </form>
                </div>
            </div>

            <!-- 사용법 안내 -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fe fe-help-circle me-2"></i>사용법
                    </h6>
                </div>
                <div class="card-body">
                    <ol class="mb-0 small">
                        <li class="mb-2">배송비 국가를 선택하세요</li>
                        <li class="mb-2">상품의 무게를 입력하세요</li>
                        <li class="mb-2">주문 금액을 입력하세요</li>
                        <li class="mb-0">계산 결과를 확인하세요</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- 계산 결과 -->
        <div class="col-lg-8 mb-4">
            @if($calculation_result)
                @if($calculation_result['success'])
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fe fe-check-circle text-success me-2"></i>계산 결과
                            </h5>
                            <span class="badge bg-light-success text-success">
                                {{ count($calculation_result['rates']) }}개 배송 방식 찾음
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- 입력 정보 요약 -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <strong>국가:</strong><br>
                                    <span class="text-muted">{{ $calculation_result['input']['country_code'] ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>무게:</strong><br>
                                    <span class="text-muted">{{ $calculation_result['input']['weight'] ?? '0' }}kg</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>주문금액:</strong><br>
                                    <span class="text-muted">₩{{ number_format($calculation_result['input']['order_amount'] ?? 0) }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>계산시각:</strong><br>
                                    <span class="text-muted">{{ now()->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>

                            <!-- 배송 방식별 요금 -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>배송 방식</th>
                                            <th>배송 기간</th>
                                            <th class="text-end">기본 요금</th>
                                            <th class="text-end">무게 요금</th>
                                            <th class="text-end">총 배송비</th>
                                            <th class="text-center">무료배송</th>
                                            <th class="text-center">상세</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($calculation_result['rates'] as $rate)
                                        <tr class="{{ $rate['is_free_shipping'] ? 'table-success' : '' }}">
                                            <td>
                                                <div>
                                                    <strong>{{ $rate['method_name'] }}</strong>
                                                    <br><small class="text-muted">{{ $rate['zone_name'] }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light-info text-info">
                                                    {{ $rate['delivery_time'] }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                {{ $rate['currency'] }} {{ number_format($rate['base_cost']) }}
                                            </td>
                                            <td class="text-end">
                                                {{ $rate['currency'] }} {{ number_format($rate['weight_cost']) }}
                                            </td>
                                            <td class="text-end">
                                                <strong class="{{ $rate['is_free_shipping'] ? 'text-success' : 'text-primary' }}">
                                                    @if($rate['is_free_shipping'])
                                                        무료
                                                    @else
                                                        {{ $rate['currency'] }} {{ number_format($rate['final_cost']) }}
                                                    @endif
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                @if($rate['is_free_shipping'])
                                                    <span class="badge bg-success">
                                                        <i class="fe fe-gift me-1"></i>무료배송
                                                    </span>
                                                @else
                                                    @if($rate['free_shipping_threshold'] > 0)
                                                        <small class="text-muted">
                                                            {{ $rate['currency'] }} {{ number_format($rate['free_shipping_threshold']) }} 이상
                                                        </small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-info" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#details-{{ $loop->index }}">
                                                    상세
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="details-{{ $loop->index }}">
                                            <td colspan="7">
                                                <div class="bg-light p-3 rounded">
                                                    <h6>계산 상세:</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled mb-0">
                                                                <li>기본 배송비: {{ $rate['currency'] }} {{ number_format($rate['calculation_details']['base_cost']) }}</li>
                                                                <li>무게 ({{ $rate['calculation_details']['weight'] }}kg) × kg당 요금 ({{ $rate['currency'] }} {{ number_format($rate['calculation_details']['per_kg_cost']) }})</li>
                                                                <li>= 무게 요금: {{ $rate['currency'] }} {{ number_format($rate['calculation_details']['weight_cost']) }}</li>
                                                                <li>소계: {{ $rate['currency'] }} {{ number_format($rate['calculation_details']['subtotal']) }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled mb-0">
                                                                <li>무료배송 기준:
                                                                    @if($rate['free_shipping_threshold'] > 0)
                                                                        {{ $rate['currency'] }} {{ number_format($rate['free_shipping_threshold']) }}
                                                                    @else
                                                                        없음
                                                                    @endif
                                                                </li>
                                                                <li>무료배송 적용: {{ $rate['calculation_details']['free_shipping_applied'] ? '예' : '아니오' }}</li>
                                                                <li><strong>최종 배송비: {{ $rate['currency'] }} {{ number_format($rate['calculation_details']['final_cost']) }}</strong></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- 계산 실패 -->
                    <div class="card border-danger">
                        <div class="card-header bg-light-danger">
                            <h5 class="card-title mb-0 text-danger">
                                <i class="fe fe-x-circle me-2"></i>계산 실패
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger">
                                {{ $calculation_result['message'] }}
                            </div>
                            <p class="text-muted">다음 사항을 확인해주세요:</p>
                            <ul class="text-muted">
                                <li>선택한 국가에 배송 지역이 설정되어 있는지 확인</li>
                                <li>해당 지역에 활성화된 배송 방식이 있는지 확인</li>
                                <li>주문 금액이 배송 방식의 최소/최대 범위에 맞는지 확인</li>
                            </ul>
                        </div>
                    </div>
                @endif
            @else
                <!-- 초기 상태 -->
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fe fe-calculator text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">배송비 계산기</h4>
                        <p class="text-muted">
                            왼쪽 양식에 배송 정보를 입력하고<br>
                            계산 결과를 확인해 배송비를 조회하세요.
                        </p>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <i class="fe fe-globe text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h6>{{ $countries->count() }}개국</h6>
                                    <small class="text-muted">배송 가능</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <i class="fe fe-truck text-success mb-2" style="font-size: 2rem;"></i>
                                    <h6>{{ $methods->count() }}가지</h6>
                                    <small class="text-muted">배송 방식</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3">
                                    <i class="fe fe-zap text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h6>실시간</h6>
                                    <small class="text-muted">계산 결과</small>
                                </div>
                            </div>
                        </div>
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
    // 국가 선택 시 지역 자동 설정 기능 (향후 구현)
    const countrySelect = document.querySelector('select[name="country_code"]');
    const zoneSelect = document.querySelector('select[name="zone_id"]');

    if (countrySelect && zoneSelect) {
        countrySelect.addEventListener('change', function() {
            // 향후 AJAX를 통해 국가 변경 시 지역을 자동으로 설정
            console.log('Selected country:', this.value);
        });
    }
});
</script>
@endpush
