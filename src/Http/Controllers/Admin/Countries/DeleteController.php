<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;
use Illuminate\Support\Facades\DB;

/**
 * 국가 삭제 컨트롤러
 */
class DeleteController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        try {
            $country = SiteCountry::findOrFail($id);

            // 안전성 검사
            $this->validateDeletion($country);

            DB::transaction(function () use ($country) {
                $country->delete();
            });

            return redirect()
                ->route('admin.cms.country.index')
                ->with('success', "{$country->name} 국가가 성공적으로 삭제되었습니다.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '국가 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 삭제 가능 여부 검증
     *
     * @param SiteLanguage $country
     * @throws \Exception
     */
    private function validateDeletion($country)
    {
        // 기본 국가는 삭제할 수 없음
        if ($country->is_default) {
            throw new \Exception('기본 국가는 삭제할 수 없습니다.');
        }

        // 활성화된 국가가 모두 삭제되는지 확인
        $activeLanguages = SiteCountry::where('enable', true)->count();
        if ($country->enable && $activeLanguages <= 1) {
            throw new \Exception('최소 하나의 활성화된 국가가 있어야 합니다.');
        }

        // 시스템에 국가가 하나만 남는 경우 방지
        $totalLanguages = SiteCountry::count();
        if ($totalLanguages <= 1) {
            throw new \Exception('최소 하나의 국가가 있어야 합니다.');
        }
    }
}
