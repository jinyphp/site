<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 수정 폼 표시 컨트롤러
 */
class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);

        return view('jiny-site::admin.languages.edit', [
            'language' => $language,
        ]);
    }
}
