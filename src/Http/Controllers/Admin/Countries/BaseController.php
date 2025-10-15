<?php

namespace Jiny\Site\Http\Controllers\Admin\Countries;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

/**
 * 국가 관리 기본 컨트롤러
 *
 * 모든 국가 관리 컨트롤러의 공통 기능을 제공합니다.
 * JSON 설정 파일을 읽어서 설정값을 로드합니다.
 */
class BaseController extends Controller
{
    /**
     * JSON 설정 데이터
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
     * JSON 설정 파일 로드
     *
     * @return void
     */
    protected function loadConfig()
    {
        $configPath = __DIR__ . '/Countries.json';

        if (File::exists($configPath)) {
            $jsonContent = File::get($configPath);
            $this->config = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // JSON 파싱 오류 시 기본값 사용
                $this->config = $this->getDefaultConfig();
            }
        } else {
            // 파일이 없을 경우 기본값 사용
            $this->config = $this->getDefaultConfig();
        }
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
                'name' => 'site_countries',
                'model' => 'Jiny\Site\Models\SiteCountry',
                'sort' => [
                    'column' => 'order',
                    'order' => 'asc'
                ]
            ],
            'index' => [
                'title' => '국가 관리',
                'subtitle' => '사이트에서 제공 가능한 국가 목록',
                'view' => 'jiny-site::admin.countries.index',
                'route' => 'admin.cms.country.index',
                'pagination' => [
                    'per_page' => 15
                ]
            ],
            'create' => [
                'title' => '국가 생성',
                'subtitle' => '새로운 국가 추가',
                'view' => 'jiny-site::admin.countries.create',
                'route' => 'admin.cms.country.create'
            ],
            'store' => [
                'route' => 'admin.cms.country.store',
                'redirect' => [
                    'success' => 'admin.cms.country.index',
                    'error' => 'admin.cms.country.create'
                ],
                'messages' => [
                    'success' => '국가가 성공적으로 생성되었습니다.',
                    'error' => '국가 생성에 실패했습니다.'
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
        return $this->getConfig("{$action}.redirect.{$type}", 'admin.cms.country.index');
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