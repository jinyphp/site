<?php

namespace Jiny\Site\Http\Controllers\Site\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * About 페이지 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/about') → IndexController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. resolveView() - 뷰 우선순위 확인
 *     └─ 3. renderView() - 뷰 렌더링
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
            'enabled' => config('site.about.enabled', true),
        ];
    }

    /**
     * About 페이지 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // About 페이지 비활성화 확인
        if (!$this->config['enabled']) {
            abort(404);
        }

        // 1단계: 뷰 해석
        $viewPath = $this->resolveView();

        // 2단계: 뷰 렌더링
        return $this->renderView($viewPath);
    }

    /**
     * [1단계] 뷰 해석 (우선순위)
     *
     * 우선순위:
     * 1. www::about.index
     * 2. theme::{theme}.about.index
     * 3. jiny-site::site.about.index
     *
     * @return string
     */
    protected function resolveView()
    {
        // 우선순위 1: www 뷰
        $view = "www::about.index";
        if (view()->exists($view)) {
            return $view;
        }

        // 우선순위 2: 테마 뷰
        if ($this->config['theme']) {
            $view = "theme::" . $this->config['theme'] . ".about.index";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 우선순위 3: 패키지 기본 뷰
        return "jiny-site::site.about.index";
    }

    /**
     * [2단계] 뷰 렌더링
     *
     * @param string $viewPath
     * @return \Illuminate\View\View
     */
    protected function renderView($viewPath)
    {
        return view($viewPath, [
            'config' => $this->config,
        ]);
    }
}
