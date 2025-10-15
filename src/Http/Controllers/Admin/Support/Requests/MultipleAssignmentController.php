<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportMultipleAssignment;
use App\Models\User;

/**
 * 기술지원 요청 다중 할당 관리 컨트롤러
 */
class MultipleAssignmentController extends Controller
{
    /**
     * 관리자 할당
     */
    public function assign(Request $request, $supportId)
    {
        $request->validate([
            'assignee_id' => 'required|exists:users,id',
            'role' => 'required|in:primary,secondary',
            'note' => 'nullable|string|max:1000'
        ]);

        try {
            $support = SiteSupport::findOrFail($supportId);

            // 할당받을 사용자가 관리자인지 확인
            $assignee = User::where('id', $request->assignee_id)
                           ->where('isAdmin', true)
                           ->first();

            if (!$assignee) {
                return response()->json([
                    'success' => false,
                    'message' => '유효하지 않은 관리자입니다.'
                ], 400);
            }

            // 관리자 할당
            $assignment = SiteSupportMultipleAssignment::assignAdmin(
                $supportId,
                $request->assignee_id,
                $request->role,
                Auth::id(),
                $request->note
            );

            return response()->json([
                'success' => true,
                'message' => "{$assignee->name}님이 {$assignment->role_label}로 할당되었습니다.",
                'assignment' => [
                    'id' => $assignment->id,
                    'assignee' => [
                        'id' => $assignee->id,
                        'name' => $assignee->name
                    ],
                    'role' => $assignment->role,
                    'role_label' => $assignment->role_label,
                    'note' => $assignment->note,
                    'assigned_at' => $assignment->assigned_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 해제
     */
    public function deactivate(Request $request, $supportId, $assignmentId)
    {
        try {
            $assignment = SiteSupportMultipleAssignment::where('support_id', $supportId)
                ->where('id', $assignmentId)
                ->where('is_active', true)
                ->firstOrFail();

            $assignment->deactivate();

            return response()->json([
                'success' => true,
                'message' => '할당이 해제되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 해제 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 역할 변경 (주담당자 ↔ 부담당자)
     */
    public function changeRole(Request $request, $supportId, $assignmentId)
    {
        $request->validate([
            'role' => 'required|in:primary,secondary'
        ]);

        try {
            $assignment = SiteSupportMultipleAssignment::where('support_id', $supportId)
                ->where('id', $assignmentId)
                ->where('is_active', true)
                ->firstOrFail();

            if ($request->role === 'primary') {
                $assignment->promoteToPrimary();
                $message = '주담당자로 변경되었습니다.';
            } else {
                $assignment->demoteToSecondary();
                $message = '부담당자로 변경되었습니다.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'assignment' => [
                    'id' => $assignment->id,
                    'role' => $assignment->role,
                    'role_label' => $assignment->role_label
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '역할 변경 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당된 관리자 목록 조회
     */
    public function list($supportId)
    {
        try {
            $assignments = SiteSupportMultipleAssignment::getAllActiveAssignees($supportId);

            return response()->json([
                'success' => true,
                'assignments' => $assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'assignee' => [
                            'id' => $assignment->assignee->id,
                            'name' => $assignment->assignee->name,
                            'email' => $assignment->assignee->email
                        ],
                        'role' => $assignment->role,
                        'role_label' => $assignment->role_label,
                        'note' => $assignment->note,
                        'assigned_at' => $assignment->assigned_at->format('Y-m-d H:i:s'),
                        'assigned_by' => $assignment->assignedBy ? [
                            'id' => $assignment->assignedBy->id,
                            'name' => $assignment->assignedBy->name
                        ] : null
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 목록 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 가능한 관리자 목록 조회
     */
    public function getAvailableAdmins($supportId)
    {
        try {
            // 이미 할당된 관리자 ID 목록
            $assignedAdminIds = SiteSupportMultipleAssignment::where('support_id', $supportId)
                ->where('is_active', true)
                ->pluck('assignee_id');

            // 할당되지 않은 관리자들 조회
            $availableAdmins = User::where('isAdmin', true)
                ->whereNotIn('id', $assignedAdminIds)
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'admins' => $availableAdmins
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '관리자 목록 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 이력 조회 (모든 할당/해제 내역)
     */
    public function history($supportId)
    {
        try {
            $assignments = SiteSupportMultipleAssignment::where('support_id', $supportId)
                ->with(['assignee', 'assignedBy'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'history' => $assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'assignee' => [
                            'id' => $assignment->assignee->id,
                            'name' => $assignment->assignee->name
                        ],
                        'role' => $assignment->role,
                        'role_label' => $assignment->role_label,
                        'status' => $assignment->is_active ? '활성' : '비활성',
                        'note' => $assignment->note,
                        'assigned_at' => $assignment->assigned_at->format('Y-m-d H:i:s'),
                        'deactivated_at' => $assignment->deactivated_at ? $assignment->deactivated_at->format('Y-m-d H:i:s') : null,
                        'assigned_by' => $assignment->assignedBy ? [
                            'id' => $assignment->assignedBy->id,
                            'name' => $assignment->assignedBy->name
                        ] : null
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 이력 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}