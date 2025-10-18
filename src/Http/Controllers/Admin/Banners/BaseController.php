<?php

namespace Jiny\Site\Http\Controllers\Admin\Banners;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

/**
 * 베너 관리 기본 컨트롤러
 *
 * 모든 베너 관리 컨트롤러의 공통 기능을 제공합니다.
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
        $configPath = __DIR__ . '/Banners.json';

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
                'name' => 'banners',
                'model' => 'Jiny\Site\Models\Banner',
                'sort' => [
                    'column' => 'display_order',
                    'order' => 'asc'
                ]
            ],
            'index' => [
                'title' => '베너 관리',
                'subtitle' => '사이트 상단 베너를 관리합니다.',
                'view' => 'jiny-site::admin.banners.index',
                'route' => 'admin.site.banner.index',
                'pagination' => [
                    'per_page' => 15
                ]
            ],
            'create' => [
                'title' => '베너 추가',
                'subtitle' => '새로운 베너를 추가합니다.',
                'view' => 'jiny-site::admin.banners.create',
                'route' => 'admin.site.banner.create'
            ],
            'edit' => [
                'title' => '베너 수정',
                'subtitle' => '베너 정보를 수정합니다.',
                'view' => 'jiny-site::admin.banners.edit',
                'route' => 'admin.site.banner.edit'
            ],
            'show' => [
                'title' => '베너 상세보기',
                'subtitle' => '베너 정보를 확인합니다.',
                'view' => 'jiny-site::admin.banners.show',
                'route' => 'admin.site.banner.show'
            ],
            'store' => [
                'route' => 'admin.site.banner.store',
                'redirect' => [
                    'success' => 'admin.site.banner.index',
                    'error' => 'admin.site.banner.create'
                ],
                'messages' => [
                    'success' => '베너가 성공적으로 생성되었습니다.',
                    'error' => '베너 생성에 실패했습니다.'
                ]
            ],
            'update' => [
                'route' => 'admin.site.banner.update',
                'redirect' => [
                    'success' => 'admin.site.banner.index',
                    'error' => 'admin.site.banner.edit'
                ],
                'messages' => [
                    'success' => '베너가 성공적으로 수정되었습니다.',
                    'error' => '베너 수정에 실패했습니다.'
                ]
            ],
            'destroy' => [
                'redirect' => [
                    'success' => 'admin.site.banner.index'
                ],
                'messages' => [
                    'success' => '베너가 성공적으로 삭제되었습니다.',
                    'error' => '베너 삭제에 실패했습니다.'
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
        return $this->getConfig("{$action}.redirect.{$type}", 'admin.site.banner.index');
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