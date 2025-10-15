<?php

namespace Jiny\Site\Http\Controllers\Admin\Support\Requests;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 수정 컨트롤러
 */
class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $support = SiteSupport::with(['user', 'assignedTo'])->findOrFail($id);

        if ($request->isMethod('POST')) {
            return $this->update($request, $support);
        }

        // 담당자 목록
        $assignees = DB::table('users')
            ->where('isAdmin', true)
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

    private function update(Request $request, $support)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,normal,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_note' => 'nullable|string',
            'response_content' => 'nullable|string',
        ]);

        $oldStatus = $support->status;

        // 지원 요청 업데이트
        $support->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'admin_note' => $request->admin_note,
            'updated_at' => now(),
        ]);

        // 상태가 변경된 경우 해결 시간 기록
        if ($oldStatus !== $request->status && $request->status === 'resolved') {
            $support->update(['resolved_at' => now()]);
        }

        // 첫 응답 시간은 admin_reply에 내용이 생겼을 때 updated_at으로 기록됨 (별도 컬럼 없음)

        // 관리자 응답 내용이 있는 경우 처리
        if ($request->response_content) {
            // 여기에 응답 내용 저장 로직 추가 (답변 테이블 등)
            // 예: SupportResponse::create([...])
        }

        return redirect()
            ->route('admin.cms.support.requests.show', $support->id)
            ->with('success', '지원 요청이 성공적으로 업데이트되었습니다.');
    }

    private function getResponseTemplates()
    {
        return [
            'resolved' => [
                'title' => '해결완료 알림',
                'content' => "안녕하세요!\n\n문의해 주신 내용에 대해 검토를 완료하였습니다.\n\n[해결 방법 또는 답변 내용을 여기에 입력하세요]\n\n문제가 해결되었는지 확인 부탁드리며, 추가 문의사항이 있으시면 언제든지 연락 주시기 바랍니다.\n\n감사합니다."
            ],
            'investigating' => [
                'title' => '조사중 알림',
                'content' => "안녕하세요!\n\n문의해 주신 내용을 확인하였습니다.\n\n현재 관련 부서에서 해당 사항에 대해 조사 중이며, 조사가 완료되는 대로 빠른 시일 내에 답변 드리겠습니다.\n\n조금 더 시간이 필요할 수 있으니 양해 부탁드립니다.\n\n감사합니다."
            ],
            'more_info_needed' => [
                'title' => '추가정보 요청',
                'content' => "안녕하세요!\n\n문의해 주신 내용을 확인하였습니다.\n\n보다 정확한 답변을 드리기 위해 추가 정보가 필요합니다:\n\n[필요한 정보를 여기에 명시하세요]\n\n위 정보를 제공해 주시면 빠른 시일 내에 해결해 드리겠습니다.\n\n감사합니다."
            ],
        ];
    }
}