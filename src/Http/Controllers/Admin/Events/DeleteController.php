<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 삭제 컨트롤러
 *
 * 진입 경로:
 * Route::delete('admin/site/event/{id}') → DeleteController::__invoke()
 */
class DeleteController extends BaseController
{
    /**
     * 이벤트 삭제
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            // 이벤트 조회 및 삭제
            $event = SiteEvent::findOrFail($id);
            $eventTitle = $event->title;

            $event->delete();

            // 성공 메시지
            session()->flash('success', "이벤트 '{$eventTitle}'가 성공적으로 삭제되었습니다.");

            // 성공 시 리다이렉트
            $successRoute = $this->getConfig('delete.redirect.success', 'admin.site.event.index');
            return redirect()->route($successRoute);

        } catch (\Exception $e) {
            // 실패 메시지
            session()->flash('error', '이벤트 삭제 중 오류가 발생했습니다: ' . $e->getMessage());

            // 실패 시 원래 페이지로 리다이렉트
            return redirect()->back();
        }
    }
}