<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 수정 폼 표시 컨트롤러
 */
class EditController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);
        $editConfig = $this->getConfig('edit', []);
        $updateConfig = $this->getConfig('update', []);

        return view($editConfig['view'] ?? 'jiny-site::admin.languages.edit', [
            'language' => $language,
            'config' => $editConfig,
            'validation' => $this->getValidationRules('update'),
            'routes' => [
                'update' => $updateConfig['route'] ?? 'admin.cms.language.update',
                'index' => $this->getConfig('index.route', 'admin.cms.language.index'),
                'show' => $this->getConfig('show.route', 'admin.cms.language.show'),
            ]
        ]);
    }
}
