<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 관리 메인 컨트롤러
 */
class IndexController extends Controller
{
    public function __construct()
    {
        // Middleware applied in routes
    }

    public function __invoke(Request $request)
    {
        $query = SiteSupport::with(['user', 'assignedTo']);

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

        // 담당자 필터
        if ($request->has('assigned_to') && $request->assigned_to) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
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

        // 통계
        $statistics = [
            'total' => SiteSupport::count(),
            'pending' => SiteSupport::where('status', 'pending')->count(),
            'in_progress' => SiteSupport::where('status', 'in_progress')->count(),
            'resolved' => SiteSupport::where('status', 'resolved')->count(),
            'closed' => SiteSupport::where('status', 'closed')->count(),
        ];

        // 추가 통계
        $todayCount = SiteSupport::whereDate('created_at', today())->count();
        $weekCount = SiteSupport::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $avgResponseTime = $this->getAverageResponseTime();

        // 담당자 목록
        $assignees = DB::table('users')
            ->where('isAdmin', true)
            ->select('id', 'name', 'email')
            ->get();

        // 유형별 통계
        $typeStats = SiteSupport::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        return view('jiny-site::admin.support.requests.index', [
            'supports' => $supports,
            'statistics' => $statistics,
            'currentStatus' => $request->status,
            'currentType' => $request->type,
            'currentPriority' => $request->priority,
            'currentAssignee' => $request->assigned_to,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
            'searchKeyword' => $request->search,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
            'assignees' => $assignees,
            'todayCount' => $todayCount,
            'weekCount' => $weekCount,
            'avgResponseTime' => $avgResponseTime,
            'typeStats' => $typeStats,
        ]);
    }

    /**
     * 평균 응답 시간 계산
     */
    private function getAverageResponseTime()
    {
        $resolved = SiteSupport::whereNotNull('resolved_at')
            ->whereNotNull('created_at')
            ->get();

        if ($resolved->isEmpty()) {
            return 0;
        }

        $totalHours = $resolved->sum(function ($support) {
            return $support->created_at->diffInHours($support->resolved_at);
        });

        return round($totalHours / $resolved->count(), 1);
    }
}