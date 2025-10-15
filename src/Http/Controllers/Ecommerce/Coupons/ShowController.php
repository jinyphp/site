<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Coupons;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class ShowController extends Controller
{
    public function __invoke(Request $request, Coupon $coupon)
    {
        $coupon->load(['usages.user', 'usages.order']);

        return view('jiny-site::ecommerce.coupons.show', compact('coupon'));
    }
}