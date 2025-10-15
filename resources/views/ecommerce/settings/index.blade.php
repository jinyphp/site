@extends('jiny-admin::layouts.app')

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
                                <a href="{{ route('admin.home') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cms.ecommerce.dashboard') }}">Ecommerce</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-download me-2"></i>설정 백업
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="fe fe-save me-2"></i>설정 저장
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 설정 탭 -->
        <div class="col-lg-3 col-md-4 col-12 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
                        <a class="nav-link active rounded-0 border-0" id="general-tab" data-bs-toggle="pill" href="#general" role="tab">
                            <i class="fe fe-settings me-2"></i>일반 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="currency-tab" data-bs-toggle="pill" href="#currency" role="tab">
                            <i class="fe fe-dollar-sign me-2"></i>통화 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="tax-tab" data-bs-toggle="pill" href="#tax" role="tab">
                            <i class="fe fe-percent me-2"></i>세금 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="order-tab" data-bs-toggle="pill" href="#order" role="tab">
                            <i class="fe fe-shopping-cart me-2"></i>주문 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="shipping-tab" data-bs-toggle="pill" href="#shipping" role="tab">
                            <i class="fe fe-truck me-2"></i>배송 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="inventory-tab" data-bs-toggle="pill" href="#inventory" role="tab">
                            <i class="fe fe-package me-2"></i>재고 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="customer-tab" data-bs-toggle="pill" href="#customer" role="tab">
                            <i class="fe fe-users me-2"></i>고객 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="payment-tab" data-bs-toggle="pill" href="#payment" role="tab">
                            <i class="fe fe-credit-card me-2"></i>결제 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="email-tab" data-bs-toggle="pill" href="#email" role="tab">
                            <i class="fe fe-mail me-2"></i>이메일 설정
                        </a>
                        <a class="nav-link rounded-0 border-0" id="advanced-tab" data-bs-toggle="pill" href="#advanced" role="tab">
                            <i class="fe fe-cpu me-2"></i>고급 설정
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 설정 내용 -->
        <div class="col-lg-9 col-md-8 col-12">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- 일반 설정 -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">일반 설정</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">상점명</label>
                                        <input type="text" class="form-control" value="{{ $settings['store_name'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">상점 이메일</label>
                                        <input type="email" class="form-control" value="{{ $settings['store_email'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">상점 전화번호</label>
                                        <input type="tel" class="form-control" value="{{ $settings['store_phone'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">시간대</label>
                                        <select class="form-select">
                                            <option value="Asia/Seoul" selected>Asia/Seoul</option>
                                            <option value="UTC">UTC</option>
                                            <option value="America/New_York">America/New_York</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">상점 주소</label>
                                        <textarea class="form-control" rows="3">{{ $settings['store_address'] }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 통화 설정 -->
                <div class="tab-pane fade" id="currency" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">통화 설정</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">기본 통화</label>
                                        <select class="form-select">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}" {{ $currency->code === $settings['base_currency'] ? 'selected' : '' }}>
                                                    {{ $currency->code }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">소수점 자리수</label>
                                        <select class="form-select">
                                            <option value="0" {{ $settings['currency_decimals'] == 0 ? 'selected' : '' }}>0</option>
                                            <option value="2" {{ $settings['currency_decimals'] == 2 ? 'selected' : '' }}>2</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="autoCurrency" {{ $settings['auto_currency_detection'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="autoCurrency">
                                                사용자 위치에 따른 자동 통화 감지
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">환율 정보</label>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>통화</th>
                                                        <th>환율 ({{ $settings['base_currency'] }} 기준)</th>
                                                        <th>마지막 업데이트</th>
                                                        <th>상태</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($exchangeRates['recent_rates'] as $rate)
                                                    <tr>
                                                        <td>{{ $rate->from_currency }} → {{ $rate->to_currency }}</td>
                                                        <td>{{ number_format($rate->rate, 6) }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($rate->updated_at)->format('Y.m.d H:i') }}</td>
                                                        <td>
                                                            <span class="badge bg-light-success text-success">활성</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.cms.exchange-rates.index') }}" class="btn btn-outline-primary btn-sm">
                                                환율 관리
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 세금 설정 -->
                <div class="tab-pane fade" id="tax" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">세금 설정</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">세금 계산 방식</label>
                                        <select class="form-select">
                                            <option value="exclusive" {{ $settings['tax_calculation'] === 'exclusive' ? 'selected' : '' }}>세금 별도 (Exclusive)</option>
                                            <option value="inclusive" {{ $settings['tax_calculation'] === 'inclusive' ? 'selected' : '' }}>세금 포함 (Inclusive)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">세금 표시 방식</label>
                                        <select class="form-select">
                                            <option value="both" {{ $settings['tax_display'] === 'both' ? 'selected' : '' }}>가격 + 세금 둘 다</option>
                                            <option value="price_only" {{ $settings['tax_display'] === 'price_only' ? 'selected' : '' }}>가격만</option>
                                            <option value="tax_only" {{ $settings['tax_display'] === 'tax_only' ? 'selected' : '' }}>세금만</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">세금 기준 주소</label>
                                        <select class="form-select">
                                            <option value="shipping_address" {{ $settings['tax_based_on'] === 'shipping_address' ? 'selected' : '' }}>배송 주소</option>
                                            <option value="billing_address" {{ $settings['tax_based_on'] === 'billing_address' ? 'selected' : '' }}>청구 주소</option>
                                            <option value="store_address" {{ $settings['tax_based_on'] === 'store_address' ? 'selected' : '' }}>상점 주소</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">기본 세율 (%)</label>
                                        <input type="number" class="form-control" step="0.01" value="{{ $settings['default_tax_rate'] * 100 }}">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="shippingTax" {{ $settings['shipping_tax_calculation'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="shippingTax">
                                                배송비에도 세금 적용
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 주문 설정 -->
                <div class="tab-pane fade" id="order" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">주문 설정</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">주문번호 접두사</label>
                                        <input type="text" class="form-control" value="{{ $settings['order_number_prefix'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">주문번호 형식</label>
                                        <select class="form-select">
                                            <option value="YYYYMMDD-NNN" {{ $settings['order_number_format'] === 'YYYYMMDD-NNN' ? 'selected' : '' }}>YYYYMMDD-NNN</option>
                                            <option value="NNN">NNN (순차번호)</option>
                                            <option value="YYYY-NNN">YYYY-NNN</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">재고 차감 시점</label>
                                        <select class="form-select">
                                            <option value="on_payment" {{ $settings['order_stock_reduction'] === 'on_payment' ? 'selected' : '' }}>결제 완료 시</option>
                                            <option value="on_order" {{ $settings['order_stock_reduction'] === 'on_order' ? 'selected' : '' }}>주문 생성 시</option>
                                            <option value="manual" {{ $settings['order_stock_reduction'] === 'manual' ? 'selected' : '' }}>수동</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoConfirm" {{ $settings['order_auto_confirm'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="autoConfirm">
                                                주문 자동 확인
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="guestCheckout" {{ $settings['allow_guest_checkout'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="guestCheckout">
                                                게스트 주문 허용
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="requirePhone" {{ $settings['require_phone_number'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="requirePhone">
                                                전화번호 필수 입력
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 시스템 상태 -->
                <div class="tab-pane fade" id="advanced" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">시스템 상태</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">데이터베이스</h6>
                                            <p class="text-muted mb-0 small">{{ $systemStatus['database_connection']['message'] }}</p>
                                        </div>
                                        <div>
                                            @if($systemStatus['database_connection']['status'] === 'connected')
                                                <span class="badge bg-light-success text-success">정상</span>
                                            @else
                                                <span class="badge bg-light-danger text-danger">오류</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">캐시 시스템</h6>
                                            <p class="text-muted mb-0 small">{{ $systemStatus['cache_status']['message'] }}</p>
                                        </div>
                                        <div>
                                            @if($systemStatus['cache_status']['status'] === 'working')
                                                <span class="badge bg-light-success text-success">정상</span>
                                            @else
                                                <span class="badge bg-light-danger text-danger">오류</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">스토리지 권한</h6>
                                            <p class="text-muted mb-0 small">{{ $systemStatus['storage_permissions']['message'] }}</p>
                                        </div>
                                        <div>
                                            @if($systemStatus['storage_permissions']['status'] === 'writable')
                                                <span class="badge bg-light-success text-success">정상</span>
                                            @else
                                                <span class="badge bg-light-danger text-danger">오류</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                                        <div>
                                            <h6 class="mb-1">SSL 인증서</h6>
                                            <p class="text-muted mb-0 small">{{ $systemStatus['ssl_enabled'] ? 'HTTPS 활성화됨' : 'HTTP만 사용중' }}</p>
                                        </div>
                                        <div>
                                            @if($systemStatus['ssl_enabled'])
                                                <span class="badge bg-light-success text-success">보안</span>
                                            @else
                                                <span class="badge bg-light-warning text-warning">주의</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-4">
                                    <h6>시스템 정보</h6>
                                    <ul class="list-unstyled text-muted small">
                                        <li>PHP: {{ $systemStatus['php_version'] }}</li>
                                        <li>Laravel: {{ $systemStatus['laravel_version'] }}</li>
                                        <li>메모리 사용량: {{ $systemStatus['memory_usage'] }}</li>
                                        <li>디스크 여유공간: {{ $systemStatus['disk_space'] }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h6>지역화 설정</h6>
                                    <ul class="list-unstyled text-muted small">
                                        <li>시간대: {{ $systemStatus['timezone'] }}</li>
                                        <li>언어: {{ $systemStatus['locale'] }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h6>환율 시스템</h6>
                                    <ul class="list-unstyled text-muted small">
                                        <li>총 환율: {{ $exchangeRates['total_rates'] }}개</li>
                                        <li>자동 업데이트: {{ $exchangeRates['auto_update_enabled'] ? '활성화' : '비활성화' }}</li>
                                        <li>업데이트 주기: {{ $exchangeRates['update_frequency'] }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 설정 저장 버튼 클릭 이벤트
    document.querySelector('.btn-primary')?.addEventListener('click', function() {
        // 실제 구현에서는 AJAX로 설정 저장
        alert('설정이 저장되었습니다. (데모)');
    });

    // 설정 백업 버튼 클릭 이벤트
    document.querySelector('.btn-outline-secondary')?.addEventListener('click', function() {
        // 실제 구현에서는 설정 백업 파일 다운로드
        alert('설정 백업을 다운로드합니다. (데모)');
    });
});
</script>
@endpush