<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Location;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Location 순서 변경 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/about/location/update-order') → UpdateOrderController::__invoke()
 */
class UpdateOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $items = $request->input('items', []);

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => '정렬할 항목이 없습니다.'
            ]);
        }

        try {
            DB::beginTransaction();

            foreach ($items as $index => $item) {
                DB::table('site_location')
                    ->where('id', $item['id'])
                    ->update([
                        'sort_order' => $index + 1,
                        'updated_at' => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '순서가 성공적으로 변경되었습니다.'
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => '순서 변경 중 오류가 발생했습니다.'
            ], 500);
        }
    }
}