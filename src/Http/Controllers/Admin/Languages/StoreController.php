<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 저장 컨트롤러
 */
class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:site_language,code',
            'name' => 'required|string|max:100',
            'native_name' => 'nullable|string|max:100',
            'enabled' => 'boolean',
        ]);

        $language = SiteLanguage::create($validated);

        return redirect()
            ->route('admin.site.languages.index')
            ->with('success', '언어가 성공적으로 생성되었습니다.');
    }
}
