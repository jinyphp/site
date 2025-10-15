<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 저장 컨트롤러
 */
class StoreController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = [
            'table' => 'site_product_pricing',
            'redirect_route' => 'admin.site.products.pricing.index',
        ];
    }

    public function __invoke(Request $request, $productId)
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

        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'billing_period' => 'nullable|string|max:50',
            'features' => 'nullable|string',
            'limitations' => 'nullable|string',
            'min_quantity' => 'required|integer|min:1',
            'max_quantity' => 'nullable|integer|min:1',
            'pos' => 'required|integer|min:0',
            'enable' => 'boolean',
        ]);

        // 코드 중복 확인 (같은 상품 내에서)
        if (!empty($validated['code'])) {
            $exists = DB::table($this->config['table'])
                ->where('product_id', $productId)
                ->where('code', $validated['code'])
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors(['code' => '이미 사용 중인 코드입니다.']);
            }
        }

        $validated['product_id'] = $productId;
        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        DB::table($this->config['table'])->insert($validated);

        return redirect()
            ->route($this->config['redirect_route'], $productId)
            ->with('success', '가격 옵션이 성공적으로 추가되었습니다.');
    }
}