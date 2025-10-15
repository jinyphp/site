<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 수정 저장 컨트롤러
 *
 * 진입 경로:
 * Route::put('admin/site/event/{id}') → UpdateController::__invoke()
 */
class UpdateController extends BaseController
{
    /**
     * 이벤트 수정 저장
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        // 이벤트 조회
        $event = SiteEvent::findOrFail($id);

        // 유효성 검사
        $validated = $this->validateRequest($request, $id);

        try {
            // 이벤트 업데이트
            $event->update($validated);

            // 성공 메시지
            session()->flash('success', '이벤트가 성공적으로 수정되었습니다.');

            // 성공 시 리다이렉트
            $successRoute = $this->getConfig('update.redirect.success', 'admin.site.event.index');
            return redirect()->route($successRoute);

        } catch (\Exception $e) {
            // 실패 메시지
            session()->flash('error', '이벤트 수정 중 오류가 발생했습니다: ' . $e->getMessage());

            // 실패 시 리다이렉트
            $errorRoute = $this->getConfig('update.redirect.error', 'admin.site.event.edit');
            return redirect()->route($errorRoute, $id)->withInput();
        }
    }

    /**
     * 요청 유효성 검사
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    protected function validateRequest(Request $request, $id)
    {
        $validation = $this->getConfig('update.validation', []);

        // unique 규칙에서 현재 ID 제외
        if (isset($validation['code'])) {
            $validation['code'] = str_replace('{id}', $id, $validation['code']);
        }

        $validated = $request->validate($validation);

        // HTML 폼에서 체크박스가 체크되지 않으면 값이 전송되지 않으므로 기본값 설정
        $validated['enable'] = $request->has('enable') ? true : false;
        $validated['allow_participation'] = $request->has('allow_participation') ? true : false;

        // 빈 값들을 null로 변환
        if (empty($validated['max_participants'])) {
            $validated['max_participants'] = null;
        }
        if (empty($validated['participation_start_date'])) {
            $validated['participation_start_date'] = null;
        }
        if (empty($validated['participation_end_date'])) {
            $validated['participation_end_date'] = null;
        }
        if (empty($validated['approval_type'])) {
            $validated['approval_type'] = 'auto';
        }

        return $validated;
    }
}