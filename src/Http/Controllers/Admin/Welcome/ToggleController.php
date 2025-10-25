<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome 블록 활성화/비활성화 컨트롤러
 *
 * @description
 * 블록의 is_enabled 상태를 토글합니다.
 */
class ToggleController extends Controller
{
    /**
     * 블록 활성화/비활성화 토글
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        try {
            $block = SiteWelcome::findOrFail($request->id);

            // is_enabled 상태 토글
            $block->update([
                'is_enabled' => !$block->is_enabled,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => '블록 상태가 성공적으로 변경되었습니다.',
                'enabled' => $block->is_enabled
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => '블록을 찾을 수 없습니다.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '블록 상태 변경 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}