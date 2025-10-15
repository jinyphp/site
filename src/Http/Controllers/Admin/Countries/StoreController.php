<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;
use Illuminate\Support\Facades\DB;

/**
 * 국가 저장 컨트롤러
 */
class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        // JSON 설정에서 validation 규칙 가져오기
        $validationRules = $this->getValidationRules('store');
        $validated = $request->validate($validationRules);

        // JSON 설정에서 기본값 가져오기
        $defaults = $this->getDefaults('store');

        // 기본값 설정
        $validated['enable'] = $request->has('enable');
        $validated['is_default'] = $request->has('is_default');
        $validated['order'] = $validated['order'] ?? ($defaults['order'] ?? 0);
        $validated['manager'] = $validated['manager'] ?? 'System';

        try {
            DB::transaction(function () use ($validated) {
                // 기본 국가로 설정하는 경우, 기존 기본 국가 해제
                if ($validated['is_default']) {
                    SiteCountry::where('is_default', true)->update(['is_default' => false]);
                    // 기본 국가는 반드시 활성화
                    $validated['enable'] = true;
                }

                $this->country = SiteCountry::create($validated);
            });

            return redirect()
                ->route($this->getRedirectRoute('store', 'success'))
                ->with('success', $this->getMessage('store', 'success'));

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $this->getMessage('store', 'error') . ': ' . $e->getMessage());
        }
    }

    private $country;
}
