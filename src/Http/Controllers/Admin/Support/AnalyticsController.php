<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupport;
use Carbon\Carbon;

/**
 * 지원 요청 분석 및 통계 컨트롤러
 */
class AnalyticsController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 대시보드 통계 조회
     */
    public function dashboard(Request $request)
    {
        $period = $request->get('period', '30'); // 기본 30일
        $startDate = now()->subDays($period);

        // 기본 통계
        $basicStats = $this->getBasicStatistics();

        // 기간별 트렌드
        $trendData = $this->getTrendData($startDate);

        // 성능 지표
        $performanceMetrics = $this->getPerformanceMetrics($startDate);

        // 담당자별 통계
        $assigneeStats = $this->getAssigneeStatistics($startDate);

        // 유형별 통계
        $typeStats = $this->getTypeStatistics($startDate);

        // 우선순위별 통계
        $priorityStats = $this->getPriorityStatistics($startDate);

        // 시간별 분포
        $hourlyDistribution = $this->getHourlyDistribution($startDate);

        // 요일별 분포
        $weeklyDistribution = $this->getWeeklyDistribution($startDate);

        $data = [
            'basic_stats' => $basicStats,
            'trend_data' => $trendData,
            'performance_metrics' => $performanceMetrics,
            'assignee_stats' => $assigneeStats,
            'type_stats' => $typeStats,
            'priority_stats' => $priorityStats,
            'hourly_distribution' => $hourlyDistribution,
            'weekly_distribution' => $weeklyDistribution,
            'period_days' => $period,
            'generated_at' => now()->toISOString()
        ];

        // JSON 요청인 경우 JSON 응답
        if ($request->expectsJson() || $request->has('format') && $request->format === 'json') {
            return response()->json($data);
        }

        // 일반 요청인 경우 뷰 응답
        return view('jiny-site::admin.support.analytics.dashboard', $data);
    }

    /**
     * 기본 통계 조회
     */
    private function getBasicStatistics()
    {
        return [
            'total' => SiteSupport::count(),
            'pending' => SiteSupport::where('status', 'pending')->count(),
            'in_progress' => SiteSupport::where('status', 'in_progress')->count(),
            'resolved' => SiteSupport::where('status', 'resolved')->count(),
            'closed' => SiteSupport::where('status', 'closed')->count(),
            'today' => SiteSupport::whereDate('created_at', today())->count(),
            'this_week' => SiteSupport::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => SiteSupport::whereMonth('created_at', now()->month)->count(),
        ];
    }

    /**
     * 트렌드 데이터 조회
     */
    private function getTrendData($startDate)
    {
        $dailyStats = SiteSupport::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return $dailyStats->map(function ($stat) {
            return [
                'date' => $stat->date,
                'total' => $stat->total,
                'resolved' => $stat->resolved,
                'pending' => $stat->pending,
                'resolution_rate' => $stat->total > 0 ? round(($stat->resolved / $stat->total) * 100, 1) : 0
            ];
        });
    }

    /**
     * 성능 지표 조회
     */
    private function getPerformanceMetrics($startDate)
    {
        // 평균 응답 시간 (해결까지 소요 시간)
        $avgResolutionTime = SiteSupport::whereNotNull('resolved_at')
            ->where('created_at', '>=', $startDate)
            ->get()
            ->avg(function ($support) {
                return $support->created_at->diffInHours($support->resolved_at);
            });

        // 해결률
        $totalCount = SiteSupport::where('created_at', '>=', $startDate)->count();
        $resolvedCount = SiteSupport::where('status', 'resolved')
            ->where('created_at', '>=', $startDate)
            ->count();

        $resolutionRate = $totalCount > 0 ? round(($resolvedCount / $totalCount) * 100, 1) : 0;

        // 고객 만족도 (우선순위 기반 가중치)
        $satisfactionScore = $this->calculateSatisfactionScore($startDate);

        // 첫 응답 시간 (관리자 답변까지 시간)
        $avgFirstResponseTime = SiteSupport::whereNotNull('admin_reply')
            ->whereNotNull('responded_at')
            ->where('created_at', '>=', $startDate)
            ->get()
            ->avg(function ($support) {
                return $support->created_at->diffInHours($support->responded_at ?? $support->updated_at);
            });

        return [
            'avg_resolution_time_hours' => round($avgResolutionTime ?? 0, 1),
            'resolution_rate_percent' => $resolutionRate,
            'satisfaction_score' => $satisfactionScore,
            'avg_first_response_time_hours' => round($avgFirstResponseTime ?? 0, 1),
            'total_processed' => $totalCount,
            'total_resolved' => $resolvedCount
        ];
    }

    /**
     * 고객 만족도 점수 계산
     */
    private function calculateSatisfactionScore($startDate)
    {
        $supports = SiteSupport::where('status', 'resolved')
            ->where('created_at', '>=', $startDate)
            ->get();

        if ($supports->isEmpty()) {
            return 0;
        }

        $totalScore = 0;
        $count = 0;

        foreach ($supports as $support) {
            $score = 50; // 기본 점수

            // 응답 시간에 따른 점수 조정
            if ($support->resolved_at && $support->created_at) {
                $hoursToResolve = $support->created_at->diffInHours($support->resolved_at);

                if ($hoursToResolve <= 2) {
                    $score += 40; // 매우 빠름
                } elseif ($hoursToResolve <= 8) {
                    $score += 30; // 빠름
                } elseif ($hoursToResolve <= 24) {
                    $score += 15; // 보통
                } elseif ($hoursToResolve <= 72) {
                    $score += 5; // 느림
                }
                // 72시간 초과는 추가 점수 없음
            }

            // 우선순위에 따른 가중치
            $priorityWeight = match($support->priority) {
                'urgent' => 1.5,
                'high' => 1.2,
                'normal' => 1.0,
                'low' => 0.8,
                default => 1.0
            };

            $totalScore += $score * $priorityWeight;
            $count++;
        }

        return round($totalScore / $count, 1);
    }

    /**
     * 담당자별 통계 조회
     */
    private function getAssigneeStatistics($startDate)
    {
        return SiteSupport::select(
                'assigned_to',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress')
            )
            ->with('assignedTo:id,name')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->get()
            ->map(function ($stat) {
                return [
                    'assignee_id' => $stat->assigned_to,
                    'assignee_name' => $stat->assignedTo ? $stat->assignedTo->name : '알 수 없음',
                    'total' => $stat->total,
                    'resolved' => $stat->resolved,
                    'pending' => $stat->pending,
                    'in_progress' => $stat->in_progress,
                    'resolution_rate' => $stat->total > 0 ? round(($stat->resolved / $stat->total) * 100, 1) : 0
                ];
            });
    }

    /**
     * 유형별 통계 조회
     */
    private function getTypeStatistics($startDate)
    {
        return SiteSupport::select(
                'type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('type')
            ->get()
            ->map(function ($stat) {
                return [
                    'type' => $stat->type,
                    'type_label' => $this->getTypeLabel($stat->type),
                    'count' => $stat->count,
                    'resolved' => $stat->resolved,
                    'resolution_rate' => $stat->count > 0 ? round(($stat->resolved / $stat->count) * 100, 1) : 0
                ];
            });
    }

    /**
     * 우선순위별 통계 조회
     */
    private function getPriorityStatistics($startDate)
    {
        $databaseDriver = config('database.default');

        if ($databaseDriver === 'sqlite') {
            // SQLite용 쿼리
            return SiteSupport::select(
                    'priority',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('AVG(CASE WHEN resolved_at IS NOT NULL THEN (julianday(resolved_at) - julianday(created_at)) * 24 END) as avg_resolution_hours')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy('priority')
                ->get()
                ->map(function ($stat) {
                    return [
                        'priority' => $stat->priority,
                        'priority_label' => $this->getPriorityLabel($stat->priority),
                        'count' => $stat->count,
                        'avg_resolution_hours' => round($stat->avg_resolution_hours ?? 0, 1)
                    ];
                });
        } else {
            // MySQL용 쿼리
            return SiteSupport::select(
                    'priority',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('AVG(CASE WHEN resolved_at IS NOT NULL THEN TIMESTAMPDIFF(HOUR, created_at, resolved_at) END) as avg_resolution_hours')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy('priority')
                ->get()
                ->map(function ($stat) {
                    return [
                        'priority' => $stat->priority,
                        'priority_label' => $this->getPriorityLabel($stat->priority),
                        'count' => $stat->count,
                        'avg_resolution_hours' => round($stat->avg_resolution_hours ?? 0, 1)
                    ];
                });
        }
    }

    /**
     * 시간별 분포 조회
     */
    private function getHourlyDistribution($startDate)
    {
        $databaseDriver = config('database.default');

        if ($databaseDriver === 'sqlite') {
            // SQLite용 쿼리
            return SiteSupport::select(
                    DB::raw('CAST(strftime("%H", created_at) as INTEGER) as hour'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('strftime("%H", created_at)'))
                ->orderBy('hour')
                ->get()
                ->map(function ($stat) {
                    return [
                        'hour' => $stat->hour,
                        'count' => $stat->count
                    ];
                });
        } else {
            // MySQL용 쿼리
            return SiteSupport::select(
                    DB::raw('HOUR(created_at) as hour'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('HOUR(created_at)'))
                ->orderBy('hour')
                ->get()
                ->map(function ($stat) {
                    return [
                        'hour' => $stat->hour,
                        'count' => $stat->count
                    ];
                });
        }
    }

    /**
     * 요일별 분포 조회
     */
    private function getWeeklyDistribution($startDate)
    {
        $databaseDriver = config('database.default');

        if ($databaseDriver === 'sqlite') {
            // SQLite용 쿼리 (0=일요일, 1=월요일 ... 6=토요일)
            return SiteSupport::select(
                    DB::raw('CAST(strftime("%w", created_at) as INTEGER) as day_of_week'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('strftime("%w", created_at)'))
                ->orderBy('day_of_week')
                ->get()
                ->map(function ($stat) {
                    $dayNames = ['일', '월', '화', '수', '목', '금', '토'];
                    return [
                        'day_of_week' => $stat->day_of_week,
                        'day_name' => $dayNames[$stat->day_of_week] ?? '알 수 없음',
                        'count' => $stat->count
                    ];
                });
        } else {
            // MySQL용 쿼리 (1=일요일, 2=월요일 ... 7=토요일)
            return SiteSupport::select(
                    DB::raw('DAYOFWEEK(created_at) as day_of_week'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('DAYOFWEEK(created_at)'))
                ->orderBy('day_of_week')
                ->get()
                ->map(function ($stat) {
                    $dayNames = ['일', '월', '화', '수', '목', '금', '토'];
                    return [
                        'day_of_week' => $stat->day_of_week,
                        'day_name' => $dayNames[$stat->day_of_week - 1] ?? '알 수 없음',
                        'count' => $stat->count
                    ];
                });
        }
    }

    /**
     * 유형 라벨 반환
     */
    private function getTypeLabel($type)
    {
        $labels = [
            'technical' => '기술 지원',
            'billing' => '결제 문의',
            'general' => '일반 문의',
            'bug_report' => '버그 리포트',
        ];

        return $labels[$type] ?? $type;
    }

    /**
     * 우선순위 라벨 반환
     */
    private function getPriorityLabel($priority)
    {
        $labels = [
            'urgent' => '긴급',
            'high' => '높음',
            'normal' => '보통',
            'low' => '낮음',
        ];

        return $labels[$priority] ?? $priority;
    }
}