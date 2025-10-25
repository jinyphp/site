<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome 블록 수정 컨트롤러
 *
 * @description
 * 기존 블록의 정보를 데이터베이스에서 수정합니다.
 */
class UpdateController extends Controller
{
    /**
     * 블록 수정
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'group_title' => 'nullable|string|max:255',
            'group_description' => 'nullable|string',
            'block_name' => 'required|string|max:255',
            'view_template' => 'required|string',
            'is_enabled' => 'boolean',
            'config' => 'array',
            'deploy_at' => 'nullable|date',
            'status' => 'required|string|in:draft,scheduled,active,archived'
        ]);

        try {
            $block = SiteWelcome::findOrFail($id);

            // 블록 정보 업데이트 (order와 group_name은 유지)
            $block->update([
                'group_title' => $request->group_title,
                'group_description' => $request->group_description,
                'block_name' => $request->block_name,
                'view_template' => $request->view_template,
                'is_enabled' => $request->boolean('is_enabled', true),
                'config' => $request->config ?? [],
                'deploy_at' => $request->deploy_at,
                'status' => $request->status,
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => '블록이 성공적으로 수정되었습니다.',
                'block' => [
                    'id' => $block->id,
                    'name' => $block->block_name,
                    'view' => $block->view_template,
                    'enabled' => $block->is_enabled,
                    'order' => $block->order,
                    'config' => $block->config,
                    'group_name' => $block->group_name,
                    'deploy_status' => $block->deploy_status,
                    'is_active' => $block->is_active,
                    'deploy_at' => $block->deploy_at?->format('Y-m-d H:i:s'),
                    'status' => $block->status
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => '블록을 찾을 수 없습니다.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '블록 수정 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}