<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_inventory',
            'view' => 'jiny-site::ecommerce.inventory.edit',
            'title' => 'Inventory 수정',
            'subtitle' => '재고 항목을 수정합니다.',
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

        // 상품 목록 조회
        $products = DB::table('site_products')
            ->whereNull('deleted_at')
            ->where('enable', true)
            ->orderBy('name')
            ->get();

        // 상품 변형 목록 조회
        $variants = DB::table('site_product_variants')
            ->leftJoin('site_products', 'site_product_variants.product_id', '=', 'site_products.id')
            ->select(
                'site_product_variants.*',
                'site_products.name as product_name'
            )
            ->whereNull('site_product_variants.deleted_at')
            ->where('site_product_variants.enable', true)
            ->orderBy('site_products.name')
            ->orderBy('site_product_variants.name')
            ->get();

        // 기존 재고 위치 목록
        $locations = DB::table($this->config['table'])
            ->select('location')
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->whereNull('deleted_at')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return view($this->config['view'], [
            'inventory' => $inventory,
            'products' => $products,
            'variants' => $variants,
            'locations' => $locations,
            'config' => $this->config,
        ]);
    }
}