<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 카테고리 수정 폼 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/categories/{id}/edit') → EditController::__invoke()
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
            'table' => 'site_faq_cate',
            'view' => 'jiny-site::admin.faq.categories.edit',
            'title' => 'FAQ 카테고리 수정',
            'subtitle' => 'FAQ 카테고리 정보를 수정합니다.',
            'redirect_route' => 'admin.cms.faq.categories.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $category = $this->getCategory($id);

        if (!$category) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '카테고리를 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'category' => $category,
            'config' => $this->config,
        ]);
    }

    protected function getCategory($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->first();
    }
}