<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;
use Illuminate\Support\Facades\DB;

/**
 * 지원 요청 유형 상세 조회 컨트롤러
 */
class ShowController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 지원 요청 유형 상세 조회
     */
    public function __invoke(Request $request, $id)
    {
        $supportType = SiteSupportType::with(['defaultAssignee', 'supportRequests'])
            ->findOrFail($id);

        // 통계 정보 계산
        $statistics = [
            'total_requests' => $supportType->supportRequests()->count(),
            'pending_requests' => $supportType->supportRequests()->where('status', 'pending')->count(),
            'in_progress_requests' => $supportType->supportRequests()->where('status', 'in_progress')->count(),
            'resolved_requests' => $supportType->supportRequests()->where('status', 'resolved')->count(),
            'closed_requests' => $supportType->supportRequests()->where('status', 'closed')->count(),
        ];

        // 해결률 계산
        $resolutionRate = $statistics['total_requests'] > 0
            ? round(($statistics['resolved_requests'] / $statistics['total_requests']) * 100, 2)
            : 0;

        // 평균 해결 시간 계산
        $avgResolutionTime = $supportType->supportRequests()
            ->where('status', 'resolved')
            ->whereNotNull('resolved_at')
            ->whereNotNull('created_at')
            ->get()
            ->avg(function ($support) {
                return $support->created_at->diffInHours($support->resolved_at);
            });

        // 월별 요청 트렌드 (최근 12개월)
        $monthlyTrend = DB::table('site_support')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('type', $supportType->code)
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get();

        // 최근 요청 목록 (5개)
        $recentRequests = $supportType->supportRequests()
            ->with(['user', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 우선순위별 분포
        $priorityDistribution = $supportType->supportRequests()
            ->select('priority', DB::raw('COUNT(*) as count'))
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        return view('jiny-site::admin.support.types.show', [
            'supportType' => $supportType,
            'statistics' => $statistics,
            'resolutionRate' => $resolutionRate,
            'avgResolutionTime' => round($avgResolutionTime ?? 0, 1),
            'monthlyTrend' => $monthlyTrend,
            'recentRequests' => $recentRequests,
            'priorityDistribution' => $priorityDistribution,
        ]);
    }
}