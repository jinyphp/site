<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 수정 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/faqs/{id}/edit') → EditController::__invoke()
 */
class EditController extends Controller
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
            'view' => 'jiny-site::admin.faq.faqs.edit',
            'title' => 'FAQ 수정',
            'subtitle' => 'FAQ 정보를 수정합니다.',
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

        $categories = $this->getCategories();

        return view($this->config['view'], [
            'faq' => $faq,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }

    protected function getFaq($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->first();
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