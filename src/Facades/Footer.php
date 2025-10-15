<?php

namespace Jiny\Site\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Footer Facade
 *
 * @method static array getAll()
 * @method static array getConfig()
 * @method static array getInfo()
 * @method static array|null getById(int $id)
 * @method static array|null getByKey(string $key)
 * @method static array getLinks()
 * @method static string getCopyright()
 * @method static string getLogo()
 * @method static array getCompany()
 * @method static array getSocial()
 * @method static array getMenuSections()
 * @method static array getMenuSection(string $key)
 * @method static bool isDuplicateKey(string $key, ?int $excludeIndex = null)
 * @method static bool add(array $data)
 * @method static bool update(int $id, array $data)
 * @method static bool delete(int $id)
 * @method static bool updateConfig(array $config)
 */
class Footer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'footer-service';
    }
}