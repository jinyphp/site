<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact;

use Illuminate\Routing\Controller;
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
            'table' => 'site_contact',
            'view' => 'jiny-site::admin.contact.index',
            'title' => 'Contact 문의 관리',
            'subtitle' => '고객 문의 내역을 확인하고 처리합니다.',
            'per_page' => 15,
            'sort' => [
                'column' => 'created_at',
                'order' => 'desc',
            ],
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $sortBy = $request->get('sort_by', $this->config['sort']['column']);
        $sortOrder = $request->get('order', $this->config['sort']['order']);

        $contacts = $query->orderBy($sortBy, $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();

        return $this->renderView($contacts, $stats);
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
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->get('status') !== 'all') {
            $query->where('status', $request->get('status'));
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->count(),
            'pending' => DB::table($table)->where('status', 'pending')->where('enable', true)->whereNull('deleted_at')->count(),
            'processing' => DB::table($table)->where('status', 'processing')->where('enable', true)->whereNull('deleted_at')->count(),
            'completed' => DB::table($table)->where('status', 'completed')->where('enable', true)->whereNull('deleted_at')->count(),
            'today' => DB::table($table)->whereDate('created_at', today())->where('enable', true)->whereNull('deleted_at')->count(),
        ];
    }

    protected function renderView($contacts, $stats)
    {
        return view($this->config['view'], [
            'contacts' => $contacts,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }
}
