@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">새 주문 생성 - 4단계: 결제/완료</h1>
                <a href="{{ route('admin.cms.ecommerce.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>주문 목록으로
                </a>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <small class="text-success">✓ 1. 고객 정보</small>
                <small class="text-success">✓ 2. 상품 선택</small>
                <small class="text-success">✓ 3. 배송/청구</small>
                <small class="text-primary fw-bold">4. 결제/완료</small>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('admin.cms.ecommerce.orders.step', 4) }}" id="paymentForm">
                @csrf

                <!-- 주문 상태 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">주문 상태</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">주문 상태 <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>대기 중</option>
                                    <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>처리 중</option>
                                    <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>배송됨</option>
                                    <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>배송완료</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>취소됨</option>
                                    <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>환불됨</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_status" class="form-label">결제 상태 <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_status" name="payment_status" required>
                                    <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>결제 대기</option>
                                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>결제 완료</option>
                                    <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>결제 실패</option>
                                    <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>환불됨</option>
                                    <option value="cancelled" {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>결제 취소</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 결제 정보 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">결제 정보</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">결제 수단</label>
                                <select class="form-select" id="payment_method" name="payment_method">
                                    <option value="">선택하세요</option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>신용카드</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>계좌이체</option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="kakaopay" {{ old('payment_method') == 'kakaopay' ? 'selected' : '' }}>카카오페이</option>
                                    <option value="naverpay" {{ old('payment_method') == 'naverpay' ? 'selected' : '' }}>네이버페이</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>현금</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_id" class="form-label">결제 ID</label>
                                <input type="text" class="form-control" id="payment_id" name="payment_id"
                                       value="{{ old('payment_id') }}" placeholder="결제 시스템에서 생성된 ID">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 메모 -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">주문 메모</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="notes" class="form-label">메모</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                      placeholder="주문에 대한 추가 정보나 메모를 입력하세요...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.cms.ecommerce.orders.step', 3) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>이전 단계
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check me-2"></i>주문 생성 완료
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">진행 단계</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success">1. 고객 정보</div>
                            <small class="text-muted">완료</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success">2. 상품 선택</div>
                            <small class="text-muted">완료</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-check fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-success">3. 배송/청구</div>
                            <small class="text-muted">완료</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-credit-card fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-primary">4. 결제/완료</div>
                            <small class="text-muted">진행 중</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 주문 요약 -->
            @if(isset($stepData))
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">최종 주문 요약</h6>
                </div>
                <div class="card-body">
                    <!-- 고객 정보 -->
                    @if(isset($stepData['customer']))
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">고객 정보</h6>
                        <p class="mb-1"><strong>{{ $stepData['customer']['customer_name'] }}</strong></p>
                        <p class="mb-1 small text-muted">{{ $stepData['customer']['customer_email'] }}</p>
                        @if($stepData['customer']['customer_phone'])
                            <p class="mb-0 small text-muted">{{ $stepData['customer']['customer_phone'] }}</p>
                        @endif
                    </div>
                    @endif

                    <!-- 상품 정보 -->
                    @if(isset($stepData['products']))
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">주문 상품 ({{ count($stepData['products']['items']) }}개)</h6>
                        @foreach($stepData['products']['items'] as $item)
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                <span class="small">₩{{ number_format($item['price'] * $item['quantity']) }}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- 배송 주소 -->
                    @if(isset($stepData['shipping']['shipping_address']))
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">배송 주소</h6>
                        <p class="small mb-0">
                            {{ $stepData['shipping']['shipping_address']['street'] }}<br>
                            {{ $stepData['shipping']['shipping_address']['city'] }}
                            {{ $stepData['shipping']['shipping_address']['state'] }}
                            {{ $stepData['shipping']['shipping_address']['postal_code'] }}<br>
                            {{ $stepData['shipping']['shipping_address']['country'] }}
                        </p>
                    </div>
                    @endif

                    <!-- 가격 요약 -->
                    @if(isset($stepData['products']['subtotal']) && isset($stepData['shipping']))
                    <hr>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">상품 소계:</span>
                        <span class="small">₩{{ number_format($stepData['products']['subtotal']) }}</span>
                    </div>
                    @if($stepData['shipping']['tax_amount'] > 0)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">세금:</span>
                        <span class="small">₩{{ number_format($stepData['shipping']['tax_amount']) }}</span>
                    </div>
                    @endif
                    @if($stepData['shipping']['shipping_cost'] > 0)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">배송비:</span>
                        <span class="small">₩{{ number_format($stepData['shipping']['shipping_cost']) }}</span>
                    </div>
                    @endif
                    @if($stepData['shipping']['discount_amount'] > 0)
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">할인:</span>
                        <span class="small text-danger">-₩{{ number_format($stepData['shipping']['discount_amount']) }}</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>총 금액:</strong>
                        <strong class="text-primary">₩{{ number_format($stepData['shipping']['total_amount']) }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// 폼 제출 시 확인
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    if (!confirm('주문을 생성하시겠습니까? 생성된 주문은 주문 목록에서 관리할 수 있습니다.')) {
        e.preventDefault();
    }
});
</script>
@endsection
