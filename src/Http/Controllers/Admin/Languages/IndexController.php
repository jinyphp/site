<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/languages') → IndexController::__invoke()
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
            'view' => config('site.admin.languages.view', 'jiny-site::admin.languages.index'),
            'per_page' => config('site.admin.languages.per_page', 15),
        ];
    }

    /**
     * 언어 목록 표시 (메인 진입점)
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $languages = SiteLanguage::orderBy('created_at', 'desc')
            ->paginate($this->config['per_page']);

        return view($this->config['view'], [
            'languages' => $languages,
            'config' => $this->config,
        ]);
    }
}
