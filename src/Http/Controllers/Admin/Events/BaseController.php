<?php

namespace Jiny\Site\Http\Controllers\Admin\Events;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

/**
 * 이벤트 관리 기본 컨트롤러
 *
 * 모든 이벤트 관리 컨트롤러의 공통 기능을 제공합니다.
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
        $configPath = __DIR__ . '/Events.json';

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
     * 설정값 반환
     *
     * @param string $key 설정 키 (예: 'index.title')
     * @param mixed $default 기본값
     * @return mixed
     */
    protected function getConfig($key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }

        $keys = explode('.', $key);
        $config = $this->config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                return $default;
            }
            $config = $config[$k];
        }

        return $config;
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
                'name' => 'site_event',
                'model' => 'Jiny\\Site\\Models\\SiteEvent',
                'sort' => ['column' => 'created_at', 'order' => 'desc']
            ],
            'index' => [
                'title' => 'Event 관리',
                'subtitle' => '사이트 이벤트를 관리합니다',
                'view' => 'jiny-site::admin.events.index'
            ]
        ];
    }

    /**
     * 모델 클래스 반환
     *
     * @return string
     */
    protected function getModelClass()
    {
        return $this->getConfig('table.model', 'Jiny\\Site\\Models\\SiteEvent');
    }

    /**
     * 테이블명 반환
     *
     * @return string
     */
    protected function getTableName()
    {
        return $this->getConfig('table.name', 'site_event');
    }

    /**
     * 정렬 조건 반환
     *
     * @return array
     */
    protected function getSortConfig()
    {
        return $this->getConfig('table.sort', ['column' => 'created_at', 'order' => 'desc']);
    }
}