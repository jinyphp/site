<?php

namespace Jiny\Site\Http\Controllers\Site\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

/**
 * 장바구니 수량 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    public function __invoke(Request $request, $cartId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

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

        // 상품인 경우 재고 확인
        if ($cartItem->item_type === 'product') {
            $product = Product::find($cartItem->item_id);
            if ($product && $product->track_inventory && !$product->isInStock($validated['quantity'])) {
                $inventoryItem = $product->inventoryItem;
                $availableStock = $inventoryItem ? $inventoryItem->quantity_available : 0;

                return response()->json([
                    'success' => false,
                    'message' => "재고가 부족합니다. 현재 재고: {$availableStock}개, 요청 수량: {$validated['quantity']}개"
                ], 400);
            }
        }

        // 수량 업데이트
        DB::table('site_cart')
            ->where('id', $cartId)
            ->update([
                'quantity' => $validated['quantity'],
                'updated_at' => now()
            ]);

        // 장바구니 아이템 개수 조회
        $cartCount = $this->getCartCount($userId, $sessionId);

        return response()->json([
            'success' => true,
            'message' => '수량이 업데이트되었습니다.',
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