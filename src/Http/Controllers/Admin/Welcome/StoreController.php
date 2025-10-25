<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome 블록 생성 컨트롤러
 *
 * @description
 * 새로운 블록을 데이터베이스에 추가합니다.
 */
class StoreController extends Controller
{
    /**
     * 새 블록 생성
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:50',
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
            // 현재 그룹에서의 최대 순서 계산
            $maxOrder = SiteWelcome::group($request->group_name)->max('order') ?? 0;
            $newOrder = $maxOrder + 1;

            // 새 블록 생성
            $block = SiteWelcome::create([
                'group_name' => $request->group_name,
                'group_title' => $request->group_title,
                'group_description' => $request->group_description,
                'block_name' => $request->block_name,
                'view_template' => $request->view_template,
                'config' => $request->config ?? [],
                'order' => $newOrder,
                'is_enabled' => $request->boolean('is_enabled', true),
                'deploy_at' => $request->deploy_at,
                'is_active' => false, // 새 블록은 기본적으로 비활성
                'is_published' => false, // 새 블록은 기본적으로 미배포
                'status' => $request->status ?? 'draft',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => '블록이 성공적으로 생성되었습니다.',
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

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '블록 생성 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}