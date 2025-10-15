<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteCountry;

/**
 * 국가 상세 표시 컨트롤러
 */
class ShowController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        $country = SiteCountry::findOrFail($id);
        $showConfig = $this->getConfig('show', []);

        // 관련 통계 정보 생성
        $stats = $this->generateStats($country);

        return view($showConfig['view'] ?? 'jiny-site::admin.countrys.show', [
            'country' => $country,
            'config' => $showConfig,
            'stats' => $stats,
            'routes' => [
                'edit' => $this->getConfig('edit.route', 'admin.cms.country.edit'),
                'index' => $this->getConfig('index.route', 'admin.cms.country.index'),
                'delete' => $this->getConfig('delete.route', 'admin.cms.country.destroy'),
            ]
        ]);
    }

    /**
     * 국가 관련 통계 생성
     */
    private function generateStats($country)
    {
        $totalLanguages = SiteCountry::count();
        $activeLanguages = SiteCountry::where('enable', true)->count();
        $isOnlyDefault = $country->is_default && SiteCountry::where('is_default', true)->count() === 1;
        $isOnlyActive = $country->enable && $activeLanguages === 1;

        return [
            'total_countrys' => $totalLanguages,
            'active_countrys' => $activeLanguages,
            'can_delete' => !$country->is_default && !$isOnlyActive,
            'can_disable' => !$country->is_default && !$isOnlyActive,
            'delete_warning' => $this->getDeleteWarning($country, $isOnlyDefault, $isOnlyActive),
        ];
    }

    /**
     * 삭제 경고 메시지 생성
     */
    private function getDeleteWarning($country, $isOnlyDefault, $isOnlyActive)
    {
        if ($country->is_default) {
            return '기본 국가는 삭제할 수 없습니다.';
        }

        if ($isOnlyActive) {
            return '최소 하나의 활성화된 국가가 있어야 합니다.';
        }

        return null;
    }
}
