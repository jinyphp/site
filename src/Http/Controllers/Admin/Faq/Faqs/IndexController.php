<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/faqs/') → IndexController::__invoke()
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
            'view' => 'jiny-site::admin.faq.faqs.index',
            'title' => 'FAQ 관리',
            'subtitle' => '자주 묻는 질문을 관리합니다.',
            'per_page' => 20,
            'sort' => [
                'column' => 'order',
                'order' => 'asc',
            ],
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $sortBy = $request->get('sort_by', $this->config['sort']['column']);
        $sortOrder = $request->get('order', $this->config['sort']['order']);

        // Map 'pos' to 'order' since that's the actual column name
        if ($sortBy === 'pos') {
            $sortBy = 'order';
        }

        $faqs = $query->orderBy("site_faq.{$sortBy}", $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $categories = $this->getCategories();

        return $this->renderView($faqs, $stats, $categories);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->select(
                'site_faq.*',
                DB::raw('(SELECT title FROM site_faq_cate WHERE code = site_faq.category AND enable = 1 LIMIT 1) as category_title')
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_faq.question', 'like', "%{$search}%")
                  ->orWhere('site_faq.answer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('site_faq.category', $request->get('category'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_faq.enable', $request->get('enable') === '1');
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'published' => DB::table($table)->where('enable', true)->count(),
            'draft' => DB::table($table)->where('enable', false)->count(),
            'total_likes' => DB::table($table)->sum('like') ?? 0,
            'total_views' => DB::table($table)->sum('views') ?? 0,
        ];
    }

    protected function getCategories()
    {
        return DB::table('site_faq_cate')
            ->where('enable', true)
            ->groupBy('code')
            ->orderBy('pos')
            ->get();
    }

    protected function renderView($faqs, $stats, $categories)
    {
        return view($this->config['view'], [
            'faqs' => $faqs,
            'stats' => $stats,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }
}