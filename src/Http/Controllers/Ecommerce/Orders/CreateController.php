<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Orders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        // Redirect to step-by-step order creation process
        return redirect()->route('admin.cms.ecommerce.orders.step', 1);
    }
}