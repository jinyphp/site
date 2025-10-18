<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use Jiny\Site\Models\Banner;

/**
 * 베너 업데이트 처리 컨트롤러
 *
 * 진입 경로:
 * Route::put('admin/site/banner/{id}') → UpdateController::__invoke()
 */
class UpdateController extends BaseController
{

    /**
     * 베너 업데이트 처리
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        // JSON 설정에서 검증 규칙 가져오기
        $rules = $this->getConfig('update.validation', [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,danger,primary,secondary',
            'link_url' => 'nullable|url',
            'link_text' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'background_color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'cookie_days' => 'required|integer|min:1|max:365',
        ]);

        $request->validate($rules);

        try {
            $banner->update($request->all());

            $successRoute = $this->getRedirectRoute('update', 'success');
            $successMessage = $this->getMessage('update', 'success');

            return redirect()->route($successRoute)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            $errorRoute = $this->getRedirectRoute('update', 'error');
            $errorMessage = $this->getMessage('update', 'error');

            return redirect()->route($errorRoute, ['id' => $id])
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
}