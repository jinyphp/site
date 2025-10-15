<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;
use Illuminate\Support\Facades\DB;

/**
 * 언어 순서 업데이트 컨트롤러
 */
class UpdateOrderController extends BaseController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:site_language,id',
            'orders.*.order' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->orders as $orderData) {
                    SiteLanguage::where('id', $orderData['id'])
                        ->update(['order' => $orderData['order']]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => $this->getMessage('actions.bulk', 'success')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage('actions.bulk', 'error') . ': ' . $e->getMessage()
            ], 500);
        }
    }
}