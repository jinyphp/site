{{-- 배송 지역 관리 --}}
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
                            <li class="breadcrumb-item active" aria-current="page">배송 지역</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a href="#" class="me-3 text-body">
                        <i class="fe fe-download me-2"></i>내보내기
                    </a>
                    <a href="{{ route('admin.cms.ecommerce.shipping.index') }}" class="me-2 btn btn-outline-secondary">
                        <i class="fe fe-home me-2"></i>배송 대시보드
                    </a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addZoneModal">
                        <i class="fe fe-plus me-2"></i>지역 추가
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 통계 카드 -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $zones->total() }}</h4>
                            <p class="text-muted mb-0">총 배송 지역</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="fe fe-globe"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $zones->where('enable', true)->count() }}</h4>
                            <p class="text-muted mb-0">활성 지역</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $zones->sum('country_count') }}</h4>
                            <p class="text-muted mb-0">포함 국가</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="fe fe-map"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $zones->sum('rate_count') }}</h4>
                            <p class="text-muted mb-0">설정 요금</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="fe fe-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 배송 지역 목록 -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">배송 지역 목록</h4>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width: auto;" onchange="window.location.search='status='+this.value">
                                <option value="">전체 상태</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>활성</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>비활성</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 검색 및 필터 -->
                <div class="card-body border-bottom">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">검색</label>
                            <input type="search" class="form-control" name="search" value="{{ $search }}" placeholder="지역 이름 검색 등">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">정렬</label>
                            <select class="form-select" name="sort_by">
                                <option value="order" {{ $sort_by === 'order' ? 'selected' : '' }}>순서</option>
                                <option value="name" {{ $sort_by === 'name' ? 'selected' : '' }}>이름</option>
                                <option value="country_count" {{ $sort_by === 'country_count' ? 'selected' : '' }}>국가 수</option>
                                <option value="created_at" {{ $sort_by === 'created_at' ? 'selected' : '' }}>생성일</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">방향</label>
                            <select class="form-select" name="sort_order">
                                <option value="asc" {{ $sort_order === 'asc' ? 'selected' : '' }}>오름차순</option>
                                <option value="desc" {{ $sort_order === 'desc' ? 'selected' : '' }}>내림차순</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">표시 수</label>
                            <select class="form-select" name="per_page">
                                <option value="15" {{ $per_page == 15 ? 'selected' : '' }}>15</option>
                                <option value="30" {{ $per_page == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ $per_page == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">검색</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>순서</th>
                                <th>지역명</th>
                                <th>설명</th>
                                <th class="text-center">국가 수</th>
                                <th class="text-center">요금 수</th>
                                <th class="text-center">기본 지역</th>
                                <th class="text-center">상태</th>
                                <th class="text-center">생성일</th>
                                <th class="text-center">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($zones as $zone)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $zone->order }}</span>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $zone->name_ko ?: $zone->name }}</h6>
                                        @if($zone->name_ko && $zone->name !== $zone->name_ko)
                                            <small class="text-muted">{{ $zone->name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($zone->description, 50) ?: '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light-info text-info">{{ $zone->country_count }}개국</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light-warning text-warning">{{ $zone->rate_count }}개</span>
                                </td>
                                <td class="text-center">
                                    @if($zone->is_default)
                                        <span class="badge bg-light-success text-success">기본</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($zone->enable)
                                        <span class="badge bg-light-success text-success">활성</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">비활성</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="text-muted">{{ Carbon\Carbon::parse($zone->created_at)->format('Y-m-d') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            관리
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i>상세보기</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-map me-2"></i>국가 관리</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>복사</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                @if($zone->enable)
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye-off me-2"></i>비활성화</a>
                                                @else
                                                    <a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i>활성화</a>
                                                @endif
                                            </li>
                                            @if(!$zone->is_default)
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fe fe-globe fs-1 mb-3"></i>
                                        <p>배송 지역이 없습니다.</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addZoneModal">
                                            첫 번째 지역 추가하기
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($zones->hasPages())
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-0">
                                {{ $zones->firstItem() }}-{{ $zones->lastItem() }} / {{ $zones->total() }} 개
                            </p>
                        </div>
                        <div>
                            {{ $zones->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- 지역 추가 모달 -->
<div class="modal fade" id="addZoneModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">배송 지역 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">지역명 (한국어) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: 아시아">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">지역명 (영어) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="예: Asia">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">순서</label>
                            <input type="number" class="form-control" value="1" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">상태</label>
                            <select class="form-select">
                                <option value="1">활성</option>
                                <option value="0">비활성</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">설명</label>
                            <textarea class="form-control" rows="3" placeholder="배송 지역에 대한 설명을 입력하세요"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isDefault">
                                <label class="form-check-label" for="isDefault">
                                    기본 지역으로 설정
                                </label>
                                <div class="form-text">기본 지역은 미지정 국가의 주문이 자동으로 할당됩니다.</div>
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
    // 지역 추가 폼 처리
    const form = document.querySelector('#addZoneModal form');
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('배송 지역이 추가됩니다. (임시)');
        bootstrap.Modal.getInstance(document.getElementById('addZoneModal')).hide();
    });
});
</script>
@endpush
