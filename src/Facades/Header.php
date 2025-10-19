<?php

namespace Jiny\Site\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Header Facade
 *
 * @method static array getAllHeaders()
 * @method static array getHeaderConfig()
 * @method static array getHeaderInfo()
 * @method static array|null getHeaderById(int $id)
 * @method static bool isDuplicateKey(string $key, ?int $excludeIndex = null)
 * @method static bool addHeader(array $data)
 * @method static bool updateHeader(int $id, array $data)
 * @method static bool deleteHeader(int $id)
 * @method static bool updateConfig(array $config)
 * @method static array getAll()
 * @method static array getConfig()
 * @method static array getInfo()
 * @method static array|null getById(int $id)
 * @method static array|null getByKey(string $key)
 * @method static string getLogo()
 * @method static string getBrandName()
 * @method static string getBrandTagline()
 * @method static array getNavigation()
 * @method static array getPrimaryNavigation()
 * @method static array getSecondaryNavigation()
 * @method static array getSettings()
 * @method static bool add(array $data)
 * @method static bool update(int $id, array $data)
 * @method static bool delete(int $id)
 * @method static array getFullJsonData()
 * @method static bool saveJsonData(array $data)
 * @method static array|null getDefaultHeader()
 * @method static bool setDefaultHeader(int $id)
 * @method static array getTemplateStats()
 * @method static string getDefaultHeaderPath()
 * @method static array getEnabledHeaders()
 * @method static array getActiveHeaders()
 * @method static bool setActiveHeader(int $id)
 * @method static bool toggleHeaderEnable(int $id)
 * @method static string getBrand()
 * @method static string getSearch()
 * @method static bool updateLogo(string $logo)
 * @method static bool updateBrand(string $brand)
 * @method static bool updateSearch(string $search)
 *
 * @see \Jiny\Site\Services\HeaderService
 */
class Header extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jiny.site.header';
    }
}