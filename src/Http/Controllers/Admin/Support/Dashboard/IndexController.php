<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupport;
use Carbon\Carbon;

/**
 * 지원 요청 대시보드 컨트롤러 (메인 페이지)
 */
class IndexController extends Controller
{
    /**
     * 대시보드 통계 조회
     */
    public function __invoke(Request $request)
    {
        $period = $request->get('period', '30'); // 기본 30일
        $startDate = now()->subDays($period);

        // 기본 통계
        $basicStats = $this->getBasicStats($startDate);

        // 성능 지표
        $performanceMetrics = $this->getPerformanceMetrics($startDate);

        // 트렌드 데이터
        $trendData = $this->getTrendData($period);

        // 우선순위별 통계
        $priorityStats = $this->getPriorityStats($startDate);

        // 유형별 통계
        $typeStats = $this->getTypeStats($startDate);

        // 시간별 분포
        $hourlyDistribution = $this->getHourlyDistribution($startDate);

        // 요일별 분포
        $weeklyDistribution = $this->getWeeklyDistribution($startDate);

        // 담당자별 통계
        $assigneeStats = $this->getAssigneeStats($startDate);

        // 할당 현황 통계
        $assignmentStats = $this->getAssignmentStats($startDate);

        // 자동 할당 통계
        $autoAssignmentStats = $this->getAutoAssignmentStats($startDate);

        // 최근 할당 이력
        $recentAssignments = $this->getRecentAssignments();

        $data = [
            'basic_stats' => $basicStats,
            'performance_metrics' => $performanceMetrics,
            'trend_data' => $trendData,
            'priority_stats' => $priorityStats,
            'type_stats' => $typeStats,
            'hourly_distribution' => $hourlyDistribution,
            'weekly_distribution' => $weeklyDistribution,
            'assignee_stats' => $assigneeStats,
            'assignment_stats' => $assignmentStats,
            'auto_assignment_stats' => $autoAssignmentStats,
            'recent_assignments' => $recentAssignments,
            'period_days' => $period,
            'generated_at' => now()
        ];

        // JSON 요청인 경우
        if ($request->expectsJson() || $request->has('format') && $request->format === 'json') {
            return response()->json($data);
        }

        // 일반 요청인 경우 뷰 응답
        return view('jiny-site::admin.support.analytics.dashboard', $data);
    }

