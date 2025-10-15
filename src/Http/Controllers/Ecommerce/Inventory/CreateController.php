<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Inventory;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inventory 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_inventory',
            'view' => 'jiny-site::ecommerce.inventory.create',
            'title' => 'Inventory 추가',
            'subtitle' => '새로운 재고 항목을 추가합니다.',
        ];
    }

    public function __invoke(Request $request)
    {
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
            'config' => $this->config,
            'products' => $products,
            'variants' => $variants,
            'locations' => $locations,
        ]);
    }
}