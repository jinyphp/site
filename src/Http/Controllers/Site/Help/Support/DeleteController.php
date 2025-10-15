<?php

namespace Jiny\Site\Http\Controllers\Site\Help\Support;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jiny\Site\Models\SiteSupport;

/**
 * 지원 요청 삭제 컨트롤러 (Single Action)
 *
 * 메소드 호출 트리:
 * __invoke(Request $request, $id)
 * ├── Auth::user() - 현재 사용자 정보 조회
 * ├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
 * ├── SiteSupport::where() - 해당 ID와 사용자 ID로 지원 요청 조회
 * ├── isDeletable() - 삭제 가능 상태 확인
 * ├── $support->delete() - 지원 요청 삭제 실행
 * └── 응답 형태에 따른 결과 반환
 *     ├── JSON 응답 (AJAX 요청)
 *     └── 리다이렉트 응답 (일반 요청)
 *
 * 진입 경로:
 * Route::delete('/help/support/{id}') → DeleteController::__invoke()
 * Route::post('/help/support/{id}/delete') → DeleteController::__invoke()
 *
 * 주요 기능:
 * - 지원 요청 삭제 처리
 * - 삭제 권한 확인 (본인 요청 + 삭제 가능 상태)
 * - JSON 및 HTML 응답 지원 (AJAX/일반 요청)
 * - 에러 처리 및 사용자 피드백
 *
 * 비즈니스 규칙:
 * - 본인이 작성한 요청만 삭제 가능
 * - pending 상태의 요청만 삭제 가능
 * - 처리중(in_progress) 이상의 상태는 삭제 불가
 *
 * 응답 형태:
 * - AJAX 요청: JSON 응답 (success/error 상태)
 * - 일반 요청: 리다이렉트 응답 (플래시 메시지 포함)
 *
 * 의존성:
 * - SiteSupport 모델
 * - Laravel Auth 시스템
 */
class DeleteController extends Controller
{
    /**
     * 생성자
     *
     * Single Action Controller이므로 미들웨어는 라우트에서 적용됩니다.
     *
     * @return void
     */
    public function __construct()
    {
        // Single action controller - middleware should be applied in routes
    }

    /**
     * Single Action Controller 메인 메소드 - 지원 요청 삭제
     *
     * 지원 요청의 삭제 권한을 확인하고 삭제를 실행합니다.
     * 본인이 작성한 요청이며 삭제 가능한 상태(pending)인 경우에만 삭제를 허용합니다.
     * AJAX 요청과 일반 요청 모두를 지원하여 적절한 응답을 반환합니다.
     *
     * @param Request $request HTTP 요청 객체
     * @param int $id 삭제할 지원 요청 ID
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        $user = Auth::user();

        // 인증 확인 - 로그인하지 않은 경우 로그인 페이지로 리다이렉트
        if (!$user) {
            return redirect('/login')->with('message', '로그인이 필요합니다.');
        }

        // 지원 요청 조회 - 해당 ID이면서 현재 사용자가 작성한 요청만 조회
        // firstOrFail() 사용으로 해당하는 요청이 없으면 404 예외 발생
        $support = SiteSupport::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // 삭제 가능 상태 확인 - pending 상태만 삭제 가능
        if (!$support->isDeletable()) {
            // AJAX 요청인 경우 JSON 에러 응답
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '이미 처리 중이거나 완료된 요청은 삭제할 수 없습니다.'
                ], 400);
            }

            // 일반 요청인 경우 리다이렉트 에러 응답
            return redirect()->route('help.support.my')
                ->with('error', '이미 처리 중이거나 완료된 요청은 삭제할 수 없습니다.');
        }

        try {
            // 지원 요청 삭제 실행
            $support->delete();

            // 성공 응답 - 요청 형태에 따라 JSON 또는 리다이렉트
            if ($request->expectsJson()) {
                // AJAX 요청: JSON 성공 응답
                return response()->json([
                    'success' => true,
                    'message' => '지원 요청이 성공적으로 삭제되었습니다.'
                ]);
            }

            // 일반 요청: 내 지원 요청 목록으로 리다이렉트
            return redirect()->route('help.support.my')
                ->with('success', '지원 요청이 성공적으로 삭제되었습니다.');

        } catch (\Exception $e) {
            // 예외 발생 시 에러 처리 - 요청 형태에 따라 JSON 또는 리다이렉트
            if ($request->expectsJson()) {
                // AJAX 요청: JSON 에러 응답
                return response()->json([
                    'success' => false,
                    'message' => '삭제 중 오류가 발생했습니다. 다시 시도해 주세요.'
                ], 500);
            }

            // 일반 요청: 이전 페이지로 돌아가기
            return back()->with('error', '삭제 중 오류가 발생했습니다. 다시 시도해 주세요.');
        }
    }
}