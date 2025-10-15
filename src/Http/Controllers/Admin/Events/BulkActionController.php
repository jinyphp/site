<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 대량 작업 컨트롤러
 *
 * 진입 경로:
 * Route::post('admin/site/event/bulk') → BulkActionController::__invoke()
 */
class BulkActionController extends BaseController
{
    /**
     * 대량 작업 실행
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // 유효성 검사
        $request->validate([
            'action' => 'required|in:delete,enable,disable,status',
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:site_event,id',
            'status' => 'required_if:action,status|in:active,inactive,planned,completed',
        ]);

        $action = $request->get('action');
        $ids = $request->get('ids');
        $status = $request->get('status');

        try {
            $count = $this->executeAction($action, $ids, $status);

            $message = $this->getActionMessage($action, $count, $status);

            // AJAX 요청인 경우 JSON 응답
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'count' => $count,
                ]);
            }

            // 일반 요청인 경우 리다이렉트
            session()->flash('success', $message);
            return redirect()->route('admin.site.event.index');

        } catch (\Exception $e) {
            $errorMessage = '대량 작업 중 오류가 발생했습니다: ' . $e->getMessage();

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

    /**
     * 액션 실행
     *
     * @param string $action
     * @param array $ids
     * @param string|null $status
     * @return int
     */
    protected function executeAction($action, $ids, $status = null)
    {
        $query = SiteEvent::whereIn('id', $ids);

        switch ($action) {
            case 'delete':
                return $query->delete();

            case 'enable':
                return $query->update(['enable' => true]);

            case 'disable':
                return $query->update(['enable' => false]);

            case 'status':
                return $query->update(['status' => $status]);

            default:
                throw new \InvalidArgumentException("지원하지 않는 액션입니다: {$action}");
        }
    }

    /**
     * 액션 성공 메시지 생성
     *
     * @param string $action
     * @param int $count
     * @param string|null $status
     * @return string
     */
    protected function getActionMessage($action, $count, $status = null)
    {
        switch ($action) {
            case 'delete':
                return "{$count}개의 이벤트가 삭제되었습니다.";

            case 'enable':
                return "{$count}개의 이벤트가 활성화되었습니다.";

            case 'disable':
                return "{$count}개의 이벤트가 비활성화되었습니다.";

            case 'status':
                $statusText = [
                    'active' => '활성',
                    'inactive' => '비활성',
                    'planned' => '계획중',
                    'completed' => '완료'
                ][$status] ?? $status;
                return "{$count}개의 이벤트 상태가 '{$statusText}'로 변경되었습니다.";

            default:
                return "{$count}개의 이벤트가 처리되었습니다.";
        }
    }
}