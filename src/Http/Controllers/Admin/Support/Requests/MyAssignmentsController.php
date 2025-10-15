<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;

/**
 * 내 할당 요청 목록 컨트롤러
 */
class MyAssignmentsController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = Auth::id();

        $query = SiteSupport::with(['user', 'assignedTo', 'latestAssignment'])
                            ->where('assigned_to', $userId);

        // 상태 필터
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // 유형 필터
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // 우선순위 필터
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // 날짜 범위 필터
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // 검색
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // 정렬
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $allowedSorts = ['created_at', 'updated_at', 'priority', 'status', 'subject'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'priority') {
                // 우선순위는 커스텀 정렬이 필요
                $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'normal', 'low') " . $sortDirection);
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 15);
        $supports = $query->paginate($perPage);

        // 내 할당 통계
        $myStatistics = [
            'total' => SiteSupport::where('assigned_to', $userId)->count(),
            'pending' => SiteSupport::where('assigned_to', $userId)->where('status', 'pending')->count(),
            'in_progress' => SiteSupport::where('assigned_to', $userId)->where('status', 'in_progress')->count(),
            'resolved' => SiteSupport::where('assigned_to', $userId)->where('status', 'resolved')->count(),
            'closed' => SiteSupport::where('assigned_to', $userId)->where('status', 'closed')->count(),
        ];

        // 오늘 할당된 요청 수
        $todayAssigned = SiteSupport::where('assigned_to', $userId)
                                   ->whereDate('created_at', today())
                                   ->count();

        // 이번 주 할당된 요청 수
        $weekAssigned = SiteSupport::where('assigned_to', $userId)
                                  ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                  ->count();

        // 평균 처리 시간 (내가 처리한 것들)
        $avgResponseTime = $this->getMyAverageResponseTime($userId);

        // 유형별 통계 (내 할당 요청)
        $myTypeStats = SiteSupport::where('assigned_to', $userId)
                                 ->select('type')
                                 ->selectRaw('COUNT(*) as count')
                                 ->groupBy('type')
                                 ->pluck('count', 'type')
                                 ->toArray();

        return view('jiny-site::admin.support.requests.my-assignments', [
            'supports' => $supports,
            'statistics' => $myStatistics,
            'currentStatus' => $request->status,
            'currentType' => $request->type,
            'currentPriority' => $request->priority,
            'currentDateFrom' => $request->date_from,
            'currentDateTo' => $request->date_to,
            'currentSearch' => $request->search,
            'searchKeyword' => $request->search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'todayAssigned' => $todayAssigned,
            'weekAssigned' => $weekAssigned,
            'avgResponseTime' => $avgResponseTime,
            'typeStats' => $myTypeStats,
        ]);
    }

    private function getMyAverageResponseTime($userId)
    {
        $driverName = \DB::connection()->getDriverName();

        if ($driverName === 'sqlite') {
            $avgTime = \DB::table('site_support')
                ->where('assigned_to', $userId)
                ->whereNotNull('admin_reply')
                ->where('admin_reply', '!=', '')
                ->selectRaw('AVG((julianday(updated_at) - julianday(created_at)) * 24) as avg_hours')
                ->value('avg_hours');
        } else {
            $avgTime = \DB::table('site_support')
                ->where('assigned_to', $userId)
                ->whereNotNull('admin_reply')
                ->where('admin_reply', '!=', '')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
                ->value('avg_hours');
        }

        return round($avgTime ?? 0, 1);
    }
}