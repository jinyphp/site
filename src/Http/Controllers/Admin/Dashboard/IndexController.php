<?php

namespace Jiny\Site\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\DashboardService;

/**
 * 사이트 대시보드 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site') → IndexController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. loadStatistics() - 통계 데이터 로드
 *     └─ 3. renderView() - 뷰 렌더링
 */
class IndexController extends Controller
{
    protected $dashboardService;
    protected $config;

    /**
     * 생성자
     *
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'view' => config('site.admin.dashboard.view', 'jiny-site::admin.dashboard.index'),
        ];
    }

    /**
     * 대시보드 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 1단계: 통계 데이터 로드
        $statistics = $this->loadStatistics();

        // 2단계: 뷰 렌더링
        return $this->renderView($statistics);
    }

    /**
     * [1단계] 통계 데이터 로드
     *
     * @return array
     */
    protected function loadStatistics()
    {
        return [
            'total_visits' => $this->dashboardService->getTotalVisits(),
            'today_visits' => $this->dashboardService->getTodayVisits(),
            'total_pages' => $this->dashboardService->getTotalPages(),
            'total_menus' => $this->dashboardService->getTotalMenus(),
            'recent_logs' => $this->dashboardService->getRecentLogs(10),
        ];
    }

    /**
     * [2단계] 뷰 렌더링
     *
     * @param array $statistics
     * @return \Illuminate\View\View
     */
    protected function renderView($statistics)
    {
        return view($this->config['view'], [
            'statistics' => $statistics,
            'config' => $this->config,
        ]);
    }
}
