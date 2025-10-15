<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportReply;
use Jiny\Site\Models\SiteSupportEvaluation;

/**
 * 사용자가 직접 지원 요청을 종료하는 컨트롤러
 */
class CloseController extends Controller
{
    /**
     * 사용자가 직접 지원 요청 종료
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
            'rating' => 'nullable|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            $user = Auth::user();
        } catch (\Exception $e) {
            \Log::error('사용자 인증 오류: ' . $e->getMessage());
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        // 인증 확인
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        \Log::info('지원 요청 종료 시도', [
            'support_id' => $id,
            'user_id' => $user->id,
            'reason' => $request->reason,
            'rating' => $request->rating
        ]);

        try {
            // 본인의 지원 요청인지 확인
            $support = SiteSupport::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // 종료 가능한 상태인지 확인 (대기중, 처리중인 경우만)
            if (!in_array($support->status, ['pending', 'in_progress'])) {
                return redirect()->back()
                    ->with('error', '이미 완료되거나 종료된 지원 요청입니다.');
            }

            // 지원 요청 종료
            $support->update([
                'status' => 'closed',
                'closed_at' => now(),
                // closed_by 컬럼이 없어서 주석 처리
                // 'closed_by' => $user->id,
            ]);

            // 종료 이력을 답변으로 기록
            $closeReason = $request->reason ?: '고객이 직접 종료했습니다.';
            SiteSupportReply::createCustomerReply(
                $id,
                $user->id,
                "지원 요청을 종료합니다.\n\n사유: " . $closeReason
            );

            // 관리자용 내부 메모도 추가 (시스템 생성)
            SiteSupportReply::create([
                'support_id' => $id,
                'user_id' => 1, // 시스템 사용자 ID (또는 관리자 ID)
                'content' => "고객이 직접 지원 요청을 종료했습니다.\n종료 사유: " . $closeReason,
                'sender_type' => 'admin',
                'is_private' => true,
                'is_read' => false,
            ]);

            // 평점이 제공된 경우 자동으로 평가 생성
            if ($request->rating) {
                try {
                    // 답변을 작성한 관리자 중 첫 번째를 기본 평가 대상으로 설정
                    $adminReply = SiteSupportReply::where('support_id', $id)
                        ->where('sender_type', 'admin')
                        ->where('is_private', false)
                        ->whereNotNull('user_id')
                        ->first();

                    if ($adminReply && $adminReply->user_id) {
                        // 이미 평가가 있는지 확인
                        $existingEvaluation = SiteSupportEvaluation::where('support_id', $id)
                            ->where('evaluator_id', $user->id)
                            ->first();

                        if (!$existingEvaluation) {
                            SiteSupportEvaluation::create([
                                'support_id' => $id,
                                'evaluator_id' => $user->id,
                                'evaluated_admin_id' => $adminReply->user_id,
                                'rating' => $request->rating,
                                'comment' => $request->comment,
                                'is_anonymous' => false,
                            ]);

                            \Log::info('평가 자동 생성 완료', [
                                'support_id' => $id,
                                'evaluator_id' => $user->id,
                                'evaluated_admin_id' => $adminReply->user_id,
                                'rating' => $request->rating
                            ]);
                        }
                    } else {
                        \Log::warning('평가 대상 관리자를 찾을 수 없음', ['support_id' => $id]);
                    }
                } catch (\Exception $e) {
                    \Log::error('평가 생성 오류: ' . $e->getMessage(), [
                        'support_id' => $id,
                        'user_id' => $user->id,
                        'rating' => $request->rating
                    ]);
                }
            }

            $successMessage = '지원 요청이 종료되었습니다.';
            if ($request->rating) {
                $successMessage .= ' 평가도 함께 제출되었습니다. 소중한 의견 감사합니다.';
            } else {
                $successMessage .= ' 서비스에 대한 평가를 남겨주세요.';
            }

            return redirect()->route('help.support.show', $id)
                ->with('success', $successMessage)
                ->with('support_closed', true); // 종료 플래그 추가

        } catch (\Exception $e) {
            \Log::error('지원 요청 종료 오류: ' . $e->getMessage(), [
                'support_id' => $id,
                'user_id' => $user ? $user->id : null,
                'error' => $e->getTraceAsString()
            ]);

            $errorMessage = '요청 종료 중 오류가 발생했습니다. 다시 시도해주세요. (오류코드: ' . substr($e->getMessage(), 0, 50) . ')';

            return redirect()->back()
                ->with('error', $errorMessage);
        }
    }
}