<?php

namespace Jiny\Site\Http\Controllers\Admin\Faq\Faqs;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * FAQ 대량 작업 컨트롤러
 *
 * 진입 경로:
 * Route::post('/admin/cms/faq/faqs/bulk-action') → BulkActionController::__invoke()
 */
class BulkActionController extends Controller
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
        try {
            $action = $request->get('action');
            $ids = $request->get('ids', []);

            // 쉼표로 구분된 문자열인 경우 배열로 변환
            if (is_string($ids)) {
                $ids = array_filter(explode(',', $ids));
            }

            // 배열 값 정리 (빈 값 제거, 숫자 변환)
            $ids = array_filter(array_map('intval', $ids));

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => '선택된 항목이 없습니다.'
                ], 400);
            }

            $result = $this->performBulkAction($action, $ids);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'action' => $action,
                'ids' => $ids,
                'count' => count($ids)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '작업 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function performBulkAction($action, $ids)
    {
        try {
            switch ($action) {
                case 'delete':
                    $affected = DB::table($this->config['table'])
                        ->whereIn('id', $ids)
                        ->delete();

                    return [
                        'success' => true,
                        'message' => "선택된 {$affected}개의 FAQ가 삭제되었습니다."
                    ];

                case 'enable':
                    $affected = DB::table($this->config['table'])
                        ->whereIn('id', $ids)
                        ->update(['enable' => true, 'updated_at' => now()]);

                    return [
                        'success' => true,
                        'message' => "선택된 {$affected}개의 FAQ가 활성화되었습니다."
                    ];

                case 'disable':
                    $affected = DB::table($this->config['table'])
                        ->whereIn('id', $ids)
                        ->update(['enable' => false, 'updated_at' => now()]);

                    return [
                        'success' => true,
                        'message' => "선택된 {$affected}개의 FAQ가 비활성화되었습니다."
                    ];

                default:
                    return [
                        'success' => false,
                        'message' => '올바르지 않은 작업입니다.'
                    ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '데이터베이스 작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ];
        }
    }
}