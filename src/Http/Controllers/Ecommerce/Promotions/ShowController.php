<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Promotions;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;

class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        return view('jiny-site::ecommerce.promotions.show', compact('promotion'));
    }
}