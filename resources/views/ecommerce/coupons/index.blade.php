@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '쿠폰 관리')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">쿠폰 관리</h2>
            <p class="text-muted">할인 쿠폰을 생성하고 관리합니다.</p>
        </div>
        <a href="{{ route('admin.cms.ecommerce.coupons.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>새 쿠폰 생성
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-ticket-perforated text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">전체 쿠폰</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">활성 쿠폰</h6>
                            <h3 class="mb-0">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-pause-circle text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">비활성 쿠폰</h6>
                            <h3 class="mb-0">{{ $stats['inactive'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h6 class="card-title text-muted mb-1">만료된 쿠폰</h6>
                            <h3 class="mb-0">{{ $stats['expired'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.cms.ecommerce.coupons.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">검색</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="쿠폰명, 코드, 설명 검색">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">상태</label>
                    <select class="form-select" id="status" name="status">
                        <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>전체</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>활성</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>비활성</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>만료</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="type" class="form-label">타입</label>
                    <select class="form-select" id="type" name="type">
                        <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>전체</option>
                        <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>퍼센트</option>
                        <option value="fixed_amount" {{ request('type') === 'fixed_amount' ? 'selected' : '' }}>고정금액</option>
                        <option value="free_shipping" {{ request('type') === 'free_shipping' ? 'selected' : '' }}>무료배송</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-label">정렬</label>
                    <select class="form-select" id="sort" name="sort">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>생성일</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>이름</option>
                        <option value="expires_at" {{ request('sort') === 'expires_at' ? 'selected' : '' }}>만료일</option>
                        <option value="times_used" {{ request('sort') === 'times_used' ? 'selected' : '' }}>사용횟수</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search me-1"></i>검색
                    </button>
                    <a href="{{ route('admin.cms.ecommerce.coupons.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>초기화
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="card">
        <div class="card-body">
            @if($coupons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>쿠폰명</th>
                                <th>코드</th>
                                <th>타입</th>
                                <th>할인값</th>
                                <th>상태</th>
                                <th>사용횟수</th>
                                <th>시작일</th>
                                <th>만료일</th>
                                <th>액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $coupon->name }}</div>
                                    @if($coupon->description)
                                        <div class="text-muted small">{{ Str::limit($coupon->description, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                                </td>
                                <td>
                                    @switch($coupon->type)
                                        @case('percentage')
                                            <span class="badge bg-primary">퍼센트</span>
                                            @break
                                        @case('fixed_amount')
                                            <span class="badge bg-success">고정금액</span>
                                            @break
                                        @case('free_shipping')
                                            <span class="badge bg-info">무료배송</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}%
                                    @elseif($coupon->type === 'fixed_amount')
                                        {{ number_format($coupon->value) }}원
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    {{ $coupon->times_used }}
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @endif
                                </td>
                                <td>{{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : '-' }}</td>
                                <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '무제한' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.cms.ecommerce.coupons.show', $coupon) }}"
                                           class="btn btn-sm btn-outline-primary" title="보기">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cms.ecommerce.coupons.edit', $coupon) }}"
                                           class="btn btn-sm btn-outline-warning" title="수정">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.cms.ecommerce.coupons.destroy', $coupon) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('정말 삭제하시겠습니까?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="삭제">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $coupons->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-ticket-perforated text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">쿠폰이 없습니다</h5>
                    <p class="text-muted">새로운 할인 쿠폰을 생성해보세요.</p>
                    <a href="{{ route('admin.cms.ecommerce.coupons.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>첫 번째 쿠폰 생성
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    const filterSelects = document.querySelectorAll('#status, #type, #sort');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
