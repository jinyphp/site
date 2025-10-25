<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome 그룹 미리보기 컨트롤러
 *
 * @description
 * 비활성 그룹들을 미리보기할 수 있는 기능을 제공합니다.
 */
class PreviewController extends Controller
{
    /**
     * 특정 그룹 미리보기
     */
    public function __invoke(Request $request, $groupName)
    {
        try {
            // 미리보기용 블록들 가져오기 (활성화 여부 무관)
            $blocks = SiteWelcome::getPreviewBlocks($groupName);

            if ($blocks->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => '미리보기할 블록이 없습니다.'
                ], 404);
            }

            // 블록 데이터 변환
            $previewBlocks = $blocks->map(function ($block) {
                return [
                    'id' => $block->id,
                    'name' => $block->block_name,
                    'view' => $block->view_template,
                    'enabled' => $block->is_enabled,
                    'order' => $block->order,
                    'config' => $block->config ?? [],
                    'group_name' => $block->group_name,
                    'deploy_status' => $block->deploy_status,
                    'is_active' => $block->is_active,
                    'deploy_at' => $block->deploy_at?->format('Y-m-d H:i:s'),
                    'status' => $block->status
                ];
            })->toArray();

            // 그룹 정보
            $groupInfo = $blocks->first();

            return response()->json([
                'success' => true,
                'group_name' => $groupName,
                'group_info' => [
                    'group_name' => $groupInfo->group_name,
                    'group_title' => $groupInfo->group_title,
                    'group_description' => $groupInfo->group_description,
                    'is_active' => $groupInfo->is_active,
                    'is_published' => $groupInfo->is_published,
                    'deploy_at' => $groupInfo->deploy_at,
                    'status' => $groupInfo->status,
                    'deploy_status' => $groupInfo->deploy_status
                ],
                'blocks' => $previewBlocks,
                'preview_url' => url('/?preview=' . $groupName)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '미리보기 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 미리보기 가능한 모든 그룹 목록
     */
    public function list(Request $request)
    {
        try {
            $groups = SiteWelcome::getAllGroups();

            $previewList = $groups->map(function ($group) {
                return [
                    'group_name' => $group->group_name,
                    'group_title' => $group->group_title,
                    'group_description' => $group->group_description,
                    'is_active' => $group->is_active,
                    'is_published' => $group->is_published,
                    'deploy_at' => $group->deploy_at,
                    'status' => $group->status,
                    'deploy_status' => $group->deploy_status,
                    'preview_url' => url('/?preview=' . $group->group_name),
                    'admin_preview_url' => url('/admin/cms/welcome/preview/' . $group->group_name)
                ];
            })->values();

            return response()->json([
                'success' => true,
                'groups' => $previewList
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '그룹 목록 조회 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}