<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;

/**
 * 국가 활성화/비활성화 토글 컨트롤러
 */
class ToggleController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        try {
            $country = SiteCountry::findOrFail($id);

            $enable = $request->boolean('enable');
            $country->enable = $enable;
            $country->save();

            $message = $enable
                ? "{$country->name} 국가가 활성화되었습니다."
                : "{$country->name} 국가가 비활성화되었습니다.";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'id' => $country->id,
                    'enable' => $country->enable
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