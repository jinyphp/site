<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Categories 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_categories',
            'view' => 'jiny-site::ecommerce.products.categories.index',
            'title' => 'Product Categories 관리',
            'subtitle' => '상품 카테고리를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $categories = $query->orderBy('site_product_categories.pos', 'asc')
            ->orderBy('site_product_categories.created_at', 'desc')
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
        return DB::table($this->config['table'])
            ->leftJoin('site_product_categories as parent', 'site_product_categories.parent_id', '=', 'parent.id')
            ->select(
                'site_product_categories.*',
                'parent.title as parent_title'
            )
            ->whereNull('site_product_categories.deleted_at');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_product_categories.title', 'like', "%{$search}%")
                  ->orWhere('site_product_categories.code', 'like', "%{$search}%")
                  ->orWhere('site_product_categories.description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_product_categories.enable', $request->get('enable') === '1');
        }

        if ($request->filled('parent_id') && $request->get('parent_id') !== 'all') {
            if ($request->get('parent_id') === 'null') {
                $query->whereNull('site_product_categories.parent_id');
            } else {
                $query->where('site_product_categories.parent_id', $request->get('parent_id'));
            }
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->whereNull('deleted_at')->count(),
            'enabled' => DB::table($table)->where('enable', true)->whereNull('deleted_at')->count(),
            'disabled' => DB::table($table)->where('enable', false)->whereNull('deleted_at')->count(),
            'root_categories' => DB::table($table)->whereNull('parent_id')->whereNull('deleted_at')->count(),
        ];
    }
}