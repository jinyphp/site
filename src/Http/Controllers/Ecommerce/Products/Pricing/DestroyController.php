<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_pricing',
            'redirect_route' => 'admin.site.products.pricing.index',
        ];
    }

    public function __invoke(Request $request, $productId, $pricingId)
    {
        // 상품 존재 확인
        $product = DB::table('site_products')
            ->where('id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            return redirect()
                ->route('admin.site.products.index')
                ->with('error', 'Product를 찾을 수 없습니다.');
        }

        // 가격 옵션 존재 확인
        $pricing = DB::table($this->config['table'])
            ->where('id', $pricingId)
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$pricing) {
            return redirect()
                ->route($this->config['redirect_route'], $productId)
                ->with('error', '가격 옵션을 찾을 수 없습니다.');
        }

        // Soft delete
        DB::table($this->config['table'])
            ->where('id', $pricingId)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now()
            ]);

        return redirect()
            ->route($this->config['redirect_route'], $productId)
            ->with('success', '가격 옵션이 성공적으로 삭제되었습니다.');
    }
}