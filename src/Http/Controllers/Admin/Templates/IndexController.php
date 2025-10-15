<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 사이트 템플릿 관리 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/templates') → IndexController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     └─ 2. renderView() - 뷰 렌더링
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
            'view' => config('site.admin.templates.view', 'jiny-site::admin.templates.index'),
            'title' => 'Site Template',
            'subtitle' => '사이트 요소구성을 위한 템플릿을 관리합니다.',
        ];
    }

    /**
     * 템플릿 관리 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        return $this->renderView();
    }

    /**
     * 뷰 렌더링
     *
     * @return \Illuminate\View\View
     */
    protected function renderView()
    {
        return view($this->config['view'], [
            'config' => $this->config,
        ]);
    }
}
