<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Promotions;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:promotions,code,' . $id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed_amount,buy_x_get_y,free_shipping',
            'value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'applicable_products' => 'nullable|array',
            'applicable_categories' => 'nullable|array',
            'excluded_products' => 'nullable|array',
            'stackable' => 'nullable|boolean',
            'starts_at' => 'required|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'status' => 'required|in:active,inactive,expired'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // 배열 필드 처리
        $data['applicable_products'] = $data['applicable_products'] ?? null;
        $data['applicable_categories'] = $data['applicable_categories'] ?? null;
        $data['excluded_products'] = $data['excluded_products'] ?? null;
        $data['stackable'] = $data['stackable'] ?? false;

        $promotion->update($data);

        return redirect()->route('admin.cms.ecommerce.promotions.show', $promotion->id)
            ->with('success', '프로모션이 성공적으로 수정되었습니다.');
    }
}