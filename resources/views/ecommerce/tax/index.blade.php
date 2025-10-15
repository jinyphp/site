@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', $config['title'])

@section('content')
<div class="container-fluid p-4">
    <!-- Page Header -->
    <div class="border-bottom pb-3 mb-4 d-flex flex-lg-row flex-column gap-2 align-items-lg-center justify-content-between">
        <div>
            <h1 class="mb-0 h2 fw-bold">{{ $config['title'] }}</h1>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.cms.dashboard') }}">CMS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">세율 관리</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.cms.country.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fe fe-globe me-2"></i>국가 관리
            </a>
            <button type="button" class="btn btn-outline-primary me-3" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
                <i class="fe fe-edit me-2"></i>일괄 수정
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taxAnalyticsModal">
                <i class="fe fe-bar-chart-2 me-2"></i>세율 분석
            </button>
        </div>
    </div>

    <!-- Error Messages -->
    @if(isset($error))
    <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
        <i class="fe fe-alert-circle me-2"></i>
        <div>
            <strong>오류!</strong> {{ $error }}
        </div>
    </div>
    @endif

    @if(isset($tableNotExist))
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fe fe-alert-triangle me-2"></i>
        <div>
            <strong>주의!</strong> 세율 관리에 필요한 데이터베이스 테이블이 없습니다. 마이그레이션을 실행해주세요.
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row gy-4 mb-4">
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-primary text-primary rounded-circle mx-auto mb-2">
                        <i class="fe fe-globe"></i>
                    </div>
                    <h4 class="mb-0">{{ number_format($stats['total_countries']) }}</h4>
                    <p class="text-muted mb-0 small">전체 국가</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-success text-success rounded-circle mx-auto mb-2">
                        <i class="fe fe-percent"></i>
                    </div>
                    <h4 class="mb-0">{{ number_format($stats['with_tax']) }}</h4>
                    <p class="text-muted mb-0 small">과세 국가</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-warning text-warning rounded-circle mx-auto mb-2">
                        <i class="fe fe-minus-circle"></i>
                    </div>
                    <h4 class="mb-0">{{ number_format($stats['no_tax']) }}</h4>
                    <p class="text-muted mb-0 small">무세 국가</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-info text-info rounded-circle mx-auto mb-2">
                        <i class="fe fe-trending-up"></i>
                    </div>
                    <h4 class="mb-0">{{ $stats['avg_tax_rate'] }}%</h4>
                    <p class="text-muted mb-0 small">평균 세율</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-danger text-danger rounded-circle mx-auto mb-2">
                        <i class="fe fe-arrow-up"></i>
                    </div>
                    <h4 class="mb-0">{{ $stats['max_tax_rate'] }}%</h4>
                    <p class="text-muted mb-0 small">최고 세율</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="icon-shape icon-md bg-light-secondary text-secondary rounded-circle mx-auto mb-2">
                        <i class="fe fe-arrow-down"></i>
                    </div>
                    <h4 class="mb-0">{{ $stats['min_tax_rate'] }}%</h4>
                    <p class="text-muted mb-0 small">최저 세율</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tax Type Overview -->
    @if($stats['tax_types']->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fe fe-pie-chart me-2"></i>세금 유형별 현황
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($stats['tax_types'] as $taxType)
                <div class="col-lg-3 col-md-4 col-6 mb-3">
                    <div class="text-center">
                        <div class="fw-bold text-primary">{{ $taxType['name'] }}</div>
                        <div class="text-muted small">{{ $taxType['count'] }}개국</div>
                        <div class="text-success small">평균 {{ $taxType['avg_rate'] }}%</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">검색 및 필터</h4>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-lg-3 col-md-4 col-12">
                    <label class="form-label">검색</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                           placeholder="국가명, 코드, 세금명...">
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label">세금 유형</label>
                    <select class="form-select" name="tax_name">
                        <option value="all" {{ request('tax_name') === 'all' ? 'selected' : '' }}>모든 유형</option>
                        @foreach($taxTypes as $taxType)
                            <option value="{{ $taxType }}" {{ request('tax_name') === $taxType ? 'selected' : '' }}>
                                {{ $taxType }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label">대륙</label>
                    <select class="form-select" name="continent">
                        <option value="all" {{ request('continent') === 'all' ? 'selected' : '' }}>모든 대륙</option>
                        @foreach(['Asia', 'Europe', 'North America', 'South America', 'Africa', 'Oceania'] as $continent)
                            <option value="{{ $continent }}" {{ request('continent') === $continent ? 'selected' : '' }}>
                                {{ $continent }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-1 col-md-2 col-6">
                    <label class="form-label">최소 세율</label>
                    <input type="number" class="form-control" name="tax_rate_min" value="{{ request('tax_rate_min') }}"
                           placeholder="0" min="0" max="100" step="0.1">
                </div>
                <div class="col-lg-1 col-md-2 col-6">
                    <label class="form-label">최대 세율</label>
                    <input type="number" class="form-control" name="tax_rate_max" value="{{ request('tax_rate_max') }}"
                           placeholder="100" min="0" max="100" step="0.1">
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label">상태</label>
                    <select class="form-select" name="enable">
                        <option value="all" {{ request('enable') === 'all' ? 'selected' : '' }}>모든 상태</option>
                        <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>활성화</option>
                        <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비활성화</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-12 col-12">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-search me-1"></i>
                            <span class="d-none d-sm-inline">검색</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Countries Tax Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">국가별 세율 정보</h4>
                <div class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0 me-2">페이지당:</label>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($countries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px; padding: 0.75rem 0.5rem;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </div>
                                </th>
                                <th style="width: 80px; padding: 0.75rem 0.5rem;">코드</th>
                                <th style="width: 200px; padding: 0.75rem 0.5rem;">국가명</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">대륙</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;">통화</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-end">세율</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">세금 유형</th>
                                <th style="width: 200px; padding: 0.75rem 0.5rem;">세금 설명</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">상태</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($countries as $country)
                            <tr>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div class="form-check">
                                        <input class="form-check-input country-checkbox" type="checkbox" value="{{ $country->id }}">
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <span class="fw-bold text-primary">{{ $country->code }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div class="fw-semibold">{{ $country->name }}</div>
                                        @if($country->name_ko)
                                            <small class="text-muted">{{ $country->name_ko }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    @if($country->continent)
                                        <span class="badge bg-light-info text-info">{{ $country->continent }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    @if($country->currency_code)
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-1">{{ $country->currency_symbol ?: $country->currency_code }}</span>
                                            <span class="text-muted small">{{ $country->currency_code }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-end">
                                    @if($country->tax_rate > 0)
                                        <span class="fw-bold text-primary">{{ number_format($country->tax_rate * 100, 2) }}%</span>
                                    @else
                                        <span class="text-muted">0%</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    @if($country->tax_name)
                                        <span class="badge bg-light-secondary text-secondary">{{ $country->tax_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    @if($country->tax_description)
                                        <span class="text-truncate" style="max-width: 200px;" title="{{ $country->tax_description }}">
                                            {{ \Illuminate\Support\Str::limit($country->tax_description, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    @if($country->enable)
                                        <span class="badge bg-light-success text-success">활성</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">비활성</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            액션
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="editTaxRate({{ $country->id }})"><i class="fe fe-edit me-2"></i>세율 수정</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="viewTaxHistory({{ $country->id }})"><i class="fe fe-clock me-2"></i>변경 이력</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" onclick="copyTaxSettings({{ $country->id }})"><i class="fe fe-copy me-2"></i>설정 복사</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($countries->hasPages())
                <div class="card-footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small flex-shrink-0">
                            <span class="d-none d-sm-inline">총 {{ number_format($countries->total()) }}개 중 </span>
                            <span class="text-nowrap">{{ number_format($countries->firstItem()) }}-{{ number_format($countries->lastItem()) }}개 표시</span>
                        </div>
                        <div class="d-flex justify-content-center flex-shrink-0">
                            {{ $countries->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fe fe-percent text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-muted">등록된 국가가 없습니다</h5>
                    <p class="text-muted">필터 조건을 변경해 보세요.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Tax Rate Modal -->
<div class="modal fade" id="editTaxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">세율 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTaxForm">
                <input type="hidden" id="countryId" name="country_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">국가</label>
                            <input type="text" class="form-control" id="countryName" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">세율 (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tax_rate" id="taxRate"
                                   step="0.01" min="0" max="100" placeholder="10.00" required>
                            <div class="form-text">소수점 둘째 자리까지 입력 가능</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">세금 명칭 <span class="text-danger">*</span></label>
                            <select class="form-select" name="tax_name" id="taxName" required>
                                <option value="">선택해주세요</option>
                                <option value="VAT">VAT (부가가치세)</option>
                                <option value="GST">GST (상품서비스세)</option>
                                <option value="Sales Tax">Sales Tax (판매세)</option>
                                <option value="Consumption Tax">Consumption Tax (소비세)</option>
                                <option value="Service Tax">Service Tax (서비스세)</option>
                                <option value="Other">기타</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">세금 설명</label>
                            <textarea class="form-control" name="tax_description" id="taxDescription" rows="3"
                                      placeholder="세금에 대한 추가 설명"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">저장</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">선택 국가 일괄 수정</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkUpdateForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fe fe-info me-2"></i>
                        선택된 국가들의 세율을 일괄적으로 변경합니다.
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">세율 (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="tax_rate"
                                   step="0.01" min="0" max="100" placeholder="10.00" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">세금 명칭 <span class="text-danger">*</span></label>
                            <select class="form-select" name="tax_name" required>
                                <option value="">선택해주세요</option>
                                <option value="VAT">VAT (부가가치세)</option>
                                <option value="GST">GST (상품서비스세)</option>
                                <option value="Sales Tax">Sales Tax (판매세)</option>
                                <option value="Consumption Tax">Consumption Tax (소비세)</option>
                                <option value="Service Tax">Service Tax (서비스세)</option>
                                <option value="Other">기타</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">세금 설명</label>
                            <textarea class="form-control" name="tax_description" rows="3"
                                      placeholder="세금에 대한 추가 설명"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">일괄 적용</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tax Analytics Modal -->
<div class="modal fade" id="taxAnalyticsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">세율 분석</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>세금 유형별 분석</h6>
                        @if($stats['tax_types']->count() > 0)
                            @foreach($stats['tax_types'] as $taxType)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $taxType['name'] }}</span>
                                <div class="text-end">
                                    <div class="fw-bold">{{ $taxType['count'] }}개국</div>
                                    <small class="text-muted">평균 {{ $taxType['avg_rate'] }}%</small>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">데이터가 없습니다.</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>대륙별 분석</h6>
                        @if($stats['continents']->count() > 0)
                            @foreach($stats['continents'] as $continent)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $continent['name'] }}</span>
                                <div class="text-end">
                                    <div class="fw-bold">{{ $continent['count'] }}개국</div>
                                    <small class="text-muted">평균 {{ $continent['avg_rate'] }}%</small>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">데이터가 없습니다.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Geeks Theme Icon Shapes */
.icon-shape {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    vertical-align: middle;
    width: 48px;
    height: 48px;
}

.icon-shape.icon-md {
    width: 40px;
    height: 40px;
}

/* Background color utilities */
.bg-light-primary {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.bg-light-secondary {
    background-color: rgba(var(--bs-secondary-rgb), 0.1) !important;
}

.bg-light-success {
    background-color: rgba(var(--bs-success-rgb), 0.1) !important;
}

.bg-light-info {
    background-color: rgba(var(--bs-info-rgb), 0.1) !important;
}

.bg-light-warning {
    background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
}

.bg-light-danger {
    background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
}

/* 테이블 반응형 스타일 */
.table-responsive .table {
    margin-bottom: 0;
    min-width: 1200px;
    table-layout: fixed;
    width: 100%;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
}

.table th,
.table td {
    border-top: 1px solid #dee2e6;
    vertical-align: middle;
    box-sizing: border-box;
}

.table thead th {
    border-bottom: 2px solid #dee2e6;
    background-color: #f8f9fa;
}

/* 텍스트 말줄임 */
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
@endpush

@push('scripts')
<script>
// 페이지당 항목 수 변경
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    window.location = url.toString();
}

// 전체 선택/해제
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.country-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

// 세율 수정
function editTaxRate(countryId) {
    // 기존 데이터 가져오기 (실제로는 AJAX로)
    fetch(`/admin/cms/tax/${countryId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('countryId').value = data.country.id;
                document.getElementById('countryName').value = data.country.name;
                document.getElementById('taxRate').value = (data.country.tax_rate * 100).toFixed(2);
                document.getElementById('taxName').value = data.country.tax_name || '';
                document.getElementById('taxDescription').value = data.country.tax_description || '';

                new bootstrap.Modal(document.getElementById('editTaxModal')).show();
            }
        })
        .catch(error => {
            showAlert('국가 정보를 가져오는데 실패했습니다.', 'error');
        });
}

// 세율 수정 폼 제출
document.getElementById('editTaxForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const countryId = document.getElementById('countryId').value;

    fetch(`/admin/cms/tax/${countryId}/update`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('세율이 성공적으로 수정되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '수정 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('수정 중 오류가 발생했습니다.', 'error');
    });

    // 모달 닫기
    bootstrap.Modal.getInstance(document.getElementById('editTaxModal')).hide();
});

// 일괄 수정 폼 제출
document.getElementById('bulkUpdateForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const checkedBoxes = document.querySelectorAll('.country-checkbox:checked');

    if (checkedBoxes.length === 0) {
        showAlert('수정할 국가를 선택해 주세요.', 'warning');
        return;
    }

    const formData = new FormData(this);
    const countryIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);
    formData.append('countries', JSON.stringify(countryIds));

    fetch('/admin/cms/tax/bulk-update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`${data.updated_count}개 국가의 세율이 성공적으로 수정되었습니다.`, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '일괄 수정 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('일괄 수정 중 오류가 발생했습니다.', 'error');
    });

    // 모달 닫기
    bootstrap.Modal.getInstance(document.getElementById('bulkUpdateModal')).hide();
});

// 세율 변경 이력 보기
function viewTaxHistory(countryId) {
    showAlert('세율 변경 이력 기능은 곧 구현될 예정입니다.', 'info');
}

// 세율 설정 복사
function copyTaxSettings(countryId) {
    showAlert('세율 설정 복사 기능은 곧 구현될 예정입니다.', 'info');
}

// 알림 메시지 표시
function showAlert(message, type = 'info') {
    const alertType = type === 'error' ? 'danger' : type;
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${alertType} alert-dismissible fade show`;
    alertDiv.style.position = 'fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => {
        if (alertDiv && alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush
