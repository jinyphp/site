<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 목록 컨트롤러
 */
class IndexController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_pricing',
            'view' => 'jiny-site::ecommerce.products.pricing.index',
            'title' => 'Product Pricing 관리',
            'subtitle' => '상품 가격 옵션을 관리합니다.',
        ];
    }

    public function __invoke(Request $request, $productId)
    {
        // 상품 정보 조회
        $product = DB::table('site_products')
            ->where('id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route('admin.site.products.index')
                ->with('error', 'Product를 찾을 수 없습니다.');
        }

        // 가격 옵션 목록 조회
        $pricingOptions = DB::table($this->config['table'])
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->orderBy('pos')
            ->orderBy('price')
            ->get();

        return view($this->config['view'], [
            'product' => $product,
            'pricingOptions' => $pricingOptions,
            'config' => $this->config,
        ]);
    }
}