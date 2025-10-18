<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use Jiny\Site\Models\Banner;

/**
 * 베너 삭제 처리 컨트롤러
 *
 * 진입 경로:
 * Route::delete('admin/site/banner/{id}') → DestroyController::__invoke()
 */
class DestroyController extends BaseController
{

    /**
     * 베너 삭제 처리
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->delete();

            $successRoute = $this->getRedirectRoute('destroy', 'success');
            $successMessage = $this->getMessage('destroy', 'success');

            return redirect()->route($successRoute)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            $errorMessage = $this->getMessage('destroy', 'error');

            return redirect()->back()
                ->with('error', $errorMessage);
        }
    }
}