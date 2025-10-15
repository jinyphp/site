<?php

namespace Jiny\Site\Http\Controllers\Admin\Contact\ContactType;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

/**
 * 상담 유형 관리 기본 컨트롤러
 *
 * 모든 상담 유형 관리 컨트롤러의 공통 기능을 제공합니다.
 */
class BaseController extends Controller
{
    /**
     * 설정 데이터
     *
     * @var array
     */
    protected $config = [];

    /**
     * 생성자
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * 설정 로드
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->config = $this->getDefaultConfig();
    }

    /**
     * 기본 설정값 반환
     *
     * @return array
     */
    protected function getDefaultConfig()
    {
        return [
            'table' => [
                'name' => 'site_contact_types',
                'model' => 'Jiny\Site\Models\SiteContactType',
                'sort' => [
                    'column' => 'sort_order',
                    'order' => 'asc'
                ]
            ],
            'index' => [
                'title' => '상담 유형 관리',
                'subtitle' => '상담 카테고리를 관리합니다',
                'view' => 'jiny-site::admin.contact.types',
                'route' => 'admin.cms.contact.types.index',
                'pagination' => [
                    'per_page' => 15
                ]
            ],
            'create' => [
                'title' => '상담 유형 생성',
                'subtitle' => '새로운 상담 유형 추가',
                'view' => 'jiny-site::admin.contact.types.create',
                'route' => 'admin.cms.contact.types.create'
            ],
            'store' => [
                'route' => 'admin.cms.contact.types.store',
                'redirect' => [
                    'success' => 'admin.cms.contact.types.index',
                    'error' => 'admin.cms.contact.types.create'
                ],
                'messages' => [
                    'success' => '상담 유형이 성공적으로 생성되었습니다.',
                    'error' => '상담 유형 생성에 실패했습니다.'
                ]
            ]
        ];
    }

    /**
     * 특정 섹션의 설정값 반환
     *
     * @param string $section
     * @param mixed $default
     * @return mixed
     */
    protected function getConfig(string $section, $default = null)
    {
        return data_get($this->config, $section, $default);
    }

    /**
     * 검증 규칙 반환
     *
     * @param string $action
     * @return array
     */
    protected function getValidationRules(string $action)
    {
        return $this->getConfig("{$action}.validation", []);
    }

    /**
     * 메시지 반환
     *
     * @param string $action
     * @param string $type
     * @return string
     */
    protected function getMessage(string $action, string $type)
    {
        return $this->getConfig("{$action}.messages.{$type}", '작업이 완료되었습니다.');
    }

    /**
     * 리다이렉트 라우트 반환
     *
     * @param string $action
     * @param string $type
     * @return string
     */
    protected function getRedirectRoute(string $action, string $type)
    {
        return $this->getConfig("{$action}.redirect.{$type}", 'admin.cms.contact.types.index');
    }

    /**
     * 기본값 반환
     *
     * @param string $action
     * @return array
     */
    protected function getDefaults(string $action)
    {
        return $this->getConfig("{$action}.defaults", []);
    }
}