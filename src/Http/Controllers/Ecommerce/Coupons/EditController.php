<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Coupons;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class EditController extends Controller
{
    public function __invoke(Request $request, Coupon $coupon)
    {
        return view('jiny-site::ecommerce.coupons.edit', compact('coupon'));
    }
}