    /**
     * 기본 통계 조회
     */
    private function getBasicStats($startDate)
    {
        return [
            'total' => SiteSupport::where('created_at', '>=', $startDate)->count(),
            'pending' => SiteSupport::where('created_at', '>=', $startDate)->where('status', 'pending')->count(),
            'in_progress' => SiteSupport::where('created_at', '>=', $startDate)->where('status', 'in_progress')->count(),
            'resolved' => SiteSupport::where('created_at', '>=', $startDate)->where('status', 'resolved')->count(),
            'today' => SiteSupport::whereDate('created_at', today())->count(),
            'this_week' => SiteSupport::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
    }

    /**
     * 성능 지표 조회
     */
    private function getPerformanceMetrics($startDate)
    {
        $driverName = DB::connection()->getDriverName();

        if ($driverName === 'sqlite') {
            // SQLite용 쿼리 - 해결 시간만 계산 (resolved_at 컬럼 사용)
            $avgResolutionTime = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->where('status', 'resolved')
                ->whereNotNull('resolved_at')
                ->selectRaw('AVG((julianday(resolved_at) - julianday(created_at)) * 24) as avg_hours')
                ->value('avg_hours');

            // 첫 응답 시간은 admin_reply가 있는 경우 updated_at을 기준으로 계산
            $avgFirstResponseTime = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->whereNotNull('admin_reply')
                ->where('admin_reply', '!=', '')
                ->selectRaw('AVG((julianday(updated_at) - julianday(created_at)) * 24) as avg_hours')
                ->value('avg_hours');
        } else {
            // MySQL용 쿼리
            $avgResolutionTime = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->where('status', 'resolved')
                ->whereNotNull('resolved_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
                ->value('avg_hours');

            $avgFirstResponseTime = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->whereNotNull('admin_reply')
                ->where('admin_reply', '!=', '')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
                ->value('avg_hours');
        }

        $totalRequests = SiteSupport::where('created_at', '>=', $startDate)->count();
        $resolvedRequests = SiteSupport::where('created_at', '>=', $startDate)->where('status', 'resolved')->count();
        $resolutionRate = $totalRequests > 0 ? round(($resolvedRequests / $totalRequests) * 100, 1) : 0;

        return [
            'avg_resolution_time_hours' => round($avgResolutionTime ?? 0, 1),
            'avg_first_response_time_hours' => round($avgFirstResponseTime ?? 0, 1),
            'resolution_rate_percent' => $resolutionRate,
            'satisfaction_score' => 4.2, // 추후 실제 만족도 조사 데이터 연동
        ];
    }

    /**
     * 트렌드 데이터 조회
     */
    private function getTrendData($period)
    {
        $days = min($period, 30); // 최대 30일
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $total = SiteSupport::whereDate('created_at', $date)->count();
            $resolved = SiteSupport::whereDate('created_at', $date)->where('status', 'resolved')->count();

            $data[] = [
                'date' => Carbon::parse($date)->format('m/d'),
                'total' => $total,
                'resolved' => $resolved,
            ];
        }

        return $data;
    }

    /**
     * 우선순위별 통계
     */
    private function getPriorityStats($startDate)
    {
        $priorities = ['urgent' => '긴급', 'high' => '높음', 'normal' => '보통', 'low' => '낮음'];
        $stats = [];

        foreach ($priorities as $priority => $label) {
            $count = SiteSupport::where('created_at', '>=', $startDate)
                ->where('priority', $priority)
                ->count();

            if ($count > 0) {
                $stats[] = [
                    'priority' => $priority,
                    'priority_label' => $label,
                    'count' => $count,
                ];
            }
        }

        return $stats;
    }

    /**
     * 유형별 통계
     */
    private function getTypeStats($startDate)
    {
        $types = [
            'technical' => '기술지원',
            'billing' => '결제문의',
            'general' => '일반문의',
            'bug_report' => '버그리포트',
            'account' => '계정지원'
        ];

        $stats = [];

        foreach ($types as $type => $label) {
            $count = SiteSupport::where('created_at', '>=', $startDate)
                ->where('type', $type)
                ->count();

            if ($count > 0) {
                $stats[] = [
                    'type' => $type,
                    'type_label' => $label,
                    'count' => $count,
                ];
            }
        }

        return $stats;
    }

    /**
     * 시간별 분포
     */
    private function getHourlyDistribution($startDate)
    {
        $driverName = DB::connection()->getDriverName();

        if ($driverName === 'sqlite') {
            return DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->selectRaw("CAST(strftime('%H', created_at) AS INTEGER) as hour, COUNT(*) as count")
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->map(function ($item) {
                    return [
                        'hour' => $item->hour,
                        'count' => $item->count,
                    ];
                })
                ->toArray();
        } else {
            return DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->orderBy('hour')
                ->get()
                ->map(function ($item) {
                    return [
                        'hour' => $item->hour,
                        'count' => $item->count,
                    ];
                })
                ->toArray();
        }
    }

    /**
     * 요일별 분포
     */
    private function getWeeklyDistribution($startDate)
    {
        $driverName = DB::connection()->getDriverName();
        $dayNames = ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'];

        if ($driverName === 'sqlite') {
            $results = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->selectRaw("CAST(strftime('%w', created_at) AS INTEGER) as day_of_week, COUNT(*) as count")
                ->groupBy('day_of_week')
                ->orderBy('day_of_week')
                ->get();
        } else {
            $results = DB::table('site_support')
                ->where('created_at', '>=', $startDate)
                ->selectRaw('DAYOFWEEK(created_at) - 1 as day_of_week, COUNT(*) as count')
                ->groupBy('day_of_week')
                ->orderBy('day_of_week')
                ->get();
        }

        return $results->map(function ($item) use ($dayNames) {
            return [
                'day_of_week' => $item->day_of_week,
                'day_name' => $dayNames[$item->day_of_week],
                'count' => $item->count,
            ];
        })->toArray();
    }

    /**
     * 담당자별 통계
     */
    private function getAssigneeStats($startDate)
    {
        return DB::table('site_support')
            ->leftJoin('users', 'site_support.assigned_to', '=', 'users.id')
            ->where('site_support.created_at', '>=', $startDate)
            ->selectRaw('
                COALESCE(users.name, "미배정") as assignee_name,
                COUNT(*) as total,
                SUM(CASE WHEN site_support.status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN site_support.status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN site_support.status = "resolved" THEN 1 ELSE 0 END) as resolved,
                ROUND(SUM(CASE WHEN site_support.status = "resolved" THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 1) as resolution_rate
            ')
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'assignee_name' => $item->assignee_name,
                    'total' => $item->total,
                    'pending' => $item->pending,
                    'in_progress' => $item->in_progress,
                    'resolved' => $item->resolved,
                    'resolution_rate' => $item->resolution_rate,
                ];
            })
            ->toArray();
    }

