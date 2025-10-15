<?php

namespace Jiny\Site\Http\Controllers\Admin\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteSupport;

class EditController extends Controller
{
    public function __construct()
    {
        // Middleware applied in routes
    }

    public function __invoke(Request $request, $id)
    {
        $support = SiteSupport::with(['user', 'assignedTo'])->findOrFail($id);

        if ($request->isMethod('POST')) {
            // 유효성 검사
            $validatedData = $request->validate([
                'status' => 'required|in:pending,in_progress,resolved,closed',
                'priority' => 'required|in:low,normal,high,urgent',
                'admin_reply' => 'nullable|string',
                'assigned_to' => 'nullable|exists:users,id',
                'internal_note' => 'nullable|string',
                'send_email' => 'boolean',
                'auto_close' => 'boolean',
            ]);

            // 이전 상태 저장
            $previousStatus = $support->status;
            $previousAssignee = $support->assigned_to;

            // 데이터 업데이트
            $updateData = [
                'status' => $validatedData['status'],
                'priority' => $validatedData['priority'],
                'assigned_to' => $validatedData['assigned_to'] ?? null,
                'internal_note' => $validatedData['internal_note'] ?? null,
            ];

            // 관리자 답변이 있는 경우
            if (!empty($validatedData['admin_reply'])) {
                $updateData['admin_reply'] = $validatedData['admin_reply'];
                $updateData['responded_at'] = now();
            }

            // 상태별 처리
            if ($validatedData['status'] === 'resolved' && $previousStatus !== 'resolved') {
                $updateData['resolved_at'] = now();
            }

            if ($validatedData['status'] === 'closed' && $previousStatus !== 'closed') {
                $updateData['closed_at'] = now();
            }

            if ($validatedData['status'] === 'in_progress' && $previousStatus === 'pending') {
                $updateData['started_at'] = now();
            }

            // 자동 종료 옵션
            if ($request->has('auto_close') && $validatedData['status'] === 'resolved') {
                $updateData['status'] = 'closed';
                $updateData['closed_at'] = now();
            }

            $support->update($updateData);

            // 이메일 알림 발송
            if ($request->has('send_email') && !empty($validatedData['admin_reply'])) {
                $this->sendNotificationEmail($support, $validatedData['admin_reply']);
            }

            // 활동 로그 기록
            $this->logActivity($support, $previousStatus, $previousAssignee, $request->user());

            $message = '지원 요청이 업데이트되었습니다.';
            if ($request->has('send_email') && !empty($validatedData['admin_reply'])) {
                $message .= ' 고객에게 이메일이 발송되었습니다.';
            }

            return redirect()->route('admin.cms.support.show', $id)
                ->with('success', $message);
        }

        // 담당자 목록
        $assignees = \App\Models\User::where('isAdmin', true)
            ->select('id', 'name', 'email')
            ->get();

        // 템플릿 답변 목록
        $templates = $this->getResponseTemplates();

        return view('jiny-site::admin.support.requests.edit', [
            'support' => $support,
            'assignees' => $assignees,
            'templates' => $templates,
        ]);
    }

    /**
     * 알림 이메일 발송
     */
    private function sendNotificationEmail($support, $adminReply)
    {
        try {
            $recipient = $support->email ?? ($support->user ? $support->user->email : null);

            if (!$recipient) {
                throw new \Exception('수신자 이메일 주소가 없습니다.');
            }

            // 이메일 발송
            \Mail::to($recipient)->send(new \Jiny\Site\Mail\SupportReplyMail($support, $adminReply));

            // 로그 기록
            \Log::info('Support notification email sent', [
                'support_id' => $support->id,
                'recipient' => $recipient
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send support notification email', [
                'support_id' => $support->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * 활동 로그 기록
     */
    private function logActivity($support, $previousStatus, $previousAssignee, $admin)
    {
        $activities = [];

        if ($support->status !== $previousStatus) {
            $activities[] = "상태를 '{$previousStatus}'에서 '{$support->status}'로 변경";
        }

        if ($support->assigned_to !== $previousAssignee) {
            $oldAssignee = $previousAssignee ? \App\Models\User::find($previousAssignee)?->name : '없음';
            $newAssignee = $support->assigned_to ? $support->assignedTo?->name : '없음';
            $activities[] = "담당자를 '{$oldAssignee}'에서 '{$newAssignee}'로 변경";
        }

        if ($support->admin_reply) {
            $activities[] = "관리자 답변 추가";
        }

        if (!empty($activities)) {
            \Log::info('Support activity', [
                'support_id' => $support->id,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'activities' => $activities,
                'timestamp' => now()
            ]);
        }
    }

    /**
     * 응답 템플릿 목록
     */
    private function getResponseTemplates()
    {
        return [
            'resolved' => [
                'title' => '해결완료 템플릿',
                'content' => "안녕하세요.\n\n문의해 주신 내용에 대해 검토를 완료하였습니다.\n\n[해결 방법 또는 답변 내용을 여기에 입력하세요]\n\n추가 문의사항이 있으시면 언제든지 연락 주시기 바랍니다.\n\n감사합니다."
            ],
            'investigating' => [
                'title' => '조사중 템플릿',
                'content' => "안녕하세요.\n\n문의해 주신 내용을 확인하였습니다.\n\n현재 관련 부서에서 해당 사항에 대해 조사 중이며, 조사가 완료되는 대로 빠른 시일 내에 답변 드리겠습니다.\n\n조금 더 시간이 필요할 수 있으니 양해 부탁드립니다.\n\n감사합니다."
            ],
            'more_info' => [
                'title' => '추가정보 요청 템플릿',
                'content' => "안녕하세요.\n\n문의해 주신 내용을 확인하였습니다.\n\n정확한 답변을 위해 추가 정보가 필요합니다:\n\n1. [필요한 정보 1]\n2. [필요한 정보 2]\n3. [필요한 정보 3]\n\n위 정보를 회신해 주시면 빠른 시일 내에 답변 드리겠습니다.\n\n감사합니다."
            ],
            'technical_support' => [
                'title' => '기술지원 템플릿',
                'content' => "안녕하세요.\n\n기술적인 문제에 대해 문의해 주셔서 감사합니다.\n\n[문제 해결 방법을 상세히 기술]\n\n위 방법으로도 문제가 해결되지 않으시면 다음 정보를 함께 보내주세요:\n- 사용 중인 브라우저 및 버전\n- 오류 메시지 스크린샷\n- 문제 발생 시점 및 재현 단계\n\n추가 도움이 필요하시면 언제든지 연락주세요.\n\n감사합니다."
            ]
        ];
    }
}