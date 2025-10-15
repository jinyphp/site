<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;

/**
 * 베너 생성 폼 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/banner/create') → CreateController::__invoke()
 */
class CreateController extends BaseController
{

    /**
     * 베너 생성 폼 표시
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $createConfig = $this->getConfig('create', []);

        return view($createConfig['view'] ?? 'jiny-site::admin.banners.create', [
            'config' => $createConfig,
        ]);
    }
}