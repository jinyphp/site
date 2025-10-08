<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 업데이트 컨트롤러
 */
class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:site_language,code,' . $id,
            'name' => 'required|string|max:100',
            'native_name' => 'nullable|string|max:100',
            'enabled' => 'boolean',
        ]);

        $language->update($validated);

        return redirect()
            ->route('admin.site.languages.index')
            ->with('success', '언어가 성공적으로 업데이트되었습니다.');
    }
}
