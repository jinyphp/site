<?php

namespace Jiny\Site\Http\Controllers\Site\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 장바구니 아이템 제거 컨트롤러
 */
class RemoveController extends Controller
{
    public function __invoke(Request $request, $cartId)
    {
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        // 장바구니 아이템 확인
        $cartItem = DB::table('site_cart')
            ->where('id', $cartId)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->whereNull('deleted_at')
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => '장바구니 아이템을 찾을 수 없습니다.'
            ], 404);
        }

        // 소프트 삭제
        DB::table('site_cart')
            ->where('id', $cartId)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now()
            ]);

        // 장바구니 아이템 개수 조회
        $cartCount = $this->getCartCount($userId, $sessionId);

        return response()->json([
            'success' => true,
            'message' => '상품이 장바구니에서 제거되었습니다.',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * 장바구니 아이템 개수 조회
     */
    protected function getCartCount($userId, $sessionId)
    {
        return DB::table('site_cart')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->whereNull('deleted_at')
            ->sum('quantity');
    }
}