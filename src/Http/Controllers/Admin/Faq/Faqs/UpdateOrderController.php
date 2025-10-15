<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 순서 변경 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/faq/faqs/update-order') → UpdateOrderController::__invoke()
 */
class UpdateOrderController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'table' => 'site_faq',
        ];
    }

    public function __invoke(Request $request)
    {
        $items = $request->get('items', []);

        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => '정렬할 항목이 없습니다.'
            ]);
        }

        $this->updateOrder($items);

        return response()->json([
            'success' => true,
            'message' => 'FAQ 순서가 성공적으로 변경되었습니다.'
        ]);
    }

    protected function updateOrder($items)
    {
        foreach ($items as $index => $id) {
            DB::table($this->config['table'])
                ->where('id', $id)
                ->update(['order' => $index + 1]);
        }
    }
}