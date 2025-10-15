<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Coupons;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class UpdateController extends Controller
{
    public function __invoke(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,free_shipping',
            'value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'excluded_products' => 'nullable|array',
            'stackable' => 'boolean',
            'auto_apply' => 'boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'status' => 'required|in:active,inactive,expired'
        ]);

        $coupon->update($validated);

        return redirect()
            ->route('admin.cms.ecommerce.coupons.index')
            ->with('success', '쿠폰이 성공적으로 수정되었습니다.');
    }
}