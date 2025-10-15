<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

/**
 * 베너 순서 업데이트 컨트롤러
 *
 * 진입 경로:
 * Route::post('admin/site/banner/update-order') → UpdateOrderController::__invoke()
 */
class UpdateOrderController extends BaseController
{

    /**
     * 베너 순서 업데이트 처리
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $orders = $request->get('orders', []);

        if (empty($orders)) {
            return response()->json([
                'success' => false,
                'message' => '순서 데이터가 없습니다.'
            ]);
        }

        try {
            DB::transaction(function () use ($orders) {
                foreach ($orders as $order) {
                    Banner::where('id', $order['id'])
                        ->update(['display_order' => $order['order']]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => '베너 순서가 업데이트되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '베너 순서 업데이트 중 오류가 발생했습니다.'
            ]);
        }
    }
}