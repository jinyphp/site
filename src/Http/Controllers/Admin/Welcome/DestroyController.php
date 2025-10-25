<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;
use Illuminate\Support\Facades\DB;

/**
 * Welcome 블록 삭제 컨트롤러
 *
 * @description
 * 기존 블록을 데이터베이스에서 삭제합니다.
 */
class DestroyController extends Controller
{
    /**
     * 블록 삭제
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $block = SiteWelcome::findOrFail($id);
            $deletedOrder = $block->order;
            $groupName = $block->group_name;

            DB::beginTransaction();

            // 블록 삭제
            $block->delete();

            // 삭제된 블록 이후의 순서들을 1씩 감소 (같은 그룹 내에서)
            SiteWelcome::group($groupName)
                ->where('order', '>', $deletedOrder)
                ->decrement('order');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '블록이 성공적으로 삭제되었습니다.'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => '블록을 찾을 수 없습니다.'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '블록 삭제 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}