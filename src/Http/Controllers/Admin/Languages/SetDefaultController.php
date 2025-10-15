<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;
use Illuminate\Support\Facades\DB;

/**
 * 기본 언어 설정 컨트롤러
 */
class SetDefaultController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                // 먼저 모든 언어의 기본 설정을 해제
                SiteLanguage::where('is_default', true)->update(['is_default' => false]);

                // 선택된 언어를 기본 언어로 설정
                $language = SiteLanguage::findOrFail($id);
                $language->is_default = true;
                $language->enable = true; // 기본 언어는 반드시 활성화
                $language->save();

                $this->language = $language;
            });

            return response()->json([
                'success' => true,
                'message' => $this->getMessage('actions.set_default', 'success'),
                'data' => [
                    'id' => $this->language->id,
                    'is_default' => true
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage('actions.set_default', 'error') . ': ' . $e->getMessage()
            ], 500);
        }
    }

    private $language;
}