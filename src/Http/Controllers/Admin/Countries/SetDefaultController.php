<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;
use Illuminate\Support\Facades\DB;

/**
 * 기본 국가 설정 컨트롤러
 */
class SetDefaultController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                // 먼저 모든 국가의 기본 설정을 해제
                SiteCountry::where('is_default', true)->update(['is_default' => false]);

                // 선택된 국가를 기본 국가로 설정
                $country = SiteCountry::findOrFail($id);
                $country->is_default = true;
                $country->enable = true; // 기본 국가는 반드시 활성화
                $country->save();

                $this->country = $country;
            });

            return response()->json([
                'success' => true,
                'message' => $this->getMessage('actions.set_default', 'success'),
                'data' => [
                    'id' => $this->country->id,
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

    private $country;
}