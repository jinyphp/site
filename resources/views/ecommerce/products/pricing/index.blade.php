@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $config['title'] }}</h2>
                    <p class="text-muted mb-0">{{ $product->title }} - {{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.products.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fe fe-arrow-left me-2"></i>상품 목록
                    </a>
                    <a href="{{ route('admin.site.products.pricing.create', $product->id) }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>가격 옵션 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 상품 정보 카드 -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->title }}"
                         class="me-3 rounded" style="width: 60px; height: 60px; object-fit: cover;">
                @else
                    <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px;">
                        <i class="fe fe-package text-muted"></i>
                    </div>
                @endif
                <div>
                    <h5 class="mb-1">{{ $product->title }}</h5>
                    @if($product->description)
                        <p class="text-muted mb-0">{{ Str::limit(strip_tags($product->description), 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 가격 옵션 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">가격 옵션 목록 ({{ $pricingOptions->count() }}개)</h5>
        </div>
        <div class="card-body p-0">
            @if($pricingOptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">순서</th>
                                <th>옵션명</th>
                                <th width="100">코드</th>
                                <th width="120">가격</th>
                                <th width="120">할인가</th>
                                <th width="100">결제주기</th>
                                <th width="80">수량</th>
                                <th width="80">상태</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pricingOptions as $pricing)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $pricing->pos }}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $pricing->name }}</strong>
                                        @if($pricing->description)
                                            <br><small class="text-muted">{{ Str::limit(strip_tags($pricing->description), 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($pricing->code)
                                        <code class="small">{{ $pricing->code }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $pricing->currency }} {{ number_format($pricing->price) }}</strong>
                                </td>
                                <td>
                                    @if($pricing->sale_price && $pricing->sale_price < $pricing->price)
                                        <strong class="text-danger">{{ $pricing->currency }} {{ number_format($pricing->sale_price) }}</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pricing->billing_period)
                                        <span class="badge bg-info">{{ $pricing->billing_period }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        {{ $pricing->min_quantity }}
                                        @if($pricing->max_quantity)
                                            ~ {{ $pricing->max_quantity }}
                                        @else
                                            +
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    @if($pricing->enable)
                                        <span class="badge bg-success">활성</span>
                                    @else
                                        <span class="badge bg-secondary">비활성</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.site.products.pricing.edit', [$product->id, $pricing->id]) }}"
                                           class="btn btn-outline-primary" title="수정">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="삭제"
                                                onclick="deletePricing({{ $pricing->id }})">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-tag fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 가격 옵션이 없습니다</h5>
                    <p class="text-muted">새로운 가격 옵션을 추가해보세요.</p>
                    <a href="{{ route('admin.site.products.pricing.create', $product->id) }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>가격 옵션 추가
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">가격 옵션 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 가격 옵션을 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    삭제된 데이터는 복구할 수 있습니다.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">삭제</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 삭제 확인
function deletePricing(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/site/products/{{ $product->id }}/pricing/${id}`;
    modal.show();
}
</script>
@endpush
