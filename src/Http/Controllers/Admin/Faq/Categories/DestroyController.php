<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 카테고리 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('/admin/cms/faq/categories/{id}') → DestroyController::__invoke()
 */
class DestroyController extends Controller
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
            'redirect_route' => 'admin.cms.faq.categories.index',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        // 해당 카테고리를 사용하는 FAQ가 있는지 확인
        $faqCount = $this->getFaqCount($id);

        if ($faqCount > 0) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '이 카테고리를 사용하는 FAQ가 있어 삭제할 수 없습니다.');
        }

        $deleted = $this->deleteCategory($id);

        if (!$deleted) {
            return redirect()->route($this->config['redirect_route'])
                ->with('error', '카테고리를 찾을 수 없습니다.');
        }

        return redirect()->route($this->config['redirect_route'])
            ->with('success', 'FAQ 카테고리가 성공적으로 삭제되었습니다.');
    }

    protected function getFaqCount($id)
    {
        return DB::table('site_faq')
            ->where('cate', function($query) use ($id) {
                $query->select('code')
                    ->from('site_faq_cate')
                    ->where('id', $id);
            })
            ->count();
    }

    protected function deleteCategory($id)
    {
        return DB::table($this->config['table'])
            ->where('id', $id)
            ->delete();
    }
}