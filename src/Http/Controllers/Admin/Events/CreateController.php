<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

/**
 * 이벤트 생성 폼 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/event/create') → CreateController::__invoke()
 */
class CreateController extends BaseController
{
    /**
     * 이벤트 생성 폼 표시
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $createConfig = $this->getConfig('create', []);
        $fields = $this->getConfig('fields', []);

        return view($createConfig['view'] ?? 'jiny-site::admin.events.create', [
            'config' => $createConfig,
            'fields' => $fields,
        ]);
    }
}