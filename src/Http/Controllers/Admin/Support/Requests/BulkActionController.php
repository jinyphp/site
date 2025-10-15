<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 일괄 작업 컨트롤러
 */
class BulkActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_status,assign,update_priority',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:site_support,id',
        ]);

        $action = $request->action;
        $selectedIds = $request->selected_ids;

        try {
            switch ($action) {
                case 'delete':
                    return $this->bulkDelete($selectedIds);

                case 'update_status':
                    $request->validate(['status' => 'required|in:pending,in_progress,resolved,closed']);
                    return $this->bulkUpdateStatus($selectedIds, $request->status);

                case 'assign':
                    $request->validate(['assigned_to' => 'nullable|exists:users,id']);
                    return $this->bulkAssign($selectedIds, $request->assigned_to);

                case 'update_priority':
                    $request->validate(['priority' => 'required|in:low,normal,high,urgent']);
                    return $this->bulkUpdatePriority($selectedIds, $request->priority);

                default:
                    throw new \InvalidArgumentException('Invalid action');
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '작업 처리 중 오류가 발생했습니다: ' . $e->getMessage()
                ], 500);
            }

            return redirect()
                ->back()
                ->with('error', '작업 처리 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    private function bulkDelete($selectedIds)
    {
        $count = SiteSupport::whereIn('id', $selectedIds)->count();
        SiteSupport::whereIn('id', $selectedIds)->delete();

        return $this->successResponse("선택한 {$count}개의 지원 요청이 삭제되었습니다.");
    }

    private function bulkUpdateStatus($selectedIds, $status)
    {
        $updateData = ['status' => $status];

        // 해결 상태로 변경하는 경우 해결 시간 기록
        if ($status === 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $count = SiteSupport::whereIn('id', $selectedIds)->update($updateData);

        $statusLabels = [
            'pending' => '대기중',
            'in_progress' => '처리중',
            'resolved' => '해결완료',
            'closed' => '종료'
        ];

        $statusLabel = $statusLabels[$status] ?? $status;

        return $this->successResponse("선택한 {$count}개의 지원 요청 상태가 '{$statusLabel}'로 변경되었습니다.");
    }

    private function bulkAssign($selectedIds, $assignedTo)
    {
        $count = SiteSupport::whereIn('id', $selectedIds)->update([
            'assigned_to' => $assignedTo
        ]);

        if ($assignedTo) {
            $assigneeName = \DB::table('users')->where('id', $assignedTo)->value('name');
            $message = "선택한 {$count}개의 지원 요청이 '{$assigneeName}'에게 배정되었습니다.";
        } else {
            $message = "선택한 {$count}개의 지원 요청 배정이 해제되었습니다.";
        }

        return $this->successResponse($message);
    }

    private function bulkUpdatePriority($selectedIds, $priority)
    {
        $count = SiteSupport::whereIn('id', $selectedIds)->update([
            'priority' => $priority
        ]);

        $priorityLabels = [
            'low' => '낮음',
            'normal' => '보통',
            'high' => '높음',
            'urgent' => '긴급'
        ];

        $priorityLabel = $priorityLabels[$priority] ?? $priority;

        return $this->successResponse("선택한 {$count}개의 지원 요청 우선순위가 '{$priorityLabel}'로 변경되었습니다.");
    }

    private function successResponse($message)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()
            ->route('admin.cms.support.requests.index')
            ->with('success', $message);
    }
}