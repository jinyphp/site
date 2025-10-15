<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 상세 조회 컨트롤러
 */
class ShowController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_inventory',
            'view' => 'jiny-site::ecommerce.inventory.show',
            'title' => 'Inventory 상세',
            'subtitle' => '재고 항목 상세 정보를 확인합니다.',
        ];
    }

    public function __invoke(Request $request, $id)
    {
        $inventory = DB::table($this->config['table'])
            ->leftJoin('site_products', 'site_inventory.product_id', '=', 'site_products.id')
            ->leftJoin('site_product_variants', 'site_inventory.variant_id', '=', 'site_product_variants.id')
            ->select(
                'site_inventory.*',
                'site_products.name as product_name',
                'site_products.sku as product_sku',
                'site_products.description as product_description',
                'site_product_variants.name as variant_name',
                'site_product_variants.sku as variant_sku'
            )
            ->where('site_inventory.id', $id)
            ->whereNull('site_inventory.deleted_at')
            ->first();

        if (!$inventory) {
            return redirect()
                ->route('admin.site.ecommerce.inventory.index')
                ->with('error', '해당 재고 항목을 찾을 수 없습니다.');
        }

        // 재고 이동 내역 조회
        $movements = DB::table('site_inventory_movements')
            ->where('inventory_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view($this->config['view'], [
            'inventory' => $inventory,
            'movements' => $movements,
            'config' => $this->config,
        ]);
    }
}