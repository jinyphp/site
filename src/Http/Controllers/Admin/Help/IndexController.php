<?php

namespace Jiny\Site\Http\Controllers\Admin\Help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_help',
            'view' => 'jiny-site::admin.help.index',
            'title' => 'Help 관리',
            'subtitle' => '도움말 문서를 관리합니다.',
            'per_page' => 15,
            'sort' => ['column' => 'order', 'order' => 'asc'],
        ];
    }

    public function __invoke(Request $request)
    {
        $query = DB::table($this->config['table'])
            ->where('enable', true)
            ->whereNull('deleted_at');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('category', $request->get('category'));
        }

        $sortBy = $request->get('sort_by', $this->config['sort']['column']);
        $sortOrder = $request->get('order', $this->config['sort']['order']);

        $helps = $query->orderBy($sortBy, $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = [
            'total' => DB::table($this->config['table'])->where('enable', true)->whereNull('deleted_at')->count(),
            'categories' => DB::table($this->config['table'])->where('enable', true)->whereNull('deleted_at')->distinct('category')->count('category'),
            'total_views' => DB::table($this->config['table'])->where('enable', true)->whereNull('deleted_at')->sum('views'),
        ];

        $categories = DB::table($this->config['table'])
            ->select('category')
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view($this->config['view'], [
            'helps' => $helps,
            'stats' => $stats,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }
}
