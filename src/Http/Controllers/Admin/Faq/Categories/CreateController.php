<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * FAQ 카테고리 생성 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/categories/create') → CreateController::__invoke()
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'view' => 'jiny-site::admin.faq.categories.create',
            'title' => 'FAQ 카테고리 생성',
            'subtitle' => '새로운 FAQ 카테고리를 작성합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        return view($this->config['view'], [
            'config' => $this->config,
        ]);
    }
}