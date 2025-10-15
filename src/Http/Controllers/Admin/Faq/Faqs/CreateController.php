<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 생성 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/faqs/create') → CreateController::__invoke()
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
            'view' => 'jiny-site::admin.faq.faqs.create',
            'title' => 'FAQ 생성',
            'subtitle' => '새로운 FAQ를 작성합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
        $categories = $this->getCategories();

        return view($this->config['view'], [
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }

    protected function getCategories()
    {
        return DB::table('site_faq_cate')
            ->where('enable', true)
            ->groupBy('code')
            ->orderBy('pos')
            ->get();
    }
}