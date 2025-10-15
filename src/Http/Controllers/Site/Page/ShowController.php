<?php

namespace Jiny\Site\Http\Controllers\Site\Page;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Services\PageService;

/**
 * 동적 페이지 표시 컨트롤러 (Fallback)
 *
 * 진입 경로:
 * Route::get('/{slug}') → ShowController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. loadPage() - 페이지 데이터 로드
 *     ├─ 3. resolveView() - 뷰 우선순위 확인
 *     └─ 4. renderView() - 뷰 렌더링
 */
class ShowController extends Controller
{
    protected $pageService;
    protected $config;

    /**
     * 생성자
     *
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->loadConfig();
    }

    /**
     * [초기화] config 값을 배열로 로드
     */
    protected function loadConfig()
    {
        $this->config = [
            'theme' => config('site.theme'),
            'enabled' => config('site.dynamic_pages.enabled', true),
        ];
    }

    /**
     * 동적 페이지 표시 (메인 진입점)
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $slug)
    {
        // 동적 페이지 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: 페이지 데이터 로드
        $page = $this->loadPage($slug);

        // 2단계: 뷰 해석
        $viewPath = $this->resolveView($slug);

        // 3단계: 뷰 렌더링
        return $this->renderView($viewPath, $page);
    }

    /**
     * [1단계] 페이지 데이터 로드
     *
     * @param string $slug
     * @return array|null
     */
    protected function loadPage($slug)
    {
        return $this->pageService->getPageBySlug($slug);
    }

    /**
     * [2단계] 뷰 해석 (우선순위)
     *
     * 우선순위:
     * 1. www::{slug}
     * 2. theme::{theme}.{slug}
     * 3. jiny-site::site.page.show
     *
     * @param string $slug
     * @return string
     */
    protected function resolveView($slug)
    {
        // 슬러그 정리 (슬래시를 점으로 변환)
        $viewSlug = str_replace('/', '.', $slug);

        // 우선순위 1: www 뷰
        $view = "www::" . $viewSlug;
        if (view()->exists($view)) {
            return $view;
        }

        // 우선순위 2: 테마 뷰
        if ($this->config['theme']) {
            $view = "theme::" . $this->config['theme'] . "." . $viewSlug;
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 우선순위 3: 패키지 기본 뷰
        return "jiny-site::site.page.show";
    }

    /**
     * [3단계] 뷰 렌더링
     *
     * @param string $viewPath
     * @param array|null $page
     * @return \Illuminate\View\View
     */
    protected function renderView($viewPath, $page)
    {
        // 페이지가 없으면 404
        if (!$page && !view()->exists($viewPath)) {
            abort(404);
        }

        return view($viewPath, [
            'page' => $page,
            'config' => $this->config,
        ]);
    }
}
