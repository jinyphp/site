<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 삭제 컨트롤러
 */
class DeleteController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);
        $language->delete();

        return redirect()
            ->route('admin.site.languages.index')
            ->with('success', '언어가 성공적으로 삭제되었습니다.');
    }
}
