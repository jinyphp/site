<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jiny\Site\Models\SiteSupport;
use Jiny\Site\Models\SiteSupportReply;

/**
 * 고객 추가 문의 처리 컨트롤러
 */
class CustomerReplyController extends Controller
{
    /**
     * 고객 추가 문의 제출
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:10240', // 10MB
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

            // 답변 가능한 상태인지 확인 (종료되지 않은 경우만)
            if (!in_array($support->status, ['pending', 'in_progress'])) {
                return redirect()->back()
                    ->with('error', '이미 완료되거나 종료된 지원 요청에는 추가 문의를 할 수 없습니다.');
            }

            // 첨부파일 처리
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('support/attachments', $filename, 'public');

                        $attachments[] = [
                            'name' => $file->getClientOriginalName(),
                            'path' => $path,
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType(),
                        ];
                    } catch (\Exception $e) {
                        \Log::error('첨부파일 업로드 오류: ' . $e->getMessage());
                        // 첨부파일 업로드 실패해도 답변은 저장
                    }
                }
            }

            // 고객 답변 생성
            $reply = SiteSupportReply::createCustomerReply(
                $id,
                $user->id,
                $request->content,
                $attachments
            );

            // 지원 요청 상태를 '처리중'으로 변경 (고객이 추가 문의했으므로)
            if ($support->status === 'pending') {
                $support->update(['status' => 'in_progress']);
            }

            \Log::info('고객 추가 문의 저장 완료', [
                'support_id' => $id,
                'user_id' => $user->id,
                'reply_id' => $reply->id,
                'attachments_count' => count($attachments)
            ]);

            return redirect()->route('help.support.show', $id)
                ->with('success', '추가 문의가 성공적으로 전송되었습니다. 관리자 확인 후 답변드리겠습니다.')
                ->with('reply_added', true);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('/help/support/my')
                ->with('error', '지원 요청을 찾을 수 없습니다.');
        } catch (\Exception $e) {
            \Log::error('고객 추가 문의 저장 오류: ' . $e->getMessage(), [
                'support_id' => $id,
                'user_id' => $user ? $user->id : null,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', '문의 전송 중 오류가 발생했습니다. 다시 시도해주세요.')
                ->withInput();
        }
    }
}