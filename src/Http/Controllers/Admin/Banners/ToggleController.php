<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use App\Models\Banner;

/**
 * 베너 활성화/비활성화 토글 컨트롤러
 *
 * 진입 경로:
 * Route::post('admin/site/banner/{id}/toggle') → ToggleController::__invoke()
 */
class ToggleController extends BaseController
{

    /**
     * 베너 활성화/비활성화 토글 처리
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->update(['enable' => $request->get('enable')]);

            $message = $request->get('enable') ? '베너가 활성화되었습니다.' : '베너가 비활성화되었습니다.';

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