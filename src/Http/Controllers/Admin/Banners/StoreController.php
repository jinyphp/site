<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Http\Request;
use Jiny\Site\Models\Banner;

/**
 * 베너 생성 처리 컨트롤러
 *
 * 진입 경로:
 * Route::post('admin/site/banner') → StoreController::__invoke()
 */
class StoreController extends BaseController
{

    /**
     * 베너 생성 처리
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        // JSON 설정에서 검증 규칙 가져오기
        $rules = $this->getConfig('create.validation', [
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
            $data = $request->all();
            $data['display_order'] = Banner::max('display_order') + 1;

            Banner::create($data);

            $successRoute = $this->getRedirectRoute('store', 'success');
            $successMessage = $this->getMessage('store', 'success');

            return redirect()->route($successRoute)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            $errorRoute = $this->getRedirectRoute('store', 'error');
            $errorMessage = $this->getMessage('store', 'error');

            return redirect()->route($errorRoute)
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
}