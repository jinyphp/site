<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Location 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/about/location/') → IndexController::__invoke()
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
            'table' => 'site_location',
            'view' => 'jiny-site::admin.about.location.index',
            'title' => 'Location 관리',
            'subtitle' => '위치 정보를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $locations = $query->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();

        return view($this->config['view'], [
            'locations' => $locations,
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
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active') && $request->get('is_active') !== 'all') {
            $query->where('is_active', $request->get('is_active') === '1');
        }

        if ($request->filled('country')) {
            $query->where('country', $request->get('country'));
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'active' => DB::table($table)->where('is_active', true)->count(),
            'inactive' => DB::table($table)->where('is_active', false)->count(),
        ];
    }
}