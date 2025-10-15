<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;

/**
 * 국가 생성 폼 표시 컨트롤러
 */
class CreateController extends BaseController
{
    public function __invoke(Request $request)
    {
        $createConfig = $this->getConfig('create', []);
        $storeConfig = $this->getConfig('store', []);

        return view($createConfig['view'] ?? 'jiny-site::admin.countries.create', [
            'config' => $createConfig,
            'validation' => $this->getValidationRules('store'),
            'defaults' => $this->getDefaults('store'),
            'routes' => [
                'store' => $storeConfig['route'] ?? 'admin.cms.country.store',
                'index' => $this->getConfig('index.route', 'admin.cms.country.index'),
            ]
        ]);
    }
}
