@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">새 주문 생성 - 1단계: 고객 정보</h1>
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
                <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <small class="text-primary fw-bold">1. 고객 정보</small>
                <small class="text-muted">2. 상품 선택</small>
                <small class="text-muted">3. 배송/청구</small>
                <small class="text-muted">4. 결제/완료</small>
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">고객 정보 입력</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cms.ecommerce.orders.step', 1) }}">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">기존 고객 선택 (선택사항)</h6>
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">기존 고객</label>
                                    <select class="form-select" id="user_id" name="user_id" onchange="fillCustomerInfo(this)">
                                        <option value="">직접 입력</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                {{ old('user_id', $stepData['customer']['user_id'] ?? '') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">고객명 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name"
                                       value="{{ old('customer_name', $stepData['customer']['customer_name'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">이메일 <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email"
                                       value="{{ old('customer_email', $stepData['customer']['customer_email'] ?? '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">전화번호</label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                       value="{{ old('customer_phone', $stepData['customer']['customer_phone'] ?? '') }}"
                                       placeholder="010-1234-5678">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.cms.ecommerce.orders.reset') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                다음 단계: 상품 선택 <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">진행 단계</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-user fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-primary">1. 고객 정보</div>
                            <small class="text-muted">진행 중</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 opacity-50">
                        <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-box fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold">2. 상품 선택</div>
                            <small class="text-muted">대기 중</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 opacity-50">
                        <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-truck fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold">3. 배송/청구</div>
                            <small class="text-muted">대기 중</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center opacity-50">
                        <div class="rounded-circle bg-light text-muted d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <i class="fas fa-credit-card fa-sm"></i>
                        </div>
                        <div>
                            <div class="fw-bold">4. 결제/완료</div>
                            <small class="text-muted">대기 중</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillCustomerInfo(select) {
    const option = select.options[select.selectedIndex];
    if (option.value) {
        document.getElementById('customer_name').value = option.dataset.name;
        document.getElementById('customer_email').value = option.dataset.email;
    } else {
        document.getElementById('customer_name').value = '';
        document.getElementById('customer_email').value = '';
        document.getElementById('customer_phone').value = '';
    }
}
</script>
@endsection
