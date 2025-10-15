<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 수정 폼 컨트롤러
 */
class EditController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::ecommerce.products.pricing.edit',
            'title' => 'Product Pricing 수정',
            'subtitle' => '가격 옵션을 수정합니다.',
        ];
    }

    public function __invoke(Request $request, $productId, $pricingId)
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

        // 가격 옵션 정보 조회
        $pricing = DB::table('site_product_pricing')
            ->where('id', $pricingId)
            ->where('product_id', $productId)
            ->whereNull('deleted_at')
            ->first();

        if (!$pricing) {
            return redirect()
                ->route('admin.site.products.pricing.index', $productId)
                ->with('error', '가격 옵션을 찾을 수 없습니다.');
        }

        return view($this->config['view'], [
            'product' => $product,
            'pricing' => $pricing,
            'config' => $this->config,
        ]);
    }
}