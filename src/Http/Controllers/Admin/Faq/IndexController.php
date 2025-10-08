<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'view' => 'jiny-site::admin.faq.index',
            'title' => 'FAQ 관리',
            'subtitle' => '자주 묻는 질문을 관리합니다.',
            'per_page' => 15,
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

        $faqs = $query->orderBy($sortBy, $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $categories = $this->getCategories();

        return $this->renderView($faqs, $stats, $categories);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->where('enable', true)
            ->whereNull('deleted_at');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('category', $request->get('category'));
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->count(),
            'categories' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->distinct('category')->count('category'),
            'total_views' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->sum('views'),
        ];
    }

    protected function getCategories()
    {
        return DB::table($this->config['table'])
            ->select('category')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');
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
