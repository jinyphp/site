<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Faq;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 목록 표시 컨트롤러 (Help 섹션 내)
 *
 * 진입 경로:
 * Route::get('/help/faq') → IndexController::__invoke()
 */
class IndexController extends Controller
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
            'view' => config('site.help.faq_view', 'jiny-site::www.help.faq.index'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        $category = $request->input('category', '');

        // FAQ 카테고리 목록
        $categories = DB::table('site_faq_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        // FAQ 목록 조회
        $faqQuery = DB::table($this->config['table'])
            ->where('enable', true)
            ->whereNull('deleted_at');

        if (!empty($category)) {
            $faqQuery->where('category', $category);
        }

        $faqs = $faqQuery
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate($this->config['per_page']);

        // 선택된 카테고리 정보
        $selectedCategory = null;
        if (!empty($category)) {
            $selectedCategory = DB::table('site_faq_cate')
                ->where('code', $category)
                ->where('enable', true)
                ->first();
        }

        // 인기 FAQ (조회수 기준)
        $popularFaqs = DB::table($this->config['table'])
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view($this->config['view'], [
            'categories' => $categories,
            'faqs' => $faqs,
            'selectedCategory' => $selectedCategory,
            'popularFaqs' => $popularFaqs,
            'config' => $this->config,
        ]);
    }
}