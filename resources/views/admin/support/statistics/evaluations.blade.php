@extends('jiny-admin::layouts.admin')

@section('title', '평가 통계 대시보드')

@section('content')
<div class="container-fluid">
    <!-- 헤더 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">평가 통계 대시보드</h1>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary" onclick="showCompareModal()">
                        <i class="fe fe-bar-chart-2 me-1"></i>관리자 비교
                    </button>
                    <a href="{{ route('admin.cms.support.statistics.evaluations.report') }}" class="btn btn-outline-secondary">
                        <i class="fe fe-download me-1"></i>리포트 다운로드
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 필터 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-3">
                            <label for="adminSelect" class="form-label">관리자</label>
                            <select id="adminSelect" name="admin_id" class="form-select">
                                @foreach($admins as $adminOption)
                                <option value="{{ $adminOption->id }}" {{ $adminOption->id == $selectedAdminId ? 'selected' : '' }}>
                                    {{ $adminOption->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="startDate" class="form-label">시작일</label>
                            <input type="date" id="startDate" name="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate" class="form-label">종료일</label>
                            <input type="date" id="endDate" name="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-search me-1"></i>조회
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 요약 통계 카드 -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_count'] }}</h4>
                            <p class="mb-0">총 평가수</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-star fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['average_rating'] }}</h4>
                            <p class="mb-0">평균 평점</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-trending-up fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $ranking['current_rank'] ?? 'N/A' }}</h4>
                            <p class="mb-0">전체 순위</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-award fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $ranking['percentile'] ?? 0 }}%</h4>
                            <p class="mb-0">상위 퍼센트</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fe fe-percent fs-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- 평점 분포 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">평점 분포</h5>
                </div>
                <div class="card-body">
                    @if($stats['total_count'] > 0)
                    <div class="rating-distribution">
                        @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $stats['rating_distribution'][$i] ?? 0;
                            $percentage = $stats['total_count'] > 0 ? round(($count / $stats['total_count']) * 100, 1) : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="rating-label me-3" style="width: 80px;">
                                {{ $i }}점
                                @for($j = 0; $j < $i; $j++)
                                <i class="fas fa-star text-warning"></i>
                                @endfor
                            </div>
                            <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="rating-count" style="width: 60px;">
                                {{ $count }}개 ({{ $percentage }}%)
                            </div>
                        </div>
                        @endfor
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fe fe-star fs-1 mb-2"></i>
                        <p>평가 데이터가 없습니다.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 세부 기준별 점수 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">세부 기준별 평가</h5>
                </div>
                <div class="card-body">
                    @if(count($criteriaStats) > 0)
                    <div class="criteria-stats">
                        @php
                            $criteriaLabels = [
                                'response_speed' => '응답 속도',
                                'problem_solving' => '해결 능력',
                                'kindness' => '친절도',
                                'expertise' => '전문성'
                            ];
                        @endphp
                        @foreach($criteriaStats as $criterion => $stats)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $criteriaLabels[$criterion] ?? $criterion }}</strong>
                                <small class="text-muted d-block">{{ $stats['count'] }}개 평가</small>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-0">{{ $stats['average'] }}</h5>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= round($stats['average']) ? 's' : 'r' }} fa-star text-warning"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fe fe-bar-chart fs-1 mb-2"></i>
                        <p>세부 평가 데이터가 없습니다.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 최근 평가 -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">최근 평가</h5>
                </div>
                <div class="card-body">
                    @if($recentEvaluations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>지원 요청</th>
                                    <th>평가자</th>
                                    <th>평점</th>
                                    <th>평가일</th>
                                    <th>의견</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentEvaluations as $evaluation)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.cms.support.requests.show', $evaluation->support_id) }}" class="text-decoration-none">
                                            #{{ $evaluation->support_id }} - {{ Str::limit($evaluation->support->subject, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $evaluation->is_anonymous ? '익명' : ($evaluation->evaluator->name ?? '알 수 없음') }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $evaluation->rating }}</span>
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $evaluation->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $evaluation->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($evaluation->comment)
                                        <small>{{ Str::limit($evaluation->comment, 50) }}</small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="fe fe-message-circle fs-1 mb-2"></i>
                        <p>최근 평가가 없습니다.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 필터 폼 제출
document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const params = new URLSearchParams();

    for (let [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }

    window.location.href = '{{ route("admin.cms.support.statistics.evaluations.index") }}' + '?' + params.toString();
});

// 관리자 비교 모달
function showCompareModal() {
    alert('관리자 비교 기능은 구현 예정입니다.');
}
</script>
@endpush

@push('styles')
<style>
.rating-distribution .progress {
    height: 20px;
}

.stars {
    font-size: 0.9rem;
}

.stars i {
    margin-right: 1px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.bg-primary .card-body h4,
.bg-success .card-body h4,
.bg-info .card-body h4,
.bg-warning .card-body h4 {
    font-weight: 600;
}
</style>
@endpush