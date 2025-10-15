<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Coupons;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class DestroyController extends Controller
{
    public function __invoke(Request $request, Coupon $coupon)
    {
        // 사용 기록이 있는 쿠폰은 비활성화만 하고 삭제하지 않음
        if ($coupon->times_used > 0) {
            $coupon->update(['status' => 'inactive']);
            return redirect()
                ->route('admin.cms.ecommerce.coupons.index')
                ->with('success', '사용 기록이 있는 쿠폰을 비활성화했습니다.');
        }

        $coupon->delete();

        return redirect()
            ->route('admin.cms.ecommerce.coupons.index')
            ->with('success', '쿠폰이 성공적으로 삭제되었습니다.');
    }
}