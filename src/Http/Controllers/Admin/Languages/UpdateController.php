<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;
use Illuminate\Support\Facades\DB;

/**
 * 언어 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);

        $validated = $request->validate([
            'lang' => 'required|string|max:10|unique:site_language,lang,' . $id,
            'name' => 'required|string|max:100',
            'native_name' => 'nullable|string|max:100',
            'locale' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:255',
            'flag' => 'nullable|string|max:10',
            'manager' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'enable' => 'boolean',
            'is_default' => 'boolean',
        ]);

        // 기본값 설정
        $validated['enable'] = $request->has('enable');
        $validated['is_default'] = $request->has('is_default');
        $validated['order'] = $validated['order'] ?? 0;
        $validated['manager'] = $validated['manager'] ?? 'System';

        try {
            DB::transaction(function () use ($validated, $language, $id) {
                // 기본 언어로 설정하는 경우, 기존 기본 언어 해제
                if ($validated['is_default']) {
                    SiteLanguage::where('is_default', true)
                        ->where('id', '!=', $id)
                        ->update(['is_default' => false]);
                    // 기본 언어는 반드시 활성화
                    $validated['enable'] = true;
                }

                $language->update($validated);
                $this->language = $language;
            });

            return redirect()
                ->route('admin.cms.language.index')
                ->with('success', '언어가 성공적으로 업데이트되었습니다.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '언어 업데이트 중 오류가 발생했습니다: ' . $e->getMessage());
        }
    }

    private $language;
}
