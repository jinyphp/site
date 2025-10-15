<?php

namespace Jiny\Site\Http\Controllers\Site\Faq;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 카테고리별 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/faq/category/{code}') → CategoryController::__invoke()
 */
class CategoryController extends Controller
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
            'view' => config('site.faq.category_view', 'jiny-site::www.faq.category'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request, $code)
    {
        $category = $this->getCategory($code);

        if (!$category) {
            abort(404, 'FAQ 카테고리를 찾을 수 없습니다.');
        }

        $faqs = $this->getFaqsByCategory($code);
        $categories = $this->getAllCategories();

        return view($this->config['view'], [
            'category' => $category,
            'categories' => $categories,
            'faqs' => $faqs,
            'config' => $this->config,
        ]);
    }

    protected function getCategory($code)
    {
        return DB::table('site_faq_cate')
            ->where('code', $code)
            ->where('enable', true)
            ->first();
    }

    protected function getFaqsByCategory($code)
    {
        return DB::table($this->config['table'])
            ->where('cate', $code)
            ->where('enable', true)
            ->orderBy('pos')
            ->paginate($this->config['per_page']);
    }

    protected function getAllCategories()
    {
        return DB::table('site_faq_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();
    }
}