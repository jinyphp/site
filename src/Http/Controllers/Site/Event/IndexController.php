<?php

namespace Jiny\Site\Http\Controllers\Site\Event;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 사이트 이벤트 목록 컨트롤러
 *
 * 일반 사용자가 볼 수 있는 활성화된 이벤트 목록을 표시합니다.
 */
class IndexController extends Controller
{
    /**
     * 이벤트 목록 표시
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 활성화된 이벤트만 조회
        $query = SiteEvent::active()
            ->where('enable', true)
            ->ordered();

        // 검색 기능
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // 상태별 필터링
        if ($status = $request->get('status')) {
            $query->status($status);
        }

        // 페이지네이션
        $events = $query->paginate(12)->withQueryString();

        // 통계 데이터
        $stats = [
            'total' => SiteEvent::active()->where('enable', true)->count(),
            'active' => SiteEvent::active()->where('enable', true)->where('status', 'active')->count(),
            'planned' => SiteEvent::active()->where('enable', true)->where('status', 'planned')->count(),
            'completed' => SiteEvent::active()->where('enable', true)->where('status', 'completed')->count(),
        ];

        return view('jiny-site::site.event.index', [
            'events' => $events,
            'stats' => $stats,
            'currentStatus' => $status,
            'searchQuery' => $search,
        ]);
    }
}