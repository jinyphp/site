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
                    <a href="{{ route('admin.site.ecommerce.inventory.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 재고 추가
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-package text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">전체 재고</h6>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-check-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">재고 있음</h6>
                            <h4 class="mb-0">{{ $stats['in_stock'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-x-circle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">품절</h6>
                            <h4 class="mb-0">{{ $stats['out_of_stock'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-alert-triangle text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">부족 재고</h6>
                            <h4 class="mb-0">{{ $stats['low_stock'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-gradient rounded-circle p-3 stat-circle">
                                <i class="fe fe-dollar-sign text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">총 재고 가치</h6>
                            <h4 class="mb-0">₩{{ number_format($stats['total_value']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.site.ecommerce.inventory.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">검색</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="상품명, SKU, 위치로 검색..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stock_status">재고 상태</label>
                            <select id="stock_status" name="stock_status" class="form-control">
                                <option value="all">전체</option>
                                <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>재고 있음</option>
                                <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>품절</option>
                                <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>부족 재고</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="location">위치</label>
                            <select id="location" name="location" class="form-control">
                                <option value="all">전체 위치</option>
                                {{-- 동적으로 위치 목록이 추가될 예정 --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="fe fe-search me-1"></i>검색
                        </button>
                        <a href="{{ route('admin.site.ecommerce.inventory.index') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-refresh-cw me-1"></i>초기화
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 재고 목록 -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">재고 목록</h5>
        </div>
        <div class="card-body p-0">
            @if($inventories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>상품 정보</th>
                                <th width="100">수량</th>
                                <th width="100">예약 수량</th>
                                <th width="100">사용 가능</th>
                                <th width="120">위치</th>
                                <th width="100">단가</th>
                                <th width="100">상태</th>
                                <th width="150">업데이트</th>
                                <th width="120">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventories as $inventory)
                            <tr class="{{ $inventory->quantity <= $inventory->low_stock_threshold ? 'table-warning' : '' }}">
                                <td>{{ $inventory->id }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route('admin.site.ecommerce.inventory.show', $inventory->id) }}"
                                           class="text-decoration-none">
                                            <strong>{{ $inventory->product_name }}</strong>
                                        </a>
                                        @if($inventory->variant_name)
                                            <br><small class="text-muted">변형: {{ $inventory->variant_name }}</small>
                                        @endif
                                        <br>
                                        <small class="text-muted">
                                            SKU:
                                            @if($inventory->variant_sku)
                                                <code>{{ $inventory->variant_sku }}</code>
                                            @else
                                                <code>{{ $inventory->product_sku }}</code>
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($inventory->quantity) }}</span>
                                    @if($inventory->quantity <= $inventory->low_stock_threshold)
                                        <br><small class="text-warning">
                                            <i class="fe fe-alert-triangle me-1"></i>부족
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ number_format($inventory->reserved_quantity ?? 0) }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($inventory->available_quantity ?? $inventory->quantity) }}</span>
                                </td>
                                <td>
                                    @if($inventory->location)
                                        <span class="badge bg-secondary">{{ $inventory->location }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                    @if($inventory->warehouse)
                                        <br><small class="text-muted">{{ $inventory->warehouse }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($inventory->unit_cost > 0)
                                        ₩{{ number_format($inventory->unit_cost) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($inventory->quantity <= 0)
                                        <span class="badge bg-danger">품절</span>
                                    @elseif($inventory->quantity <= $inventory->low_stock_threshold)
                                        <span class="badge bg-warning">부족</span>
                                    @else
                                        <span class="badge bg-success">정상</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($inventory->updated_at)->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.site.ecommerce.inventory.show', $inventory->id) }}"
                                           class="btn btn-outline-info"
                                           title="보기">
                                            <i class="fe fe-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.site.ecommerce.inventory.edit', $inventory->id) }}"
                                           class="btn btn-outline-primary"
                                           title="수정">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-outline-danger"
                                                title="삭제"
                                                onclick="deleteInventory({{ $inventory->id }})">
                                            <i class="fe fe-trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 페이지네이션 -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            전체 {{ $inventories->total() }}개 중
                            {{ $inventories->firstItem() }}~{{ $inventories->lastItem() }}개 표시
                        </div>
                        <div>
                            {{ $inventories->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fe fe-package fe-3x text-muted mb-3"></i>
                    <h5 class="text-muted">등록된 재고가 없습니다</h5>
                    <p class="text-muted">새 재고 항목을 추가해보세요.</p>
                    <a href="{{ route('admin.site.ecommerce.inventory.create') }}" class="btn btn-primary">
                        <i class="fe fe-plus me-2"></i>새 재고 추가
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

@push('styles')
<style>
/* 통계 카드 원형 아이콘 스타일 */
.stat-circle {
    width: 48px !important;
    height: 48px !important;
    min-width: 48px;
    min-height: 48px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.stat-circle i {
    font-size: 20px;
}

/* 부족 재고 행 강조 */
.table-warning td {
    background-color: rgba(255, 193, 7, 0.1) !important;
}
</style>
@endpush

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
