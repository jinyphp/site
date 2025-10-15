<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Shipping\Zones;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 배송 지역 생성 컨트롤러
 */
class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        // TODO: 구현 예정
        return response()->json(['message' => '준비 중입니다.']);
    }
}