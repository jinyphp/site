<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 관리자 장바구니 아이템 삭제 컨트롤러
 */
class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        try {
            // 장바구니 아이템 존재 확인
            $cartItem = DB::table('site_cart')
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => '장바구니 아이템을 찾을 수 없습니다.'
                ], 404);
            }

            // 소프트 삭제 (deleted_at 설정)
            DB::table('site_cart')
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => '장바구니 아이템이 삭제되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '삭제 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}