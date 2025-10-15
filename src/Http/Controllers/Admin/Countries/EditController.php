<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;

/**
 * 국가 수정 폼 표시 컨트롤러
 */
class EditController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        $country = SiteCountry::findOrFail($id);
        $editConfig = $this->getConfig('edit', []);
        $updateConfig = $this->getConfig('update', []);

        return view($editConfig['view'] ?? 'jiny-site::admin.countrys.edit', [
            'country' => $country,
            'config' => $editConfig,
            'validation' => $this->getValidationRules('update'),
            'routes' => [
                'update' => $updateConfig['route'] ?? 'admin.cms.country.update',
                'index' => $this->getConfig('index.route', 'admin.cms.country.index'),
                'show' => $this->getConfig('show.route', 'admin.cms.country.show'),
            ]
        ]);
    }
}
