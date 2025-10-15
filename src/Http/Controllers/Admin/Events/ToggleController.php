<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 활성화 토글 컨트롤러
 *
 * 진입 경로:
 * Route::patch('admin/site/event/{id}/toggle') → ToggleController::__invoke()
 */
class ToggleController extends BaseController
{
    /**
     * 이벤트 활성화 상태 토글
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            // 이벤트 조회
            $event = SiteEvent::findOrFail($id);

            // 활성화 상태 토글
            $event->enable = !$event->enable;
            $event->save();

            $status = $event->enable ? '활성화' : '비활성화';
            $message = "이벤트 '{$event->title}'가 {$status}되었습니다.";

            // AJAX 요청인 경우 JSON 응답
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'enable' => $event->enable,
                ]);
            }

            // 일반 요청인 경우 리다이렉트
            session()->flash('success', $message);
            return redirect()->back();

        } catch (\Exception $e) {
            $errorMessage = '상태 변경 중 오류가 발생했습니다: ' . $e->getMessage();

            // AJAX 요청인 경우 JSON 응답
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }

            // 일반 요청인 경우 리다이렉트
            session()->flash('error', $errorMessage);
            return redirect()->back();
        }
    }
}