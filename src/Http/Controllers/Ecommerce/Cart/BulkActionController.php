<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 관리자 장바구니 일괄 작업 컨트롤러
 */
class BulkActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete',
            'items' => 'required|array|min:1',
            'items.*' => 'integer|exists:site_cart,id'
        ]);

        try {
            $action = $validated['action'];
            $itemIds = $validated['items'];

            switch ($action) {
                case 'delete':
                    return $this->bulkDelete($itemIds);

                default:
                    return response()->json([
                        'success' => false,
                        'message' => '지원하지 않는 작업입니다.'
                    ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 장바구니 아이템 일괄 삭제
     */
    private function bulkDelete(array $itemIds)
    {
        // 삭제되지 않은 아이템만 필터링
        $existingItems = DB::table('site_cart')
            ->whereIn('id', $itemIds)
            ->whereNull('deleted_at')
            ->pluck('id')
            ->toArray();

        if (empty($existingItems)) {
            return response()->json([
                'success' => false,
                'message' => '삭제할 수 있는 장바구니 아이템이 없습니다.'
            ], 404);
        }

        // 소프트 삭제 실행
        $deletedCount = DB::table('site_cart')
            ->whereIn('id', $existingItems)
            ->whereNull('deleted_at')
            ->update([
                'deleted_at' => now(),
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount}개의 장바구니 아이템이 삭제되었습니다.",
            'deleted_count' => $deletedCount
        ]);
    }
}