<?php

namespace Jiny\Site\Http\Controllers\Admin\Languages;

use Illuminate\Http\Request;
use Jiny\Site\Models\SiteLanguage;

/**
 * 언어 상세 표시 컨트롤러
 */
class ShowController extends BaseController
{
    public function __invoke(Request $request, $id)
    {
        $language = SiteLanguage::findOrFail($id);
        $showConfig = $this->getConfig('show', []);

        // 관련 통계 정보 생성
        $stats = $this->generateStats($language);

        return view($showConfig['view'] ?? 'jiny-site::admin.languages.show', [
            'language' => $language,
            'config' => $showConfig,
            'stats' => $stats,
            'routes' => [
                'edit' => $this->getConfig('edit.route', 'admin.cms.language.edit'),
                'index' => $this->getConfig('index.route', 'admin.cms.language.index'),
                'delete' => $this->getConfig('delete.route', 'admin.cms.language.destroy'),
            ]
        ]);
    }

    /**
     * 언어 관련 통계 생성
     */
    private function generateStats($language)
    {
        $totalLanguages = SiteLanguage::count();
        $activeLanguages = SiteLanguage::where('enable', true)->count();
        $isOnlyDefault = $language->is_default && SiteLanguage::where('is_default', true)->count() === 1;
        $isOnlyActive = $language->enable && $activeLanguages === 1;

        return [
            'total_languages' => $totalLanguages,
            'active_languages' => $activeLanguages,
            'can_delete' => !$language->is_default && !$isOnlyActive,
            'can_disable' => !$language->is_default && !$isOnlyActive,
            'delete_warning' => $this->getDeleteWarning($language, $isOnlyDefault, $isOnlyActive),
        ];
    }

    /**
     * 삭제 경고 메시지 생성
     */
    private function getDeleteWarning($language, $isOnlyDefault, $isOnlyActive)
    {
        if ($language->is_default) {
            return '기본 언어는 삭제할 수 없습니다.';
        }

        if ($isOnlyActive) {
            return '최소 하나의 활성화된 언어가 있어야 합니다.';
        }

        return null;
    }
}
