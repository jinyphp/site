<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 삭제 컨트롤러
 */
class DestroyController extends BaseController
{
    /**
     * 상담 유형 삭제
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $type = SiteContactType::findOrFail($id);

            // 사용 중인 상담 유형인지 확인
            if ($type->contacts()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => '사용 중인 상담 유형은 삭제할 수 없습니다.'
                ]);
            }

            $type->delete();

            return response()->json([
                'success' => true,
                'message' => '상담 유형이 삭제되었습니다.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상담 유형 삭제에 실패했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}