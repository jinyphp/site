<?php

namespace Jiny\Site\Http\Controllers\Admin\Welcome;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteWelcomeDeployment;

/**
 * Welcome 배포 이력 컨트롤러
 *
 * @description
 * Welcome 페이지 그룹들의 배포 이력을 조회하고 관리합니다.
 */
class DeploymentHistoryController extends Controller
{
    /**
     * 배포 이력 목록 조회
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 20);
            $groupName = $request->get('group_name');
            $deploymentType = $request->get('deployment_type');
            $deploymentStatus = $request->get('deployment_status');

            $query = SiteWelcomeDeployment::latest();

            // 필터링
            if ($groupName) {
                $query->group($groupName);
            }

            if ($deploymentType) {
                $query->where('deployment_type', $deploymentType);
            }

            if ($deploymentStatus) {
                $query->where('deployment_status', $deploymentStatus);
            }

            $deployments = $query->paginate($perPage);

            // JSON 요청인 경우
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'deployments' => $deployments->items(),
                    'pagination' => [
                        'current_page' => $deployments->currentPage(),
                        'last_page' => $deployments->lastPage(),
                        'per_page' => $deployments->perPage(),
                        'total' => $deployments->total()
                    ]
                ]);
            }

            // 그룹 목록 (필터용)
            $groups = SiteWelcomeDeployment::select('group_name')
                ->distinct()
                ->orderBy('group_name')
                ->pluck('group_name');

            return view('jiny-site::admin.welcome.deployment-history', [
                'deployments' => $deployments,
                'groups' => $groups,
                'currentFilters' => [
                    'group_name' => $groupName,
                    'deployment_type' => $deploymentType,
                    'deployment_status' => $deploymentStatus
                ]
            ]);

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '배포 이력 조회 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['message' => '배포 이력 조회 중 오류가 발생했습니다.']);
        }
    }

    /**
     * 특정 배포 이력 상세 조회
     */
    public function show(Request $request, $id)
    {
        try {
            $deployment = SiteWelcomeDeployment::findOrFail($id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'deployment' => $deployment
                ]);
            }

            return view('jiny-site::admin.welcome.deployment-detail', [
                'deployment' => $deployment
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '배포 이력을 찾을 수 없습니다.'
                ], 404);
            }

            return back()->withErrors(['message' => '배포 이력을 찾을 수 없습니다.']);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '배포 이력 조회 중 오류가 발생했습니다.',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['message' => '배포 이력 조회 중 오류가 발생했습니다.']);
        }
    }

    /**
     * 배포 통계 조회
     */
    public function stats(Request $request)
    {
        try {
            $stats = SiteWelcomeDeployment::getDeploymentStats();
            $recentDeployments = SiteWelcomeDeployment::getRecentDeployments(5);

            // 오늘의 배포 수
            $todayDeployments = SiteWelcomeDeployment::whereDate('deployed_at', today())->count();

            // 이번 주 배포 수
            $weekDeployments = SiteWelcomeDeployment::whereBetween('deployed_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count();

            // 이번 달 배포 수
            $monthDeployments = SiteWelcomeDeployment::whereMonth('deployed_at', now()->month)
                ->whereYear('deployed_at', now()->year)
                ->count();

            $summary = [
                'total_deployments' => SiteWelcomeDeployment::count(),
                'successful_deployments' => SiteWelcomeDeployment::successful()->count(),
                'failed_deployments' => SiteWelcomeDeployment::failed()->count(),
                'today_deployments' => $todayDeployments,
                'week_deployments' => $weekDeployments,
                'month_deployments' => $monthDeployments
            ];

            return response()->json([
                'success' => true,
                'summary' => $summary,
                'group_stats' => $stats,
                'recent_deployments' => $recentDeployments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '배포 통계 조회 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 최근 배포 이력 조회 (AJAX용)
     */
    public function recent(Request $request)
    {
        try {
            $limit = $request->get('limit', 10);
            $groupName = $request->get('group_name');

            $query = SiteWelcomeDeployment::latest();

            if ($groupName) {
                $query->group($groupName);
            }

            $deployments = $query->limit($limit)->get();

            return response()->json([
                'success' => true,
                'deployments' => $deployments->map(function ($deployment) {
                    return [
                        'id' => $deployment->id,
                        'group_name' => $deployment->group_name,
                        'group_title' => $deployment->group_title,
                        'deployment_type' => $deployment->deployment_type,
                        'deployment_type_korean' => $deployment->deployment_type_korean,
                        'deployment_status' => $deployment->deployment_status,
                        'deployment_status_korean' => $deployment->deployment_status_korean,
                        'blocks_count' => $deployment->blocks_count,
                        'deployed_at' => $deployment->deployed_at->format('Y-m-d H:i:s'),
                        'deployed_at_human' => $deployment->deployed_at->diffForHumans(),
                        'deployed_by_name' => $deployment->deployed_by_name,
                        'previous_active_group' => $deployment->previous_active_group
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '최근 배포 이력 조회 중 오류가 발생했습니다.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}