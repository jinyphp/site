<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Products\Pricing;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product Pricing 업데이트 컨트롤러
 */
class UpdateController extends Controller
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

        // 코드 중복 확인 (자기 자신 제외)
        if (!empty($validated['code'])) {
            $exists = DB::table($this->config['table'])
                ->where('product_id', $productId)
                ->where('code', $validated['code'])
                ->where('id', '!=', $pricingId)
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->withErrors(['code' => '이미 사용 중인 코드입니다.']);
            }
        }

        $validated['updated_at'] = now();

        DB::table($this->config['table'])
            ->where('id', $pricingId)
            ->update($validated);

        return redirect()
            ->route($this->config['redirect_route'], $productId)
            ->with('success', '가격 옵션이 성공적으로 수정되었습니다.');
    }
}