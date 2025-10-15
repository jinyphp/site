<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteContactType;

/**
 * 상담 유형 일괄 작업 컨트롤러
 */
class BulkActionController extends BaseController
{
    /**
     * 상담 유형 일괄 작업
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'action' => 'required|in:enable,disable,delete',
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer'
        ]);

        try {
            $types = SiteContactType::whereIn('id', $request->ids)->get();
            $successCount = 0;

            foreach ($types as $type) {
                try {
                    switch ($request->action) {
                        case 'enable':
                            $type->update(['enable' => true]);
                            $successCount++;
                            break;

                        case 'disable':
                            $type->update(['enable' => false]);
                            $successCount++;
                            break;

                        case 'delete':
                            // 사용 중인 유형은 삭제하지 않음
                            if (!$type->contacts()->exists()) {
                                $type->delete();
                                $successCount++;
                            }
                            break;
                    }
                } catch (\Exception $e) {
                    logger('Bulk action failed for contact type ' . $type->id . ': ' . $e->getMessage());
                }
            }

            $actionNames = [
                'enable' => '활성화',
                'disable' => '비활성화',
                'delete' => '삭제'
            ];

            return response()->json([
                'success' => true,
                'message' => "{$successCount}개의 상담 유형이 {$actionNames[$request->action]}되었습니다."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '일괄 작업 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}