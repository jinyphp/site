<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use App\Models\Banner;

/**
 * 베너 수정 폼 표시 컨트롤러
 *
 * 진입 경로:
 * Route::get('admin/site/banner/{id}/edit') → EditController::__invoke()
 */
class EditController extends BaseController
{

    /**
     * 베너 수정 폼 표시
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $editConfig = $this->getConfig('edit', []);

        return view($editConfig['view'] ?? 'jiny-site::admin.banners.edit', [
            'banner' => $banner,
            'config' => $editConfig,
        ]);
    }
}