<?php

namespace Jiny\Site\Services;

use Illuminate\Support\Facades\DB;

/**
 * 사이트 서비스
 */
class SiteService
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Load site configuration from JSON file
     */
    protected function loadConfig()
    {
        $configPath = __DIR__ . '/../../config/site.json';

        if (file_exists($configPath)) {
            $json = file_get_contents($configPath);
            $this->config = json_decode($json, true) ?: [];
        } else {
            $this->config = [];
        }
    }

    /**
     * Get configuration value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get phone number
     *
     * @return string
     */
    public function phone()
    {
        return $this->get('phone', '');
    }

    /**
     * Get business hours
     *
     * @return string
     */
    public function businessHours()
    {
        return $this->get('business_hours', '');
    }

    /**
     * Get brand name
     *
     * @return string
     */
    public function brand()
    {
        return $this->get('brand', '');
    }

    /**
     * Get logo path
     *
     * @return string
     */
    public function logo()
    {
        return $this->get('logo', '');
    }

    /**
     * Get navigation menu data
     *
     * @return array
     */
    public function navigation()
    {
        $navigationPath = __DIR__ . '/../../resources/menu/navigation.json';

        if (file_exists($navigationPath)) {
            $json = file_get_contents($navigationPath);
            return json_decode($json, true) ?: [];
        }

        return [];
    }

    /**
     * Get main menu items
     *
     * @return array
     */
    public function mainMenu()
    {
        $navigation = $this->navigation();
        return $navigation['main_menu'] ?? [];
    }

    /**
     * Get classic navigation menu data
     *
     * @return array
     */
    public function classicNavigation()
    {
        $classicPath = __DIR__ . '/../../resources/menu/classic.json';

        if (file_exists($classicPath)) {
            $json = file_get_contents($classicPath);
            return json_decode($json, true) ?: [];
        }

        return [];
    }

    /**
     * Get classic main menu items
     *
     * @return array
     */
    public function classicMainMenu()
    {
        $navigation = $this->classicNavigation();
        return $navigation['main_menu'] ?? [];
    }

    /**
     * Get menu data by name
     *
     * @param string $menuName
     * @return array
     */
    public function menu($menuName)
    {
        // 1순위: 프로젝트 resources/menu 경로에서 찾기
        $projectMenuPath = resource_path("menu/{$menuName}.json");
        if (file_exists($projectMenuPath)) {
            $json = file_get_contents($projectMenuPath);
            return json_decode($json, true) ?: [];
        }

        // 2순위: 패키지 resources/menu 경로에서 찾기 (기본값)
        $packageMenuPath = __DIR__ . "/../../resources/menu/{$menuName}.json";
        if (file_exists($packageMenuPath)) {
            $json = file_get_contents($packageMenuPath);
            return json_decode($json, true) ?: [];
        }

        return [];
    }

    /**
     * Get main menu items by menu name
     *
     * @param string $menuName
     * @return array
     */
    public function menuItems($menuName)
    {
        $menu = $this->menu($menuName);
        return $menu['main_menu'] ?? [];
    }

    /**
     * Get all configuration
     *
     * @return array
     */
    public function all()
    {
        return $this->config;
    }

    /**
     * Magic method to get configuration values
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * 사이트 설정 조회 (기존 메서드 유지)
     *
     * @return array
     */
    public function getSettings()
    {
        return config('site');
    }

    /**
     * 사이트 정보 조회 (기존 메서드 유지)
     *
     * @return object|null
     */
    public function getInfo()
    {
        return DB::table('site_env')->first();
    }

    /**
     * 사이트 정보 업데이트 (기존 메서드 유지)
     *
     * @param array $data
     * @return bool
     */
    public function updateInfo(array $data)
    {
        return DB::table('site_env')
            ->where('id', 1)
            ->update($data);
    }
}
