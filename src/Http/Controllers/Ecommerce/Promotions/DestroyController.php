<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Promotions;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $promotionName = $promotion->name;
        $promotion->delete();

        return redirect()->route('admin.cms.ecommerce.promotions.index')
            ->with('success', "프로모션 '{$promotionName}'이(가) 성공적으로 삭제되었습니다.");
    }
}