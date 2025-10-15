<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteEvent;

/**
 * 이벤트 수정 폼 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/event/{id}/edit') → EditController::__invoke()
 */
class EditController extends BaseController
{
    /**
     * 이벤트 수정 폼 표시
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $id)
    {
        // 이벤트 조회
        $event = SiteEvent::findOrFail($id);

        $editConfig = $this->getConfig('edit', []);
        $fields = $this->getConfig('fields', []);

        return view($editConfig['view'] ?? 'jiny-site::admin.events.edit', [
            'event' => $event,
            'config' => $editConfig,
            'fields' => $fields,
        ]);
    }
}