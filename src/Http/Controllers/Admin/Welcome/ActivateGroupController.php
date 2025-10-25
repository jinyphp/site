<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;
use Jiny\Site\Models\SiteWelcomeDeployment;

/**
 * Welcome 그룹 활성화 컨트롤러
 *
 * @description
 * 특정 그룹을 활성화하고 다른 그룹들은 비활성화합니다.
 * 배포 이력도 함께 기록합니다.
 */
class ActivateGroupController extends Controller
{
    /**
     * 그룹 활성화
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:50'
        ]);

        try {
            // 이전 활성 그룹 찾기
            $previousActiveGroup = SiteWelcome::where('is_active', true)
                ->pluck('group_name')
                ->first();

            // 그룹 활성화
            $result = SiteWelcome::activateGroup($request->group_name);

            if ($result) {
                // 배포된 블록들 정보 수집
                $deployedBlocks = SiteWelcome::group($request->group_name)
                    ->enabled()
                    ->ordered()
                    ->get()
                    ->map(function ($block) {
                        return [
                            'id' => $block->id,
                            'block_name' => $block->block_name,
                            'view_template' => $block->view_template,
                            'order' => $block->order,
                            'is_enabled' => $block->is_enabled
                        ];
                    })
                    ->toArray();

                // 배포 이력 기록
                SiteWelcomeDeployment::recordDeployment(
                    groupName: $request->group_name,
                    deploymentType: 'manual',
                    blocks: $deployedBlocks,
                    previousActiveGroup: $previousActiveGroup,
                    metadata: [
                        'user_agent' => $request->userAgent(),
                        'ip_address' => $request->ip(),
                        'activation_method' => 'admin_panel'
                    ]
                );

                return response()->json([
                    'success' => true,
                    'message' => "'{$request->group_name}' 그룹이 성공적으로 활성화되었습니다.",
                    'active_group' => $request->group_name,
                    'blocks_deployed' => count($deployedBlocks),
                    'previous_active_group' => $previousActiveGroup
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '그룹을 찾을 수 없습니다.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '그룹 활성화 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}