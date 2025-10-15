<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\Types;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contact 타입 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/cms/contact/types/') → IndexController::__invoke()
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
            'table' => 'site_contact_type',
            'view' => 'jiny-site::admin.contact.types.index',
            'title' => 'Contact 타입 관리',
            'subtitle' => '문의 타입을 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $types = $query->orderBy('pos', 'asc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();

        return view($this->config['view'], [
            'types' => $types,
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