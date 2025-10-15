<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 생성 폼 컨트롤러
 */
class CreateController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'view' => 'jiny-site::ecommerce.products.pricing.create',
            'title' => 'Product Pricing 추가',
            'subtitle' => '새로운 가격 옵션을 추가합니다.',
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

        return view($this->config['view'], [
            'product' => $product,
            'config' => $this->config,
        ]);
    }
}