<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;
use Illuminate\Support\Facades\DB;

/**
 * Welcome 블록 순서 업데이트 컨트롤러
 *
 * @description
 * 드래그앤드롭을 통한 블록 순서 변경을 데이터베이스에서 처리합니다.
 */
class UpdateOrderController extends Controller
{
    /**
     * 블록 순서 업데이트
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|integer',
            'blocks.*.order' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            // 순서 업데이트
            foreach ($request->blocks as $updatedBlock) {
                SiteWelcome::where('id', $updatedBlock['id'])
                    ->update([
                        'order' => $updatedBlock['order'],
                        'updated_by' => auth()->id()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '블록 순서가 성공적으로 업데이트되었습니다.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '블록 순서 업데이트 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}