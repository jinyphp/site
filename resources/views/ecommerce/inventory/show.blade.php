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
                    <p class="text-muted mb-0">{{ $config['subtitle'] }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.site.ecommerce.inventory.edit', $inventory->id) }}" class="btn btn-primary me-2">
                        <i class="fe fe-edit me-2"></i>수정
                    </a>
                    <a href="{{ route('admin.site.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-arrow-left me-2"></i>재고 목록
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 기본 정보 -->
        <div class="col-lg-8">
            <!-- 상품 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">상품 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">상품명</h6>
                            <p class="mb-3">{{ $inventory->product_name }}</p>

                            <h6 class="text-muted mb-2">상품 SKU</h6>
                            <p class="mb-3">
                                @if($inventory->product_sku)
                                    <code>{{ $inventory->product_sku }}</code>
                                @else
                                    <span class="text-muted">SKU 없음</span>
                                @endif
                            </p>

                            @if($inventory->product_description)
                                <h6 class="text-muted mb-2">상품 설명</h6>
                                <p class="mb-3">{{ $inventory->product_description }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($inventory->variant_name)
                                <h6 class="text-muted mb-2">상품 변형</h6>
                                <p class="mb-3">{{ $inventory->variant_name }}</p>

                                <h6 class="text-muted mb-2">변형 SKU</h6>
                                <p class="mb-3">
                                    @if($inventory->variant_sku)
                                        <code>{{ $inventory->variant_sku }}</code>
                                    @else
                                        <span class="text-muted">SKU 없음</span>
                                    @endif
                                </p>
                            @else
                                <div class="text-muted">
                                    <i class="fe fe-info me-1"></i>
                                    기본 상품 (변형 없음)
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 재고 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">재고 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <div class="bg-primary bg-gradient rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px;">
                                    <i class="fe fe-package text-white" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="text-muted mb-1">보유 수량</h6>
                                <h4 class="mb-0">{{ number_format($inventory->quantity) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <div class="bg-warning bg-gradient rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px;">
                                    <i class="fe fe-clock text-white" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="text-muted mb-1">예약 수량</h6>
                                <h4 class="mb-0">{{ number_format($inventory->reserved_quantity ?? 0) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <div class="bg-success bg-gradient rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px;">
                                    <i class="fe fe-check-circle text-white" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="text-muted mb-1">사용 가능</h6>
                                <h4 class="mb-0 text-primary">{{ number_format($inventory->available_quantity ?? $inventory->quantity) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-3">
                                <div class="bg-info bg-gradient rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px;">
                                    <i class="fe fe-alert-triangle text-white" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="text-muted mb-1">부족 기준</h6>
                                <h4 class="mb-0">{{ number_format($inventory->low_stock_threshold ?? 0) }}</h4>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">단위 원가</h6>
                            <p class="mb-3">
                                @if($inventory->unit_cost > 0)
                                    <span class="h5 text-success">₩{{ number_format($inventory->unit_cost) }}</span>
                                @else
                                    <span class="text-muted">설정되지 않음</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">총 재고 가치</h6>
                            <p class="mb-3">
                                <span class="h5 text-primary">₩{{ number_format(($inventory->quantity ?? 0) * ($inventory->unit_cost ?? 0)) }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- 재고 상태 -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">재고 상태</h6>
                            @if($inventory->quantity <= 0)
                                <span class="badge bg-danger fs-6">품절</span>
                            @elseif($inventory->quantity <= ($inventory->low_stock_threshold ?? 0))
                                <span class="badge bg-warning fs-6">부족 재고</span>
                            @else
                                <span class="badge bg-success fs-6">정상</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 위치 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">위치 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">위치</h6>
                            <p class="mb-3">
                                @if($inventory->location)
                                    <span class="badge bg-secondary fs-6">{{ $inventory->location }}</span>
                                @else
                                    <span class="text-muted">설정되지 않음</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">창고</h6>
                            <p class="mb-3">
                                @if($inventory->warehouse)
                                    {{ $inventory->warehouse }}
                                @else
                                    <span class="text-muted">설정되지 않음</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted mb-2">세부 위치</h6>
                            <p class="mb-3">
                                @if($inventory->bin_location)
                                    <code>{{ $inventory->bin_location }}</code>
                                @else
                                    <span class="text-muted">설정되지 않음</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($inventory->notes)
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted mb-2">메모</h6>
                                <div class="bg-light rounded p-3">
                                    {{ $inventory->notes }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 재고 이동 내역 -->
            @if($movements->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">최근 재고 이동 내역</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>날짜</th>
                                    <th>유형</th>
                                    <th>변경 전</th>
                                    <th>변경 후</th>
                                    <th>변경량</th>
                                    <th>메모</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($movement->created_at)->format('Y-m-d H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        @switch($movement->type)
                                            @case('adjustment')
                                                <span class="badge bg-info">조정</span>
                                                @break
                                            @case('sale')
                                                <span class="badge bg-danger">판매</span>
                                                @break
                                            @case('purchase')
                                                <span class="badge bg-success">입고</span>
                                                @break
                                            @case('removal')
                                                <span class="badge bg-warning">제거</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $movement->type }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ number_format($movement->quantity_before) }}</td>
                                    <td>{{ number_format($movement->quantity_after) }}</td>
                                    <td>
                                        @if($movement->quantity_change > 0)
                                            <span class="text-success">+{{ number_format($movement->quantity_change) }}</span>
                                        @elseif($movement->quantity_change < 0)
                                            <span class="text-danger">{{ number_format($movement->quantity_change) }}</span>
                                        @else
                                            <span class="text-muted">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($movement->notes)
                                            <small class="text-muted">{{ $movement->notes }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- 사이드바 정보 -->
        <div class="col-lg-4">
            <!-- 상태 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">상태 정보</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">활성 상태</h6>
                        @if($inventory->enable)
                            <span class="badge bg-success fs-6">활성</span>
                            <div class="form-text mt-1">주문 처리에 포함됩니다.</div>
                        @else
                            <span class="badge bg-secondary fs-6">비활성</span>
                            <div class="form-text mt-1">주문 처리에서 제외됩니다.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 등록 정보 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">등록 정보</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">재고 ID:</span>
                        <span class="fw-bold">{{ $inventory->id }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">등록일:</span>
                        <span>{{ \Carbon\Carbon::parse($inventory->created_at)->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-muted">수정일:</span>
                        <span>{{ \Carbon\Carbon::parse($inventory->updated_at)->format('Y-m-d H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- 액션 버튼 -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.site.ecommerce.inventory.edit', $inventory->id) }}" class="btn btn-primary">
                            <i class="fe fe-edit me-2"></i>재고 수정
                        </a>
                        <a href="{{ route('admin.site.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-list me-2"></i>재고 목록
                        </a>
                        <hr class="my-2">
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="deleteInventory({{ $inventory->id }})">
                            <i class="fe fe-trash-2 me-2"></i>재고 삭제
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 삭제 확인 모달 -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">재고 삭제</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>이 재고 항목을 삭제하시겠습니까?</p>
                <p class="text-danger small">
                    <i class="fe fe-alert-triangle me-1"></i>
                    삭제된 재고는 복구할 수 없습니다.
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
function deleteInventory(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/site/ecommerce/inventory/${id}`;
    modal.show();
}
</script>
@endpush
