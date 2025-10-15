<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportReply;
use Jiny\Site\Models\SiteSupportEvaluation;

/**
 * 사용자 지원 요청 상세 보기 컨트롤러
 */
class ShowController extends Controller
{
    /**
     * 지원 요청 상세 정보 표시
     */
    public function __invoke(Request $request, $id)
    {
        $user = Auth::user();

        // 인증 확인
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        try {
            // 본인의 지원 요청만 조회 가능
            $support = SiteSupport::where('id', $id)
                ->where('user_id', $user->id)
                ->with([
                    'assignedTo',
                    'activeAssignments.assignee',
                    // 존재하지 않는 컬럼들로 인한 관계는 주석 처리
                    // 'resolvedBy',
                    // 'closedBy',
                    // 'reopenedBy'
                ])
                ->firstOrFail();

            // 답변 이력 조회 (공개 답변만, 시간순 정렬)
            $replies = SiteSupportReply::where('support_id', $id)
                ->where('is_private', false) // 공개 답변만
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get();

            // 평가 여부 확인 (해결/종료된 경우만)
            $canEvaluate = in_array($support->status, ['resolved', 'closed']);
            $existingEvaluation = null;

            if ($canEvaluate) {
                $existingEvaluation = SiteSupportEvaluation::where('support_id', $id)
                    ->where('evaluator_id', $user->id)
                    ->first();
            }

            // 평가 가능한 관리자 목록 (답변을 작성한 관리자들)
            $evaluableAdmins = [];
            if ($canEvaluate && !$existingEvaluation) {
                $adminIds = $replies->where('sender_type', 'admin')
                    ->pluck('user_id')
                    ->unique();

                $evaluableAdmins = \App\Models\User::whereIn('id', $adminIds)
                    ->where('isAdmin', true)
                    ->select('id', 'name', 'email')
                    ->get();
            }

            return view('jiny-site::www.help.support.show', [
                'support' => $support,
                'replies' => $replies,
                'canEvaluate' => $canEvaluate,
                'existingEvaluation' => $existingEvaluation,
                'evaluableAdmins' => $evaluableAdmins,
            ]);

        } catch (\Exception $e) {
            return redirect('/help/support/my')
                ->with('error', '지원 요청을 찾을 수 없습니다.');
        }
    }
}