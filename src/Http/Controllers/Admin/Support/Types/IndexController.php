<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupportType;

/**
 * 지원 요청 유형 목록 컨트롤러
 */
class IndexController extends Controller
{
    /**
     * 생성자
     */
    public function __construct()
    {
        // Middleware applied in routes
    }

    /**
     * 지원 요청 유형 목록 조회
     */
    public function __invoke(Request $request)
    {
        $query = SiteSupportType::with('defaultAssignee');

        // 상태 필터
        if ($request->has('status') && $request->status !== '') {
            $query->where('enable', $request->status === 'active');
        }

        // 우선순위 필터
        if ($request->has('priority') && $request->priority) {
            $query->where('default_priority', $request->priority);
        }

        // 검색
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');

        $allowedSorts = ['sort_order', 'name', 'code', 'created_at', 'total_requests', 'resolution_rate'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'resolution_rate') {
                // 해결률은 계산 필드이므로 직접 정렬
                $query->selectRaw('*, CASE WHEN total_requests > 0 THEN (resolved_requests / total_requests * 100) ELSE 0 END as resolution_rate')
                      ->orderBy('resolution_rate', $sortDirection);
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        } else {
            $query->ordered();
        }

        $types = $query->paginate(15);

        // 통계 정보
        $statistics = [
            'total' => SiteSupportType::count(),
            'active' => SiteSupportType::where('enable', true)->count(),
            'inactive' => SiteSupportType::where('enable', false)->count(),
        ];

        // 우선순위별 통계
        $priorityStats = SiteSupportType::selectRaw('default_priority, count(*) as count')
            ->groupBy('default_priority')
            ->pluck('count', 'default_priority')
            ->toArray();

        // 요청 상태별 통계
        $totalRequests = SiteSupportType::sum('total_requests');
        $pendingRequests = SiteSupportType::sum('pending_requests');
        $inProgressRequests = SiteSupportType::sum('in_progress_requests');
        $resolvedRequests = SiteSupportType::sum('resolved_requests');
        $closedRequests = SiteSupportType::sum('closed_requests');
        $avgResolutionTime = SiteSupportType::where('total_requests', '>', 0)->avg('avg_resolution_hours');

        return view('jiny-site::admin.support.types.index', [
            'types' => $types,
            'statistics' => $statistics,
            'priorityStats' => $priorityStats,
            'totalRequests' => $totalRequests,
            'pendingRequests' => $pendingRequests,
            'inProgressRequests' => $inProgressRequests,
            'resolvedRequests' => $resolvedRequests,
            'closedRequests' => $closedRequests,
            'avgResolutionTime' => $avgResolutionTime ?? 0,
            'currentStatus' => $request->status,
            'currentPriority' => $request->priority,
            'searchKeyword' => $request->search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }
}