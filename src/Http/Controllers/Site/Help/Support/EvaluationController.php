<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportEvaluation;
use Jiny\Site\Models\SiteSupportReply;

/**
 * 사용자 평가 제출 컨트롤러
 */
class EvaluationController extends Controller
{
    /**
     * 평가 제출
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'evaluated_admin_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:2000',
            'is_anonymous' => 'boolean'
        ]);

        $user = Auth::user();

        // 인증 확인
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        try {
            // 본인의 지원 요청인지 확인
            $support = SiteSupport::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // 해결/종료된 지원 요청만 평가 가능
            if (!in_array($support->status, ['resolved', 'closed'])) {
                return redirect()->back()
                    ->with('error', '해결 완료되거나 종료된 지원 요청만 평가할 수 있습니다.');
            }

            // 이미 평가했는지 확인
            $existingEvaluation = SiteSupportEvaluation::where('support_id', $id)
                ->where('evaluator_id', $user->id)
                ->first();

            if ($existingEvaluation) {
                return redirect()->back()
                    ->with('error', '이미 이 지원 요청에 대해 평가를 작성했습니다.');
            }

            // 평가받을 관리자가 실제로 답변했는지 확인
            $evaluatedAdminId = $request->evaluated_admin_id;
            $hasReplied = SiteSupportReply::where('support_id', $id)
                ->where('user_id', $evaluatedAdminId)
                ->where('sender_type', 'admin')
                ->exists();

            if (!$hasReplied) {
                return redirect()->back()
                    ->with('error', '이 지원 요청에 답변하지 않은 관리자는 평가할 수 없습니다.');
            }

            // 평가 생성
            SiteSupportEvaluation::createEvaluation(
                $id,
                $user->id,
                $evaluatedAdminId,
                $request->rating,
                $request->comment,
                null, // 세부 기준 점수는 웹에서는 사용하지 않음
                $request->boolean('is_anonymous', false)
            );

            return redirect()->route('help.support.show', $id)
                ->with('success', '평가가 성공적으로 제출되었습니다. 소중한 의견 감사합니다.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '평가 제출 중 오류가 발생했습니다. 다시 시도해주세요.');
        }
    }
}