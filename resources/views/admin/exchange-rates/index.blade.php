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
                    <li class="breadcrumb-item active" aria-current="page">환율 관리</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.cms.currencies.index') }}" class="btn btn-outline-secondary me-3">
                <i class="fe fe-dollar-sign me-2"></i>통화 관리
            </a>
            <button type="button" class="btn btn-outline-primary me-3" onclick="refreshAllRates()">
                <i class="fe fe-refresh-cw me-2"></i>전체 갱신
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRateModal">
                <i class="fe fe-plus me-2"></i>환율 추가
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row gy-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['total_rates']) }}</h4>
                            <p class="text-muted mb-0">전체 환율</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="fe fe-trending-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['active_rates']) }}</h4>
                            <p class="text-muted mb-0">활성 환율</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-success text-success rounded-3">
                            <i class="fe fe-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0 text-warning">{{ number_format($stats['expired_rates']) }}</h4>
                            <p class="text-muted mb-0">만료된 환율</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="fe fe-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ number_format($stats['recent_updates']) }}</h4>
                            <p class="text-muted mb-0">주간 업데이트</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="fe fe-activity"></i>
                        </div>
                    </div>
                </div>
            </div>
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

    @if(isset($tablesNotExist))
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fe fe-alert-triangle me-2"></i>
        <div>
            <strong>주의!</strong> 환율 관리에 필요한 데이터베이스 테이블이 없습니다. 마이그레이션을 실행해주세요.
        </div>
    </div>
    @endif

    <!-- Exchange Rate Status Alert -->
    @if(isset($stats['expired_rates']) && $stats['expired_rates'] > 0)
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fe fe-alert-triangle me-2"></i>
        <div>
            <strong>주의!</strong> {{ number_format($stats['expired_rates']) }}개의 환율이 만료되었습니다.
        </div>
    </div>
    @endif

    <!-- Recent Rate Changes -->
    @if(isset($recentChanges) && $recentChanges->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fe fe-trending-up me-2"></i>최근 환율 변동
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($recentChanges->take(6) as $change)
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="text-center">
                        <div class="fw-bold">{{ $change->from_currency }}/{{ $change->to_currency }}</div>
                        <div class="small text-muted">{{ number_format($change->new_rate, 6) }}</div>
                        <div class="small {{ $change->rate_change >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fe fe-{{ $change->rate_change >= 0 ? 'trending-up' : 'trending-down' }} me-1"></i>
                            {{ $change->rate_change > 0 ? '+' : '' }}{{ number_format($change->rate_change_percent, 2) }}%
                        </div>
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
                    <label class="form-label">기준 통화</label>
                    <select class="form-select" name="from_currency">
                        <option value="">모든 기준 통화</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->code }}" {{ request('from_currency') === $currency->code ? 'selected' : '' }}>
                                {{ $currency->code }} - {{ $currency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <label class="form-label">대상 통화</label>
                    <select class="form-select" name="to_currency">
                        <option value="">모든 대상 통화</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->code }}" {{ request('to_currency') === $currency->code ? 'selected' : '' }}>
                                {{ $currency->code }} - {{ $currency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label">상태</label>
                    <select class="form-select" name="is_active">
                        <option value="all" {{ request('is_active') === 'all' ? 'selected' : '' }}>모든 상태</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>활성</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>비활성</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label">출처</label>
                    <select class="form-select" name="source">
                        <option value="">모든 출처</option>
                        <option value="manual" {{ request('source') === 'manual' ? 'selected' : '' }}>수동</option>
                        <option value="api" {{ request('source') === 'api' ? 'selected' : '' }}>API</option>
                        <option value="bank" {{ request('source') === 'bank' ? 'selected' : '' }}>은행</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-12 col-12">
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

    <!-- Exchange Rates Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">환율 목록</h4>
                <div class="d-flex align-items-center gap-2">
                    <label class="form-label mb-0 me-2">페이지당:</label>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($exchangeRates->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">통화 쌍</th>
                                <th style="width: 140px; padding: 0.75rem 0.5rem;" class="text-end">환율</th>
                                <th style="width: 140px; padding: 0.75rem 0.5rem;" class="text-end">역환율</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">출처</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">기준일시</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">만료일시</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">상태</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exchangeRates as $rate)
                            <tr class="{{ $rate->expires_at && $rate->expires_at <= now() ? 'table-warning' : '' }}">
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-primary">{{ $rate->from_currency }}</span>
                                        <i class="fe fe-arrow-right mx-2 text-muted"></i>
                                        <span class="fw-bold text-success">{{ $rate->to_currency }}</span>
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-end">
                                    <span class="fw-bold">{{ number_format($rate->rate, 6) }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-end">
                                    <span class="text-muted">{{ number_format($rate->inverse_rate, 6) }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    @if($rate->source === 'manual')
                                        <span class="badge bg-light-secondary text-secondary">수동</span>
                                    @elseif($rate->source === 'api')
                                        <span class="badge bg-light-primary text-primary">API</span>
                                    @elseif($rate->source === 'bank')
                                        <span class="badge bg-light-info text-info">은행</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $rate->source }}</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div>{{ \Carbon\Carbon::parse($rate->rate_date)->format('m.d') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($rate->rate_date)->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    @if($rate->expires_at)
                                        <div>
                                            <div class="{{ $rate->expires_at <= now() ? 'text-danger' : '' }}">
                                                {{ \Carbon\Carbon::parse($rate->expires_at)->format('m.d') }}
                                            </div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($rate->expires_at)->format('H:i') }}</small>
                                        </div>
                                        @if($rate->expires_at <= now())
                                            <small class="text-danger">만료됨</small>
                                        @endif
                                    @else
                                        <span class="text-muted">무제한</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    @if($rate->is_active)
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
                                            <li><a class="dropdown-item" href="#" onclick="editRate({{ $rate->id }})"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="refreshRate({{ $rate->id }})"><i class="fe fe-refresh-cw me-2"></i>갱신</a></li>
                                            <li>
                                                @if($rate->is_active)
                                                    <a class="dropdown-item" href="#" onclick="toggleRate({{ $rate->id }}, false)"><i class="fe fe-eye-off me-2"></i>비활성화</a>
                                                @else
                                                    <a class="dropdown-item" href="#" onclick="toggleRate({{ $rate->id }}, true)"><i class="fe fe-eye me-2"></i>활성화</a>
                                                @endif
                                            </li>
                                            <li><a class="dropdown-item" href="#" onclick="viewHistory({{ $rate->id }})"><i class="fe fe-clock me-2"></i>변경 이력</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteRate({{ $rate->id }})"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($exchangeRates->hasPages())
                <div class="card-footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small flex-shrink-0">
                            <span class="d-none d-sm-inline">총 {{ number_format($exchangeRates->total()) }}개 중 </span>
                            <span class="text-nowrap">{{ number_format($exchangeRates->firstItem()) }}-{{ number_format($exchangeRates->lastItem()) }}개 표시</span>
                        </div>
                        <div class="d-flex justify-content-center flex-shrink-0">
                            {{ $exchangeRates->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fe fe-trending-up text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-muted">등록된 환율이 없습니다</h5>
                    <p class="text-muted">첫 번째 환율을 추가해보세요.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRateModal">
                        환율 추가하기
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Rate Modal -->
<div class="modal fade" id="addRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">환율 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addRateForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">기준 통화 <span class="text-danger">*</span></label>
                            <select class="form-select" name="from_currency" required>
                                <option value="">선택해주세요</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">대상 통화 <span class="text-danger">*</span></label>
                            <select class="form-select" name="to_currency" required>
                                <option value="">선택해주세요</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->code }}">{{ $currency->code }} - {{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">환율 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="rate" step="0.000001" placeholder="예: 1350.000000" required>
                            <div class="form-text">1 기준통화 = 환율 × 대상통화</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">출처</label>
                            <select class="form-select" name="source">
                                <option value="manual">수동 입력</option>
                                <option value="api">API</option>
                                <option value="bank">은행</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">제공업체</label>
                            <input type="text" class="form-control" name="provider" placeholder="예: 한국은행">
                        </div>
                        <div class="col-6">
                            <label class="form-label">기준일시</label>
                            <input type="datetime-local" class="form-control" name="rate_date" value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label">만료일시</label>
                            <input type="datetime-local" class="form-control" name="expires_at" value="{{ now()->addDay()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">비고</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="환율에 대한 추가 정보"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="activeRate" checked>
                                <label class="form-check-label" for="activeRate">
                                    활성화
                                </label>
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

.icon-shape.icon-lg {
    width: 48px;
    height: 48px;
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
    min-width: 1000px;
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

/* 만료된 행 스타일 */
.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
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

// 환율 추가
document.getElementById('addRateForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/admin/cms/exchange-rates', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('환율이 성공적으로 추가되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '추가 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('추가 중 오류가 발생했습니다.', 'error');
    });
});

// 환율 수정
function editRate(id) {
    showAlert('수정 기능은 곧 구현될 예정입니다.', 'info');
}

// 환율 갱신
function refreshRate(id) {
    if (!confirm('이 환율을 최신 정보로 갱신하시겠습니까?')) {
        return;
    }

    fetch(`/admin/cms/exchange-rates/${id}/refresh`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('환율이 성공적으로 갱신되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '갱신 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('갱신 중 오류가 발생했습니다.', 'error');
    });
}

// 전체 환율 갱신
function refreshAllRates() {
    if (!confirm('모든 환율을 최신 정보로 갱신하시겠습니까? 시간이 다소 소요될 수 있습니다.')) {
        return;
    }

    showAlert('환율 갱신을 시작합니다...', 'info');

    fetch('/admin/cms/exchange-rates/refresh-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`${data.updated || 0}개의 환율이 성공적으로 갱신되었습니다.`, 'success');
            setTimeout(() => window.location.reload(), 2000);
        } else {
            showAlert(data.message || '갱신 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('갱신 중 오류가 발생했습니다.', 'error');
    });
}

// 환율 활성화/비활성화
function toggleRate(id, active) {
    const action = active ? '활성화' : '비활성화';

    if (!confirm(`이 환율을 ${action}하시겠습니까?`)) {
        return;
    }

    fetch(`/admin/cms/exchange-rates/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ is_active: active })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`환율이 ${action}되었습니다.`, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || `${action} 중 오류가 발생했습니다.`, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert(`${action} 중 오류가 발생했습니다.`, 'error');
    });
}

// 변경 이력 보기
function viewHistory(id) {
    showAlert('변경 이력 기능은 곧 구현될 예정입니다.', 'info');
}

// 환율 삭제
function deleteRate(id) {
    if (!confirm('이 환율을 삭제하시겠습니까? 삭제된 환율은 복구할 수 없습니다.')) {
        return;
    }

    fetch(`/admin/cms/exchange-rates/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('환율이 삭제되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '삭제 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('삭제 중 오류가 발생했습니다.', 'error');
    });
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
