<?php

namespace Jiny\Site\Http\Controllers\Admin\Help\Docs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Help 문서 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_guide',
            'view' => 'jiny-site::admin.helps.documents.index',
            'title' => '가이드 문서 관리',
            'subtitle' => '가이드 문서를 관리합니다.',
            'per_page' => 15,
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = DB::table($this->config['table'])
            ->leftJoin('site_guide_cate', function($join) {
                $join->on('site_guide.category', '=', 'site_guide_cate.code')
                     ->where('site_guide_cate.enable', '=', true);
            })
            ->select(
                'site_guide.id',
                'site_guide.title',
                'site_guide.content',
                'site_guide.category',
                'site_guide.enable',
                'site_guide.views',
                'site_guide.likes',
                'site_guide.order',
                'site_guide.created_at',
                'site_guide.updated_at',
                DB::raw('MAX(site_guide_cate.title) as category_title')
            )
            ->whereNull('site_guide.deleted_at')
            ->groupBy(
                'site_guide.id',
                'site_guide.title',
                'site_guide.content',
                'site_guide.category',
                'site_guide.enable',
                'site_guide.views',
                'site_guide.likes',
                'site_guide.order',
                'site_guide.created_at',
                'site_guide.updated_at'
            );

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_guide.title', 'like', "%{$search}%")
                  ->orWhere('site_guide.content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('site_guide.category', $request->get('category'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_guide.enable', $request->get('enable') === '1');
        }

        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('order', 'asc');

        $guides = $query->orderBy("site_guide.{$sortBy}", $sortOrder)
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = [
            'total' => DB::table($this->config['table'])->whereNull('deleted_at')->count(),
            'published' => DB::table($this->config['table'])->where('enable', true)->whereNull('deleted_at')->count(),
            'draft' => DB::table($this->config['table'])->where('enable', false)->whereNull('deleted_at')->count(),
            'total_views' => DB::table($this->config['table'])->whereNull('deleted_at')->sum('views'),
        ];

        $categories = DB::table('site_guide_cate')
            ->where('enable', true)
            ->orderBy('pos')
            ->get();

        return view($this->config['view'], [
            'guides' => $guides,
            'stats' => $stats,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }
}