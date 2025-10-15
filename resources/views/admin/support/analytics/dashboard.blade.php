@extends($layout ?? 'jiny-site::layouts.admin.sidebar')

@section('title', '지원 요청 통계 대시보드')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fe fe-bar-chart-2 me-2"></i>
                지원 요청 통계 대시보드
            </h1>
            <p class="text-muted">지원 요청 현황과 성과 지표를 확인할 수 있습니다.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('admin.cms.support.requests.index') }}" class="btn btn-outline-secondary">
                <i class="fe fe-arrow-left me-2"></i>지원 요청 관리
            </a>
            <select class="form-select" id="periodSelector" style="width: auto;">
                <option value="7" {{ $period_days == 7 ? 'selected' : '' }}>최근 7일</option>
                <option value="30" {{ $period_days == 30 ? 'selected' : '' }}>최근 30일</option>
                <option value="90" {{ $period_days == 90 ? 'selected' : '' }}>최근 90일</option>
                <option value="365" {{ $period_days == 365 ? 'selected' : '' }}>최근 1년</option>
            </select>
        </div>
    </div>

    {{-- 기본 통계 카드 --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <div class="h2 mb-0 text-primary">{{ number_format($basic_stats['total']) }}</div>
                    <p class="card-text text-muted">총 요청</p>
                    <small class="text-muted">
                        오늘: {{ number_format($basic_stats['today']) }} |
                        이번 주: {{ number_format($basic_stats['this_week']) }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <div class="h2 mb-0 text-warning">{{ number_format($basic_stats['pending']) }}</div>
                    <p class="card-text text-muted">대기 중</p>
                    <small class="text-muted">
                        전체의 {{ $basic_stats['total'] > 0 ? number_format(($basic_stats['pending'] / $basic_stats['total']) * 100, 1) : 0 }}%
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <div class="h2 mb-0 text-info">{{ number_format($basic_stats['in_progress']) }}</div>
                    <p class="card-text text-muted">진행 중</p>
                    <small class="text-muted">
                        전체의 {{ $basic_stats['total'] > 0 ? number_format(($basic_stats['in_progress'] / $basic_stats['total']) * 100, 1) : 0 }}%
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <div class="h2 mb-0 text-success">{{ number_format($basic_stats['resolved']) }}</div>
                    <p class="card-text text-muted">해결됨</p>
                    <small class="text-muted">
                        해결률: {{ $basic_stats['total'] > 0 ? number_format(($basic_stats['resolved'] / $basic_stats['total']) * 100, 1) : 0 }}%
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- 성능 지표 --}}
    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-clock me-2"></i>
                        성능 지표
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h4 text-primary">{{ $performance_metrics['avg_resolution_time_hours'] }}h</div>
                                <small class="text-muted">평균 해결시간</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-success">{{ $performance_metrics['resolution_rate_percent'] }}%</div>
                            <small class="text-muted">해결률</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h4 text-info">{{ $performance_metrics['avg_first_response_time_hours'] }}h</div>
                                <small class="text-muted">평균 첫 응답시간</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-warning">{{ number_format($performance_metrics['satisfaction_score'], 1) }}</div>
                            <small class="text-muted">만족도 점수</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 트렌드 차트 --}}
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-trending-up me-2"></i>
                        일별 요청 트렌드
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- 분석 차트들 --}}
    <div class="row mb-4">
        {{-- 우선순위별 통계 --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-flag me-2"></i>
                        우선순위별 통계
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="priorityChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- 유형별 통계 --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-layers me-2"></i>
                        유형별 통계
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="typeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- 시간별/요일별 분포 --}}
    <div class="row mb-4">
        {{-- 시간별 분포 --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-clock me-2"></i>
                        시간별 요청 분포
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="hourlyChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- 요일별 분포 --}}
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-calendar me-2"></i>
                        요일별 요청 분포
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="weeklyChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- 담당자별 통계 테이블 --}}
    @if(!empty($assignee_stats) && count($assignee_stats) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fe fe-users me-2"></i>
                        담당자별 처리 현황
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>담당자</th>
                                    <th>총 요청</th>
                                    <th>대기</th>
                                    <th>진행중</th>
                                    <th>해결</th>
                                    <th>해결률</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignee_stats as $stat)
                                <tr>
                                    <td>{{ $stat['assignee_name'] }}</td>
                                    <td><span class="badge bg-primary">{{ number_format($stat['total']) }}</span></td>
                                    <td><span class="badge bg-warning">{{ number_format($stat['pending']) }}</span></td>
                                    <td><span class="badge bg-info">{{ number_format($stat['in_progress']) }}</span></td>
                                    <td><span class="badge bg-success">{{ number_format($stat['resolved']) }}</span></td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success"
                                                 style="width: {{ $stat['resolution_rate'] }}%">
                                                {{ $stat['resolution_rate'] }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 데이터 업데이트 정보 --}}
    <div class="row">
        <div class="col-12">
            <div class="alert alert-light">
                <i class="fe fe-info me-2"></i>
                <strong>데이터 업데이트:</strong> {{ \Carbon\Carbon::parse($generated_at)->format('Y-m-d H:i:s') }}
                <span class="float-end">
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshData()">
                        <i class="fe fe-refresh-cw me-1"></i> 새로고침
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// 전역 변수로 차트 데이터 저장
const chartData = {
    trend: @json($trend_data),
    priority: @json($priority_stats),
    type: @json($type_stats),
    hourly: @json($hourly_distribution),
    weekly: @json($weekly_distribution)
};

// 차트 색상 팔레트
const colors = {
    primary: '#007bff',
    success: '#28a745',
    info: '#17a2b8',
    warning: '#ffc107',
    danger: '#dc3545',
    secondary: '#6c757d'
};

// 트렌드 차트
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: chartData.trend.map(item => item.date),
        datasets: [{
            label: '총 요청',
            data: chartData.trend.map(item => item.total),
            borderColor: colors.primary,
            backgroundColor: colors.primary + '20',
            tension: 0.4
        }, {
            label: '해결됨',
            data: chartData.trend.map(item => item.resolved),
            borderColor: colors.success,
            backgroundColor: colors.success + '20',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 우선순위 차트
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'doughnut',
    data: {
        labels: chartData.priority.map(item => item.priority_label),
        datasets: [{
            data: chartData.priority.map(item => item.count),
            backgroundColor: [colors.danger, colors.warning, colors.info, colors.secondary]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// 유형별 차트
const typeCtx = document.getElementById('typeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'bar',
    data: {
        labels: chartData.type.map(item => item.type_label),
        datasets: [{
            label: '요청 수',
            data: chartData.type.map(item => item.count),
            backgroundColor: colors.primary
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 시간별 차트
const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
new Chart(hourlyCtx, {
    type: 'bar',
    data: {
        labels: Array.from({length: 24}, (_, i) => i + '시'),
        datasets: [{
            label: '요청 수',
            data: Array.from({length: 24}, (_, i) => {
                const hourData = chartData.hourly.find(item => item.hour === i);
                return hourData ? hourData.count : 0;
            }),
            backgroundColor: colors.info
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 요일별 차트
const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
new Chart(weeklyCtx, {
    type: 'bar',
    data: {
        labels: chartData.weekly.map(item => item.day_name),
        datasets: [{
            label: '요청 수',
            data: chartData.weekly.map(item => item.count),
            backgroundColor: colors.warning
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 기간 선택 이벤트
document.getElementById('periodSelector').addEventListener('change', function() {
    const period = this.value;
    window.location.href = `{{ url()->current() }}?period=${period}`;
});

// 데이터 새로고침
function refreshData() {
    location.reload();
}
</script>
@endsection
