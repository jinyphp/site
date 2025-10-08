<?php

namespace Jiny\Site\Http\Controllers\Admin\PageDesign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 페이지 디자인 모드 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/pages/design') → IndexController::__invoke()
 *     ├─ 1. loadConfig() - 설정값 로드
 *     ├─ 2. loadPages() - 페이지 데이터 로드
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
            'view' => config('site.admin.page_design.view', 'jiny-site::admin.page-design.index'),
            'upload_path' => 'pages',
        ];
    }

    /**
     * 페이지 디자인 모드 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        // 1단계: 페이지 데이터 로드
        $pages = $this->loadPages();

        // 2단계: 뷰 렌더링
        return $this->renderView($pages);
    }

    /**
     * [1단계] 페이지 데이터 로드
     *
     * @return array
     */
    protected function loadPages()
    {
        // 페이지 위젯 데이터 로드 로직
        // 추후 필요시 구현
        return [];
    }

    /**
     * [2단계] 뷰 렌더링
     *
     * @param array $pages
     * @return \Illuminate\View\View
     */
    protected function renderView($pages)
    {
        return view($this->config['view'], [
            'pages' => $pages,
            'config' => $this->config,
        ]);
    }
}
