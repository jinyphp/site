<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'inventory',
            'view' => 'jiny-site::ecommerce.inventory.index',
            'title' => 'Inventory 관리',
            'subtitle' => '상품 재고를 관리합니다.',
            'per_page' => 15,
        ];
    }

    public function __invoke(Request $request)
    {
        $query = $this->buildQuery();
        $query = $this->applyFilters($query, $request);

        $inventories = $query->orderBy('site_inventory.updated_at', 'desc')
            ->paginate($this->config['per_page'])
            ->withQueryString();

        $stats = $this->getStatistics();

        return view($this->config['view'], [
            'inventories' => $inventories,
            'stats' => $stats,
            'config' => $this->config,
        ]);
    }

    protected function buildQuery()
    {
        return DB::table($this->config['table'])
            ->leftJoin('products', 'inventory.product_id', '=', 'products.id')
            ->select(
                'inventory.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'inventory.quantity_on_hand as quantity',
                'inventory.reorder_point as low_stock_threshold'
            );
    }

    protected function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.sku', 'like', "%{$search}%")
                  ->orWhere('inventory.location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('stock_status') && $request->get('stock_status') !== 'all') {
            $status = $request->get('stock_status');
            if ($status === 'low_stock') {
                $query->whereRaw('inventory.quantity_on_hand <= inventory.reorder_point');
            } elseif ($status === 'out_of_stock') {
                $query->where('inventory.quantity_on_hand', '<=', 0);
            } elseif ($status === 'in_stock') {
                $query->where('inventory.quantity_on_hand', '>', 0);
            }
        }

        if ($request->filled('location') && $request->get('location') !== 'all') {
            $query->where('inventory.location', $request->get('location'));
        }

        return $query;
    }

    protected function getStatistics()
    {
        $table = $this->config['table'];

        return [
            'total' => DB::table($table)->count(),
            'in_stock' => DB::table($table)->where('quantity_on_hand', '>', 0)->count(),
            'out_of_stock' => DB::table($table)->where('quantity_on_hand', '<=', 0)->count(),
            'low_stock' => DB::table($table)->whereRaw('quantity_on_hand <= reorder_point')->count(),
            'total_value' => DB::table($table)
                ->selectRaw('SUM(quantity_on_hand * COALESCE(last_cost, 0)) as total')
                ->value('total') ?? 0,
        ];
    }
}