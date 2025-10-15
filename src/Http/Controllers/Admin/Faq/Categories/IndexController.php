<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 카테고리 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/faq/categories/') → IndexController::__invoke()
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
            'table' => 'site_faq_cate',
            'view' => 'jiny-site::admin.faq.categories.index',
            'title' => 'FAQ 카테고리 관리',
            'subtitle' => 'FAQ 카테고리를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $categories = $query->orderBy('pos', 'asc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();

        return view($this->config['view'], [
            'categories' => $categories,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table']);
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('enable', $request->get('enable') === '1');
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'enabled' => DB::table($table)->where('enable', true)->count(),
            'disabled' => DB::table($table)->where('enable', false)->count(),
        ];
    }
}