<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;
use Illuminate\Support\Facades\DB;

/**
 * 언어 삭제 컨트롤러
 */
class DeleteController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        try {
            $language = SiteLanguage::findOrFail($id);

            // 안전성 검사
            $this->validateDeletion($language);

            DB::transaction(function () use ($language) {
                $language->delete();
            });

            return redirect()
                ->route('admin.cms.language.index')
                ->with('success', "{$language->name} 언어가 성공적으로 삭제되었습니다.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '언어 삭제 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    /**
     * 삭제 가능 여부 검증
     *
     * @param SiteLanguage $language
     * @throws \Exception
     */
    private function validateDeletion($language)
    {
        // 기본 언어는 삭제할 수 없음
        if ($language->is_default) {
            throw new \Exception('기본 언어는 삭제할 수 없습니다.');
        }

        // 활성화된 언어가 모두 삭제되는지 확인
        $activeLanguages = SiteLanguage::where('enable', true)->count();
        if ($language->enable && $activeLanguages <= 1) {
            throw new \Exception('최소 하나의 활성화된 언어가 있어야 합니다.');
        }

        // 시스템에 언어가 하나만 남는 경우 방지
        $totalLanguages = SiteLanguage::count();
        if ($totalLanguages <= 1) {
            throw new \Exception('최소 하나의 언어가 있어야 합니다.');
        }
    }
}
