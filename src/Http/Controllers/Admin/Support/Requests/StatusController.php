<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportAssignment;

class StatusController extends Controller
{
    /**
     * 지원 요청 상태 변경 (AJAX)
     */
    public function update(Request $request, $id)
    {
        try {
            $support = SiteSupport::findOrFail($id);

            $request->validate([
                'status' => 'required|in:pending,in_progress,resolved,closed,reopened',
                'note' => 'nullable|string|max:1000'
            ]);

            $oldStatus = $support->status;
            $newStatus = $request->status;
            $note = $request->note;

            // 상태 변경 유효성 검사
            $this->validateStatusTransition($support, $oldStatus, $newStatus);

            DB::beginTransaction();

            // 상태별 특별 처리
            $updateData = ['status' => $newStatus];

            switch ($newStatus) {
                case 'in_progress':
                    if ($oldStatus === 'pending') {
                        $updateData['started_at'] = now();
                    }
                    break;

                case 'resolved':
                    $updateData['resolved_at'] = now();
                    $updateData['resolved_by'] = Auth::id();
                    break;

                case 'closed':
                    $updateData['closed_at'] = now();
                    $updateData['closed_by'] = Auth::id();
                    if (!$support->resolved_at) {
                        $updateData['resolved_at'] = now();
                        $updateData['resolved_by'] = Auth::id();
                    }
                    break;

                case 'reopened':
                    // 재오픈 시 이전 완료/종료 정보 초기화
                    $updateData['status'] = 'in_progress'; // 재오픈하면 진행중으로
                    $updateData['resolved_at'] = null;
                    $updateData['resolved_by'] = null;
                    $updateData['closed_at'] = null;
                    $updateData['closed_by'] = null;
                    $updateData['reopened_at'] = now();
                    $updateData['reopened_by'] = Auth::id();
                    break;
            }

            // 상태 변경
            $support->update($updateData);

            // 상태 변경 이력 생성
            if ($oldStatus !== $newStatus) {
                SiteSupportAssignment::create([
                    'support_id' => $support->id,
                    'assigned_to' => Auth::id(),
                    'assigned_from' => Auth::id(),
                    'action' => 'status_change',
                    'notes' => $this->buildStatusChangeNote($oldStatus, $newStatus, $note)
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $this->getStatusChangeMessage($newStatus),
                'status' => $updateData['status'] ?? $newStatus,
                'support' => [
                    'id' => $support->id,
                    'status' => $updateData['status'] ?? $newStatus,
                    'resolved_at' => isset($updateData['resolved_at']) ? $updateData['resolved_at']?->format('Y-m-d H:i:s') : $support->resolved_at?->format('Y-m-d H:i:s'),
                    'closed_at' => isset($updateData['closed_at']) ? $updateData['closed_at']?->format('Y-m-d H:i:s') : $support->closed_at?->format('Y-m-d H:i:s'),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * 지원 요청 완료 처리
     */
    public function complete(Request $request, $id)
    {
        $request->merge(['status' => 'resolved']);
        return $this->update($request, $id);
    }

    /**
     * 지원 요청 종료 처리
     */
    public function close(Request $request, $id)
    {
        $request->merge(['status' => 'closed']);
        return $this->update($request, $id);
    }

    /**
     * 지원 요청 재오픈 처리
     */
    public function reopen(Request $request, $id)
    {
        $request->merge(['status' => 'reopened']);
        return $this->update($request, $id);
    }

    /**
     * 상태 변경 유효성 검사
     */
    private function validateStatusTransition($support, $oldStatus, $newStatus)
    {
        // 동일한 상태로 변경 시도
        if ($oldStatus === $newStatus) {
            throw new \Exception('현재와 동일한 상태입니다.');
        }

        // 유효한 상태 변경 규칙
        $validTransitions = [
            'pending' => ['in_progress', 'closed'],
            'in_progress' => ['resolved', 'closed', 'pending'],
            'resolved' => ['closed', 'reopened'],
            'closed' => ['reopened'],
        ];

        // 재오픈의 특별한 경우 처리
        if ($newStatus === 'reopened') {
            if (!in_array($oldStatus, ['resolved', 'closed'])) {
                throw new \Exception('완료되거나 종료된 요청만 재오픈할 수 있습니다.');
            }
            return;
        }

        // 일반 상태 변경 규칙 확인
        if (!isset($validTransitions[$oldStatus]) || !in_array($newStatus, $validTransitions[$oldStatus])) {
            throw new \Exception("'{$oldStatus}'에서 '{$newStatus}'로 상태를 변경할 수 없습니다.");
        }

        // 권한 확인 (필요시 추가)
        // 예: 특정 상태 변경은 특정 권한을 가진 사용자만 가능
    }

    /**
     * 상태 변경 메모 생성
     */
    private function buildStatusChangeNote($oldStatus, $newStatus, $userNote = null)
    {
        $statusLabels = [
            'pending' => '대기',
            'in_progress' => '진행중',
            'resolved' => '해결완료',
            'closed' => '종료',
            'reopened' => '재오픈'
        ];

        $note = sprintf(
            '상태 변경: %s → %s',
            $statusLabels[$oldStatus] ?? $oldStatus,
            $statusLabels[$newStatus] ?? $newStatus
        );

        if ($userNote) {
            $note .= "\n메모: " . $userNote;
        }

        return $note;
    }

    /**
     * 상태 변경 성공 메시지 생성
     */
    private function getStatusChangeMessage($status)
    {
        $messages = [
            'pending' => '요청이 대기 상태로 변경되었습니다.',
            'in_progress' => '요청 처리를 시작했습니다.',
            'resolved' => '요청이 해결 완료되었습니다.',
            'closed' => '요청이 종료되었습니다.',
            'reopened' => '요청이 재오픈되어 진행중 상태로 변경되었습니다.'
        ];

        return $messages[$status] ?? '상태가 성공적으로 변경되었습니다.';
    }

    /**
     * 지원 요청 상태 정보 조회
     */
    public function getStatusInfo($id)
    {
        try {
            $support = SiteSupport::with(['resolvedBy', 'closedBy', 'reopenedBy'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'status_info' => [
                    'current_status' => $support->status,
                    'started_at' => $support->started_at?->format('Y-m-d H:i:s'),
                    'resolved_at' => $support->resolved_at?->format('Y-m-d H:i:s'),
                    'resolved_by' => $support->resolvedBy ? [
                        'id' => $support->resolvedBy->id,
                        'name' => $support->resolvedBy->name
                    ] : null,
                    'closed_at' => $support->closed_at?->format('Y-m-d H:i:s'),
                    'closed_by' => $support->closedBy ? [
                        'id' => $support->closedBy->id,
                        'name' => $support->closedBy->name
                    ] : null,
                    'reopened_at' => $support->reopened_at?->format('Y-m-d H:i:s'),
                    'reopened_by' => $support->reopenedBy ? [
                        'id' => $support->reopenedBy->id,
                        'name' => $support->reopenedBy->name
                    ] : null,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '상태 정보 조회 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}