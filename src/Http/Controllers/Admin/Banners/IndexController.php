<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use Jiny\Site\Models\Banner;
use Carbon\Carbon;

/**
 * 베너 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/banner') → IndexController::__invoke()
 */
class IndexController extends BaseController
{

    /**
     * 베너 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 통계 데이터 생성
        $stats = $this->generateStats();

        // 필터링된 베너 목록 조회
        $banners = $this->getFilteredBanners($request);

        $indexConfig = $this->getConfig('index', []);

        return view($indexConfig['view'] ?? 'jiny-site::admin.banners.index', [
            'banners' => $banners,
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
            'total' => Banner::count(),
            'active' => Banner::where('enable', true)->count(),
            'inactive' => Banner::where('enable', false)->count(),
            'expired' => Banner::where('end_date', '<', Carbon::now())->count(),
        ];
    }

    /**
     * 필터링된 베너 목록 조회
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function getFilteredBanners(Request $request)
    {
        $query = Banner::query();

        // 검색 필터
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // 활성화 상태 필터
        if ($request->has('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', $request->get('enable') == '1');
        }

        // 타입 필터
        if ($request->has('type') && $request->get('type') !== 'all') {
            $query->where('type', $request->get('type'));
        }

        // JSON 설정에서 기본 정렬 정보 가져오기
        $defaultSort = $this->getConfig('table.sort', ['column' => 'display_order', 'order' => 'asc']);
        $sortBy = $request->get('sort_by', $defaultSort['column']);
        $order = $request->get('order', $defaultSort['order']);

        if ($sortBy === 'display_order') {
            $query->orderBy('display_order', $order)->orderBy('id', 'desc');
        } else {
            $query->orderBy($sortBy, $order);
        }

        // JSON 설정에서 페이지당 항목 수 가져오기
        $perPage = $this->getConfig('index.pagination.per_page', 15);
        return $query->paginate($perPage);
    }
}
