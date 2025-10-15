<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 순서 업데이트 컨트롤러
 */
class UpdateOrderController extends BaseController
{
    /**
     * 상담 유형 순서 업데이트
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer',
            'orders.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->orders as $order) {
                SiteContactType::where('id', $order['id'])
                    ->update(['sort_order' => $order['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => '상담 유형 순서가 업데이트되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '순서 업데이트에 실패했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}