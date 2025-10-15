<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 상세 조회 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/faqs/{id}') → ShowController::__invoke()
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_faq',
            'view' => 'jiny-site::admin.faq.faqs.show',
            'title' => 'FAQ 상세',
            'subtitle' => 'FAQ 상세 정보를 확인합니다.',
            'redirect_route' => 'admin.cms.faq.faqs.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $faq = $this->getFaq($id);

        if (!$faq) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', 'FAQ를 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'faq' => $faq,
            'config' => $this->config,
        ]);
    }

    protected function getFaq($id)
    {
        return DB::table($this->config['table'])
            ->select(
                'site_faq.*',
                DB::raw('(SELECT title FROM site_faq_cate WHERE code = site_faq.category AND enable = 1 LIMIT 1) as category_title')
            )
            ->where('site_faq.id', $id)
            ->first();
    }
}