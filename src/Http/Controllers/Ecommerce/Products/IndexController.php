<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Products 목록 컨트롤러
 *
 * 진입 경로:
 * Route::get('/admin/site/products/') → IndexController::__invoke()
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
            'table' => 'site_products',
            'view' => 'jiny-site::ecommerce.products.index',
            'title' => 'Products 관리',
            'subtitle' => '상품 정보를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $products = $query->orderBy('site_products.created_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();
        $categories = $this->getCategories();

        return view($this->config['view'], [
            'products' => $products,
            'stats' => $stats,
            'categories' => $categories,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('site_product_categories', 'site_products.category_id', '=', 'site_product_categories.id')
            ->leftJoin(
                DB::raw('(SELECT product_id, COUNT(*) as pricing_count FROM site_product_pricing WHERE enable = 1 AND deleted_at IS NULL GROUP BY product_id) as pricing_stats'),
                'site_products.id', '=', 'pricing_stats.product_id'
            )
            ->select(
                'site_products.id',
                'site_products.slug',
                'site_products.title',
                'site_products.description',
                'site_products.price',
                'site_products.sale_price',
                'site_products.image',
                'site_products.enable',
                'site_products.featured',
                'site_products.view_count',
                'site_products.created_at',
                'site_products.updated_at',
                'site_product_categories.title as category_name',
                'site_product_categories.slug as category_slug',
                DB::raw('COALESCE(pricing_stats.pricing_count, 0) as pricing_options_count')
            )
            ->whereNull('site_products.deleted_at');
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('site_products.title', 'like', "%{$search}%")
                  ->orWhere('site_products.description', 'like', "%{$search}%")
                  ->orWhere('site_product_categories.title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('site_products.category_id', $request->get('category'));
        }

        if ($request->filled('enable') && $request->get('enable') !== 'all') {
            $query->where('site_products.enable', $request->get('enable') === '1');
        }

        if ($request->filled('featured') && $request->get('featured') !== 'all') {
            $query->where('site_products.featured', $request->get('featured') === '1');
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
            'popular' => DB::table($table)->where('view_count', '>', 100)->whereNull('deleted_at')->count(),
            'total_views' => DB::table($table)->whereNull('deleted_at')->sum('view_count'),
        ];
    }

    protected function getCategories()
    {
        return DB::table('site_product_categories')
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('pos')
            ->orderBy('title')
            ->get();
    }
}