<?php

namespace Jiny\Site\Http\Controllers\Site\Faq;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 목록 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('/faq') → IndexController::__invoke()
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
            'category_table' => 'site_faq_cate',
            'view' => config('site.faq.view', 'jiny-site::www.faq.index'),
            'per_page' => config('site.faq.per_page', 20),
        ];
    }

    public function __invoke(Request $request)
    {
        // FAQ 카테고리 조회
        $categories = DB::table($this->config['category_table'])
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        // FAQ 목록 조회 (카테고리별로 그룹화)
        $query = DB::table($this->config['table'])
            ->leftJoin($this->config['category_table'], 'site_faq.category', '=', 'site_faq_cate.code')
            ->select(
                'site_faq.*',
                'site_faq_cate.title as category_title',
                'site_faq_cate.pos as category_pos'
            )
            ->where('site_faq.enable', true)
            ->whereNull('site_faq.deleted_at');

        // 카테고리 필터
        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('site_faq.category', $request->get('category'));
        }

        // 검색 기능
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_faq.question', 'like', "%{$search}%")
                  ->orWhere('site_faq.answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->orderBy('site_faq_cate.pos', 'asc')
            ->orderBy('site_faq.order', 'asc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        // 통계 정보
        $stats = [
            'total' => DB::table($this->config['table'])->where('enable', true)->whereNull('deleted_at')->count(),
            'categories' => $categories->count(),
        ];

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
            'popularFaqs' => $popularFaqs,
            'stats' => $stats,
            'config' => $this->config,
            'currentCategory' => $request->get('category'),
            'searchQuery' => $request->get('search'),
        ]);
    }
}