    /**
     * 할당 현황 통계
     */
    private function getAssignmentStats($startDate)
    {
        $totalRequests = SiteSupport::where('created_at', '>=', $startDate)->count();
        $assignedRequests = SiteSupport::where('created_at', '>=', $startDate)
                                      ->whereNotNull('assigned_to')
                                      ->count();
        $unassignedRequests = $totalRequests - $assignedRequests;

        return [
            'total_requests' => $totalRequests,
            'assigned_requests' => $assignedRequests,
            'unassigned_requests' => $unassignedRequests,
            'assignment_rate' => $totalRequests > 0 ? round(($assignedRequests / $totalRequests) * 100, 1) : 0,
            'unassigned_rate' => $totalRequests > 0 ? round(($unassignedRequests / $totalRequests) * 100, 1) : 0,
        ];
    }

    /**
     * 자동 할당 통계
     */
    private function getAutoAssignmentStats($startDate)
    {
        // 자동 할당된 요청 수 (note가 '자동 할당'인 경우)
        $autoAssignedCount = DB::table('site_support_assignments')
            ->where('created_at', '>=', $startDate)
            ->where('action', 'assign')
            ->where('note', '자동 할당')
            ->count();

        // 수동 할당된 요청 수
        $manualAssignedCount = DB::table('site_support_assignments')
            ->where('created_at', '>=', $startDate)
            ->where('action', 'assign')
            ->where(function($query) {
                $query->where('note', '!=', '자동 할당')
                      ->orWhereNull('note');
            })
            ->count();

        // 자가 할당된 요청 수
        $selfAssignedCount = DB::table('site_support_assignments')
            ->where('created_at', '>=', $startDate)
            ->where('action', 'self_assign')
            ->count();

        // 이전된 요청 수
        $transferredCount = DB::table('site_support_assignments')
            ->where('created_at', '>=', $startDate)
            ->where('action', 'transfer')
            ->count();

        $totalAssignments = $autoAssignedCount + $manualAssignedCount + $selfAssignedCount;

        return [
            'auto_assigned' => $autoAssignedCount,
            'manual_assigned' => $manualAssignedCount,
            'self_assigned' => $selfAssignedCount,
            'transferred' => $transferredCount,
            'total_assignments' => $totalAssignments,
            'auto_assignment_rate' => $totalAssignments > 0 ? round(($autoAssignedCount / $totalAssignments) * 100, 1) : 0,
        ];
    }

    /**
     * 최근 할당 이력
     */
    private function getRecentAssignments()
    {
        return DB::table('site_support_assignments')
            ->join('site_support', 'site_support_assignments.support_id', '=', 'site_support.id')
            ->join('users as assigned_user', 'site_support_assignments.assigned_to', '=', 'assigned_user.id')
            ->leftJoin('users as assigned_from_user', 'site_support_assignments.assigned_from', '=', 'assigned_from_user.id')
            ->select([
                'site_support_assignments.id',
                'site_support_assignments.action',
                'site_support_assignments.note',
                'site_support_assignments.created_at',
                'site_support.subject as support_subject',
                'site_support.type as support_type',
                'site_support.priority as support_priority',
                'assigned_user.name as assigned_to_name',
                'assigned_from_user.name as assigned_from_name'
            ])
            ->orderBy('site_support_assignments.created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'action' => $item->action,
                    'action_label' => $this->getActionLabel($item->action),
                    'note' => $item->note,
                    'created_at' => $item->created_at,
                    'support_subject' => $item->support_subject,
                    'support_type' => $item->support_type,
                    'support_priority' => $item->support_priority,
                    'assigned_to_name' => $item->assigned_to_name,
                    'assigned_from_name' => $item->assigned_from_name,
                ];
            })
            ->toArray();
    }

    /**
     * 액션 라벨 반환
     */
    private function getActionLabel($action)
    {
        $labels = [
            'assign' => '할당',
            'unassign' => '할당 해제',
            'transfer' => '이전',
            'self_assign' => '자가 할당',
        ];

        return $labels[$action] ?? $action;
    }
}