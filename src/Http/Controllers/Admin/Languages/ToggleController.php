<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 활성화/비활성화 토글 컨트롤러
 */
class ToggleController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        try {
            $language = SiteLanguage::findOrFail($id);

            $enable = $request->boolean('enable');
            $language->enable = $enable;
            $language->save();

            $message = $enable
                ? "{$language->name} 언어가 활성화되었습니다."
                : "{$language->name} 언어가 비활성화되었습니다.";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $language->id,
                    'enable' => $language->enable
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage('actions.toggle', 'error') . ': ' . $e->getMessage()
            ], 500);
        }
    }
}