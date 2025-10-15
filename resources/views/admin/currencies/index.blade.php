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
                    <li class="breadcrumb-item active" aria-current="page">통화 관리</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-outline-secondary me-3" data-bs-toggle="modal" data-bs-target="#syncRatesModal">
                <i class="fe fe-refresh-cw me-2"></i>환율 동기화
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                <i class="fe fe-plus me-2"></i>통화 추가
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
                            <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                            <p class="text-muted mb-0">전체 통화</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-primary text-primary rounded-3">
                            <i class="fe fe-dollar-sign"></i>
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
                            <h4 class="mb-0">{{ number_format($stats['enabled']) }}</h4>
                            <p class="text-muted mb-0">활성화</p>
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
                            <h4 class="mb-0">{{ $stats['base_currency'] }}</h4>
                            <p class="text-muted mb-0">기준 통화</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-warning text-warning rounded-3">
                            <i class="fe fe-star"></i>
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
                            <h4 class="mb-0">{{ number_format($exchange_rate_stats['active_rates']) }}</h4>
                            <p class="text-muted mb-0">활성 환율</p>
                        </div>
                        <div class="icon-shape icon-lg bg-light-info text-info rounded-3">
                            <i class="fe fe-trending-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exchange Rate Status Alert -->
    @if($exchange_rate_stats['expired_rates'] > 0)
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fe fe-alert-triangle me-2"></i>
        <div>
            <strong>주의!</strong> {{ number_format($exchange_rate_stats['expired_rates']) }}개의 환율이 만료되었습니다.
            <a href="{{ route('admin.cms.exchange-rates.index') }}" class="alert-link">환율 관리로 이동</a>
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
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="form-label">검색</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                           placeholder="통화 코드, 이름, 기호...">
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <label class="form-label">상태</label>
                    <select class="form-select" name="enable">
                        <option value="all" {{ request('enable') === 'all' ? 'selected' : '' }}>모든 상태</option>
                        <option value="1" {{ request('enable') === '1' ? 'selected' : '' }}>활성화</option>
                        <option value="0" {{ request('enable') === '0' ? 'selected' : '' }}>비활성화</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-6">
                    <label class="form-label">기준 통화</label>
                    <select class="form-select" name="is_base">
                        <option value="all" {{ request('is_base') === 'all' ? 'selected' : '' }}>전체</option>
                        <option value="1" {{ request('is_base') === '1' ? 'selected' : '' }}>기준 통화</option>
                        <option value="0" {{ request('is_base') === '0' ? 'selected' : '' }}>일반 통화</option>
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

    <!-- Currencies Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">통화 목록</h4>
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
            @if($currencies->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px; padding: 0.75rem 0.5rem;">순서</th>
                                <th style="width: 80px; padding: 0.75rem 0.5rem;">코드</th>
                                <th style="width: 60px; padding: 0.75rem 0.5rem;">기호</th>
                                <th style="width: 200px; padding: 0.75rem 0.5rem;">통화명</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">소수점</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">기준 통화</th>
                                <th style="width: 100px; padding: 0.75rem 0.5rem;" class="text-center">상태</th>
                                <th style="width: 150px; padding: 0.75rem 0.5rem;">생성일</th>
                                <th style="width: 120px; padding: 0.75rem 0.5rem;">액션</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($currencies as $currency)
                            <tr>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <span class="badge bg-light text-dark">{{ $currency->order }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <span class="fw-bold text-primary">{{ $currency->code }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <span class="fw-bold" style="font-size: 1.1em;">{{ $currency->symbol }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div class="fw-semibold">{{ $currency->name }}</div>
                                        @if($currency->description)
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($currency->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    <span class="badge bg-light-secondary text-secondary">{{ $currency->decimal_places }}</span>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    @if($currency->is_base)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fe fe-star me-1"></i>기준
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;" class="text-center">
                                    @if($currency->enable)
                                        <span class="badge bg-light-success text-success">활성화</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">비활성화</span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div>
                                        <div>{{ \Carbon\Carbon::parse($currency->created_at)->format('Y.m.d') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($currency->created_at)->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td style="padding: 0.75rem 0.5rem;">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            액션
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="editCurrency({{ $currency->id }})"><i class="fe fe-edit me-2"></i>수정</a></li>
                                            @if(!$currency->is_base)
                                                <li><a class="dropdown-item" href="#" onclick="setBaseCurrency({{ $currency->id }})"><i class="fe fe-star me-2"></i>기준 통화 설정</a></li>
                                            @endif
                                            <li>
                                                @if($currency->enable)
                                                    <a class="dropdown-item" href="#" onclick="toggleCurrency({{ $currency->id }}, false)"><i class="fe fe-eye-off me-2"></i>비활성화</a>
                                                @else
                                                    <a class="dropdown-item" href="#" onclick="toggleCurrency({{ $currency->id }}, true)"><i class="fe fe-eye me-2"></i>활성화</a>
                                                @endif
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            @if(!$currency->is_base)
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteCurrency({{ $currency->id }})"><i class="fe fe-trash-2 me-2"></i>삭제</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($currencies->hasPages())
                <div class="card-footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small flex-shrink-0">
                            <span class="d-none d-sm-inline">총 {{ number_format($currencies->total()) }}개 중 </span>
                            <span class="text-nowrap">{{ number_format($currencies->firstItem()) }}-{{ number_format($currencies->lastItem()) }}개 표시</span>
                        </div>
                        <div class="d-flex justify-content-center flex-shrink-0">
                            {{ $currencies->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fe fe-dollar-sign text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-muted">등록된 통화가 없습니다</h5>
                    <p class="text-muted">첫 번째 통화를 추가해보세요.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                        통화 추가하기
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Currency Modal -->
<div class="modal fade" id="addCurrencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">통화 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCurrencyForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">통화 코드 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="code" placeholder="예: USD" maxlength="3" required>
                            <div class="form-text">3자리 ISO 통화 코드</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">통화명 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="예: US Dollar" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">통화 기호 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="symbol" placeholder="예: $" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">설명</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="통화에 대한 설명"></textarea>
                        </div>
                        <div class="col-6">
                            <label class="form-label">소수점 자리수</label>
                            <select class="form-select" name="decimal_places">
                                <option value="0">0 (예: JPY)</option>
                                <option value="2" selected>2 (예: USD)</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">정렬 순서</label>
                            <input type="number" class="form-control" name="order" value="0">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enable" id="enableCurrency" checked>
                                <label class="form-check-label" for="enableCurrency">
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

<!-- Sync Rates Modal -->
<div class="modal fade" id="syncRatesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">환율 동기화</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fe fe-refresh-cw text-primary" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">환율 정보를 최신으로 업데이트하시겠습니까?</h5>
                    <p class="text-muted">외부 API를 통해 최신 환율 정보를 가져옵니다.</p>
                </div>
                <div class="alert alert-info">
                    <i class="fe fe-info me-2"></i>
                    마지막 업데이트: {{ $exchange_rate_stats['last_update'] ? \Carbon\Carbon::parse($exchange_rate_stats['last_update'])->format('Y.m.d H:i') : '없음' }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="button" class="btn btn-primary" onclick="syncExchangeRates()">동기화 시작</button>
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
    min-width: 800px;
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

// 통화 추가
document.getElementById('addCurrencyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/admin/cms/currencies', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('통화가 성공적으로 추가되었습니다.', 'success');
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

// 통화 수정
function editCurrency(id) {
    // 실제 구현 시 모달을 통한 수정 기능
    showAlert('수정 기능은 곧 구현될 예정입니다.', 'info');
}

// 기준 통화 설정
function setBaseCurrency(id) {
    if (!confirm('이 통화를 기준 통화로 설정하시겠습니까?')) {
        return;
    }

    fetch(`/admin/cms/currencies/${id}/set-base`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('기준 통화가 변경되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(data.message || '변경 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('변경 중 오류가 발생했습니다.', 'error');
    });
}

// 통화 활성화/비활성화
function toggleCurrency(id, enable) {
    const action = enable ? '활성화' : '비활성화';

    if (!confirm(`이 통화를 ${action}하시겠습니까?`)) {
        return;
    }

    fetch(`/admin/cms/currencies/${id}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ enable: enable })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`통화가 ${action}되었습니다.`, 'success');
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

// 통화 삭제
function deleteCurrency(id) {
    if (!confirm('이 통화를 삭제하시겠습니까? 삭제된 통화는 복구할 수 없습니다.')) {
        return;
    }

    fetch(`/admin/cms/currencies/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('통화가 삭제되었습니다.', 'success');
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

// 환율 동기화
function syncExchangeRates() {
    showAlert('환율 동기화를 시작합니다...', 'info');

    fetch('/admin/cms/exchange-rates/sync', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('환율이 성공적으로 동기화되었습니다.', 'success');
            setTimeout(() => window.location.reload(), 2000);
        } else {
            showAlert(data.message || '동기화 중 오류가 발생했습니다.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('동기화 중 오류가 발생했습니다.', 'error');
    });

    // 모달 닫기
    bootstrap.Modal.getInstance(document.getElementById('syncRatesModal')).hide();
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
