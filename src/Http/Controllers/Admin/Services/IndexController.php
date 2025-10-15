<?php

namespace Jiny\Site\Http\Controllers\Admin\Services;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Services 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/site/services/') → IndexController::__invoke()
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
            'table' => 'site_services',
            'view' => 'jiny-site::admin.services.index',
            'title' => 'Services 관리',
            'subtitle' => '서비스 정보를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $services = $query->orderBy('site_services.created_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $categories = $this->getCategories();

        return view($this->config['view'], [
            'services' => $services,
            'stats' => $stats,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_service_categories', 'site_services.category_id', '=', 'site_service_categories.id')
            ->select(
                'site_services.*',
                'site_service_categories.title as category_name'
            )
            ->whereNull('site_services.deleted_at');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_services.title', 'like', "%{$search}%")
                  ->orWhere('site_services.description', 'like', "%{$search}%")
                  ->orWhere('site_service_categories.title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('site_services.category_id', $request->get('category'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_services.enable', $request->get('enable') === '1');
        }

        if ($request->filled('featured') && $request->get('featured') !== 'all') {
            $query->where('site_services.featured', $request->get('featured') === '1');
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->whereNull('deleted_at')->count(),
            'published' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->count(),
            'draft' => DB::table($table)->where('enable', false)->whereNull('deleted_at')->count(),
            'featured' => DB::table($table)->where('featured', true)->whereNull('deleted_at')->count(),
        ];
    }

    protected function getCategories()
    {
        return DB::table('site_service_categories')
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();
    }
}