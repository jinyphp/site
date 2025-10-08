<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 상세 표시 컨트롤러
 */
class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);

        return view('jiny-site::admin.languages.show', [
            'language' => $language,
        ]);
    }
}
