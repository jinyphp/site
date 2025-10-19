<?php

namespace Jiny\Site\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Footer 서비스 Facade
 *
 * @method static array getAllFooters()
 * @method static array|null getFooterById(int $id)
 * @method static string getDefaultFooterPath()
 * @method static array|null getActiveFooter()
 * @method static bool isDuplicatePath(string $path, ?int $excludeIndex = null)
 * @method static bool addFooter(array $footerData)
 * @method static bool updateFooter(int $id, array $footerData)
 * @method static bool deleteFooter(int $id)
 * @method static bool setDefaultFooter(int $id)
 * @method static bool setActiveFooter(int $id)
 * @method static bool toggleFooterEnable(int $id)
 * @method static array getFooterStats()
 * @method static array|null getCompany()
 * @method static string getCopyright()
 * @method static string getLogo()
 * @method static array getSocial()
 * @method static array getMenuSections()
 * @method static array|null getMenuSection(string $section)
 * @method static array getFooterLinks()
 * @method static bool updateCompany(array $companyData)
 * @method static bool updateSocial(array $socialData)
 * @method static bool updateMenuSections(array $menuSections)
 * @method static bool updateCopyright(string $copyright)
 * @method static bool updateLogo(string $logo)
 *
 * @see \Jiny\Site\Services\FooterService
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
        return 'jiny.site.footer';
    }
}