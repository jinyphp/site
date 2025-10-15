<?php

namespace Jiny\Site\Http\Controllers\Site\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

/**
 * 장바구니 상품 추가 컨트롤러
 */
class AddController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required|in:product,service',
            'item_id' => 'required|integer',
            'pricing_option_id' => 'nullable|integer',
            'quantity' => 'integer|min:1|max:99',
            'options' => 'nullable|array'
        ]);

        // 기본값 설정
        $validated['quantity'] = $validated['quantity'] ?? 1;

        // 상품/서비스 존재 확인
        $tableName = $validated['item_type'] === 'product' ? 'site_products' : 'site_services';
        $item = DB::table($tableName)
            ->where('id', $validated['item_id'])
            ->where('enable', true)
            ->whereNull('deleted_at')
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => '해당 상품을 찾을 수 없습니다.'
            ], 404);
        }

        // 상품인 경우 재고 확인
        if ($validated['item_type'] === 'product') {
            $product = Product::find($validated['item_id']);
            if ($product && $product->track_inventory) {
                // 기존 장바구니에 있는 수량 확인
                $userId = auth()->id();
                $sessionId = $userId ? null : session()->getId();
                $pricingOptionId = $validated['pricing_option_id'] ?? null;

                $existingQuantity = DB::table('site_cart')
                    ->where('item_type', $validated['item_type'])
                    ->where('item_id', $validated['item_id'])
                    ->where(function($query) use ($pricingOptionId) {
                        if ($pricingOptionId === null) {
                            $query->whereNull('pricing_option_id');
                        } else {
                            $query->where('pricing_option_id', $pricingOptionId);
                        }
                    })
                    ->where(function($query) use ($userId, $sessionId) {
                        if ($userId) {
                            $query->where('user_id', $userId);
                        } else {
                            $query->where('session_id', $sessionId);
                        }
                    })
                    ->whereNull('deleted_at')
                    ->sum('quantity') ?? 0;

                $totalRequestedQuantity = $existingQuantity + $validated['quantity'];

                // 재고 확인
                if (!$product->isInStock($totalRequestedQuantity)) {
                    $inventoryItem = $product->inventoryItem;
                    $availableStock = $inventoryItem ? $inventoryItem->quantity_available : 0;

                    return response()->json([
                        'success' => false,
                        'message' => "재고가 부족합니다. 현재 재고: {$availableStock}개, 요청 수량: {$totalRequestedQuantity}개"
                    ], 400);
                }
            }
        }

        // 가격 옵션 존재 확인
        if (!empty($validated['pricing_option_id'])) {
            $pricingTable = $validated['item_type'] === 'product' ? 'site_product_pricing' : 'site_service_pricing';
            $pricingOption = DB::table($pricingTable)
                ->where('id', $validated['pricing_option_id'])
                ->where($validated['item_type'] . '_id', $validated['item_id'])
                ->where('enable', true)
                ->whereNull('deleted_at')
                ->first();

            if (!$pricingOption) {
                return response()->json([
                    'success' => false,
                    'message' => '선택한 가격 옵션을 찾을 수 없습니다.'
                ], 404);
            }
        }

        // 사용자 식별
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        // 이미 장바구니에 있는지 확인
        $pricingOptionId = $validated['pricing_option_id'] ?? null;
        $existingCartItem = DB::table('site_cart')
            ->where('item_type', $validated['item_type'])
            ->where('item_id', $validated['item_id'])
            ->where(function($query) use ($pricingOptionId) {
                if ($pricingOptionId === null) {
                    $query->whereNull('pricing_option_id');
                } else {
                    $query->where('pricing_option_id', $pricingOptionId);
                }
            })
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->whereNull('deleted_at')
            ->first();

        if ($existingCartItem) {
            // 기존 아이템 수량 업데이트
            $newQuantity = $existingCartItem->quantity + $validated['quantity'];
            $newQuantity = min($newQuantity, 99); // 최대 수량 제한

            // 상품인 경우 재고 한번 더 확인 (최종 수량 기준)
            if ($validated['item_type'] === 'product') {
                $product = Product::find($validated['item_id']);
                if ($product && $product->track_inventory && !$product->isInStock($newQuantity)) {
                    $inventoryItem = $product->inventoryItem;
                    $availableStock = $inventoryItem ? $inventoryItem->quantity_available : 0;

                    return response()->json([
                        'success' => false,
                        'message' => "재고가 부족합니다. 현재 재고: {$availableStock}개, 요청 수량: {$newQuantity}개"
                    ], 400);
                }
            }

            DB::table('site_cart')
                ->where('id', $existingCartItem->id)
                ->update([
                    'quantity' => $newQuantity,
                    'updated_at' => now()
                ]);

            $message = '장바구니에 추가되었습니다. (기존 수량 업데이트)';
        } else {
            // 새 아이템 추가
            DB::table('site_cart')->insert([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'item_type' => $validated['item_type'],
                'item_id' => $validated['item_id'],
                'pricing_option_id' => $validated['pricing_option_id'] ?? null,
                'quantity' => $validated['quantity'],
                'options' => !empty($validated['options']) ? json_encode($validated['options']) : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $message = '장바구니에 추가되었습니다.';
        }

        // 장바구니 아이템 개수 조회
        $cartCount = $this->getCartCount($userId, $sessionId);

        return response()->json([
            'success' => true,
            'message' => $message,
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