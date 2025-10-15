<?php

namespace Jiny\Site\Http\Controllers\Site\Cart;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 장바구니 아이템 개수 조회 컨트롤러
 */
class CountController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        // 장바구니 아이템 개수 조회
        $cartCount = DB::table('site_cart')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->whereNull('deleted_at')
            ->sum('quantity');

        return response()->json([
            'success' => true,
            'count' => $cartCount
        ]);
    }
}