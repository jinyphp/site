<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcome;

/**
 * Welcome 그룹 배포 컨트롤러
 *
 * @description
 * 스케줄된 그룹들을 수동으로 배포하거나 배포 상태를 확인합니다.
 */
class DeployGroupController extends Controller
{
    /**
     * 현재 그룹 즉시 배포
     */
    public function deploy(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:50'
        ]);

        try {
            // 이전 활성 그룹 찾기
            $previousActiveGroup = SiteWelcome::where('is_active', true)
                ->pluck('group_name')
                ->first();

            // 현재 그룹 활성화
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
                        'deployment_method' => 'immediate_deploy'
                    ]
                );

                return response()->json([
                    'success' => true,
                    'message' => "'{$request->group_name}' 그룹이 성공적으로 배포되었습니다.",
                    'deployed_group' => $request->group_name,
                    'blocks_deployed' => count($deployedBlocks),
                    'previous_active_group' => $previousActiveGroup
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '배포할 그룹을 찾을 수 없습니다.'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '그룹 배포 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 스케줄된 그룹들 자동 배포 (cron job용)
     */
    public function deployScheduled(Request $request)
    {
        try {
            $deployedCount = SiteWelcome::deployScheduledGroups();

            return response()->json([
                'success' => true,
                'message' => "{$deployedCount}개의 스케줄된 그룹이 배포되었습니다.",
                'deployed_count' => $deployedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '스케줄된 그룹 배포 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 특정 그룹의 배포 스케줄 설정
     */
    public function schedule(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:50',
            'deploy_at' => 'required|date|after:now'
        ]);

        try {
            $updatedCount = SiteWelcome::group($request->group_name)
                ->update([
                    'deploy_at' => $request->deploy_at,
                    'status' => 'scheduled',
                    'updated_by' => auth()->id()
                ]);

            if ($updatedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "'{$request->group_name}' 그룹의 배포가 예약되었습니다.",
                    'deploy_at' => $request->deploy_at
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
                'message' => '배포 스케줄 설정 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 배포 가능한 그룹들 조회
     */
    public function deployable(Request $request)
    {
        try {
            $groups = SiteWelcome::select('group_name', 'group_title', 'deploy_at', 'status')
                ->where('status', 'scheduled')
                ->where('deploy_at', '<=', now())
                ->distinct('group_name')
                ->get()
                ->groupBy('group_name')
                ->map(function ($items) {
                    return $items->first();
                });

            return response()->json([
                'success' => true,
                'deployable_groups' => $groups->values()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '배포 가능한 그룹 조회 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}