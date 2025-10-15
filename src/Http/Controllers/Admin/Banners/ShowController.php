<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use App\Models\Banner;

/**
 * 베너 상세보기 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/banner/{id}') → ShowController::__invoke()
 */
class ShowController extends BaseController
{

    /**
     * 베너 상세보기
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $showConfig = $this->getConfig('show', []);

        return view($showConfig['view'] ?? 'jiny-site::admin.banners.show', [
            'banner' => $banner,
            'config' => $showConfig,
        ]);
    }
}