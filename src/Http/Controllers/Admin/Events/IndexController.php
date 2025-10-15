<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/event') → IndexController::__invoke()
 */
class IndexController extends BaseController
{
    /**
     * 이벤트 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 통계 데이터 생성
        $stats = $this->generateStats();

        // 필터링된 이벤트 목록 조회
        $events = $this->getFilteredEvents($request);

        $indexConfig = $this->getConfig('index', []);

        return view($indexConfig['view'] ?? 'jiny-site::admin.events.index', [
            'events' => $events,
            'config' => $indexConfig,
            'stats' => $stats,
        ]);
    }

    /**
     * 통계 데이터 생성
     *
     * @return array
     */
    protected function generateStats()
    {
        return [
            'total' => SiteEvent::count(),
            'active' => SiteEvent::where('enable', true)->count(),
            'inactive' => SiteEvent::where('enable', false)->count(),
            'status_active' => SiteEvent::where('status', 'active')->count(),
            'status_planned' => SiteEvent::where('status', 'planned')->count(),
            'status_completed' => SiteEvent::where('status', 'completed')->count(),
        ];
    }

    /**
     * 필터링된 이벤트 목록 조회
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredEvents(Request $request)
    {
        $query = SiteEvent::query();

        // 검색 필터
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // 활성화 상태 필터
        if ($request->filled('enable')) {
            $query->where('enable', $request->boolean('enable'));
        }

        // 상태 필터
        if ($status = $request->get('status')) {
            $query->status($status);
        }

        // 정렬 적용
        $sortConfig = $this->getSortConfig();
        $query->orderBy($sortConfig['column'], $sortConfig['order']);

        // 페이지네이션 적용
        $perPage = $this->getConfig('index.pagination.per_page', 15);

        return $query->paginate($perPage)->withQueryString();
    }
}