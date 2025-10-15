@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '쿠폰 상세')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">쿠폰 상세</h2>
            <p class="text-muted">{{ $coupon->name }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.cms.ecommerce.coupons.edit', $coupon) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>수정
            </a>
            <a href="{{ route('admin.cms.ecommerce.coupons.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>목록으로
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">기본 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">쿠폰명:</dt>
                                <dd class="col-sm-8">{{ $coupon->name }}</dd>

                                <dt class="col-sm-4">쿠폰 코드:</dt>
                                <dd class="col-sm-8">
                                    <code class="bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                                </dd>

                                <dt class="col-sm-4">설명:</dt>
                                <dd class="col-sm-8">{{ $coupon->description ?: '-' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">상태:</dt>
                                <dd class="col-sm-8">
                                    @switch($coupon->status)
                                        @case('active')
                                            <span class="badge bg-success">활성</span>
                                            @break
                                        @case('inactive')
                                            <span class="badge bg-warning">비활성</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-danger">만료</span>
                                            @break
                                    @endswitch
                                </dd>

                                <dt class="col-sm-4">생성일:</dt>
                                <dd class="col-sm-8">{{ $coupon->created_at->format('Y-m-d H:i') }}</dd>

                                <dt class="col-sm-4">생성자:</dt>
                                <dd class="col-sm-8">{{ $coupon->created_by ? 'Admin' : '시스템' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Discount Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">할인 설정</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">할인 타입:</dt>
                                <dd class="col-sm-7">
                                    @switch($coupon->type)
                                        @case('percentage')
                                            <span class="badge bg-primary">퍼센트 할인</span>
                                            @break
                                        @case('fixed_amount')
                                            <span class="badge bg-success">고정 금액 할인</span>
                                            @break
                                        @case('free_shipping')
                                            <span class="badge bg-info">무료 배송</span>
                                            @break
                                    @endswitch
                                </dd>

                                <dt class="col-sm-5">할인값:</dt>
                                <dd class="col-sm-7">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}%
                                    @elseif($coupon->type === 'fixed_amount')
                                        {{ number_format($coupon->value) }}원
                                    @else
                                        무료 배송
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-5">최소 주문 금액:</dt>
                                <dd class="col-sm-7">
                                    {{ $coupon->minimum_order_amount ? number_format($coupon->minimum_order_amount) . '원' : '제한 없음' }}
                                </dd>

                                <dt class="col-sm-5">최대 할인 금액:</dt>
                                <dd class="col-sm-7">
                                    {{ $coupon->maximum_discount_amount ? number_format($coupon->maximum_discount_amount) . '원' : '제한 없음' }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Information -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">사용 정보</h5>
                    @if($coupon->usages->count() > 0)
                        <small class="text-muted">총 {{ $coupon->usages->count() }}회 사용</small>
                    @endif
                </div>
                <div class="card-body">
                    @if($coupon->usages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>사용일</th>
                                        <th>사용자</th>
                                        <th>주문 금액</th>
                                        <th>할인 금액</th>
                                        <th>주문 번호</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupon->usages->take(10) as $usage)
                                    <tr>
                                        <td>{{ $usage->used_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $usage->user ? $usage->user->name : $usage->customer_email }}</td>
                                        <td>{{ number_format($usage->order_amount) }}원</td>
                                        <td>{{ number_format($usage->discount_amount) }}원</td>
                                        <td>
                                            @if($usage->order_id)
                                                <a href="#" class="text-decoration-none">{{ $usage->order_id }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($coupon->usages->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">최근 10개 사용 기록만 표시됩니다.</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-clock-history text-muted" style="font-size: 2rem;"></i>
                            <p class="mt-2 text-muted">아직 사용된 기록이 없습니다.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">통계</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-1">{{ $coupon->times_used }}</h4>
                                <small class="text-muted">사용 횟수</small>
                            </div>
                        </div>
                        @if($coupon->usage_limit)
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="mb-1">{{ $coupon->usage_limit - $coupon->times_used }}</h4>
                                <small class="text-muted">남은 사용 횟수</small>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h4 class="mb-1">
                                    {{ number_format($coupon->usages->sum('discount_amount')) }}원
                                </h4>
                                <small class="text-muted">총 할인 금액</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">설정</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-6">사용 한도:</dt>
                        <dd class="col-sm-6">{{ $coupon->usage_limit ?: '무제한' }}</dd>

                        <dt class="col-sm-6">고객당 한도:</dt>
                        <dd class="col-sm-6">{{ $coupon->usage_limit_per_customer ?: '무제한' }}</dd>

                        <dt class="col-sm-6">중복 사용:</dt>
                        <dd class="col-sm-6">
                            {!! $coupon->stackable
                                ? '<i class="bi bi-check-circle text-success"></i> 가능'
                                : '<i class="bi bi-x-circle text-danger"></i> 불가능' !!}
                        </dd>

                        <dt class="col-sm-6">자동 적용:</dt>
                        <dd class="col-sm-6">
                            {!! $coupon->auto_apply
                                ? '<i class="bi bi-check-circle text-success"></i> 활성'
                                : '<i class="bi bi-x-circle text-muted"></i> 비활성' !!}
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Date Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">유효 기간</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">시작일:</dt>
                        <dd class="col-sm-8">{{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d H:i') : '-' }}</dd>

                        <dt class="col-sm-4">만료일:</dt>
                        <dd class="col-sm-8">
                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('Y-m-d H:i') }}
                                @if($coupon->expires_at->isPast())
                                    <span class="badge bg-danger ms-2">만료됨</span>
                                @elseif($coupon->expires_at->diffInDays() <= 7)
                                    <span class="badge bg-warning ms-2">곧 만료</span>
                                @endif
                            @else
                                무제한
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
