<?php

namespace Jiny\Site\Http\Controllers\Site\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * About Location 페이지 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/about/location') → IndexController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. getLocations() - 활성화된 위치 정보 조회
 *     ├─ 3. resolveView() - 뷰 우선순위 확인
 *     └─ 4. renderView() - 뷰 렌더링
 */
class IndexController extends Controller
{
    protected $config;

    /**
     * 생성자
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'theme' => config('site.theme'),
            'enabled' => config('site.about.location.enabled', true),
            'title' => config('site.about.location.title', 'Our Locations'),
            'subtitle' => config('site.about.location.subtitle', 'Find us at these locations'),
        ];
    }

    /**
     * About Location 페이지 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // Location 페이지 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: 위치 정보 조회
        $locations = $this->getLocations();

        // 2단계: 뷰 해석
        $viewPath = $this->resolveView();

        // 3단계: 뷰 렌더링
        return $this->renderView($viewPath, $locations);
    }

    /**
     * [1단계] 활성화된 위치 정보 조회
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getLocations()
    {
        return DB::table('site_location')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * [2단계] 뷰 해석 (우선순위)
     *
     * 우선순위:
     * 1. www::about.location.index
     * 2. theme::{theme}.about.location.index
     * 3. jiny-site::www.about.location.index
     *
     * @return string
     */
    protected function resolveView()
    {
        // 우선순위 1: www 뷰
        $view = "www::about.location.index";
        if (view()->exists($view)) {
            return $view;
        }

        // 우선순위 2: 테마 뷰
        if ($this->config['theme']) {
            $view = "theme::" . $this->config['theme'] . ".about.location.index";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 우선순위 3: 패키지 기본 뷰
        return "jiny-site::www.about.location.index";
    }

    /**
     * [3단계] 뷰 렌더링
     *
     * @param string $viewPath
     * @param \Illuminate\Support\Collection $locations
     * @return \Illuminate\View\View
     */
    protected function renderView($viewPath, $locations)
    {
        return view($viewPath, [
            'config' => $this->config,
            'locations' => $locations,
        ]);
    }
}