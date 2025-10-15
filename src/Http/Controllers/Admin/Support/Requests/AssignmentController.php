<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportAssignment;
use App\Models\User;

/**
 * 기술지원 요청 할당 관리 컨트롤러
 */
class AssignmentController extends Controller
{
    /**
     * 자가 할당 (내가하기)
     */
    public function selfAssign(Request $request, $id)
    {
        try {
            $support = SiteSupport::findOrFail($id);

            // 할당 가능 여부 확인
            if (!$support->canBeAssigned()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 완료된 요청은 할당할 수 없습니다.'
                ], 400);
            }

            // 이미 할당된 경우 확인
            if ($support->assigned_to) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 다른 관리자에게 할당된 요청입니다.'
                ], 400);
            }

            $userId = Auth::id();
            $support->selfAssign($userId);

            return response()->json([
                'success' => true,
                'message' => '요청이 성공적으로 할당되었습니다.',
                'assigned_to' => Auth::user()->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 관리자 할당
     */
    public function assign(Request $request, $id)
    {
        $request->validate([
            'assignee_id' => 'required|exists:users,id',
            'note' => 'nullable|string|max:1000'
        ]);

        try {
            $support = SiteSupport::findOrFail($id);

            // 할당 가능 여부 확인
            if (!$support->canBeAssigned()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 완료된 요청은 할당할 수 없습니다.'
                ], 400);
            }

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

            $support->assignTo(
                $request->assignee_id,
                Auth::id(),
                $request->note
            );

            return response()->json([
                'success' => true,
                'message' => "요청이 {$assignee->name}에게 할당되었습니다.",
                'assigned_to' => $assignee->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 이전
     */
    public function transfer(Request $request, $id)
    {
        $request->validate([
            'new_assignee_id' => 'required|exists:users,id',
            'note' => 'nullable|string|max:1000'
        ]);

        try {
            $support = SiteSupport::findOrFail($id);

            // 할당 가능 여부 확인
            if (!$support->canBeAssigned()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 완료된 요청은 이전할 수 없습니다.'
                ], 400);
            }

            // 현재 담당자인지 확인 (본인만 이전 가능)
            if (!$support->isAssignedTo(Auth::id())) {
                return response()->json([
                    'success' => false,
                    'message' => '본인에게 할당된 요청만 이전할 수 있습니다.'
                ], 400);
            }

            // 새로운 담당자가 관리자인지 확인
            $newAssignee = User::where('id', $request->new_assignee_id)
                              ->where('isAdmin', true)
                              ->first();

            if (!$newAssignee) {
                return response()->json([
                    'success' => false,
                    'message' => '유효하지 않은 관리자입니다.'
                ], 400);
            }

            $support->transferTo(
                $request->new_assignee_id,
                Auth::id(),
                $request->note
            );

            return response()->json([
                'success' => true,
                'message' => "요청이 {$newAssignee->name}에게 이전되었습니다.",
                'assigned_to' => $newAssignee->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '이전 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 해제
     */
    public function unassign(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000'
        ]);

        try {
            $support = SiteSupport::findOrFail($id);

            // 할당 가능 여부 확인
            if (!$support->canBeAssigned()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 완료된 요청은 할당 해제할 수 없습니다.'
                ], 400);
            }

            // 할당되지 않은 경우
            if (!$support->assigned_to) {
                return response()->json([
                    'success' => false,
                    'message' => '할당되지 않은 요청입니다.'
                ], 400);
            }

            $support->unassign(Auth::id(), $request->note);

            return response()->json([
                'success' => true,
                'message' => '요청 할당이 해제되었습니다.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '할당 해제 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 할당 이력 조회
     */
    public function history($id)
    {
        try {
            $support = SiteSupport::findOrFail($id);

            $assignments = SiteSupportAssignment::where('support_id', $id)
                ->with(['assignedFrom', 'assignedTo'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'assignments' => $assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'action' => $assignment->action,
                        'action_label' => $assignment->action_label,
                        'assigned_from' => $assignment->assignedFrom ? [
                            'id' => $assignment->assignedFrom->id,
                            'name' => $assignment->assignedFrom->name
                        ] : null,
                        'assigned_to' => [
                            'id' => $assignment->assignedTo->id,
                            'name' => $assignment->assignedTo->name
                        ],
                        'note' => $assignment->note,
                        'created_at' => $assignment->created_at->format('Y-m-d H:i:s')
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '이력 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 관리자 목록 조회 (할당용)
     */
    public function getAdmins()
    {
        try {
            $admins = User::where('isAdmin', true)
                         ->where('id', '!=', Auth::id()) // 본인 제외
                         ->select('id', 'name', 'email')
                         ->orderBy('name')
                         ->get();

            return response()->json([
                'success' => true,
                'admins' => $admins
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '관리자 목록 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}