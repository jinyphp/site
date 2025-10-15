<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 상세보기 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/event/{id}') → ShowController::__invoke()
 */
class ShowController extends BaseController
{
    /**
     * 이벤트 상세보기
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $id)
    {
        // 이벤트 조회
        $event = SiteEvent::findOrFail($id);

        $showConfig = $this->getConfig('show', []);
        $fields = $this->getConfig('fields', []);

        return view($showConfig['view'] ?? 'jiny-site::admin.events.show', [
            'event' => $event,
            'config' => $showConfig,
            'fields' => $fields,
        ]);
    }
}