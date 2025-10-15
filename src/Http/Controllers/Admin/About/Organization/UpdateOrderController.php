<?php

namespace Jiny\Site\Http\Controllers\Admin\About\Organization;

use App\Http\Controllers\Controller;
use App\Models\SiteAboutOrganization;
use Illuminate\Http\Request;

class UpdateOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:site_about_organization,id',
            'orders.*.sort_order' => 'required|integer|min:0'
        ]);

        try {
            foreach ($request->orders as $orderData) {
                SiteAboutOrganization::where('id', $orderData['id'])
                    ->update(['sort_order' => $orderData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => '정렬 순서가 성공적으로 업데이트되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '정렬 순서 업데이트 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}