<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 활성화/비활성화 토글 컨트롤러
 */
class ToggleController extends BaseController
{
    /**
     * 상담 유형 활성화/비활성화 토글
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'enable' => 'required|boolean'
        ]);

        try {
            $type = SiteContactType::findOrFail($id);
            $type->update(['enable' => $request->enable]);

            $message = $request->enable ? '상담 유형이 활성화되었습니다.' : '상담 유형이 비활성화되었습니다.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상태 변경에 실패했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}