<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use App\Models\Banner;

/**
 * 베너 일괄 작업 처리 컨트롤러
 *
 * 진입 경로:
 * Route::post('admin/site/banner/bulk-action') → BulkActionController::__invoke()
 */
class BulkActionController extends BaseController
{

    /**
     * 베너 일괄 작업 처리
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $action = $request->get('action');
        $ids = $request->get('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => '선택된 항목이 없습니다.'
            ]);
        }

        try {
            $count = count($ids);

            switch ($action) {
                case 'delete':
                    Banner::whereIn('id', $ids)->delete();
                    $message = "{$count}개의 베너가 삭제되었습니다.";
                    break;

                case 'enable':
                    Banner::whereIn('id', $ids)->update(['enable' => true]);
                    $message = "{$count}개의 베너가 활성화되었습니다.";
                    break;

                case 'disable':
                    Banner::whereIn('id', $ids)->update(['enable' => false]);
                    $message = "{$count}개의 베너가 비활성화되었습니다.";
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => '유효하지 않은 작업입니다.'
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '오류가 발생했습니다.'
            ]);
        }
    }
}